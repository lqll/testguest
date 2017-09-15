<?php

session_start();

//博友界面
define('IN_TG', true);

define('SCRIPT', 'blog');

require dirname(__FILE__) . '/includes/common.inc.php';

?>
<html>
<head>

    <title>博友</title>

    <?php
    require ROOT_PATH . 'includes/title.inc.php'
    ?>
    <script type="text/javascript" src="js/blog.js"></script>

</head>

<body>

<?php
require ROOT_PATH . 'includes/header.inc.php';

global $_pagesize, $_pagenum;
_page('SELECT tg_id FROM tg_user', 10);

//从数据库提取数据
$_result = _query('SELECT tg_id,tg_username,tg_face,tg_sex FROM tg_user ORDER BY tg_reg_time DESC LIMIT ' . $_pagenum . ',' . $_pagesize)
?>

<div id="blog">
    <h2>博友列表</h2>

    <?php
//    print_r( _fetch_array_list($_result));
    $_rows = array();
    ?>
    <?php while (!!$_rows = _fetch_array_list($_result)) {
        $_html = array();
        $_html['id'] = $_rows['tg_id'];
        $_html['username'] = $_rows['tg_username'];
        $_html['face'] = $_rows['tg_face'];
        $_html['sex'] = $_rows['tg_sex'];
        $_html = _html($_html);
        ?>


        <dl>
            <dd class="user"><?php echo $_html['username'] ?>(<?php echo $_html['sex'] ?>)</dd>
            <dt><img src="<?php echo $_html['face'] ?>" alt="国勇"></dt>
            <dd><a href="javascript:;" name="message" title="<?php echo $_html['id'] ?>">发消息</a></dd>
            <dd><a href="javascript:;" name="friend" title="<?php echo $_html['id'] ?>">加为好友</a></dd>



            <dd>写留言</dd>
            <dd><a href="javascript:;" name="flower" title="<?php echo $_html['id'] ?>">给她送花</a></dd>
        </dl>
        <?php

    }

    _free_result($_result); ?>


    <?php _paging(1) ?>
    <?php _paging(2) ?>


</div>


<?php
require "includes/footer.inc.php";

?>
</body>
</html>
