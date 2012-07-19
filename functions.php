<?php

session_start();
include_once 'config.inc.php';

//Admin
function admin_top($title) {
    include '../templates/admin_head.php';
}

function admin_footer() {
    include '../templates/admin_footer.php';
}
//Site structure
function top($title)
{
    include 'templates/head.php';
}
function template($template) {
    if($template=='construction') {
        include 'templates/construction.php';
    }
}
function footer()
{
    include 'templates/footer.php';
}
//MySQL
function query($query)
{
    return mysql_query($query);
}
function assoc($query) {
    $row = mysql_fetch_assoc($query);
    if(is_array($row)) {
        foreach($row as $key=>$value) {
            $return[$key]=trim(stripslashes($value));
        }
        return $return;
    }
}
//Security
function escape($string, $type='full') {
    $escaped = htmlspecialchars($string);
    if($type=='full') {
        $escaped = mysql_real_escape_string($escaped);
    }
    elseif($type=='nohtml') {
        $escaped = mysql_real_escape_string($string);
    }
    elseif($type=='nomysql') {
        $escaped = addslashes($string);
    }
    return $escaped;
}
function strip_str_lines($string) {
    return str_replace('|', '', $string);
}
function password($password) {
    //$c_pass = hash_hmac('SHA256', $password, 'secret');
    $c_pass = md5($password);
    return $c_pass;
}
//Messages
function note($msg)
{
    echo '<div class="error">'.$msg.'</div><br />';
}
function alert($msg)
{
    echo '<script type="text/javascript">alert("'.$msg.'")</script>';
}
//Redirect
function redirect($link) {
    ob_start();
    header('Location: ' . $link);
    die;
}
//Development
function dump_var($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
function search_string($string,$what) {
    $pos = strpos($string,$what);
    if ($pos !== false) {
        return true;
    } else {
        return false;
    }
}
function rr($link){
    header('location:'.$link);
}
?>