<?php

    
   $temp=explode("§",$_REQUEST['constx']);
   $id_iscrizione=$temp[1];
    
  if($id_iscrizione!='x0z1x21'){
      
    $db->query("SELECT * FROM studente_corso
                WHERE id='".$id_iscrizione."'
                AND pagato='n'
               ");
    $riga=$db->single();
    
    if($db->rowCount()>0){
        
        $db->query("SELECT  anagrafica_studenti.* 
                    FROM 
                    anagrafica_studenti 
                    WHERE anagrafica_studenti.id ='".$riga['id_studente']."' ");
        $studente=$db->single();
        
        $db->query("SELECT * FROM anagrafica_corsi WHERE id ='".$riga['id_corso']."' ");
        $corso=$db->single();
        $db->query("SELECT * FROM anagrafica_scuole WHERE id ='".$riga['id_scuola']."' ");
        $scuola=$db->single();
        
        $esiste='si'; 
        
        $db->query("UPDATE studente_corso
                    SET
                    pagato='s'
                    WHERE id='".$id_iscrizione."'
                  ");
       if($db->execute()){  
        
        
        include("mail_config.php"); 

        $mail->AddAddress($studente['email']);
        $mail->Subject = "Europenacertification.it - Iscrizione a corso";
        $mail->AddEmbeddedImage("./assets/img/european-certification-picc.png", 'logo_mail');
        $message="Gentile ".ucwords(strtolower($studente['nome'])).", <br />
                  sei stato appena iscritto al corso di <b>".$corso['nome']."</b> dalal scuola <b>".$scuola['nome']."</b>.<br /><br />
                  Riportiamo qui in basso i tuoi dati di accesso alla tua area personale<br /> dalla quale potrai accedere ai contenuti
                  di tutti i corsi ai quali sei stato iscritto.<br /><br />
                  <b>Link:</b> ".BASE_URL."<br />
                  <b>Email:</b> ".$studente['email']."<br />
                  <b>Password:</b> ".$studente['password']."<br />
                  <br /><br /><br />
                  <img src='cid:logo_mail'  style=''/>";

        $mail->Body =$message;
        $mail->Send();

    
      }    
        
    }
    
  }  

   







?>