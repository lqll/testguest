<?php
/**
 * Created by PhpStorm.
 * User: 84532
 * Date: 2017/9/4
 * Time: 12:52
 */


//博友界面
define('IN_TG', true);

define('SCRIPT', 'member_message_detail');

require dirname(__FILE__) . '/includes/common.inc.php';


//判断是否登录
if (!isset($_COOKIE['username'])) {
    _alert_back('请先登录');
}

//删除短信模块

if (isset($_GET['action'])) {

    if ($_GET['action'] = 'delete' && isset($_GET['id'])) {
        if (!!$_rows = _fetch_array("SELECT tg_id FROM tg_message WHERE tg_id = '{$_GET['id']}' LIMIT 1")) {

            //当进行删除操作的时候要进行标识符验证
            if (!!$_rows2 = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
                _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);
                //删除短信
                _query("DELETE FROM tg_message WHERE tg_id={$_GET['id']} LIMIT 1 ");

                if (_affected_rows() == 1){
                    mysqli_close($_conn);
                    _session_destroy();
                    _location('短信删除成功','member_message.php');
                }else{
                    mysqli_close($_conn);
                    _session_destroy();
                    _location('短信删除失败','member_message.php');
                }
                exit();
            }else{
                _alert_back('非法登录');
            }
        } else {

            _alert_back('此短信不存在无法删除');
        }
    }
} elseif (isset($_GET['id'])) {
    $_rows = _fetch_array("SELECT tg_id,tg_fromuser,tg_content,tg_state,tg_date FROM tg_message WHERE tg_id = '{$_GET['id']}' LIMIT 1");
    if ($_rows) {

        //将state设置为1;
        if(empty($_rows['tg_state'])){
            _query("UPDATE tg_message SET tg_state=1 WHERE tg_id='{$_GET['id']}' LIMIT 1");
            if(!_affected_rows()){
                _alert_back('异常');
            }
        }

        $_html = array();
        $_html['id'] = $_rows['tg_id'];
        $_html['fromuser'] = $_rows['tg_fromuser'];
        $_html['content'] = $_rows['tg_content'];
        $_html['date'] = $_rows['tg_date'];
        $_html = _html($_html);
    } else {
        _alert_back('此短信不存在');

    }
} else {
    _alert_back('非法数据');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--短信详情</title>

    <?php
    require ROOT_PATH . 'includes/title.inc.php'
    ?>

    <script src="js/member_message_detail.js"></script>
</head>
<body>


<?php
require ROOT_PATH . 'includes/header.inc.php';
?>


<div id="member">

    <?php require ROOT_PATH . 'includes/member.inc.php' ?>


    <div id="member_main">
        <h2>短信详情中心</h2>

        <dl>
            <dd>发信人：<?php echo $_html['fromuser'] ?></dd>
            <dd>内容：<strong><?php echo $_html['content'] ?></strong></dd>
            <dd>发信时间:<?php echo $_html['date'] ?></dd>
            <dd class="button"><input type="button" value="返回列表" id="return"> <input type="button" value="删除短信"
                                                                                     id="delete"
                                                                                     name="<?php echo $_html['id'] ?>">
            </dd>

        </dl>
    </div>


</div>
</div>

<?php
require "includes/footer.inc.php";
?>
</body>
</html>