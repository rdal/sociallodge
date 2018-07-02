<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "basecontroller.php";

//class Main extends CI_Controller {
class Main extends BaseController {

    private $currentWifeId;
    private $currentNephews;
    private $currentMembers;

    function __construct()
    {
        parent::__construct();

        $this->currentWifeId = -1;
        $this->currentNephews = array();

        $this->currentMembers = array();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */

        $this->load->library('grocery_CRUD');

    }

    public function index()
    {
        $this->grocery_crud->set_table('users');
        $output = $this->grocery_crud->render();
        $output->output = "";

        $this->_example_output($output);
    }

    /*function get_subcategories()
    {
        $categoryId = $this->uri->segment(3);

        $this->db->select("*")
            ->from('subcategory')
            ->where('category_id', $categoryId);
        $db = $this->db->get();

        $array = array();
        foreach($db->result() as $row):
            $array[] = array("value" => $row->id, "property" => $row->name);
        endforeach;

        echo json_encode($array);
        exit;
    }*/

    function callback_before_upload($files_to_upload,$field_info)
    {
        $allowed_formats = array();
        if(($field_info->upload_path == "users_pictures") || ($field_info->upload_path == "lodges_pictures")){
            $allowed_formats = array("jpeg","jpg", "bmp", "png");
        }
//        elseif($field_info->upload_path == "pranchas_candidatos"){
//            $allowed_formats = array("pdf");
//        }
//        elseif($field_info->upload_path == "documentos"){
//            $allowed_formats = array("doc", "docx", "xls", "xlsx", "pdf");
//        }

        foreach($files_to_upload as $value) {
            $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
        }

        if(in_array(strtolower($ext),$allowed_formats))
        {
            return true;
        }
        else
        {
            $formats = implode(", ", $allowed_formats);
            return "Formatos permitidos: ".$formats;
        }
    }

