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
        <link href="css/style-topics-listing.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="css/jPages.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="js/jPages.js"></script>
        <script language="javascript">
            /* when document is ready */
            $(function() {
                /* initiate plugin */
                $("div.holder").jPages({
                    containerID: "itemContainer"
                });
            });
        </script>
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
			<div class="middle-right">
			    <div class="topics-listing">
				    <div class="topics-listing-title">T&oacute;picos</div><hr>
                    <div class="topics-listing-text">
                        <!-- Item container (doesn't need to be an UL) -->
                        <div id="itemContainer" style="margin-top: 15px;">
                            <!--<table width="685" style="margin-bottom: 15px;">
                                <tr><td width="22"><img src="images/avatar_mestre.gif"></td><td align="left"><a href="#">Assunto</a></td><td align="right">19/11/1999</td></tr>
                            </table>-->
<?php
                        $topics = $db->getTopics();
                        foreach($topics as $topic)
                        {
                            $degree = $db->getDegreeById($topic->getDegreeId());
                            if($_SESSION['user_degree_value'] >= $degree->getValue())
                            {
                                $icon_filename = "";
                                if($degree->getValue() == Util::ENTERED_APPRENTICE){
                                    $icon_filename = "avatar_aprendiz.gif";
                                }
                                elseif($degree->getValue() == Util::FELLOW_CRAFT){
                                    $icon_filename = "avatar_companheiro.gif";
                                }
                                elseif($degree->getValue() == Util::MASTER_MASON){
                                    $icon_filename = "avatar_mestre.gif";
                                }


                                $subject = utf8_encode($topic->getSubject());
                                if(strlen($subject) > 80){
                                    $subject = substr($subject, 0, 77)."...";
                                }
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                                echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"topic-view.php?topic_id=".$topic->getId()."\">".$subject."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($topic->getDateUpdated()))."</td></tr></table>";
                            }
                        }
?>
                        </div>
                    </div>
                    <!-- Future navigation panel -->
                    <div class="holder"></div>
                </div>
			</div>
        </div>
    </body>
</html>