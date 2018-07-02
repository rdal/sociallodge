<div class="left">
    <?php
    $motherLodge = $db->getLodgeFromUser($_SESSION['user_id']);
    $lodges = $db->lodgesFromMemberId($_SESSION['user_id']);

    $isVisitingALodge = ($motherLodge->getId() != $currentLodge->getId());

    // Prepend mother lodge
    array_unshift($lodges, $motherLodge);
    ?>
    <center>
        <select id="comboboxLodge" name="comboboxLodge" onchange="changeLodge()"><option value="0">-- Visitar Loja</option>
            <?php
            foreach($lodges as $lodge)
            {
                if($lodge->getId() != $_SESSION['user_lodge_id'])
                {
                    $name = utf8_encode($lodge->getName());
                    if(mb_strlen($name) > 26){
                        $name = mb_substr($name,0,26,'UTF-8');
                        $name .= "...";
                    }
                    echo "<option value=\"".$lodge->getId()."\">".$name."</option>";
                }
            }
            ?>
        </select>
        <br>
    </center>
    <hr>
    <div class="profile-pic-container" >
        <a href="index.php"><img src="admin/lodges_pictures/<?=$currentLodge->getLogo()?>" height="100"></a>
    </div>
    <div class="left-menu">
        <ul>
<?php
if(!$isVisitingALodge){
?>
            <li><a href="user-register.php">Editar Perfil</a></li>
            <li><a href="user-social-networks.php">Editar Redes Sociais</a></li>
<?php
}
?>
            <li><a href="documents-listing-view.php">Documentos</a></li><li><a href="admin/index.php/calendar/showCalendar/<?=$_SESSION['user_lodge_id']?>" target="_BLANK">Consultar Agenda</a></li>
<?php
            if(!$isVisitingALodge)
            {
                if ($_SESSION['worshipful_master'] || $_SESSION["senior_warden"] || $_SESSION["junior_warden"] ||
                    $_SESSION["orator"] || $_SESSION["secretary"] || $_SESSION["treasurer"] || $_SESSION["hospitable"] ||
                    $_SESSION["chancellor"]
                ) {
                    echo "<br><br>";
                }
                if ($_SESSION['worshipful_master'] || $_SESSION["senior_warden"]) {
                    //echo "<br><br>";
                    echo "<li><a href=\"admin/index.php/main/apprentice_history\" target=\"_BLANK\">1&ordf; Vigil&acirc;ncia</a></li>";
                }
                if ($_SESSION['worshipful_master'] || $_SESSION["junior_warden"]) {
                    echo "<li><a href=\"admin/index.php/main/fellowcraft_history\" target=\"_BLANK\">2&ordf; Vigil&acirc;ncia</a></li>";
                }
                if ($_SESSION['worshipful_master']) {
                    echo "<li><a href=\"admin/index.php/main/master_history\" target=\"_BLANK\">Mestres</a></li>";
                    echo "<li><a href=\"admin/index.php/main/calendar\" target=\"_BLANK\">Gerenciar Agenda</a></li>";
                    echo "<li><a href=\"admin/index.php/main/documents\" target=\"_BLANK\">Gerenciar Documentos</a></li>";
                }
                if ($_SESSION["treasurer"]) {
                    echo "<li><a href=\"admin/index.php/main/financial_entries\" target=\"_BLANK\">Lan&ccedil;amentos Financeiros</a></li>";
                }
                if ($_SESSION['worshipful_master'] || $_SESSION["treasurer"]) {
                    echo "<li><a href=\"admin/index.php/diarybook\" target=\"_BLANK\">Caixa Loja</a></li>";
                }
                if ($_SESSION["hospitable"]) {
                    echo "<li><a href=\"admin/index.php/main/beneficential_entries\" target=\"_BLANK\">Lan&ccedil;amentos da Hospitalaria</a></li>";
                }
                if ($_SESSION['worshipful_master'] || $_SESSION["hospitable"]) {
                    echo "<li><a href=\"admin/index.php/beneficentialdiarybook\" target=\"_BLANK\">Caixa Hospitalaria</a></li>";
                }
                if($_SESSION['secretary'] || $_SESSION["chancellor"]) {
                    echo "<li><a href=\"admin/index.php/main/sessions\" target = \"_BLANK\" >Gerenciar Sess&otilde;es</a ></li >";
                }
                if($_SESSION['worshipful_master'] || $_SESSION['secretary'] || $_SESSION["chancellor"]){
                    //echo "<li><a href=\"admin/index.php/presencesreport\" target=\"_BLANK\">Relat&oacute;rio de Presen&ccedil;as</a></li>";
                }


                echo "<br><br><li><a href=\"admin/index.php/login\" target=\"_BLANK\">Logar como Administrador</a></li>";
            }
            else{
                echo "<br><br>";
            }
            echo "<li><a href=\"logoff.php\">Sair</a></li></ul></div>";
?>
</div>