<?php
require_once('commons.php');
require_once('controllers/dbcontroller.php');

$commons = new Commons();
$commons->checkUserSession();

if(isset($_POST['user_lodge_id']))
{
    $_SESSION['user_lodge_id'] = $_POST['user_lodge_id'];
}

$db = new DBController();
$currentLodge = $db->getLodgeById($_SESSION['user_lodge_id']);

$topicId = $_REQUEST['topic_id'];
$subject = "Novo T&oacute;pico";
if(isset($topicId)){
    $topic = $db->getTopic($topicId);
    if(!is_null($topic))
    {
        $subject = utf8_encode($topic->getSubject());
        $topicMessages = $db->getTopicMessages($topicId);
        $topicIdInputHidden = "<input type=\"hidden\" name=\"topic_id\" value=\"".$topicId."\">";
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Social Lodge</title>
        <link href="css/style-topic.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            function submitform(noSubject)
            {
                if((typeof noSubject === 'undefined') && (document.submitPost.subject.value == null || document.submitPost.subject.value == "")){
                    alert('O assunto está vazio!');
                }
                else if(document.submitPost.newComment.value == null || document.submitPost.newComment.value == ""){
                    alert('A mensagem está vazia!');
                }
                else{
                    document.submitPost.submit();
                }

            }
        </script>
        <script src="js/jquery-1.11.3.min.js"></script>
        <script src="js/util.js"></script>
        <script language="javascript">

            function changeLodge() {
                var lodgeId = document.getElementById("comboboxLodge").value;
                post_to_url('<?="http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']?>', {'user_lodge_id':lodgeId});
            }
        </script>
    </head>

    <body>
        <div class="container" >
            <div class="top">
                <img src="images/sociallodge-logo.png">
			</div>
<?php
include("left_menu.inc")
?>
			<div class="middle">


                <div class="topic-title"><?=$subject?></div><hr>
                <form id="submitPost" name="submitPost" action="process_post.php" method="post">
                    <?=$topicIdInputHidden?>
<?php
    if(empty($topicMessages))
    {
        echo "<b>Assunto</b><br><input id=\"subject\" type=\"text\" name=\"subject\" style=\"width: 715px; min-width:715px; max-width:715px;\" />";
    }
?>
                    <table>
<?php


    if(!empty($topicMessages))
    {
        foreach($topicMessages as $topicMessage)
        {
            $user = $db->getUser($topicMessage->getUserId());
?>
                        <tr>
                            <td align="center">
                                <div class="avatar"><img src="<?="admin/users_pictures/".$user->getProfilePicture()?>" height="100" style="position: relative; left: 100%; margin-left: -200%;"></div>
                                <a href="user-profile.php?user_id=<?=$user->getId()?>"><?=utf8_encode($user->getName())?></a>
                            </td>
                            <td align="justify">
                                <div class="topic-cell-no-height"><?=utf8_encode($topicMessage->getMessage())?></div>
<?php
            if($topicMessage->getUserId() == $_SESSION['user_id'])
            {
?>
                                <a href="delete_topic_message.php?topic_message=<?=$topicMessage->getId()?>" style="margin-left: 10px;">Excluir</a>
<?php
            }
?>
                            <td>
                        </tr>
<?php
        }
    }
?>
                        <tr>
                            <td align="justify" colspan="2" style="border: 1px solid #A1A1A1;">
                                <b>Mensagem</b><br><textarea id="newComment" name="newComment" style="resize: none; width: 715px; min-width:715px; max-width:715px; height:110px; min-height:110px; max-height:110px;"></textarea>
                            </td>
                        </tr>
                        <tr>
<?php
    if(empty($topicMessages)){
        $degrees = array();
        $degrees = $db->getDegrees();
        echo "<td style=\"padding-top: 2px; width: 94px;\"><a class=\"btn\" href=\"javascript: submitform()\">Submeter</a></td><td align=\"left\">";
        echo "<select name=\"degree_id\">";
        foreach($degrees as $degree){
            echo "<option value=\"".$degree->getId()."\">".$degree->getName()."</option>";
        }
        echo "</select>";
    }
    else{
        echo "<td style=\"padding-top: 2px; width: 94px;\"><a class=\"btn\" href=\"javascript: submitform(true)\">Submeter</a></td><td align=\"left\">";
    }
?>
                            </td>
                        </tr>
                    </table>
                </form>
			</div>
        </div>
    </body>
</html>
