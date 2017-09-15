<?php
/**
 * Created by PhpStorm.
 * User: 84532
 * Date: 2017/8/15
 * Time: 16:03
 */

if (!defined('IN_TG')){
    exit ('非法调用');
}

mysqli_close($_conn);
?>

<div id="footer">
    <p>本程序执行耗时<?php
        $_end_time = _runtime();
        echo $_end_time - $_strt_time;?>秒</p>
    <p>版权所有 翻版必究</p>
    <p>本程序由浪去郎来提供 源代码可以任意修改或发布</p>
</div>
