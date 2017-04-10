<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/7/3
 * Time: 下午6:21
 */
class Http {
    public function __construct() {
    }

    /**
     * @param $url
     * @param $data
     * @param $method
     * @param bool|true $encode
     * @param bool|false $need_header
     * @return mixed
     */
    public static function request($url, $data, $method, $encode = true, $need_header = false) {
        $protocol = 'http';

        if(strpos($url, '://') !== false)
        {
            $explode_arr = explode('://', $url);

            $protocol = $explode_arr[0];
        }

        $method = strtoupper($method);
        $data_fields = '';

        if($encode && (is_array($data) || is_object($data)))
        {
            $data_fields = http_build_query($data);
        } else {
            $data_fields = $data;
        }

        if($method == 'GET' && $encode && $data_fields)
        {
            $url .= '?'.$data_fields;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        if($need_header)
        {
            curl_setopt($curl, CURLOPT_HEADER, 1);
        } else {
            curl_setopt($curl, CURLOPT_HEADER, 0);
        }

        if($method == 'POST')
        {
            curl_setopt($curl, CURLOPT_POST, true );
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_fields);
        }

        if($protocol == 'https')
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSLVERSION, 1);
        }

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }
}