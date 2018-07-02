<?php

    require_once('controllers/dbcontroller.php');

    $potencia = $_REQUEST['potencia'];

    $login = $_REQUEST['login'];
    $password = md5($_REQUEST['password']);

    $db = new DBController();
    $user = $db->login($potencia, $login, $password);

    if(is_null($user))
    {
        header("Location: login.php?err=-1");
    }
    else
    {
        if(session_id() == '') {
            session_start();
        }

        $degree = $db->getDegreeById($user->getDegreeId());

        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_degree_value'] = $degree->getValue();
        $_SESSION['user_lodge_id'] = $user->getLodgeId();

        $roles = $db->getRoles($user->getId(), $user->getLodgeId());
        if($roles["worshipful_master_user_id"]){
            $_SESSION['lodge_id_as_admin'] = $user->getLodgeId();
            $_SESSION['worshipful_master'] = true;
            $_SESSION['loggedin_as_admin'] = true;
        }
        if($roles["senior_warden_user_id"]){
            $_SESSION['lodge_id_as_admin'] = $user->getLodgeId();
            $_SESSION['senior_warden'] = true;
            $_SESSION['loggedin_as_admin'] = true;
        }
        if($roles["junior_warden_user_id"]){
            $_SESSION['lodge_id_as_admin'] = $user->getLodgeId();
            $_SESSION['junior_warden'] = true;
            $_SESSION['loggedin_as_admin'] = true;
        }
        if($roles["orator_user_id"]){
            $_SESSION['lodge_id_as_admin'] = $user->getLodgeId();
            $_SESSION['orator'] = true;

        }
        if($roles["secretary_user_id"]){
            $_SESSION['lodge_id_as_admin'] = $user->getLodgeId();
            $_SESSION['secretary'] = true;
        }
        if($roles["treasurer_user_id"]){
            $_SESSION['lodge_id_as_admin'] = $user->getLodgeId();
            $_SESSION['treasurer'] = true;
        }
        if($roles["hospitable_user_id"]){
            $_SESSION['lodge_id_as_admin'] = $user->getLodgeId();
            $_SESSION['hospitable'] = true;
        }
        if($roles["chancellor_user_id"]){
            $_SESSION['lodge_id_as_admin'] = $user->getLodgeId();
            $_SESSION['chancellor'] = true;
        }

        header("Location: lodge-main.php");
    }

?>
