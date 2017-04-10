<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2016/11/6
 * Time: 上午11:31
 */
include 'library/init.inc.php';

$operation = 'login';

$opera = check_action($operation, getPOST('opera'));

if('login' == $opera) {
    $account = getPOST('account');
    $password = getPOST('password');
    $code = getPOST('code');

    $ajax_response = array('error'=>-1, 'message'=>'');

    if($account == '') {
        $ajax_response['message'] .= '-请填写管理员账号'.BR;
    } else {
        $account = $db->escape($account);
    }

    if($password == '') {
        $ajax_response['message'] .= '-请填写管理员密码'.BR;
    } else {
        $password = md5($password.PASSWORD_SALT);
    }

    if($_SESSION['login_fail'] > 3 && $code == '') {
        $ajax_response['message'] .= '-请填写验证码'.BR;
    } else {
        $code = strtolower($code);

        if($code != $_SESSION['code']) {
            $ajax_response['message'] .= '-验证码错误'.BR;
        }
    }

    if($ajax_response['message'] == '') {
        $admin_conditions = array(
            'account' => $account
        );

        $admin = $db->get('admin', $admin_conditions);

        if(empty($admin)) {
            $ajax_response['message'] .= '-管理员不存在'.BR;
            $_SESSION['login_fail']++;
        } else {
            if($admin['password'] != $password) {
                $ajax_response['message'] .= '-管理员密码错误'.BR;
            } else {
                $_SESSION['admin'] = $admin['account'];
                $_SESSION['purview'] = 'all';
                $_SESSION['name'] = $admin['name'];

                $ajax_response['error'] = 0;
                $ajax_response['message'] = '登录成功';
            }
        }
    } else {
        $_SESSION['login_fail']++;
    }

    $ajax_response['login_fail'] = $_SESSION['login_fail'];
    echo json_encode($ajax_response);
    exit;
}

if($_SESSION['login_fail'] <= 3) {
    $_SESSION['code'] = 'code';
}
$smarty->assign('_P', $_P);
$smarty->display('login.phtml');