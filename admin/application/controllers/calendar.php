<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rdal
 * Date: 7/6/15
 * Time: 17:19
 * To change this template use File | Settings | File Templates.
 */

//require_once('commons.php');

class Calendar extends CI_Controller {


    function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('cookie');
        /* ------------------ */
        $prefs = array (
            'day_type' => 'long',
            'template' => '
        {table_open}<table class="calendar">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}
        {heading_previous_cell}<th><a href="{previous_url}">&larr;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&rarr;</a></th>{/heading_next_cell}
        {heading_row_end}</tr>{/heading_row_end}

        {week_day_cell}<th class="day_header">{week_day}</th>{/week_day_cell}
        {cal_cell_start}{/cal_cell_start}
        {cal_cell_content}<td id="ts_cell_{day}"><span class="day_listing">{day}</span>&nbsp; {content}&nbsp;{/cal_cell_content}
        {cal_cell_content_today}<td id="ts_cell_{day}"><div class="today"><span class="day_listing">{day}</span> {content}</div>{/cal_cell_content_today}
        {cal_cell_no_content}<td id="ts_cell_{day}"><span class="day_listing">{day}</span>&nbsp;{/cal_cell_no_content}
        {cal_cell_no_content_today}<td id="ts_cell_{day}"><div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
		{cal_cell_blank}<td>&nbsp;{/cal_cell_blank}',
            'show_next_prev' => TRUE,
            'next_prev_url' => base_url().'index.php/calendar/index'
        );
        //$this->load->library('grocery_CRUD');
        $this->load->library('calendar', $prefs);
    }

    function showCalendar($lodgeId)
    {
        $this->input->set_cookie("calendar_lodge_id", $lodgeId, 0, $_SERVER['HTTP_HOST'], "/");
        $this->index();
    }

    function index($ano = null, $mes = null)
    {
        //$commons = new Commons();

        //-------- Adaptacao de diretorio relativo para back no caso de nao estar logado ainda -----------
        $pieces = explode("/", $_SERVER["REQUEST_URI"]);
        $count_pieces = count($pieces);

        $flag = false;
        if(strlen($pieces[$count_pieces-1]) == 0) $flag = true;
        unset($pieces[$count_pieces-1]);
        unset($pieces[$count_pieces-2]);
        unset($pieces[$count_pieces-3]);
        if($flag) unset($pieces[$count_pieces-4]);
        $path = implode("/",$pieces);
        //------------------------------------------------------------------------------------------------

        //$commons->checkUserSession($path);

        //$db = new DBController();

        //$events = $db->getCalendarEvents($_SESSION['user_lodge_id'], $ano, $mes);

        //----------------------------- DATABASE QUERY --------------------------------------
        $ret = array();

        if(is_null($ano)){
            $ano = date('Y');
        }
        if(is_null($mes)){
            $mes = date('m');
        }

        $num_days = date("t", strtotime( $ano . "-" . $mes . "-01") );
        //$result = mysql_query("SELECT id, date, contents FROM calendar WHERE lodge_id = '".$lodgeId."' AND date BETWEEN '".$ano."-".$mes."-01' AND '".$ano."-".$mes."-".$num_days."'");

        $sql = "SELECT id, date, contents FROM calendar WHERE lodge_id = '".$this->input->cookie("calendar_lodge_id", TRUE)."' AND date BETWEEN '".$ano."-".$mes."-01' AND '".$ano."-".$mes."-".$num_days."'";
        $query = $this->db->query($sql);

        $data = array();
        foreach ($query->result() as $row)
        {
            $pieces = explode("-", $row->date);
            $day = (int)$pieces[2];
            $data[$day] = $row->contents;
        }
        //-----------------------------------------------------------------------------------

//        $data = array(
//            3  => 'fsdfds sdfsdfsd fdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsf dsfdsfds fdsfdsf dsfdsfs dfdsfds fsdfds sdfsdfsd fdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsf dsfdsfds fdsfdsf dsfdsfs dfdsfds fsdfds sdfsdfsd fdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsf dsfdsfds fdsfdsf dsfdsfs dfdsfds fsdfds sdfsdfsd fdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsf dsfdsfds fdsfdsf dsfdsfs dfdsfds fsdfds sdfsdfsd fdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsf dsfdsfds fdsfdsf dsfdsfs dfdsfds fsdfds sdfsdfsd fdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsfds fdsfdsf dsfdsf dsfdsfds fdsfdsf dsfdsfs dfdsfds',
//            7  => 'http://example.com/news/article/2006/07/ '.$this->uri->segment(3),
//            13 => 'http://example.com/news/article/2006/13/',
//            26 => 'http://example.com/news/article/2006/26/'
//        );

        $vars['calendar'] = $this->calendar->generate($ano, $mes, $data);
        $this->load->view('calendar_view.php', $vars);
    }

}