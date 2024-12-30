<?php
require("../inc_config.php");




if ($_POST['func'] == "edit_opzione"){
 
    $errore = "";
    
    $db->query("UPDATE opzioni
                SET
                nome = :nome,
                valore = :valore
                WHERE id='".$_POST['id_opzione']."' ");

    $array_var=array(
            ":nome" => $_POST['nome'],
            ":valore" => $_POST['valore']
    );

    
   // print_r($aray_var);
    
        if (!$db->execute($array_var)) { 
         $errore="NON INSERITO";
        }
    
   $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();       
}

if ($_POST['func'] == "ins_opzione"){
    
     $errore = "";
     
     $db->query("SELECT * FROM opzioni WHERE nome = :nome");
     $db->single(array(":nome" => $_POST['nome']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già  una opzione  con questa email.');
        echo json_encode($arr);
        exit();  
     }

     
     $db->query("INSERT INTO opzioni(nome,valore)   
                 VALUES(:nome,:valore) 
                ");
        if (!$db->execute(array(
            ":nome" => $_POST['nome'],
            ":valore" => $_POST['valore']
        ))) { 
         $errore="NON INSERITO";
        }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "load_ins_form") { 
    
    
    if($_POST['id']!="0"){
        
         $db->query("SELECT * FROM opzioni WHERE id = '".$_POST['id']."' ");
         $opzione=$db->single();    
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
                <form id="form_ins_opzione" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                    
                    
                    <input name="func" id="func" value="<?php if($_POST['id']!="0"){ echo "edit_opzione";} else { echo "ins_opzione";} ?>" type="hidden" />
                    <?php
                    if($_POST['id']!="0"){ ?>
                     <input name="id_opzione" id="id_opzione" value="<?=$_POST['id'];?>" type="hidden" />   
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
                                        <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?=$opzione['nome'];?>" readonly required>
                                    </div>
                                 </div>
                                  <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Valore %</label>
                                        <input type="number" class="form-control" name="valore" placeholder="Valore" value="<?=$opzione['valore'];?>" required> 
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