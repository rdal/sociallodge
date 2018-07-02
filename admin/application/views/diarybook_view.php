<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Social Lodge - Relat&oacute;rio Caixa Loja</title>
    <link rel="stylesheet" href="<?php echo site_url('../../css/style-menu.css')?>">

    <style type='text/css'>
        body
        {
            font-family: Arial;
            font-size: 14px;
        }
        a {
            color: blue;
            text-decoration: none;
            font-size: 14px;
        }
        a:hover
        {
            text-decoration: underline;
        }
    </style>

    <style type="text/css">
        table, td{
            font:100% Arial, Helvetica, sans-serif;
        }
        table{width:100%;border-collapse:collapse;margin:1em 0;}
        th, td{text-align:left;padding:.5em;border:1px solid #000;}
        th{background: rgba(171, 166, 168, 0.97) url(images/tr_back.png) repeat-x; font-size:14px; }
        td{background:#fff; font-size:14px;}
    </style>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#chosen_period").datepicker( {
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'mm/yy',
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });
            /*$( "#end_date" ).datepicker({ dateFormat: "dd/mm/yy" }); */
        });
    </script>
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
</head>
<body>
<!-- Beginning header -->

<!-- End of header-->
<?php
$top = "20";
if(isset($_SESSION['show_menus']) && $_SESSION['show_menus']){
    $top = "120";
}
?>
<div style="position: absolute;top:<?=$top?>px;width:100%">
    <?=form_open('diarybook/diarybook_financial_report');?>
    <div class="demo">
        <p>Per&iacute;odo: <input id="chosen_period" name="chosen_period" type="text"><input type="submit" value="Ok"/></p>
    </div>
    </form>

    <?php echo $output; ?>

</div>

<?php
if(isset($dropdown_setup)) {
    $this->load->view('dependent_dropdown', $dropdown_setup);
}
?>
<!-- Beginning footer -->
<?php
/*if(!$_SESSION["worshipful_master"] && !$_SESSION["senior_warden"] && !$_SESSION["junior_warden"] &&
   !$_SESSION["orator"] && !$_SESSION["secretary"] && !$_SESSION["treasurer"] && !$_SESSION["chancellor"]) */
if(isset($_SESSION['show_menus']) && $_SESSION['show_menus'])
{
    include('menu_admin.inc');
}
?>
<!-- End of Footer -->
</body>
</html>