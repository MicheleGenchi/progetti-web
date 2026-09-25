<?php
require("../inc_config.php");



if ($_POST['func'] == "elimina_record") {
    $errore = "";
    $warning = "no";

    if ($_POST['id']) {
        $db->query("DELETE FROM ".$_POST['table']." WHERE id='".$_POST['id']."' ");
        $db->execute();
    } else {
        $errore = 'ID non valido';
    }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();
}

if ($_POST['func'] == "attiva_utente") {
    $errore = "";
    $warning = "no";
    
    $stato='s';
    if($_POST['stato_attuale']=='s') $stato='n';

    if ($_POST['id']) {
        $db->query("UPDATE ".$_POST['table']." SET attivo = '".$stato."' WHERE id='".$_POST['id']."' ");
        if (!$db->execute()) {
            $errore = "NON MODIFICATO!";
        }
    } else {
        $errore = 'ID non valido';
    }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();
}







?>