<?php
require("../inc_config.php");

if ($_POST['func'] == "attiva_metodo") {
    $errore = "";
    $warning = "no";
    
    $stato='s';
    if($_POST['stato_attuale']=='s') $stato='n';

    if ($_POST['id']) {
        
        $db->query("UPDATE ".$_POST['table']." SET attivo = 'n'");
        $db->execute();
        $db->query("UPDATE ".$_POST['table']." SET attivo = '".$stato."' WHERE id='".$_POST['id']."' ");
        if (!$db->execute()) {
            $errore = "NON MODIFICATO!";
        }else{
            
            $query = "SELECT *
                      FROM
                      account_paypal
                      WHERE `attivo` = 's'
                    ";
            $db->query($query);
            $metod=$db->single();
            $_SESSION['metod']= $metod['email'];
        }
    } else {
        $errore = 'ID non valido';
    }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();
}

if ($_POST['func'] == "ins_metodopag"){
    
     $errore = "";

     
     $db->query("SELECT * FROM account_paypal WHERE email = :email");
     $db->single(array(":email" => $_POST['email']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già un account con questa email.');
        echo json_encode($arr);
        exit();  
         
     }

     
     $db->query(" INSERT INTO account_paypal(email,attivo)   
                  VALUES(:email,'n') 
                ");
        if(!$db->execute(array( ":email" => $_POST['email']))) { 
         $errore="NON INSERITO";
        }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "load_ins_form") { 
    

    ?>


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
                <form id="form_ins_metodopag" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                    <input name="func" id="func" value="ins_metodopag" type="hidden" />
              
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
                                        <label>Email</label>
                                        <input  type="email" class="form-control" name="email" placeholder="Email dell'account" value="" required >
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