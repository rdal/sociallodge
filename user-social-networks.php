<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 18/05/15
 * Time: 13:39
 */

require_once('commons.php');
require_once('controllers/dbcontroller.php');
require_once('Util.php');

$commons = new Commons();
$commons->checkUserSession();

$db = new DBController();

$userId = $_SESSION['user_id'];
if(isset($userId)){

    $user = $db->getUser($userId);
    $name = utf8_encode($user->getName());
    $picture = utf8_encode($user->getProfilePicture());
    $degree = $db->getDegreeById($user->getDegreeId());

    $icon_filename = "";
    if($degree->getValue() == Util::ENTERED_APPRENTICE){
        $icon_filename = "apprentice-apron.png";
    }
    elseif($degree->getValue() == Util::FELLOW_CRAFT){
        $icon_filename = "fellow-craft-apron.png";
    }
    elseif($degree->getValue() == Util::MASTER_MASON){
        $icon_filename = "master-apron.png";
    }

    $socialNetworks = $db->getSocialNetworks();

?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Social Lodge</title>
        <link href="css/style-register-user.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            function submitform()
            {
                document.submitPost.submit();
            }
        </script>
    </head>

    <body>
    <div class="container" >
        <div class="top">
            <img src="images/sociallodge-logo.png">
        </div>
        <div class="left">
            <div class="profile-pic-container" >
                <!--<img src="images/default-profile-pic.jpg" height="100">-->
                <img src="<?="admin/users_pictures/".$user->getProfilePicture()?>" height="100">
            </div>
            <div class="apron-pic-container" >
                <img src="images/<?=$icon_filename?>" height="100">
            </div>
            <div class="left-menu">
                <ul>
                    <li><a href="javascript:history.back()">Voltar</a></li>
                    <li><a href="logoff.php">Sair</a></li>
                </ul>
            </div>
        </div>
        <div class="middle-right">
            <div class="user-register-frame">
                <div class="user-register-title"><?=$name?></div><hr>
                <div class="user-register-text">
                    <form id="submitPost" name="submitPost" action="process_user_social_networks.php" method="post">
<?php
                        foreach($socialNetworks as $socialNetwork)
                        {
                            $socialNetworkValue = $db->getSocialNetworkValueFromUser($userId, $socialNetwork->getId());
                            echo "<img src=\"images/".$socialNetwork->getIcon()."\" height=\"40\">&nbsp;<label for=\"SN_".$socialNetwork->getId()."\"><b>".$socialNetwork->getName().":</b></label>\n";
                            echo "<input id=\"SN_".$socialNetwork->getId()."\" name=\"SN_".$socialNetwork->getId()."\" type=\"text\" value=\"".$socialNetworkValue."\" style=\"width: 522px\">\n";
                        }
?>
                        <a class="btn" href="javascript: submitform()">Submeter</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </body>
    </html>
<?php
}

?>