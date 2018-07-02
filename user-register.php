<?php
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
    $email = utf8_encode($user->getEmail());
    $address = utf8_encode($user->getAddress());
    $phone = utf8_encode($user->getPhone());
    $mobile = utf8_encode($user->getMobile());
    $website = utf8_encode($user->getWebpage());
    $picture = utf8_encode($user->getProfilePicture());
    $aboutme = utf8_encode($user->getAboutme());
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
    <link href="css/style-register-user.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        function submitform()
        {
            if((document.submitPost.name.value == null || document.submitPost.name.value == "")){
                alert('O nome está vazio!');
            }
            else if(document.submitPost.email.value == null || document.submitPost.email.value == ""){
                alert('O e-mail está vazio!');
            }
            else{
                if((document.submitPost.password.value == null || document.submitPost.password.value == "") &&
                   (document.submitPost.confirm_password.value == null || document.submitPost.confirm_password.value == "")){
                    document.submitPost.submit();
                }
                else{
                    if(document.submitPost.password.value != document.submitPost.confirm_password.value){
                        alert('As senhas estão diferentes!');
                    }
                    else{
                        document.submitPost.submit();
                    }
                }
            }

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
                <form id="submitPost" name="submitPost" action="process_user_data.php" method="post">
                    <label for="name">Nome:</label>
                    <input id="name" name="name" type="text" value="<?=$name?>" style="width: 522px">
                    <label for="email">E-Mail:</label>
                    <input id="email" name="email" type="text" value="<?=$email?>" style="width: 522px">
                    <label for="password">Senha:</label>
                    <input id="password" name="password" type="password" style="width: 522px">
                    <label for="confirm_password">Confirme Senha:</label>
                    <input id="confirm_password" name="confirm_password" type="password" style="width: 522px">
                    <label for="address">Endere&ccedil;o:</label>
                    <input id="address" name="address" type="text" value="<?=$address?>" style="width: 522px">
                    <label for="phone">Telefone:</label>
                    <input id="phone" name="phone" type="text" value="<?=$phone?>" style="width: 522px">
                    <label for="mobile">Celular:</label>
                    <input id="mobile" name="mobile" type="text" value="<?=$mobile?>" style="width: 522px">
                    <label for="webpage">Website:</label>
                    <input id="webpage" name="webpage" type="text" value="<?=$website?>" style="width: 522px">
                    <label for="aboutme">Sobre:</label>
                    <textarea id="aboutme" name="aboutme" style="resize: none; width: 522px; min-width:522px; max-width:522px; height:110px; min-height:110px; max-height:110px;"><?=$aboutme?></textarea>
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