    function callback_before_upload_document($files_to_upload,$field_info)
    {
        $allowed_formats = array();
        if(($field_info->upload_path == "documents") /*|| ($field_info->upload_path == "stores_pictures")*/){
            $allowed_formats = array("jpeg","jpg", "bmp", "png", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf");
        }

        foreach($files_to_upload as $value) {
            $pieces = explode(".", $value['name']);
            $cnt = count($pieces);
            $ext = $pieces[$cnt-1];
        }

        if(in_array(strtolower($ext),$allowed_formats))
        {
            return true;
        }
        else
        {
            $formats = implode(", ", $allowed_formats);
            return "Formatos permitidos: ".$formats;
        }
    }

    function callback_before_upload_apprentice_document($files_to_upload,$field_info)
    {
        $allowed_formats = array();
        if(($field_info->upload_path == "apprentice_documents") /*|| ($field_info->upload_path == "stores_pictures")*/){
            $allowed_formats = array("jpeg","jpg", "bmp", "png", "doc", "docx", "pdf");
        }

        foreach($files_to_upload as $value) {
            $pieces = explode(".", $value['name']);
            $cnt = count($pieces);
            $ext = $pieces[$cnt-1];
        }

        if(in_array(strtolower($ext),$allowed_formats))
        {
            return true;
        }
        else
        {
            $formats = implode(", ", $allowed_formats);
            return "Formatos permitidos: ".$formats;
        }
    }

    function callback_before_upload_fellowcraft_document($files_to_upload,$field_info)
    {
        $allowed_formats = array();
        if(($field_info->upload_path == "fellowcraft_documents")){
            $allowed_formats = array("jpeg","jpg", "bmp", "png", "doc", "docx", "pdf");
        }

        foreach($files_to_upload as $value) {
            $pieces = explode(".", $value['name']);
            $cnt = count($pieces);
            $ext = $pieces[$cnt-1];
        }

        if(in_array(strtolower($ext),$allowed_formats))
        {
            return true;
        }
        else
        {
            $formats = implode(", ", $allowed_formats);
            return "Formatos permitidos: ".$formats;
        }
    }

    function callback_before_upload_master_document($files_to_upload,$field_info)
    {
        $allowed_formats = array();
        if(($field_info->upload_path == "master_documents")){
            $allowed_formats = array("jpeg","jpg", "bmp", "png", "doc", "docx", "pdf");
        }

        foreach($files_to_upload as $value) {
            $pieces = explode(".", $value['name']);
            $cnt = count($pieces);
            $ext = $pieces[$cnt-1];
        }

        if(in_array(strtolower($ext),$allowed_formats))
        {
            return true;
        }
        else
        {
            $formats = implode(", ", $allowed_formats);
            return "Formatos permitidos: ".$formats;
        }
    }

    function callback_before_upload_session_record($files_to_upload,$field_info)
    {
        $allowed_formats = array();
        if(($field_info->upload_path == "session_records")){
            $allowed_formats = array("jpeg","jpg", "bmp", "png", "doc", "docx", "pdf");
        }

        foreach($files_to_upload as $value) {
            $pieces = explode(".", $value['name']);
            $cnt = count($pieces);
            $ext = $pieces[$cnt-1];
        }

        if(in_array(strtolower($ext),$allowed_formats))
        {
            return true;
        }
        else
        {
            $formats = implode(", ", $allowed_formats);
            return "Formatos permitidos: ".$formats;
        }
    }

    function checkPassword()
    {
        $ret = TRUE;

        $password = $this->input->post("password",true);

        $crud = new grocery_CRUD();
        $state = $crud->getState();
        if(($state == 'insert_validation') && (strlen($password) == 0))
        {
            $this->form_validation->set_message("checkPassword","O campo Senha é obrigatório na inclusão de um novo usuário.");
            $ret = FALSE;
        }

        return $ret;
    }

//    function checkMasonicProfiles()
//    {
//        $ret = TRUE;
//
//        $masonic_profile_meritorious = $this->input->post("masonic_profile_meritorious",true);
//        $masonic_profile_studious = $this->input->post("masonic_profile_studious",true);
//        $masonic_profile_political = $this->input->post("masonic_profile_political",true);
//
//        $crud = new grocery_CRUD();
//        $state = $crud->getState();
//        if(($state == 'insert_validation') || ($state == 'update_validation'))
//        {
//            if(($masonic_profile_meritorious != $masonic_profile_studious) &&
//                ($masonic_profile_meritorious != $masonic_profile_political) &&
//                ($masonic_profile_studious != $masonic_profile_political))
//            {
//                $ret = TRUE;
//            }
//            else
//            {
//                $this->form_validation->set_message("checkMasonicProfiles","Cada critério do 'Perfil Maçônico' deve possuir um valor único.");
//                $ret = FALSE;
//            }
//        }
//
//        return $ret;
//    }
//
//    function checkProfilesMatrix()
//    {
//        $ret = TRUE;
//
//        $matrix_profile_analytical = $this->input->post("matrix_profile_analytical",true);
//        $matrix_profile_pragmatic = $this->input->post("matrix_profile_pragmatic",true);
//        $matrix_profile_affable = $this->input->post("matrix_profile_affable",true);
//        $matrix_profile_expressive = $this->input->post("matrix_profile_expressive",true);
//
//        $crud = new grocery_CRUD();
//        $state = $crud->getState();
//        if(($state == 'insert_validation') || ($state == 'update_validation'))
//        {
//            if(($matrix_profile_analytical != $matrix_profile_pragmatic) &&
//                ($matrix_profile_analytical != $matrix_profile_affable) &&
//                ($matrix_profile_analytical != $matrix_profile_expressive) &&
//                ($matrix_profile_pragmatic != $matrix_profile_affable) &&
//                ($matrix_profile_pragmatic != $matrix_profile_expressive) &&
//                ($matrix_profile_affable != $matrix_profile_expressive))
//            {
//                $ret = TRUE;
//            }
//            else
//            {
//                $this->form_validation->set_message("checkProfilesMatrix","Cada critério da 'Matriz de Perfil' deve possuir um valor único.");
//                $ret = FALSE;
//            }
//        }
//
//        return $ret;
//    }

    function encrypt_password_callback($post_array, $primary_key = null)
    {
        $password = $this->input->post("password",true);
        if(strlen($password) == 0)
        {
            $id = $this->input->post("id",true);


            $this->db->where('id',$id);
            $query = $this->db->get('users');
            if($query->num_rows() > 0){

                $row = $query->row();
                $post_array['password'] = $row->password;
            }
        }
        else
        {
            $post_array['password'] = md5($password);
        }

        $this->db->select('wife_id');
        $query = $this->db->get_where('users', array('id' => $primary_key));
        $result = $query->result();

        $this->currentWifeId = $result[0]->wife_id;

        $this->db->select('nephew_id');
        $query = $this->db->get_where('users_nephews', array('user_id' => $primary_key));
        $result = $query->result();

        foreach($result as $res)
        {
            $this->currentNephews[] = $res->nephew_id;
        }

        $post_array['approved_inquiry_expedition'] = (is_null($post_array['approved_inquiry_expedition'])) ? false : true;
        if(strlen($post_array['approved_inquiry_expedition_date']) > 0)
        {
            $pieces = explode("/",$post_array['approved_inquiry_expedition_date']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['approved_inquiry_expedition_date'] = implode("-", $dateFormatArray);
        }

        $post_array['inquiry_done'] = (is_null($post_array['inquiry_done'])) ? false : true;
        if(strlen($post_array['inquiry_done_date']) > 0)
        {
            $pieces = explode("/",$post_array['inquiry_done_date']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['inquiry_done_date'] = implode("-", $dateFormatArray);
        }

        $post_array['approved_spouse_inquiry_expedition'] = (is_null($post_array['approved_spouse_inquiry_expedition'])) ? false : true;
        if(strlen($post_array['approved_spouse_inquiry_expedition_date']) > 0)
        {
            $pieces = explode("/",$post_array['approved_spouse_inquiry_expedition_date']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['approved_spouse_inquiry_expedition_date'] = implode("-", $dateFormatArray);
        }

        $post_array['spouse_inquiry_done'] = (is_null($post_array['spouse_inquiry_done'])) ? false : true;
        if(strlen($post_array['spouse_inquiry_done_date']) > 0)
        {
            $pieces = explode("/",$post_array['spouse_inquiry_done_date']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['spouse_inquiry_done_date'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_01']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_02']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_03']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_04']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_05']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_06']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_07']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_07'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_08']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_08']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_08'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_09']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_09']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_09'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_10']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_10']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_10'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_11']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_11']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_11'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['lodge_role_tenure_date_12']) > 0)
        {
            $pieces = explode("/",$post_array['lodge_role_tenure_date_12']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['lodge_role_tenure_date_12'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['governing_body_role_tenure_date_01']) > 0)
        {
            $pieces = explode("/",$post_array['governing_body_role_tenure_date_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['governing_body_role_tenure_date_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['governing_body_role_tenure_date_02']) > 0)
        {
            $pieces = explode("/",$post_array['governing_body_role_tenure_date_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['governing_body_role_tenure_date_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['governing_body_role_tenure_date_03']) > 0)
        {
            $pieces = explode("/",$post_array['governing_body_role_tenure_date_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['governing_body_role_tenure_date_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['governing_body_role_tenure_date_04']) > 0)
        {
            $pieces = explode("/",$post_array['governing_body_role_tenure_date_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['governing_body_role_tenure_date_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['governing_body_role_tenure_date_05']) > 0)
        {
            $pieces = explode("/",$post_array['governing_body_role_tenure_date_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['governing_body_role_tenure_date_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['governing_body_role_tenure_date_06']) > 0)
        {
            $pieces = explode("/",$post_array['governing_body_role_tenure_date_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['governing_body_role_tenure_date_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['governing_body_role_tenure_date_07']) > 0)
        {
            $pieces = explode("/",$post_array['governing_body_role_tenure_date_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['governing_body_role_tenure_date_07'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['another_role_in_another_degree_tenure_date_01']) > 0)
        {
            $pieces = explode("/",$post_array['another_role_in_another_degree_tenure_date_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['another_role_in_another_degree_tenure_date_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['another_role_in_another_degree_tenure_date_02']) > 0)
        {
            $pieces = explode("/",$post_array['another_role_in_another_degree_tenure_date_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['another_role_in_another_degree_tenure_date_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['another_role_in_another_degree_tenure_date_03']) > 0)
        {
            $pieces = explode("/",$post_array['another_role_in_another_degree_tenure_date_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['another_role_in_another_degree_tenure_date_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['another_role_in_another_degree_tenure_date_04']) > 0)
        {
            $pieces = explode("/",$post_array['another_role_in_another_degree_tenure_date_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['another_role_in_another_degree_tenure_date_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['another_role_in_another_degree_tenure_date_05']) > 0)
        {
            $pieces = explode("/",$post_array['another_role_in_another_degree_tenure_date_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['another_role_in_another_degree_tenure_date_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['another_role_in_another_degree_tenure_date_06']) > 0)
        {
            $pieces = explode("/",$post_array['another_role_in_another_degree_tenure_date_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['another_role_in_another_degree_tenure_date_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['another_role_in_another_degree_tenure_date_07']) > 0)
        {
            $pieces = explode("/",$post_array['another_role_in_another_degree_tenure_date_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['another_role_in_another_degree_tenure_date_07'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['social_entity_role_tenure_date_01']) > 0)
        {
            $pieces = explode("/",$post_array['social_entity_role_tenure_date_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['social_entity_role_tenure_date_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['social_entity_role_tenure_date_02']) > 0)
        {
            $pieces = explode("/",$post_array['social_entity_role_tenure_date_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['social_entity_role_tenure_date_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['social_entity_role_tenure_date_03']) > 0)
        {
            $pieces = explode("/",$post_array['social_entity_role_tenure_date_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['social_entity_role_tenure_date_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['social_entity_role_tenure_date_04']) > 0)
        {
            $pieces = explode("/",$post_array['social_entity_role_tenure_date_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['social_entity_role_tenure_date_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['social_entity_role_tenure_date_05']) > 0)
        {
            $pieces = explode("/",$post_array['social_entity_role_tenure_date_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['social_entity_role_tenure_date_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['social_entity_role_tenure_date_06']) > 0)
        {
            $pieces = explode("/",$post_array['social_entity_role_tenure_date_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['social_entity_role_tenure_date_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['social_entity_role_tenure_date_07']) > 0)
        {
            $pieces = explode("/",$post_array['social_entity_role_tenure_date_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['social_entity_role_tenure_date_07'] = implode("-", $dateFormatArray);
        }

        $post_array['proposal_copies'] = (is_null($post_array['proposal_copies'])) ? false : true;
        $post_array['medical_certificate'] = (is_null($post_array['medical_certificate'])) ? false : true;
        $post_array['notary_notification_certificate'] = (is_null($post_array['notary_notification_certificate'])) ? false : true;
        $post_array['criminal_certificate'] = (is_null($post_array['criminal_certificate'])) ? false : true;
        $post_array['civil_certificate'] = (is_null($post_array['civil_certificate'])) ? false : true;


//        $fp = fopen('/tmp/data.txt', 'w');
//        fwrite($fp, print_r($post_array, true));
//        fwrite($fp, "\n");
//        fclose($fp);

        return $post_array;
    }

    function checkBeforeModifyApprenticeHistoryDatabase()
    {
        $ret = TRUE;

        $userId = $this->input->post("user_id",true);
        $this->db->select('id');
        $query = $this->db->get_where('apprentice_history', array('user_id' => $userId));
        $result = $query->result();

        $crud = new grocery_CRUD();
        $state = $crud->getState();
        if(($state == 'insert_validation') && !is_null($result[0]->id))
        {
            $this->form_validation->set_message("checkBeforeModifyApprenticeHistoryDatabase","O membro selecionado já possui um histórico de Aprendiz Maçom.");
            $ret = FALSE;
        }

        return $ret;
    }

    function checkBeforeModifyFellowcraftHistoryDatabase()
    {
        $ret = TRUE;

        $userId = $this->input->post("user_id",true);
        $this->db->select('id');
        $query = $this->db->get_where('fellowcraft_history', array('user_id' => $userId));
        $result = $query->result();

        $crud = new grocery_CRUD();
        $state = $crud->getState();
        if(($state == 'insert_validation') && !is_null($result[0]->id))
        {
            $this->form_validation->set_message("checkBeforeModifyFellowcraftHistoryDatabase","O membro selecionado já possui um histórico de Companheiro Maçom.");
            $ret = FALSE;
        }

        return $ret;
    }

    function checkBeforeModifyMasterHistoryDatabase()
    {
        $ret = TRUE;

        $userId = $this->input->post("user_id",true);
        $this->db->select('id');
        $query = $this->db->get_where('master_history', array('user_id' => $userId));
        $result = $query->result();

        $crud = new grocery_CRUD();
        $state = $crud->getState();
        if(($state == 'insert_validation') && !is_null($result[0]->id))
        {
            $this->form_validation->set_message("checkBeforeModifyMasterHistoryDatabase","O membro selecionado já possui um histórico de Mestre Maçom.");
            $ret = FALSE;
        }

        return $ret;
    }

    function callback_before_modifying_apprentice_history($post_array, $primary_key = null)
    {
        if(strlen($post_array['received_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_04']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_04']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_04']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_05']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_05']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_05']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_06']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_06']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_06']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_07']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_07'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_07']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_07'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_07']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_07'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_01']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_01']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_02']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_02']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_03']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_03']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_04']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_04']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_05']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_05']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_01']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_02']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_03']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_04']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_05']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_06']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_07']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_07'] = implode("-", $dateFormatArray);
        }

//        $fp = fopen('/tmp/data.txt', 'w');
//        fwrite($fp, print_r($post_array, true));
//        fwrite($fp, "\n");
//        fclose($fp);

        return $post_array;
    }

    function callback_before_modifying_fellowcraft_history($post_array, $primary_key = null)
    {
        if(strlen($post_array['received_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_04']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_04']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_04']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_05']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_05']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_05']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_01']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_01']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_02']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_02']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_03']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_03']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_04']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_04']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_05']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_05']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_01']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_02']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_03']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_04']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_05']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_06']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_07']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_07'] = implode("-", $dateFormatArray);
        }

//        $fp = fopen('/tmp/data.txt', 'w');
//        fwrite($fp, print_r($post_array, true));
//        fwrite($fp, "\n");
//        fclose($fp);

        return $post_array;
    }

    function callback_before_modifying_master_history($post_array, $primary_key = null)
    {
        if(strlen($post_array['received_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_01']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_02']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['received_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['received_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['received_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_work_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_work_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_work_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_work_instruction_03']) > 0)
        {
            $pieces = explode("/",$post_array['presented_work_instruction_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_work_instruction_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_01']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_01']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_02']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_02']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_03']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_03']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_04']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_04']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_05']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_05']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_06']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_06']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['delivered_extra_work_07']) > 0)
        {
            $pieces = explode("/",$post_array['delivered_extra_work_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['delivered_extra_work_07'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['presented_extra_work_07']) > 0)
        {
            $pieces = explode("/",$post_array['presented_extra_work_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['presented_extra_work_07'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_01']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_01']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_01'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_02']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_02']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_02'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_03']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_03']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_03'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_04']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_04']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_04'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_05']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_05']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_05'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_06']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_06']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_06'] = implode("-", $dateFormatArray);
        }

        if(strlen($post_array['visit_lodge_date_07']) > 0)
        {
            $pieces = explode("/",$post_array['visit_lodge_date_07']);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $post_array['visit_lodge_date_07'] = implode("-", $dateFormatArray);
        }

//        $fp = fopen('/tmp/data.txt', 'w');
//        fwrite($fp, print_r($post_array, true));
//        fwrite($fp, "\n");
//        fclose($fp);

        return $post_array;
    }

    function set_password_input_to_empty() {
        $mode = $this->uri->segment(3);

        if($mode == "read"){
            $ret = "";
        }
        else{
            $ret = "<input type='password' name='password' value='' />";
        }
        return $ret;
    }

    function set_relatives_availability($post_array,$primary_key)
    {

        if($this->currentWifeId != $post_array["wife_id"])
        {
            $data = array(
                'is_available' => 1
            );

            $this->db->where('id', $this->currentWifeId);
            $this->db->update('wives', $data);


            if(!is_null($post_array["wife_id"]))
            {
                $data = array(
                    'is_available' => 0
                );

                $this->db->where('id', $post_array["wife_id"]);
                $this->db->update('wives', $data);
            }
        }

        //=================================================
        foreach($this->currentNephews as $currentNewphewId)
        {
            $data = array(
                'is_available' => 1
            );

            $this->db->where('id', $currentNewphewId);
            $this->db->update('nephews', $data);
        }
        foreach($post_array["nephews"] as $nephewId)
        {
//            $key = array_search($nephewId, $this->currentNephews);
//            if($key !== false)
//            {
            $data = array(
                'is_available' => 0
            );

            $this->db->where('id', $nephewId);
            $this->db->update('nephews', $data);
//            }
        }

        return true;
    }

    public function _callback_wife($value = '', $primary_key = null)
    {
//        $fp = fopen('/tmp/data.txt', 'w');
//        fwrite($fp, print_r($page, true));
//        fwrite($fp, "\n");
//        fclose($fp);

        $mode = $this->uri->segment(3);

        if($mode == "read")
        {
            $page = $_SERVER['REQUEST_URI'];
            $pieces = explode("/", $page);
            $posSubject = count($pieces) - 3;
            $posValue = count($pieces) - 1;
            $pieces[$posSubject] = "wives";
            $pieces[$posValue] = $value;
            $page = 'http://' . $_SERVER['HTTP_HOST'] . implode("/", $pieces);

            $this->db->select("name")
                ->from("wives")
                ->where('id', $value);
            $query = $this->db->get();
            $result = $query->result();
            $wifeName = (count($result) == 0) ? "" : $result[0]->name;

            $ret = "<a href=\"".$page."\">".$wifeName."</a>";
        }
        else{
            $ret = "<select id=\"field-wife_id\" name=\"wife_id\" class=\"chosen-select chzn-done\" data-placeholder=\"Select Cunhada\" style=\"width: 300px;\">";
            $ret .= "<option value=\"\"></option>";

            //        $this->db->select('id, name');
            //        $this->db->order_by("name", "asc");
            //        $query = $this->db->get_where("wives", "is_available='1' OR id='".$value."'");

            if(is_null($value))
            {
                $this->db->select("id, name")
                    ->from("wives")
                    ->where('is_available', "1");
            }
            else
            {
                $this->db->select("id, name")
                    ->from("wives")
                    ->where('is_available', "1")
                    ->or_where('id =', $value);
            }
            $query = $this->db->get();
            foreach ($query->result() as $row)
            {
                if($row->id == $value){
                    $ret .= "<option value=\"".$row->id."\" selected>".$row->name."</option>";
                }
                else{
                    $ret .= "<option value=\"".$row->id."\">".$row->name."</option>";
                }
            }

            $ret .= "</select>";
        }

        return $ret;
    }

    function before_update_members_callback($post_array, $primary_key)
    {
        $this->currentMembers = array();
        $query = $this->db->get_where('lodge_members', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
        foreach ($query->result() as $row)
        {
            $this->currentMembers[] = $row->user_id;
        }

        return $post_array;
    }

    function after_update_members_callback($post_array,$primary_key)
    {
//        $fp = fopen('/tmp/data.txt', 'w');
//        fwrite($fp, print_r($post_array["members"], true));
//        fwrite($fp, "\n");
//        fclose($fp);

        $usersToBeSkiped = array();
        $usersToBeDeleted = array();
        foreach($this->currentMembers as $currentMember)
        {
            $key = array_search($currentMember, $post_array["members"]);
            if($key === FALSE)
            {
                $usersToBeDeleted[] = $currentMember;
            }
            else
            {
                $usersToBeSkiped[] = $currentMember;
            }
        }

        foreach($usersToBeDeleted as $userToBeDeleted)
        {
            $this->db->delete('members_lodges', array('user_id' => $userToBeDeleted, 'lodge_id' => $_SESSION['lodge_id_as_admin']));
        }

        foreach($post_array["members"] as $member)
        {
            $key = array_search($member, $usersToBeSkiped);
            if($key === FALSE)
            {
                $data = array(
                    'user_id' => $member ,
                    'lodge_id' => $_SESSION['lodge_id_as_admin']
                );

                $this->db->insert('members_lodges', $data);
            }
        }

        return true;
    }

    // Hobbies
    function edit_hobby_callback_1($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_1' value='".$user->hobby_practitioner_1."'></td><td><input type='text' name='hobby_activity_1' value='".$user->hobby_activity_1."'></td></tr></table>";
    }

    function add_hobby_callback_1()
    {

        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_1' ></td><td><input type='text' name='hobby_activity_1'></td></tr></table>";
    }

    function edit_hobby_activity_1($value, $primary_key)
    {
        return  "";
    }

    function add_hobby_activity_1()
    {

        return  "";
    }

    function edit_hobby_callback_2($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_2' value='".$user->hobby_practitioner_2."'></td><td><input type='text' name='hobby_activity_2' value='".$user->hobby_activity_2."'></td></tr></table>";
    }

    function add_hobby_callback_2()
    {

        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_2' ></td><td><input type='text' name='hobby_activity_2'></td></tr></table>";
    }

    function edit_hobby_activity_2($value, $primary_key)
    {
        return  "";
    }

    function add_hobby_activity_2()
    {

        return  "";
    }

    function edit_hobby_callback_3($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_3' value='".$user->hobby_practitioner_3."'></td><td><input type='text' name='hobby_activity_3' value='".$user->hobby_activity_3."'></td></tr></table>";
    }

    function add_hobby_callback_3()
    {

        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_3' ></td><td><input type='text' name='hobby_activity_3'></td></tr></table>";
    }

    function edit_hobby_activity_3($value, $primary_key)
    {
        return  "";
    }

    function add_hobby_activity_3()
    {

        return  "";
    }

    function edit_hobby_callback_4($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_4' value='".$user->hobby_practitioner_4."'></td><td><input type='text' name='hobby_activity_4' value='".$user->hobby_activity_4."'></td></tr></table>";
    }

    function add_hobby_callback_4()
    {

        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_4' ></td><td><input type='text' name='hobby_activity_4'></td></tr></table>";
    }

    function edit_hobby_activity_4($value, $primary_key)
    {
        return  "";
    }

    function add_hobby_activity_4()
    {

        return  "";
    }

    function edit_hobby_callback_5($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_5' value='".$user->hobby_practitioner_5."'></td><td><input type='text' name='hobby_activity_5' value='".$user->hobby_activity_5."'></td></tr></table>";
    }

    function add_hobby_callback_5()
    {

        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_5' ></td><td><input type='text' name='hobby_activity_5'></td></tr></table>";
    }

    function edit_hobby_activity_5($value, $primary_key)
    {
        return  "";
    }

    function add_hobby_activity_5()
    {

        return  "";
    }

    function edit_hobby_callback_6($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_6' value='".$user->hobby_practitioner_6."'></td><td><input type='text' name='hobby_activity_6' value='".$user->hobby_activity_6."'></td></tr></table>";
    }

    function add_hobby_callback_6()
    {

        return  "<table><tr><td>Praticante</td><td>Atividade</td></tr><tr><td><input type='text' name='hobby_practitioner_6' ></td><td><input type='text' name='hobby_activity_6'></td></tr></table>";
    }

    function edit_hobby_activity_6($value, $primary_key)
    {
        return  "";
    }

    function add_hobby_activity_6()
    {

        return  "";
    }

    function edit_approved_inquiry_expedition_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $approvedInquiryExpeditionDate = "";
        $approvedChecked = "";
        if($user->approved_inquiry_expedition)
        {
            $approvedChecked = "checked";
        }

        if(!is_null($user->approved_inquiry_expedition_date))
        {
            $pieces = explode("-",$user->approved_inquiry_expedition_date);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $approvedInquiryExpeditionDate = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Aprovada</td><td align=\"center\">Data</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"approved_inquiry_expedition\" ".$approvedChecked."></td><td><input id='field-approved_inquiry_expedition_date' name='approved_inquiry_expedition_date' type='text' value='".$approvedInquiryExpeditionDate."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_approved_inquiry_expedition_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Aprovada</td><td align=\"center\">Data</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"approved_inquiry_expedition\"></td><td><input id='field-approved_inquiry_expedition_date' name='approved_inquiry_expedition_date' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_approved_inquiry_expedition_date_callback($value, $primary_key)
    {
        return  "";
    }

    function add_approved_inquiry_expedition_date_callback()
    {
        return  "";
    }

    function edit_inquiry_done_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $inquiryDoneDate = "";
        $inquiryDoneChecked = "";
        if($user->inquiry_done)
        {
            $inquiryDoneChecked = "checked";
        }

        if(!is_null($user->inquiry_done_date))
        {
            $pieces = explode("-",$user->inquiry_done_date);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $inquiryDoneDate = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td><td align=\"center\">Data</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"inquiry_done\" ".$inquiryDoneChecked."></td><td><input id='field-inquiry_done_date' name='inquiry_done_date' type='text' value='".$inquiryDoneDate."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_inquiry_done_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td><td align=\"center\">Data</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"inquiry_done\"></td><td><input id='field-inquiry_done_date' name='inquiry_done_date' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_inquiry_done_date_callback($value, $primary_key)
    {
        return  "";
    }

    function add_inquiry_done_date_callback()
    {
        return  "";
    }

    function edit_inquiry_master_01_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<input type='text' name='inquiry_master_01' value='".$user->inquiry_master_01."' style='width: 200px;'>&nbsp;<input type='text' name='inquiry_master_02' value='".$user->inquiry_master_02."' style='width: 200px;'>&nbsp;<input type='text' name='inquiry_master_03' value='".$user->inquiry_master_03."' style='width: 200px;'>";
    }

    function add_inquiry_master_01_callback()
    {
        return  "<input type='text' name='inquiry_master_01' style='width: 200px;'>&nbsp;<input type='text' name='inquiry_master_02' style='width: 200px;'>&nbsp;<input type='text' name='inquiry_master_03' style='width: 200px;'>";
    }

    function edit_inquiry_master_02_callback($value, $primary_key)
    {
        return  "";
    }

    function add_inquiry_master_02_callback()
    {
        return  "";
    }
    function edit_inquiry_master_03_callback($value, $primary_key)
    {
        return  "";
    }

    function add_inquiry_master_03_callback()
    {
        return  "";
    }

    function edit_more_inquiry_masters_01_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<input type='text' name='more_inquiry_masters_01' value='".$user->more_inquiry_masters_01."' style='width: 200px;'>&nbsp;<input type='text' name='more_inquiry_masters_02' value='".$user->more_inquiry_masters_02."' style='width: 200px;'>&nbsp;<input type='text' name='more_inquiry_masters_03' value='".$user->more_inquiry_masters_03."' style='width: 200px;'>";
    }

    function add_more_inquiry_masters_01_callback()
    {
        return  "<input type='text' name='more_inquiry_masters_01' style='width: 200px;'>&nbsp;<input type='text' name='more_inquiry_masters_02' style='width: 200px;'>&nbsp;<input type='text' name='more_inquiry_masters_03' style='width: 200px;'>";
    }

    function edit_more_inquiry_masters_02_callback($value, $primary_key)
    {
        return  "";
    }

    function add_more_inquiry_masters_02_callback()
    {
        return  "";
    }
    function edit_more_inquiry_masters_03_callback($value, $primary_key)
    {
        return  "";
    }

    function add_more_inquiry_masters_03_callback()
    {
        return  "";
    }

    function edit_approved_spouse_inquiry_expedition_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $approvedSpouseInquiryExpeditionDate = "";
        $approvedChecked = "";
        if($user->approved_spouse_inquiry_expedition)
        {
            $approvedChecked = "checked";
        }

        if(!is_null($user->approved_spouse_inquiry_expedition_date))
        {
            $pieces = explode("-",$user->approved_spouse_inquiry_expedition_date);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $approvedSpouseInquiryExpeditionDate = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Aprovada</td><td align=\"center\">Data</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"approved_spouse_inquiry_expedition\" ".$approvedChecked."></td><td><input id='field-approved_spouse_inquiry_expedition_date' name='approved_spouse_inquiry_expedition_date' type='text' value='".$approvedSpouseInquiryExpeditionDate."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_approved_spouse_inquiry_expedition_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Aprovada</td><td align=\"center\">Data</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"approved_spouse_inquiry_expedition\"></td><td><input id='field-approved_spouse_inquiry_expedition_date' name='approved_spouse_inquiry_expedition_date' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_approved_spouse_inquiry_expedition_date_callback($value, $primary_key)
    {
        return  "";
    }

    function add_approved_spouse_inquiry_expedition_date_callback()
    {
        return  "";
    }

    function edit_spouse_inquiry_done_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $spouseInquiryDoneDate = "";
        $spouseInquiryDoneChecked = "";
        if($user->spouse_inquiry_done)
        {
            $spouseInquiryDoneChecked = "checked";
        }

        if(!is_null($user->spouse_inquiry_done_date))
        {
            $pieces = explode("-",$user->spouse_inquiry_done_date);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $spouseInquiryDoneDate = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td><td align=\"center\">Data</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"spouse_inquiry_done\" ".$spouseInquiryDoneChecked."></td><td><input id='field-spouse_inquiry_done_date' name='spouse_inquiry_done_date' type='text' value='".$spouseInquiryDoneDate."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_spouse_inquiry_done_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td><td align=\"center\">Data</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"spouse_inquiry_done\"></td><td><input id='field-spouse_inquiry_done_date' name='spouse_inquiry_done_date' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_spouse_inquiry_done_date_callback($value, $primary_key)
    {
        return  "";
    }

    function add_spouse_inquiry_done_date_callback()
    {
        return  "";
    }

    function edit_spouse_inquiry_master_01_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();


        return  "<input type='text' name='spouse_inquiry_master_01' value='".$user->spouse_inquiry_master_01."' style='width: 200px;'>&nbsp;<input type='text' name='spouse_inquiry_master_02' value='".$user->spouse_inquiry_master_02."' style='width: 200px;'>&nbsp;<input type='text' name='spouse_inquiry_master_03' value='".$user->spouse_inquiry_master_03."' style='width: 200px;'>";
    }

    function add_spouse_inquiry_master_01_callback()
    {
        return  "<input type='text' name='spouse_inquiry_master_01' style='width: 200px;'>&nbsp;<input type='text' name='spouse_inquiry_master_02' style='width: 200px;'>&nbsp;<input type='text' name='spouse_inquiry_master_03' style='width: 200px;'>";
    }

    function edit_spouse_inquiry_master_02_callback($value, $primary_key)
    {
        return  "";
    }

    function add_spouse_inquiry_master_02_callback()
    {
        return  "";
    }
    function edit_spouse_inquiry_master_03_callback($value, $primary_key)
    {
        return  "";
    }

    function add_spouse_inquiry_master_03_callback()
    {
        return  "";
    }

    function edit_proposal_copies_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $proposalCopiesChecked = "";
        if($user->proposal_copies)
        {
            $proposalCopiesChecked = "checked";
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"proposal_copies\" ".$proposalCopiesChecked."></td></tr></table>";
    }

    function add_proposal_copies_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"proposal_copies\"></td></tr></table>";
    }

    function edit_medical_certificate_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $medicalCertificateChecked = "";
        if($user->medical_certificate)
        {
            $medicalCertificateChecked = "checked";
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"medical_certificate\" ".$medicalCertificateChecked."></td></tr></table>";
    }

    function add_medical_certificate_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"medical_certificate\"></td></tr></table>";
    }

    function edit_notary_notification_certificate_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $notaryNotificationCertificateChecked = "";
        if($user->notary_notification_certificate)
        {
            $notaryNotificationCertificateChecked = "checked";
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"notary_notification_certificate\" ".$notaryNotificationCertificateChecked."></td></tr></table>";
    }

    function add_notary_notification_certificate_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"notary_notification_certificate\"></td></tr></table>";
    }

    function edit_criminal_certificate_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $criminalCertificateChecked = "";
        if($user->criminal_certificate)
        {
            $criminalCertificateChecked = "checked";
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"criminal_certificate\" ".$criminalCertificateChecked."></td></tr></table>";
    }

    function add_criminal_certificate_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"criminal_certificate\"></td></tr></table>";
    }

    function edit_civil_certificate_callback($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $civilCertificateChecked = "";
        if($user->civil_certificate)
        {
            $civilCertificateChecked = "checked";
        }

        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"civil_certificate\" ".$civilCertificateChecked."></td></tr></table>";
    }

    function add_civil_certificate_callback()
    {
        return  "<table><tr><td align=\"center\" width=\"100\">Sim</td></tr><tr><td align=\"center\" width=\"100\"><input type=\"checkbox\" name=\"civil_certificate\"></td></tr></table>";
    }

    function edit_philosophical_degree_id($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $selectDegrees = "<select id=\"field-philosophical_degree_id\" name=\"philosophical_degree_id\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau Atual\" style=\"width: 300px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('philosophical_degrees');
        foreach ($degrees->result() as $row){
            if($row->id == $user->philosophical_degree_id){
                $selectDegrees .= "<option value=\"".$row->id."\" selected>" . $row->value . "</option>";
            }
            else{
                $selectDegrees .= "<option value=\"".$row->id."\">" . $row->value . "</option>";
            }
        }
        $selectDegrees .= "</select>";

        $selectRites = "<select id=\"field-rite_id\" name=\"rite_id\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 300px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            if($row->id == $user->rite_id){
                $selectRites .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectRites .= "</select>";

        return  "<table><tr><td>Grau Atual</td><td>Rito</td></tr><tr><td>".$selectDegrees."</td><td>".$selectRites."</td></tr></table>";
    }

    function add_philosophical_degree_id()
    {
        $selectDegrees = "<select id=\"field-philosophical_degree_id\" name=\"philosophical_degree_id\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau Atual\" style=\"width: 300px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('philosophical_degrees');
        foreach ($degrees->result() as $row){
            $selectDegrees .= "<option value=\"".$row->id."\">" . $row->value . "</option>";
        }
        $selectDegrees .= "</select>";

        $selectRites = "<select id=\"field-rite_id\" name=\"rite_id\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 300px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectRites .= "</select>";

        return  "<table><tr><td>Grau Atual</td><td>Rito</td></tr><tr><td>".$selectDegrees."</td><td>".$selectRites."</td></tr></table>";
    }

    function edit_rite_id($value, $primary_key)
    {
        return  "";
    }

    function add_rite_id()
    {

        return  "";
    }

    function edit_lodge_role_01($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate01 = "";
        if(!is_null($user->lodge_role_tenure_date_01))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate01 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_01\" name=\"lodge_role_01\" value=\"".$user->lodge_role_01."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_01\" name=\"lodge_role_management_01\" value=\"".$user->lodge_role_management_01."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_01' name='lodge_role_tenure_date_01' type='text' value='".$lodgeRoleTenureDate01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_01()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_01\" name=\"lodge_role_01\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_01\" name=\"lodge_role_management_01\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_01' name='lodge_role_tenure_date_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_01($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_01()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_01($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_01()
    {
        return "";
    }

    function edit_lodge_role_02($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate02 = "";
        if(!is_null($user->lodge_role_tenure_date_02))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate02 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_02\" name=\"lodge_role_02\" value=\"".$user->lodge_role_02."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_02\" name=\"lodge_role_management_02\" value=\"".$user->lodge_role_management_02."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_02' name='lodge_role_tenure_date_02' type='text' value='".$lodgeRoleTenureDate02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_02()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_02\" name=\"lodge_role_02\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_02\" name=\"lodge_role_management_02\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_02' name='lodge_role_tenure_date_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_02($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_02()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_02($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_02()
    {
        return "";
    }

    function edit_lodge_role_03($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate03 = "";
        if(!is_null($user->lodge_role_tenure_date_03))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate03 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_03\" name=\"lodge_role_03\" value=\"".$user->lodge_role_03."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_03\" name=\"lodge_role_management_03\" value=\"".$user->lodge_role_management_03."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_03' name='lodge_role_tenure_date_03' type='text' value='".$lodgeRoleTenureDate03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_03()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_03\" name=\"lodge_role_03\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_03\" name=\"lodge_role_management_03\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_03' name='lodge_role_tenure_date_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_03($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_03()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_03($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_03()
    {
        return "";
    }

    function edit_lodge_role_04($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate04 = "";
        if(!is_null($user->lodge_role_tenure_date_04))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate04 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_04\" name=\"lodge_role_04\" value=\"".$user->lodge_role_04."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_04\" name=\"lodge_role_management_04\" value=\"".$user->lodge_role_management_04."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_04' name='lodge_role_tenure_date_04' type='text' value='".$lodgeRoleTenureDate04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_04()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_04\" name=\"lodge_role_04\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_04\" name=\"lodge_role_management_04\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_04' name='lodge_role_tenure_date_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_04($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_04()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_04($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_04()
    {
        return "";
    }

    function edit_lodge_role_05($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate05 = "";
        if(!is_null($user->lodge_role_tenure_date_05))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate05 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_05\" name=\"lodge_role_05\" value=\"".$user->lodge_role_05."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_05\" name=\"lodge_role_management_05\" value=\"".$user->lodge_role_management_05."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_05' name='lodge_role_tenure_date_05' type='text' value='".$lodgeRoleTenureDate05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_05()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_05\" name=\"lodge_role_05\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_05\" name=\"lodge_role_management_05\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_05' name='lodge_role_tenure_date_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_05($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_05()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_05($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_05()
    {
        return "";
    }

    function edit_lodge_role_06($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate06 = "";
        if(!is_null($user->lodge_role_tenure_date_06))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate06 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_06\" name=\"lodge_role_06\" value=\"".$user->lodge_role_06."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_06\" name=\"lodge_role_management_06\" value=\"".$user->lodge_role_management_06."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_06' name='lodge_role_tenure_date_06' type='text' value='".$lodgeRoleTenureDate06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_06()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_06\" name=\"lodge_role_06\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_06\" name=\"lodge_role_management_06\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_06' name='lodge_role_tenure_date_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_06($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_06()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_06($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_06()
    {
        return "";
    }

    function edit_lodge_role_07($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate07 = "";
        if(!is_null($user->lodge_role_tenure_date_07))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate07 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_07\" name=\"lodge_role_07\" value=\"".$user->lodge_role_07."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_07\" name=\"lodge_role_management_07\" value=\"".$user->lodge_role_management_07."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_07' name='lodge_role_tenure_date_07' type='text' value='".$lodgeRoleTenureDate07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_07()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_07\" name=\"lodge_role_07\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_07\" name=\"lodge_role_management_07\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_07' name='lodge_role_tenure_date_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_07($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_07()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_07($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_07()
    {
        return "";
    }

    function edit_lodge_role_08($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate08 = "";
        if(!is_null($user->lodge_role_tenure_date_08))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_08);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate08 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_08\" name=\"lodge_role_08\" value=\"".$user->lodge_role_08."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_08\" name=\"lodge_role_management_08\" value=\"".$user->lodge_role_management_08."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_08' name='lodge_role_tenure_date_08' type='text' value='".$lodgeRoleTenureDate08."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_08()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_08\" name=\"lodge_role_08\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_08\" name=\"lodge_role_management_08\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_08' name='lodge_role_tenure_date_08' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_08($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_08()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_08($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_08()
    {
        return "";
    }

    function edit_lodge_role_09($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate09 = "";
        if(!is_null($user->lodge_role_tenure_date_09))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_09);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate09 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_09\" name=\"lodge_role_09\" value=\"".$user->lodge_role_09."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_09\" name=\"lodge_role_management_09\" value=\"".$user->lodge_role_management_09."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_09' name='lodge_role_tenure_date_09' type='text' value='".$lodgeRoleTenureDate09."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_09()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_09\" name=\"lodge_role_09\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_09\" name=\"lodge_role_management_09\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_09' name='lodge_role_tenure_date_09' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_09($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_09()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_09($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_09()
    {
        return "";
    }

    function edit_lodge_role_10($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate10 = "";
        if(!is_null($user->lodge_role_tenure_date_10))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_10);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate10 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_10\" name=\"lodge_role_10\" value=\"".$user->lodge_role_10."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_10\" name=\"lodge_role_management_10\" value=\"".$user->lodge_role_management_10."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_10' name='lodge_role_tenure_date_10' type='text' value='".$lodgeRoleTenureDate10."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_10()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_10\" name=\"lodge_role_10\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_10\" name=\"lodge_role_management_10\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_10' name='lodge_role_tenure_date_10' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_10($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_10()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_10($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_10()
    {
        return "";
    }

    function edit_lodge_role_11($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate11 = "";
        if(!is_null($user->lodge_role_tenure_date_11))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_11);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate11 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_11\" name=\"lodge_role_11\" value=\"".$user->lodge_role_11."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_11\" name=\"lodge_role_management_11\" value=\"".$user->lodge_role_management_11."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_11' name='lodge_role_tenure_date_11' type='text' value='".$lodgeRoleTenureDate11."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_11()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_11\" name=\"lodge_role_11\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_11\" name=\"lodge_role_management_11\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_11' name='lodge_role_tenure_date_11' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_11($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_11()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_11($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_11()
    {
        return "";
    }

    function edit_lodge_role_12($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate12 = "";
        if(!is_null($user->lodge_role_tenure_date_12))
        {
            $pieces = explode("-",$user->lodge_role_tenure_date_12);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate12 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_12\" name=\"lodge_role_12\" value=\"".$user->lodge_role_12."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_12\" name=\"lodge_role_management_12\" value=\"".$user->lodge_role_management_12."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_12' name='lodge_role_tenure_date_12' type='text' value='".$lodgeRoleTenureDate12."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_lodge_role_12()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-lodge_role_12\" name=\"lodge_role_12\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-lodge_role_management_12\" name=\"lodge_role_management_12\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-lodge_role_tenure_date_12' name='lodge_role_tenure_date_12' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_lodge_role_management_12($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_management_12()
    {
        return "";
    }

    function edit_lodge_role_tenure_date_12($value, $primary_key)
    {
        return "";
    }

    function add_lodge_role_tenure_date_12()
    {
        return "";
    }

    function edit_governing_body_role_01($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $governingBodyRoleTenureDate01 = "";
        if(!is_null($user->governing_body_role_tenure_date_01))
        {
            $pieces = explode("-",$user->governing_body_role_tenure_date_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $governingBodyRoleTenureDate01 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_01\" name=\"governing_body_role_01\" value=\"".$user->governing_body_role_01."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_01\" name=\"governing_body_role_management_01\" value=\"".$user->governing_body_role_management_01."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_01' name='governing_body_role_tenure_date_01' type='text' value='".$governingBodyRoleTenureDate01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_governing_body_role_01()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_01\" name=\"governing_body_role_01\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_01\" name=\"governing_body_role_management_01\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_01' name='governing_body_role_tenure_date_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_governing_body_role_management_01($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_management_01()
    {
        return "";
    }

    function edit_governing_body_role_tenure_date_01($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_tenure_date_01()
    {
        return "";
    }

    function edit_governing_body_role_02($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $governingBodyRoleTenureDate02 = "";
        if(!is_null($user->governing_body_role_tenure_date_02))
        {
            $pieces = explode("-",$user->governing_body_role_tenure_date_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $governingBodyRoleTenureDate02 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_02\" name=\"governing_body_role_02\" value=\"".$user->governing_body_role_02."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_02\" name=\"governing_body_role_management_02\" value=\"".$user->governing_body_role_management_02."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_02' name='governing_body_role_tenure_date_02' type='text' value='".$governingBodyRoleTenureDate02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_governing_body_role_02()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_02\" name=\"governing_body_role_02\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_02\" name=\"governing_body_role_management_02\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_02' name='governing_body_role_tenure_date_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_governing_body_role_management_02($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_management_02()
    {
        return "";
    }

    function edit_governing_body_role_tenure_date_02($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_tenure_date_02()
    {
        return "";
    }

    function edit_governing_body_role_03($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $governingBodyRoleTenureDate03 = "";
        if(!is_null($user->governing_body_role_tenure_date_03))
        {
            $pieces = explode("-",$user->governing_body_role_tenure_date_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $governingBodyRoleTenureDate03 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_03\" name=\"governing_body_role_03\" value=\"".$user->governing_body_role_03."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_03\" name=\"governing_body_role_management_03\" value=\"".$user->governing_body_role_management_03."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_03' name='governing_body_role_tenure_date_03' type='text' value='".$governingBodyRoleTenureDate03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_governing_body_role_03()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_03\" name=\"governing_body_role_03\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_03\" name=\"governing_body_role_management_03\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_03' name='governing_body_role_tenure_date_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_governing_body_role_management_03($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_management_03()
    {
        return "";
    }

    function edit_governing_body_role_tenure_date_03($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_tenure_date_03()
    {
        return "";
    }

    function edit_governing_body_role_04($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $governingBodyRoleTenureDate04 = "";
        if(!is_null($user->governing_body_role_tenure_date_04))
        {
            $pieces = explode("-",$user->governing_body_role_tenure_date_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $governingBodyRoleTenureDate04 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_04\" name=\"governing_body_role_04\" value=\"".$user->governing_body_role_04."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_04\" name=\"governing_body_role_management_04\" value=\"".$user->governing_body_role_management_04."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_04' name='governing_body_role_tenure_date_04' type='text' value='".$governingBodyRoleTenureDate04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_governing_body_role_04()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_04\" name=\"governing_body_role_04\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_04\" name=\"governing_body_role_management_04\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_04' name='governing_body_role_tenure_date_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_governing_body_role_management_04($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_management_04()
    {
        return "";
    }

    function edit_governing_body_role_tenure_date_04($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_tenure_date_04()
    {
        return "";
    }

    function edit_governing_body_role_05($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $governingBodyRoleTenureDate05 = "";
        if(!is_null($user->governing_body_role_tenure_date_05))
        {
            $pieces = explode("-",$user->governing_body_role_tenure_date_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $governingBodyRoleTenureDate05 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_05\" name=\"governing_body_role_05\" value=\"".$user->governing_body_role_05."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_05\" name=\"governing_body_role_management_05\" value=\"".$user->governing_body_role_management_05."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_05' name='governing_body_role_tenure_date_05' type='text' value='".$governingBodyRoleTenureDate05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_governing_body_role_05()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_05\" name=\"governing_body_role_05\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_05\" name=\"governing_body_role_management_05\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_05' name='governing_body_role_tenure_date_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_governing_body_role_management_05($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_management_05()
    {
        return "";
    }

    function edit_governing_body_role_tenure_date_05($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_tenure_date_05()
    {
        return "";
    }

    function edit_governing_body_role_06($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $governingBodyRoleTenureDate06 = "";
        if(!is_null($user->governing_body_role_tenure_date_06))
        {
            $pieces = explode("-",$user->governing_body_role_tenure_date_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $governingBodyRoleTenureDate06 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_06\" name=\"governing_body_role_06\" value=\"".$user->governing_body_role_06."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_06\" name=\"governing_body_role_management_06\" value=\"".$user->governing_body_role_management_06."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_06' name='governing_body_role_tenure_date_06' type='text' value='".$governingBodyRoleTenureDate06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_governing_body_role_06()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_06\" name=\"governing_body_role_06\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_06\" name=\"governing_body_role_management_06\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_06' name='governing_body_role_tenure_date_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_governing_body_role_management_06($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_management_06()
    {
        return "";
    }

    function edit_governing_body_role_tenure_date_06($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_tenure_date_06()
    {
        return "";
    }

    function edit_governing_body_role_07($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $governingBodyRoleTenureDate07 = "";
        if(!is_null($user->governing_body_role_tenure_date_07))
        {
            $pieces = explode("-",$user->governing_body_role_tenure_date_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $governingBodyRoleTenureDate07 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_07\" name=\"governing_body_role_07\" value=\"".$user->governing_body_role_07."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_07\" name=\"governing_body_role_management_07\" value=\"".$user->governing_body_role_management_07."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_07' name='governing_body_role_tenure_date_07' type='text' value='".$governingBodyRoleTenureDate07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_governing_body_role_07()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-governing_body_role_07\" name=\"governing_body_role_07\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-governing_body_role_management_07\" name=\"governing_body_role_management_07\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-governing_body_role_tenure_date_07' name='governing_body_role_tenure_date_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_governing_body_role_management_07($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_management_07()
    {
        return "";
    }

    function edit_governing_body_role_tenure_date_07($value, $primary_key)
    {
        return "";
    }

    function add_governing_body_role_tenure_date_07()
    {
        return "";
    }

    function edit_another_role_in_another_degree_01($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $anotherRoleInAnotherDegreeTenureDate01 = "";
        if(!is_null($user->another_role_in_another_degree_tenure_date_01))
        {
            $pieces = explode("-",$user->another_role_in_another_degree_tenure_date_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $anotherRoleInAnotherDegreeTenureDate01 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_01\" name=\"another_role_in_another_degree_01\" value=\"".$user->another_role_in_another_degree_01."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_01\" name=\"another_role_in_another_degree_management_01\" value=\"".$user->another_role_in_another_degree_management_01."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_01' name='another_role_in_another_degree_tenure_date_01' type='text' value='".$anotherRoleInAnotherDegreeTenureDate01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_another_role_in_another_degree_01()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_01\" name=\"another_role_in_another_degree_01\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_01\" name=\"another_role_in_another_degree_management_01\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_01' name='another_role_in_another_degree_tenure_date_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_another_role_in_another_degree_management_01($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_management_01()
    {
        return "";
    }

    function edit_another_role_in_another_degree_tenure_date_01($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_tenure_date_01()
    {
        return "";
    }

    function edit_another_role_in_another_degree_02($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $anotherRoleInAnotherDegreeTenureDate02 = "";
        if(!is_null($user->another_role_in_another_degree_tenure_date_02))
        {
            $pieces = explode("-",$user->another_role_in_another_degree_tenure_date_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $anotherRoleInAnotherDegreeTenureDate02 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_02\" name=\"another_role_in_another_degree_02\" value=\"".$user->another_role_in_another_degree_02."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_02\" name=\"another_role_in_another_degree_management_02\" value=\"".$user->another_role_in_another_degree_management_02."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_02' name='another_role_in_another_degree_tenure_date_02' type='text' value='".$anotherRoleInAnotherDegreeTenureDate02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_another_role_in_another_degree_02()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_02\" name=\"another_role_in_another_degree_02\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_02\" name=\"another_role_in_another_degree_management_02\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_02' name='another_role_in_another_degree_tenure_date_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_another_role_in_another_degree_management_02($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_management_02()
    {
        return "";
    }

    function edit_another_role_in_another_degree_tenure_date_02($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_tenure_date_02()
    {
        return "";
    }

    function edit_another_role_in_another_degree_03($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $anotherRoleInAnotherDegreeTenureDate03 = "";
        if(!is_null($user->another_role_in_another_degree_tenure_date_03))
        {
            $pieces = explode("-",$user->another_role_in_another_degree_tenure_date_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $anotherRoleInAnotherDegreeTenureDate03 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_03\" name=\"another_role_in_another_degree_03\" value=\"".$user->another_role_in_another_degree_03."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_03\" name=\"another_role_in_another_degree_management_03\" value=\"".$user->another_role_in_another_degree_management_03."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_03' name='another_role_in_another_degree_tenure_date_03' type='text' value='".$anotherRoleInAnotherDegreeTenureDate03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_another_role_in_another_degree_03()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_03\" name=\"another_role_in_another_degree_03\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_03\" name=\"another_role_in_another_degree_management_03\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_03' name='another_role_in_another_degree_tenure_date_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_another_role_in_another_degree_management_03($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_management_03()
    {
        return "";
    }

    function edit_another_role_in_another_degree_tenure_date_03($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_tenure_date_03()
    {
        return "";
    }

    function edit_another_role_in_another_degree_04($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $anotherRoleInAnotherDegreeTenureDate04 = "";
        if(!is_null($user->another_role_in_another_degree_tenure_date_04))
        {
            $pieces = explode("-",$user->another_role_in_another_degree_tenure_date_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $anotherRoleInAnotherDegreeTenureDate04 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_04\" name=\"another_role_in_another_degree_04\" value=\"".$user->another_role_in_another_degree_04."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_04\" name=\"another_role_in_another_degree_management_04\" value=\"".$user->another_role_in_another_degree_management_04."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_04' name='another_role_in_another_degree_tenure_date_04' type='text' value='".$anotherRoleInAnotherDegreeTenureDate04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_another_role_in_another_degree_04()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_04\" name=\"another_role_in_another_degree_04\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_04\" name=\"another_role_in_another_degree_management_04\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_04' name='another_role_in_another_degree_tenure_date_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_another_role_in_another_degree_management_04($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_management_04()
    {
        return "";
    }

    function edit_another_role_in_another_degree_tenure_date_04($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_tenure_date_04()
    {
        return "";
    }

    function edit_another_role_in_another_degree_05($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $anotherRoleInAnotherDegreeTenureDate05 = "";
        if(!is_null($user->another_role_in_another_degree_tenure_date_05))
        {
            $pieces = explode("-",$user->another_role_in_another_degree_tenure_date_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $anotherRoleInAnotherDegreeTenureDate05 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_05\" name=\"another_role_in_another_degree_05\" value=\"".$user->another_role_in_another_degree_05."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_05\" name=\"another_role_in_another_degree_management_05\" value=\"".$user->another_role_in_another_degree_management_05."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_05' name='another_role_in_another_degree_tenure_date_05' type='text' value='".$anotherRoleInAnotherDegreeTenureDate05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_another_role_in_another_degree_05()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_05\" name=\"another_role_in_another_degree_05\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_05\" name=\"another_role_in_another_degree_management_05\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_05' name='another_role_in_another_degree_tenure_date_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_another_role_in_another_degree_management_05($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_management_05()
    {
        return "";
    }

    function edit_another_role_in_another_degree_tenure_date_05($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_tenure_date_05()
    {
        return "";
    }

    function edit_another_role_in_another_degree_06($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $anotherRoleInAnotherDegreeTenureDate06 = "";
        if(!is_null($user->another_role_in_another_degree_tenure_date_06))
        {
            $pieces = explode("-",$user->another_role_in_another_degree_tenure_date_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $anotherRoleInAnotherDegreeTenureDate06 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_06\" name=\"another_role_in_another_degree_06\" value=\"".$user->another_role_in_another_degree_06."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_06\" name=\"another_role_in_another_degree_management_06\" value=\"".$user->another_role_in_another_degree_management_06."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_06' name='another_role_in_another_degree_tenure_date_06' type='text' value='".$anotherRoleInAnotherDegreeTenureDate06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_another_role_in_another_degree_06()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_06\" name=\"another_role_in_another_degree_06\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_06\" name=\"another_role_in_another_degree_management_06\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_06' name='another_role_in_another_degree_tenure_date_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_another_role_in_another_degree_management_06($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_management_06()
    {
        return "";
    }

    function edit_another_role_in_another_degree_tenure_date_06($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_tenure_date_06()
    {
        return "";
    }

    function edit_another_role_in_another_degree_07($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $anotherRoleInAnotherDegreeTenureDate07 = "";
        if(!is_null($user->another_role_in_another_degree_tenure_date_07))
        {
            $pieces = explode("-",$user->another_role_in_another_degree_tenure_date_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $anotherRoleInAnotherDegreeTenureDate07 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_07\" name=\"another_role_in_another_degree_07\" value=\"".$user->another_role_in_another_degree_07."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_07\" name=\"another_role_in_another_degree_management_07\" value=\"".$user->another_role_in_another_degree_management_07."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_07' name='another_role_in_another_degree_tenure_date_07' type='text' value='".$anotherRoleInAnotherDegreeTenureDate07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_another_role_in_another_degree_07()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-another_role_in_another_degree_07\" name=\"another_role_in_another_degree_07\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-another_role_in_another_degree_management_07\" name=\"another_role_in_another_degree_management_07\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-another_role_in_another_degree_tenure_date_07' name='another_role_in_another_degree_tenure_date_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_another_role_in_another_degree_management_07($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_management_07()
    {
        return "";
    }

    function edit_another_role_in_another_degree_tenure_date_07($value, $primary_key)
    {
        return "";
    }

    function add_another_role_in_another_degree_tenure_date_07()
    {
        return "";
    }

    function edit_social_entity_role_01($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $lodgeRoleTenureDate01 = "";
        if(!is_null($user->social_entity_role_tenure_date_01))
        {
            $pieces = explode("-",$user->social_entity_role_tenure_date_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $lodgeRoleTenureDate01 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_01\" name=\"social_entity_role_01\" value=\"".$user->social_entity_role_01."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_01\" name=\"social_entity_role_management_01\" value=\"".$user->social_entity_role_management_01."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_01' name='social_entity_role_tenure_date_01' type='text' value='".$lodgeRoleTenureDate01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_social_entity_role_01()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_01\" name=\"social_entity_role_01\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_01\" name=\"social_entity_role_management_01\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_01' name='social_entity_role_tenure_date_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_social_entity_role_management_01($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_management_01()
    {
        return "";
    }

    function edit_social_entity_role_tenure_date_01($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_tenure_date_01()
    {
        return "";
    }

    function edit_social_entity_role_02($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $socialEntityRoleTenureDate02 = "";
        if(!is_null($user->social_entity_role_tenure_date_02))
        {
            $pieces = explode("-",$user->social_entity_role_tenure_date_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $socialEntityRoleTenureDate02 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_02\" name=\"social_entity_role_02\" value=\"".$user->social_entity_role_02."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_02\" name=\"social_entity_role_management_02\" value=\"".$user->social_entity_role_management_02."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_02' name='social_entity_role_tenure_date_02' type='text' value='".$socialEntityRoleTenureDate02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_social_entity_role_02()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_02\" name=\"social_entity_role_02\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_02\" name=\"social_entity_role_management_02\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_02' name='social_entity_role_tenure_date_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_social_entity_role_management_02($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_management_02()
    {
        return "";
    }

    function edit_social_entity_role_tenure_date_02($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_tenure_date_02()
    {
        return "";
    }

    function edit_social_entity_role_03($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $socialEntityRoleTenureDate03 = "";
        if(!is_null($user->social_entity_role_tenure_date_03))
        {
            $pieces = explode("-",$user->social_entity_role_tenure_date_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $socialEntityRoleTenureDate03 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_03\" name=\"social_entity_role_03\" value=\"".$user->social_entity_role_03."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_03\" name=\"social_entity_role_management_03\" value=\"".$user->social_entity_role_management_03."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_03' name='social_entity_role_tenure_date_03' type='text' value='".$socialEntityRoleTenureDate03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_social_entity_role_03()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_03\" name=\"social_entity_role_03\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_03\" name=\"social_entity_role_management_03\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_03' name='social_entity_role_tenure_date_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_social_entity_role_management_03($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_management_03()
    {
        return "";
    }

    function edit_social_entity_role_tenure_date_03($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_tenure_date_03()
    {
        return "";
    }

    function edit_social_entity_role_04($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $socialEntityRoleTenureDate04 = "";
        if(!is_null($user->social_entity_role_tenure_date_04))
        {
            $pieces = explode("-",$user->social_entity_role_tenure_date_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $socialEntityRoleTenureDate04 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_04\" name=\"social_entity_role_04\" value=\"".$user->social_entity_role_04."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_04\" name=\"social_entity_role_management_04\" value=\"".$user->social_entity_role_management_04."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_04' name='social_entity_role_tenure_date_04' type='text' value='".$socialEntityRoleTenureDate04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_social_entity_role_04()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_04\" name=\"social_entity_role_04\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_04\" name=\"social_entity_role_management_04\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_04' name='social_entity_role_tenure_date_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_social_entity_role_management_04($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_management_04()
    {
        return "";
    }

    function edit_social_entity_role_tenure_date_04($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_tenure_date_04()
    {
        return "";
    }

    function edit_social_entity_role_05($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $socialEntityRoleTenureDate05 = "";
        if(!is_null($user->social_entity_role_tenure_date_05))
        {
            $pieces = explode("-",$user->social_entity_role_tenure_date_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $socialEntityRoleTenureDate05 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_05\" name=\"social_entity_role_05\" value=\"".$user->social_entity_role_05."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_05\" name=\"social_entity_role_management_05\" value=\"".$user->social_entity_role_management_05."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_05' name='social_entity_role_tenure_date_05' type='text' value='".$socialEntityRoleTenureDate05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_social_entity_role_05()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_05\" name=\"social_entity_role_05\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_05\" name=\"social_entity_role_management_05\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_05' name='social_entity_role_tenure_date_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_social_entity_role_management_05($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_management_05()
    {
        return "";
    }

    function edit_social_entity_role_tenure_date_05($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_tenure_date_05()
    {
        return "";
    }

    function edit_social_entity_role_06($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $socialEntityRoleTenureDate06 = "";
        if(!is_null($user->social_entity_role_tenure_date_06))
        {
            $pieces = explode("-",$user->social_entity_role_tenure_date_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $socialEntityRoleTenureDate06 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_06\" name=\"social_entity_role_06\" value=\"".$user->social_entity_role_06."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_06\" name=\"social_entity_role_management_06\" value=\"".$user->social_entity_role_management_06."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_06' name='social_entity_role_tenure_date_06' type='text' value='".$socialEntityRoleTenureDate06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_social_entity_role_06()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_06\" name=\"social_entity_role_06\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_06\" name=\"social_entity_role_management_06\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_06' name='social_entity_role_tenure_date_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_social_entity_role_management_06($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_management_06()
    {
        return "";
    }

    function edit_social_entity_role_tenure_date_06($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_tenure_date_06()
    {
        return "";
    }

    function edit_social_entity_role_07($value, $primary_key)
    {
        $this->db->where('id',$primary_key);
        $user = $this->db->get('users')->row();

        $socialEntityRoleTenureDate07 = "";
        if(!is_null($user->social_entity_role_tenure_date_07))
        {
            $pieces = explode("-",$user->social_entity_role_tenure_date_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $socialEntityRoleTenureDate07 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_07\" name=\"social_entity_role_07\" value=\"".$user->social_entity_role_07."\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_07\" name=\"social_entity_role_management_07\" value=\"".$user->social_entity_role_management_07."\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_07' name='social_entity_role_tenure_date_07' type='text' value='".$socialEntityRoleTenureDate07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_social_entity_role_07()
    {
        return  "<table><tr><td>Cargo</td><td>Gest&atilde;o</td><td>Data da Posse</td></tr><tr><td><input id=\"field-social_entity_role_07\" name=\"social_entity_role_07\" maxlength=\"100\" type=\"text\"></td><td><input id=\"field-social_entity_role_management_07\" name=\"social_entity_role_management_07\" maxlength=\"9\" type=\"text\" style='width: 80px;' ></td><td><input id='field-social_entity_role_tenure_date_07' name='social_entity_role_tenure_date_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_social_entity_role_management_07($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_management_07()
    {
        return "";
    }

    function edit_social_entity_role_tenure_date_07($value, $primary_key)
    {
        return "";
    }

    function add_social_entity_role_tenure_date_07()
    {
        return "";
    }

    function edit_received_instruction_01($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $receivedInstruction01 = "";
        if(!is_null($user->received_instruction_01))
        {
            $pieces = explode("-",$user->received_instruction_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $receivedInstruction01 = implode("/", $dateFormatArray);
        }

        $deliveredWorkInstruction01 = "";
        if(!is_null($user->delivered_work_instruction_01))
        {
            $pieces = explode("-",$user->delivered_work_instruction_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredWorkInstruction01 = implode("/", $dateFormatArray);
        }

        $presentedWorkInstruction01 = "";
        if(!is_null($user->presented_work_instruction_01))
        {
            $pieces = explode("-",$user->presented_work_instruction_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedWorkInstruction01 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_01' name='received_instruction_01' type='text' value='".$receivedInstruction01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_01' name='delivered_work_instruction_01' type='text' value='".$deliveredWorkInstruction01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_01' name='presented_work_instruction_01' type='text' value='".$presentedWorkInstruction01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_received_instruction_01()
    {
        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_01' name='received_instruction_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_01' name='delivered_work_instruction_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_01' name='presented_work_instruction_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_work_instruction_01($value, $primary_key)
    {
        return "";
    }

    function add_delivered_work_instruction_01()
    {
        return "";
    }

    function edit_presented_work_instruction_01($value, $primary_key)
    {
        return "";
    }

    function add_presented_work_instruction_01()
    {
        return "";
    }

    function edit_received_instruction_02($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $receivedInstruction02 = "";
        if(!is_null($user->received_instruction_02))
        {
            $pieces = explode("-",$user->received_instruction_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $receivedInstruction02 = implode("/", $dateFormatArray);
        }

        $deliveredWorkInstruction02 = "";
        if(!is_null($user->delivered_work_instruction_02))
        {
//            $fp = fopen('/tmp/data.txt', 'w');
//            fwrite($fp, print_r($user->received_instruction_02, true));
//            fwrite($fp, print_r($user->received_instruction_02, true));
//            fwrite($fp, "\n");
//            fclose($fp);
            $pieces = explode("-",$user->delivered_work_instruction_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredWorkInstruction02 = implode("/", $dateFormatArray);
        }

        $presentedWorkInstruction02 = "";
        if(!is_null($user->presented_work_instruction_02))
        {
            $pieces = explode("-",$user->presented_work_instruction_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedWorkInstruction02 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_02' name='received_instruction_02' type='text' value='".$receivedInstruction02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_02' name='delivered_work_instruction_02' type='text' value='".$deliveredWorkInstruction02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_02' name='presented_work_instruction_02' type='text' value='".$presentedWorkInstruction02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_received_instruction_02()
    {
        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_02' name='received_instruction_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_02' name='delivered_work_instruction_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_02' name='presented_work_instruction_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_work_instruction_02($value, $primary_key)
    {
        return "";
    }

    function add_delivered_work_instruction_02()
    {
        return "";
    }

    function edit_presented_work_instruction_02($value, $primary_key)
    {
        return "";
    }

    function add_presented_work_instruction_02()
    {
        return "";
    }

    function edit_received_instruction_03($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $receivedInstruction03 = "";
        if(!is_null($user->received_instruction_03))
        {
            $pieces = explode("-",$user->received_instruction_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $receivedInstruction03 = implode("/", $dateFormatArray);
        }

        $deliveredWorkInstruction03 = "";
        if(!is_null($user->delivered_work_instruction_03))
        {
            $pieces = explode("-",$user->delivered_work_instruction_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredWorkInstruction03 = implode("/", $dateFormatArray);
        }

        $presentedWorkInstruction03 = "";
        if(!is_null($user->presented_work_instruction_03))
        {
            $pieces = explode("-",$user->presented_work_instruction_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedWorkInstruction03 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_03' name='received_instruction_03' type='text' value='".$receivedInstruction03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_03' name='delivered_work_instruction_03' type='text' value='".$deliveredWorkInstruction03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_03' name='presented_work_instruction_03' type='text' value='".$presentedWorkInstruction03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_received_instruction_03()
    {
        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_03' name='received_instruction_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_03' name='delivered_work_instruction_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_03' name='presented_work_instruction_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_work_instruction_03($value, $primary_key)
    {
        return "";
    }

    function add_delivered_work_instruction_03()
    {
        return "";
    }

    function edit_presented_work_instruction_03($value, $primary_key)
    {
        return "";
    }

    function add_presented_work_instruction_03()
    {
        return "";
    }

    function edit_received_instruction_04($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $receivedInstruction04 = "";
        if(!is_null($user->received_instruction_04))
        {
            $pieces = explode("-",$user->received_instruction_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $receivedInstruction04 = implode("/", $dateFormatArray);
        }

        $deliveredWorkInstruction04 = "";
        if(!is_null($user->delivered_work_instruction_04))
        {
            $pieces = explode("-",$user->delivered_work_instruction_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredWorkInstruction04 = implode("/", $dateFormatArray);
        }

        $presentedWorkInstruction04 = "";
        if(!is_null($user->presented_work_instruction_04))
        {
            $pieces = explode("-",$user->presented_work_instruction_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedWorkInstruction04 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_04' name='received_instruction_04' type='text' value='".$receivedInstruction04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_04' name='delivered_work_instruction_04' type='text' value='".$deliveredWorkInstruction04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_04' name='presented_work_instruction_04' type='text' value='".$presentedWorkInstruction04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_received_instruction_04()
    {
        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_04' name='received_instruction_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_04' name='delivered_work_instruction_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_04' name='presented_work_instruction_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_work_instruction_04($value, $primary_key)
    {
        return "";
    }

    function add_delivered_work_instruction_04()
    {
        return "";
    }

    function edit_presented_work_instruction_04($value, $primary_key)
    {
        return "";
    }

    function add_presented_work_instruction_04()
    {
        return "";
    }

    function edit_received_instruction_05($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $receivedInstruction05 = "";
        if(!is_null($user->received_instruction_05))
        {
            $pieces = explode("-",$user->received_instruction_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $receivedInstruction05 = implode("/", $dateFormatArray);
        }

        $deliveredWorkInstruction05 = "";
        if(!is_null($user->delivered_work_instruction_05))
        {
            $pieces = explode("-",$user->delivered_work_instruction_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredWorkInstruction05 = implode("/", $dateFormatArray);
        }

        $presentedWorkInstruction05 = "";
        if(!is_null($user->presented_work_instruction_05))
        {
            $pieces = explode("-",$user->presented_work_instruction_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedWorkInstruction05 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_05' name='received_instruction_05' type='text' value='".$receivedInstruction05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_05' name='delivered_work_instruction_05' type='text' value='".$deliveredWorkInstruction05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_05' name='presented_work_instruction_05' type='text' value='".$presentedWorkInstruction05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_received_instruction_05()
    {
        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_05' name='received_instruction_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_05' name='delivered_work_instruction_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_05' name='presented_work_instruction_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_work_instruction_05($value, $primary_key)
    {
        return "";
    }

    function add_delivered_work_instruction_05()
    {
        return "";
    }

    function edit_presented_work_instruction_05($value, $primary_key)
    {
        return "";
    }

    function add_presented_work_instruction_05()
    {
        return "";
    }

    function edit_received_instruction_06($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $receivedInstruction06 = "";
        if(!is_null($user->received_instruction_06))
        {
            $pieces = explode("-",$user->received_instruction_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $receivedInstruction06 = implode("/", $dateFormatArray);
        }

        $deliveredWorkInstruction06 = "";
        if(!is_null($user->delivered_work_instruction_06))
        {
            $pieces = explode("-",$user->delivered_work_instruction_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredWorkInstruction06 = implode("/", $dateFormatArray);
        }

        $presentedWorkInstruction06 = "";
        if(!is_null($user->presented_work_instruction_06))
        {
            $pieces = explode("-",$user->presented_work_instruction_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedWorkInstruction06 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_06' name='received_instruction_06' type='text' value='".$receivedInstruction06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_06' name='delivered_work_instruction_06' type='text' value='".$deliveredWorkInstruction06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_06' name='presented_work_instruction_06' type='text' value='".$presentedWorkInstruction06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_received_instruction_06()
    {
        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_06' name='received_instruction_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_06' name='delivered_work_instruction_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_06' name='presented_work_instruction_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_work_instruction_06($value, $primary_key)
    {
        return "";
    }

    function add_delivered_work_instruction_06()
    {
        return "";
    }

    function edit_presented_work_instruction_06($value, $primary_key)
    {
        return "";
    }

    function add_presented_work_instruction_06()
    {
        return "";
    }

    function edit_received_instruction_07($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $receivedInstruction07 = "";
        if(!is_null($user->received_instruction_07))
        {
            $pieces = explode("-",$user->received_instruction_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $receivedInstruction07 = implode("/", $dateFormatArray);
        }

        $deliveredWorkInstruction07 = "";
        if(!is_null($user->delivered_work_instruction_07))
        {
            $pieces = explode("-",$user->delivered_work_instruction_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredWorkInstruction07 = implode("/", $dateFormatArray);
        }

        $presentedWorkInstruction07 = "";
        if(!is_null($user->presented_work_instruction_07))
        {
            $pieces = explode("-",$user->presented_work_instruction_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedWorkInstruction07 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_07' name='received_instruction_07' type='text' value='".$receivedInstruction07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_07' name='delivered_work_instruction_07' type='text' value='".$deliveredWorkInstruction07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_07' name='presented_work_instruction_07' type='text' value='".$presentedWorkInstruction07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_received_instruction_07()
    {
        return  "<table><tr><td>Data de Recebimento</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id='field-received_instruction_07' name='received_instruction_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-delivered_work_instruction_07' name='delivered_work_instruction_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_work_instruction_07' name='presented_work_instruction_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_work_instruction_07($value, $primary_key)
    {
        return "";
    }

    function add_delivered_work_instruction_07()
    {
        return "";
    }

    function edit_presented_work_instruction_07($value, $primary_key)
    {
        return "";
    }

    function add_presented_work_instruction_07()
    {
        return "";
    }

    function edit_extra_work_title_01($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $deliveredExtraWork01 = "";
        if(!is_null($user->delivered_extra_work_01))
        {
            $pieces = explode("-",$user->delivered_extra_work_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredExtraWork01 = implode("/", $dateFormatArray);
        }

        $presentedExtraWork01 = "";
        if(!is_null($user->presented_extra_work_01))
        {
            $pieces = explode("-",$user->presented_extra_work_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedExtraWork01 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_01\" name=\"extra_work_title_01\" value=\"".$user->extra_work_title_01."\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_01' name='delivered_extra_work_01' type='text' value='".$deliveredExtraWork01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_01' name='presented_extra_work_01' type='text' value='".$presentedExtraWork01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_extra_work_title_01()
    {
        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_01\" name=\"extra_work_title_01\" value=\"\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_01' name='delivered_extra_work_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_01' name='presented_extra_work_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_extra_work_01($value, $primary_key)
    {
        return "";
    }

    function add_delivered_extra_work_01()
    {
        return "";
    }

    function edit_presented_extra_work_01($value, $primary_key)
    {
        return "";
    }

    function add_presented_extra_work_01()
    {
        return "";
    }

    function edit_extra_work_title_02($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $deliveredExtraWork02 = "";
        if(!is_null($user->delivered_extra_work_02))
        {
            $pieces = explode("-",$user->delivered_extra_work_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredExtraWork02 = implode("/", $dateFormatArray);
        }

        $presentedExtraWork02 = "";
        if(!is_null($user->presented_extra_work_02))
        {
            $pieces = explode("-",$user->presented_extra_work_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedExtraWork02 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_02\" name=\"extra_work_title_02\" value=\"".$user->extra_work_title_02."\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_02' name='delivered_extra_work_02' type='text' value='".$deliveredExtraWork02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_02' name='presented_extra_work_02' type='text' value='".$presentedExtraWork02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_extra_work_title_02()
    {
        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_02\" name=\"extra_work_title_02\" value=\"\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_02' name='delivered_extra_work_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_02' name='presented_extra_work_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_extra_work_02($value, $primary_key)
    {
        return "";
    }

    function add_delivered_extra_work_02()
    {
        return "";
    }

    function edit_presented_extra_work_02($value, $primary_key)
    {
        return "";
    }

    function add_presented_extra_work_02()
    {
        return "";
    }

    function edit_extra_work_title_03($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $deliveredExtraWork03 = "";
        if(!is_null($user->delivered_extra_work_03))
        {
            $pieces = explode("-",$user->delivered_extra_work_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredExtraWork03 = implode("/", $dateFormatArray);
        }

        $presentedExtraWork03 = "";
        if(!is_null($user->presented_extra_work_03))
        {
            $pieces = explode("-",$user->presented_extra_work_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedExtraWork03 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_03\" name=\"extra_work_title_03\" value=\"".$user->extra_work_title_03."\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_03' name='delivered_extra_work_03' type='text' value='".$deliveredExtraWork03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_03' name='presented_extra_work_03' type='text' value='".$presentedExtraWork03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_extra_work_title_03()
    {
        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_03\" name=\"extra_work_title_03\" value=\"\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_03' name='delivered_extra_work_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_03' name='presented_extra_work_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_extra_work_03($value, $primary_key)
    {
        return "";
    }

    function add_delivered_extra_work_03()
    {
        return "";
    }

    function edit_presented_extra_work_03($value, $primary_key)
    {
        return "";
    }

    function add_presented_extra_work_03()
    {
        return "";
    }

    function edit_extra_work_title_04($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $deliveredExtraWork04 = "";
        if(!is_null($user->delivered_extra_work_04))
        {
            $pieces = explode("-",$user->delivered_extra_work_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredExtraWork04 = implode("/", $dateFormatArray);
        }

        $presentedExtraWork04 = "";
        if(!is_null($user->presented_extra_work_04))
        {
            $pieces = explode("-",$user->presented_extra_work_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedExtraWork04 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_04\" name=\"extra_work_title_04\" value=\"".$user->extra_work_title_04."\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_04' name='delivered_extra_work_04' type='text' value='".$deliveredExtraWork04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_04' name='presented_extra_work_04' type='text' value='".$presentedExtraWork04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_extra_work_title_04()
    {
        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_04\" name=\"extra_work_title_04\" value=\"\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_04' name='delivered_extra_work_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_04' name='presented_extra_work_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_extra_work_04($value, $primary_key)
    {
        return "";
    }

    function add_delivered_extra_work_04()
    {
        return "";
    }

    function edit_presented_extra_work_04($value, $primary_key)
    {
        return "";
    }

    function add_presented_extra_work_04()
    {
        return "";
    }

    function edit_extra_work_title_05($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $deliveredExtraWork05 = "";
        if(!is_null($user->delivered_extra_work_05))
        {
            $pieces = explode("-",$user->delivered_extra_work_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredExtraWork05 = implode("/", $dateFormatArray);
        }

        $presentedExtraWork05 = "";
        if(!is_null($user->presented_extra_work_05))
        {
            $pieces = explode("-",$user->presented_extra_work_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedExtraWork05 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_05\" name=\"extra_work_title_05\" value=\"".$user->extra_work_title_05."\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_05' name='delivered_extra_work_05' type='text' value='".$deliveredExtraWork05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_05' name='presented_extra_work_05' type='text' value='".$presentedExtraWork05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_extra_work_title_05()
    {
        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_05\" name=\"extra_work_title_05\" value=\"\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_05' name='delivered_extra_work_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_05' name='presented_extra_work_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_extra_work_05($value, $primary_key)
    {
        return "";
    }

    function add_delivered_extra_work_05()
    {
        return "";
    }

    function edit_presented_extra_work_05($value, $primary_key)
    {
        return "";
    }

    function add_presented_extra_work_05()
    {
        return "";
    }

    function edit_extra_work_title_06($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $deliveredExtraWork06 = "";
        if(!is_null($user->delivered_extra_work_06))
        {
            $pieces = explode("-",$user->delivered_extra_work_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredExtraWork06 = implode("/", $dateFormatArray);
        }

        $presentedExtraWork06 = "";
        if(!is_null($user->presented_extra_work_06))
        {
            $pieces = explode("-",$user->presented_extra_work_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedExtraWork06 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_06\" name=\"extra_work_title_06\" value=\"".$user->extra_work_title_06."\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_06' name='delivered_extra_work_06' type='text' value='".$deliveredExtraWork06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_06' name='presented_extra_work_06' type='text' value='".$presentedExtraWork06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_extra_work_title_06()
    {
        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_06\" name=\"extra_work_title_06\" value=\"\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_06' name='delivered_extra_work_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_06' name='presented_extra_work_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_extra_work_06($value, $primary_key)
    {
        return "";
    }

    function add_delivered_extra_work_06()
    {
        return "";
    }

    function edit_presented_extra_work_06($value, $primary_key)
    {
        return "";
    }

    function add_presented_extra_work_06()
    {
        return "";
    }

    function edit_extra_work_title_07($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $deliveredExtraWork07 = "";
        if(!is_null($user->delivered_extra_work_07))
        {
            $pieces = explode("-",$user->delivered_extra_work_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $deliveredExtraWork07 = implode("/", $dateFormatArray);
        }

        $presentedExtraWork07 = "";
        if(!is_null($user->presented_extra_work_07))
        {
            $pieces = explode("-",$user->presented_extra_work_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $presentedExtraWork07 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_07\" name=\"extra_work_title_07\" value=\"".$user->extra_work_title_07."\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_07' name='delivered_extra_work_07' type='text' value='".$deliveredExtraWork07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_07' name='presented_extra_work_07' type='text' value='".$presentedExtraWork07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_extra_work_title_07()
    {
        return  "<table><tr><td>T&iacute;tulo</td><td>Data de Entrega do Trabalho</td><td>Data de Leitura do Trabalho</td></tr><tr><td><input id=\"field-extra_work_title_07\" name=\"extra_work_title_07\" value=\"\" maxlength=\"100\" type=\"text\"></td><td><input id='field-delivered_extra_work_07' name='delivered_extra_work_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td><td><input id='field-presented_extra_work_07' name='presented_extra_work_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_delivered_extra_work_07($value, $primary_key)
    {
        return "";
    }

    function add_delivered_extra_work_07()
    {
        return "";
    }

    function edit_presented_extra_work_07($value, $primary_key)
    {
        return "";
    }

    function add_presented_extra_work_07()
    {
        return "";
    }

    function edit_visit_lodge_name_01($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectRites = "<select id=\"field-visit_lodge_rite_id_01\" name=\"visit_lodge_rite_id_01\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            if($user->visit_lodge_rite_id_01 == $row->id){
                $selectRites .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_01\" name=\"visit_lodge_governing_body_id_01\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            if($user->visit_lodge_governing_body_id_01 == $row->id){
                $selectGoverningBodies .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectGoverningBodies .= "</select>";

        $visitLodgeDate01 = "";
        if(!is_null($user->visit_lodge_date_01))
        {
            $pieces = explode("-",$user->visit_lodge_date_01);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $visitLodgeDate01 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_01\" name=\"visit_lodge_name_01\" value=\"".$user->visit_lodge_name_01."\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_01\" name=\"visit_lodge_number_01\" value=\"".$user->visit_lodge_number_01."\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_01' name='visit_lodge_date_01' type='text' value='".$visitLodgeDate01."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_visit_lodge_name_01()
    {
        $selectRites = "<select id=\"field-visit_lodge_rite_id_01\" name=\"visit_lodge_rite_id_01\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_01\" name=\"visit_lodge_governing_body_id_01\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectGoverningBodies .= "</select>";

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_01\" name=\"visit_lodge_name_01\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_01\" name=\"visit_lodge_number_01\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_01' name='visit_lodge_date_01' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_visit_lodge_number_01($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_number_01()
    {
        return "";
    }

    function edit_visit_lodge_rite_id_01($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_rite_id_01()
    {
        return "";
    }

    function edit_visit_lodge_governing_body_id_01($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_governing_body_id_01()
    {
        return "";
    }

    function edit_visit_lodge_date_01($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_date_01()
    {
        return "";
    }

    function edit_visit_lodge_session_degree_id_01($value, $primary_key)
    {
        $table = "";
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history"){
            $table = $this->uri->segment(2);
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_01\" name=\"visit_lodge_session_degree_id_01\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            if($user->visit_lodge_session_degree_id_01 == $row->id){
                $selectDegrees .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_01\" name=\"visit_lodge_worshipful_master_phone_01\" value=\"".$user->visit_lodge_worshipful_master_phone_01."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_01\" name=\"visit_lodge_worshipful_master_email_01\" value=\"".$user->visit_lodge_worshipful_master_email_01."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_01\" name=\"visit_lodge_warden_name_01\" value=\"".$user->visit_lodge_warden_name_01."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_01\" name=\"visit_lodge_warden_phone_01\" value=\"".$user->visit_lodge_warden_phone_01."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_01\" name=\"visit_lodge_warden_email_01\" value=\"".$user->visit_lodge_warden_email_01."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_01\" name=\"visit_lodge_worshipful_master_name_01\" value=\"".$user->visit_lodge_worshipful_master_name_01."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function add_visit_lodge_session_degree_id_01()
    {
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history"){
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }
        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_01\" name=\"visit_lodge_session_degree_id_01\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_01\" name=\"visit_lodge_worshipful_master_phone_01\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_01\" name=\"visit_lodge_worshipful_master_email_01\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_01\" name=\"visit_lodge_warden_name_01\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_01\" name=\"visit_lodge_warden_phone_01\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_01\" name=\"visit_lodge_warden_email_01\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_01\" name=\"visit_lodge_worshipful_master_name_01\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function edit_visit_lodge_worshipful_master_name_01($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_worshipful_master_name_01()
    {
        return "";
    }

    function edit_visit_lodge_warden_name_01($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_name_01()
    {
        return "";
    }

    function edit_visit_lodge_warden_phone_01($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_phone_01()
    {
        return "";
    }

    function edit_visit_lodge_warden_email_01($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_email_01()
    {
        return "";
    }

    function edit_visit_lodge_name_02($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectRites = "<select id=\"field-visit_lodge_rite_id_02\" name=\"visit_lodge_rite_id_02\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            if($user->visit_lodge_rite_id_02 == $row->id){
                $selectRites .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_02\" name=\"visit_lodge_governing_body_id_02\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            if($user->visit_lodge_governing_body_id_02 == $row->id){
                $selectGoverningBodies .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectGoverningBodies .= "</select>";

        $visitLodgeDate02 = "";
        if(!is_null($user->visit_lodge_date_02))
        {
            $pieces = explode("-",$user->visit_lodge_date_02);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $visitLodgeDate02 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_02\" name=\"visit_lodge_name_02\" value=\"".$user->visit_lodge_name_02."\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_02\" name=\"visit_lodge_number_02\" value=\"".$user->visit_lodge_number_02."\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_02' name='visit_lodge_date_02' type='text' value='".$visitLodgeDate02."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_visit_lodge_name_02()
    {
        $selectRites = "<select id=\"field-visit_lodge_rite_id_02\" name=\"visit_lodge_rite_id_02\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_02\" name=\"visit_lodge_governing_body_id_02\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectGoverningBodies .= "</select>";

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_02\" name=\"visit_lodge_name_02\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_02\" name=\"visit_lodge_number_02\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_02' name='visit_lodge_date_02' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_visit_lodge_number_02($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_number_02()
    {
        return "";
    }

    function edit_visit_lodge_rite_id_02($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_rite_id_02()
    {
        return "";
    }

    function edit_visit_lodge_governing_body_id_02($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_governing_body_id_02()
    {
        return "";
    }

    function edit_visit_lodge_date_02($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_date_02()
    {
        return "";
    }

    function edit_visit_lodge_session_degree_id_02($value, $primary_key)
    {
        $table = "";
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history"){
            $table = $this->uri->segment(2);
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_02\" name=\"visit_lodge_session_degree_id_02\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            if($user->visit_lodge_session_degree_id_02 == $row->id){
                $selectDegrees .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_02\" name=\"visit_lodge_worshipful_master_phone_02\" value=\"".$user->visit_lodge_worshipful_master_phone_02."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_02\" name=\"visit_lodge_worshipful_master_email_02\" value=\"".$user->visit_lodge_worshipful_master_email_02."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_02\" name=\"visit_lodge_warden_name_02\" value=\"".$user->visit_lodge_warden_name_02."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_02\" name=\"visit_lodge_warden_phone_02\" value=\"".$user->visit_lodge_warden_phone_02."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_02\" name=\"visit_lodge_warden_email_02\" value=\"".$user->visit_lodge_warden_email_02."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_02\" name=\"visit_lodge_worshipful_master_name_02\" value=\"".$user->visit_lodge_worshipful_master_name_02."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function add_visit_lodge_session_degree_id_02()
    {
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history"){
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_02\" name=\"visit_lodge_session_degree_id_02\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_02\" name=\"visit_lodge_worshipful_master_phone_02\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_02\" name=\"visit_lodge_worshipful_master_email_02\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_02\" name=\"visit_lodge_warden_name_02\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_02\" name=\"visit_lodge_warden_phone_02\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_02\" name=\"visit_lodge_warden_email_02\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_02\" name=\"visit_lodge_worshipful_master_name_02\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function edit_visit_lodge_worshipful_master_name_02($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_worshipful_master_name_02()
    {
        return "";
    }

    function edit_visit_lodge_warden_name_02($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_name_02()
    {
        return "";
    }

    function edit_visit_lodge_warden_phone_02($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_phone_02()
    {
        return "";
    }

    function edit_visit_lodge_warden_email_02($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_email_02()
    {
        return "";
    }

    function edit_visit_lodge_name_03($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectRites = "<select id=\"field-visit_lodge_rite_id_03\" name=\"visit_lodge_rite_id_03\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            if($user->visit_lodge_rite_id_03 == $row->id){
                $selectRites .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_03\" name=\"visit_lodge_governing_body_id_03\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            if($user->visit_lodge_governing_body_id_03 == $row->id){
                $selectGoverningBodies .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectGoverningBodies .= "</select>";

        $visitLodgeDate03 = "";
        if(!is_null($user->visit_lodge_date_03))
        {
            $pieces = explode("-",$user->visit_lodge_date_03);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $visitLodgeDate03 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_03\" name=\"visit_lodge_name_03\" value=\"".$user->visit_lodge_name_03."\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_03\" name=\"visit_lodge_number_03\" value=\"".$user->visit_lodge_number_03."\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_03' name='visit_lodge_date_03' type='text' value='".$visitLodgeDate03."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_visit_lodge_name_03()
    {
        $selectRites = "<select id=\"field-visit_lodge_rite_id_03\" name=\"visit_lodge_rite_id_03\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_03\" name=\"visit_lodge_governing_body_id_03\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectGoverningBodies .= "</select>";

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_03\" name=\"visit_lodge_name_03\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_03\" name=\"visit_lodge_number_03\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_03' name='visit_lodge_date_03' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_visit_lodge_number_03($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_number_03()
    {
        return "";
    }

    function edit_visit_lodge_rite_id_03($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_rite_id_03()
    {
        return "";
    }

    function edit_visit_lodge_governing_body_id_03($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_governing_body_id_03()
    {
        return "";
    }

    function edit_visit_lodge_date_03($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_date_03()
    {
        return "";
    }

    function edit_visit_lodge_session_degree_id_03($value, $primary_key)
    {
        $table = "";
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history"){
            $table = $this->uri->segment(2);
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_03\" name=\"visit_lodge_session_degree_id_03\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            if($user->visit_lodge_session_degree_id_03 == $row->id){
                $selectDegrees .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_03\" name=\"visit_lodge_worshipful_master_phone_03\" value=\"".$user->visit_lodge_worshipful_master_phone_03."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_03\" name=\"visit_lodge_worshipful_master_email_03\" value=\"".$user->visit_lodge_worshipful_master_email_03."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_03\" name=\"visit_lodge_warden_name_03\" value=\"".$user->visit_lodge_warden_name_03."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_03\" name=\"visit_lodge_warden_phone_03\" value=\"".$user->visit_lodge_warden_phone_03."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_03\" name=\"visit_lodge_warden_email_03\" value=\"".$user->visit_lodge_warden_email_03."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_03\" name=\"visit_lodge_worshipful_master_name_03\" value=\"".$user->visit_lodge_worshipful_master_name_03."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function add_visit_lodge_session_degree_id_03()
    {
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history"){
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_03\" name=\"visit_lodge_session_degree_id_03\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_03\" name=\"visit_lodge_worshipful_master_phone_03\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_03\" name=\"visit_lodge_worshipful_master_email_03\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_03\" name=\"visit_lodge_warden_name_03\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_03\" name=\"visit_lodge_warden_phone_03\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_03\" name=\"visit_lodge_warden_email_03\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_03\" name=\"visit_lodge_worshipful_master_name_03\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function edit_visit_lodge_worshipful_master_name_03($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_worshipful_master_name_03()
    {
        return "";
    }

    function edit_visit_lodge_warden_name_03($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_name_03()
    {
        return "";
    }

    function edit_visit_lodge_warden_phone_03($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_phone_03()
    {
        return "";
    }

    function edit_visit_lodge_warden_email_03($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_email_03()
    {
        return "";
    }

    function edit_visit_lodge_name_04($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectRites = "<select id=\"field-visit_lodge_rite_id_04\" name=\"visit_lodge_rite_id_04\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            if($user->visit_lodge_rite_id_04 == $row->id){
                $selectRites .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_04\" name=\"visit_lodge_governing_body_id_04\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            if($user->visit_lodge_governing_body_id_04 == $row->id){
                $selectGoverningBodies .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectGoverningBodies .= "</select>";

        $visitLodgeDate04 = "";
        if(!is_null($user->visit_lodge_date_04))
        {
            $pieces = explode("-",$user->visit_lodge_date_04);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $visitLodgeDate04 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_04\" name=\"visit_lodge_name_04\" value=\"".$user->visit_lodge_name_04."\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_04\" name=\"visit_lodge_number_04\" value=\"".$user->visit_lodge_number_04."\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_04' name='visit_lodge_date_04' type='text' value='".$visitLodgeDate04."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_visit_lodge_name_04()
    {
        $selectRites = "<select id=\"field-visit_lodge_rite_id_04\" name=\"visit_lodge_rite_id_04\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_04\" name=\"visit_lodge_governing_body_id_04\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectGoverningBodies .= "</select>";

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_04\" name=\"visit_lodge_name_04\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_04\" name=\"visit_lodge_number_04\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_04' name='visit_lodge_date_04' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_visit_lodge_number_04($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_number_04()
    {
        return "";
    }

    function edit_visit_lodge_rite_id_04($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_rite_id_04()
    {
        return "";
    }

    function edit_visit_lodge_governing_body_id_04($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_governing_body_id_04()
    {
        return "";
    }

    function edit_visit_lodge_date_04($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_date_04()
    {
        return "";
    }

    function edit_visit_lodge_session_degree_id_04($value, $primary_key)
    {
        $table = "";
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history"){
            $table = $this->uri->segment(2);
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_04\" name=\"visit_lodge_session_degree_id_04\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            if($user->visit_lodge_session_degree_id_04 == $row->id){
                $selectDegrees .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_04\" name=\"visit_lodge_worshipful_master_phone_04\" value=\"".$user->visit_lodge_worshipful_master_phone_04."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_04\" name=\"visit_lodge_worshipful_master_email_04\" value=\"".$user->visit_lodge_worshipful_master_email_04."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_04\" name=\"visit_lodge_warden_name_04\" value=\"".$user->visit_lodge_warden_name_04."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_04\" name=\"visit_lodge_warden_phone_04\" value=\"".$user->visit_lodge_warden_phone_04."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_04\" name=\"visit_lodge_warden_email_04\" value=\"".$user->visit_lodge_warden_email_04."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_04\" name=\"visit_lodge_worshipful_master_name_04\" value=\"".$user->visit_lodge_worshipful_master_name_04."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function add_visit_lodge_session_degree_id_04()
    {
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history"){
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_04\" name=\"visit_lodge_session_degree_id_04\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_04\" name=\"visit_lodge_worshipful_master_phone_04\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_04\" name=\"visit_lodge_worshipful_master_email_04\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_04\" name=\"visit_lodge_warden_name_04\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_04\" name=\"visit_lodge_warden_phone_04\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_04\" name=\"visit_lodge_warden_email_04\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_04\" name=\"visit_lodge_worshipful_master_name_04\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function edit_visit_lodge_worshipful_master_name_04($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_worshipful_master_name_04()
    {
        return "";
    }

    function edit_visit_lodge_warden_name_04($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_name_04()
    {
        return "";
    }

    function edit_visit_lodge_warden_phone_04($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_phone_04()
    {
        return "";
    }

    function edit_visit_lodge_warden_email_04($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_email_04()
    {
        return "";
    }

    function edit_visit_lodge_name_05($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectRites = "<select id=\"field-visit_lodge_rite_id_05\" name=\"visit_lodge_rite_id_05\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            if($user->visit_lodge_rite_id_05 == $row->id){
                $selectRites .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_05\" name=\"visit_lodge_governing_body_id_05\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            if($user->visit_lodge_governing_body_id_05 == $row->id){
                $selectGoverningBodies .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectGoverningBodies .= "</select>";

        $visitLodgeDate05 = "";
        if(!is_null($user->visit_lodge_date_05))
        {
            $pieces = explode("-",$user->visit_lodge_date_05);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $visitLodgeDate05 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_05\" name=\"visit_lodge_name_05\" value=\"".$user->visit_lodge_name_05."\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_05\" name=\"visit_lodge_number_05\" value=\"".$user->visit_lodge_number_05."\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_05' name='visit_lodge_date_05' type='text' value='".$visitLodgeDate05."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_visit_lodge_name_05()
    {
        $selectRites = "<select id=\"field-visit_lodge_rite_id_05\" name=\"visit_lodge_rite_id_05\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_05\" name=\"visit_lodge_governing_body_id_05\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectGoverningBodies .= "</select>";

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_05\" name=\"visit_lodge_name_05\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_05\" name=\"visit_lodge_number_05\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_05' name='visit_lodge_date_05' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_visit_lodge_number_05($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_number_05()
    {
        return "";
    }

    function edit_visit_lodge_rite_id_05($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_rite_id_05()
    {
        return "";
    }

    function edit_visit_lodge_governing_body_id_05($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_governing_body_id_05()
    {
        return "";
    }

    function edit_visit_lodge_date_05($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_date_05()
    {
        return "";
    }

    function edit_visit_lodge_session_degree_id_05($value, $primary_key)
    {
        $table = "";
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history"){
            $table = $this->uri->segment(2);
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_05\" name=\"visit_lodge_session_degree_id_05\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            if($user->visit_lodge_session_degree_id_05 == $row->id){
                $selectDegrees .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_05\" name=\"visit_lodge_worshipful_master_phone_05\" value=\"".$user->visit_lodge_worshipful_master_phone_05."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_05\" name=\"visit_lodge_worshipful_master_email_05\" value=\"".$user->visit_lodge_worshipful_master_email_05."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_05\" name=\"visit_lodge_warden_name_05\" value=\"".$user->visit_lodge_warden_name_05."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_05\" name=\"visit_lodge_warden_phone_05\" value=\"".$user->visit_lodge_warden_phone_05."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_05\" name=\"visit_lodge_warden_email_05\" value=\"".$user->visit_lodge_warden_email_05."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_05\" name=\"visit_lodge_worshipful_master_name_05\" value=\"".$user->visit_lodge_worshipful_master_name_05."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function add_visit_lodge_session_degree_id_05()
    {
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history"){
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_05\" name=\"visit_lodge_session_degree_id_05\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_05\" name=\"visit_lodge_worshipful_master_phone_05\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_05\" name=\"visit_lodge_worshipful_master_email_05\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_05\" name=\"visit_lodge_warden_name_05\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_05\" name=\"visit_lodge_warden_phone_05\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_05\" name=\"visit_lodge_warden_email_05\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_05\" name=\"visit_lodge_worshipful_master_name_05\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function edit_visit_lodge_worshipful_master_name_05($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_worshipful_master_name_05()
    {
        return "";
    }

    function edit_visit_lodge_warden_name_05($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_name_05()
    {
        return "";
    }

    function edit_visit_lodge_warden_phone_05($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_phone_05()
    {
        return "";
    }

    function edit_visit_lodge_warden_email_05($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_email_05()
    {
        return "";
    }

    function edit_visit_lodge_name_06($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectRites = "<select id=\"field-visit_lodge_rite_id_06\" name=\"visit_lodge_rite_id_06\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            if($user->visit_lodge_rite_id_06 == $row->id){
                $selectRites .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_06\" name=\"visit_lodge_governing_body_id_06\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            if($user->visit_lodge_governing_body_id_06 == $row->id){
                $selectGoverningBodies .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectGoverningBodies .= "</select>";

        $visitLodgeDate06 = "";
        if(!is_null($user->visit_lodge_date_06))
        {
            $pieces = explode("-",$user->visit_lodge_date_06);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $visitLodgeDate06 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_06\" name=\"visit_lodge_name_06\" value=\"".$user->visit_lodge_name_06."\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_06\" name=\"visit_lodge_number_06\" value=\"".$user->visit_lodge_number_06."\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_06' name='visit_lodge_date_06' type='text' value='".$visitLodgeDate06."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_visit_lodge_name_06()
    {
        $selectRites = "<select id=\"field-visit_lodge_rite_id_06\" name=\"visit_lodge_rite_id_06\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_06\" name=\"visit_lodge_governing_body_id_06\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectGoverningBodies .= "</select>";

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_06\" name=\"visit_lodge_name_06\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_06\" name=\"visit_lodge_number_06\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_06' name='visit_lodge_date_06' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_visit_lodge_number_06($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_number_06()
    {
        return "";
    }

    function edit_visit_lodge_rite_id_06($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_rite_id_06()
    {
        return "";
    }

    function edit_visit_lodge_governing_body_id_06($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_governing_body_id_06()
    {
        return "";
    }

    function edit_visit_lodge_date_06($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_date_06()
    {
        return "";
    }

    function edit_visit_lodge_session_degree_id_06($value, $primary_key)
    {
        $table = "";
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history"){
            $table = $this->uri->segment(2);
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_06\" name=\"visit_lodge_session_degree_id_06\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            if($user->visit_lodge_session_degree_id_06 == $row->id){
                $selectDegrees .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_06\" name=\"visit_lodge_worshipful_master_phone_06\" value=\"".$user->visit_lodge_worshipful_master_phone_06."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_06\" name=\"visit_lodge_worshipful_master_email_06\" value=\"".$user->visit_lodge_worshipful_master_email_06."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_06\" name=\"visit_lodge_warden_name_06\" value=\"".$user->visit_lodge_warden_name_06."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_06\" name=\"visit_lodge_warden_phone_06\" value=\"".$user->visit_lodge_warden_phone_06."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_06\" name=\"visit_lodge_warden_email_06\" value=\"".$user->visit_lodge_warden_email_06."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_06\" name=\"visit_lodge_worshipful_master_name_06\" value=\"".$user->visit_lodge_worshipful_master_name_06."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function add_visit_lodge_session_degree_id_06()
    {
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history"){
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_06\" name=\"visit_lodge_session_degree_id_06\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_06\" name=\"visit_lodge_worshipful_master_phone_06\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_06\" name=\"visit_lodge_worshipful_master_email_06\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_06\" name=\"visit_lodge_warden_name_06\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_06\" name=\"visit_lodge_warden_phone_06\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_06\" name=\"visit_lodge_warden_email_06\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_06\" name=\"visit_lodge_worshipful_master_name_06\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function edit_visit_lodge_worshipful_master_name_06($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_worshipful_master_name_06()
    {
        return "";
    }

    function edit_visit_lodge_warden_name_06($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_name_06()
    {
        return "";
    }

    function edit_visit_lodge_warden_phone_06($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_phone_06()
    {
        return "";
    }

    function edit_visit_lodge_warden_email_06($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_email_06()
    {
        return "";
    }

    function edit_visit_lodge_name_07($value, $primary_key)
    {
        $table = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history")
            $table = $this->uri->segment(2);

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectRites = "<select id=\"field-visit_lodge_rite_id_07\" name=\"visit_lodge_rite_id_07\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            if($user->visit_lodge_rite_id_07 == $row->id){
                $selectRites .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_07\" name=\"visit_lodge_governing_body_id_07\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            if($user->visit_lodge_governing_body_id_07 == $row->id){
                $selectGoverningBodies .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectGoverningBodies .= "</select>";

        $visitLodgeDate07 = "";
        if(!is_null($user->visit_lodge_date_07))
        {
            $pieces = explode("-",$user->visit_lodge_date_07);
            $dateFormatArray = array($pieces[2], $pieces[1], $pieces[0]);
            $visitLodgeDate07 = implode("/", $dateFormatArray);
        }

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_07\" name=\"visit_lodge_name_07\" value=\"".$user->visit_lodge_name_07."\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_07\" name=\"visit_lodge_number_07\" value=\"".$user->visit_lodge_number_07."\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_07' name='visit_lodge_date_07' type='text' value='".$visitLodgeDate07."' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function add_visit_lodge_name_07()
    {
        $selectRites = "<select id=\"field-visit_lodge_rite_id_07\" name=\"visit_lodge_rite_id_07\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Rito\" style=\"width: 240px;\">";
        $selectRites .= "<option value=\"\"></option>";
        $rites = $this->db->get('rites');
        foreach ($rites->result() as $row){
            $selectRites .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectRites .= "</select>";

        $selectGoverningBodies = "<select id=\"field-visit_lodge_governing_body_id_07\" name=\"visit_lodge_governing_body_id_07\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Pot&ecirc;ncia\" style=\"width: 100px;\">";
        $selectGoverningBodies .= "<option value=\"\"></option>";
        $governingBodies = $this->db->get('governing_bodies');
        foreach ($governingBodies->result() as $row){
            $selectGoverningBodies .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectGoverningBodies .= "</select>";

        return  "<table><tr><td>A&there4;R&there4;L&there4;S&there4;</td><td>N&uacute;mero</td><td>Rito</td><td>Pot&ecirc;ncia</td><td>Data da Visita</td></tr><tr><td><input id=\"field-visit_lodge_name_07\" name=\"visit_lodge_name_07\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 250px;\"></td><td><input id=\"field-visit_lodge_number_07\" name=\"visit_lodge_number_07\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 50px;\"></td><td>".$selectRites."</td><td>".$selectGoverningBodies."</td><td><input id='field-visit_lodge_date_07' name='visit_lodge_date_07' type='text' value='' maxlength='10' class='datepicker-input' /> <a class='datepicker-input-clear' tabindex='-1'>Clear</a> (dd/mm/yyyy)</td></tr></table>";
    }

    function edit_visit_lodge_number_07($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_number_07()
    {
        return "";
    }

    function edit_visit_lodge_rite_id_07($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_rite_id_07()
    {
        return "";
    }

    function edit_visit_lodge_governing_body_id_07($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_governing_body_id_07()
    {
        return "";
    }

    function edit_visit_lodge_date_07($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_date_07()
    {
        return "";
    }

    function edit_visit_lodge_session_degree_id_07($value, $primary_key)
    {
        $table = "";
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history" || $this->uri->segment(2) == "master_history"){
            $table = $this->uri->segment(2);
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $this->db->where('id',$primary_key);
        $user = $this->db->get($table)->row();

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_07\" name=\"visit_lodge_session_degree_id_07\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            if($user->visit_lodge_session_degree_id_07 == $row->id){
                $selectDegrees .= "<option value=\"".$row->id."\" selected>" . $row->name . "</option>";
            }
            else{
                $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
            }
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_07\" name=\"visit_lodge_worshipful_master_phone_07\" value=\"".$user->visit_lodge_worshipful_master_phone_07."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_07\" name=\"visit_lodge_worshipful_master_email_07\" value=\"".$user->visit_lodge_worshipful_master_email_07."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_07\" name=\"visit_lodge_warden_name_07\" value=\"".$user->visit_lodge_warden_name_07."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_07\" name=\"visit_lodge_warden_phone_07\" value=\"".$user->visit_lodge_warden_phone_07."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_07\" name=\"visit_lodge_warden_email_07\" value=\"".$user->visit_lodge_warden_email_07."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_07\" name=\"visit_lodge_worshipful_master_name_07\" value=\"".$user->visit_lodge_worshipful_master_name_07."\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function add_visit_lodge_session_degree_id_07()
    {
        $vig = "";
        if($this->uri->segment(2) == "apprentice_history" || $this->uri->segment(2) == "fellowcraft_history"){
            $vig = ($this->uri->segment(2) == "apprentice_history") ? "1" : "2";
        }

        $selectDegrees = "<select id=\"field-visit_lodge_session_degree_id_07\" name=\"visit_lodge_session_degree_id_07\" class=\"chosen-select chzn-done\" data-placeholder=\"Selecionar Grau da Sess&atilde;o\" style=\"width: 240px;\">";
        $selectDegrees .= "<option value=\"\"></option>";
        $degrees = $this->db->get('degrees');
        foreach ($degrees->result() as $row){
            $selectDegrees .= "<option value=\"".$row->id."\">" . $row->name . "</option>";
        }
        $selectDegrees .= "</select>";

        $txtPrefix = ($this->uri->segment(2) == "master_history") ? "<td>Telefone do V&there4; M&there4;</td><td>E-Mail do V&there4; M&there4;</td>" : "<td>Nome do ".$vig."&ordm; Vig&there4;</td><td>Telefone do ".$vig."&ordm; Vig&there4;</td><td>E-Mail do ".$vig."&ordm; Vig&there4;</td>";
        $txtSuffix = ($this->uri->segment(2) == "master_history") ? "<td><input id=\"field-visit_lodge_worshipful_master_phone_07\" name=\"visit_lodge_worshipful_master_phone_07\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_worshipful_master_email_07\" name=\"visit_lodge_worshipful_master_email_07\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>" : "<td><input id=\"field-visit_lodge_warden_name_07\" name=\"visit_lodge_warden_name_07\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_phone_07\" name=\"visit_lodge_warden_phone_07\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td><td><input id=\"field-visit_lodge_warden_email_07\" name=\"visit_lodge_warden_email_07\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>";

        return  "<table><tr><td>Grau da Sess&atilde;o</td><td>Nome do V&there4; M&there4;</td>".$txtPrefix."</tr><tr><td>".$selectDegrees."</td><td><input id=\"field-visit_lodge_worshipful_master_name_07\" name=\"visit_lodge_worshipful_master_name_07\" value=\"\" maxlength=\"100\" type=\"text\" style=\"width: 190px;\"></td>".$txtSuffix."</tr></table>";
    }

    function edit_visit_lodge_worshipful_master_name_07($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_worshipful_master_name_07()
    {
        return "";
    }

    function edit_visit_lodge_warden_name_07($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_name_07()
    {
        return "";
    }

    function edit_visit_lodge_warden_phone_07($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_phone_07()
    {
        return "";
    }

    function edit_visit_lodge_warden_email_07($value, $primary_key)
    {
        return "";
    }

    function add_visit_lodge_warden_email_07()
    {
        return "";
    }

    public function users()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('users.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('users');

            $this->grocery_crud->set_subject('Obreiro');
            $this->grocery_crud->fields('id', 'governing_body_id', 'lodge_id', 'profile_picture', 'masonic_profiles', 'matrix_profiles', 'name', 'email', 'password', 'webpage', 'aboutme', 'wife_id', 'nephews', 'address', 'phone', 'mobile', 'house_status_id', 'birth_date', 'birth_city', 'birth_state', 'father_name', 'mother_name', 'occupation', 'occupation_document', 'occupation_document_emission_date', 'civil_status_id', 'identity_document', 'identity_document_emission_organ', 'identity_document_emission_date', 'cpf', 'scholarity_id', 'formation', 'languages', 'company_name', 'company_activity_id', 'company_address', 'company_mobile', 'company_phone', 'company_email', 'company_website', 'in_company_role', 'admission_date', 'income', 'other_activities', 'masonic_birth_date', 'courtship_start_date', 'marriage_date', 'hobby_practitioner_1', 'hobby_activity_1', 'hobby_practitioner_2', 'hobby_activity_2', 'hobby_practitioner_3', 'hobby_activity_3', 'hobby_practitioner_4', 'hobby_activity_4', 'hobby_practitioner_5', 'hobby_activity_5', 'hobby_practitioner_6', 'hobby_activity_6', 'degree_id', 'cim', 'sponsor_name', 'type_of_acceptance_id', 'pre-proposal_entry_date', 'first_pre-proposal_reading_date', 'second_pre-proposal_reading_date', 'third_pre-proposal_reading_date', 'approved_inquiry_expedition', 'approved_inquiry_expedition_date', 'inquiry_done', 'inquiry_done_date', 'inquiry_master_01', 'inquiry_master_02', 'inquiry_master_03', 'more_inquiry_masters_01', 'more_inquiry_masters_02', 'more_inquiry_masters_03', 'approved_spouse_inquiry_expedition', 'approved_spouse_inquiry_expedition_date', 'spouse_inquiry_done', 'spouse_inquiry_done_date', 'spouse_inquiry_master_01', 'spouse_inquiry_master_02', 'spouse_inquiry_master_03', 'proposal_copies', 'medical_certificate', 'notary_notification_certificate', 'criminal_certificate', 'civil_certificate', 'reading_at', 'approved_by_id', 'approval_observations', 'proposal_for_id', 'recorded_at_governing_body_in', 'published_in_bulletin_number', 'bulletin_date_publication', 'bulletin_observations', 'admission_observations', 'initiation_request_placet_date', 'initiation_placet_number', 'initiation_placet_date', 'initiation_date', 'argumentation_for_grade_2_date', 'argumentation_for_grade_2_approved_by_id', 'argumentation_for_grade_2_approval_observations', 'elevation_request_placet_date', 'elevation_placet_number', 'elevation_placet_date', 'elevation_date', 'argumentation_for_grade_3_date', 'argumentation_for_grade_3_approved_by_id', 'argumentation_for_grade_3_approval_observations', 'exaltation_request_placet_date', 'exaltation_placet_number', 'exaltation_placet_date', 'exaltation_date', 'installation_and_tenure', 'philosophical_degree_id', 'rite_id', 'philosophical_degree_observations', 'user_history', 'lodge_leaving_reason', 'leaving_lodge_request_date', 'leaving_lodge_approved_by_id', 'leaving_lodge_request_observations', 'leaving_lodge_recorded_at_governing_body_in', 'leaving_lodge_published_in_bulletin_number', 'leaving_lodge_bulletin_date_publication', 'leaving_lodge_bulletin_observations', 'leaving_lodge_observations', 'lodge_role_01', 'lodge_role_management_01', 'lodge_role_tenure_date_01', 'lodge_role_02', 'lodge_role_management_02', 'lodge_role_tenure_date_02', 'lodge_role_03', 'lodge_role_management_03', 'lodge_role_tenure_date_03', 'lodge_role_04', 'lodge_role_management_04', 'lodge_role_tenure_date_04', 'lodge_role_05', 'lodge_role_management_05', 'lodge_role_tenure_date_05', 'lodge_role_06', 'lodge_role_management_06', 'lodge_role_tenure_date_06', 'lodge_role_07', 'lodge_role_management_07', 'lodge_role_tenure_date_07', 'lodge_role_08', 'lodge_role_management_08', 'lodge_role_tenure_date_08', 'lodge_role_09', 'lodge_role_management_09', 'lodge_role_tenure_date_09', 'lodge_role_10', 'lodge_role_management_10', 'lodge_role_tenure_date_10', 'lodge_role_11', 'lodge_role_management_11', 'lodge_role_tenure_date_11', 'lodge_role_12', 'lodge_role_management_12', 'lodge_role_tenure_date_12', 'governing_body_role_01', 'governing_body_role_management_01', 'governing_body_role_tenure_date_01', 'governing_body_role_02', 'governing_body_role_management_02', 'governing_body_role_tenure_date_02', 'governing_body_role_03', 'governing_body_role_management_03', 'governing_body_role_tenure_date_03', 'governing_body_role_04', 'governing_body_role_management_04', 'governing_body_role_tenure_date_04', 'governing_body_role_05', 'governing_body_role_management_05', 'governing_body_role_tenure_date_05', 'governing_body_role_06', 'governing_body_role_management_06', 'governing_body_role_tenure_date_06', 'governing_body_role_07', 'governing_body_role_management_07', 'governing_body_role_tenure_date_07', 'another_role_in_another_degree_01', 'another_role_in_another_degree_management_01', 'another_role_in_another_degree_tenure_date_01', 'another_role_in_another_degree_02', 'another_role_in_another_degree_management_02', 'another_role_in_another_degree_tenure_date_02', 'another_role_in_another_degree_03', 'another_role_in_another_degree_management_03', 'another_role_in_another_degree_tenure_date_03', 'another_role_in_another_degree_04', 'another_role_in_another_degree_management_04', 'another_role_in_another_degree_tenure_date_04', 'another_role_in_another_degree_05', 'another_role_in_another_degree_management_05', 'another_role_in_another_degree_tenure_date_05', 'another_role_in_another_degree_06', 'another_role_in_another_degree_management_06', 'another_role_in_another_degree_tenure_date_06', 'another_role_in_another_degree_07', 'another_role_in_another_degree_management_07', 'another_role_in_another_degree_tenure_date_07', 'social_entity_role_01', 'social_entity_role_management_01', 'social_entity_role_tenure_date_01', 'social_entity_role_02', 'social_entity_role_management_02', 'social_entity_role_tenure_date_02', 'social_entity_role_03', 'social_entity_role_management_03', 'social_entity_role_tenure_date_03', 'social_entity_role_04', 'social_entity_role_management_04', 'social_entity_role_tenure_date_04', 'social_entity_role_05', 'social_entity_role_management_05', 'social_entity_role_tenure_date_05', 'social_entity_role_06', 'social_entity_role_management_06', 'social_entity_role_tenure_date_06', 'social_entity_role_07', 'social_entity_role_management_07', 'social_entity_role_tenure_date_07', 'general_observations');
            $this->grocery_crud->required_fields('degree_id', 'cim', 'name', 'email', 'password');
            $this->grocery_crud->display_as('lodge_id', 'Loja')
                ->display_as('degree_id', 'Grau')
                ->display_as('cim','N&uacute;mero da Identidade Ma&ccedil;&ocirc;nica')
                ->display_as('profile_picture','Foto')
                ->display_as('masonic_profiles', 'Perfil Ma&ccedil;&ocirc;nico')
                ->display_as('matrix_profiles', 'Matriz de Perfil')
                ->display_as('house_status_id', 'Im&oacute;vel')
                ->display_as('name','Nome')
                ->display_as('email', 'E-Mail')
                ->display_as('password','Senha')
                ->display_as('webpage','Home Page')
                ->display_as('aboutme','Sobre')
                ->display_as('wife_id','Cunhada')
                ->display_as('nephews', 'Sobrinhos(as)')
                ->display_as('address','Endere&ccedil;o')
                ->display_as('phone','Telefone')
                ->display_as('mobile','Celular')
                ->display_as('birth_date', 'Data de Nascimento')
                ->display_as('birth_city', 'Cidade de Nascimento')
                ->display_as('birth_state', 'Estado de Nascimento')
                ->display_as('father_name', 'Nome do Pai')
                ->display_as('mother_name', 'Nome da M&atilde;e')
                ->display_as('occupation', 'Profiss&atilde;o')
                ->display_as('occupation_document', 'Documento de Atividade Profissional')
                ->display_as('occupation_document_emission_date', 'Data de Emiss&atilde;o')
                ->display_as('civil_status_id', 'Estado Civil')
                ->display_as('identity_document', 'Documento de Identidade')
                ->display_as('identity_document_emission_organ', '&Oacute;rg&atilde;o Emissor')
                ->display_as('identity_document_emission_date', 'Data de Emiss&atilde;o')
                ->display_as('cpf', 'CPF')
                ->display_as('scholarity_id', 'Escolaridade')
                ->display_as('formation', 'Forma&ccedil;&atilde;o')
                ->display_as('languages', 'Idiomas')
                ->display_as('company_name', 'Nome da empresa ou reparti&ccedil;&atilde;o que trabalha')
                ->display_as('company_activity_id', 'Ramo de Atividade da Empresa')
                ->display_as('company_address', 'Endere&ccedil;o Comercial')
                ->display_as('company_mobile', 'Celular Corporativo')
                ->display_as('company_phone', 'Telefone Comercial')
                ->display_as('company_email', 'E-mail Profissional')
                ->display_as('company_website', 'Site Corporativo')
                ->display_as('in_company_role', 'Cargo')
                ->display_as('admission_date', 'Data de Admiss&atilde;o')
                ->display_as('income', 'Sal&aacute;rio')
                ->display_as('other_activities', 'Outras Atividades')
                ->display_as('masonic_birth_date', 'Anivers&aacute;rio Ma&ccedil;&ocirc;nico')
                ->display_as('courtship_start_date', 'In&iacute;cio de Namoro com a Cunhada')
                ->display_as('marriage_date', 'Data de Casamento')
                ->display_as('hobby_practitioner_1', 'Hobby 01')
                ->display_as('hobby_practitioner_2', 'Hobby 02')
                ->display_as('hobby_practitioner_3', 'Hobby 03')
                ->display_as('hobby_practitioner_4', 'Hobby 04')
                ->display_as('hobby_practitioner_5', 'Hobby 05')
                ->display_as('hobby_practitioner_6', 'Hobby 06')
                ->display_as('sponsor_name', 'Nome do Padrinho Ma&ccedil;&ocirc;nico')
                ->display_as('type_of_acceptance_id', 'Processo de Entrada')
                ->display_as('pre-proposal_entry_date', 'Entrada Pr&eacute;-Proposta Bolsa')
                ->display_as('first_pre-proposal_reading_date', 'Data da Primeira Leitura da Pr&eacute;-Proposta')
                ->display_as('second_pre-proposal_reading_date', 'Data da Segunda Leitura da Pr&eacute;-Proposta')
                ->display_as('third_pre-proposal_reading_date', 'Data da Terceira Leitura da Pr&eacute;-Proposta')
                ->display_as('approved_inquiry_expedition', 'Expedi&ccedil;&atilde;o da sindic&acirc;ncia com o candidato')
                ->display_as('inquiry_done', 'Sindic&acirc;ncia Realizada')
                ->display_as('inquiry_master_01', 'Nome dos 3 MM&there4; IInst&there4; Participantes da Sindic&acirc;ncia')
                ->display_as('more_inquiry_masters_01', 'Outros MM&there4; participantes da Sindic&acirc;ncia')
                ->display_as('approved_spouse_inquiry_expedition', 'Expedi&ccedil;&atilde;o da sindic&acirc;ncia com a esposa do candidato')
                ->display_as('spouse_inquiry_done','Sindic&acirc;ncia Realizada')
                ->display_as('spouse_inquiry_master_01', 'Nome dos 3 MM&there4; participantes da sindic&acirc;ncia com a esposa, sendo pelo menos um M&there4; Inst&there4; ')
                ->display_as('proposal_copies', 'Duas vias da proposta')
                ->display_as('medical_certificate', 'Atestado M&eacute;dico')
                ->display_as('notary_notification_certificate', 'Certid&otilde;es de Protesto')
                ->display_as('criminal_certificate', 'Certid&atilde;o Criminal')
                ->display_as('civil_certificate', 'Certid&atilde;o C&iacute;vel')
                ->display_as('reading_at', 'Leitura em')
                ->display_as('approved_by_id', 'Aprova&ccedil;&atilde;o')
                ->display_as('approval_observations', 'Observa&ccedil;&otildees sobre a Aprova&ccedil;&atilde;o/Rejei&ccedil;&atilde;o')
                ->display_as('proposal_for_id', 'Proposta de')
                ->display_as('recorded_at_governing_body_in', 'Protocolado na Pot&there4; em')
                ->display_as('published_in_bulletin_number', 'Publicado no boletim n&ordm;')
                ->display_as('bulletin_date_publication', 'Data do boletim')
                ->display_as('bulletin_observations', 'Observa&ccedil;&otilde;es sobre o boletim')
                ->display_as('admission_observations', 'Observa&ccedil;&otilde;es sobre a admiss&atilde;o')
                ->display_as('initiation_request_placet_date', 'Data do pedido de placet de inicia&ccedil;&atilde;o')
                ->display_as('initiation_placet_number', 'N&ordm; do placet de inicia&ccedil;&atilde;o')
                ->display_as('initiation_placet_date', 'Data do placet de inicia&ccedil;&atilde;o')
                ->display_as('initiation_date', 'Data da inicia&ccedil;&atilde;o')
                ->display_as('argumentation_for_grade_2_date', 'Data da argui&ccedil;&atilde;o para o grau 2')
                ->display_as('argumentation_for_grade_2_approved_by_id', 'Aprova&ccedil;&atilde;o da argui&ccedil;&atilde;o para o grau 2')
                ->display_as('argumentation_for_grade_2_approval_observations', 'Observa&ccedil;&otildees sobre a Aprova&ccedil;&atilde;o/Rejei&ccedil;&atilde;o da argui&ccedil;&atilde;o para o grau 2')
                ->display_as('elevation_request_placet_date', 'Data do pedido de placet de eleva&ccedil;&atilde;o')
                ->display_as('elevation_placet_number', 'N&ordm; do placet de eleva&ccedil;&atilde;o')
                ->display_as('elevation_placet_date', 'Data do placet de eleva&ccedil;&atilde;o')
                ->display_as('elevation_date', 'Data da eleva&ccedil;&atilde;o')
                ->display_as('argumentation_for_grade_3_date', 'Data da argui&ccedil;&atilde;o para o grau 3')
                ->display_as('argumentation_for_grade_3_approved_by_id', 'Aprova&ccedil;&atilde;o da argui&ccedil;&atilde;o para o grau 3')
                ->display_as('argumentation_for_grade_3_approval_observations', 'Observa&ccedil;&otildees sobre a Aprova&ccedil;&atilde;o/Rejei&ccedil;&atilde;o da argui&ccedil;&atilde;o para o grau 3')
                ->display_as('exaltation_request_placet_date', 'Data do pedido de placet de exalta&ccedil;&atilde;o')
                ->display_as('exaltation_placet_number', 'N&ordm; do placet de exalta&ccedil;&atilde;o')
                ->display_as('exaltation_placet_date', 'Data do placet de exalta&ccedil;&atilde;o')
                ->display_as('exaltation_date', 'Data da exalta&ccedil;&atilde;o')
                ->display_as('installation_and_tenure', 'Instala&ccedil;&atilde;o e Posse')
                ->display_as('philosophical_degree_id', 'Graus Filos&oacute;ficos')
                ->display_as('philosophical_degree_observations', 'Observa&ccedil;&otilde;es Graus Filos&oacute;ficos')
                ->display_as('user_history', 'Hist&oacute;rico Ma&ccedil;&ocirc;nico do Obreiro Filiado, Regularizado, Direitos Suspensos e Restitu&iacute;dos')
                ->display_as('lodge_leaving_reason', 'Encaminhamento do Processo de Sa&iacute;da pelo Motivo de')
                ->display_as('leaving_lodge_request_date', 'Entrada do Pedido de Desligamento na Bolsa')
                ->display_as('leaving_lodge_approved_by_id', 'Aprova&ccedil;&atilde;o do Desligamento')
                ->display_as('leaving_lodge_request_observations', 'Observa&ccedil;&otilde;es Sobre o Pedido de Desligamento')
                ->display_as('leaving_lodge_recorded_at_governing_body_in', 'Protocolado na Pot&there4; em')
                ->display_as('leaving_lodge_published_in_bulletin_number', 'Publicado no Boletim n&ordm;')
                ->display_as('leaving_lodge_bulletin_date_publication', 'Data do Boletim')
                ->display_as('leaving_lodge_bulletin_observations', 'Observa&ccedil;&otilde;es Sobre o Boletim')
                ->display_as('leaving_lodge_observations', 'Observa&ccedil;&otilde;es Sobre o Desligamento')
                ->display_as('lodge_role_01', '01 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_02', '02 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_03', '03 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_04', '04 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_05', '05 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_06', '06 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_07', '07 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_08', '08 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_09', '09 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_10', '10 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_11', '11 - Cargo Ocupado na Loja')
                ->display_as('lodge_role_12', '12 - Cargo Ocupado na Loja')
                ->display_as('governing_body_role_01', '01 - Cargo Ocupado na Pot&ecirc;ncia')
                ->display_as('governing_body_role_02', '02 - Cargo Ocupado na Pot&ecirc;ncia')
                ->display_as('governing_body_role_03', '03 - Cargo Ocupado na Pot&ecirc;ncia')
                ->display_as('governing_body_role_04', '04 - Cargo Ocupado na Pot&ecirc;ncia')
                ->display_as('governing_body_role_05', '05 - Cargo Ocupado na Pot&ecirc;ncia')
                ->display_as('governing_body_role_06', '06 - Cargo Ocupado na Pot&ecirc;ncia')
                ->display_as('governing_body_role_07', '07 - Cargo Ocupado na Pot&ecirc;ncia')
                ->display_as('another_role_in_another_degree_01', '01 - Cargo ocupado em outros graus na ordem ma&ccedil;&ocirc;nica')
                ->display_as('another_role_in_another_degree_02', '02 - Cargo ocupado em outros graus na ordem ma&ccedil;&ocirc;nica')
                ->display_as('another_role_in_another_degree_03', '03 - Cargo ocupado em outros graus na ordem ma&ccedil;&ocirc;nica')
                ->display_as('another_role_in_another_degree_04', '04 - Cargo ocupado em outros graus na ordem ma&ccedil;&ocirc;nica')
                ->display_as('another_role_in_another_degree_05', '05 - Cargo ocupado em outros graus na ordem ma&ccedil;&ocirc;nica')
                ->display_as('another_role_in_another_degree_06', '06 - Cargo ocupado em outros graus na ordem ma&ccedil;&ocirc;nica')
                ->display_as('another_role_in_another_degree_07', '07 - Cargo ocupado em outros graus na ordem ma&ccedil;&ocirc;nica')
                ->display_as('social_entity_role_01', '01 - Cargo ocupado em entidade social no mundo profano para o bem da Ordem')
                ->display_as('social_entity_role_02', '02 - Cargo ocupado em entidade social no mundo profano para o bem da Ordem')
                ->display_as('social_entity_role_03', '03 - Cargo ocupado em entidade social no mundo profano para o bem da Ordem')
                ->display_as('social_entity_role_04', '04 - Cargo ocupado em entidade social no mundo profano para o bem da Ordem')
                ->display_as('social_entity_role_05', '05 - Cargo ocupado em entidade social no mundo profano para o bem da Ordem')
                ->display_as('social_entity_role_06', '06 - Cargo ocupado em entidade social no mundo profano para o bem da Ordem')
                ->display_as('social_entity_role_07', '07 - Cargo ocupado em entidade social no mundo profano para o bem da Ordem')
                ->display_as('general_observations', 'Observa&ccedil;&otilde;es Gerais');

            $this->grocery_crud->columns(array('profile_picture','name','cim','degree_id','email','mobile','webpage'));

            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('hobby_activity_1', 'hidden');
            $this->grocery_crud->change_field_type('hobby_activity_2', 'hidden');
            $this->grocery_crud->change_field_type('hobby_activity_3', 'hidden');
            $this->grocery_crud->change_field_type('hobby_activity_4', 'hidden');
            $this->grocery_crud->change_field_type('hobby_activity_5', 'hidden');
            $this->grocery_crud->change_field_type('hobby_activity_6', 'hidden');
            $this->grocery_crud->change_field_type('approved_inquiry_expedition_date', 'hidden');
            $this->grocery_crud->change_field_type('inquiry_done_date', 'hidden');
            $this->grocery_crud->change_field_type('inquiry_master_02', 'hidden');
            $this->grocery_crud->change_field_type('inquiry_master_03', 'hidden');
            $this->grocery_crud->change_field_type('more_inquiry_masters_02', 'hidden');
            $this->grocery_crud->change_field_type('more_inquiry_masters_03', 'hidden');
            $this->grocery_crud->change_field_type('approved_spouse_inquiry_expedition_date', 'hidden');
            $this->grocery_crud->change_field_type('spouse_inquiry_done_date', 'hidden');
            $this->grocery_crud->change_field_type('spouse_inquiry_master_02', 'hidden');
            $this->grocery_crud->change_field_type('spouse_inquiry_master_03', 'hidden');
            $this->grocery_crud->change_field_type('rite_id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_01', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_01', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_02', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_02', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_03', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_03', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_04', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_04', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_05', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_05', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_06', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_06', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_07', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_07', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_08', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_08', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_09', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_09', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_10', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_10', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_11', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_11', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_management_12', 'hidden');
            $this->grocery_crud->change_field_type('lodge_role_tenure_date_12', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_management_01', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_tenure_date_01', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_management_02', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_tenure_date_02', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_management_03', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_tenure_date_03', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_management_04', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_tenure_date_04', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_management_05', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_tenure_date_05', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_management_06', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_tenure_date_06', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_management_07', 'hidden');
            $this->grocery_crud->change_field_type('governing_body_role_tenure_date_07', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_management_01', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_tenure_date_01', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_management_02', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_tenure_date_02', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_management_03', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_tenure_date_03', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_management_04', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_tenure_date_04', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_management_05', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_tenure_date_05', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_management_06', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_tenure_date_06', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_management_07', 'hidden');
            $this->grocery_crud->change_field_type('another_role_in_another_degree_tenure_date_07', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_management_01', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_tenure_date_01', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_management_02', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_tenure_date_02', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_management_03', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_tenure_date_03', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_management_04', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_tenure_date_04', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_management_05', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_tenure_date_05', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_management_06', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_tenure_date_06', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_management_07', 'hidden');
            $this->grocery_crud->change_field_type('social_entity_role_tenure_date_07', 'hidden');

            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);
            $this->grocery_crud->change_field_type('governing_body_id','hidden', $_SESSION['governing_body_as_admin']);

            $this->grocery_crud->set_field_upload('profile_picture','users_pictures');
            $this->grocery_crud->callback_before_upload(array($this,'callback_before_upload'));

            $this->grocery_crud->field_type('income', 'integer');

            $this->grocery_crud->set_relation('degree_id','degrees','name');
            $this->grocery_crud->set_relation('house_status_id','house_status','name', null, 'id ASC');
            $this->grocery_crud->set_relation('civil_status_id','civil_status','name', null, 'id ASC');
            $this->grocery_crud->set_relation('scholarity_id','scholarity','name', null, 'id ASC');
            $this->grocery_crud->set_relation('company_activity_id','company_activities','name', null, 'id ASC');
            $this->grocery_crud->set_relation('wife_id','wives','name');
            $this->grocery_crud->set_relation('type_of_acceptance_id','types_of_acceptance','name', null, 'id ASC');
            $this->grocery_crud->set_relation('approved_by_id', 'approved_by', 'name', null, 'id ASC');
            $this->grocery_crud->set_relation('argumentation_for_grade_2_approved_by_id', 'approved_by', 'name', null, 'id ASC');
            $this->grocery_crud->set_relation('argumentation_for_grade_3_approved_by_id', 'approved_by', 'name', null, 'id ASC');
            $this->grocery_crud->set_relation('leaving_lodge_approved_by_id', 'approved_by', 'name', null, 'id ASC');
            $this->grocery_crud->set_relation('proposal_for_id', 'proposal_for', 'name', null, 'id ASC');
            $this->grocery_crud->set_relation('proposal_for_id', 'proposal_for', 'name', null, 'id ASC');
            $this->grocery_crud->set_relation('philosophical_degree_id', 'philosophical_degrees', 'value', null, 'id ASC');
            $this->grocery_crud->set_relation_n_n('nephews', 'users_nephews', 'nephews', 'user_id', 'nephew_id', 'name','priority', array('nephews.lodge_id'=>$_SESSION['lodge_id_as_admin'], 'is_available'=>1)/*array('is_available'=>1)*/);
            $this->grocery_crud->set_relation_n_n('languages', 'users_languages', 'languages', 'user_id', 'language_id', 'name');
            $this->grocery_crud->set_relation_n_n('masonic_profiles', 'users_masonic_profiles', 'masonic_profiles', 'user_id', 'masonic_profile_id', 'name','priority');
            $this->grocery_crud->set_relation_n_n('matrix_profiles', 'users_matrix_profiles', 'matrix_profiles', 'user_id', 'matrix_profile_id', 'name','priority');

            $this->grocery_crud->callback_field('wife_id',array($this,'_callback_wife'));

            $this->grocery_crud->field_type('password', 'password');
            $this->grocery_crud->set_rules("password", "Senha", "callback_checkPassword");
            $this->grocery_crud->callback_before_insert(array($this,'encrypt_password_callback'));
            $this->grocery_crud->callback_before_update(array($this,'encrypt_password_callback'));
            $this->grocery_crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));
            $this->grocery_crud->callback_add_field('password',array($this,'set_password_input_to_empty'));

            $this->grocery_crud->callback_after_insert(array($this, 'set_relatives_availability'));
            $this->grocery_crud->callback_after_update(array($this, 'set_relatives_availability'));

            // Hobbies
            $this->grocery_crud->callback_edit_field('hobby_practitioner_1',array($this,'edit_hobby_callback_1'));
            $this->grocery_crud->callback_add_field('hobby_practitioner_1',array($this,'add_hobby_callback_1'));
            $this->grocery_crud->callback_edit_field('hobby_activity_1',array($this,'edit_hobby_activity_1'));
            $this->grocery_crud->callback_add_field('hobby_activity_1',array($this,'add_hobby_activity_1'));

            $this->grocery_crud->callback_edit_field('hobby_practitioner_2',array($this,'edit_hobby_callback_2'));
            $this->grocery_crud->callback_add_field('hobby_practitioner_2',array($this,'add_hobby_callback_2'));
            $this->grocery_crud->callback_edit_field('hobby_activity_2',array($this,'edit_hobby_activity_2'));
            $this->grocery_crud->callback_add_field('hobby_activity_2',array($this,'add_hobby_activity_2'));

            $this->grocery_crud->callback_edit_field('hobby_practitioner_3',array($this,'edit_hobby_callback_3'));
            $this->grocery_crud->callback_add_field('hobby_practitioner_3',array($this,'add_hobby_callback_3'));
            $this->grocery_crud->callback_edit_field('hobby_activity_3',array($this,'edit_hobby_activity_3'));
            $this->grocery_crud->callback_add_field('hobby_activity_3',array($this,'add_hobby_activity_3'));

            $this->grocery_crud->callback_edit_field('hobby_practitioner_4',array($this,'edit_hobby_callback_4'));
            $this->grocery_crud->callback_add_field('hobby_practitioner_4',array($this,'add_hobby_callback_4'));
            $this->grocery_crud->callback_edit_field('hobby_activity_4',array($this,'edit_hobby_activity_4'));
            $this->grocery_crud->callback_add_field('hobby_activity_4',array($this,'add_hobby_activity_4'));

            $this->grocery_crud->callback_edit_field('hobby_practitioner_5',array($this,'edit_hobby_callback_5'));
            $this->grocery_crud->callback_add_field('hobby_practitioner_5',array($this,'add_hobby_callback_5'));
            $this->grocery_crud->callback_edit_field('hobby_activity_5',array($this,'edit_hobby_activity_5'));
            $this->grocery_crud->callback_add_field('hobby_activity_5',array($this,'add_hobby_activity_5'));

            $this->grocery_crud->callback_edit_field('hobby_practitioner_6',array($this,'edit_hobby_callback_6'));
            $this->grocery_crud->callback_add_field('hobby_practitioner_6',array($this,'add_hobby_callback_6'));
            $this->grocery_crud->callback_edit_field('hobby_activity_6',array($this,'edit_hobby_activity_6'));
            $this->grocery_crud->callback_add_field('hobby_activity_6',array($this,'add_hobby_activity_6'));

            //------
            $this->grocery_crud->callback_edit_field('approved_inquiry_expedition',array($this,'edit_approved_inquiry_expedition_callback'));
            $this->grocery_crud->callback_add_field('approved_inquiry_expedition',array($this,'add_approved_inquiry_expedition_callback'));
            $this->grocery_crud->callback_edit_field('approved_inquiry_expedition_date',array($this,'edit_approved_inquiry_expedition_date_callback'));
            $this->grocery_crud->callback_add_field('approved_inquiry_expedition_date',array($this,'add_approved_inquiry_expedition_date_callback'));

            $this->grocery_crud->callback_edit_field('inquiry_done',array($this,'edit_inquiry_done_callback'));
            $this->grocery_crud->callback_add_field('inquiry_done',array($this,'add_inquiry_done_callback'));
            $this->grocery_crud->callback_edit_field('inquiry_done_date',array($this,'edit_inquiry_done_date_callback'));
            $this->grocery_crud->callback_add_field('inquiry_done_date',array($this,'add_inquiry_done_date_callback'));

            $this->grocery_crud->callback_edit_field('inquiry_master_01',array($this,'edit_inquiry_master_01_callback'));
            $this->grocery_crud->callback_add_field('inquiry_master_01',array($this,'add_inquiry_master_01_callback'));
            $this->grocery_crud->callback_edit_field('inquiry_master_02',array($this,'edit_inquiry_master_02_callback'));
            $this->grocery_crud->callback_add_field('inquiry_master_02',array($this,'add_inquiry_master_02_callback'));
            $this->grocery_crud->callback_edit_field('inquiry_master_03',array($this,'edit_inquiry_master_03_callback'));
            $this->grocery_crud->callback_add_field('inquiry_master_03',array($this,'add_inquiry_master_03_callback'));

            $this->grocery_crud->callback_edit_field('more_inquiry_masters_01',array($this,'edit_more_inquiry_masters_01_callback'));
            $this->grocery_crud->callback_add_field('more_inquiry_masters_01',array($this,'add_more_inquiry_masters_01_callback'));
            $this->grocery_crud->callback_edit_field('more_inquiry_masters_02',array($this,'edit_more_inquiry_masters_02_callback'));
            $this->grocery_crud->callback_add_field('more_inquiry_masters_02',array($this,'add_more_inquiry_masters_02_callback'));
            $this->grocery_crud->callback_edit_field('more_inquiry_masters_03',array($this,'edit_more_inquiry_masters_03_callback'));
            $this->grocery_crud->callback_add_field('more_inquiry_masters_03',array($this,'add_more_inquiry_masters_03_callback'));

            $this->grocery_crud->callback_edit_field('approved_spouse_inquiry_expedition',array($this,'edit_approved_spouse_inquiry_expedition_callback'));
            $this->grocery_crud->callback_add_field('approved_spouse_inquiry_expedition',array($this,'add_approved_spouse_inquiry_expedition_callback'));
            $this->grocery_crud->callback_edit_field('approved_spouse_inquiry_expedition_date',array($this,'edit_approved_spouse_inquiry_expedition_date_callback'));
            $this->grocery_crud->callback_add_field('approved_spouse_inquiry_expedition_date',array($this,'add_approved_spouse_inquiry_expedition_date_callback'));

            $this->grocery_crud->callback_edit_field('spouse_inquiry_done',array($this,'edit_spouse_inquiry_done_callback'));
            $this->grocery_crud->callback_add_field('spouse_inquiry_done',array($this,'add_spouse_inquiry_done_callback'));
            $this->grocery_crud->callback_edit_field('spouse_inquiry_done_date',array($this,'edit_spouse_inquiry_done_date_callback'));
            $this->grocery_crud->callback_add_field('spouse_inquiry_done_date',array($this,'add_spouse_inquiry_done_date_callback'));

            $this->grocery_crud->callback_edit_field('spouse_inquiry_master_01',array($this,'edit_spouse_inquiry_master_01_callback'));
            $this->grocery_crud->callback_add_field('spouse_inquiry_master_01',array($this,'add_spouse_inquiry_master_01_callback'));
            $this->grocery_crud->callback_edit_field('spouse_inquiry_master_02',array($this,'edit_spouse_inquiry_master_02_callback'));
            $this->grocery_crud->callback_add_field('spouse_inquiry_master_02',array($this,'add_spouse_inquiry_master_02_callback'));
            $this->grocery_crud->callback_edit_field('spouse_inquiry_master_03',array($this,'edit_spouse_inquiry_master_03_callback'));
            $this->grocery_crud->callback_add_field('spouse_inquiry_master_03',array($this,'add_spouse_inquiry_master_03_callback'));

            $this->grocery_crud->callback_edit_field('proposal_copies',array($this,'edit_proposal_copies_callback'));
            $this->grocery_crud->callback_add_field('proposal_copies',array($this,'add_proposal_copies_callback'));
            $this->grocery_crud->callback_edit_field('medical_certificate',array($this,'edit_medical_certificate_callback'));
            $this->grocery_crud->callback_add_field('medical_certificate',array($this,'add_medical_certificate_callback'));
            $this->grocery_crud->callback_edit_field('notary_notification_certificate',array($this,'edit_notary_notification_certificate_callback'));
            $this->grocery_crud->callback_add_field('notary_notification_certificate',array($this,'add_notary_notification_certificate_callback'));
            $this->grocery_crud->callback_edit_field('criminal_certificate',array($this,'edit_criminal_certificate_callback'));
            $this->grocery_crud->callback_add_field('criminal_certificate',array($this,'add_criminal_certificate_callback'));
            $this->grocery_crud->callback_edit_field('civil_certificate',array($this,'edit_civil_certificate_callback'));
            $this->grocery_crud->callback_add_field('civil_certificate',array($this,'add_civil_certificate_callback'));

            $this->grocery_crud->callback_edit_field('philosophical_degree_id',array($this,'edit_philosophical_degree_id'));
            $this->grocery_crud->callback_add_field('philosophical_degree_id',array($this,'add_philosophical_degree_id'));
            $this->grocery_crud->callback_edit_field('rite_id',array($this,'edit_rite_id'));
            $this->grocery_crud->callback_add_field('rite_id',array($this,'add_rite_id'));

            $this->grocery_crud->callback_edit_field('lodge_role_01',array($this,'edit_lodge_role_01'));
            $this->grocery_crud->callback_add_field('lodge_role_01',array($this,'add_lodge_role_01'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_01',array($this,'edit_lodge_role_management_01'));
            $this->grocery_crud->callback_add_field('lodge_role_management_01',array($this,'add_lodge_role_management_01'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_01',array($this,'edit_lodge_role_tenure_date_01'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_01',array($this,'add_lodge_role_tenure_date_01'));
            $this->grocery_crud->callback_edit_field('lodge_role_02',array($this,'edit_lodge_role_02'));
            $this->grocery_crud->callback_add_field('lodge_role_02',array($this,'add_lodge_role_02'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_02',array($this,'edit_lodge_role_management_02'));
            $this->grocery_crud->callback_add_field('lodge_role_management_02',array($this,'add_lodge_role_management_02'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_02',array($this,'edit_lodge_role_tenure_date_02'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_02',array($this,'add_lodge_role_tenure_date_02'));
            $this->grocery_crud->callback_edit_field('lodge_role_03',array($this,'edit_lodge_role_03'));
            $this->grocery_crud->callback_add_field('lodge_role_03',array($this,'add_lodge_role_03'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_03',array($this,'edit_lodge_role_management_03'));
            $this->grocery_crud->callback_add_field('lodge_role_management_03',array($this,'add_lodge_role_management_03'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_03',array($this,'edit_lodge_role_tenure_date_03'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_03',array($this,'add_lodge_role_tenure_date_03'));
            $this->grocery_crud->callback_edit_field('lodge_role_04',array($this,'edit_lodge_role_04'));
            $this->grocery_crud->callback_add_field('lodge_role_04',array($this,'add_lodge_role_04'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_04',array($this,'edit_lodge_role_management_04'));
            $this->grocery_crud->callback_add_field('lodge_role_management_04',array($this,'add_lodge_role_management_04'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_04',array($this,'edit_lodge_role_tenure_date_04'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_04',array($this,'add_lodge_role_tenure_date_04'));
            $this->grocery_crud->callback_edit_field('lodge_role_05',array($this,'edit_lodge_role_05'));
            $this->grocery_crud->callback_add_field('lodge_role_05',array($this,'add_lodge_role_05'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_05',array($this,'edit_lodge_role_management_05'));
            $this->grocery_crud->callback_add_field('lodge_role_management_05',array($this,'add_lodge_role_management_05'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_05',array($this,'edit_lodge_role_tenure_date_05'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_05',array($this,'add_lodge_role_tenure_date_05'));
            $this->grocery_crud->callback_edit_field('lodge_role_06',array($this,'edit_lodge_role_06'));
            $this->grocery_crud->callback_add_field('lodge_role_06',array($this,'add_lodge_role_06'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_06',array($this,'edit_lodge_role_management_06'));
            $this->grocery_crud->callback_add_field('lodge_role_management_06',array($this,'add_lodge_role_management_06'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_06',array($this,'edit_lodge_role_tenure_date_06'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_06',array($this,'add_lodge_role_tenure_date_06'));
            $this->grocery_crud->callback_edit_field('lodge_role_07',array($this,'edit_lodge_role_07'));
            $this->grocery_crud->callback_add_field('lodge_role_07',array($this,'add_lodge_role_07'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_07',array($this,'edit_lodge_role_management_07'));
            $this->grocery_crud->callback_add_field('lodge_role_management_07',array($this,'add_lodge_role_management_07'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_07',array($this,'edit_lodge_role_tenure_date_07'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_07',array($this,'add_lodge_role_tenure_date_07'));
            $this->grocery_crud->callback_edit_field('lodge_role_08',array($this,'edit_lodge_role_08'));
            $this->grocery_crud->callback_add_field('lodge_role_08',array($this,'add_lodge_role_08'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_08',array($this,'edit_lodge_role_management_08'));
            $this->grocery_crud->callback_add_field('lodge_role_management_08',array($this,'add_lodge_role_management_08'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_08',array($this,'edit_lodge_role_tenure_date_08'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_08',array($this,'add_lodge_role_tenure_date_08'));
            $this->grocery_crud->callback_edit_field('lodge_role_09',array($this,'edit_lodge_role_09'));
            $this->grocery_crud->callback_add_field('lodge_role_09',array($this,'add_lodge_role_09'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_09',array($this,'edit_lodge_role_management_09'));
            $this->grocery_crud->callback_add_field('lodge_role_management_09',array($this,'add_lodge_role_management_09'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_09',array($this,'edit_lodge_role_tenure_date_09'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_09',array($this,'add_lodge_role_tenure_date_09'));
            $this->grocery_crud->callback_edit_field('lodge_role_10',array($this,'edit_lodge_role_10'));
            $this->grocery_crud->callback_add_field('lodge_role_10',array($this,'add_lodge_role_10'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_10',array($this,'edit_lodge_role_management_10'));
            $this->grocery_crud->callback_add_field('lodge_role_management_10',array($this,'add_lodge_role_management_10'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_10',array($this,'edit_lodge_role_tenure_date_10'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_10',array($this,'add_lodge_role_tenure_date_10'));
            $this->grocery_crud->callback_edit_field('lodge_role_11',array($this,'edit_lodge_role_11'));
            $this->grocery_crud->callback_add_field('lodge_role_11',array($this,'add_lodge_role_11'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_11',array($this,'edit_lodge_role_management_11'));
            $this->grocery_crud->callback_add_field('lodge_role_management_11',array($this,'add_lodge_role_management_11'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_11',array($this,'edit_lodge_role_tenure_date_11'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_11',array($this,'add_lodge_role_tenure_date_11'));
            $this->grocery_crud->callback_edit_field('lodge_role_12',array($this,'edit_lodge_role_12'));
            $this->grocery_crud->callback_add_field('lodge_role_12',array($this,'add_lodge_role_12'));
            $this->grocery_crud->callback_edit_field('lodge_role_management_12',array($this,'edit_lodge_role_management_12'));
            $this->grocery_crud->callback_add_field('lodge_role_management_12',array($this,'add_lodge_role_management_12'));
            $this->grocery_crud->callback_edit_field('lodge_role_tenure_date_12',array($this,'edit_lodge_role_tenure_date_12'));
            $this->grocery_crud->callback_add_field('lodge_role_tenure_date_12',array($this,'add_lodge_role_tenure_date_12'));
            $this->grocery_crud->callback_edit_field('governing_body_role_01',array($this,'edit_governing_body_role_01'));
            $this->grocery_crud->callback_add_field('governing_body_role_01',array($this,'add_governing_body_role_01'));
            $this->grocery_crud->callback_edit_field('governing_body_role_management_01',array($this,'edit_governing_body_role_management_01'));
            $this->grocery_crud->callback_add_field('governing_body_role_management_01',array($this,'add_governing_body_role_management_01'));
            $this->grocery_crud->callback_edit_field('governing_body_role_tenure_date_01',array($this,'edit_governing_body_role_tenure_date_01'));
            $this->grocery_crud->callback_add_field('governing_body_role_tenure_date_01',array($this,'add_governing_body_role_tenure_date_01'));
            $this->grocery_crud->callback_edit_field('governing_body_role_02',array($this,'edit_governing_body_role_02'));
            $this->grocery_crud->callback_add_field('governing_body_role_02',array($this,'add_governing_body_role_02'));
            $this->grocery_crud->callback_edit_field('governing_body_role_management_02',array($this,'edit_governing_body_role_management_02'));
            $this->grocery_crud->callback_add_field('governing_body_role_management_02',array($this,'add_governing_body_role_management_02'));
            $this->grocery_crud->callback_edit_field('governing_body_role_tenure_date_02',array($this,'edit_governing_body_role_tenure_date_02'));
            $this->grocery_crud->callback_add_field('governing_body_role_tenure_date_02',array($this,'add_governing_body_role_tenure_date_02'));
            $this->grocery_crud->callback_edit_field('governing_body_role_03',array($this,'edit_governing_body_role_03'));
            $this->grocery_crud->callback_add_field('governing_body_role_03',array($this,'add_governing_body_role_03'));
            $this->grocery_crud->callback_edit_field('governing_body_role_management_03',array($this,'edit_governing_body_role_management_03'));
            $this->grocery_crud->callback_add_field('governing_body_role_management_03',array($this,'add_governing_body_role_management_03'));
            $this->grocery_crud->callback_edit_field('governing_body_role_tenure_date_03',array($this,'edit_governing_body_role_tenure_date_03'));
            $this->grocery_crud->callback_add_field('governing_body_role_tenure_date_03',array($this,'add_governing_body_role_tenure_date_03'));
            $this->grocery_crud->callback_edit_field('governing_body_role_04',array($this,'edit_governing_body_role_04'));
            $this->grocery_crud->callback_add_field('governing_body_role_04',array($this,'add_governing_body_role_04'));
            $this->grocery_crud->callback_edit_field('governing_body_role_management_04',array($this,'edit_governing_body_role_management_04'));
            $this->grocery_crud->callback_add_field('governing_body_role_management_04',array($this,'add_governing_body_role_management_04'));
            $this->grocery_crud->callback_edit_field('governing_body_role_tenure_date_04',array($this,'edit_governing_body_role_tenure_date_04'));
            $this->grocery_crud->callback_add_field('governing_body_role_tenure_date_04',array($this,'add_governing_body_role_tenure_date_04'));
            $this->grocery_crud->callback_edit_field('governing_body_role_05',array($this,'edit_governing_body_role_05'));
            $this->grocery_crud->callback_add_field('governing_body_role_05',array($this,'add_governing_body_role_05'));
            $this->grocery_crud->callback_edit_field('governing_body_role_management_05',array($this,'edit_governing_body_role_management_05'));
            $this->grocery_crud->callback_add_field('governing_body_role_management_05',array($this,'add_governing_body_role_management_05'));
            $this->grocery_crud->callback_edit_field('governing_body_role_tenure_date_05',array($this,'edit_governing_body_role_tenure_date_05'));
            $this->grocery_crud->callback_add_field('governing_body_role_tenure_date_05',array($this,'add_governing_body_role_tenure_date_05'));
            $this->grocery_crud->callback_edit_field('governing_body_role_06',array($this,'edit_governing_body_role_06'));
            $this->grocery_crud->callback_add_field('governing_body_role_06',array($this,'add_governing_body_role_06'));
            $this->grocery_crud->callback_edit_field('governing_body_role_management_06',array($this,'edit_governing_body_role_management_06'));
            $this->grocery_crud->callback_add_field('governing_body_role_management_06',array($this,'add_governing_body_role_management_06'));
            $this->grocery_crud->callback_edit_field('governing_body_role_tenure_date_06',array($this,'edit_governing_body_role_tenure_date_06'));
            $this->grocery_crud->callback_add_field('governing_body_role_tenure_date_06',array($this,'add_governing_body_role_tenure_date_06'));
            $this->grocery_crud->callback_edit_field('governing_body_role_07',array($this,'edit_governing_body_role_07'));
            $this->grocery_crud->callback_add_field('governing_body_role_07',array($this,'add_governing_body_role_07'));
            $this->grocery_crud->callback_edit_field('governing_body_role_management_07',array($this,'edit_governing_body_role_management_07'));
            $this->grocery_crud->callback_add_field('governing_body_role_management_07',array($this,'add_governing_body_role_management_07'));
            $this->grocery_crud->callback_edit_field('governing_body_role_tenure_date_07',array($this,'edit_governing_body_role_tenure_date_07'));
            $this->grocery_crud->callback_add_field('governing_body_role_tenure_date_07',array($this,'add_governing_body_role_tenure_date_07'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_01',array($this,'edit_another_role_in_another_degree_01'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_01',array($this,'add_another_role_in_another_degree_01'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_management_01',array($this,'edit_another_role_in_another_degree_management_01'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_management_01',array($this,'add_another_role_in_another_degree_management_01'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_tenure_date_01',array($this,'edit_another_role_in_another_degree_tenure_date_01'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_tenure_date_01',array($this,'add_another_role_in_another_degree_tenure_date_01'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_02',array($this,'edit_another_role_in_another_degree_02'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_02',array($this,'add_another_role_in_another_degree_02'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_management_02',array($this,'edit_another_role_in_another_degree_management_02'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_management_02',array($this,'add_another_role_in_another_degree_management_02'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_tenure_date_02',array($this,'edit_another_role_in_another_degree_tenure_date_02'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_tenure_date_02',array($this,'add_another_role_in_another_degree_tenure_date_02'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_03',array($this,'edit_another_role_in_another_degree_03'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_03',array($this,'add_another_role_in_another_degree_03'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_management_03',array($this,'edit_another_role_in_another_degree_management_03'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_management_03',array($this,'add_another_role_in_another_degree_management_03'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_tenure_date_03',array($this,'edit_another_role_in_another_degree_tenure_date_03'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_tenure_date_03',array($this,'add_another_role_in_another_degree_tenure_date_03'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_04',array($this,'edit_another_role_in_another_degree_04'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_04',array($this,'add_another_role_in_another_degree_04'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_management_04',array($this,'edit_another_role_in_another_degree_management_04'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_management_04',array($this,'add_another_role_in_another_degree_management_04'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_tenure_date_04',array($this,'edit_another_role_in_another_degree_tenure_date_04'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_tenure_date_04',array($this,'add_another_role_in_another_degree_tenure_date_04'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_05',array($this,'edit_another_role_in_another_degree_05'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_05',array($this,'add_another_role_in_another_degree_05'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_management_05',array($this,'edit_another_role_in_another_degree_management_05'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_management_05',array($this,'add_another_role_in_another_degree_management_05'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_tenure_date_05',array($this,'edit_another_role_in_another_degree_tenure_date_05'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_tenure_date_05',array($this,'add_another_role_in_another_degree_tenure_date_05'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_06',array($this,'edit_another_role_in_another_degree_06'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_06',array($this,'add_another_role_in_another_degree_06'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_management_06',array($this,'edit_another_role_in_another_degree_management_06'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_management_06',array($this,'add_another_role_in_another_degree_management_06'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_tenure_date_06',array($this,'edit_another_role_in_another_degree_tenure_date_06'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_tenure_date_06',array($this,'add_another_role_in_another_degree_tenure_date_06'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_07',array($this,'edit_another_role_in_another_degree_07'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_07',array($this,'add_another_role_in_another_degree_07'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_management_07',array($this,'edit_another_role_in_another_degree_management_07'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_management_07',array($this,'add_another_role_in_another_degree_management_07'));
            $this->grocery_crud->callback_edit_field('another_role_in_another_degree_tenure_date_07',array($this,'edit_another_role_in_another_degree_tenure_date_07'));
            $this->grocery_crud->callback_add_field('another_role_in_another_degree_tenure_date_07',array($this,'add_another_role_in_another_degree_tenure_date_07'));
            $this->grocery_crud->callback_edit_field('social_entity_role_01',array($this,'edit_social_entity_role_01'));
            $this->grocery_crud->callback_add_field('social_entity_role_01',array($this,'add_social_entity_role_01'));
            $this->grocery_crud->callback_edit_field('social_entity_role_management_01',array($this,'edit_social_entity_role_management_01'));
            $this->grocery_crud->callback_add_field('social_entity_role_management_01',array($this,'add_social_entity_role_management_01'));
            $this->grocery_crud->callback_edit_field('social_entity_role_tenure_date_01',array($this,'edit_social_entity_role_tenure_date_01'));
            $this->grocery_crud->callback_add_field('social_entity_role_tenure_date_01',array($this,'add_social_entity_role_tenure_date_01'));
            $this->grocery_crud->callback_edit_field('social_entity_role_02',array($this,'edit_social_entity_role_02'));
            $this->grocery_crud->callback_add_field('social_entity_role_02',array($this,'add_social_entity_role_02'));
            $this->grocery_crud->callback_edit_field('social_entity_role_management_02',array($this,'edit_social_entity_role_management_02'));
            $this->grocery_crud->callback_add_field('social_entity_role_management_02',array($this,'add_social_entity_role_management_02'));
            $this->grocery_crud->callback_edit_field('social_entity_role_tenure_date_02',array($this,'edit_social_entity_role_tenure_date_02'));
            $this->grocery_crud->callback_add_field('social_entity_role_tenure_date_02',array($this,'add_social_entity_role_tenure_date_02'));
            $this->grocery_crud->callback_edit_field('social_entity_role_03',array($this,'edit_social_entity_role_03'));
            $this->grocery_crud->callback_add_field('social_entity_role_03',array($this,'add_social_entity_role_03'));
            $this->grocery_crud->callback_edit_field('social_entity_role_management_03',array($this,'edit_social_entity_role_management_03'));
            $this->grocery_crud->callback_add_field('social_entity_role_management_03',array($this,'add_social_entity_role_management_03'));
            $this->grocery_crud->callback_edit_field('social_entity_role_tenure_date_03',array($this,'edit_social_entity_role_tenure_date_03'));
            $this->grocery_crud->callback_add_field('social_entity_role_tenure_date_03',array($this,'add_social_entity_role_tenure_date_03'));
            $this->grocery_crud->callback_edit_field('social_entity_role_04',array($this,'edit_social_entity_role_04'));
            $this->grocery_crud->callback_add_field('social_entity_role_04',array($this,'add_social_entity_role_04'));
            $this->grocery_crud->callback_edit_field('social_entity_role_management_04',array($this,'edit_social_entity_role_management_04'));
            $this->grocery_crud->callback_add_field('social_entity_role_management_04',array($this,'add_social_entity_role_management_04'));
            $this->grocery_crud->callback_edit_field('social_entity_role_tenure_date_04',array($this,'edit_social_entity_role_tenure_date_04'));
            $this->grocery_crud->callback_add_field('social_entity_role_tenure_date_04',array($this,'add_social_entity_role_tenure_date_04'));
            $this->grocery_crud->callback_edit_field('social_entity_role_05',array($this,'edit_social_entity_role_05'));
            $this->grocery_crud->callback_add_field('social_entity_role_05',array($this,'add_social_entity_role_05'));
            $this->grocery_crud->callback_edit_field('social_entity_role_management_05',array($this,'edit_social_entity_role_management_05'));
            $this->grocery_crud->callback_add_field('social_entity_role_management_05',array($this,'add_social_entity_role_management_05'));
            $this->grocery_crud->callback_edit_field('social_entity_role_tenure_date_05',array($this,'edit_social_entity_role_tenure_date_05'));
            $this->grocery_crud->callback_add_field('social_entity_role_tenure_date_05',array($this,'add_social_entity_role_tenure_date_05'));
            $this->grocery_crud->callback_edit_field('social_entity_role_06',array($this,'edit_social_entity_role_06'));
            $this->grocery_crud->callback_add_field('social_entity_role_06',array($this,'add_social_entity_role_06'));
            $this->grocery_crud->callback_edit_field('social_entity_role_management_06',array($this,'edit_social_entity_role_management_06'));
            $this->grocery_crud->callback_add_field('social_entity_role_management_06',array($this,'add_social_entity_role_management_06'));
            $this->grocery_crud->callback_edit_field('social_entity_role_tenure_date_06',array($this,'edit_social_entity_role_tenure_date_06'));
            $this->grocery_crud->callback_add_field('social_entity_role_tenure_date_06',array($this,'add_social_entity_role_tenure_date_06'));
            $this->grocery_crud->callback_edit_field('social_entity_role_07',array($this,'edit_social_entity_role_07'));
            $this->grocery_crud->callback_add_field('social_entity_role_07',array($this,'add_social_entity_role_07'));
            $this->grocery_crud->callback_edit_field('social_entity_role_management_07',array($this,'edit_social_entity_role_management_07'));
            $this->grocery_crud->callback_add_field('social_entity_role_management_07',array($this,'add_social_entity_role_management_07'));
            $this->grocery_crud->callback_edit_field('social_entity_role_tenure_date_07',array($this,'edit_social_entity_role_tenure_date_07'));
            $this->grocery_crud->callback_add_field('social_entity_role_tenure_date_07',array($this,'add_social_entity_role_tenure_date_07'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function apprentice_history()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('apprentice_history.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('apprentice_history');

            $this->grocery_crud->set_subject('Hist&oacute;rico de Aprendiz');
            $this->grocery_crud->fields('id', 'lodge_id', 'user_id', 'received_instruction_01', 'delivered_work_instruction_01', 'presented_work_instruction_01', 'work_instruction_filename_01', 'received_instruction_02', 'delivered_work_instruction_02', 'presented_work_instruction_02', 'work_instruction_filename_02', 'received_instruction_03', 'delivered_work_instruction_03', 'presented_work_instruction_03', 'work_instruction_filename_03', 'received_instruction_04', 'delivered_work_instruction_04', 'presented_work_instruction_04', 'work_instruction_filename_04', 'received_instruction_05', 'delivered_work_instruction_05', 'presented_work_instruction_05', 'work_instruction_filename_05', 'received_instruction_06', 'delivered_work_instruction_06', 'presented_work_instruction_06', 'work_instruction_filename_06', 'received_instruction_07', 'delivered_work_instruction_07', 'presented_work_instruction_07', 'work_instruction_filename_07', 'extra_work_title_01', 'delivered_extra_work_01', 'presented_extra_work_01', 'extra_work_filename_01', 'extra_work_title_02', 'delivered_extra_work_02', 'presented_extra_work_02', 'extra_work_filename_02', 'extra_work_title_03', 'delivered_extra_work_03', 'presented_extra_work_03', 'extra_work_filename_03', 'extra_work_title_04', 'delivered_extra_work_04', 'presented_extra_work_04', 'extra_work_filename_04', 'extra_work_title_05', 'delivered_extra_work_05', 'presented_extra_work_05', 'extra_work_filename_05', 'visit_lodge_name_01', 'visit_lodge_number_01', 'visit_lodge_rite_id_01', 'visit_lodge_governing_body_id_01', 'visit_lodge_date_01', 'visit_lodge_session_degree_id_01', 'visit_lodge_worshipful_master_name_01', 'visit_lodge_warden_name_01', 'visit_lodge_warden_phone_01', 'visit_lodge_warden_email_01', 'visit_lodge_address_01', 'visit_lodge_name_02', 'visit_lodge_number_02', 'visit_lodge_rite_id_02', 'visit_lodge_governing_body_id_02', 'visit_lodge_date_02', 'visit_lodge_session_degree_id_02', 'visit_lodge_worshipful_master_name_02', 'visit_lodge_warden_name_02', 'visit_lodge_warden_phone_02', 'visit_lodge_warden_email_02', 'visit_lodge_address_02', 'visit_lodge_name_03', 'visit_lodge_number_03', 'visit_lodge_rite_id_03', 'visit_lodge_governing_body_id_03', 'visit_lodge_date_03', 'visit_lodge_session_degree_id_03', 'visit_lodge_worshipful_master_name_03', 'visit_lodge_warden_name_03', 'visit_lodge_warden_phone_03', 'visit_lodge_warden_email_03', 'visit_lodge_address_03', 'visit_lodge_name_04', 'visit_lodge_number_04', 'visit_lodge_rite_id_04', 'visit_lodge_governing_body_id_04', 'visit_lodge_date_04', 'visit_lodge_session_degree_id_04', 'visit_lodge_worshipful_master_name_04', 'visit_lodge_warden_name_04', 'visit_lodge_warden_phone_04', 'visit_lodge_warden_email_04', 'visit_lodge_address_04', 'visit_lodge_name_05', 'visit_lodge_number_05', 'visit_lodge_rite_id_05', 'visit_lodge_governing_body_id_05', 'visit_lodge_date_05', 'visit_lodge_session_degree_id_05', 'visit_lodge_worshipful_master_name_05', 'visit_lodge_warden_name_05', 'visit_lodge_warden_phone_05', 'visit_lodge_warden_email_05', 'visit_lodge_address_05', 'visit_lodge_name_06', 'visit_lodge_number_06', 'visit_lodge_rite_id_06', 'visit_lodge_governing_body_id_06', 'visit_lodge_date_06', 'visit_lodge_session_degree_id_06', 'visit_lodge_worshipful_master_name_06', 'visit_lodge_warden_name_06', 'visit_lodge_warden_phone_06', 'visit_lodge_warden_email_06', 'visit_lodge_address_06', 'visit_lodge_name_07', 'visit_lodge_number_07', 'visit_lodge_rite_id_07', 'visit_lodge_governing_body_id_07', 'visit_lodge_date_07', 'visit_lodge_session_degree_id_07', 'visit_lodge_worshipful_master_name_07', 'visit_lodge_warden_name_07', 'visit_lodge_warden_phone_07', 'visit_lodge_warden_email_07', 'visit_lodge_address_07', 'warden_01', 'warden_02', 'warden_03', 'general_observations');
            $this->grocery_crud->required_fields('user_id');
            $this->grocery_crud->display_as('user_id','Obreiro')
                ->display_as('received_instruction_01','Ministrada 1&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_02','Ministrada 2&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_03','Ministrada 3&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_04','Ministrada 4&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_05','Ministrada 5&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_06','Ministrada 6&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_07','Ministrada 7&ordf; Instru&ccedil;&atilde;o')
                ->display_as('extra_work_title_01', '1&ordm; trabalho Extra')
                ->display_as('extra_work_title_02', '2&ordm; trabalho Extra')
                ->display_as('extra_work_title_03', '3&ordm; trabalho Extra')
                ->display_as('extra_work_title_04', '4&ordm; trabalho Extra')
                ->display_as('extra_work_title_05', '5&ordm; trabalho Extra')
                ->display_as('work_instruction_filename_01', 'Arquivo do trabalho da 1&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_02', 'Arquivo do trabalho da 2&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_03', 'Arquivo do trabalho da 3&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_04', 'Arquivo do trabalho da 4&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_05', 'Arquivo do trabalho da 5&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_06', 'Arquivo do trabalho da 6&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_07', 'Arquivo do trabalho da 7&ordf; Instru&ccedil;&atilde;o')
                ->display_as('extra_work_filename_01', 'Arquivo do 1&ordm; trabalho extra')
                ->display_as('extra_work_filename_02', 'Arquivo do 2&ordm; trabalho extra')
                ->display_as('extra_work_filename_03', 'Arquivo do 3&ordm; trabalho extra')
                ->display_as('extra_work_filename_04', 'Arquivo do 4&ordm; trabalho extra')
                ->display_as('extra_work_filename_05', 'Arquivo do 5&ordm; trabalho extra')
                ->display_as('visit_lodge_name_01', '1&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_01', '1&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_01', '1&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_02', '2&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_02', '2&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_02', '2&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_03', '3&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_03', '3&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_03', '3&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_04', '4&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_04', '4&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_04', '4&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_05', '5&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_05', '5&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_05', '5&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_06', '6&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_06', '6&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_06', '6&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_07', '7&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_07', '7&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_07', '7&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('warden_01', '01 - 1&ordm; Vig&there4; a cuidar da Col&there4;')
                ->display_as('warden_02', '02 - 1&ordm; Vig&there4; a cuidar da Col&there4;')
                ->display_as('warden_03', '03 - 1&ordm; Vig&there4; a cuidar da Col&there4;')
                ->display_as('general_observations', 'Observa&ccedil;&otilde;es Gerais');

            $this->grocery_crud->set_field_upload('work_instruction_filename_01','apprentice_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_02','apprentice_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_03','apprentice_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_04','apprentice_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_05','apprentice_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_06','apprentice_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_07','apprentice_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_01','apprentice_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_02','apprentice_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_03','apprentice_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_04','apprentice_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_05','apprentice_documents');

            $this->grocery_crud->callback_before_upload(array($this,'callback_before_upload_apprentice_document'));

            $this->grocery_crud->change_field_type('delivered_work_instruction_01', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_01', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_02', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_02', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_03', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_03', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_04', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_04', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_05', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_05', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_06', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_06', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_07', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_07', 'hidden');

            $this->grocery_crud->change_field_type('visit_lodge_number_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_07', 'hidden');

            $this->grocery_crud->change_field_type('delivered_extra_work_01', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_01', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_02', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_02', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_03', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_03', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_04', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_04', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_05', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_05', 'hidden');

            $this->grocery_crud->columns(array('user_id'));
            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_relation('user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']), 'name ASC');

            $this->grocery_crud->set_rules("user_id", "Membro", "callback_checkBeforeModifyApprenticeHistoryDatabase");

            $this->grocery_crud->callback_before_insert(array($this,'callback_before_modifying_apprentice_history'));
            $this->grocery_crud->callback_before_update(array($this,'callback_before_modifying_apprentice_history'));

            $this->grocery_crud->callback_edit_field('received_instruction_01',array($this,'edit_received_instruction_01'));
            $this->grocery_crud->callback_add_field('received_instruction_01',array($this,'add_received_instruction_01'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_01',array($this,'edit_delivered_work_instruction_01'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_01',array($this,'add_delivered_work_instruction_01'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_01',array($this,'edit_presented_work_instruction_01'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_01',array($this,'add_presented_work_instruction_01'));
            $this->grocery_crud->callback_edit_field('received_instruction_02',array($this,'edit_received_instruction_02'));
            $this->grocery_crud->callback_add_field('received_instruction_02',array($this,'add_received_instruction_02'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_02',array($this,'edit_delivered_work_instruction_02'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_02',array($this,'add_delivered_work_instruction_02'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_02',array($this,'edit_presented_work_instruction_02'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_02',array($this,'add_presented_work_instruction_02'));
            $this->grocery_crud->callback_edit_field('received_instruction_03',array($this,'edit_received_instruction_03'));
            $this->grocery_crud->callback_add_field('received_instruction_03',array($this,'add_received_instruction_03'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_03',array($this,'edit_delivered_work_instruction_03'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_03',array($this,'add_delivered_work_instruction_03'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_03',array($this,'edit_presented_work_instruction_03'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_03',array($this,'add_presented_work_instruction_03'));
            $this->grocery_crud->callback_edit_field('received_instruction_04',array($this,'edit_received_instruction_04'));
            $this->grocery_crud->callback_add_field('received_instruction_04',array($this,'add_received_instruction_04'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_04',array($this,'edit_delivered_work_instruction_04'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_04',array($this,'add_delivered_work_instruction_04'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_04',array($this,'edit_presented_work_instruction_04'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_04',array($this,'add_presented_work_instruction_04'));
            $this->grocery_crud->callback_edit_field('received_instruction_05',array($this,'edit_received_instruction_05'));
            $this->grocery_crud->callback_add_field('received_instruction_05',array($this,'add_received_instruction_05'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_05',array($this,'edit_delivered_work_instruction_05'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_05',array($this,'add_delivered_work_instruction_05'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_05',array($this,'edit_presented_work_instruction_05'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_05',array($this,'add_presented_work_instruction_05'));
            $this->grocery_crud->callback_edit_field('received_instruction_06',array($this,'edit_received_instruction_06'));
            $this->grocery_crud->callback_add_field('received_instruction_06',array($this,'add_received_instruction_06'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_06',array($this,'edit_delivered_work_instruction_06'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_06',array($this,'add_delivered_work_instruction_06'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_06',array($this,'edit_presented_work_instruction_06'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_06',array($this,'add_presented_work_instruction_06'));
            $this->grocery_crud->callback_edit_field('received_instruction_07',array($this,'edit_received_instruction_07'));
            $this->grocery_crud->callback_add_field('received_instruction_07',array($this,'add_received_instruction_07'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_07',array($this,'edit_delivered_work_instruction_07'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_07',array($this,'add_delivered_work_instruction_07'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_07',array($this,'edit_presented_work_instruction_07'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_07',array($this,'add_presented_work_instruction_07'));

            $this->grocery_crud->callback_edit_field('extra_work_title_01',array($this,'edit_extra_work_title_01'));
            $this->grocery_crud->callback_add_field('extra_work_title_01',array($this,'add_extra_work_title_01'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_01',array($this,'edit_delivered_extra_work_01'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_01',array($this,'add_delivered_extra_work_01'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_01',array($this,'edit_presented_extra_work_01'));
            $this->grocery_crud->callback_add_field('presented_extra_work_01',array($this,'add_presented_extra_work_01'));
            $this->grocery_crud->callback_edit_field('extra_work_title_02',array($this,'edit_extra_work_title_02'));
            $this->grocery_crud->callback_add_field('extra_work_title_02',array($this,'add_extra_work_title_02'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_02',array($this,'edit_delivered_extra_work_02'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_02',array($this,'add_delivered_extra_work_02'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_02',array($this,'edit_presented_extra_work_02'));
            $this->grocery_crud->callback_add_field('presented_extra_work_02',array($this,'add_presented_extra_work_02'));
            $this->grocery_crud->callback_edit_field('extra_work_title_03',array($this,'edit_extra_work_title_03'));
            $this->grocery_crud->callback_add_field('extra_work_title_03',array($this,'add_extra_work_title_03'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_03',array($this,'edit_delivered_extra_work_03'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_03',array($this,'add_delivered_extra_work_03'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_03',array($this,'edit_presented_extra_work_03'));
            $this->grocery_crud->callback_add_field('presented_extra_work_03',array($this,'add_presented_extra_work_03'));
            $this->grocery_crud->callback_edit_field('extra_work_title_04',array($this,'edit_extra_work_title_04'));
            $this->grocery_crud->callback_add_field('extra_work_title_04',array($this,'add_extra_work_title_04'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_04',array($this,'edit_delivered_extra_work_04'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_04',array($this,'add_delivered_extra_work_04'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_04',array($this,'edit_presented_extra_work_04'));
            $this->grocery_crud->callback_add_field('presented_extra_work_04',array($this,'add_presented_extra_work_04'));
            $this->grocery_crud->callback_edit_field('extra_work_title_05',array($this,'edit_extra_work_title_05'));
            $this->grocery_crud->callback_add_field('extra_work_title_05',array($this,'add_extra_work_title_05'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_05',array($this,'edit_delivered_extra_work_05'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_05',array($this,'add_delivered_extra_work_05'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_05',array($this,'edit_presented_extra_work_05'));
            $this->grocery_crud->callback_add_field('presented_extra_work_05',array($this,'add_presented_extra_work_05'));

            $this->grocery_crud->callback_edit_field('visit_lodge_name_01',array($this,'edit_visit_lodge_name_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_01',array($this,'add_visit_lodge_name_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_01',array($this,'edit_visit_lodge_number_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_01',array($this,'add_visit_lodge_number_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_01',array($this,'edit_visit_lodge_rite_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_01',array($this,'add_visit_lodge_rite_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_01',array($this,'edit_visit_lodge_governing_body_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_01',array($this,'add_visit_lodge_governing_body_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_01',array($this,'edit_visit_lodge_date_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_01',array($this,'add_visit_lodge_date_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_01',array($this,'edit_visit_lodge_session_degree_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_01',array($this,'add_visit_lodge_session_degree_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_01',array($this,'edit_visit_lodge_worshipful_master_name_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_01',array($this,'add_visit_lodge_worshipful_master_name_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_01',array($this,'edit_visit_lodge_warden_name_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_01',array($this,'add_visit_lodge_warden_name_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_01',array($this,'edit_visit_lodge_warden_phone_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_01',array($this,'add_visit_lodge_warden_phone_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_01',array($this,'edit_visit_lodge_warden_email_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_01',array($this,'add_visit_lodge_warden_email_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_02',array($this,'edit_visit_lodge_name_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_02',array($this,'add_visit_lodge_name_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_02',array($this,'edit_visit_lodge_number_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_02',array($this,'add_visit_lodge_number_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_02',array($this,'edit_visit_lodge_rite_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_02',array($this,'add_visit_lodge_rite_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_02',array($this,'edit_visit_lodge_governing_body_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_02',array($this,'add_visit_lodge_governing_body_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_02',array($this,'edit_visit_lodge_date_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_02',array($this,'add_visit_lodge_date_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_02',array($this,'edit_visit_lodge_session_degree_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_02',array($this,'add_visit_lodge_session_degree_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_02',array($this,'edit_visit_lodge_worshipful_master_name_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_02',array($this,'add_visit_lodge_worshipful_master_name_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_02',array($this,'edit_visit_lodge_warden_name_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_02',array($this,'add_visit_lodge_warden_name_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_02',array($this,'edit_visit_lodge_warden_phone_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_02',array($this,'add_visit_lodge_warden_phone_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_02',array($this,'edit_visit_lodge_warden_email_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_02',array($this,'add_visit_lodge_warden_email_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_03',array($this,'edit_visit_lodge_name_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_03',array($this,'add_visit_lodge_name_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_03',array($this,'edit_visit_lodge_number_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_03',array($this,'add_visit_lodge_number_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_03',array($this,'edit_visit_lodge_rite_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_03',array($this,'add_visit_lodge_rite_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_03',array($this,'edit_visit_lodge_governing_body_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_03',array($this,'add_visit_lodge_governing_body_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_03',array($this,'edit_visit_lodge_date_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_03',array($this,'add_visit_lodge_date_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_03',array($this,'edit_visit_lodge_session_degree_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_03',array($this,'add_visit_lodge_session_degree_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_03',array($this,'edit_visit_lodge_worshipful_master_name_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_03',array($this,'add_visit_lodge_worshipful_master_name_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_03',array($this,'edit_visit_lodge_warden_name_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_03',array($this,'add_visit_lodge_warden_name_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_03',array($this,'edit_visit_lodge_warden_phone_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_03',array($this,'add_visit_lodge_warden_phone_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_03',array($this,'edit_visit_lodge_warden_email_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_03',array($this,'add_visit_lodge_warden_email_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_04',array($this,'edit_visit_lodge_name_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_04',array($this,'add_visit_lodge_name_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_04',array($this,'edit_visit_lodge_number_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_04',array($this,'add_visit_lodge_number_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_04',array($this,'edit_visit_lodge_rite_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_04',array($this,'add_visit_lodge_rite_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_04',array($this,'edit_visit_lodge_governing_body_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_04',array($this,'add_visit_lodge_governing_body_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_04',array($this,'edit_visit_lodge_date_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_04',array($this,'add_visit_lodge_date_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_04',array($this,'edit_visit_lodge_session_degree_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_04',array($this,'add_visit_lodge_session_degree_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_04',array($this,'edit_visit_lodge_worshipful_master_name_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_04',array($this,'add_visit_lodge_worshipful_master_name_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_04',array($this,'edit_visit_lodge_warden_name_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_04',array($this,'add_visit_lodge_warden_name_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_04',array($this,'edit_visit_lodge_warden_phone_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_04',array($this,'add_visit_lodge_warden_phone_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_04',array($this,'edit_visit_lodge_warden_email_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_04',array($this,'add_visit_lodge_warden_email_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_05',array($this,'edit_visit_lodge_name_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_05',array($this,'add_visit_lodge_name_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_05',array($this,'edit_visit_lodge_number_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_05',array($this,'add_visit_lodge_number_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_05',array($this,'edit_visit_lodge_rite_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_05',array($this,'add_visit_lodge_rite_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_05',array($this,'edit_visit_lodge_governing_body_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_05',array($this,'add_visit_lodge_governing_body_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_05',array($this,'edit_visit_lodge_date_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_05',array($this,'add_visit_lodge_date_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_05',array($this,'edit_visit_lodge_session_degree_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_05',array($this,'add_visit_lodge_session_degree_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_05',array($this,'edit_visit_lodge_worshipful_master_name_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_05',array($this,'add_visit_lodge_worshipful_master_name_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_05',array($this,'edit_visit_lodge_warden_name_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_05',array($this,'add_visit_lodge_warden_name_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_05',array($this,'edit_visit_lodge_warden_phone_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_05',array($this,'add_visit_lodge_warden_phone_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_05',array($this,'edit_visit_lodge_warden_email_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_05',array($this,'add_visit_lodge_warden_email_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_06',array($this,'edit_visit_lodge_name_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_06',array($this,'add_visit_lodge_name_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_06',array($this,'edit_visit_lodge_number_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_06',array($this,'add_visit_lodge_number_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_06',array($this,'edit_visit_lodge_rite_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_06',array($this,'add_visit_lodge_rite_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_06',array($this,'edit_visit_lodge_governing_body_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_06',array($this,'add_visit_lodge_governing_body_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_06',array($this,'edit_visit_lodge_date_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_06',array($this,'add_visit_lodge_date_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_06',array($this,'edit_visit_lodge_session_degree_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_06',array($this,'add_visit_lodge_session_degree_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_06',array($this,'edit_visit_lodge_worshipful_master_name_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_06',array($this,'add_visit_lodge_worshipful_master_name_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_06',array($this,'edit_visit_lodge_warden_name_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_06',array($this,'add_visit_lodge_warden_name_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_06',array($this,'edit_visit_lodge_warden_phone_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_06',array($this,'add_visit_lodge_warden_phone_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_06',array($this,'edit_visit_lodge_warden_email_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_06',array($this,'add_visit_lodge_warden_email_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_07',array($this,'edit_visit_lodge_name_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_07',array($this,'add_visit_lodge_name_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_07',array($this,'edit_visit_lodge_number_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_07',array($this,'add_visit_lodge_number_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_07',array($this,'edit_visit_lodge_rite_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_07',array($this,'add_visit_lodge_rite_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_07',array($this,'edit_visit_lodge_governing_body_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_07',array($this,'add_visit_lodge_governing_body_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_07',array($this,'edit_visit_lodge_date_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_07',array($this,'add_visit_lodge_date_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_07',array($this,'edit_visit_lodge_session_degree_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_07',array($this,'add_visit_lodge_session_degree_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_07',array($this,'edit_visit_lodge_worshipful_master_name_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_07',array($this,'add_visit_lodge_worshipful_master_name_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_07',array($this,'edit_visit_lodge_warden_name_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_07',array($this,'add_visit_lodge_warden_name_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_07',array($this,'edit_visit_lodge_warden_phone_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_07',array($this,'add_visit_lodge_warden_phone_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_07',array($this,'edit_visit_lodge_warden_email_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_07',array($this,'add_visit_lodge_warden_email_07'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function fellowcraft_history()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('fellowcraft_history.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('fellowcraft_history');

            $this->grocery_crud->set_subject('Hist&oacute;rico de Companheiro');
            $this->grocery_crud->fields('id', 'lodge_id', 'user_id', 'received_instruction_01', 'delivered_work_instruction_01', 'presented_work_instruction_01', 'work_instruction_filename_01', 'received_instruction_02', 'delivered_work_instruction_02', 'presented_work_instruction_02', 'work_instruction_filename_02', 'received_instruction_03', 'delivered_work_instruction_03', 'presented_work_instruction_03', 'work_instruction_filename_03', 'received_instruction_04', 'delivered_work_instruction_04', 'presented_work_instruction_04', 'work_instruction_filename_04', 'received_instruction_05', 'delivered_work_instruction_05', 'presented_work_instruction_05', 'work_instruction_filename_05', 'extra_work_title_01', 'delivered_extra_work_01', 'presented_extra_work_01', 'extra_work_filename_01', 'extra_work_title_02', 'delivered_extra_work_02', 'presented_extra_work_02', 'extra_work_filename_02', 'extra_work_title_03', 'delivered_extra_work_03', 'presented_extra_work_03', 'extra_work_filename_03', 'extra_work_title_04', 'delivered_extra_work_04', 'presented_extra_work_04', 'extra_work_filename_04', 'extra_work_title_05', 'delivered_extra_work_05', 'presented_extra_work_05', 'extra_work_filename_05', 'visit_lodge_name_01', 'visit_lodge_number_01', 'visit_lodge_rite_id_01', 'visit_lodge_governing_body_id_01', 'visit_lodge_date_01', 'visit_lodge_session_degree_id_01', 'visit_lodge_worshipful_master_name_01', 'visit_lodge_warden_name_01', 'visit_lodge_warden_phone_01', 'visit_lodge_warden_email_01', 'visit_lodge_address_01', 'visit_lodge_name_02', 'visit_lodge_number_02', 'visit_lodge_rite_id_02', 'visit_lodge_governing_body_id_02', 'visit_lodge_date_02', 'visit_lodge_session_degree_id_02', 'visit_lodge_worshipful_master_name_02', 'visit_lodge_warden_name_02', 'visit_lodge_warden_phone_02', 'visit_lodge_warden_email_02', 'visit_lodge_address_02', 'visit_lodge_name_03', 'visit_lodge_number_03', 'visit_lodge_rite_id_03', 'visit_lodge_governing_body_id_03', 'visit_lodge_date_03', 'visit_lodge_session_degree_id_03', 'visit_lodge_worshipful_master_name_03', 'visit_lodge_warden_name_03', 'visit_lodge_warden_phone_03', 'visit_lodge_warden_email_03', 'visit_lodge_address_03', 'visit_lodge_name_04', 'visit_lodge_number_04', 'visit_lodge_rite_id_04', 'visit_lodge_governing_body_id_04', 'visit_lodge_date_04', 'visit_lodge_session_degree_id_04', 'visit_lodge_worshipful_master_name_04', 'visit_lodge_warden_name_04', 'visit_lodge_warden_phone_04', 'visit_lodge_warden_email_04', 'visit_lodge_address_04', 'visit_lodge_name_05', 'visit_lodge_number_05', 'visit_lodge_rite_id_05', 'visit_lodge_governing_body_id_05', 'visit_lodge_date_05', 'visit_lodge_session_degree_id_05', 'visit_lodge_worshipful_master_name_05', 'visit_lodge_warden_name_05', 'visit_lodge_warden_phone_05', 'visit_lodge_warden_email_05', 'visit_lodge_address_05', 'visit_lodge_name_06', 'visit_lodge_number_06', 'visit_lodge_rite_id_06', 'visit_lodge_governing_body_id_06', 'visit_lodge_date_06', 'visit_lodge_session_degree_id_06', 'visit_lodge_worshipful_master_name_06', 'visit_lodge_warden_name_06', 'visit_lodge_warden_phone_06', 'visit_lodge_warden_email_06', 'visit_lodge_address_06', 'visit_lodge_name_07', 'visit_lodge_number_07', 'visit_lodge_rite_id_07', 'visit_lodge_governing_body_id_07', 'visit_lodge_date_07', 'visit_lodge_session_degree_id_07', 'visit_lodge_worshipful_master_name_07', 'visit_lodge_warden_name_07', 'visit_lodge_warden_phone_07', 'visit_lodge_warden_email_07', 'visit_lodge_address_07', 'warden_01', 'warden_02', 'warden_03', 'general_observations');
            $this->grocery_crud->required_fields('user_id');
            $this->grocery_crud->display_as('user_id','Obreiro')
                ->display_as('received_instruction_01','Ministrada 1&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_02','Ministrada 2&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_03','Ministrada 3&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_04','Ministrada 4&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_05','Ministrada 5&ordf; Instru&ccedil;&atilde;o')
                ->display_as('extra_work_title_01', '1&ordm; trabalho Extra')
                ->display_as('extra_work_title_02', '2&ordm; trabalho Extra')
                ->display_as('extra_work_title_03', '3&ordm; trabalho Extra')
                ->display_as('extra_work_title_04', '4&ordm; trabalho Extra')
                ->display_as('extra_work_title_05', '5&ordm; trabalho Extra')
                ->display_as('work_instruction_filename_01', 'Arquivo do trabalho da 1&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_02', 'Arquivo do trabalho da 2&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_03', 'Arquivo do trabalho da 3&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_04', 'Arquivo do trabalho da 4&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_05', 'Arquivo do trabalho da 5&ordf; Instru&ccedil;&atilde;o')
                ->display_as('extra_work_filename_01', 'Arquivo do 1&ordm; trabalho extra')
                ->display_as('extra_work_filename_02', 'Arquivo do 2&ordm; trabalho extra')
                ->display_as('extra_work_filename_03', 'Arquivo do 3&ordm; trabalho extra')
                ->display_as('extra_work_filename_04', 'Arquivo do 4&ordm; trabalho extra')
                ->display_as('extra_work_filename_05', 'Arquivo do 5&ordm; trabalho extra')
                ->display_as('visit_lodge_name_01', '1&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_01', '1&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_01', '1&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_02', '2&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_02', '2&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_02', '2&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_03', '3&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_03', '3&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_03', '3&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_04', '4&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_04', '4&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_04', '4&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_05', '5&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_05', '5&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_05', '5&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_06', '6&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_06', '6&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_06', '6&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_07', '7&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_07', '7&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_07', '7&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('warden_01', '01 - 2&ordm; Vig&there4; a cuidar da Col&there4;')
                ->display_as('warden_02', '02 - 2&ordm; Vig&there4; a cuidar da Col&there4;')
                ->display_as('warden_03', '03 - 2&ordm; Vig&there4; a cuidar da Col&there4;')
                ->display_as('general_observations', 'Observa&ccedil;&otilde;es Gerais');

            $this->grocery_crud->set_field_upload('work_instruction_filename_01','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_02','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_03','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_04','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_05','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_01','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_02','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_03','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_04','fellowcraft_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_05','fellowcraft_documents');

            $this->grocery_crud->callback_before_upload(array($this,'callback_before_upload_fellowcraft_document'));

            $this->grocery_crud->change_field_type('delivered_work_instruction_01', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_01', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_02', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_02', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_03', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_03', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_04', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_04', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_05', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_05', 'hidden');

            $this->grocery_crud->change_field_type('visit_lodge_number_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_name_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_phone_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_warden_email_07', 'hidden');

            $this->grocery_crud->change_field_type('delivered_extra_work_01', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_01', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_02', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_02', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_03', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_03', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_04', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_04', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_05', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_05', 'hidden');

            $this->grocery_crud->columns(array('user_id'));
            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_relation('user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']), 'name ASC');

            $this->grocery_crud->set_rules("user_id", "Membro", "callback_checkBeforeModifyFellowcraftHistoryDatabase");

            $this->grocery_crud->callback_before_insert(array($this,'callback_before_modifying_fellowcraft_history'));
            $this->grocery_crud->callback_before_update(array($this,'callback_before_modifying_fellowcraft_history'));

            $this->grocery_crud->callback_edit_field('received_instruction_01',array($this,'edit_received_instruction_01'));
            $this->grocery_crud->callback_add_field('received_instruction_01',array($this,'add_received_instruction_01'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_01',array($this,'edit_delivered_work_instruction_01'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_01',array($this,'add_delivered_work_instruction_01'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_01',array($this,'edit_presented_work_instruction_01'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_01',array($this,'add_presented_work_instruction_01'));
            $this->grocery_crud->callback_edit_field('received_instruction_02',array($this,'edit_received_instruction_02'));
            $this->grocery_crud->callback_add_field('received_instruction_02',array($this,'add_received_instruction_02'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_02',array($this,'edit_delivered_work_instruction_02'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_02',array($this,'add_delivered_work_instruction_02'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_02',array($this,'edit_presented_work_instruction_02'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_02',array($this,'add_presented_work_instruction_02'));
            $this->grocery_crud->callback_edit_field('received_instruction_03',array($this,'edit_received_instruction_03'));
            $this->grocery_crud->callback_add_field('received_instruction_03',array($this,'add_received_instruction_03'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_03',array($this,'edit_delivered_work_instruction_03'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_03',array($this,'add_delivered_work_instruction_03'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_03',array($this,'edit_presented_work_instruction_03'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_03',array($this,'add_presented_work_instruction_03'));
            $this->grocery_crud->callback_edit_field('received_instruction_04',array($this,'edit_received_instruction_04'));
            $this->grocery_crud->callback_add_field('received_instruction_04',array($this,'add_received_instruction_04'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_04',array($this,'edit_delivered_work_instruction_04'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_04',array($this,'add_delivered_work_instruction_04'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_04',array($this,'edit_presented_work_instruction_04'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_04',array($this,'add_presented_work_instruction_04'));
            $this->grocery_crud->callback_edit_field('received_instruction_05',array($this,'edit_received_instruction_05'));
            $this->grocery_crud->callback_add_field('received_instruction_05',array($this,'add_received_instruction_05'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_05',array($this,'edit_delivered_work_instruction_05'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_05',array($this,'add_delivered_work_instruction_05'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_05',array($this,'edit_presented_work_instruction_05'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_05',array($this,'add_presented_work_instruction_05'));

            $this->grocery_crud->callback_edit_field('extra_work_title_01',array($this,'edit_extra_work_title_01'));
            $this->grocery_crud->callback_add_field('extra_work_title_01',array($this,'add_extra_work_title_01'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_01',array($this,'edit_delivered_extra_work_01'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_01',array($this,'add_delivered_extra_work_01'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_01',array($this,'edit_presented_extra_work_01'));
            $this->grocery_crud->callback_add_field('presented_extra_work_01',array($this,'add_presented_extra_work_01'));
            $this->grocery_crud->callback_edit_field('extra_work_title_02',array($this,'edit_extra_work_title_02'));
            $this->grocery_crud->callback_add_field('extra_work_title_02',array($this,'add_extra_work_title_02'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_02',array($this,'edit_delivered_extra_work_02'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_02',array($this,'add_delivered_extra_work_02'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_02',array($this,'edit_presented_extra_work_02'));
            $this->grocery_crud->callback_add_field('presented_extra_work_02',array($this,'add_presented_extra_work_02'));
            $this->grocery_crud->callback_edit_field('extra_work_title_03',array($this,'edit_extra_work_title_03'));
            $this->grocery_crud->callback_add_field('extra_work_title_03',array($this,'add_extra_work_title_03'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_03',array($this,'edit_delivered_extra_work_03'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_03',array($this,'add_delivered_extra_work_03'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_03',array($this,'edit_presented_extra_work_03'));
            $this->grocery_crud->callback_add_field('presented_extra_work_03',array($this,'add_presented_extra_work_03'));
            $this->grocery_crud->callback_edit_field('extra_work_title_04',array($this,'edit_extra_work_title_04'));
            $this->grocery_crud->callback_add_field('extra_work_title_04',array($this,'add_extra_work_title_04'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_04',array($this,'edit_delivered_extra_work_04'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_04',array($this,'add_delivered_extra_work_04'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_04',array($this,'edit_presented_extra_work_04'));
            $this->grocery_crud->callback_add_field('presented_extra_work_04',array($this,'add_presented_extra_work_04'));
            $this->grocery_crud->callback_edit_field('extra_work_title_05',array($this,'edit_extra_work_title_05'));
            $this->grocery_crud->callback_add_field('extra_work_title_05',array($this,'add_extra_work_title_05'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_05',array($this,'edit_delivered_extra_work_05'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_05',array($this,'add_delivered_extra_work_05'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_05',array($this,'edit_presented_extra_work_05'));
            $this->grocery_crud->callback_add_field('presented_extra_work_05',array($this,'add_presented_extra_work_05'));

            $this->grocery_crud->callback_edit_field('visit_lodge_name_01',array($this,'edit_visit_lodge_name_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_01',array($this,'add_visit_lodge_name_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_01',array($this,'edit_visit_lodge_number_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_01',array($this,'add_visit_lodge_number_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_01',array($this,'edit_visit_lodge_rite_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_01',array($this,'add_visit_lodge_rite_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_01',array($this,'edit_visit_lodge_governing_body_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_01',array($this,'add_visit_lodge_governing_body_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_01',array($this,'edit_visit_lodge_date_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_01',array($this,'add_visit_lodge_date_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_01',array($this,'edit_visit_lodge_session_degree_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_01',array($this,'add_visit_lodge_session_degree_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_01',array($this,'edit_visit_lodge_worshipful_master_name_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_01',array($this,'add_visit_lodge_worshipful_master_name_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_01',array($this,'edit_visit_lodge_warden_name_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_01',array($this,'add_visit_lodge_warden_name_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_01',array($this,'edit_visit_lodge_warden_phone_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_01',array($this,'add_visit_lodge_warden_phone_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_01',array($this,'edit_visit_lodge_warden_email_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_01',array($this,'add_visit_lodge_warden_email_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_02',array($this,'edit_visit_lodge_name_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_02',array($this,'add_visit_lodge_name_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_02',array($this,'edit_visit_lodge_number_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_02',array($this,'add_visit_lodge_number_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_02',array($this,'edit_visit_lodge_rite_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_02',array($this,'add_visit_lodge_rite_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_02',array($this,'edit_visit_lodge_governing_body_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_02',array($this,'add_visit_lodge_governing_body_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_02',array($this,'edit_visit_lodge_date_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_02',array($this,'add_visit_lodge_date_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_02',array($this,'edit_visit_lodge_session_degree_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_02',array($this,'add_visit_lodge_session_degree_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_02',array($this,'edit_visit_lodge_worshipful_master_name_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_02',array($this,'add_visit_lodge_worshipful_master_name_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_02',array($this,'edit_visit_lodge_warden_name_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_02',array($this,'add_visit_lodge_warden_name_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_02',array($this,'edit_visit_lodge_warden_phone_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_02',array($this,'add_visit_lodge_warden_phone_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_02',array($this,'edit_visit_lodge_warden_email_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_02',array($this,'add_visit_lodge_warden_email_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_03',array($this,'edit_visit_lodge_name_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_03',array($this,'add_visit_lodge_name_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_03',array($this,'edit_visit_lodge_number_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_03',array($this,'add_visit_lodge_number_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_03',array($this,'edit_visit_lodge_rite_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_03',array($this,'add_visit_lodge_rite_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_03',array($this,'edit_visit_lodge_governing_body_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_03',array($this,'add_visit_lodge_governing_body_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_03',array($this,'edit_visit_lodge_date_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_03',array($this,'add_visit_lodge_date_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_03',array($this,'edit_visit_lodge_session_degree_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_03',array($this,'add_visit_lodge_session_degree_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_03',array($this,'edit_visit_lodge_worshipful_master_name_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_03',array($this,'add_visit_lodge_worshipful_master_name_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_03',array($this,'edit_visit_lodge_warden_name_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_03',array($this,'add_visit_lodge_warden_name_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_03',array($this,'edit_visit_lodge_warden_phone_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_03',array($this,'add_visit_lodge_warden_phone_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_03',array($this,'edit_visit_lodge_warden_email_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_03',array($this,'add_visit_lodge_warden_email_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_04',array($this,'edit_visit_lodge_name_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_04',array($this,'add_visit_lodge_name_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_04',array($this,'edit_visit_lodge_number_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_04',array($this,'add_visit_lodge_number_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_04',array($this,'edit_visit_lodge_rite_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_04',array($this,'add_visit_lodge_rite_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_04',array($this,'edit_visit_lodge_governing_body_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_04',array($this,'add_visit_lodge_governing_body_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_04',array($this,'edit_visit_lodge_date_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_04',array($this,'add_visit_lodge_date_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_04',array($this,'edit_visit_lodge_session_degree_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_04',array($this,'add_visit_lodge_session_degree_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_04',array($this,'edit_visit_lodge_worshipful_master_name_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_04',array($this,'add_visit_lodge_worshipful_master_name_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_04',array($this,'edit_visit_lodge_warden_name_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_04',array($this,'add_visit_lodge_warden_name_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_04',array($this,'edit_visit_lodge_warden_phone_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_04',array($this,'add_visit_lodge_warden_phone_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_04',array($this,'edit_visit_lodge_warden_email_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_04',array($this,'add_visit_lodge_warden_email_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_05',array($this,'edit_visit_lodge_name_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_05',array($this,'add_visit_lodge_name_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_05',array($this,'edit_visit_lodge_number_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_05',array($this,'add_visit_lodge_number_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_05',array($this,'edit_visit_lodge_rite_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_05',array($this,'add_visit_lodge_rite_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_05',array($this,'edit_visit_lodge_governing_body_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_05',array($this,'add_visit_lodge_governing_body_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_05',array($this,'edit_visit_lodge_date_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_05',array($this,'add_visit_lodge_date_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_05',array($this,'edit_visit_lodge_session_degree_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_05',array($this,'add_visit_lodge_session_degree_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_05',array($this,'edit_visit_lodge_worshipful_master_name_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_05',array($this,'add_visit_lodge_worshipful_master_name_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_05',array($this,'edit_visit_lodge_warden_name_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_05',array($this,'add_visit_lodge_warden_name_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_05',array($this,'edit_visit_lodge_warden_phone_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_05',array($this,'add_visit_lodge_warden_phone_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_05',array($this,'edit_visit_lodge_warden_email_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_05',array($this,'add_visit_lodge_warden_email_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_06',array($this,'edit_visit_lodge_name_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_06',array($this,'add_visit_lodge_name_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_06',array($this,'edit_visit_lodge_number_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_06',array($this,'add_visit_lodge_number_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_06',array($this,'edit_visit_lodge_rite_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_06',array($this,'add_visit_lodge_rite_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_06',array($this,'edit_visit_lodge_governing_body_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_06',array($this,'add_visit_lodge_governing_body_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_06',array($this,'edit_visit_lodge_date_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_06',array($this,'add_visit_lodge_date_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_06',array($this,'edit_visit_lodge_session_degree_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_06',array($this,'add_visit_lodge_session_degree_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_06',array($this,'edit_visit_lodge_worshipful_master_name_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_06',array($this,'add_visit_lodge_worshipful_master_name_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_06',array($this,'edit_visit_lodge_warden_name_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_06',array($this,'add_visit_lodge_warden_name_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_06',array($this,'edit_visit_lodge_warden_phone_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_06',array($this,'add_visit_lodge_warden_phone_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_06',array($this,'edit_visit_lodge_warden_email_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_06',array($this,'add_visit_lodge_warden_email_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_07',array($this,'edit_visit_lodge_name_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_07',array($this,'add_visit_lodge_name_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_07',array($this,'edit_visit_lodge_number_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_07',array($this,'add_visit_lodge_number_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_07',array($this,'edit_visit_lodge_rite_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_07',array($this,'add_visit_lodge_rite_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_07',array($this,'edit_visit_lodge_governing_body_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_07',array($this,'add_visit_lodge_governing_body_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_07',array($this,'edit_visit_lodge_date_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_07',array($this,'add_visit_lodge_date_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_07',array($this,'edit_visit_lodge_session_degree_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_07',array($this,'add_visit_lodge_session_degree_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_07',array($this,'edit_visit_lodge_worshipful_master_name_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_07',array($this,'add_visit_lodge_worshipful_master_name_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_name_07',array($this,'edit_visit_lodge_warden_name_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_name_07',array($this,'add_visit_lodge_warden_name_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_phone_07',array($this,'edit_visit_lodge_warden_phone_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_phone_07',array($this,'add_visit_lodge_warden_phone_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_warden_email_07',array($this,'edit_visit_lodge_warden_email_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_warden_email_07',array($this,'add_visit_lodge_warden_email_07'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function master_history()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('master_history.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('master_history');

            $this->grocery_crud->set_subject('Hist&oacute;rico de Mestre');
            $this->grocery_crud->fields('id', 'lodge_id', 'user_id', 'received_instruction_01', 'delivered_work_instruction_01', 'presented_work_instruction_01', 'work_instruction_filename_01', 'received_instruction_02', 'delivered_work_instruction_02', 'presented_work_instruction_02', 'work_instruction_filename_02', 'received_instruction_03', 'delivered_work_instruction_03', 'presented_work_instruction_03', 'work_instruction_filename_03', 'extra_work_title_01', 'delivered_extra_work_01', 'presented_extra_work_01', 'extra_work_filename_01', 'extra_work_title_02', 'delivered_extra_work_02', 'presented_extra_work_02', 'extra_work_filename_02', 'extra_work_title_03', 'delivered_extra_work_03', 'presented_extra_work_03', 'extra_work_filename_03', 'extra_work_title_04', 'delivered_extra_work_04', 'presented_extra_work_04', 'extra_work_filename_04', 'extra_work_title_05', 'delivered_extra_work_05', 'presented_extra_work_05', 'extra_work_filename_05', 'extra_work_title_06', 'delivered_extra_work_06', 'presented_extra_work_06', 'extra_work_filename_06', 'extra_work_title_07', 'delivered_extra_work_07', 'presented_extra_work_07', 'extra_work_filename_07', 'visit_lodge_name_01', 'visit_lodge_number_01', 'visit_lodge_rite_id_01', 'visit_lodge_governing_body_id_01', 'visit_lodge_date_01', 'visit_lodge_session_degree_id_01', 'visit_lodge_worshipful_master_name_01', 'visit_lodge_worshipful_master_phone_01', 'visit_lodge_worshipful_master_email_01', 'visit_lodge_address_01', 'visit_lodge_name_02', 'visit_lodge_number_02', 'visit_lodge_rite_id_02', 'visit_lodge_governing_body_id_02', 'visit_lodge_date_02', 'visit_lodge_session_degree_id_02', 'visit_lodge_worshipful_master_name_02', 'visit_lodge_worshipful_master_phone_02', 'visit_lodge_worshipful_master_email_02', 'visit_lodge_address_02', 'visit_lodge_name_03', 'visit_lodge_number_03', 'visit_lodge_rite_id_03', 'visit_lodge_governing_body_id_03', 'visit_lodge_date_03', 'visit_lodge_session_degree_id_03', 'visit_lodge_worshipful_master_name_03', 'visit_lodge_worshipful_master_phone_03', 'visit_lodge_worshipful_master_email_03', 'visit_lodge_address_03', 'visit_lodge_name_04', 'visit_lodge_number_04', 'visit_lodge_rite_id_04', 'visit_lodge_governing_body_id_04', 'visit_lodge_date_04', 'visit_lodge_session_degree_id_04', 'visit_lodge_worshipful_master_name_04', 'visit_lodge_worshipful_master_phone_04', 'visit_lodge_worshipful_master_email_04', 'visit_lodge_address_04', 'visit_lodge_name_05', 'visit_lodge_number_05', 'visit_lodge_rite_id_05', 'visit_lodge_governing_body_id_05', 'visit_lodge_date_05', 'visit_lodge_session_degree_id_05', 'visit_lodge_worshipful_master_name_05', 'visit_lodge_worshipful_master_phone_05', 'visit_lodge_worshipful_master_email_05', 'visit_lodge_address_05', 'visit_lodge_name_06', 'visit_lodge_number_06', 'visit_lodge_rite_id_06', 'visit_lodge_governing_body_id_06', 'visit_lodge_date_06', 'visit_lodge_session_degree_id_06', 'visit_lodge_worshipful_master_name_06', 'visit_lodge_worshipful_master_phone_06', 'visit_lodge_worshipful_master_email_06', 'visit_lodge_address_06', 'visit_lodge_name_07', 'visit_lodge_number_07', 'visit_lodge_rite_id_07', 'visit_lodge_governing_body_id_07', 'visit_lodge_date_07', 'visit_lodge_session_degree_id_07', 'visit_lodge_worshipful_master_name_07', 'visit_lodge_worshipful_master_phone_07', 'visit_lodge_worshipful_master_email_07', 'visit_lodge_address_07', 'worshipful_master_01', 'worshipful_master_02', 'worshipful_master_03', 'general_observations');
            $this->grocery_crud->required_fields('user_id');
            $this->grocery_crud->display_as('user_id','Obreiro')
                ->display_as('received_instruction_01','Ministrada 1&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_02','Ministrada 2&ordf; Instru&ccedil;&atilde;o')
                ->display_as('received_instruction_03','Ministrada 3&ordf; Instru&ccedil;&atilde;o')
                ->display_as('extra_work_title_01', '1&ordm; trabalho Extra')
                ->display_as('extra_work_title_02', '2&ordm; trabalho Extra')
                ->display_as('extra_work_title_03', '3&ordm; trabalho Extra')
                ->display_as('extra_work_title_04', '4&ordm; trabalho Extra')
                ->display_as('extra_work_title_05', '5&ordm; trabalho Extra')
                ->display_as('extra_work_title_06', '6&ordm; trabalho Extra')
                ->display_as('extra_work_title_07', '7&ordm; trabalho Extra')
                ->display_as('work_instruction_filename_01', 'Arquivo do trabalho da 1&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_02', 'Arquivo do trabalho da 2&ordf; Instru&ccedil;&atilde;o')
                ->display_as('work_instruction_filename_03', 'Arquivo do trabalho da 3&ordf; Instru&ccedil;&atilde;o')
                ->display_as('extra_work_filename_01', 'Arquivo do 1&ordm; trabalho extra')
                ->display_as('extra_work_filename_02', 'Arquivo do 2&ordm; trabalho extra')
                ->display_as('extra_work_filename_03', 'Arquivo do 3&ordm; trabalho extra')
                ->display_as('extra_work_filename_04', 'Arquivo do 4&ordm; trabalho extra')
                ->display_as('extra_work_filename_05', 'Arquivo do 5&ordm; trabalho extra')
                ->display_as('extra_work_filename_06', 'Arquivo do 6&ordm; trabalho extra')
                ->display_as('extra_work_filename_07', 'Arquivo do 7&ordm; trabalho extra')
                ->display_as('visit_lodge_name_01', '1&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_01', '1&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_01', '1&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_02', '2&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_02', '2&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_02', '2&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_03', '3&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_03', '3&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_03', '3&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_04', '4&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_04', '4&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_04', '4&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_05', '5&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_05', '5&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_05', '5&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_06', '6&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_06', '6&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_06', '6&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('visit_lodge_name_07', '7&ordf; Visita - Dados da Loja')
                ->display_as('visit_lodge_session_degree_id_07', '7&ordf; Visita - Dados da Sess&atilde;o')
                ->display_as('visit_lodge_address_07', '7&ordf; Visita - Endere&ccedil;o da Loja')
                ->display_as('worshipful_master_01', '01 - V&there4; M&there4; / Instru&ccedil;&atilde;o')
                ->display_as('worshipful_master_02', '02 - V&there4; M&there4; / Instru&ccedil;&atilde;o')
                ->display_as('worshipful_master_03', '03 - V&there4; M&there4; / Instru&ccedil;&atilde;o')
                ->display_as('general_observations', 'Observa&ccedil;&otilde;es Gerais');

            $this->grocery_crud->set_field_upload('work_instruction_filename_01','master_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_02','master_documents');
            $this->grocery_crud->set_field_upload('work_instruction_filename_03','master_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_01','master_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_02','master_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_03','master_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_04','master_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_05','master_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_06','master_documents');
            $this->grocery_crud->set_field_upload('extra_work_filename_07','master_documents');

            $this->grocery_crud->callback_before_upload(array($this,'callback_before_upload_master_document'));

            $this->grocery_crud->change_field_type('delivered_work_instruction_01', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_01', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_02', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_02', 'hidden');
            $this->grocery_crud->change_field_type('delivered_work_instruction_03', 'hidden');
            $this->grocery_crud->change_field_type('presented_work_instruction_03', 'hidden');

            $this->grocery_crud->change_field_type('visit_lodge_number_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_phone_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_email_01', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_phone_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_email_02', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_phone_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_email_03', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_phone_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_email_04', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_phone_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_email_05', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_phone_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_email_06', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_number_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_rite_id_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_governing_body_id_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_date_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_name_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_phone_07', 'hidden');
            $this->grocery_crud->change_field_type('visit_lodge_worshipful_master_email_07', 'hidden');

            $this->grocery_crud->change_field_type('delivered_extra_work_01', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_01', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_02', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_02', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_03', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_03', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_04', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_04', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_05', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_05', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_06', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_06', 'hidden');
            $this->grocery_crud->change_field_type('delivered_extra_work_07', 'hidden');
            $this->grocery_crud->change_field_type('presented_extra_work_07', 'hidden');

            $this->grocery_crud->columns(array('user_id'));
            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_relation('user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']), 'name ASC');

            $this->grocery_crud->set_rules("user_id", "Membro", "callback_checkBeforeModifyMasterHistoryDatabase");

            $this->grocery_crud->callback_before_insert(array($this,'callback_before_modifying_master_history'));
            $this->grocery_crud->callback_before_update(array($this,'callback_before_modifying_master_history'));

            $this->grocery_crud->callback_edit_field('received_instruction_01',array($this,'edit_received_instruction_01'));
            $this->grocery_crud->callback_add_field('received_instruction_01',array($this,'add_received_instruction_01'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_01',array($this,'edit_delivered_work_instruction_01'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_01',array($this,'add_delivered_work_instruction_01'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_01',array($this,'edit_presented_work_instruction_01'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_01',array($this,'add_presented_work_instruction_01'));
            $this->grocery_crud->callback_edit_field('received_instruction_02',array($this,'edit_received_instruction_02'));
            $this->grocery_crud->callback_add_field('received_instruction_02',array($this,'add_received_instruction_02'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_02',array($this,'edit_delivered_work_instruction_02'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_02',array($this,'add_delivered_work_instruction_02'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_02',array($this,'edit_presented_work_instruction_02'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_02',array($this,'add_presented_work_instruction_02'));
            $this->grocery_crud->callback_edit_field('received_instruction_03',array($this,'edit_received_instruction_03'));
            $this->grocery_crud->callback_add_field('received_instruction_03',array($this,'add_received_instruction_03'));
            $this->grocery_crud->callback_edit_field('delivered_work_instruction_03',array($this,'edit_delivered_work_instruction_03'));
            $this->grocery_crud->callback_add_field('delivered_work_instruction_03',array($this,'add_delivered_work_instruction_03'));
            $this->grocery_crud->callback_edit_field('presented_work_instruction_03',array($this,'edit_presented_work_instruction_03'));
            $this->grocery_crud->callback_add_field('presented_work_instruction_03',array($this,'add_presented_work_instruction_03'));

            $this->grocery_crud->callback_edit_field('extra_work_title_01',array($this,'edit_extra_work_title_01'));
            $this->grocery_crud->callback_add_field('extra_work_title_01',array($this,'add_extra_work_title_01'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_01',array($this,'edit_delivered_extra_work_01'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_01',array($this,'add_delivered_extra_work_01'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_01',array($this,'edit_presented_extra_work_01'));
            $this->grocery_crud->callback_add_field('presented_extra_work_01',array($this,'add_presented_extra_work_01'));
            $this->grocery_crud->callback_edit_field('extra_work_title_02',array($this,'edit_extra_work_title_02'));
            $this->grocery_crud->callback_add_field('extra_work_title_02',array($this,'add_extra_work_title_02'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_02',array($this,'edit_delivered_extra_work_02'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_02',array($this,'add_delivered_extra_work_02'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_02',array($this,'edit_presented_extra_work_02'));
            $this->grocery_crud->callback_add_field('presented_extra_work_02',array($this,'add_presented_extra_work_02'));
            $this->grocery_crud->callback_edit_field('extra_work_title_03',array($this,'edit_extra_work_title_03'));
            $this->grocery_crud->callback_add_field('extra_work_title_03',array($this,'add_extra_work_title_03'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_03',array($this,'edit_delivered_extra_work_03'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_03',array($this,'add_delivered_extra_work_03'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_03',array($this,'edit_presented_extra_work_03'));
            $this->grocery_crud->callback_add_field('presented_extra_work_03',array($this,'add_presented_extra_work_03'));
            $this->grocery_crud->callback_edit_field('extra_work_title_04',array($this,'edit_extra_work_title_04'));
            $this->grocery_crud->callback_add_field('extra_work_title_04',array($this,'add_extra_work_title_04'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_04',array($this,'edit_delivered_extra_work_04'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_04',array($this,'add_delivered_extra_work_04'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_04',array($this,'edit_presented_extra_work_04'));
            $this->grocery_crud->callback_add_field('presented_extra_work_04',array($this,'add_presented_extra_work_04'));
            $this->grocery_crud->callback_edit_field('extra_work_title_05',array($this,'edit_extra_work_title_05'));
            $this->grocery_crud->callback_add_field('extra_work_title_05',array($this,'add_extra_work_title_05'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_05',array($this,'edit_delivered_extra_work_05'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_05',array($this,'add_delivered_extra_work_05'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_05',array($this,'edit_presented_extra_work_05'));
            $this->grocery_crud->callback_add_field('presented_extra_work_05',array($this,'add_presented_extra_work_05'));
            $this->grocery_crud->callback_edit_field('extra_work_title_06',array($this,'edit_extra_work_title_06'));
            $this->grocery_crud->callback_add_field('extra_work_title_06',array($this,'add_extra_work_title_06'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_06',array($this,'edit_delivered_extra_work_06'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_06',array($this,'add_delivered_extra_work_06'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_06',array($this,'edit_presented_extra_work_06'));
            $this->grocery_crud->callback_add_field('presented_extra_work_06',array($this,'add_presented_extra_work_06'));
            $this->grocery_crud->callback_edit_field('extra_work_title_07',array($this,'edit_extra_work_title_07'));
            $this->grocery_crud->callback_add_field('extra_work_title_07',array($this,'add_extra_work_title_07'));
            $this->grocery_crud->callback_edit_field('delivered_extra_work_07',array($this,'edit_delivered_extra_work_07'));
            $this->grocery_crud->callback_add_field('delivered_extra_work_07',array($this,'add_delivered_extra_work_07'));
            $this->grocery_crud->callback_edit_field('presented_extra_work_07',array($this,'edit_presented_extra_work_07'));
            $this->grocery_crud->callback_add_field('presented_extra_work_07',array($this,'add_presented_extra_work_07'));

            $this->grocery_crud->callback_edit_field('visit_lodge_name_01',array($this,'edit_visit_lodge_name_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_01',array($this,'add_visit_lodge_name_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_01',array($this,'edit_visit_lodge_number_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_01',array($this,'add_visit_lodge_number_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_01',array($this,'edit_visit_lodge_rite_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_01',array($this,'add_visit_lodge_rite_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_01',array($this,'edit_visit_lodge_governing_body_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_01',array($this,'add_visit_lodge_governing_body_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_01',array($this,'edit_visit_lodge_date_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_01',array($this,'add_visit_lodge_date_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_01',array($this,'edit_visit_lodge_session_degree_id_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_01',array($this,'add_visit_lodge_session_degree_id_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_01',array($this,'edit_visit_lodge_worshipful_master_name_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_01',array($this,'add_visit_lodge_worshipful_master_name_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_phone_01',array($this,'edit_visit_lodge_warden_phone_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_phone_01',array($this,'add_visit_lodge_warden_phone_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_email_01',array($this,'edit_visit_lodge_warden_email_01'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_email_01',array($this,'add_visit_lodge_warden_email_01'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_02',array($this,'edit_visit_lodge_name_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_02',array($this,'add_visit_lodge_name_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_02',array($this,'edit_visit_lodge_number_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_02',array($this,'add_visit_lodge_number_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_02',array($this,'edit_visit_lodge_rite_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_02',array($this,'add_visit_lodge_rite_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_02',array($this,'edit_visit_lodge_governing_body_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_02',array($this,'add_visit_lodge_governing_body_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_02',array($this,'edit_visit_lodge_date_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_02',array($this,'add_visit_lodge_date_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_02',array($this,'edit_visit_lodge_session_degree_id_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_02',array($this,'add_visit_lodge_session_degree_id_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_02',array($this,'edit_visit_lodge_worshipful_master_name_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_02',array($this,'add_visit_lodge_worshipful_master_name_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_phone_02',array($this,'edit_visit_lodge_warden_phone_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_phone_02',array($this,'add_visit_lodge_warden_phone_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_email_02',array($this,'edit_visit_lodge_warden_email_02'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_email_02',array($this,'add_visit_lodge_warden_email_02'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_03',array($this,'edit_visit_lodge_name_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_03',array($this,'add_visit_lodge_name_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_03',array($this,'edit_visit_lodge_number_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_03',array($this,'add_visit_lodge_number_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_03',array($this,'edit_visit_lodge_rite_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_03',array($this,'add_visit_lodge_rite_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_03',array($this,'edit_visit_lodge_governing_body_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_03',array($this,'add_visit_lodge_governing_body_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_03',array($this,'edit_visit_lodge_date_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_03',array($this,'add_visit_lodge_date_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_03',array($this,'edit_visit_lodge_session_degree_id_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_03',array($this,'add_visit_lodge_session_degree_id_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_03',array($this,'edit_visit_lodge_worshipful_master_name_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_03',array($this,'add_visit_lodge_worshipful_master_name_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_phone_03',array($this,'edit_visit_lodge_warden_phone_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_phone_03',array($this,'add_visit_lodge_warden_phone_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_email_03',array($this,'edit_visit_lodge_warden_email_03'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_email_03',array($this,'add_visit_lodge_warden_email_03'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_04',array($this,'edit_visit_lodge_name_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_04',array($this,'add_visit_lodge_name_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_04',array($this,'edit_visit_lodge_number_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_04',array($this,'add_visit_lodge_number_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_04',array($this,'edit_visit_lodge_rite_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_04',array($this,'add_visit_lodge_rite_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_04',array($this,'edit_visit_lodge_governing_body_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_04',array($this,'add_visit_lodge_governing_body_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_04',array($this,'edit_visit_lodge_date_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_04',array($this,'add_visit_lodge_date_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_04',array($this,'edit_visit_lodge_session_degree_id_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_04',array($this,'add_visit_lodge_session_degree_id_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_04',array($this,'edit_visit_lodge_worshipful_master_name_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_04',array($this,'add_visit_lodge_worshipful_master_name_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_phone_04',array($this,'edit_visit_lodge_warden_phone_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_phone_04',array($this,'add_visit_lodge_warden_phone_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_email_04',array($this,'edit_visit_lodge_warden_email_04'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_email_04',array($this,'add_visit_lodge_warden_email_04'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_05',array($this,'edit_visit_lodge_name_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_05',array($this,'add_visit_lodge_name_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_05',array($this,'edit_visit_lodge_number_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_05',array($this,'add_visit_lodge_number_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_05',array($this,'edit_visit_lodge_rite_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_05',array($this,'add_visit_lodge_rite_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_05',array($this,'edit_visit_lodge_governing_body_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_05',array($this,'add_visit_lodge_governing_body_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_05',array($this,'edit_visit_lodge_date_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_05',array($this,'add_visit_lodge_date_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_05',array($this,'edit_visit_lodge_session_degree_id_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_05',array($this,'add_visit_lodge_session_degree_id_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_05',array($this,'edit_visit_lodge_worshipful_master_name_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_05',array($this,'add_visit_lodge_worshipful_master_name_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_phone_05',array($this,'edit_visit_lodge_warden_phone_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_phone_05',array($this,'add_visit_lodge_warden_phone_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_email_05',array($this,'edit_visit_lodge_warden_email_05'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_email_05',array($this,'add_visit_lodge_warden_email_05'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_06',array($this,'edit_visit_lodge_name_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_06',array($this,'add_visit_lodge_name_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_06',array($this,'edit_visit_lodge_number_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_06',array($this,'add_visit_lodge_number_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_06',array($this,'edit_visit_lodge_rite_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_06',array($this,'add_visit_lodge_rite_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_06',array($this,'edit_visit_lodge_governing_body_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_06',array($this,'add_visit_lodge_governing_body_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_06',array($this,'edit_visit_lodge_date_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_06',array($this,'add_visit_lodge_date_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_06',array($this,'edit_visit_lodge_session_degree_id_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_06',array($this,'add_visit_lodge_session_degree_id_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_06',array($this,'edit_visit_lodge_worshipful_master_name_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_06',array($this,'add_visit_lodge_worshipful_master_name_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_phone_06',array($this,'edit_visit_lodge_warden_phone_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_phone_06',array($this,'add_visit_lodge_warden_phone_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_email_06',array($this,'edit_visit_lodge_warden_email_06'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_email_06',array($this,'add_visit_lodge_warden_email_06'));
            $this->grocery_crud->callback_edit_field('visit_lodge_name_07',array($this,'edit_visit_lodge_name_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_name_07',array($this,'add_visit_lodge_name_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_number_07',array($this,'edit_visit_lodge_number_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_number_07',array($this,'add_visit_lodge_number_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_rite_id_07',array($this,'edit_visit_lodge_rite_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_rite_id_07',array($this,'add_visit_lodge_rite_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_governing_body_id_07',array($this,'edit_visit_lodge_governing_body_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_governing_body_id_07',array($this,'add_visit_lodge_governing_body_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_date_07',array($this,'edit_visit_lodge_date_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_date_07',array($this,'add_visit_lodge_date_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_session_degree_id_07',array($this,'edit_visit_lodge_session_degree_id_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_session_degree_id_07',array($this,'add_visit_lodge_session_degree_id_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_name_07',array($this,'edit_visit_lodge_worshipful_master_name_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_name_07',array($this,'add_visit_lodge_worshipful_master_name_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_phone_07',array($this,'edit_visit_lodge_warden_phone_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_phone_07',array($this,'add_visit_lodge_warden_phone_07'));
            $this->grocery_crud->callback_edit_field('visit_lodge_worshipful_master_email_07',array($this,'edit_visit_lodge_warden_email_07'));
            $this->grocery_crud->callback_add_field('visit_lodge_worshipful_master_email_07',array($this,'add_visit_lodge_warden_email_07'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function sessions()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('sessions.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('sessions');

            $this->grocery_crud->set_subject('Sess&atilde;o');
            $this->grocery_crud->fields('id', 'lodge_id', 'session_category_id', 'degree_id', 'date', 'presences', 'agenda', 'record', 'general_observations');
            $this->grocery_crud->required_fields('session_category_id', 'degree_id', 'date');
            $this->grocery_crud->display_as('session_category_id','Tipo de Sess&atilde;o')
                ->display_as('degree_id','Grau da Sess&atilde;o')
                ->display_as('date','Data')
                ->display_as('presences', 'Presen&ccedil;as')
                ->display_as('agenda','Ordem do Dia')
                ->display_as('record','Ata')
                ->display_as('general_observations','Observa&ccedil;&otilde;es Gerais');

            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->callback_before_upload(array($this,'callback_before_upload_session_record'));
            $this->grocery_crud->set_field_upload('record','session_records');

            $this->grocery_crud->columns(array('date', 'session_category_id', 'degree_id'));

            $this->grocery_crud->set_relation('session_category_id','session_categories','name');
            $this->grocery_crud->set_relation('degree_id','degrees','name');
            $this->grocery_crud->set_relation_n_n('presences', 'sessions_users', 'users', 'session_id', 'user_id', 'name','priority', array('users.lodge_id'=>$_SESSION['lodge_id_as_admin']));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function wives()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('wives.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('wives');

            $this->grocery_crud->set_subject('Cunhada');
            $this->grocery_crud->fields('id', 'lodge_id', 'name', 'birth_date', 'profession', 'occupation', 'work_place', 'work_site', 'work_address', 'work_phone', 'mobile_phone', 'whatsapp_phone', 'email');
            $this->grocery_crud->required_fields('name', 'birth_date', 'email');
            $this->grocery_crud->display_as('name','Nome')
                ->display_as('birth_date','Data de Nascimento')
                ->display_as('profession','Profiss&atilde;o')
                ->display_as('occupation','Fun&ccedil;&atilde;o Atual')
                ->display_as('work_place','Onde exerce')
                ->display_as('work_site','Website Comercial')
                ->display_as('work_address','Endere&ccedil;o Comercial')
                ->display_as('work_phone','Telefone Comercial')
                ->display_as('mobile_phone','Celular')
                ->display_as('whatsapp_phone','N&uacute;mero WhatsApp')
                ->display_as('email','E-Mail');

            $this->grocery_crud->columns(array('name', 'birth_date','email','mobile_phone','whatsapp_phone'));
            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function nephews()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('nephews.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('nephews');

            $this->grocery_crud->set_subject('Sobrinho(a)');
            $this->grocery_crud->fields('id', 'lodge_id', 'name', 'birth_date', 'profession', 'occupation', 'work_place', 'work_site', 'work_address', 'work_phone', 'mobile_phone', 'whatsapp_phone', 'email');
            $this->grocery_crud->required_fields('name', 'birth_date');
            $this->grocery_crud->display_as('name','Nome')
                ->display_as('birth_date','Data de Nascimento')
                ->display_as('profession','Profiss&atilde;o')
                ->display_as('occupation','Fun&ccedil;&atilde;o Atual')
                ->display_as('work_place','Onde exerce')
                ->display_as('work_site','Website Comercial')
                ->display_as('work_address','Endere&ccedil;o Comercial')
                ->display_as('work_phone','Telefone Comercial')
                ->display_as('mobile_phone','Celular')
                ->display_as('whatsapp_phone','N&uacute;mero WhatsApp')
                ->display_as('email','E-Mail');

            $this->grocery_crud->columns(array('name', 'birth_date','email','mobile_phone','whatsapp_phone'));
            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function news()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->set_table('news');

            $this->grocery_crud->set_subject('Not&iacute;cia');
            $this->grocery_crud->add_fields('lodge_id', 'subject', 'contents','date_created','date_updated');
            $this->grocery_crud->edit_fields('lodge_id', 'subject', 'contents','date_updated');
            $this->grocery_crud->required_fields('subject', 'contents');
            $this->grocery_crud->display_as('lodge_id','Loja')
                ->display_as('subject','Assunto')
                ->display_as('contents','Conte&uacute;do')
                ->display_as('date_created','Data de Cria&ccedil;&atilde;o')
                ->display_as('date_updated','&Uacute;ltima atualiza&ccedil;&atilde;o');

            $this->grocery_crud->columns(array('subject', 'contents','date_created','date_updated'));
            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $now = date('Y-m-d G:i:s');
            $this->grocery_crud->change_field_type('date_created','hidden', $now);
            $this->grocery_crud->change_field_type('date_updated','hidden', $now);

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function calendar()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('calendar.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('calendar');

            $this->grocery_crud->set_subject('Evento');
            $this->grocery_crud->fields('id', 'lodge_id', 'date', 'contents');
            $this->grocery_crud->required_fields('date', 'contents');
            $this->grocery_crud->display_as('lodge_id','Loja')
                ->display_as('date','Data')
                ->display_as('contents','Conte&uacute;do');

            //$this->grocery_crud->set_relation('lodge_id','lodges','name');
            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->columns(array('date', 'contents'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function financial_entries()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('financial_entries.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('financial_entries');

            $this->grocery_crud->set_subject('Lançamento');
            $this->grocery_crud->fields('id', 'lodge_id', 'user_id', 'date', 'description', 'value');
            $this->grocery_crud->required_fields('user_id, date, value');
            $this->grocery_crud->display_as('lodge_id','Loja')
                ->display_as('user_id','Obreiro')
                ->display_as('date','Data')
                ->display_as('description','Descrição')
                ->display_as('value','Valor');

            //$this->grocery_crud->set_relation('lodge_id','lodges','name');
            $this->grocery_crud->set_relation('user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));

            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->field_type('value', 'integer');

            $this->grocery_crud->columns(array('user_id', 'date', 'description', 'value'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function beneficential_entries()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('beneficential_entries.lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('beneficential_entries');

            $this->grocery_crud->set_subject('Lançamento');
            $this->grocery_crud->fields('id', 'lodge_id', 'user_id', 'date', 'description', 'value');
            $this->grocery_crud->required_fields('user_id, date, value');
            $this->grocery_crud->display_as('lodge_id','Loja')
                ->display_as('user_id','Obreiro')
                ->display_as('date','Data')
                ->display_as('description','Descrição')
                ->display_as('value','Valor');

            $this->grocery_crud->set_relation('user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));

            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->field_type('value', 'integer');

            $this->grocery_crud->columns(array('user_id', 'date', 'description', 'value'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function documents()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('lodge_id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('documents');

            $this->grocery_crud->set_subject('Documento');
            $this->grocery_crud->fields('id', 'lodge_id', 'name', 'filename');
            $this->grocery_crud->required_fields('name', 'filename');
            $this->grocery_crud->display_as('lodge_id', 'Loja')
                ->display_as('name', 'Nome')
                ->display_as('filename', 'Nome do Arquivo')
                ->display_as('date_and_time','Data');

            $this->grocery_crud->change_field_type('id', 'hidden');
            $this->grocery_crud->change_field_type('lodge_id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_field_upload('filename','documents');
            $this->grocery_crud->callback_before_upload(array($this,'callback_before_upload_document'));

            //$this->grocery_crud->set_relation('lodge_id','lodges','name');
            $this->grocery_crud->columns(array('name', 'filename', 'date_and_time'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function lodge()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->where('lodges.id',$_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->set_table('lodges');

            $this->grocery_crud->set_subject('Loja');
            $this->grocery_crud->columns(array('logo', 'name', 'description'));
            $this->grocery_crud->edit_fields('id', 'temple_id', 'logo', 'description', 'members', 'worshipful_master_user_id', 'senior_warden_user_id', 'junior_warden_user_id', 'orator_user_id', 'secretary_user_id', 'treasurer_user_id', 'hospitable_user_id', 'chancellor_user_id');
            $this->grocery_crud->display_as('name', 'Name')
                ->display_as('temple_id', 'Templo')
                ->display_as('description', 'Descrição')
                ->display_as('logo', 'Logotipo')
                ->display_as('members', 'Convidados')
                ->display_as('worshipful_master_user_id', 'V&there4; M&there4;')
                ->display_as('senior_warden_user_id', '1&ordm; Vig&there4;')
                ->display_as('junior_warden_user_id', '2&ordm; Vig&there4;')
                ->display_as('orator_user_id', 'Orad&there4;')
                ->display_as('secretary_user_id', 'Secr&there4;')
                ->display_as('treasurer_user_id', 'Tes&there4;')
                ->display_as('hospitable_user_id', 'Hosp&there4;')
                ->display_as('chancellor_user_id', 'Chanc&there4;');

            $this->grocery_crud->set_relation('temple_id','temples','name');


            $this->grocery_crud->set_field_upload('logo','lodges_pictures');
            $this->grocery_crud->callback_before_upload(array($this,'callback_before_upload'));
            $this->grocery_crud->callback_before_update(array($this, 'before_update_members_callback'));
            $this->grocery_crud->callback_after_update(array($this, 'after_update_members_callback'));
            $this->grocery_crud->set_relation_n_n('members', 'lodge_members', 'users', 'lodge_members.lodge_id', 'user_id', 'name','priority');

            $this->grocery_crud->set_relation('worshipful_master_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
            $this->grocery_crud->set_relation('senior_warden_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
            $this->grocery_crud->set_relation('junior_warden_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
            $this->grocery_crud->set_relation('orator_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
            $this->grocery_crud->set_relation('secretary_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
            $this->grocery_crud->set_relation('treasurer_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
            $this->grocery_crud->set_relation('treasurer_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
            $this->grocery_crud->set_relation('hospitable_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));
            $this->grocery_crud->set_relation('chancellor_user_id','users','name', array('lodge_id' => $_SESSION['lodge_id_as_admin']));

            $this->grocery_crud->change_field_type('id','hidden', $_SESSION['lodge_id_as_admin']);

            $this->grocery_crud->unset_add();
            $this->grocery_crud->unset_read();
            $this->grocery_crud->unset_delete();

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    /*public function su_root_temples()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->set_table('temples');

            $this->grocery_crud->set_subject('Templo');
            $this->grocery_crud->fields('id', 'name', 'address', 'description');
            $this->grocery_crud->required_fields('name');
            $this->grocery_crud->display_as('name', 'Nome')
                ->display_as('address', 'Endere&ccedil;o')
                ->display_as('description', 'Descri&ccedil;&atilde;o');

            $this->grocery_crud->change_field_type('id', 'hidden');

            $this->grocery_crud->columns(array('name', 'address', 'description'));

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function su_root_lodges()
    {
        try
        {
            $this->grocery_crud->set_theme('datatables');

            $this->grocery_crud->set_table('lodges');

            $this->grocery_crud->set_subject('Loja');
            $this->grocery_crud->fields('id', 'logo', 'governing_body_id', 'temple_id', 'number', 'name', 'description', 'members');
            $this->grocery_crud->required_fields('governing_body_id', 'temple_id', 'number', 'name');
            $this->grocery_crud->display_as('logo', 'Logotipo')
                ->display_as('governing_body_id', 'Pot&ecirc;ncia')
                ->display_as('temple_id', 'Templo')
                ->display_as('number','N&uacute;mero')
                ->display_as('name', 'Nome')
                ->display_as('description','Descri&ccedil;&atilde;o')
                ->display_as('members', 'Convidados');

            $this->grocery_crud->change_field_type('id', 'hidden');

            $this->grocery_crud->set_field_upload('logo','lodges_pictures');
            $this->grocery_crud->callback_before_upload(array($this,'callback_before_upload'));

            $this->grocery_crud->set_relation('governing_body_id','governing_bodies','name');
            $this->grocery_crud->set_relation('temple_id','temples','name');

            $this->grocery_crud->columns(array('logo', 'name', 'description'));

            $this->grocery_crud->callback_before_update(array($this, 'before_update_members_callback'));
            $this->grocery_crud->callback_after_update(array($this, 'after_update_members_callback'));
            $this->grocery_crud->set_relation_n_n('members', 'lodge_members', 'users', 'lodge_members.lodge_id', 'user_id', 'name','priority');

            $output = $this->grocery_crud->render();

            $this->_example_output($output);
        }
        catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }*/

    function _example_output($output = null)

    {
        $this->load->view('main_view.php',$output);
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
