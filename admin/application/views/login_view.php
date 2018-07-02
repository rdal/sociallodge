<!doctype html>

<head>

    <!-- Basics -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?=$base.'css/reset.css'?>">
    <link rel="stylesheet" href="<?=$base.'css/animate.css'?>">
    <link rel="stylesheet" href="<?=$base.'css/styles.css'?>">

    <?php
    if(isset($ok) && $ok == -1)
    {
        echo "<script type=\"text/javascript\">window.alert(\"Usuário ou senha incorretos!\\nTente novamente.\")</script>";
    }
    ?>

</head>

<!-- Main HTML -->

<body>

<!-- Begin Page Content -->

<div id="container">

    <form action="login" method="POST">

        <label for="name">Login:</label>

        <input type="name" name="login">

        <label for="username">Senha:</label>

        <!--<p><a href="#">Forgot your password?</a>-->

        <input type="password" name="password">

        <div id="lower">

            <!--<input type="checkbox"><label class="check" for="checkbox">Keep me logged in</label>-->

            <input type="submit" value="Login">

        </div>

    </form>
<?php

    $pieces = explode("/", $_SERVER['PHP_SELF']);
    unset($pieces[count($pieces)-1]);
    unset($pieces[count($pieces)-1]);
    unset($pieces[count($pieces)-1]);
    unset($pieces[count($pieces)-1]);
    $url = implode("/", $pieces);

?>
    <br><br><div align="center"><a href="<?=$url?>">Voltar &agrave; p&aacute;gina principal</a></div>

</div>


<!-- End Page Content -->

</body>

</html>