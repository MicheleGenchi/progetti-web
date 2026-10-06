<?php
require("../inc_config.php");


if ($_POST['func'] == "edit_studente"){
    
     $errore = "";
     $testo_pwd='';
     $testo_pwd_array='';
    
    if($_POST['password']!=""){
        $testo_pwd=' password = :password , ';
    }

    $db->query("UPDATE anagrafica_studenti_swiss
                SET
                nome = :nome,
                telefono = :telefono,
                comune_nascita = :comune_nascita,
                data_nascita = :data_nascita,
                data_laurea = :data_laurea,
                titolo_studio='".$_POST['titolo_studio']."',
                doc_identita='".$_POST['doc_identita']."',
                statino_esami='".$_POST['statino_esami']."',
                cod_fiscale='".$_POST['cod_fiscale']."',
                dati_esteri=:dati_esteri,
                matricola=:matricola,
                ".$testo_pwd."
                id_provincia=:id_provincia
                WHERE id='".$_POST['id_studente']."' ");

    $array_var=array(
            ":nome" => $_POST['nome'],
            ":comune_nascita" => $_POST['comune_nascita'],
            ":data_nascita" => sistemadata($_POST['data_nascita']),
            ":data_laurea" => sistemadata($_POST['data_laurea']),
            ":dati_esteri" => $_POST['dati_esteri'],
            ":matricola" => $_POST['matricola'],
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

if ($_POST['func'] == "ins_studente"){
    
     $errore = "";
     
     
     $db->query("SELECT * FROM bag_admin WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già un studente con questa email.');
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
     
     $db->query("SELECT * FROM anagrafica_studenti_swiss WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già uno stundente con questa email.');
        echo json_encode($arr);
        exit();  
         
     }
     
     $db->query(" INSERT INTO anagrafica_studenti_swiss(nome,password,email,id_provincia,telefono,comune_nascita,data_nascita,attivo,titolo_studio,doc_identita,cod_fiscale,dati_esteri,data_laurea,matricola,statino_esami)   
                  VALUES(:nome,:password,:email,:id_provincia,:telefono,:comune_nascita,:data_nascita,'s','".$_POST['titolo_studio']."','".$_POST['doc_identita']."','".$_POST['cod_fiscale']."',
                      :dati_esteri,:data_laurea,:matricola,'".$_POST['statino_esami']."') 
                ");
        if(!$db->execute(array(
            ":nome" => $_POST['nome'],
            ":email" => $_POST['email'],
            ":password" => $_POST['password'],
            ":comune_nascita" => $_POST['comune_nascita'],
            ":data_nascita" => sistemadata($_POST['data_nascita']),
            ":data_laurea" => sistemadata($_POST['data_laurea']),
            ":dati_esteri" => $_POST['dati_esteri'],
            ":matricola" => $_POST['matricola'],
            ":id_provincia" => $_POST['id_provincia'],
            ":telefono" => $_POST['telefono']
        ))) { 
         $errore="NON INSERITO";
        }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "load_ins_form") { 
    
    
    if($_POST['id']!="0"){
        
         $db->query("SELECT * FROM anagrafica_studenti_swiss WHERE id = '".$_POST['id']."' ");
         $studente=$db->single();    
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
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="row">
    <div class="col-md-12">
        <div class="card card-with-nav">
            <div class="card-body">
                <form id="form_ins_studente" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                    
                    
                    <input name="func" id="func" value="<?php if($_POST['id']!="0"){ echo "edit_studente";} else { echo "ins_studente";} ?>" type="hidden" />
                    <?php
                    if($_POST['id']!="0"){ ?>
                     <input name="id_studente" id="id_studente" value="<?=$_POST['id'];?>" type="hidden" />   
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
                                        <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?=$studente['nome'];?>" required>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input  <?php if($_POST['id']!="0"){ echo "readonly"; } ?> type="email" class="form-control" name="email" placeholder="Email" value="<?=$studente['email'];?>" required >
                                    </div>
                                </div>
                            </div>    
                           
                            <div class="row mt-3">
                             
                                <div class="col-md-6" id="divProvincia">
                                    <?php
                                          $db->query("SELECT * FROM provincia ORDER BY nome");
                                          $province= $db->resultset();
                                    ?>
                                    <div class="form-group form-group-default">
                                        <label>Provincia (ITALIA)</label>
                                        <select class="form-control" id="id_provincia" name="id_provincia" placeholder="Provincia" style="width:100%">
                                            <?php 
                                            foreach($province As $provincia){ ?>
                                            <option value="<?=$provincia['id'];?>"
                                             <?php  if($_POST['id']!="0" AND $studente['id_provincia']==$provincia['id'] ){ echo "selected ";} ?>      
                                             ><?=$provincia['nome'];?></option>   
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Comune di nascita (ITALIA)</label>
                                        <input type="text" class="form-control" name="comune_nascita" placeholder="Comune di nascita"  value="<?=$studente['comune_nascita'];?>" required>
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
                                        <label>Telefono</label>
                                        <input type="text" class="form-control" value="<?=$studente['telefono'];?>" name="telefono" placeholder="Telefono">
                                    </div>
                                </div>
                            </div>
                            
                              <div class="row mt-3">
                           
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">               
                                        <label>Data di nascita</label>
                                        <input type="text" class="form-control" value="<?php  if($_POST['id']!="0") echo date('d/m/Y', strtotime($studente['data_nascita']));?>" name="data_nascita" id='data_nascita'  >
                                    </div>
                                </div>
                                   <div class="col-md-6">
                                    <div class="form-group form-group-default">               
                                        <label>Numero Matricola</label>
                                        <input type="text" class="form-control" value="<?php $studente['matricola'];?>" name="matricola" id='matricola'  >
                                    </div>
                                </div>
                                 
                            </div>
                            
                              <div class="row mt-3">
                                  <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Diploma di laurea in?</label>
                                         <input type="text" class="form-control" name="titolo_studio" placeholder="Nome del diploma di laurea"  value="<?=$studente['titolo_studio'];?>" required> 
                                    </div>
                                 </div>
                                
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">               
                                        <label>Data di laurea</label>
                                        <input type="text" class="form-control" value="<?php  if($_POST['id']!="0") echo date('d/m/Y', strtotime($studente['data_laurea']));?>" name="data_laurea" id='data_laurea'  >
                                    </div>
                                </div>
                            </div>
                             <div class="row mt-3">
                               <div class="col-md-6">
                                  <div class="form-group form-group-default">
                                        <label>Comune Estero  <span style='color:red'>(SOLO SE NAZIONALITA' ESTERA)</span></label>
                                        <input type="text" class="form-control" name="dati_esteri"   value="<?=$studente['dati_esteri'];?>">
                                    </div>
                                  
                                </div>
                             </div>   
                            <div class="row mt-3">
                               <div class="col-md-6">
                                
                                    <div class="form-group ">
                                        <label>Documento Indentità</label>
                                        
                                            <?php if($_POST['id']!="0" AND $studente['doc_identita']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/studenti/<?=$studente['doc_identita'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="doc_identita§studenti"  type="file"  />
                                         <input type="hidden" id="doc_identita"  name="doc_identita" value="<?=$studente['doc_identita'];?>"/> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Codice Fiscale</label>
                                         <?php if($_POST['id']!="0" AND $studente['cod_fiscale']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/studenti/<?=$studente['cod_fiscale'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="cod_fiscale§studenti"  type="file" />
                                         <input type="hidden" id="cod_fiscale"  name="cod_fiscale" value="<?=$studente['cod_fiscale'];?>"/> 
                                    </div>
                                </div>

                            </div>
                                    <div class="row mt-3">
                               <div class="col-md-6">
                                
                                    <div class="form-group ">
                                        <label>Statino Esami</label>
                                        
                                            <?php if($_POST['id']!="0" AND $studente['statino_esami']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/studenti/<?=$studente['statino_esami'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="statino_esami§studenti"  type="file"  />
                                         <input type="hidden" id="statino_esami"  name="statino_esami" value="<?=$studente['statino_esami'];?>"/> 
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