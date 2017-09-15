<?php
if (!defined('IN_TG')){
    exit ('非法调用');
}




/**
 * 链接mysql数据库
 */
function _connect(){
    global $_conn;
    if(!$_conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD)){
        exit('数据库链接失败');
    }
}

/**
 * 选择一个数据库
 */
function _select_db(){
    if (!mysqli_select_db($GLOBALS['_conn'],DB_NAME)){
        exit('找不到指定的数据库');
    }
}

function _set_names(){
    if(!mysqli_query($GLOBALS['_conn'],'SET NAMES UTF8')){
        exit('字符集错误');
    }
}

function _query($_sql){
    if(!$result = mysqli_query($GLOBALS['_conn'],"$_sql")){
        exit('sql语句执行失败'.mysqli_error($GLOBALS['_conn']));
    }
    return $result;
}

function _fetch_array($_sql){
    return mysqli_fetch_array(_query($_sql),MYSQLI_ASSOC);
}

function _is_repeat($_sql,$_info){
    if(_fetch_array($_sql)){
        _alert_back($_info);
    }
}

function _affected_rows(){
    return mysqli_affected_rows($GLOBALS['_conn']);
}

function _close(){
    mysqli_close($GLOBALS['_conn']);
}

function _fetch_array_list($_result){
    return mysqli_fetch_array($_result,MYSQLI_ASSOC);       //函数从结果集中取得一行作为关联数组，或数字数组

}


function _num_rows($result){
    return mysqli_num_rows($result);
}

/**
 * 销毁结果集
 * @param $_result
 */
function _free_result($_result){
    mysqli_free_result($_result);
}
