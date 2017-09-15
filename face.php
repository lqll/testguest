<?php

define('IN_TG',true);

define('SCRIPT','face');
require dirname(__FILE__).'/includes/common.inc.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>多用户留言系统-头像选择</title>
    <?php
    require ROOT_PATH.'includes/title.inc.php';
    ?>

    <script type="text/javascript" src="js/onener.js"></script>
</head>

<body>
<div id="face">
    <h3>选择头像</h3>
    <dl>
        <?php foreach (range(1,20) as $number){?>
        <dd><img src="face/<?php echo $number?>.png" alt="face/<?php echo $number?>.png" title="头像<?php echo $number?>" style="width: 80px" ></dd>
        <?php }?>
<!---->
<!--        --><?php //foreach (range(10,19) as $number){?>
<!--            <dd><img src="face/--><?php //echo $number?><!--.png" alt="头像1" style="width: 80px"></dd>-->
<!--        --><?php //}?>

    </dl>
</div>

</body>
</html>