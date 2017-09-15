<?php
/**
 * 花朵查阅
 * Created by PhpStorm.
 * User: 84532
 * Date: 2017/9/4
 * Time: 12:52
 */

session_start();

define('IN_TG', true);

define('SCRIPT', 'member_message');

require dirname(__FILE__) . '/includes/common.inc.php';


//判断是否登录
if (!isset($_COOKIE['username'])) {
    _alert_back('请先登录');
}


//批量删除花朵
if (isset($_GET['action']) && isset($_POST['ids'])) {
    if ($_GET['action'] == 'delete') {
        $_clean = array();
        $_clean['ids'] = _mysql_string(implode(',', $_POST['ids']));

        //当进行删除操作的时候要进行标识符验证

        if (!!$_rows2 = _fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")) {
            _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);

            _query("DELETE FROM tg_flower WHERE tg_id IN ({$_clean['ids']})");

            if (_affected_rows()) {
                mysqli_close($_conn);
                _session_destroy();
                _location('花朵删除成功', 'member_message.php');
            } else {
                mysqli_close($_conn);
                _session_destroy();
                _location('花朵删除失败', 'member_message.php');
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
_page("SELECT tg_id FROM tg_flower WHERE tg_touser='{$_COOKIE['username']}'", 3);

$username = _mysql_string($_COOKIE['username']);
$_result = _query("SELECT tg_id,tg_fromuser,tg_flower,tg_content,tg_date,tg_touser FROM tg_flower WHERE tg_touser='{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT " . $_pagenum . "," . $_pagesize)

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--花朵列表</title>

    <?php
    require ROOT_PATH . 'includes/title.inc.php'
    ?>

    <script src="js/member_message.js"></script>
</head>
<body>


<?php
require ROOT_PATH . 'includes/header.inc.php';
?>


<div id="member">

    <?php require ROOT_PATH . 'includes/member.inc.php' ?>

    <div id="member_main">
        <h2>花朵管理中心</h2>
        <form method="post" action="?action=delete">
            <table cellspacing="1">
                <tr>
                    <th>送花人</th>
                    <th>花朵数目</th>
                    <th>送花寄语</th>
                    <th>发送时间</th>
                    <th>操作</th>
                </tr>


                <?php
                $_html = array();
                while (!!$_rows = _fetch_array_list($_result)) {

                    $_html['id'] = $_rows['tg_id'];
                    $_html['fromuser'] = $_rows['tg_fromuser'];
                    $_html['content'] = $_rows['tg_content'];
                    $_html['flower'] = $_rows['tg_flower'];

                    $_html['date'] = $_rows['tg_date'];
                    @$_html['count'] += $_rows['tg_flower'];
                    $_html = _html($_html);



                    ?>
                    <tr>
                        <td><?php echo $_html ['fromuser'] ?></td>
                        <td><?php echo $_html ['flower'] ?></td>
                        <td><?php echo $_html['content']?></td>
                        <td><?php echo $_html ['date'] ?></td>
                        <td><input type="checkbox" name="ids[]" value="<?php echo $_html['id'] ?>"></td>
                    </tr>
                    <?php
                }
                _free_result($_result);
                ?>


                <tr>
                    <td colspan="5">共<?php echo $_html['count']?>朵花</td>
                </tr>

                <tr>
                    <td colspan="5">
                        <label for="all">全选
                            <input type="checkbox" name="chkall" id="all">
                            <input type="submit" value="批量删除">
                        </label>
                    </td>
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