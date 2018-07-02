<?php
class Commons {
    function checkUserSession($pathRedir = null)
    {
        if(session_id() == '') {
            session_start();
        }

        // ensure already signed in
        if ( !$_SESSION['loggedin'] ) {

            if(is_null($pathRedir))
            {
                //$path = $_SERVER['HTTP_HOST'];
                //echo "BEFORE = ".$path.'<BR>';
                $pieces = explode("/", $_SERVER["REQUEST_URI"]);
                $count_pieces = count($pieces);
                unset($pieces[$count_pieces-1]);
                $path = implode("/",$pieces);
                //echo "AFTER = ".$path.'<BR>';

                header('Location: '.$path.'/login.php' );
            }
            else{
                header('Location: '.$pathRedir.'/login.php' );
            }
        }
    }

    function logout() {
        session_destroy();
        header('Location: login.php' );
    }
}
?>
