<?php
if (!defined('IN_TG')){
    exit ('非法调用');
}
?>

<div id="member_sidebar">
    <h2>中心导航</h2>
    <dl>
        <dt>账号管理</dt>
        <dd><a href="member.php">个人信息</a></dd>
        <dd><a href="member_modify.php">修改资料</a></dd>
    </dl>

    <dl>
        <dt>其他管理</dt>
        <dd><a href="member_message.php">短息查阅</a></dd>
        <dd><a href="member_friend.php">好友设置</a></dd>
        <dd><a href="member_flower.php">查询花朵</a></dd>
        <dd><a href="#">个人相册</a></dd>
    </dl>
</div>