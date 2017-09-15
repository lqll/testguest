<?php
/**
 * Created by PhpStorm.
 * User: 84532
 * Date: 2017/8/18
 * Time: 11:25
 * 验证码
 */


session_start();
define('IN_TG',true);

require dirname(__FILE__).'/includes/common.inc.php';

//运行验证码
_code();    //默认验证码大小为：75*25，位数为4位，如果要6位，长度推荐125，如果要8位，推荐175

?>