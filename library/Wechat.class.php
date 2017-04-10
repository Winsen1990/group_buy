<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/7/3
 * Time: 下午5:33
 */
class Wechat {
    private static $self;
    private $http;
    private $appid;
    private $appsecret;
    private $wechat_account;
    private $token;
    private $access_token;
    private $jsapi_ticket;
    private $config_file;
    private $config;
    private $mode;

    /**
     * Wechat constructor.
     * @param string $appid 公众号appid
     * @param string $appsecret 公众号appsecret
     * @param string $wechat_account 公众号原始ID
     * @param string $token 微信开发者配置的token
     * @param string $config_file 配置文件名
     * @throws WechatException
     */
    private function __construct($appid, $appsecret, $wechat_account, $token, $config_file) {
        $this->http = new Http();

        $this->appid = $appid;
        $this->appsecret = $appsecret;
        $this->wechat_account = $wechat_account;
        $this->config_file = $config_file;
        $this->token = $token;
        $this->mode = 'default';

        if(!file_exists($config_file)) {
            $file = fopen($config_file, 'a');

            if(!$file)
            {
                throw new WechatException('配置文件创建失败');
            }

            $this->config = array(
                'access_token' => '',
                'expired_in' => 0,
                'jsapi_ticket' => '',
                'jsapi_expired' => 0
            );

            fwrite($file, json_encode($this->config));
            fclose($file);
        }

        $this->load_config();
    }

    /**
     * 单例模式
     * @param string $appid 公众号appid
     * @param string $appsecret 公众号appsecret
     * @param string $wechat_account 公众号原始ID
     * @param string $token 公众号开发者配置的token
     * @throws WechatException
     * @return Wechat
     */
    public static function getInstance($appid, $appsecret, $wechat_account, $token, $config_file = 'wechat.dat') {
        if(self::$self != NULL) {
            return self::$self;
        }

        if(!is_writable($config_file)) {
            throw new WechatException('配置文件不可写');
        }

        return new Wechat($appid, $appsecret, $wechat_account, $token, $config_file);
    }

    /**
     * 判断数据源是否是微信
     * @return bool
     * @author winsen
     * @date 2014-10-24
     */
    function is_weixin() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }

        return false;
    }

    /**
     * 获取access_token
     * @return bool
     */
    public function get_access_token() {
        if($this->config->expired_in <= time()) {
            //对于access_token超时，则重新获取access_token
            $request_time = time();
            $url_get_access_token = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
            $url = sprintf($url_get_access_token, $this->appid, $this->appsecret);

            $data = Http::request($url, null, 'get');
            $response = json_decode($data);

            if(!empty($response->errcode)) {
                trigger_error($response->errmsg);
                return false;
            } else {
                $this->access_token = $response->access_token;
                $this->config->access_token = $response->access_token;
                $this->config->expired_in = $request_time + $response->expires_in;
                $this->save_config();
            }
        }

        return $this->access_token;
    }

    /**
     * 获取JS-SDK的ticket
     * @return bool
     */
    public function get_jsapi_ticket() {
        if($this->config->jsapi_expired <= time()) {
            $request_time = time();
            $url_get_jsapi_ticket = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi';
            $url = sprintf($url_get_jsapi_ticket, $this->get_access_token());

            $data = Http::request($url, null, 'get');
            $response = json_decode($data);

            if(!empty($response->errcode)) {
                trigger_error($response->errmsg);
                return false;
            } else {
                $this->jsapi_ticket = $response->ticket;
                $this->config->jsapi_expired = $request_time + $response->expired_in;
            }
        }

        return $this->jsapi_ticket;
    }

    /**
     * 获取JS-SDK config的签名包
     * @return array
     */
    public function get_jsapi_signature() {
        $jsapi_ticket = $this->get_jsapi_ticket();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->create_noncestr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $jsapi_signature = array(
            "appId"     => $this->appid,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );

        return $jsapi_signature;
    }

    private function create_noncestr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 微信接入开发者模式验证URL以及接收用户信息时使用
     * @param string $signature 微信加密签名
     * @param string $timestamp 时间戳
     * @param string $nonce 随机数
     * @param string $token 公众号设置的Token
     * @return bool
     * @author winsen
     * @date 2014-10-24
     */
    private function check_signature($signature, $timestamp, $nonce)
    {
        $tmp_str = array($this->token, $timestamp, $nonce);
        sort($tmp_str, SORT_STRING);
        $tmp_signature = implode($tmp_str);
        $tmp_signature = sha1($tmp_signature);

        if( $tmp_signature == $signature )
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 加载微信配置
     */
    private function load_config() {
        $config_content = file_get_contents($this->config_file);
        $this->config = json_decode($config_content);
        $this->access_token = $this->config->access_token;
        $this->jsapi_ticket = $this->config->jsapi_ticket;
    }

    /**
     * 保存微信配置到配置文件
     * @return bool
     */
    private function save_config() {
        return file_put_contents($this->config_file, json_encode($this->config)) === false ? true : false;
    }

    /**
     * @param string $mode 变更信息收发方式
     */
    public function switch_mode($mode) {
        $mode_list = 'default|hybrid|encryption';

        if(strpos($mode, $mode_list) === false) {
            $this->mode = 'default';
        } else {
            $this->mode = $mode;
        }
    }

    /**
     * 根据mode对接收到的微信请求进行解密
     * @param string $encryption
     * @return null|SimpleXMLElement
     */
    public function decrypt($encryption) {
        $decryption = null;

        switch($this->mode) {
            default:
                $decryption = simplexml_load_string($encryption);
                break;
        }

        return $decryption;
    }

    /**
     * 根据mode对回传的微信信息进行加密
     * @param string $decryption
     * @return string
     */
    public function encrypt($decryption) {
        $encryption = null;

        switch($this->mode) {
            default:
                $encryption = $decryption;
                break;
        }

        return $encryption;
    }

    /**
     * 分发微信请求,并进行处理
     * @param $xml_request
     */
    public function dispatch($xml_request) {
        $request = $this->decrypt($xml_request);

        $to_user = $request->ToUserName;//开发者微信号
        $from_user = $request->FromUserName;//发送方帐号（一个OpenID）
        $create_time = $request->CreateTime;//消息创建时间 （整型）
        $msg_type = $request->MsgType;//消息类型
        $msg_id = $request->MsgId;//消息id，64位整型


        /*
        $msg_type = ucfirst($msg_type);

        $caller = 'Wechat'.$msg_type;
        $response = new $caller($to_user, $from_user, $request);

        echo $this->encrypt($response->response());
        */
    }

    /**
     * 重写克隆方法,防止单例模式被破坏
     */
    private function __clone() {
    }
}