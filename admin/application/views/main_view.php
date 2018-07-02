<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Social Lodge - Gerenciador Administrativo</title>
    <link rel="stylesheet" href="<?php echo site_url('../../css/style-menu.css')?>">

    <?php
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />

    <?php endforeach; ?>
    <?php foreach($js_files as $file): ?>

        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <script src='<?php echo site_url('../../js/jquery.maskedinput.js')?>' type="text/javascript"></script>
    <script src='<?php echo site_url('../assets/grocery_crud/js/jquery_plugins/config/jquery.datepicker.config.js')?>' type="text/javascript"></script>

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

    <script>
        $(document).ready(function()
        {
            var changeYear = $( ".datepicker-input" ).datepicker( "option", "changeYear" );
            $( ".datepicker-input" ).datepicker( "option", "yearRange", "-100:+5" );

            <!-- Select all Masonic Profile items, and removes second column -->
            $( "#masonic_profiles_input_box" ).find( "a.add-all" ).click();
            $( "#masonic_profiles_input_box" ).find( "div.available" ).empty();
            $( "#masonic_profiles_input_box" ).find( "div.ui-multiselect.ui-helper-clearfix.ui-widget" ).width($( "#masonic_profiles_input_box" ).find( "div.selected" ).width());
            $( "#masonic_profiles_input_box" ).find( "a.remove-all" ).empty();
            $( "#masonic_profiles_input_box" ).find( "span.ui-corner-all.ui-icon.ui-icon-minus" ).remove();

            $( "#matrix_profiles_input_box" ).find( "a.add-all" ).click();
            $( "#matrix_profiles_input_box" ).find( "div.available" ).empty();
            $( "#matrix_profiles_input_box" ).find( "div.ui-multiselect.ui-helper-clearfix.ui-widget" ).width($( "#matrix_profiles_input_box" ).find( "div.selected" ).width());
            $( "#matrix_profiles_input_box" ).find( "a.remove-all" ).empty();
            $( "#matrix_profiles_input_box" ).find( "span.ui-corner-all.ui-icon.ui-icon-minus" ).remove();

            $("#field-lodge_role_management_01").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_02").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_03").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_04").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_05").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_06").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_07").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_08").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_09").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_10").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_11").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-lodge_role_management_12").mask("9999/9999",{placeholder:"yyyy/yyyy"});

            $("#field-governing_body_role_management_01").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-governing_body_role_management_02").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-governing_body_role_management_03").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-governing_body_role_management_04").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-governing_body_role_management_05").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-governing_body_role_management_06").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-governing_body_role_management_07").mask("9999/9999",{placeholder:"yyyy/yyyy"});

            $("#field-another_role_in_another_degree_management_01").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-another_role_in_another_degree_management_02").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-another_role_in_another_degree_management_03").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-another_role_in_another_degree_management_04").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-another_role_in_another_degree_management_05").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-another_role_in_another_degree_management_06").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-another_role_in_another_degree_management_07").mask("9999/9999",{placeholder:"yyyy/yyyy"});

            $("#field-social_entity_role_management_01").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-social_entity_role_management_02").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-social_entity_role_management_03").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-social_entity_role_management_04").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-social_entity_role_management_05").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-social_entity_role_management_06").mask("9999/9999",{placeholder:"yyyy/yyyy"});
            $("#field-social_entity_role_management_07").mask("9999/9999",{placeholder:"yyyy/yyyy"});
        });
    </script>
</head>
<body>
<!-- Beginning header -->

<!-- End of header-->
<?php
$top = "20";
if(isset($_SESSION['show_menus']) && $_SESSION['show_menus']){
    $top = "120";
}
echo "<div style=\"position: absolute;top:".$top."px;width:100%\">";
echo $output;
echo "</div>";

?>

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