<?php
/**
 * 公共函数库
 * @author winsen
 * @version 1.0.0
 * @date 2015-07-28
 */

/**
 * 检查管理员是否登录
 */
function check_admin_oauth() {
    if(isset($_SESSION['admin'])) {
        return true;
    } else {
        redirect('login.php');
    }
}

/**
 * 重定向
 */
function redirect($url) {
    header('Location: '.$url);
    exit;
}

/**
 * 权限检查函数
 * @param int $sys_purview 系统定义的权限
 * @param int $user_purview 用户的权限
 * @return bool 拥有该权限时返回true,否则返回false
 * @author winsen
 * @date 2015-07-28
 */
function check_purview($sys_purview, $user_purview)
{
    $user_purview = json_decode($user_purview);
    $has_power = false;
    foreach( $user_purview as $key => $value ) {
        if( in_array($sys_purview, $value) ) {
            $has_power = true;
            break;
        }
    }
    return $has_power;
}

/**
 * 权限合并
 * @param array $user_purview 用户的权限
 * @param mixed $purviewList 需要合并的权限列表
 * @return int 返回合并后的权限
 * @author winsen
 * @date 2015-07-28
 */
function combile_purview($user_purview, $purview_list)
{
    if(is_array($purview_list))
    {
        $user_purview = array_merge($user_purview, $purview_list);
    }

    if(is_string($purview_list))
    {
        $user_purview[] = $purview_list;
    }

    $user_purview = array_flip($user_purview);
    $user_purview = array_flip($user_purview);
    ksort($user_purview);

    return $user_purview;
}

/**
 * 获取GET的参数封装
 * @param string $var 参数名
 * @return mixed 返回对应的参数,如果参数不存在,则返回null
 * @author winsen
 * @date 2015-07-28
 */
function getGET($var)
{
    if(isset($_GET[$var]))
    {
        return $_GET[$var];
    } else {
        return null;
    }
}

/**
 * 获取POST的参数封装
 * @param string $var 参数名
 * @return mixed 返回对应的参数,如果参数不存在,则返回null
 * @author winsen
 * @date 2015-07-28
 */
function getPOST($var)
{
    if(isset($_POST[$var]))
    {
        return $_POST[$var];
    } else {
        return null;
    }
}

/**
 * 验证页面的act或opera值的合法性
 * @param string $needle 合法操作字符串,多个操作用|分隔开
 * @param string $search 待验证的操作
 * @param string $default 若为非法操作,则采用默认值替换
 * @author winsen
 * @date 2015-07-28
 */
function check_action($needle, $search, $default = '')
{
    if(!$needle || false === strpos($needle, $search))
    {
        return $default;
    } else {
        return $search;
    }
}

/**
 * 备份数据库
 * @param mixed $tables
 * @param bool $with_struct
 * @param bool $with_drop_table
 * @return string
 * @author winsen
 * @date 2015-07-28
 */
function backup($tables = null)
{
    global $db;

    $file_name = 'backup/db-backup-'.date('YmdHis').'.sql';

    if(!dir('backup'))
    {
        mkdir('backup');
    }

    $content = '';

    if(!$tables)
    {
        $tables = array();
        //不指定要备份的表，默认为完整备份整个数据库
        $get_tables = 'show tables;';

        $tables_tmp = $db->fetchAll($get_tables);
        foreach($tables_tmp as $value)
        {
            foreach($value as $table)
            {
                $tables[] = $table;
            }
        }
    } else if(is_string($tables)) {
        $tables = array($tables);
    }

    //备份结构和数据
    $create_sql_format = '%s;'."\n\n%s\n\n\n";
    $get_table_struct = 'show create table %s;';
    $get_table_data = 'select * from %s;';

    foreach($tables as $table)
    {
        $get_table_struct_sql = sprintf($get_table_struct, $table);
        $get_table_data_sql = sprintf($get_table_data, $table);

        $create_table_sql = $db->fetchRow($get_table_struct_sql);
        $cnt = 0;
        $table_type = 'table';
        foreach($create_table_sql as $key=>$value)
        {
            if($cnt == 1)
            {
                $create_table_sql .= $value;
                break;
            } else {
                if($key == 'Table')
                {
                    $create_table_sql = 'DROP TABLE IF EXISTS `'.$table.'`;'."\n"; 
                    $table_type = 'table';
                } else if($key == 'View') {
                    $create_table_sql = 'DROP VIEW IF EXISTS `'.$table.'`;'."\n";
                    $table_type = 'view';
                }
            }
            $cnt++;
        }

        $data_set = $db->fetchAll($get_table_data_sql);
        $record_count = count($data_set);
        $data_sql = '';
        if($record_count && $table_type == 'table')
        {
            for($i = 0; $i < $record_count; $i++)
            {
                if($i%256 == 0)
                {
                    $data_sql .= 'INSERT INTO `'.$table.'` VALUES (';
                } else {
                    $data_sql .= ' (';
                }

                foreach($data_set[$i] as $value)
                {
                    $data_sql .= '\''.addslashes($value).'\',';
                }
                $data_sql = substr($data_sql, 0, strlen($data_sql)-1);
                $data_sql .= ')';

                if($i != $record_count-1 && (($i+1)%256 != 0 || $i == 0))
                {
                    $data_sql .= ",\n";
                } else {
                    $data_sql .= ";\n";
                }
            }
        }

        $content .= sprintf($create_sql_format, $create_table_sql, $data_sql);
    }

    $handler = fopen($file_name, 'w');
    fwrite($handler, $content);
    fclose($handler);

    return $file_name;
}

