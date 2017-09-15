<?php
/**
 * @return mixed
 */

function _runtime()
{
    $_mtime = explode(' ', microtime());
    return $_mtime[1] + $_mtime[0];
}

/**
 * js弹窗函数
 * @access public
 * @param $_info
 */
function _alert_back($_info)
{
    echo "<script type='text/javascript'>alert('" . $_info . "');history.back();</script>";
    exit();
}


/**
 * 验证码函数
 * @param int $_width 长度
 * @param int $_height 宽度
 * @param int $_rnd_code 位数
 * @param bool $_flag 是否有边框
 */
function _code($_width = 75, $_height = 25, $_rnd_code = 4, $_flag = false)
{


    $_nmsg = '';
    for ($i = 0; $i < $_rnd_code; $i++) {

        $_nmsg .= dechex(mt_rand(0, 15));
    }
    $_SESSION['code'] = $_nmsg;
    echo $_SESSION['code'];
//随机码的个数


    ob_clean();
    header('Content-Type:image/png');

//创建一张图像

    $_img = imagecreatetruecolor($_width, $_height);

    $_white = imagecolorallocate($_img, 255, 255, 255);
    imagefill($_img, 0, 0, $_white);

    $_black = imagecolorallocate($_img, 0, 0, 0);

    if ($_flag) {
//黑色边框
        imagerectangle($_img, 0, 0, 74, 24, $_black);
    }

//随机画出6个线条
    for ($i = 0; $i < 6; $i++) {
        $_rnd_color = imagecolorallocate($_img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        imageline($_img, mt_rand(0, $_width), mt_rand(0, $_height), mt_rand(0, $_width), mt_rand(0, $_height), $_rnd_color);
    }

//随机打雪花
    for ($i = 0; $i < 100; $i++) {
        $_rnd_color = imagecolorallocate($_img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
        imagestring($_img, 1, mt_rand(1, $_width), mt_rand(1, $_height), '*', $_rnd_color);
    }

//输出验证码


    for ($i = 0; $i < strlen($_SESSION['code']); $i++) {
        $_rnd_color = imagecolorallocate($_img, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200));
        imagestring($_img, 5, $i * $_width / $_rnd_code + mt_rand(1, 10), mt_rand(1, 25 / 2), $_SESSION['code'][$i], $_rnd_color);
    }


    imagepng($_img);
    imagedestroy($_img);
}

/**
 * 字符串转义
 * @param $_string
 * @return string
 */
function _mysql_string($_string)
{
    $_conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD) or die('数据库链接失败');


    if (is_array($_string)) {
        foreach ($_string as $_key => $_value) {
            $_string[$_key] = _mysql_string($_value);           //递归用法
        }

    } else {
        return mysqli_real_escape_string($_conn, $_string);
    }


    return $_string;
}

/**
 * 验证码比对
 * @param $_first_code
 * @param $_end_code
 */
function _check_code($_first_code, $_end_code)
{
    if ($_first_code !== $_end_code) {
//        echo $_first_code;
        _alert_back('验证码不正确');
    }
}

function _sha1_uniqid()
{
    return _mysql_string(sha1(uniqid(rand(), true)));
}

function _location($_info, $_url)
{
    if (!empty($_info)) {
        echo "<script type='text/javascript'>alert('" . $_info . "');location.href='$_url';</script>";
        exit();
    } else {
        header('Location:' . $_url);
    }

}

/**
 * 登录状态的判断
 */
function _login_state()
{
    if (isset($_COOKIE['username'])) {
        _alert_back('登录状态无法进行本操作');
    }
}

/**
 * 删除session
 */
function _session_destroy()
{
    if (session_start() == true) {
        session_destroy();
    }
}


/**
 *删除cookies
 */
function _unsetcookies()
{
    setcookie('username', '', time() - 1);
    setcookie('uniqid', '', time() - 1);
    _session_destroy();
    _location(null, 'index.php');
}


