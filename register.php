<?php
define('IN_TG', true);
define('SCRIPT', 'register');
require dirname(__FILE__) . '/includes/common.inc.php';



session_start();


//登录状态
_login_state();
//测试新增用户能否成功


//判断是否有数据提交
if (@$_GET['action'] == 'register') {
    //为了防止恶意注册和跨站攻击




    //新增用户之前要判断用户名是否重复
//    $query = _query("SELECT tg_username FROM tg_user WHERE tg_username='{$_POST['username']}'");

//    if(mysqli_fetch_array($query,MYSQLI_ASSOC)){
//        _alert_back('对不起，此用户已被注册');
//    }

//    if(_fetch_array("SELECT tg_username FROM tg_user WHERE tg_username='{$_POST['username']}'")){
//        _alert_back('对不起，此用户已被注册');
//    }

    _is_repeat(
            "SELECT tg_username FROM tg_user WHERE tg_username='{$_POST['username']}'",
            '对不起，此用户已被注册'
    );

    //检查验证码
    _check_code($_POST['code'], $_SESSION['code']);


    //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等


    //引入验证文件
    include ROOT_PATH . 'includes/check.func.php';

    $_clean = array();
    $_clean['uniqid'] = _check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
    //active也是标识符，用来刚注册的用户激活处理：
    $_clean['active'] = _sha1_uniqid();
    $_clean['username'] = _check_username($_POST['username'], 2, 10);
    $_clean['password'] = _check_password($_POST['password'], $_POST['notpassword'], 6);
    $_clean['question'] = _check_question($_POST['question'], 4, 20);
    $_clean['answer'] = _check_answer($_POST['question'], $_POST['answer'], 2, 20);
    $_clean['sex'] = $_POST['sex'];
    $_clean['face'] = $_POST['face'];
    $_clean['email'] = _check_email($_POST['email'], 6, 40);
    $_clean['qq'] = _check_qq($_POST['qq']);

    //正则有bug，有空再测试
    $_clean['url'] = _check_url($_POST['url'], 40);



    //新增用户，在双引号里，直接放变量是可以的，比如$_usernae,但如果是数组，就必须加上{}，比如{$_clean['username']}
    mysqli_query($_conn,
        "INSERT INTO tg_user(
                              tg_uniqid,
                              tg_active,
                              tg_username,
                              tg_password,
                              tg_question,
                              tg_answer,
                              tg_sex,
                              tg_face,
                              tg_email,
                              tg_qq,
                              tg_url,
                              tg_reg_time,
                              tg_last_time,
                              tg_last_ip
                              ) VALUES (
                              '{$_clean['uniqid']}',
                              '{$_clean['active']}',
                              '{$_clean['username']}',
                              '{$_clean['password']}',
                              '{$_clean['question']}',
                              '{$_clean['answer']}',
                              '{$_clean['sex']}',
                              '{$_clean['face']}',
                              '{$_clean['email']}',
                              '{$_clean['qq']}',
                              '{$_clean['url']}',
                              NOW(),
                              NOW(),
                              '{$_SERVER['REMOTE_ADDR']}'
                              )") ;

    if (_affected_rows() == 1){
        mysqli_close($_conn);
        _session_destroy();
        _location('恭喜你，注册成功','active.php?active='.$_clean['active']);
    }else{
        mysqli_close($_conn);
        _session_destroy();
        _location('很遗憾你注册失败','register.php');
    }
}else{
    $_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();

}

//唯一标识符

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统-注册</title>
    <?php
    require ROOT_PATH . 'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/code.js"></script>

    <script type="text/javascript" src="js/register.js"></script>

</head>
<body>
<?php
require ROOT_PATH . 'includes/header.inc.php';
?>

<div id="register">
    <h2>会员注册</h2>
    <form action="register.php?action=register" method="post" name="register">
        <input type="hidden" name="uniqid" value="<?php echo $_uniqid; ?>">
        <dl>
            <dt>请认真填写以下内容</dt>
            <dd>用 户 名: <input type="text" name="username" class="text">（*必填，至少两位）</dd>
            <dd>密 &nbsp; 码: <input type="password" name="password" class="text">（*必填，至少6位）</dd>
            <dd>确认密码: <input type="password" name="notpassword" class="text">（*必填，至少6位）</dd>
            <dd>密码提示: <input type="text" name="question" class="text">（*必填，至少两位）</dd>
            <dd>密码回答: <input type="text" name="answer" class="text">（*必填，至少两位）</dd>
            <dd>性 &nbsp; 别: <input type="radio" name="sex" value="男" checked="checked">男<input type="radio" name="sex"
                                                                                               value="女">女
            </dd>

            <dd class="face"><input type="hidden" name="face" value="face/1.png" id="face"><img src="face/1.png" alt="头像"
                                                                               style="width: 100px;" id="faceimg"></dd>

            <dd>电子邮件: <input type="text" name="email" class="text">(*必填，激活账户用)</dd>
            <dd> Q &nbsp;&nbsp;Q : <input type="text" name="qq" class="text"></dd>
            <dd>主页地址: <input type="text" name="url" value="http://" class="text"></dd>

            <dd>验 证 码: <input type="text" name="code" class="text yzm"><img id="code" src="code.php" alt=""></dd>

            <dd><input type="submit" value="注册" class="submit"></dd>
        </dl>
    </form>
</div>


<?php
require "includes/footer.inc.php";

?>
</body>


</html>