/**
 * 验证银行卡是否正确
 * @param $bank_card
 * @return bool
 */
function luhm_check($bank_card) {
    $length = strlen($bank_card);

    $last_num = substr($bank_card, $length-1, 1);
    $first_several_num = substr($bank_card, 0, $length - 1);
    $new_array = array();
    for( $i = $length - 1; $i >= 0; $i-- ) {
        array_push($new_array, substr($first_several_num, $i, 1));
    }
    $sum = 0;
    foreach( $new_array as $k => $v ) {
        if( ($k) % 2 == 1 ) {    //奇数位
            $temp = $v * 2;
            if( $temp <= 9 ) {
                $sum += $temp;
            } else {
                $sum += intval($temp / 10);
                $sum += $temp % 10;
            }
        } else {
            $sum += $v;
        }
    }
    //计算luhm
    $subtractor = ( ($sum % 10) == 0 ) ? 10 : ($sum % 10);
    $luhm = 10 - $subtractor;

    if( $last_num == $luhm ) {
        return true;
    } else {
        return false;
    }

}

function decodeUnicode($str)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
}

function is_email($email) {
    $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    return preg_match($pattern, $email);
}

/**
 *身份证号码检查接口函数
 *@params string $idcard 身份证号码
 *@return bool 是否正确
 */
function check_identity_num($identity_num) {
    if(strlen($identity_num) == 15 || strlen($identity_num) == 18){
        if(strlen($identity_num) == 15){
            $identity_num = idcard_15to18($identity_num);
        }
        if(idcard_checksum18($identity_num)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function idcard_verify_number($idcard_base){
    if (strlen($idcard_base) != 17){
        return false;
    }
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); //debug 加权因子
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); //debug 校验码对应值
    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++){
        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = $checksum % 11;
    $verify_number = $verify_number_list[$mod];
    return $verify_number;
}

function idcard_15to18($idcard){
    if (strlen($idcard) != 15){
        return false;
    }else{// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
            $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
        }else{
            $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
        }
    }
    $idcard = $idcard . idcard_verify_number($idcard);
    return $idcard;
}

function idcard_checksum18($idcard){
    if (strlen($idcard) != 18){ return false; }
    $idcard_base = substr($idcard, 0, 17);
    if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
        return false;
    }else{
        return true;
    }
}

/**
 * CURL方式发起http请求
 * @param string $url
 * @param mixed $data
 * @param string $method
 * @param bool $encode
 * @param bool $need_header
 * @return mixed
 */
function curl_http_request($url, $data, $method, $encode = true, $need_header = false)
{
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
        /*
        foreach($data as $key=>$value)
        {
            if('' != $data_fields)
            {
                $data_fields .= '&';
            }

            $data_fields .= $key.'='.urlencode($value);
        }
        */
    } else {
        $data_fields = $data;
    }

    if($method == 'GET' && $encode)
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

/**
 * 显示错误信息
 * @param $message
 * @param string $redirect
 * @param string $state
 */
function message($message, $redirect = '', $state = 'warning') {
    global $smarty;

    $buttons = array();

    if($redirect == '') {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

        $buttons[] = array(
            'btn' => '返回上一页',
            'url' => $redirect
        );
    } else {
        if(is_array($redirect)) {
            foreach($redirect as $item) {
                $buttons[] = array(
                    'btn' => $item['btn'],
                    'url' => $item['url']
                );
            }
        } else {
            $buttons[] = array(
                'btn' => '返回上一页',
                'url' => $redirect
            );
        }
    }

    $icon = 1;
    switch($state) {
        case 'success':
            $icon = 1;
            break;

        case 'error':
            $icon = 2;
            break;

        default:
            $icon = 7;
            break;
    }

    $smarty->assign('buttons', $buttons);
    $smarty->assign('icon', $icon);
    $smarty->assign('message', $message);
    $smarty->display('common/message.phtml');
}