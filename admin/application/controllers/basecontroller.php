<?php

class BaseController extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if(session_id() == '') {
            session_start();
        }

        $this->load->helper('url');
        // ensure already signed in
        if ( !$_SESSION['loggedin_as_admin'] ) {
            redirect( "login" );
        }
    }

    function logout() {
        session_destroy();
        // echo json_encode( $this->session->all_userdata() );
        redirect("login");
    }
}

?>