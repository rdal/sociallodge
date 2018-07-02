<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 26/05/15
 * Time: 13:30
 */

if(session_id() == '') {
    session_start();
}

require_once('controllers/dbcontroller.php');
require_once('Utils/Util.php');

$db = new DBController();
foreach($_REQUEST as $key => $request)
{
    if(Util::startsWith($key, "SN_"))
    {
        $socialNetworkId = substr($key, 3);
        //echo "ID ".$key."= ".$socialNetworkId."<br>\n";

        $ok = $db->updateUserSocialNetwork($socialNetworkId, trim($request));
        if(!$ok){
            echo "Falhou!";
        }
    }
}

header("Location: user-social-networks.php");


?>