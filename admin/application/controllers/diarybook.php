<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "basecontroller.php";

class DiaryBook extends BaseController {

	function __construct()
	{
		parent::__construct();
		
		/* Standard Libraries */
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		/* ------------------ */	
	}
	
	function _diarybook_output($output = null)
	{
		$this->load->view('diarybook_view.php',$output);
	}
	
	function index()
	{
		$this->_diarybook_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array(), 'base' => $this->config->item('base_url'), 'css' => 'style.css', 'entries' => array()));
	}	
	
	function renderDiaryBook($array, $start_date, $end_date)
	{
		/// monta tela
		$ret = "";

		$ret .= "<a href='".$this->config->item("base_url")."index.php/diarybook/printDiaryBook/".$start_date."/".$end_date."' class=' crud-action' title='Imprimir Caixa' target='_blank'><img src='".$this->config->item("base_url")."application/views/common/images/print_icon.png' alt='Imprimir Caixa' /></a>";
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

    function retrieveFinancialEntriesForPeriod($date_select_start, $date_select_end)
    {
        $array = array();
        try{
            $this->db->select("financial_entries.id, financial_entries.lodge_id, financial_entries.user_id, users.name, financial_entries.date, financial_entries.description, financial_entries.value")
                ->from("financial_entries")
                ->join('users', 'financial_entries.user_id = users.id')
                ->where("financial_entries.date >= '".$date_select_start."' and financial_entries.date <= '".$date_select_end."' and financial_entries.lodge_id='".$_SESSION['lodge_id_as_admin']."'")
                ->order_by("financial_entries.date", "asc");
            $db = $this->db->get();

            foreach($db->result() as $row):
                $array[] = $row;
            endforeach;
        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }

        return $array;
    }

    function retrieveFinancialBalanceUntilDate($date_select_end)
    {
        $array = array();
        try{
            $this->db->select("SUM(value) AS balance")
                ->from("financial_entries")
                ->where("date <= '".$date_select_end."' and financial_entries.lodge_id='".$_SESSION['lodge_id_as_admin']."'");
            $db = $this->db->get();

            foreach($db->result() as $row):
                $array[] = $row;
            endforeach;
        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }

        return $array;
    }
	
	function diarybook_financial_report()
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

        $array = $this->retrieveFinancialEntriesForPeriod($date_select_start, $date_select_end);
		
		$output['base'] = $this->config->item('base_url');
		$output['css'] = 'style.css';
		$output['output'] = $this->renderDiaryBook($array, $date_select_start, $date_select_end);
		
		$this->_diarybook_output($output);
	}


	/*
	*	@brief imprimir Fluxo de Caixa Trimestral
	*/ 
	function printDiaryBook($start_date, $end_date)
	{
        $array = $this->retrieveFinancialEntriesForPeriod($start_date, $end_date);

        // create handle for new PDF document
        $pdf = pdf_new();
        // open a file
        pdf_open_file($pdf, "");
        // start a new page (A4)
        pdf_begin_page_ext($pdf, 0, 0, "width=a4.height height=a4.width");
        // get and use a font object
        $font = pdf_load_font($pdf, "Helvetica", "host", "");
        $fontBold = pdf_load_font($pdf, "Helvetica-Bold", "host", "");
        pdf_set_parameter($pdf, "textformat", "utf8");
        pdf_setfont($pdf, $font, 14);
//        // print text
//        pdf_show_xy($pdf, "There are more things in heaven and earth, Horatio,",50, 750);
//        pdf_show_xy($pdf, "than are dreamt of in your philosophy", 50,730);
        //===============================================================
        //
        // cabecalho da tabela
        //
        pdf_setcolor($pdf, "stroke", "rgb", 0, 0, 0, 0.0);
        pdf_setcolor($pdf, "fill", "gray", 0.9, 0.0, 0.0, 0.0);
        pdf_rect($pdf, 20, 520, 800, 20);
        pdf_fill_stroke($pdf);

        //
        // Coluna Data
        //
        pdf_setcolor($pdf, "stroke", "rgb", 0, 0, 0, 0.0);
        pdf_rect($pdf, 20,520,100,20);
        pdf_stroke($pdf);
        //----
        //$p->setfont($font, 14.0);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Data",30, 525);
        //
        // Coluna Obreiro
        //
        pdf_rect($pdf, 120,520,205,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Obreiro",155, 525);
        //
        // Coluna Descrição
        //
        pdf_rect($pdf, 325,520,205,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Descrição",335, 525);
        //
        // Coluna Tipo
        //
        pdf_rect($pdf, 530,520,125,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Tipo",540, 525);
        //
        // Coluna Valor
        //
        pdf_rect($pdf, 655,520,165,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Valor",665, 525);

        //===============================================================

        $value_receita = 0;
        $value_despesa = 0;
        $cell = 0;
        foreach($array as $record)
        {

            //============ Data Handling ========================
            $datatmp = date_create($record->date);
            $datadia = date_format($datatmp, 'd/m/Y');
            //$datadia = $record->datedia;
            $valor = $record->value;
            if ($valor >= 0 )
            {
                $type = 'Receita';
                $value_receita += $record->value;
                $currVal = 'R$ ' . number_format($valor, 2, ',', '.');
            }
            else {
                $type = 'Despesa';
                $value_despesa += ((-1)*$record->value);
                $currVal = '(R$ ' . number_format(((-1)*$valor), 2, ',', '.').')';
            }
            //======================================================


            pdf_setcolor($pdf, "stroke", "rgb", 0, 0, 0, 0.0);
            pdf_setcolor($pdf, "fill", "gray", 1, 0.0, 0.0, 0.0);
            pdf_rect($pdf, 20, 500-($cell*20), 800, 20);
            pdf_fill_stroke($pdf);

            pdf_setfont($pdf, $font, 12);

            // Primeira célula
            pdf_rect($pdf, 20,500-($cell*20),100,20);
            pdf_stroke($pdf);
            pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
            pdf_show_xy($pdf, $datadia,30, 505-($cell*20));

            // Segunda célula
            $name = $record->name;
            if(mb_strlen($name) > 30){
                $name = mb_substr($name,0,30,'UTF-8');
                $name .= "...";
            }
            pdf_rect($pdf, 120,500-($cell*20),205,20);
            pdf_stroke($pdf);
            pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
            pdf_show_xy($pdf, $name,130, 505-($cell*20));

            // Terceira célula
            $description = strip_tags($record->description);
            if(mb_strlen($description) > 30){
                $description = mb_substr($description,0,30,'UTF-8');
                $description .= "...";
            }
            pdf_rect($pdf, 325,500-($cell*20),205,20);
            pdf_stroke($pdf);
            pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
            pdf_show_xy($pdf, $description, 335, 505-($cell*20));

//            $type = "";
//            $valueNumber = $record->value;
//            $currVal = "";
//            if ( $valueNumber >= 0 )
//            {
//                $type = 'Receita';
//                //$value_receita += $record->value;
//                //pdf_setColor($pdf, "fill", "rgb",0, 0, 1);
//                $currVal = 'R$ ' . number_format($valueNumber, 2, ',', '.');
//            }
//            else {
//                $type = 'Despesa';
//                //$value_despesa += ((-1)*$record->value);
//                //pdf_setColor($pdf, "fill", "rgb",1, 0, 0);
//                $currVal = '(R$ ' . number_format($valueNumber, 2, ',', '.').')';
//            }

            // Quarta célula
            //$type = "Receita";
            if(mb_strlen($type) > 17){
                $type = mb_substr($type,0,17,'UTF-8');
                $type .= "...";
            }
            pdf_rect($pdf, 530,500-($cell*20),125,20);
            pdf_stroke($pdf);
            pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
            pdf_show_xy($pdf, $type ,540, 505-($cell*20));

            // Quinta célula
            //$value = "R$ 3.243,23";$valor = $record->value;
            if(mb_strlen($currVal) > 23){
                $currVal = mb_substr($currVal,0,23,'UTF-8');
                $currVal .= "...";
            }
            pdf_rect($pdf, 655,500-($cell*20),165,20);
            pdf_stroke($pdf);
            if ( $valor >= 0 ){
                pdf_setcolor($pdf, "fill", "rgb", 0, 0, 1, 0.0);
            }
            else{
                pdf_setcolor($pdf, "fill", "rgb", 1, 0, 0, 0.0);
            }
            pdf_show_xy($pdf, $currVal, 665, 505-($cell*20));

            $cell++;
        }
        //===============================================================

        // --- Receitas ---
        pdf_setcolor($pdf, "stroke", "rgb", 0, 0, 0, 0.0);
        pdf_setcolor($pdf, "fill", "gray", 0.9, 0.0, 0.0, 0.0);
        pdf_rect($pdf, 20, 500-($cell*20), 800, 20);
        pdf_fill_stroke($pdf);

        pdf_setfont($pdf, $fontBold, 12);

        // Primeira célula
        pdf_rect($pdf, 20,500-($cell*20),100,20);
        pdf_stroke($pdf);

        // Segunda célula
        pdf_rect($pdf, 120,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Terceira célula
        pdf_rect($pdf, 325,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Quarta célula
        pdf_rect($pdf, 530,500-($cell*20),125,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Receitas" ,540, 505-($cell*20));

        // Quinta célula
        //$value = "R$ 3.243,23";$valor = $record->value;
        if(mb_strlen($value_receita) > 23){
            $value_receita = mb_substr($value_receita,0,23,'UTF-8');
            $value_receita .= "...";
        }
        pdf_rect($pdf, 655,500-($cell*20),165,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "rgb", 0, 0, 1, 0.0);
        pdf_show_xy($pdf, 'R$ ' . number_format($value_receita, 2, ',', '.'), 665, 505-($cell*20));

        $cell++;

        //--- Despesas ---
        pdf_setcolor($pdf, "stroke", "rgb", 0, 0, 0, 0.0);
        pdf_setcolor($pdf, "fill", "gray", 0.9, 0.0, 0.0, 0.0);
        pdf_rect($pdf, 20, 500-($cell*20), 800, 20);
        pdf_fill_stroke($pdf);

        pdf_setfont($pdf, $fontBold, 12);

        // Primeira célula
        pdf_rect($pdf, 20,500-($cell*20),100,20);
        pdf_stroke($pdf);

        // Segunda célula
        pdf_rect($pdf, 120,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Terceira célula
        pdf_rect($pdf, 325,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Quarta célula
        pdf_rect($pdf, 530,500-($cell*20),125,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Despesas" ,540, 505-($cell*20));

        // Quinta célula
        //$value = "R$ 3.243,23";$valor = $record->value;
        if(mb_strlen($value_despesa) > 23){
            $value_despesa = mb_substr($value_despesa,0,23,'UTF-8');
            $value_despesa .= "...";
        }
        pdf_rect($pdf, 655,500-($cell*20),165,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "rgb", 1, 0, 0, 0.0);
        pdf_show_xy($pdf, '(R$ ' . number_format($value_despesa, 2, ',', '.').')', 665, 505-($cell*20));

        $cell++;

        //--- Saldo Atual ---
        pdf_setcolor($pdf, "stroke", "rgb", 0, 0, 0, 0.0);
        pdf_setcolor($pdf, "fill", "gray", 0.9, 0.0, 0.0, 0.0);
        pdf_rect($pdf, 20, 500-($cell*20), 800, 20);
        pdf_fill_stroke($pdf);

        pdf_setfont($pdf, $fontBold, 12);

        // Primeira célula
        pdf_rect($pdf, 20,500-($cell*20),100,20);
        pdf_stroke($pdf);

        // Segunda célula
        pdf_rect($pdf, 120,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Terceira célula
        pdf_rect($pdf, 325,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Quarta célula
        pdf_rect($pdf, 530,500-($cell*20),125,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Saldo Atual" ,540, 505-($cell*20));

        // Quinta célula
        //$value = "R$ 3.243,23";$valor = $record->value;
        if(mb_strlen($value_despesa) > 23){
            $value_despesa = mb_substr($value_despesa,0,23,'UTF-8');
            $value_despesa .= "...";
        }
        pdf_rect($pdf, 655,500-($cell*20),165,20);
        pdf_stroke($pdf);
        $saldoAtualValue = "";
        $saldoAtual = $value_receita - $value_despesa;
        $saldoAtual = floatval($saldoAtual);
        if($saldoAtual >= 0){
            $saldoAtualValue = 'R$ ' . number_format($saldoAtual, 2, ',', '.');
            pdf_setcolor($pdf, "fill", "rgb", 0, 0, 1, 0.0);
        }
        else{
            $saldoAtualValue = '(R$ ' . number_format($saldoAtual, 2, ',', '.').')';
            pdf_setcolor($pdf, "fill", "rgb", 1, 0, 0, 0.0);
        }

        pdf_show_xy($pdf, $saldoAtualValue, 665, 505-($cell*20));

        $cell++;

        //--- Saldo Anterior ---
        $piecesLastMonthStartDate = explode("-", $start_date);
        $lastMonth = mktime(0, 0, 0, $piecesLastMonthStartDate[1]-1, $piecesLastMonthStartDate[2], $piecesLastMonthStartDate[0]);
        $previous_period = date("Y-m", $lastMonth);

        // Always consider the begining of the month
        $date_select_start_last_month = $previous_period."-01";
        $date_select_end_last_month = date("Y-m-t", strtotime($date_select_start_last_month));

        $saldoAnterior = $this->retrieveFinancialBalanceUntilDate($date_select_end_last_month);
        $saldoAnterior = floatval($saldoAnterior[0]->balance);

        pdf_setcolor($pdf, "stroke", "rgb", 0, 0, 0, 0.0);
        pdf_setcolor($pdf, "fill", "gray", 0.9, 0.0, 0.0, 0.0);
        pdf_rect($pdf, 20, 500-($cell*20), 800, 20);
        pdf_fill_stroke($pdf);

        pdf_setfont($pdf, $fontBold, 12);

        // Primeira célula
        pdf_rect($pdf, 20,500-($cell*20),100,20);
        pdf_stroke($pdf);

        // Segunda célula
        pdf_rect($pdf, 120,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Terceira célula
        pdf_rect($pdf, 325,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Quarta célula
        pdf_rect($pdf, 530,500-($cell*20),125,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Saldo Anterior" ,540, 505-($cell*20));

        // Quinta célula
        //$value = "R$ 3.243,23";$valor = $record->value;
        if(mb_strlen($value_despesa) > 23){
            $value_despesa = mb_substr($value_despesa,0,23,'UTF-8');
            $value_despesa .= "...";
        }
        pdf_rect($pdf, 655,500-($cell*20),165,20);
        pdf_stroke($pdf);

        if($saldoAnterior >= 0){
            pdf_setcolor($pdf, "fill", "rgb", 0, 0, 1, 0.0);
            $saldoAnteriorValue = 'R$ ' . number_format($saldoAnterior, 2, ',', '.');
        }
        else{
            pdf_setcolor($pdf, "fill", "rgb", 1, 0, 0, 0.0);
            $saldoAnteriorValue = '(R$ ' . number_format($saldoAnterior, 2, ',', '.').')';
        }

        pdf_show_xy($pdf, $saldoAnteriorValue, 665, 505-($cell*20));

        $cell++;

        //--- Saldo a transportar ---
        pdf_setcolor($pdf, "stroke", "rgb", 0, 0, 0, 0.0);
        pdf_setcolor($pdf, "fill", "gray", 0.9, 0.0, 0.0, 0.0);
        pdf_rect($pdf, 20, 500-($cell*20), 800, 20);
        pdf_fill_stroke($pdf);

        pdf_setfont($pdf, $fontBold, 12);

        // Primeira célula
        pdf_rect($pdf, 20,500-($cell*20),100,20);
        pdf_stroke($pdf);

        // Segunda célula
        pdf_rect($pdf, 120,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Terceira célula
        pdf_rect($pdf, 325,500-($cell*20),205,20);
        pdf_stroke($pdf);

        // Quarta célula
        pdf_rect($pdf, 530,500-($cell*20),125,20);
        pdf_stroke($pdf);
        pdf_setcolor($pdf, "fill", "gray", 0, 0.0, 0.0, 0.0);
        pdf_show_xy($pdf, "Saldo a Transportar" ,540, 505-($cell*20));

        // Quinta célula
        //$value = "R$ 3.243,23";$valor = $record->value;
        if(mb_strlen($value_despesa) > 23){
            $value_despesa = mb_substr($value_despesa,0,23,'UTF-8');
            $value_despesa .= "...";
        }
        pdf_rect($pdf, 655,500-($cell*20),165,20);
        pdf_stroke($pdf);

        $saldoSTransportar = $saldoAtual + $saldoAnterior;
        if($saldoSTransportar >= 0){
            pdf_setcolor($pdf, "fill", "rgb", 0, 0, 1, 0.0);
            $saldoSTransportarValue = 'R$ ' . number_format($saldoSTransportar, 2, ',', '.');
        }
        else{
            pdf_setcolor($pdf, "fill", "rgb", 1, 0, 0, 0.0);
            $saldoSTransportarValue = '(R$ ' . number_format($saldoSTransportar, 2, ',', '.').')';
        }

        pdf_show_xy($pdf, $saldoSTransportarValue, 665, 505-($cell*20));

        $cell++;

        //===============================================================
        // end page
        pdf_end_page($pdf);
        // close and save file
        pdf_close($pdf);

        $buf = pdf_get_buffer($pdf);
        $len = strlen($buf);

        header("Content-type: application/pdf");
        header("Content-Length: $len");
        header("Content-Disposition: inline; filename=foo.pdf");
        echo $buf;

        pdf_delete($pdf);
    }

	
	
}
