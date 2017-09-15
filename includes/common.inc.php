<?php
if (!defined('IN_TG')) {
    exit ('非法调用');
}

//设置编码
header('Content-Type:text/html;charset=utf-8');

//转换硬路径
define('ROOT_PATH', substr(dirname(__FILE__), 0, -8));


if (PHP_VERSION < '4.1.0') {
    exit('Version is too low!');
}

//引入核心函数库
require ROOT_PATH . 'includes/global.func.php';
require ROOT_PATH . 'includes/mysql.func.php';


//数据库链接
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'Work0907');
define('DB_NAME', 'testguest');

//链接数据库
_connect();
//选择数据库
_select_db();
//选择字符集
_set_names();


$_strt_time = _runtime();


//短信提醒
if(isset($_COOKIE['username'])){
    $_message = _fetch_array("SELECT COUNT(tg_id) AS content FROM tg_message WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");

}
if (empty($_message['content'])) {
    $_message_html = '<strong><a href="member_message.php">(0)</a></strong>';
} else {
    $_message_html = '<strong><a href="member_message.php">(' . $_message['content'] . ')</a></strong>';
}



