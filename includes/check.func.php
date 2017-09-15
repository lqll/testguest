<?php


if (!defined('IN_TG')) {
    exit('access defined');
}

if (!function_exists('_alert_back')) {
    exit('_alert_back()函数不存在，请检查');
}

if (!function_exists('_mysql_string')) {
    exit('_mysql_string()函数不存在，请检查');
}

/**
 * 检查用户名
 * @param $_string
 * @param $_min_num
 * @param $_max_num
 * @return string
 */
function _check_username($_string, $_min_num, $_max_num)
{

    //去掉两边的空格
    $_string = trim($_string);

    //长度大于2位小于20位
    if (mb_strlen($_string, 'utf-8') < $_min_num || mb_strlen($_string, 'utf-8') > 20) {
        _alert_back('长度小于' . $_min_num . '位或者大于' . $_max_num . '位错误');
    }

    //限制敏感字符
    $_char_pattern = '/[<>\'\"\ \]/';
    if (@preg_match($_char_pattern, $_string)) {
        _alert_back('不能包含敏感字符');
    }

    //限制敏感用户名
    $_mg = array();
    $_mg[0] = '张三';
    $_mg[1] = '李四';
    $_mg[2] = '王五';

    $_mg_string = '';
    foreach ($_mg as $value) {
        $_mg_string .= $value . ',';
    }

    if (in_array($_string, $_mg)) {
        _alert_back($_mg_string . '敏感用户名不能注册');
    }

    return $_string;
}

/**
 * @param $_first_pass
 * @param $_end_pass
 * @param $_min_num
 * @return string
 */
function _check_password($_first_pass, $_end_pass, $_min_num)
{
    //判断密码位数
    if (strlen($_first_pass) < $_min_num) {
        _alert_back('密码不能小于' . $_min_num . '位');
    }

    //密码和密码确认一致
    if ($_first_pass !== $_end_pass) {
        _alert_back('密码和密码确认不一致');
    }
    return sha1($_first_pass);
}

function _check_modify_password($_string, $_min_num)
{
    if (!empty($_string)) {
        //判断密码位数

        if (strlen($_string) < $_min_num) {
            _alert_back('密码不能小于' . $_min_num . '位');
        }

        return sha1($_string);
    } else {
        return $_string = null;
    }
}

/**
 * @param $_string
 * @param $_min_num
 * @param $_max_num
 * @return mixed
 */
function _check_question($_string, $_min_num, $_max_num)
{
    //长度大于4位小于20位
    $_string = trim($_string);
    if (mb_strlen($_string, 'utf-8') < $_min_num || mb_strlen($_string, 'utf-8') > 20) {
        _alert_back('密码提示必须小于' . $_min_num . '位或者大于' . $_max_num . '位错误');
    }
    return _mysql_string($_string);

}

/**
 * @param $_ques
 * @param $_answ
 * @param $_min_num
 * @param $_max_num
 * @return string
 */
function _check_answer($_ques, $_answ, $_min_num, $_max_num)
{
    if (mb_strlen($_answ, 'utf-8') < $_min_num || mb_strlen($_answ, 'utf-8') > 20) {
        _alert_back('密码提示必须小于' . $_min_num . '位或者大于' . $_max_num . '位错误');
    }

    //密码提示与回答不能一致
    if ($_ques == $_answ) {
        _alert_back('密码提示与回答不能相同');
    }

    return sha1($_answ);
}

/**
 * 检查邮件格式
 * @param $_string
 * @return mixed
 */
function _check_email($_string, $_min_num, $_max_num)
{

    if (!empty($_string)) {
        if (@!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $_string)) {
            _alert_back('邮件格式不正确');
        }
    } else {
        if (strlen($_string) < $_min_num || strlen($_string) < $_max_num) {
            _alert_back('邮箱长度不合法');
        }
        return null;

    }


    return $_string;
}


/**qq验证
 * @param $_string
 * @return null
 */
function _check_qq($_string)
{
    if (empty($_string)) {
        return null;
    } else {
        if (!preg_match('/^[1-9]{1}[0-9]{4,9}$/', $_string)) {
            _alert_back('qq号码不正确');
        }
    }
    return $_string;
}


/**
 * 网址验证
 * @param $_string
 * @return null
 */
function _check_url($_string, $_max_num)
{
    if (empty($_string) || ($_string == 'http://')) {
        return null;
    } else {
        if (!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/', $_string)) {
            _alert_back('网址格式不正确');
        }
        if (strlen($_string) > $_max_num) {
            _alert_back('网址长度不合法');
        }
    }
    return $_string;
}

function _check_uniqid($_first_uniqid, $_end_uniqid)
{
    if ((strlen($_first_uniqid) !== 40) || ($_first_uniqid !== $_end_uniqid)) {
        _alert_back('唯一标识符异常');
    }
    return $_first_uniqid;
}

function _check_content($_string)
{
    if (mb_strlen($_string, 'utf-8') < 10 || mb_strlen($_string, 'utf-8') > 200) {
        _alert_back('信息字数不符合要求');
    }
    return $_string;
}


?>