<?php
session_start();

define('IN_TG', true);
define('SCRIPT', 'login');
require dirname(__FILE__) . '/includes/common.inc.php';

//登录状态
_login_state();

//开始处理登录状态

if (@$_GET['action'] == 'login') {


    //检查验证码
//    echo $_POST['code'];
    _check_code($_POST['code'], $_SESSION['code']);

    //引入验证文件
    include ROOT_PATH . 'includes/login.func.php';

    //接受数据
    $_clean = array();
    $_clean['username'] = _check_username($_POST['username'], 2, 20);
    $_clean['password'] = _check_password($_POST['password'], 6);
    $_clean['time'] = _check_time($_POST['time']);


    //数据库验证
    if ($_rows = _fetch_array("SELECT tg_username,tg_uniqid  FROM tg_user WHERE tg_username='{$_clean['username']}' AND tg_password='{$_clean['password']}' AND tg_active='' LIMIT 1")) {

        //登录成功后记录登录信息
        _query("UPDATE tg_user SET 
                          tg_last_time=NOW(),
                          tg_last_ip='{$_SERVER["REMOTE_ADDR"]}',
                          tg_login_count=tg_login_count+1
                          WHERE tg_username='{$_rows['tg_username']}'
                          ");

        _close();
        _session_destroy();
        _setcookies($_rows['tg_username'], $_rows['tg_uniqid'], $_clean['time']);
        _location(null, 'member.php');
    } else {
        _close();
        _session_destroy();
        _location('用户名密码不正确或者该账户未被激活', 'login.php');
    }


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统-登录</title>
    <?php
    require ROOT_PATH . 'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/code.js"></script>

    <script type="text/javascript" src="js/login.js"></script>

</head>
<body>
<?php
require ROOT_PATH . 'includes/header.inc.php';
?>
<div id="login">
    <h2>登录</h2>
    <form action="login.php?action=login" method="post" name="login">
        <dl>
            <dd>用户名：<input type="text" name="username" class="text"></dd>
            <dd>密&nbsp码：<input type="password" name="password" class="text"></dd>
            <dd>保留：<input type="radio" name="time" value="0" checked="checked">不保留</dd>
            <input type="radio" name="time" value="1">一天</dd>
            <dd>保留：<input type="radio" name="time" value="2">一周</dd>
            <dd>保留：<input type="radio" name="time" value="3">一个月</dd>
            <dd>验证码：<input type="text" name="code" class="text code"><img id="code" src="code.php" alt=""></dd>

            <dd><input type="submit" value="登录" class="button"><input type="button" value="注册" id="location"
                                                                      class="button location"></dd>
        </dl>
    </form>
</div>


<?php
require "includes/footer.inc.php";

?>


</body>
</html>