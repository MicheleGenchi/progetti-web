<?php
header('Content-type: application/json');
require_once ("../class.phpmailer.php");

if(isset($_POST['nome']) || isset($_POST['cognome']) || isset($_POST['email']) || isset($_POST['richiesta'])){
  if($_POST['nome']=="" || $_POST['cognome']=="" || $_POST['email']=="" || $_POST['richiesta']=="") {
    $response_array['status'] = 'error';
    $msg='<div class="alert alert-warning" role="alert">Errore nell\'invio dell\'email.</div>';
    $response_array['msg'] = $msg;
  }
  else
  {
    //Valori POST
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $oggetto = $_POST["oggetto"];
    $richiesta = $_POST["richiesta"];
    $email_txt = "
    <p><b>Hai ricevuto una nuova richiesta dal sito ANOI</b></p>
    <p>
    <i>Nome:</i> ". $nome ."<br>
    <i>Cognome:</i> ". $cognome ."<br>
    <i>Email:</i> ". $email ."<br>
    <i>Oggetto:</i> ". $oggetto ."<br>
    <i>Richiesta</i>: ". $richiesta ."
    </p>
    ";
    $mail = new phpmailer();
    $mail->IsHTML(true);
    $mail->From = "Europeancertification.it";
    $mail->FromName ="Europeancertification";
   $mail->AddAddress("direzione@europeancertification.it");

    $mail->Subject = "Dal sito ANOI: ".$oggetto;
    $mail->Body = $email_txt;

    if ($mail->Send()) {
      $response_array['status'] = 'success';
      $msg='<div class="alert alert-success" role="alert">La ringraziamo per la richiesta inviata, le risponderemo al più presto.</div>';
      $response_array['msg'] = $msg;
    } else{
      $response_array['status'] = 'error';
      $msg='<div class="alert alert-warning" role="alert">Errore nell\'invio dell\'email.</div>';
      $response_array['msg'] = $msg;
    }
  }
} else {
  $response_array['status'] = 'error';
  $msg='<div class="alert alert-warning" role="alert">Errore nell\'invio dell\'email.</div>';
  $response_array['msg'] = $msg;
}
echo json_encode($response_array);
?>
