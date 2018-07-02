<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rdal
 * Date: 21/7/15
 * Time: 23:16
 * To change this template use File | Settings | File Templates.
 */

require_once('controllers/dbcontroller.php');

if(isset($_REQUEST['topic_message']))
{
    $topicMessageId = $_REQUEST['topic_message'];
    $db = new DBController();
    $ok = $db->deleteTopicMessage($topicMessageId);

    if($ok){
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    else{
        echo "Falhou!";
    }
}
else{
    echo "FalhouQ!";
}

?>