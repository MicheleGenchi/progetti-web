<?php
require("../inc_config.php");



if($_POST['function']=="ins_video_vimeo"){

    for($i=1;$i<=4;$i++){
        
        if($_POST['nome_video_'.$i]!='' AND $_POST['codice_video_'.$i]!=''){
            
                $db->query("INSERT INTO file_corsi(nome,tipo_file,id_corso,codice_vimeo)   
                                  VALUES(:nomefile,'video','".$_POST['id_corso']."',:codice_vimeo) ");
                $db->execute(array(":nomefile" => $_POST['nome_video_'.$i],
                                   ":codice_vimeo" => $_POST['codice_video_'.$i],
                                   )); 
        }
        
    }
    $arr = array('errore' => '');
    echo json_encode($arr);
    exit(); 
 }

if($_POST['function']=="elimina_file"){

         //Cancello file
         $db->query("SELECT percorso FROM file_corsi
                     WHERE id= '".$_POST['id_file']."' ");
         $nomefile=$db->single();

         $db->query("DELETE FROM file_corsi
                     WHERE id= '".$_POST['id_file']."' ");
         $db->execute();

         unlink(BASE_PATH."file/corsi/".$nomefile['percorso']);

 }

if ($_POST['func'] == "edit_corso"){
    
     $errore = "";
     $testo_pwd='';
     $testo_pwd_array='';
     $costo=str_replace(",",".",$_POST['costo']);

    $db->query("UPDATE anagrafica_corsi
                SET
                nome=:nome,
                descrizione=:descrizione,
                email=:email,
                costo=:costo,
                testo_decreto= :testo_decreto,
                durata=:durata,
                contratto=:contratto,
                tipologia=:tipologia,
                modulo_assicurazione=:modulo_assicurazione,
                manifesto=:manifesto
                WHERE id='" . $_POST['id_corso'] . "'
                ");

    $array_var=array(
            ":nome" => $_POST['nome'],
            ":email" => $_POST['email'],
            ":tipologia" => $_POST['tipologia'],
            ":descrizione" => $_POST['descrizione'],
            ":durata" => $_POST['durata'],
            ":costo" => $costo,
            ":manifesto" => $_POST['manifesto'],
            ":contratto" => $_POST['contratto'],
            ":modulo_assicurazione" => $_POST['modulo_assicurazione'],
            ":testo_decreto"=>$_POST['testo_decreto']
    );

        if (!$db->execute($array_var)) { 
         $errore="NON INSERITO";
        }
    
   $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();       
}

if ($_POST['func'] == "ins_corso"){
    
     $errore = "";
     
     
     $db->query("SELECT * FROM anagrafica_corsi WHERE nome = :nome");
     $db->single(array(":nome" => $_POST['nome']));
     if($db->rowCount()>0){
        $arr = array('errore' => 'Attenzione esiste già un corso con questo nome.');
        echo json_encode($arr);
        exit();  
         
     }
 
     $costo=str_replace(",",".",$_POST['costo']);
     $db->query(" INSERT INTO anagrafica_corsi(nome,email,descrizione,durata,costo,attivo,testo_decreto,id_utente,manifesto,contratto,modulo_assicurazione,tipologia)   
                  VALUES(:nome,:email,:descrizione,:durata,:costo,'n',:testo_decreto,'".$_SESSION['user']."',:manifesto,:contratto,:modulo_assicurazione,:tipologia ) 
                ");
        if (!$db->execute(array(
            ":nome" => $_POST['nome'],
            ":email" => $_POST['email'],
            ":tipologia" => $_POST['tipologia'],
            ":descrizione" => $_POST['descrizione'],
            ":durata" => $_POST['durata'],
            ":costo" => $costo,
            ":manifesto" => $_POST['manifesto'],
            ":modulo_assicurazione" => $_POST['modulo_assicurazione'],
            ":contratto" => $_POST['contratto'],
            ":testo_decreto" => $_POST['testo_decreto']
        ))) { 
         $errore="NON INSERITO";
        }else{
                $id_corso=$db->lastInsertId();
                
                //INSERISCO,PER OGNI SCUOLA, IL CORSO NELLA TABELLA corsi_scuole per dare un costo iniziale a questo corso per ogni scuola    
                $db->query("SELECT * FROM anagrafica_scuole");
                $scuole=$db->resultset(); 
                foreach($scuole AS $scuola){ 

                    $db->query("INSERT INTO corsi_scuole(id_corso,id_scuola,costo)   
                                VALUES('". $id_corso."','".$scuola['id']."','". $costo."')
                              ");
                    if (!$db->execute()) { 
                     $errore="CORSO_SCUOLA NON INSERITO";
                    }

                }
            
            
        }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();      
}

if ($_POST['func'] == "load_ins_form") { 
    
    
    if($_POST['id']!="0"){
        
         $db->query("SELECT * FROM anagrafica_corsi WHERE id = '".$_POST['id']."' ");
         $corso=$db->single();    
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
                <form id="form_ins_corso" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                    
                    
                    <input name="func" id="func" value="<?php if($_POST['id']!="0"){ echo "edit_corso";} else { echo "ins_corso";} ?>" type="hidden" />
                    <?php
                    if($_POST['id']!="0"){ ?>
                     <input name="id_corso" id="id_corso" value="<?=$_POST['id'];?>" type="hidden" />   
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
                                        <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?=$corso['nome'];?>" required>
                                    </div>
                                 </div>
                                   <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Durata (MESI)</label>
                                        <input   type="number" class="form-control" name="durata" placeholder="Durata" value="<?=$corso['durata'];?>" required >
                                    </div>
                                </div>
                            </div>    
                            <div class="row mt-3">
                           
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Costo</label>
                                        <input type="text" class="form-control" name="costo" placeholder="Costo" required value="<?=$corso['costo'];?>" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" placeholder="Email" required value="<?=$corso['email'];?>" >
                                    </div>
                                </div>
                            </div>  
                            <div class="row mt-3">    
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Testo Decreto</label>
                                        <textarea name="testo_decreto" class="form-control" ><?=$corso['testo_decreto'];?> </textarea>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Descrizione</label>
                                        <textarea name="descrizione" class="form-control" ><?=$corso['descrizione'];?> </textarea>
                                    </div>
                        
                            </div>
                            </div>
                            <div class="row mt-3">
                               <div class="col-md-6">
                                
                                    <div class="form-group ">
                                        <label>Manifesto</label>
                                        
                                            <?php if($_POST['id']!="0" AND $corso['manifesto']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/corsi/<?=$corso['manifesto'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="manifesto§corsi"  type="file"  />
                                         <input type="hidden" id="manifesto"  name="manifesto" value="<?=$corso['manifesto'];?>"/> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Contratto</label>
                                        
                                            <?php if($_POST['id']!="0" AND $corso['contratto']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/corsi/<?=$corso['contratto'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="contratto§corsi"  type="file"  />
                                         <input type="hidden" id="contratto"  name="contratto" value="<?=$corso['contratto'];?>"/> 
                                    </div>
                                </div>
                               

                            </div>
                            <div class="row mt-3">
                               <div class="col-md-6">
                                
                                    <div class="form-group ">
                                        <label>Modulo Assicurazione</label>
                                        
                                            <?php if($_POST['id']!="0" AND $corso['modulo_assicurazione']!=''){ ?>
                                             &nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL;?>file/corsi/<?=$corso['modulo_assicurazione'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a>
                                             <?php } ?>
                                         <input class="loadfile" accept="*" name="modulo_assicurazione§corsi"  type="file"  />
                                         <input type="hidden" id="modulo_assicurazione"  name="modulo_assicurazione" value="<?=$corso['modulo_assicurazione'];?>"/> 
                                    </div>
                                </div>
                                <div class="col-md-6" >
                           
                                    <div class="form-group form-group-default">
                                        <label>Tipologia</label>
                                        <select class="form-control" id="tipologia" name="tipologia"  style="width:100%">
                                            <option value="formazione" <?php  if($_POST['id']!="0" AND $corso['tipologia']=='formazione'){ echo "selected";} ?>>formazione</option>
                                            <option value="aggiornamento" <?php  if($_POST['id']!="0" AND $corso['tipologia']=='aggiornamento'){ echo "selected";} ?>>aggiornamento</option> 
                                        </select>
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

if ($_POST['func'] == "load_materiale") { 

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
                                                <a class="nav-link active" id="p-video-tab" data-toggle="pill" href="#p-video" role="tab" aria-controls="p-video" aria-selected="true">Video</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="p-file-tab" data-toggle="pill" href="#p-file" role="tab" aria-controls="p-file" aria-selected="false">File</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="p-quiz-tab" data-toggle="pill" href="#p-quiz" role="tab" aria-controls="p-quiz" aria-selected="false">Quiz</a>
                                            </li>
                                        </ul>
                                </div>
                        </div>
                        <div class="card-body">
                             <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="p-video" role="tabpanel" aria-labelledby="p-video-tab">
                                        <div class="row mt-3">
                                            <span style='font-size:20px'>VIDEO CARICATI</span> <br />
                                              <div class="col-md-12">
                                                  <div class="row">
                                               <?php
                                                $db->query("SELECT * FROM file_corsi WHERE id_corso= '".$_POST['id']."' AND tipo_file='video' ");          
                                                $files=$db->resultset();
                                                foreach ($files AS $file){ ?>
                                                      <div class="col-md-2" id='div-file-<?=$file['id'];?>' style="margin-right:4px;height:220px;border:solid 1px #dedede;padding:5px;">  
                                                          <span style='font-size:15px;color:#158bee;'> <b><?=ucfirst(strtolower($file['nome']));?></b></span> 
                                                        <?php if($_SESSION['livello']=='Admin'){ ?>  
                                                          <div style='float:right;width:20px;'>
                                                              <i class="fas fa-trash elimina_file" title='Elimina' data-id='<?=$file['id'];?>' style="color:red;cursor:pointer;"></i>
                                                          </div><br /> 
                                                        <?php } if($file['codice_vimeo']==''){ ?>  
                                                        <video width="100%" height="180" controls>
                                                            <source src="<?=BASE_URL;?>file/corsi/<?=$file['percorso'];?>" type="video/mp4">
                                                        </video>
                                                        <?php } else { ?>
                                                        <iframe src="https://player.vimeo.com/video/<?=$file['codice_vimeo'];?>" 
                                                                width="100%" height="180" frameborder="0" 
                                                                allowfullscreen="allowfullscreen">
                                                                  
                                                        </iframe>
                                                          
                                                        <?php } ?>  
                                                  </div>    
                                                    
                                                <?php } ?>
                                               
                                               
                                                  </div>
                                              </div>
                                        </div>
                                        <br />
                             <?php if($_SESSION['livello']=='Admin'){ ?>              
                                        <div class="row mt-3">
                                             <span style='font-size:20px'>CARICA VIDEO</span> <br />
                                             <div class="col-md-12" style="padding:0px;">
                                               <div class="form-group ">
                                               <input class="loadfile_video" accept="*" name="video§<?=$_POST['id'];?>"  type="file" multiple  />
                                               </div>
                                              </div>
                                        </div>   
                                        <div class="row mt-3">
                                             <span style='font-size:20px'>CARICA VIDEO VIMEO</span> <br />
                                        </div>  
                                  <form id="form_ins_vimeo" class="form-control" action="javascript:void(null)" method="post" enctype="multipart/form-data">
                                       <input name="function" id="function" value="ins_video_vimeo" type="hidden" />
                                       <input name="id_corso" id="id_corso" value="<?=$_POST['id'];?>" type="hidden" />
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default">
                                                    <label>Nome 1</label>
                                                    <input type="text" class="form-control" name="nome_video_1" placeholder="Nome video" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default">
                                                    <label>Codice 1</label>
                                                    <input type="text" class="form-control" name="codice_video_1" placeholder="Codice Vimeo"   >
                                                </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="form-group form-group-default">
                                                    <label>Nome 2</label>
                                                    <input type="text" class="form-control" name="nome_video_2" placeholder="Nome video" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default">
                                                    <label>Codice 2</label>
                                                    <input type="text" class="form-control" name="codice_video_2" placeholder="Codice Vimeo" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                           <div class="col-md-3">
                                                <div class="form-group form-group-default">
                                                    <label>Nome 3</label>
                                                    <input type="text" class="form-control" name="nome_video_3" placeholder="Nome video">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default">
                                                    <label>Codice 3</label>
                                                    <input type="text" class="form-control" name="codice_video_3" placeholder="Codice Vimeo"   >
                                                </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="form-group form-group-default">
                                                    <label>Nome 4</label>
                                                    <input type="text" class="form-control" name="nome_video_4" placeholder="Nome video">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-default">
                                                    <label>Codice 4</label>
                                                    <input type="text" class="form-control" name="codice_video_4" placeholder="Codice Vimeo"   >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2"><button  type="submit" class="btn btn-success" id="salvaProButton" name="salvaProButton" style="float:right;padding:8px 28px;" >SALVA</button>
                                            </div>
                                        </div>  
                                     </form>         
                             <?php } ?>
                                    </div>
                                    <div class="tab-pane fade " id="p-file" role="tabpanel" aria-labelledby="p-file-tab">
                                     <div class="row mt-3">
                                            <span style='font-size:20px'>FILE CARICATI</span> <br />
                                              <div class="col-md-12">
                                                  <div class="row">
                                               <?php
                                                $db->query("SELECT * FROM file_corsi WHERE id_corso= '".$_POST['id']."' AND tipo_file='file' ");          
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
                                                          <a href='<?=BASE_URL;?>file/corsi/<?=$file['percorso'];?>' style="margin-left:25px;" target="_blank"> <i class="fas fa-file-alt" style="font-size:45px;"></i>  </a>
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
                                                <label>CARICA FILE</label>
                                                <input class="loadfile" accept="*" name="file§<?=$_POST['id'];?>"  type="file"  multiple/>
                                                </div>
                                              </div>
                                        </div> 
                                     <?php } ?>

                                    </div>
                                    <div class="tab-pane fade " id="p-quiz" role="tabpanel" aria-labelledby="p-quiz-tab">
                                         <div class="row mt-3">
                                            <span style='font-size:20px'>FILE CARICATI</span> <br />
                                              <div class="col-md-12">
                                                  <div class="row">
                                               <?php
                                                $db->query("SELECT * FROM file_corsi WHERE id_corso= '".$_POST['id']."' AND tipo_file='quiz' ");          
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
                                                          <a href='<?=BASE_URL;?>file/corsi/<?=$file['percorso'];?>' style="margin-left:25px;" target="_blank"> <i class="fas fa-file-alt" style="font-size:45px;"></i>  </a>
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
                                               <label>CARICA FILE QUIZ</label>
                                               <input class="loadfile" accept="*" name="quiz§<?=$_POST['id'];?>"  type="file"  />
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