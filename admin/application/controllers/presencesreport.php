<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: rdal
 * Date: 28/5/16
 * Time: 18:51
 */

require_once "basecontroller.php";

class PresencesReport extends BaseController {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        /* ------------------ */
    }

    function _presencesreport_output($output = null)
    {
        $this->load->view('presencesreport_view.php',$output);
    }

    function index()
    {
        $this->_presencesreport_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array(), 'base' => $this->config->item('base_url'), 'css' => 'style.css', 'entries' => array()));
    }

    function renderPresencesReport($array, $start_date, $end_date)
    {
        /// monta tela
        $ret = "";

        $ret .= '<table cellspacing="0" cellpadding="0">';
        $ret .= '
		<tr>
			<th>Data</th>
			<th>Obreiro</th>
			<th>Descrição</th>
			<th>Tipo</th>
			<th>Valor</th>
		<tr/>
		';

        $value_receita = 0;
        $value_despesa = 0;

        foreach( $array as $data )
        {

            $datatmp = date_create($data->date);
            $datadia = date_format($datatmp, 'd/m/Y');
            //$datadia = $data->datedia;
            $valor = $data->value;
            if ( $data->value >= 0 )
            {
                $tipo = 'Receita';
                $value_receita += $data->value;
                $fontColor = "blue";
                $currVal = 'R$ ' . number_format($valor, 2, ',', '.');
            }
            else {
                $tipo = 'Despesa';
                $value_despesa += ((-1)*$data->value);
                $fontColor = "red";
                $currVal = '(R$ ' . number_format(((-1)*$valor), 2, ',', '.').')';
            }

            $ret .= '
					<tr>
						<td>'.$datadia.'</td>
						<td>'.$data->name.'</td>
						<td>'.$data->description.'</td>
						<td>'.$tipo.'</td>
						<td><font color="'.$fontColor.'">'.$currVal.'</font></td>
					<tr/>
					';
        }

        $saldoAtual = $value_receita - $value_despesa;
        $saldoAtual = floatval($saldoAtual);
        if($saldoAtual >= 0){
            $saldoAtualFontColor = 'blue';
            $saldoAtualValue = 'R$ ' . number_format($saldoAtual, 2, ',', '.');
        }
        else{
            $saldoAtualFontColor = 'red';
            $saldoAtualValue = '(R$ ' . number_format($saldoAtual, 2, ',', '.').')';
        }

        $ret .= '
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Receitas</th>
                    <th><font color="blue">R$ ' . number_format($value_receita, 2, ',', '.').'</font></th>
                <tr/>
                ';

        $ret .= '
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Despesas</th>
                    <th><font color="red">(R$ ' . number_format($value_despesa, 2, ',', '.').')</font></th>
                <tr/>
                ';

        $ret .= '
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Saldo Atual</th>
                    <th><font color="'.$saldoAtualFontColor.'">'.$saldoAtualValue.'</font></th>
                <tr/>
                ';

        $piecesLastMonthStartDate = explode("-", $start_date);
        $lastMonth = mktime(0, 0, 0, $piecesLastMonthStartDate[1]-1, $piecesLastMonthStartDate[2], $piecesLastMonthStartDate[0]);
        $previous_period = date("Y-m", $lastMonth);

        // Always consider the begining of the month
        $date_select_start_last_month = $previous_period."-01";
        $date_select_end_last_month = date("Y-m-t", strtotime($date_select_start_last_month));

//        $lastMonthArray = $this->retrieveFinancialEntriesForPeriod($date_select_start_last_month, $date_select_end_last_month);
//        $value_receita_last_month = 0;
//        $value_despesa_last_month = 0;
//        foreach( $lastMonthArray as $lastMonthData )
//        {
//            if ( $lastMonthData->value >= 0 )
//            {
//                $value_receita_last_month += $lastMonthData->value;
//            }
//            else {
//                $value_despesa_last_month += $lastMonthData->value;
//            }
//        }
//        $saldoAnterior = $value_receita_last_month - $value_despesa_last_month;
        $saldoAnterior = $this->retrieveFinancialBalanceUntilDate($date_select_end_last_month);
        $saldoAnterior = floatval($saldoAnterior[0]->balance);
        if($saldoAnterior >= 0){
            $saldoAnteriorFontColor = 'blue';
            $saldoAnteriorValue = 'R$ ' . number_format($saldoAnterior, 2, ',', '.');
        }
        else{
            $saldoAnteriorFontColor = 'red';
            $saldoAnteriorValue = '(R$ ' . number_format($saldoAnterior, 2, ',', '.').')';
        }

        $ret .= '
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Saldo Anterior</th>
                    <th><font color="'.$saldoAnteriorFontColor.'">'.$saldoAnteriorValue.'</font></th>
                <tr/>
                ';
//var_duMP($saldoAtual);var_dump($saldoAnterior);die();
        $saldoSTransportar = $saldoAtual + $saldoAnterior;
        if($saldoSTransportar >= 0){
            $saldoSTransportarFontColor = 'blue';
            $saldoSTransportarValue = 'R$ ' . number_format($saldoSTransportar, 2, ',', '.');
        }
        else{
            $saldoSTransportarFontColor = 'red';
            $saldoSTransportarValue = '(R$ ' . number_format($saldoSTransportar, 2, ',', '.').')';
        }
        $ret .= '
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Saldo a Transportar/Total</th>
                    <th><font color="'.$saldoSTransportarFontColor.'">'.$saldoSTransportarValue.'</font></th>
                <tr/>
                ';
        $ret .= '</table>';
        return $ret;
    }

    function retrievePresencesForPeriod($date_select_start, $date_select_end)
    {
        $array = array();
//        try{
//            $this->db->select("financial_entries.id, financial_entries.lodge_id, financial_entries.user_id, users.name, financial_entries.date, financial_entries.description, financial_entries.value")
//                ->from("financial_entries")
//                ->join('users', 'financial_entries.user_id = users.id')
//                ->where("financial_entries.date >= '".$date_select_start."' and financial_entries.date <= '".$date_select_end."' and financial_entries.lodge_id='".$_SESSION['lodge_id_as_admin']."'")
//                ->order_by("financial_entries.date", "asc");
//            $db = $this->db->get();
//
//            foreach($db->result() as $row):
//                $array[] = $row;
//            endforeach;
//        }catch(Exception $e){
//            show_error($e->getMessage().' --- '.$e->getTraceAsString());
//        }

        return $array;
    }

    function presencesreport_output()
    {
        $chosen_period = $this->input->post("chosen_period",true);
        if( $chosen_period == "" )
        {
            $chosen_period = date("m/Y");
        }

        $pieces_chosen = explode("/", $chosen_period);

        // Always consider the begining of the month
        $date_select_start = $pieces_chosen[1]."-".$pieces_chosen[0]."-01";
        $date_select_end = date("Y-m-t", strtotime($date_select_start));

        $array = $this->retrievePresencesForPeriod($date_select_start, $date_select_end);

        $output['base'] = $this->config->item('base_url');
        $output['css'] = 'style.css';
        $output['output'] = $this->renderPresencesReport($array, $date_select_start, $date_select_end);

        $this->_presencesreport_output($output);
    }

}
