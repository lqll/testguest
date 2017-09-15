<?php

session_start();

define('IN_TG', true);

define('SCRIPT', 'member_modify');

require dirname(__FILE__) . '/includes/common.inc.php';

if (@$_GET['action'] == 'modify') {



    //检查验证码
    _check_code($_POST['code'], $_SESSION['code']);

    if(!!$_rows = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")){

        //为了防止cookies伪造，还要比对一下唯一标识符uniqid()
        _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);

        //引入验证文件
        include ROOT_PATH . 'includes/check.func.php';

        $_clean = array();
        $_clean['password'] = _check_modify_password($_POST['password'], 6);
        $_clean['sex'] = $_POST['sex'];

        $_clean['face'] = $_POST['face'];
        $_clean['email'] = _check_email($_POST['email'], 6, 40);
        $_clean['qq'] = _check_qq($_POST['qq']);
        //正则有bug，有空再测试
        $_clean['url'] = _check_url($_POST['url'], 40);

        print_r($_clean);

        if (empty($_clean['password'])) {
            _query("UPDATE tg_user SET 
          tg_sex='{$_clean['sex']}',
          tg_face='{$_clean['face']}',
          tg_email='{$_clean['email']}',
          tg_qq='{$_clean['qq']}',
          tg_url='{$_clean['url']}'
          WHERE tg_username='{$_COOKIE['username']}'
");
        } else {
            _query("UPDATE tg_user SET 
          tg_password='{$_clean['password']}',
          tg_sex='{$_clean['sex']}',
          tg_face='{$_clean['face']}',
          tg_email='{$_clean['email']}',
          tg_qq='{$_clean['qq']}',
          tg_url='{$_clean['url']}'
          WHERE tg_username='{$_COOKIE['username']}'
");
        }

    }


    if (_affected_rows() == 1){
        _close();
        _session_destroy();
        _location('恭喜你，修改成功','member.php');
    }else{
        _close();
        _session_destroy();
        _location('很遗憾你没有任何被修改','member_modify.php');
    }

}

//是否正常登录
if (isset($_COOKIE['username'])) {
    //获取数据
    $_rows = _fetch_array("SELECT tg_username,tg_sex,tg_face,tg_email,tg_url,tg_qq FROM tg_user WHERE tg_username = '{$_COOKIE['username']}'");

    if ($_rows) {
        $_html = array();
        $_html['username'] = $_rows['tg_username'];
        $_html['sex'] = $_rows['tg_sex'];
        $_html['face'] = $_rows['tg_face'];
        $_html['email'] = $_rows["tg_email"];
        $_html['url'] = $_rows['tg_url'];
        $_html['qq'] = $_rows['tg_qq'];
        $_html = _html($_html);
//        性别选择
        if ($_html['sex'] == '男') {
            $_html['sex_html'] = '<input type="radio" value="男" checked="checked" name="sex">男
<input type="radio" value="女" name="sex">女';
        } elseif ($_html['sex'] == '女') {
            $_html['sex_html'] = '<input type="radio" value="男"  name="sex">男
<input type="radio" value="女" name="sex" checked="checked">女';
        }

//        头像选择
        $_html['face_html'] = '<select name="face">';
        foreach (range(1, 20) as $number) {
            $_html['face_html'] .= '<option value="face/' . $number . '.png">face/' . $number . '.png</option>/n';
        }
        $_html['face_html'] .= '</select>';

    } else {
        _alert_back('此用户不存在');
    }
} else {
    _alert_back('非法登陆');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
    require ROOT_PATH . 'includes/title.inc.php'
    ?>
    <title>多用户留言系统--个人中心</title>

    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/member_modify.js"></script>
</head>
<body>

<?php
require ROOT_PATH . 'includes/header.inc.php';
?>


<div id="member">

    <?php require ROOT_PATH . 'includes/member.inc.php' ?>

    <div id="member_main">
        <h2>会员管理中心</h2>

        <form action="member_modify.php?action=modify" method="post" name="member_modify">
            <dl>
                <dd>用 户 名：<?php echo $_html['username']; ?></dd>
                <dd>密 &nbsp; 码: <input type="password" name="password" class="text">（留空则不修改）</dd>

                <dd>性 &nbsp 别：<?php echo $_html['sex_html']; ?></dd>
                <dd>头 &nbsp 像：<?php echo $_html['face_html']; ?></dd>
                <dd>电子邮件：<input type="text" class="text" value="<?php echo $_html['email']; ?>" name="email"></dd>
                <dd>主&nbsp&nbsp&nbsp&nbsp&nbsp 页：<input type="text" class="text" name="url"
                                                        value="<?php echo $_html['url']; ?>"></dd>
                <dd>Q &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; Q：<input type="text" class="text" name="qq"
                                                               value="<?php echo $_html['qq']; ?>"></dd>

                <dd>验 证 码: <input type="text" name="code" class="text yzm"><img id="code" src="code.php" alt=""></dd>

                <dd><input type="submit" value="修改资料" class="submit"></dd>
            </dl>
        </form>

    </div>

</div>

<?php
require "includes/footer.inc.php";

?>
</body>
</html>