/**
 * @param $_sql
 * @param $_size
 * $_page 当前的页数
 * $_pageabsolute 总页数
 * $_pagesize 每页显示的记录数
 */
function _page($_sql, $_size)
{
    global $_pagesize, $_pagenum, $_num, $_page, $_pageabsolute;
    if (isset($_GET['page'])) {
        $_page = $_GET['page'];
        if (empty($_page) || $_page < 0 || !is_numeric($_page)) {
            $_page = 1;
        } else {
            $_page = intval($_page);        //获取变量的整数值
        }
    } else {
        $_page = 1;
    }

    $_pagesize = $_size;
//得到所有的数据总和
    $_num = _num_rows(_query($_sql));
//    echo $_num;
    if ($_num == 0) {
        $_pageabsolute = 1;
    } else {
        $_pageabsolute = ceil($_num / $_pagesize);

    }
    if ($_page > $_pageabsolute) {
        $_page = $_pageabsolute;

    }

    $_pagenum = ($_page - 1) * $_pagesize;
}

/**
 * 分页函数
 * @param $_type
 */
function _paging($_type)
{
    global $_page, $_pageabsolute, $_num;

    if ($_type == 1) {

        echo '<div id="page_num">';
        echo '<ul>';

        for ($i = 1; $i <= $_pageabsolute; $i++) {
            if ($_page == $i) {
                echo ' <li><a href="' . SCRIPT . '.php?page=' . $i . '" class="selected">' . $i . '</a></li>';
            } else {
                echo ' <li><a href="' . SCRIPT . '.php?page=' . $i . '">' . $i . '</a></li>';
            }
        }

        echo '</ul>';
        echo '</div>';


    } elseif ($_type == 2) {

        echo '<div id = "page_text" >';
        echo '<ul >';
        echo '<li >' . $_page . '/' . $_pageabsolute . ' |&nbsp;</li>';
        echo '<li>共有<strong>'.$_num.'</strong>个记录 |&nbsp;</li>';

        if ($_page == 1) {
            echo '<li> 首页 | </li>';
            echo '<li> 上一页 | </li>';

        } else {
            echo '<li>&nbsp;<a href="' . SCRIPT . '.php">首页</a> |</li>';
            echo '<li>&nbsp;<a href="' . SCRIPT . '.php?page=' . ($_page - 1) . '">上一页</a> | </li>';
        }

        if ($_page == $_pageabsolute ) {
            echo '<li> 下一页 | </li>';
            echo '<li> 尾页 </li>';
        } else {
            echo '<li>&nbsp;<a href="' . SCRIPT . '.php?page=' . ($_page + 1) . '">下一页</a> | </li>';
            echo '<li>&nbsp;<a href="' . SCRIPT . '.php?page=' . $_pageabsolute . '"> 尾页</a></li>';
        }

        echo '</ul>';
        echo '</div>';
    }
}

/**
 * 字段内容按照数组或字符串过滤
 * @param $_string
 * @return array|string
 */
function _html($_string)
{
    if (is_array($_string)) {
        foreach ($_string as $_key => $_value) {
            $_string[$_key] = _html($_value);           //递归用法
        }

    } else {
        $_string = htmlspecialchars($_string);
    }
    return $_string;
}


/**
 * 判断标识符是否异常
 * @param $_mysql_uniqid
 * @param $_cookie_uniqid
 */
function _uniqid($_mysql_uniqid, $_cookie_uniqid)
{
    if ($_mysql_uniqid !== $_cookie_uniqid) {
        _alert_back('唯一标识符异常');
    }
}

function _alert_close($_info)
{
    echo "<script type='text/javascript'>alert('" . $_info . "');window.close();</script>";

}

function _title($_string)
{
    if (mb_strlen($_string, 'utf-8') > 14) {
        $_string = mb_substr($_string, 1, 14);
    }
    return $_string;
}