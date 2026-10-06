<?php
require("../inc_config.php");

//******************************** LOGIN ********************************************
if ($_POST['func'] == "login") {
    
    $errore = "";
    $_SESSION['livello']='Cliente';

    
    
    $query = "SELECT *
              FROM
              bag_admin_swiss
              WHERE `email` = :email
              AND `password` = :password";

    $db->query($query);
    $user = $db->single(array(':email' => $_POST['email'], ':password' => $_POST['password']));

    if ($db->rowCount() >0) {

        $_SESSION['email'] = $user['email'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['user'] = $user['id'];
        $_SESSION['livello'] = 'Admin';

        $arr = array('campo' => '', 'errore' => $errore, 'livello'=>$_SESSION['livello']);
        echo json_encode($arr);
        exit();
        
    } 

    
     $query = "SELECT *
               FROM
               anagrafica_studenti_swiss
               WHERE `email` = :email
               AND `password` = :password
               AND attivo='s' ";

    $db->query($query);
    $studente = $db->single(array(':email' => $_POST['email'], ':password' => $_POST['password']));

    if ($db->rowCount() >0) {
        $_SESSION['email'] = $studente['email'];
        $_SESSION['nome'] =  $studente['nome'];
        $_SESSION['user'] =  $studente['id'];
        $_SESSION['livello'] = 'Studente';
        
        $arr = array('campo' => '', 'errore' => $errore, 'livello'=>$_SESSION['livello']);
        echo json_encode($arr);
        exit(); 
    }
    
    $nome = 'not_found';
    $errore = "Dati di accesso errati, o account ancora non attivo!";

    $arr = array('campo' => '', 'errore' => $errore, 'livello'=>$_SESSION['livello']);
    echo json_encode($arr);
    exit();
}
//******************************** FINE LOGIN ********************************************
