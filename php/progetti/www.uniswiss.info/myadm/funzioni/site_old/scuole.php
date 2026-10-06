<?php
require("../inc_config.php");


if ($_POST['func'] == "send_contratto"){
    
    include("../mail_config.php"); 

    $errore=""; 
    
    $mail->AddAddress($_POST['email']);
    $mail->Subject = "Europenacertification.it - Contratto di collaborazione";
    $mail->AddEmbeddedImage("../assets/img/european-certification-picc.png", 'logo_mail');
    $mail->addAttachment(BASE_PATH."file/contratto_collaborazione.pdf");
    $message="Gentili colleghi, <br />
              inviamo in allegato il contratto di collaborazione da firmare e reinviare a....<br /><br /><br /><br />
              <img src='cid:logo_mail'  style=''/>";
    
    $mail->Body =$message;
    if ($mail->Send()) {
        
        $arr = array('campo'=>'','errore'=>$errore);
        echo json_encode($arr);
        exit();
        
    } else{

        $errore="Attenzione, non riesco ad inviare la mail.";   
        $arr = array('campo'=>'errore_mail','errore'=>$errore);
        echo json_encode($arr);
        exit();

    }
         
}

if ($_POST['func'] == "edit_scuola"){
    
     $errore = "";
     $testo_pwd='';
     $testo_pwd_array='';
    
    if($_POST['password']!=""){
        $testo_pwd=' password = :password , ';
    }

    $db->query("UPDATE anagrafica_scuole
                SET
                nome = :nome,
                telefono = :telefono,
                piva = :piva,
                ".$testo_pwd."
                id_provincia=:id_provincia
                WHERE id='".$_POST['id_scuola']."'");
    
//    echo "UPDATE anagrafica_scuole
//                SET
//                nome = :nome,
//                telefono = :telefono,
//                piva = :piva,
//                ".$testo_pwd."
//                doc_identita = :doc_identita,
//                tessera_sanitaria = :tessera_sanitaria,
//                id_provincia=:id_provincia
//                WHERE id='" . $_POST['id_scuola'] . "'";
    $array_var=array(
            ":nome" => $_POST['nome'],
            ":piva" => $_POST['piva'],
            ":id_provincia" => $_POST['id_provincia'],
            ":telefono" => $_POST['telefono']
    );
    
    if($_POST['password']!=""){
        $array_var[':password']=$_POST['password'];
    }
    
   // print_r($aray_var);
    
        if (!$db->execute($array_var)) { 
         $errore="NON INSERITO";
        }else{
            
            $db->query("DELETE FROM corsi_scuole WHERE id_scuola='".$_POST['id_scuola']."' ");
            $db->execute();
            
            $db->query("SELECT * FROM anagrafica_corsi");
            $corsi=$db->resultset();
            $tot_corsi=$db->rowCount($corsi);
            $i=0;
            foreach ($corsi AS $corso){ $i++; 
               $index_costo='costo_'.$corso['id'];
                $db->query("INSERT INTO corsi_scuole(id_corso,id_scuola,costo)   
                                VALUES('".$corso['id']."', '".$_POST['id_scuola']."', '".str_replace(",",".",$_POST[$index_costo])."')
                           ");
                $db->execute();
            
            }
        }
    
   $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();       
}

if ($_POST['func'] == "ins_scuola"){
    
     $errore = "";
     
     
     $db->query("SELECT * FROM bag_admin WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già una scuola con questa email.');
        echo json_encode($arr);
        exit();  
         
     }
     
     $db->query("SELECT * FROM anagrafica_scuole WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già un agente con questa email.');
        echo json_encode($arr);
        exit();  
         
     }
     
     $db->query("SELECT * FROM anagrafica_agenti WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già una agente con questa email.');
        echo json_encode($arr);
        exit();  
         
     }
     
     $db->query("SELECT * FROM anagrafica_studenti WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già uno studente con questa email.');
        echo json_encode($arr);
        exit();  
         
     }
     
     $db->query(" INSERT INTO anagrafica_scuole(id_agente,nome,password,email,id_provincia,telefono,piva,attivo)   
                  VALUES('".$_SESSION['user']."',:nome,:password,:email,:id_provincia,:telefono,:piva,'s') 
                ");
        if (!$db->execute(array(
            ":nome" => $_POST['nome'],
            ":email" => $_POST['email'],
            ":password" => $_POST['password'],
            ":id_provincia" => $_POST['id_provincia'],
            ":telefono" => $_POST['telefono'],
            ":piva" => $_POST['piva']
        ))) { 
         $errore="NON INSERITO";
        }else{
            $id_scuola=$db->lastInsertId();

            $db->query("SELECT * FROM anagrafica_corsi");
            $corsi=$db->resultset();
            $tot_corsi=$db->rowCount($corsi);
            $i=0;
            foreach ($corsi AS $corso){ $i++; 
               $index_costo='costo_'.$corso['id'];
                $db->query("INSERT INTO corsi_scuole(id_corso,id_scuola,costo)   
                                VALUES('".$corso['id']."', '".$id_scuola."', '".str_replace(",",".",$_POST[$index_costo])."')
                           ");
                $db->execute();
            
            }
        }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "load_ins_form") { 
    
    
    if($_POST['id']!="0"){
        
         $db->query("SELECT * FROM anagrafica_scuole WHERE id = '".$_POST['id']."' ");
         $scuola=$db->single();    
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
                <form id="form_ins_scuola" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                    
                    
                    <input name="func" id="func" value="<?php if($_POST['id']!="0"){ echo "edit_scuola";} else { echo "ins_scuola";} ?>" type="hidden" />
                    <?php
                    if($_POST['id']!="0"){ ?>
                     <input name="id_scuola" id="id_scuola" value="<?=$_POST['id'];?>" type="hidden" />   
                    <?php } ?>
                    <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="p-anagrafica-tab" data-toggle="pill" href="#p-anagrafica" role="tab" aria-controls="p-anagrafica" aria-selected="true">Anagrafica</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="p-anagrafica" role="tabpanel" aria-labelledby="p-anagrafica-tab">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?=$scuola['nome'];?>" required>
                                    </div>
                                 </div>
                                   <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input  <?php if($_POST['id']!="0"){ echo "readonly"; } ?> type="email" class="form-control" name="email" placeholder="Email" value="<?=$scuola['email'];?>" required >
                                    </div>
                                </div>
                            </div>    
                            <div class="row mt-3">
                           
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Password"  <?php if($_POST['id']=="0"){ echo "required";} ?> >
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Piva</label>
                                        <input type="text" class="form-control" value="<?=$scuola['piva'];?>" name="piva" placeholder="Partita Iva">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                               <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Telefono</label>
                                        <input type="text" class="form-control" value="<?=$scuola['telefono'];?>" name="telefono" placeholder="Telefono">
                                    </div>
                                </div>
                                <div class="col-md-6" id="divProvincia">
                                    <?php
                                          $db->query("SELECT * FROM provincia ORDER BY nome");
                                          $province= $db->resultset();
                                    ?>
                                    <div class="form-group form-group-default">
                                        <label>Provincia</label>
                                        <select class="form-control" id="id_provincia" name="id_provincia" placeholder="Provincia" style="width:100%">
                                            <?php 
                                            foreach($province As $provincia){ ?>
                                            <option value="<?=$provincia['id'];?>"
                                             <?php  if($_POST['id']!="0" AND $scuola['id_provincia']==$provincia['id'] ){ echo "selected ";} ?>      
                                             ><?=$provincia['nome'];?></option>   
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                              <div class="row mt-3">
                               <div class="col-md-12">
                                   Aumenta i costi dei corsi del &nbsp;&nbsp;
                                   <input type="text" class="form-control" name="aumenta" id="aumenta" value=""  style="display:inline;width:70px;" > %
                                   &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success" id="aumentacosti" >APPLICA</button>
                                   
                               </div>
                              </div>    
                            <?php
                            $db->query("SELECT * FROM anagrafica_corsi");
                            
                            if($_POST['id']!="0"){
                                
                             $db->query("SELECT corsi_scuole.costo,anagrafica_corsi.nome AS nome,anagrafica_corsi.id,
                                         anagrafica_corsi.costo AS costo_anag 
                                         FROM corsi_scuole
                                         INNER JOIN anagrafica_corsi ON anagrafica_corsi.id=corsi_scuole.id_corso
                                         WHERE corsi_scuole.id_scuola='".$_POST['id']."' ");   
                            }
                            
                            $corsi=$db->resultset();
                            $tot_corsi=$db->rowCount($corsi);
                            $i=0;
                            foreach ($corsi AS $corso){ $i++; ?>
                                
                               <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Corso</label>  
                                       <input type="text" class="form-control" name="corso_<?=$corso['id'];?>" value="<?=$corso['nome'];?>"  readonly >
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Costo</label>  
                                       <input type="number" step=".01" min="<?=$corso['costo_anag'];?>" class="form-control costi_corso" name="costo_<?=$corso['id'];?>" value="<?php echo $corso['costo']; ?>"  required >
                                    </div>
                                </div>
                              </div>     
                           <?php }
                            
                            
                            
                            ?>
                            
                    
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

?>