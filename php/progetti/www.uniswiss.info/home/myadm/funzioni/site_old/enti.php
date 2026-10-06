<?php
require("../inc_config.php");




if ($_POST['func'] == "edit_ente"){
 
    $errore = "";
    
    $db->query("UPDATE anagrafica_enti_convenzionati
                SET
                nome = :nome,
                provincia = :provincia,
                citta = :citta,
                referente = :referente,
                settore = :settore,
                telefono = :telefono,
                contratto = :contratto,
                email = :email
                WHERE id='".$_POST['id_ente']."' ");

    $array_var=array(
            ":nome" => $_POST['nome'],
             ":provincia" => $_POST['provincia'],
             ":citta" => $_POST['citta'],
             ":referente" => $_POST['referente'],
             ":settore" => $_POST['settore'],
             ":telefono" => $_POST['telefono'],
             ":contratto" => $_POST['contratto'],
             ":email" => $_POST['email']
        );

    
   // print_r($aray_var);
    
        if (!$db->execute($array_var)) { 
         $errore="NON INSERITO";
        }
    
   $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();       
}

if ($_POST['func'] == "ins_ente"){
    
     $errore = "";
     
     $db->query("SELECT * FROM anagrafica_enti_convenzionati WHERE nome = :nome");
     $db->single(array(":nome" => $_POST['nome']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già un ente convenzionato con questa email.');
        echo json_encode($arr);
        exit();  
     }

     
     $db->query("INSERT INTO anagrafica_enti_convenzionati(nome,provincia,citta,referente,settore,telefono,email,id_utente,contratto)   
                 VALUES(:nome,:provincia,:citta,:referente,:settore,:telefono,:email,'".$_SESSION['user']."',:contratto) 
                ");
        if (!$db->execute(array(
            ":nome" => $_POST['nome'],
             ":provincia" => $_POST['provincia'],
             ":citta" => $_POST['citta'],
             ":referente" => $_POST['referente'],
             ":settore" => $_POST['settore'],
            ":contratto" => $_POST['contratto'],
             ":telefono" => $_POST['telefono'],
             ":email" => $_POST['email']
        ))) { 
         $errore="NON INSERITO";
        }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "load_ins_form") { 
    
    
    if($_POST['id']!="0"){
        
         $db->query("SELECT * FROM anagrafica_enti_convenzionati WHERE id = '".$_POST['id']."' ");
         $ente=$db->single();    
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
                <form id="form_ins_ente" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                    
                    
                    <input name="func" id="func" value="<?php if($_POST['id']!="0"){ echo "edit_ente";} else { echo "ins_ente";} ?>" type="hidden" />
                    <?php
                    if($_POST['id']!="0"){ ?>
                     <input name="id_ente" id="id_ente" value="<?=$_POST['id'];?>" type="hidden" />   
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
                                        <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?=$ente['nome'];?>" required>
                                    </div>
                                 </div>
                               <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Provincia</label>
                                        <input type="text" class="form-control" name="provincia" placeholder="Provincia" value="<?=$ente['provincia'];?>" required>
                                    </div>
                                 </div>
                            </div>    
                             <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Citta</label>
                                        <input type="text" class="form-control" name="citta" placeholder="Città" value="<?=$ente['citta'];?>" required>
                                    </div>
                                 </div>
                               <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Settore</label>
                                        <input type="text" class="form-control" name="settore" placeholder="Settore" value="<?=$ente['settore'];?>" required>
                                    </div>
                                 </div>
                            </div>
                              <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Referente</label>
                                        <input type="text" class="form-control" name="referente" placeholder="Referente" value="<?=$ente['referente'];?>" required>
                                    </div>
                                 </div>
                               <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Telefono</label>
                                        <input type="text" class="form-control" name="telefono" placeholder="Telefono" value="<?=$ente['telefono'];?>" required>
                                    </div>
                                 </div>
                            </div> 
                             <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?=$ente['email'];?>" required>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                
                                    <div class="form-group ">
                                        <label>Contratto di convenzione</label>
                                        
                                            <?php if($_POST['id']!="0" AND $ente['contratto']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/enti/<?=$ente['contratto'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="contratto§enti"  type="file"  />
                                         <input type="hidden" id="contratto"  name="contratto" value="<?=$ente['contratto'];?>"/> 
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