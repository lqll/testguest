<?php
/**
 * 好友管理页面
 * Created by PhpStorm.
 * User: 84532
 * Date: 2017/9/4
 * Time: 12:52
 */

//session_start();
//博友界面
define('IN_TG', true);

define('SCRIPT', 'member_friend');

require dirname(__FILE__) . '/includes/common.inc.php';


//判断是否登录
if (!isset($_COOKIE['username'])) {
    _alert_back('请先登录');
}

//点击验证好友
if(isset($_GET['action']) && isset($_GET['id'])){
    if($_GET['action'] == 'check' && isset($_GET['id'])){
        //敏感操作验证
        if (!!$_rows2 = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
            _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);

            _query("UPDATE tg_friend SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
            if (_affected_rows()) {
                mysqli_close($_conn);
                session_destroy();
                _location('验证通过', 'member_friend.php');
            } else {
                mysqli_close($_conn);
                _session_destroy();
                _location('验证失败', 'member_friend.php');
            }


        }else{
            _alert_back('非法操作');
        }
    }
}


//批量删除好友
if (isset($_GET['action']) && isset($_POST['ids'])) {
    if ($_GET['action'] == 'delete') {
        $_clean = array();
        $_clean['ids'] = _mysql_string(implode(',', $_POST['ids']));

        //当进行删除操作的时候要进行标识符验证

        if (!!$_rows2 = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
            _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);

            _query("DELETE FROM tg_friend WHERE tg_id IN ({$_clean['ids']})");

            if (_affected_rows()) {
                mysqli_close($_conn);
                session_destroy();
                _location('好友删除成功', 'member_message.php');
            } else {
                mysqli_close($_conn);
                _session_destroy();
                _location('好友删除失败', 'member_message.php');
            }
            exit();

        } else {
            _alert_back('非法登录');
        }


        exit();
    }

}


//分页
/**
 * $_pagesize 每页的记录条数
 * $_pagenum
 */
global $_pagesize, $_pagenum, $_num;
_page("SELECT tg_id FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}' OR tg_fromuser='{$_COOKIE['username']}'", 3);

$username = _mysql_string($_COOKIE['username']);
$_result = _query("SELECT tg_id,tg_fromuser,tg_state,tg_content,tg_date,tg_touser FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}' OR  tg_fromuser='{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT " . $_pagenum . "," . $_pagesize)

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--好友设置</title>

    <?php
    require ROOT_PATH . 'includes/title.inc.php'
    ?>

    <script src="js/member_friend.js"></script>
</head>
<body>


<?php
require ROOT_PATH . 'includes/header.inc.php';
?>


<div id="member">

    <?php require ROOT_PATH . 'includes/member.inc.php' ?>

    <div id="member_main">
        <h2>好友设置中心</h2>
        <form method="post" action="?action=delete">
            <table cellspacing="1">
                <tr>
                    <th>好友</th>
                    <th>请求内容</th>
                    <th>请求时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                <?php
                $_html = array();

                while (!!$_rows = _fetch_array_list($_result)) {

                    $_html['id'] = $_rows['tg_id'];
                    $_html['fromuser'] = $_rows['tg_fromuser'];
                    $_html['touser'] = $_rows['tg_touser'];
//                    $_html['state'] = $_rows['tg_state'];
                    $_html['content'] = $_rows['tg_content'];
                    $_html['date'] = $_rows['tg_date'];
                    $_html = _html($_html);

                    if ($_html['touser'] == $_COOKIE['username']) {
                        if (empty($_rows['tg_state'])) {
                            $_html['state'] = '<a href="?action=check&id='.$_html['id'].'">对方请求加好友</a>';
                            $_html['content_html'] = '<strong>' . _title($_rows['tg_content']) . '</strong>';
                        } else {
                            $_html['state'] = '<span  style="color: green">已同意加对方为好友</span>';

                            $_html['content_html'] = _title($_rows['tg_content']);
                        }
                        $_html['friend'] = $_html['fromuser'];
                    } elseif ($_html['fromuser'] == $_COOKIE['username']) {
                        if (empty($_rows['tg_state'])) {
                            $_html['state'] = '<span style="color: red;">等待对方验证</span>';
                            $_html['content_html'] = '<strong>' . _title($_rows['tg_content']) . '</strong>';

                        } else {
                            $_html['state'] = '<span  style="color: green">对方已同意</span>';

                            $_html['content_html'] = _title($_rows['tg_content']);
                        }

                        $_html['friend'] = $_html['touser'];
                    }


                    ?>
                    <tr>
                        <td><?php echo $_html ['friend'] ?></td>
                        <td><?php echo _title($_html['content']) ?></td>
                        <td><?php echo $_html ['date'] ?></td>
                        <td><?php echo $_html['state'] ?></td>
                        <td><input type="checkbox" name="ids[]" value="<?php echo $_html['id'] ?>"></td>
                    </tr>
                    <?php
                }
                _free_result($_result);
                ?>
                <tr>
                    <td colspan="5"><label for="all">全选 <input type="checkbox" name="chkall" id="all"><input
                                    type="submit" value="批量删除"></label></td>
                </tr>
            </table>
        </form>

        <?php _paging(1) ?>
        <?php _paging(2) ?>


    </div>
</div>

<?php
require "includes/footer.inc.php";
?>
</body>
</html>