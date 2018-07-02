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
    <link href="css/style-news-listing.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="css/jPages.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="js/jPages.js"></script>
    <script src="js/util.js"></script>
    <script language="javascript">
        /* when document is ready */
        $(function() {
            /* initiate plugin */
            $("div.holder").jPages({
                containerID: "itemContainer"
            });
        });
    </script>
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
        <div class="news-listing">
            <div class="news-listing-title">T&oacute;picos</div><hr>
            <div class="news-listing-text">
                <!-- Item container (doesn't need to be an UL) -->
                <div id="itemContainer">
                    <!--<table width="685" style="margin-bottom: 15px;">
                        <tr><td width="22"><img src="images/avatar_mestre.gif"></td><td align="left"><a href="#">Assunto</a></td><td align="right">19/11/1999</td></tr>
                    </table>-->
                    <?php
                    $news = $db->getNews();
                    foreach($news as $n){

                        $subject = utf8_encode($n->getSubject());
                        if(strlen($subject) > 45){
                            $subject = substr($subject, 0, 42)."...";
                        }
                        echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td align=\"left\">&bull;&nbsp;<a href=\"news-view.php?news_id=".$n->getId()."\">".$subject."</a></td><td align=\"right\" style=\"padding-bottom:10px;\">".date('d/m/Y - G:i',strtotime($n->getDateUpdated()))."</td></tr></table>";

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