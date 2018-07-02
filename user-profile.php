<?php
require_once('commons.php');
require_once('controllers/dbcontroller.php');
require_once('Util.php');

$commons = new Commons();
$commons->checkUserSession();

$db = new DBController();

$userId = $_REQUEST['user_id'];
if(isset($userId)){
    $user = $db->getUser($userId);
    $name = utf8_encode($user->getName());
    $picture =utf8_encode($user->getProfilePicture());
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
    $about =utf8_encode($user->getAboutme());

    $socialNetworkInstances = $db->getSocialNetworkInstances($userId);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Social Lodge</title>
        <link href="css/style-profile.css" rel="stylesheet" type="text/css" />
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
			    <div class="about-member">
				    <div class="about-member-title"><?=$name?></div><hr>
				    <div class="about-member-text" id="scroll"><?=$about?></div>
                </div>
				<div class="user-webpage">
				    <div class="user-webpage-title">P&aacute;gina Web</div><hr>
				    <div class="user-webpage-text" id="scroll"><a href="<?=$user->getWebpage()?>"><?=$user->getWebpage()?></a></div>
                </div>
				<div class="user-social-networks">
				    <div class="user-social-networks-title">Redes Sociais</div><hr>
				    <div id="sn-icons" class="user-social-networks-contents" id="scroll">
					    <!--<a href="#"><img src="images/facebook-icon.png" height="40"></a>
					    <a href="#"><img src="images/twitter-icon.png" height="40"></a>
						<a href="#"><img src="images/instagram-icon.png" height="41"></a>
						<a href="#"><img src="images/linkedin-icon.png" height="39"></a>-->
<?php
                        foreach($socialNetworkInstances as $socialNetworkInstance)
                        {
                            echo "<a href=\"".$socialNetworkInstance->getLink()."\" target=\"_blank\"><img src=\"images/".$socialNetworkInstance->getSocialNetworkIcon()."\" height=\"40\">";
                        }
?>
					</div>
                </div>
				<!--<div class="user-media">
				    <div class="user-media-title">Multim&iacute;dia</div><hr>
				    <div id="media-icons" class="user-media-contents" id="scroll">
					    <a href="albums-listing-view.php"><img src="images/iphoto-icon.png" height="40"></a>
					    <a href="#"><img src="images/youtube-icon.png" height="40"></a>
					</div>
                </div>-->
			</div>
			 
        </div>
    </body>
</html>
<?php
}
?>