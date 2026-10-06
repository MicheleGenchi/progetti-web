<?php
require("../inc_config.php");


if ($_POST['func'] == "scarica"){
    
      $errore = "";
      $db->query("UPDATE anagrafica_agenti
                  SET
                  ".$_POST['opzione']."=".$_POST['opzione']." + ".$_POST['valore']." 
                  WHERE id='".$_POST['id_agente']."' ");
      if (!$db->execute()) { 
         $errore="SPESE NON AGGIORNATE";
        }else{
            $db->query("INSERT INTO storico_pagamenti(data,id_agente,tipo_percentuale,valore)
                        VALUES(NOW(),'".$_POST['id_agente']."','".$_POST['opzione']."','".$_POST['valore']."')
                      ");  
            $db->execute(); 
        }  
    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "edit_agente"){
    
     $errore = "";
     $testo_pwd='';
     $testo_pwd_array='';
    
    if($_POST['password']!=""){
        $testo_pwd=' password = :password , ';
    }

    $db->query("UPDATE anagrafica_agenti
                SET
                nome = :nome,
                telefono = :telefono,
                piva = :piva,
                ".$testo_pwd."
                doc_identita = :doc_identita,
                tessera_sanitaria = :tessera_sanitaria,
                id_provincia=:id_provincia
                WHERE id='" . $_POST['id_agente'] . "'");
    
//    echo "UPDATE anagrafica_agenti
//                SET
//                nome = :nome,
//                telefono = :telefono,
//                piva = :piva,
//                ".$testo_pwd."
//                doc_identita = :doc_identita,
//                tessera_sanitaria = :tessera_sanitaria,
//                id_provincia=:id_provincia
//                WHERE id='" . $_POST['id_agente'] . "'";
    $array_var=array(
            ":nome" => $_POST['nome'],
            ":piva" => $_POST['piva'],
            ":tessera_sanitaria" => $_POST['tessera_sanitaria'],
            ":doc_identita" => $_POST['doc_identita'],
            ":id_provincia" => $_POST['id_provincia'],
            ":telefono" => $_POST['telefono']
    );
    
    if($_POST['password']!=""){
        $array_var[':password']=$_POST['password'];
    }
    
   // print_r($aray_var);
    
        if (!$db->execute($array_var)) { 
         $errore="NON INSERITO";
        }
    
   $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();       
}

if ($_POST['func'] == "ins_agente"){
    
     $errore = "";
     
     
     $db->query("SELECT * FROM bag_admin WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già un agente con questa email.');
        echo json_encode($arr);
        exit();  
         
     }
     
     $db->query("SELECT * FROM anagrafica_agenti WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già un agente con questa email.');
        echo json_encode($arr);
        exit();  
         
     }
     
     $db->query("SELECT * FROM anagrafica_scuole WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già una scuola con questa email.');
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
     
     $db->query(" INSERT INTO anagrafica_agenti(nome,password,email,id_provincia,telefono,piva,doc_identita,tessera_sanitaria,attivo)   
                  VALUES(:nome,:password,:email,:id_provincia,:telefono,:piva,:doc_identita,:tessera_sanitaria,'s') 
                ");
        if (!$db->execute(array(
            ":nome" => $_POST['nome'],
            ":email" => $_POST['email'],
            ":password" => $_POST['password'],
            ":id_provincia" => $_POST['id_provincia'],
            ":telefono" => $_POST['telefono'],
            ":piva" => $_POST['piva'],
            ":doc_identita" => $_POST['doc_identita'],
            ":tessera_sanitaria" => $_POST['tessera_sanitaria']
        ))) { 
         $errore="NON INSERITO";
        }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "load_ins_form") { 
    
    
    if($_POST['id']!="0"){
        
         $db->query("SELECT * FROM anagrafica_agenti WHERE id = '".$_POST['id']."' ");
         $agente=$db->single();    
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
                <form id="form_ins_agente" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                    
                    
                    <input name="func" id="func" value="<?php if($_POST['id']!="0"){ echo "edit_agente";} else { echo "ins_agente";} ?>" type="hidden" />
                    <?php
                    if($_POST['id']!="0"){ ?>
                     <input name="id_agente" id="id_agente" value="<?=$_POST['id'];?>" type="hidden" />   
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
                                        <label>Nome e Cognome</label>
                                        <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?=$agente['nome'];?>" required>
                                    </div>
                                 </div>
                                   <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input  <?php if($_POST['id']!="0"){ echo "readonly"; } ?> type="email" class="form-control" name="email" placeholder="Email" value="<?=$agente['email'];?>" required >
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
                                        <input type="text" class="form-control" value="<?=$agente['piva'];?>" name="piva" placeholder="Partita Iva">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                               <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Telefono</label>
                                        <input type="text" class="form-control" value="<?=$agente['telefono'];?>" name="telefono" placeholder="Telefono">
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
                                             <?php  if($_POST['id']!="0" AND $agente['id_provincia']==$provincia['id'] ){ echo "selected ";} ?>      
                                             ><?=$provincia['nome'];?></option>   
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="row mt-3">
                               <div class="col-md-6">
                                
                                    <div class="form-group ">
                                        <label>Documento Indentità</label>
                                        
                                            <?php if($_POST['id']!="0" AND $agente['doc_identita']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/agenti/<?=$agente['doc_identita'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="doc_identita§agenti"  type="file"  />
                                         <input type="hidden" id="doc_identita"  name="doc_identita" value="<?=$agente['doc_identita'];?>"/> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Tessera Sanitaria</label>
                                         <?php if($_POST['id']!="0" AND $agente['tessera_sanitaria']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/agenti/<?=$agente['tessera_sanitaria'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="tessera_sanitaria§agenti"  type="file" />
                                         <input type="hidden" id="tessera_sanitaria"  name="tessera_sanitaria" value="<?=$agente['tessera_sanitaria'];?>"/> 
                                    </div>
                                </div>

                            </div>
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