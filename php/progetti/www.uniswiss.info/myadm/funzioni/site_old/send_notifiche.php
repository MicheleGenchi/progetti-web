<?php


//Include config
include('/var/www/vhosts/ac-websoft.it/httpdocs/forma-italia/inc_config.php');

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once("/var/www/vhosts/ac-websoft.it/httpdocs/forma-italia/phpmailer/src/PHPMailer.php");
require_once("/var/www/vhosts/ac-websoft.it/httpdocs/forma-italia/phpmailer/src/SMTP.php");
require_once("/var/www/vhosts/ac-websoft.it/httpdocs/forma-italia/phpmailer/src/Exception.php");

 //NOTIFICHE PUSH-------------------------------------------
    $query="SELECT studente_corso.*,anagrafica_corsi.durata,anagrafica_corsi.nome
            FROM studente_corso
            INNER JOIN anagrafica_corsi ON anagrafica_corsi.id=studente_corso.id_corso
            WHERE DATE_ADD(studente_corso.data, INTERVAL anagrafica_corsi.durata MONTH) > NOW()
            ORDER BY studente_corso.data";
    $db->query($query);

    $iscrizioni=$db->resultset();

    
    foreach($iscrizioni AS $iscrizione){
        
        $db->query("SELECT * FROM anagrafica_studenti WHERE id='".$iscrizione['id_studente']."' ");
        $studente=$db->single();
       
        $db->query("SELECT * FROM anagrafica_scuole WHERE id='".$iscrizione['id_scuola']."' ");
        $scuola=$db->single();
        
        
        $num_rate=$iscrizione['durata']-1;
        
        for($i=1;$i<=$num_rate;$i++){
            
            $mesi_esame=$iscrizione['durata']-$i;
            //echo date('Y-m-d', strtotime("+$i months", strtotime($iscrizione['data'])))."<br />";
            if( date('Y-m-d', strtotime("+$i months", strtotime($iscrizione['data']))) == date('Y-m-d') ){
             
                $mail_corso = new PHPMailer\PHPMailer\PHPMailer(); 
                //$mail_corso->SetLanguage("it", './php_mailer_language/');
                $mail_corso->IsSMTP(); //Specify usage of SMTP Server
                $mail_corso->Host = "smtps.aruba.it"; //SMTP+ Server address 
                $mail_corso->Port="465";  //SET the SMTP Server port              
                $mail_corso->Username = "comunicazioni@europeancertification.it"; //SMTP+ authentication: username
                $mail_corso->Password = 'Cert89.!?.G5t4'; //SMTP+ authentication: password      
                $mail_corso->SMTPAuth = true;  //Authentication required

                $mail_corso->SMTPSecure = "ssl";

                $mail_corso->IsHTML(true);
                $mail_corso->CharSet = 'UTF-8';
                //$mail_corso->SMTPDebug  = 2;
                //$mail_corso->AddEmbeddedImage("../immagini/img_email/".$_POST['immagine'], 'immagine_mail');
                //$mail_corso->AddReplyTo($_POST['email_mittente']);

                $mail_corso->From='comunicazioni@formaitalia.info';
                $mail_corso->FromName='Formaitalia.info';
                //$mail_corso->AddBCC('antonio.cito81@gmail.com');

                $mail_corso->AddAddress($studente['email']);
                $mail_corso->Subject = "Formaitalia.info - Scadenz rata";
                $mail_corso->AddEmbeddedImage("../assets/img/logoformaitaliapicc.png", 'logo_mail');
                $message="Gentile <b>".ucwords(strtolower($studente['nome']))."</b>, <br />
                          le ricordiamo gentilmente di pagare la rata per il corso 
                          <b>".strtoupper($iscrizione['nome'])."</b> della scuola <b>".strtoupper($scuola['nome'])."</b>.<br /> 
                          Con l'occasione ti ricordiamo anche che mancano circa <b>".$mesi_esame." mesi</b> all'esame finale.<br /><br />
                          Cordiali saluti.<br /><br />
                          <img src='cid:logo_mail'  style=''/>";

                $mail_corso->Body =$message;
                if ($mail_corso->Send()) { } else{ $errore="Attenzione, non riesco ad inviare la mail al corso.";   }
            
            }
           
            
        }


        
    }

    
    
?>

