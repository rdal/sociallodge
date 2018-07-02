<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rdal
 * Date: 7/6/15
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

if(session_id() == '') {
    session_start();
}

unset($_SESSION['loggedin']);
unset($_SESSION['user_id']);
unset($_SESSION['user_lodge_id']);
session_destroy();

$path = $_SERVER['HTTP_REFERER'];
$pieces = explode("/", $path);
$count_pieces = count($pieces);
unset($pieces[$count_pieces-1]);
$path = implode("/",$pieces);

header('Location: '.$path.'/index.php');

?>