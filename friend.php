<?php
/**
 * 添加好友弹窗
 * Created by PhpStorm.
 * User: 84532
 * Date: 2017/9/4
 * Time: 12:52
 */
session_start();
//博友界面
define('IN_TG', true);

define('SCRIPT', 'friend');

require dirname(__FILE__) . '/includes/common.inc.php';

//判断是否登录
if (!isset($_COOKIE['username'])) {
    _alert_close('您还没有登陆');
}

//添加好友
if (@$_GET['action'] == 'add') {
    _check_code($_POST['code'], $_SESSION['code']);
//验证标识符
    if (!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);

        include ROOT_PATH . 'includes/check.func.php';
        $_clean = array();
        $_clean['touser'] = $_POST['touser'];
        $_clean['fromuser'] = $_COOKIE['username'];
        //不能添加自己
        if($_clean['touser'] == $_clean['fromuser']){
            _alert_close('不能添加自己');
        }

        $_clean['content'] = _check_content($_POST['content']);
        $_clean = _mysql_string($_clean);

        //验证数据库是否已经添加好友
        if (!!$rows = _fetch_array("SELECT tg_id FROM tg_friend WHERE  (tg_touser='{$_clean['touser']}' AND tg_fromuser='{$_clean['fromuser']}') OR (tg_fromuser='{$_clean['fromuser']}' AND tg_touser='{$_clean['touser']}') LIMIT 1")) {
            _alert_back('你们已经是好友了，或者是未验证的好友');
        } else {
            //添加好友
            _query("INSERT INTO tg_friend (tg_touser,tg_fromuser,tg_content,tg_date) VALUES ('{$_clean['touser']}','{$_clean['fromuser']}','{$_clean['content']}',NOW())");

            if (_affected_rows() == 1){
                mysqli_close($_conn);
                session_destroy();
                _alert_close('添加好友成功！请等待验证');
            }else{
                mysqli_close($_conn);
                session_destroy();
                _alert_close('添加好友失败');
            }
            exit();
        }

    }
}


//获取数据
if (isset($_GET['id'])) {
    if (!!$_rows = _fetch_array("SELECT tg_username FROM tg_user WHERE tg_id = '{$_GET['id']}'")) {
        $_html = array();
        $_html['touser'] = $_rows['tg_username'];

        $_html = _html($_html);
    } else {
        _alert_close('不存在此用户');
    }

} else {
    _alert_close('非法操作');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--添加好友</title>
    <script type="text/javascript" src="js/code.js"></script>

    <?php
    require ROOT_PATH . 'includes/title.inc.php'
    ?>
    <script src="js/code.js"></script>
    <script src="js/message.js"></script>
</head>
<body>


<div id="message">
    <h3>添加好友</h3>
    <form action="?action=add" method="post">
        <input type="hidden" value="<?php echo $_html['touser'] ?>" name="touser">
        <dl>
            <dd><input type="text" readonly="readonly" class="text" value="To:<?php echo $_html['touser'] ?>"></dd>
            <dd><textarea name="content" id="" cols="" rows="">我非常想和你交朋友啊啊啊啊</textarea></dd>
            <dd>验 证 码: <input type="text" name="code" class="text yzm"><img id="code" src="code.php" alt=""><input
                        type="submit" value="添加好友" class="submit"></dd>
        </dl>
    </form>
</div>

</body>
</html>