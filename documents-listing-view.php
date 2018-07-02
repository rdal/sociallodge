<?php

/**
 * Created by JetBrains PhpStorm.
 * User: rdal
 * Date: 9/9/15
 * Time: 18:52
 * To change this template use File | Settings | File Templates.
 */

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
    <link href="css/style-documents-listing.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="css/jPages.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="js/jPages.js"></script>
    <script language="javascript">
        /* when document is ready */
        $(function() {
            /* initiate plugin */
            $("div.holder").jPages({
                containerID: "itemContainer",
                perPage: 8
            });
        });
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
    <div class="middle-right">
        <div class="documents-listing">
            <div class="documents-listing-title">Documentos</div><hr>
            <div class="documents-listing-text">
                <!-- Item container (doesn't need to be an UL) -->
                <div id="itemContainer" style="margin-top: 15px;">
                    <!--<table width="685" style="margin-bottom: 15px;">
                        <tr><td width="22"><img src="images/avatar_mestre.gif"></td><td align="left"><a href="#">Assunto</a></td><td align="right">19/11/1999</td></tr>
                    </table>-->
                    <?php
                    $documents = $db->getDocuments();
                    foreach($documents as $document)
                    {
                        $filename = $document->getFilename();
                        $pieces = explode(".", $filename);
                        $cnt = count($pieces);
                        $extension = strtolower($pieces[$cnt-1]);

                        $icon_filename = "";
                        if($extension == "doc" || $extension == "docx"){
                            $icon_filename = "word-icon.png";
                        }
                        elseif($extension == "xls" || $extension == "xlsx"){
                            $icon_filename = "excel-icon.png";
                        }
                        elseif($extension == "ppt" || $extension == "pptx"){
                            $icon_filename = "powerpoint-icon.png";
                        }
                        elseif($extension == "pdf"){
                            $icon_filename = "pdf-icon.png";
                        }
                        elseif($extension == "jpeg" || $extension == "jpg" || $extension == "bmp" || $extension == "png"){
                            $icon_filename = "image-icon.png";
                        }


                        $name = utf8_encode($document->getName());
                        if(strlen($subject) > 80){
                            $subject = substr($subject, 0, 77)."...";
                        }
                        echo "<table width=\"685\" style=\"margin-bottom: 15px;\"><tr><td width=\"22\"><img src=\"images/".$icon_filename."\"></td><td align=\"left\"><a href=\"admin/documents/".$filename."\" target=\"_blank\">".$name."</a></td><td align=\"right\">".date('d/m/Y - G:i',strtotime($document->getDateAndTime()))."</td></tr></table>";
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