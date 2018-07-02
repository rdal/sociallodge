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

$newsId = $_REQUEST['news_id'];
$subject = "Novo Not&iacute;cia";
if(isset($newsId)){
    $n = $db->getNewsById($newsId);
//    var_dump($n);die();
    $subject = utf8_encode($n->getSubject());
    $contents = utf8_encode($n->getContents());
    $newsIdInputHidden = "<input type=\"hidden\" name=\"news_id\" value=\"".$newsId."\">";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Social Lodge</title>
    <link href="css/style-news.css" rel="stylesheet" type="text/css" />
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


        <div class="news-title"><?=$subject?></div><hr><br>
        <div class="news-text">
            <?=$contents?>
        </div>
    </div>
</div>
</body>
</html>
