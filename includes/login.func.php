<?php


if (!defined('IN_TG')){
    exit('access defined');
}

if (!function_exists('_alert_back')){
    exit('_alert_back()函数不存在，请检查');
}

if (!function_exists('_mysql_string')){
    exit('_mysql_string()函数不存在，请检查');
}

/**
 * 检查用户名
 * @param $_string
 * @param $_min_num
 * @param $_max_num
 * @return string
 */
function _check_username($_string,$_min_num,$_max_num){

    //去掉两边的空格
    $_string = trim($_string);

    //长度大于2位小于20位
    if(mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8') >20 ){
        _alert_back('长度小于'.$_min_num.'位或者大于'.$_max_num.'位错误');
    }

    //限制敏感字符
    $_char_pattern = '/[<>\'\"\ \     ]/';
    if(@preg_match($_char_pattern,$_string)){
        _alert_back('不能包含敏感字符');
    }


    return _mysql_string($_string);
}

/**
 * 检查密码
 * @param $_min_num
 * @return string
 */
function _check_password($_string,$_min_num){
    //判断密码位数
    if (strlen($_string) < $_min_num){
        _alert_back('密码不能小于'.$_min_num.'位');
    }
    return sha1($_string);
}


function _check_time($_string){
    $_time = array('0','1','2','3');
    if(!in_array($_string,$_time)){
        _alert_back('保留方式出错');
    }
    return _mysql_string($_string);
}


function _check_uniqid($_first_uniqid,$_end_uniqid){
    if((strlen($_first_uniqid) !== 40) || ($_first_uniqid !==$_end_uniqid)){
        _alert_back('唯一标识符异常');
    }
    return $_first_uniqid;
}


/**
 * 生成登录coodie
 * @param $_username
 * @param $_uniqid
 */
function _setcookies($_username,$_uniqid,$_time){

    switch ($_time){
        case 0:
            setcookie('username',$_username);
            setcookie('uniqid',$_uniqid);
            break;
        case 1:
            setcookie('username',$_username,time()+86400);
            setcookie('uniqid',$_uniqid,time()+86400);
            break;
        case 2:
            setcookie('username',$_username,time()+864800);
            setcookie('uniqid',$_uniqid,time()+864800);
            break;
        case 3:
            setcookie('username',$_username,time()+2592000);
            setcookie('uniqid',$_uniqid,time()+2592000);
            break;
    }
}




?>