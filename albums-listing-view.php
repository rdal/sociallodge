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
        <link href="css/style-albums-listing.css" rel="stylesheet" type="text/css" />
        <link href="css/stylesMosaic.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="css/jPagesMosaic.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="js/jPages.js"></script>
        <script>
            $(function() {
                $("div.holder").jPages({
                    containerID: "itemContainer",
                    previous : "←",
                    next : "→",
                    perPage:15,
                    midRange: 3,
                    direction: "random",
                    animation: "flipInY"
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
			    <div class="albums-listing">
				    <div class="albums-listing-title">T&oacute;picos</div><hr>
                    <div class="albums-listing-text">







                        <div id="content" class="defaults">

                            <!-- item container -->
                            <ul id="itemContainer">
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>
                                <li><img src="http://luis-almeida.github.io/jPages/img/img%20(3).jpg" alt="image"><br><a href="">AfafafafaAfafafaf</a></li>




                            </ul>

                        </div> <!--! end of #content -->
                    </div> <!--! end of #container -->





                    </div>
                <!-- navigation holder -->
                <div class="holder"></div>
                </div>
			</div>
        </div>
    </body>
</html>