<?php
/**
 * Created by PhpStorm.
 * User: 84532
 * Date: 2017/8/15
 * Time: 15:57
 */
if (!defined('IN_TG')){
    exit ('非法调用');
}
?>

<div id="header">
    <h1><a href="index.php">酷形健身俱乐部多用户留言系统</a></h1>
    <ul>
        <li><a href="index.php">首页</a></li>
        <?php
        if(isset($_COOKIE['username'])){
            echo '<li><a href="member.php">'.$_COOKIE['username'].'</a></li>';
        }else{
            echo "        <li><a href=\"register.php\">注册</a></li>
        <li><a href=\"login.php\">登录</a></li>";
        }
        ?>

        <li><a href="member.php">个人中心</a><?php echo $_message_html?></li>
        <li><a href="blog.php">博友</a></li>
        <li>风格</li>
        <li>管理</li>

        <?php
        if(isset($_COOKIE['username'])){
            echo  '<li><a href="logout.php">退出</a>';
        }
        ?>
    </ul>
</div>