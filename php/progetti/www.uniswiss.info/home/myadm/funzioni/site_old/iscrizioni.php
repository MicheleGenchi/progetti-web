<?php
require("../inc_config.php");

if ($_POST['func'] == "edit_iscrizione"){
    
     $errore = "";
    

    $db->query("UPDATE studente_corso
                SET
                num_rate_pagate=:num_rate_pagate,
                contratto_firmato=:contratto_firmato
                WHERE id='" . $_POST['id_iscrizione'] . "'
                ");

    $array_var=array(
            ":num_rate_pagate" => $_POST['num_rate_pagate'],
            ":contratto_firmato" => $_POST['contratto_firmato']     
    );

        if (!$db->execute($array_var)) { 
         $errore="NON INSERITO";
        }
    
   $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();       
}

if ($_POST['func'] == "ins_iscrizione"){
    
     $errore = "";
     
     
     $db->query("SELECT * FROM studente_corso WHERE id_studente='".$_POST['id_studente']."' AND id_corso='".$_POST['id_corso']."' ");
     $db->single();
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione questo studente è già iscritto a questo corso.');
        echo json_encode($arr);
        exit();  
         
     }
     
     $db->query("SELECT costo FROM corsi_scuole WHERE id_scuola='".$_SESSION['user']."' AND id_corso='".$_POST['id_corso']."' ");
     $corso=$db->single();
 
     $codice_univoco='EC-4'.$_POST['id_studente']."3".$_POST['id_corso'].$_SESSION['user']."2"; 

     $acconto=str_replace(",",".",$_POST['acconto']);
     
     $db->query(" INSERT INTO studente_corso(data,id_studente,id_corso,id_scuola,num_rate,codice_univoco_certificato,sblocca_attestato,acconto)   
                  VALUES(NOW(),'".$_POST['id_studente']."','".$_POST['id_corso']."','".$_SESSION['user']."','".$_POST['num_rate']."','".$codice_univoco."','n','".$acconto."') 
                ");
     if(!$db->execute()) { 
         $errore="NON INSERITO";
     }else{
    
            include("../mail_config.php"); 

            $db->query("SELECT * FROM anagrafica_studenti WHERE id='".$_POST['id_studente']."' ");
            $studente=$db->single();
            $db->query("SELECT * FROM anagrafica_corsi WHERE id='".$_POST['id_corso']."' ");
            $corso=$db->single();

            //mail allo studente  
            $mail->AddAddress($studente['email']);
            $mail->Subject = "Formaitalia.info - Benvenuto fra noi";
            $mail->AddEmbeddedImage("../assets/img/logoformaitaliapicc.png", 'logo_mail');
            $message="Gentile <b>".ucwords(strtolower($studente['nome']))."</b>, <br />
                      sei stato correttamente iscritto al corso di <b>".strtoupper($corso['nome'])."</b>,
                      dalla scuola  <b>".$_SESSION['nome']."</b>.<br />
                      Ti ricordiamo di pagare la prima del corso.<br />
                      Restiamo a tua disposizione per qualsiasi tipo di necessità.<br /><br /><br /><br />
                      <img src='cid:logo_mail'  style=''/>";

            $mail->Body =$message;
            if ($mail->Send()) { } else{ $errore="Attenzione, non riesco ad inviare la mail di benvenuto.";   }   
            
            
            //mail alla mail del corso interessato
            
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

            $mail_corso->From='comunicazioni@europeancertification.it';
            $mail_corso->FromName='Europeancertification.it';
            //$mail_corso->AddBCC('antonio.cito81@gmail.com');
            
            $mail_corso->AddAddress($corso['email']);
            $mail_corso->Subject = "Formaitalia.info - Nuova iscrizione";
            $mail_corso->AddEmbeddedImage("../assets/img/logoformaitaliapicc.png", 'logo_mail');
            $message="Lo studente <b>".ucwords(strtolower($studente['nome']))."</b>, <br />
                      avente email <b>".strtolower($studente['email'])."</b> e telefono <b>".strtolower($studente['telefono'])."</b><br />
                      è stato correttamente iscritto al corso di <b>".strtoupper($corso['nome'])."</b>,
                      dalla scuola  <b>".$_SESSION['nome']."</b>.<br /><br /> 
                      <img src='cid:logo_mail'  style=''/>";

            $mail_corso->Body =$message;
            if ($mail_corso->Send()) { } else{ $errore="Attenzione, non riesco ad inviare la mail al corso.";   }   
            
            
            
            
        }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "load_ins_form") { 

     if($_POST['id']!="0"){
        
         $db->query("SELECT * FROM studente_corso WHERE id = '".$_POST['id']."' ");
         $iscrizione=$db->single();    
    }
    ?>
 <link href="<?=BASE_URL;?>fileinput/css/fileinput_orig.css" media="all" rel="stylesheet" type="text/css" />
    <style>
     .select2-container--bootstrap .select2-selection--single {
        height: 31px;
        line-height: 1.42857143;
        padding: .3rem 1rem;
    }   
    .modal-body .btn {
        padding: 5px 7px;

    }
    .modal-body .input-group-btn{
        margin-top:6px;
    }

    </style>
    <div class="row">
    <div class="col-md-12">
        <div class="card card-with-nav">
            <div class="card-body">
                <form id="form_ins_iscrizione" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                    
                    
                    <input name="func" id="func" value="<?php if($_POST['id']!="0"){ echo "edit_iscrizione";} else { echo "ins_iscrizione";} ?>" type="hidden" />
                    <?php
                    if($_POST['id']!="0"){ ?>
                     <input name="id_iscrizione" id="id_iscrizione" value="<?=$_POST['id'];?>" type="hidden" />   
                    <?php } ?>
                    <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="p-anagrafica-tab" data-toggle="pill" href="#p-anagrafica" role="tab" aria-controls="p-anagrafica" aria-selected="true">Anagrafica</a>
                        </li>
                    </ul>
                   
                    <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="p-anagrafica" role="tabpanel" aria-labelledby="p-anagrafica-tab">
                       <?php   if($_POST['id']=="0"){ ?>    
                            <div class="row mt-3">
                                 <div class="col-md-6" id="divProvincia">
                                    <?php
                                          $db->query("SELECT * FROM anagrafica_studenti WHERE id_scuola='".$_SESSION['user']."' AND attivo='s' ORDER BY nome");
                                          $studenti= $db->resultset();
                                    ?>
                                    <div class="form-group form-group-default">
                                        <label>Studente</label>
                                        <select class="form-control" id="id_studente" name="id_studente"  style="width:100%">
                                            <?php 
                                            foreach($studenti As $studente){ ?>
                                            <option value="<?=$studente['id'];?>"><?=$studente['nome'];?></option>   
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="divProvincia">
                                    <?php
                                          $db->query("SELECT * FROM anagrafica_corsi WHERE  attivo='s' ORDER BY nome");
                                          $corsi= $db->resultset();
                                    ?>
                                    <div class="form-group form-group-default">
                                        <label>Corsi</label>
                                        <select class="form-control" id="id_corso" name="id_corso"  style="width:100%">
                                            <?php 
                                            foreach($corsi AS $corso){ ?>
                                            <option value="<?=$corso['id'];?>"><?=$corso['nome'];?></option>   
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>  
                            <div class="row mt-3">
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Acconto</label>
                                        <input type="text" class="form-control" name="acconto" placeholder="Acconto"  value="<?=$iscrizione['acconto'];?>" >
                                    </div>
                                </div>
                                   <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Numero Rate</label>
                                        <input type="number" class="form-control" name="num_rate" placeholder="Numero rate" required value="<?=$iscrizione['num_rate'];?>" >
                                    </div>
                                </div>
                             </div> 
                        <?php } else { 
                                if($_SESSION['livello']=="Admin"){ ?>        
                                   <div class="col-md-6">
                                     <div class="form-group form-group-default">
                                        <label>Numero Rate Pagate</label>
                                        <input type="number" class="form-control" name="num_rate_pagate" placeholder="Numero rate pagate" required value="<?=$iscrizione['num_rate_pagate'];?>" >
                                     </div>
                                    </div>
                                <?php } else { ?> 
                                  <input type="hidden" value="<?=$iscrizione['num_rate_pagate'];?>" name="num_rate_pagate" />
                                <?php } ?> 
                              <div class="row mt-3">
                                
                                 
                                  <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Contratto firmato</label>
                                            <?php if($_POST['id']!="0" AND $iscrizione['contratto_firmato']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/iscrizioni/<?=$iscrizione['contratto_firmato'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="contratto_firmato§iscrizioni"  type="file"  />
                                         <input type="hidden" id="contratto_firmato"  name="contratto_firmato" value="<?=$iscrizione['contratto_firmato'];?>"/> 
                                    </div>
                                </div>
                             </div> 
                            
                        <?php }?>    
                            <div class="row mt-3">
                                <div class="col-md-10"></div>
                                <div class="col-md-2"><button  type="submit" class="btn btn-success" id="salvaProButton" name="salvaProButton" style="float:right;padding:8px 28px;" >SALVA</button>
                                </div>
                            </div>
                        </div>
                    
                  
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
    
<?php  
}

if($_POST['function']=="elimina_file"){

         //Cancello file
         $db->query("SELECT percorso FROM bonifici_iscrizioni
                     WHERE id= '".$_POST['id_file']."' ");
         $nomefile=$db->single();

         $db->query("DELETE FROM bonifici_iscrizioni
                     WHERE id= '".$_POST['id_file']."' ");
         $db->execute();

         unlink(BASE_PATH."file/bonifici/".$nomefile['percorso']);

 }

if ($_POST['func'] == "load_bonifici") { 

    ?>

    <link href="<?=BASE_URL;?>fileinput/css/fileinput_orig.css" media="all" rel="stylesheet" type="text/css" />
    <style>
     .select2-container--bootstrap .select2-selection--single {
        height: 31px;
        line-height: 1.42857143;
        padding: .3rem 1rem;
    }   
    .modal-body .btn {
        padding: 5px 7px;

    }
    .modal-body .input-group-btn{
        margin-top:6px;
    }

    </style>
    
    <div class="row">
        <div class="col-md-12">
                <div class="card card-with-nav">
                        <div class="card-header">
                                <div class="row row-nav-line">
                                          <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                                    
                                            <li class="nav-item">
                                                <a class="nav-link active" id="p-file-tab" data-toggle="pill" href="#p-file" role="tab" aria-controls="p-file" aria-selected="true">Bonifici</a>
                                            </li>
                                       
                                        </ul>
                                </div>
                        </div>
                        <div class="card-body">
                             <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                        
                                    <div class="tab-pane fade show active" id="p-file" role="tabpanel" aria-labelledby="p-file-tab">
                                     <div class="row mt-3">
                                            <span style='font-size:20px'>BONIFICI CARICATI</span> <br />
                                              <div class="col-md-12">
                                                  <div class="row">
                                               <?php
                                                $db->query("SELECT * FROM bonifici_iscrizioni WHERE id_iscrizione= '".$_POST['id']."' ");          
                                                $files=$db->resultset();
                                                foreach ($files AS $file){ ?>
                                                  <div class="col-md-2" id='div-file-<?=$file['id'];?>' style="margin-right:4px;height:120px;border:solid 1px #dedede;padding:5px;">  
                                                          <div style='font-size:15px;color:#158bee;height:23px;'> <b><?=ucfirst(strtolower($file['nome']));?></b></div> 
                                                        <?php if($_SESSION['livello']=='Admin'){ ?>  
                                                          <div style='float:right;width:20px;'>
                                                              <i class="fas fa-trash elimina_file" title='Elimina' data-id='<?=$file['id'];?>' style="color:red;cursor:pointer;"></i>
                                                          </div><br /> 
                                                        <?php } ?>
                                                          <br />
                                                          <a href='<?=BASE_URL;?>file/bonifici/<?=$file['percorso'];?>' style="margin-left:25px;" target="_blank"> <i class="fas fa-file-alt" style="font-size:45px;"></i>  </a>
                                                  </div>    
                                                    
                                                <?php } ?>
                                               
                                               
                                                  </div>
                                              </div>
                                        </div>
                                        <br /> 
                                     <?php if($_SESSION['livello']=='Admin'){ ?>      
                                        <div class="row mt-3">
                                              <div class="col-md-12" style="padding:0px;">
                                                <div class="form-group ">
                                                <label>CARICA BONIFICO</label>
                                                <input class="loadfile" accept="*" name="file§<?=$_POST['id'];?>"  type="file"  multiple/>
                                                </div>
                                              </div>
                                        </div> 
                                     <?php } ?>

                                    </div>
                                    


                                </div>
                        </div>
                </div>
        </div>
</div>

    
<?php  
}

?>