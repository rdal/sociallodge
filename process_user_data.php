<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 12/05/15
 * Time: 13:05
 */

    if(session_id() == '') {
        session_start();
    }

    require_once('controllers/dbcontroller.php');

    $name = utf8_decode($_REQUEST['name']);
    $email = utf8_decode($_REQUEST['email']);
    $password = utf8_decode($_REQUEST['password']);
    $confirm_password = utf8_decode($_REQUEST['confirm_password']);
    $address = utf8_decode($_REQUEST['address']);
    $phone = utf8_decode($_REQUEST['phone']);
    $mobile = utf8_decode($_REQUEST['mobile']);
    $webpage = utf8_decode($_REQUEST['webpage']);
    $aboutme = utf8_decode($_REQUEST['aboutme']);

    $db = new DBController();
    $ok = $db->updateUserData($name, $email, $password, $address, $phone, $mobile, $webpage, $aboutme);

    if($ok){
        header("Location: user-register.php");
    }
    else
        echo "Falhou!";

?>