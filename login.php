<!doctype html>

<head>

	<!-- Basics -->
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>Login</title>

	<!-- CSS -->
	
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/styles.css">

<?php
    if($_REQUEST["err"] == -1)
    {
        echo "<script type=\"text/javascript\">window.alert(\"Usuário ou senha incorretos!\\nTente novamente.\")</script>";
    }
?>
	
</head>

	<!-- Main HTML -->
	
<body>

<?php
require_once('controllers/dbcontroller.php');

$db = new DBController();
$governingBodies = $db->getGoverningBodies();
?>	
	<!-- Begin Page Content -->
	
	<div id="container">
		
		<form action="process_login.php" method="POST">
		
		<label for="name">Login:</label>
		
		<input type="name" name="login">
		
		<label for="username">Senha:</label>
		
		<!--<p><a href="#">Forgot your password?</a>-->
		
		<input type="password" name="password">
	
                <center>
                    <select id="potencia" name="potencia">
<?php
                        foreach($governingBodies as $governingBody)
                        {
                            echo "<option value=\"".$governingBody->getId()."\">".$governingBody->getName()."</option>";
                        }
?>
                    </select>
                </center>
	
		<div id="lower">
		
		<!--<input type="checkbox"><label class="check" for="checkbox">Keep me logged in</label>-->
		
		<input type="submit" value="Login">
		
		</div>
		
		</form>

<?php
        $pieces = explode("/", $_SERVER['PHP_SELF']);
        unset($pieces[count($pieces)-1]);
        unset($pieces[count($pieces)-1]);
        $url = implode("/", $pieces);
?>

        <br><br><div align="center"><a href="<?=$url?>">Voltar &agrave; p&aacute;gina principal</a></div>
		
	</div>
	
	
	<!-- End Page Content -->
	
</body>

</html>
	
	
	
	
	
		
	
