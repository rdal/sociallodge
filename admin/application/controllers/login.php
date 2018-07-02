<?php

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        session_start();

        $this->load->helper('url');
        $this->load->helper('form');
    }

    function index()
    {
        //$data['base'] = $this->config->item('base_url');
        //$data['css'] = 'style.css';

        $data = array();
        $data['base'] = $this->config->item('base_url');

        $username = $this->input->post("login",true);
        $password = $this->input->post("password",true);

        if(strlen($username) != 0)
        {
            $ok = $this->authenticate($username, $password);
            if($ok)
            {
                redirect("main");
            }
            else
            {
                $data['ok'] = -1;
                $this->load->view('login_view', $data);
            }
        }
        else{
            $this->load->view('login_view', $data);
        }
    }

    function authenticate($username, $password)
    {
        $ret = false;

        $encryptedPassword = md5($password);
        //echo '<script type="text/javascript">alert("encryptedPassword is ' . $encryptedPassword . '");</script>';die();
        $this->db->from('admins');
        $this->db->where('login', $username);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            if($encryptedPassword == $row->password)
            {
                $_SESSION['show_menus'] = true;
                $_SESSION['loggedin_as_admin'] = true;
                $_SESSION['lodge_id_as_admin'] = $row->lodge_id;

                $this->db->from('lodges');
                $this->db->where('id', $row->lodge_id);
                $queryGB = $this->db->get();
                if($queryGB->num_rows() > 0){
                    $rowGB = $queryGB->row();
                    $_SESSION['governing_body_as_admin'] = $rowGB->governing_body_id;
                }

                $ret = true;
            }
        }

        return $ret;

    }
}

?>
