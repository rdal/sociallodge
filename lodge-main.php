<?php
require_once('commons.php');
require_once('controllers/dbcontroller.php');
require_once('Util.php');

$commons = new Commons();
$commons->checkUserSession();

if(isset($_POST['user_lodge_id']))
{
    $_SESSION['user_lodge_id'] = $_POST['user_lodge_id'];
}

$db = new DBController();
$currentLodge = $db->getLodgeById($_SESSION['user_lodge_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Social Lodge</title>
        <link href="css/style-lodge.css" rel="stylesheet" type="text/css" />
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
			    <div class="about-lodge"><br>
				    <div class="about-lodge-title">Sobre <?=utf8_encode($db->getLodgeName())?></div><hr>
				    <div class="about-lodge-text" id="scroll"><?=utf8_encode($currentLodge->getDescription())?></div>
                </div>
<?php
if($_SESSION['loggedin'] && !$_SESSION['governing_body_user'])
{
?>
				<div class="topics">
				    <div class="topics-title">T&oacute;picos</div><hr>
				    <!--<div class="topics-text"><div style="vertical-align:middle;display:table-cell;padding-right:5px;"><img src="images/avatar_companheiro.gif"></div><div style="vertical-align:middle;display:table-cell;text-align:justify;"><a href="topic-view.html">Apresenta&ccedil;&atilde;o na Sess.'. de hoje</a></div><br><div style="vertical-align:middle;display:table-cell;padding-right:5px;"><img src="images/avatar_aprendiz.gif"></div><div style="vertical-align:middle;display:table-cell;text-align:justify;"><a href="topic-view.html">Visita ao orfanato</a></div><br><div style="vertical-align:middle;display:table-cell;padding-right:5px;"><img src="images/avatar_mestre.gif"></div><div style="vertical-align:middle;display:table-cell;text-align:justify;"><a href="topic-view.html">Inicia&ccedil;&atilde;o de Profano</a></div><br><div style="vertical-align:middle;display:table-cell;padding-right:5px;"><img src="images/avatar_aprendiz.gif"></div><div style="vertical-align:middle;display:table-cell;text-align:justify;"><a href="topic-view.html">Apoio ao candidato Sicrano para vereador</a></div></div>-->
                    <div class="topics-text">
                        <table width="420">
<?php
    $topics = $db->getRecentTopics($_SESSION['user_degree_value']);
    foreach($topics as $topic){

        $icon_filename = "";
        $degree = $db->getDegreeById($topic->getDegreeId());
        if($degree->getValue() == Util::ENTERED_APPRENTICE){
            $icon_filename = "avatar_aprendiz.gif";
        }
        elseif($degree->getValue() == Util::FELLOW_CRAFT){
            $icon_filename = "avatar_companheiro.gif";
        }
        elseif($degree->getValue() == Util::MASTER_MASON){
            $icon_filename = "avatar_mestre.gif";
        }


        //echo "<div style=\"margin-top:20px;vertical-align:middle;display:table-cell;padding-right:5px;\"><img src=\"images/".$icon_filename."\"></div><div style=\"vertical-align:middle;display:table-cell;text-align:justify;\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".utf8_encode($topic->getSubject())."</a></div><div style=\"vertical-align:middle;display:table-cell;text-align:justify;float:right;\">12/11/1999</div><br>";
        $subject = utf8_encode($topic->getSubject());
        if(strlen($subject) > 45){
            $subject = substr($subject, 0, 42)."...";
        }
        echo "<tr><td><img src=\"images/".$icon_filename."\"></td><td><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr>";
    }
?>
                        </table>
                    </div>
					<div class="topics-more"><hr><table width="410"><tr><td align="left"><a href="topics-listing-view.php">Mais ...</a></td><td align="right" style="padding-top: 2px;"><a href="topic-view.php" class="btn">Novo Tópico</a></td></tr></table></div>
                </div>
<?php
}
?>
				<div class="news">
				    <div class="news-title">Not&iacute;cias</div><hr>
				    <div class="news-text">
                        <table width="420">
                            <!-- <div style="margin-top:5px">&bull;&nbsp;<a href="#">Apresenta&ccedil;&atilde;o do GEAP</a></div><br><div>&bull;&nbsp;<a href="#">Assine a peti&ccedil;&atilde;o pelo fim da impunidade</a></div><br><div>&bull;&nbsp;<a href="#">Palestra agendada para o dia 01/04 com Eduardo Campos</a></div><br><div>&bull;&nbsp;<a href="#">XIX Jornada Ma&ccedil;&ocirc;nica de S&atilde;o Paulo</a></div> -->

<?php
    $news = $db->getRecentNews();
    foreach($news as $n)
    {
        $subject = utf8_encode($n->getSubject());
        if(strlen($subject) > 45){
            $subject = substr($subject, 0, 42)."...";
        }
        echo "<tr><td style=\"padding-bottom:10px;\">&bull;&nbsp;<a href=\"news-view.php?news_id=".$n->getId()."\">".$subject."</a></td><td align=\"right\" style=\"padding-bottom:10px;\">".date('d/m/Y - G:i',strtotime($n->getDateUpdated()))."</td></tr>";
    }
?>
                        </table>
                    </div>
					<div class="news-more"><hr><a href="news-listing-view.php">Mais ...</a></div>
                </div>
			</div>

			<div class="right" id="scroll">
			    <div class="right-title">Membros</div><hr>
				<table>
                    <!--<tr>
                        <td align="center">
                            <img src="images/default-profile-pic.jpg" height="100">
                        </td>
                        <td align="center">
                            <img src="images/default-profile-pic.jpg" height="100">
                        <td>
                    </tr>
                    <tr>
                        <td align="center">
                            <a href="user-profile.html">Fulano de Tal da Silva Xavier</a>
                        </td>
                        <td align="center">
                            <a href="user-profile.html">Fulano de Tal da Silva Xavier</a>
                        </td>
                    </tr>-->
<?php
    $users = $db->getLodgeUsers($_SESSION['user_lodge_id']);
    $count = count($users);
    if($count > 0){
        echo "<tr><td colspan=\"2\" align=\"center\"><b><hr>Efetivos<hr></b></td></tr>";

        for($i=0; $i<$count; $i+=2){
            echo "<tr>";
            echo "<td align=\"center\"><div class=\"avatar\"><img src=\"admin/users_pictures/".$users[$i]->getProfilePicture()."\" height=\"100\" style=\"position: relative; left: 100%; margin-left: -200%; \"></div></td>";
            if($i+1<$count){echo "<td align=\"center\"><div class=\"avatar\"><img src=\"admin/users_pictures/".$users[$i+1]->getProfilePicture()."\" height=\"100\" style=\"position: relative; left: 100%; margin-left: -200%; \"></div></td>";}
            echo "</tr>";
            echo "<tr>";
            echo "<td align=\"center\"><a href=\"user-profile.php?user_id=".$users[$i]->getId()."\">".utf8_encode($users[$i]->getName())."</a></td>";
            if($i+1<$count){echo "<td align=\"center\"><a href=\"user-profile.php?user_id=".$users[$i+1]->getId()."\">".utf8_encode($users[$i+1]->getName())."</a></td>";}
            echo "</tr>";
        }

        echo "<tr><td colspan=\"2\" align=\"center\"><br><br></td></tr>";
    }

    $members = $db->getMembersFromLodgeId($_SESSION['user_lodge_id']);
    $countMembers = count($members);
    if($countMembers > 0){
        echo "<tr><td colspan=\"2\" align=\"center\"><b><hr>Convidados<hr></b></td></tr>";

        for($i=0; $i<$countMembers; $i+=2){
            echo "<tr>";
            echo "<td align=\"center\"><div class=\"avatar\"><img src=\"admin/users_pictures/".$members[$i]->getProfilePicture()."\" height=\"100\" style=\"position: relative; left: 100%; margin-left: -200%; \"></div></td>";
            if($i+1<$countMembers){echo "<td align=\"center\"><div class=\"avatar\"><img src=\"admin/users_pictures/".$members[$i+1]->getProfilePicture()."\" height=\"100\" style=\"position: relative; left: 100%; margin-left: -200%; \"></div></td>";}
            echo "</tr>";
            echo "<tr>";
            echo "<td align=\"center\"><a href=\"user-profile.php?user_id=".$members[$i]->getId()."\">".utf8_encode($members[$i]->getName())."</a></td>";
            if($i+1<$countMembers){echo "<td align=\"center\"><a href=\"user-profile.php?user_id=".$members[$i+1]->getId()."\">".utf8_encode($members[$i+1]->getName())."</a></td>";}
            echo "</tr>";
        }
    }
?>
				</table>
			</div>
        </div>
    <?php /*include "chat.php";*/ ?>
    </body>
</html>
