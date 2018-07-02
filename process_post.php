<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 17/04/15
 * Time: 13:50
 */

    if(session_id() == '') {
        session_start();
    }

    require_once('controllers/dbcontroller.php');

    $subject = utf8_decode($_REQUEST['subject']);
    $message = utf8_decode($_REQUEST['newComment']);
    $degreeId = $_REQUEST['degree_id'];
    $topicId = $_REQUEST['topic_id'];
    $ok = true;

    $db = new DBController();
    if(isset($topicId)){
        $ok = $db->updateTopic($topicId, $_SESSION['user_id'], $message);
    }
    else{
        $topicId = $db->insertNewTopic($_SESSION['user_id'], $degreeId, $subject, $message);
    }


    if($topicId != 0 && $ok){
        header("Location: topic-view.php?topic_id=".$topicId);
    }
    else
        echo "Falhou!";

?>