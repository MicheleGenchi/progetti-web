<?php
require("../inc_config.php");

if ($_POST['func'] == "check_visionato") { 
    
    $completato='n';
    
    $db->query("UPDATE file_corsi
                SET visionato='s'
                WHERE id= '".$_POST['id']."' 
               ");   
     $db->execute();
     
    $db->query("SELECT * FROM file_corsi WHERE id_corso= '".$_POST['id_corso']."' AND tipo_file='video' ");          
    $files=$db->resultset();
    $all_file=$db->rowCount($files);
    
    $db->query("SELECT * FROM file_corsi WHERE id_corso= '".$_POST['id_corso']."' AND tipo_file='video' AND visionato='s' ");          
    $files_vis=$db->resultset();
    $all_file_vis=$db->rowCount( $files_vis);
    
    if($all_file > 0 AND $all_file==$all_file_vis){
        
        $db->query("UPDATE studente_corso
                    SET sblocca_attestato='s'
                    WHERE id_studente= '".$_SESSION['user']."' 
                    AND id_corso='".$_POST['id_corso']."'
                   ");   
        $db->execute();
        
        $completato='s'; 
       
    }
                                         
    $arr = array('completato' => $completato);
    echo json_encode($arr);
    exit(); 
}

if ($_POST['func'] == "load_materiale") { 

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
                                            <span style='font-size:20px'>VIDEO</span> <br />
                                              <div class="col-md-12">
                                                  <div class="row">
                                               <?php
                                                $db->query("SELECT * FROM file_corsi WHERE id_corso= '".$_POST['id']."' AND tipo_file='video' ");          
                                                $files=$db->resultset();
                                                foreach ($files AS $file){ ?>
                                                      <div class="col-md-2"  id='div-file-<?=$file['id'];?>' style="margin-right:4px;height:220px;border:solid 1px #dedede;padding:5px;">  
                                                          <span style='font-size:15px;color:#158bee;'> <b><?=ucfirst(strtolower($file['nome']));?></b></span> 
                                           
                                                        <?php  
                                                        if($file['codice_vimeo']==''){ ?>  
                                                          <video width="100%" height="180" controls class="visionato" data-id_file="<?=$file['id'];?>" data-id_corso="<?=$_POST['id'];?>">
                                                            <source src="<?=BASE_URL;?>file/corsi/<?=$file['percorso'];?>" type="video/mp4">
                                                        </video>
                                                        <?php } else { ?>
                                                        <iframe  class="vid_vimeo" src="https://player.vimeo.com/video/<?=$file['codice_vimeo'];?>"  for="<?=$file['id'];?>"  data-id_file="<?=$file['id'];?>" data-id_corso="<?=$_POST['id'];?>"
                                                                width="100%" height="180" frameborder="0" 
                                                                allowfullscreen="allowfullscreen">
                                                                  
                                                        </iframe>
                                                          
                                                        <?php } ?>  
                                                  </div>    
                                                    
                                                <?php } ?>
                                               
                                               
                                                  </div>
                                              </div>
                                        </div>
                          

                                    </div>
                                    <div class="tab-pane fade " id="p-file" role="tabpanel" aria-labelledby="p-file-tab">
                                     <div class="row mt-3">
                                            <span style='font-size:20px'>FILE</span> <br />
                                              <div class="col-md-12">
                                                  <div class="row">
                                               <?php
                                                $db->query("SELECT * FROM file_corsi WHERE id_corso= '".$_POST['id']."' AND tipo_file='file' ");          
                                                $files=$db->resultset();
                                                foreach ($files AS $file){ ?>
                                                  <div class="col-md-2 "  for="<?=$file['id'];?>" id='div-file-<?=$file['id'];?>' style="margin-right:4px;height:120px;border:solid 1px #dedede;padding:5px;">  
                                                          <div style='font-size:15px;color:#158bee;height:23px;'> <b><?=ucfirst(strtolower($file['nome']));?></b></div> 
                                                          <br />
                                                          <a href='<?=BASE_URL;?>file/corsi/<?=$file['percorso'];?>' style="margin-left:25px;" target="_blank"> <i class="fas fa-file-alt" style="font-size:45px;"></i>  </a>
                                                  </div>    
                                                    
                                                <?php } ?>
                                               
                                               
                                                  </div>
                                              </div>
                                        </div>
                                        <br /> 
       

                                    </div>
                                    <div class="tab-pane fade " id="p-quiz" role="tabpanel" aria-labelledby="p-quiz-tab">
                                         <div class="row mt-3">
                                            <span style='font-size:20px'>FILE </span> <br />
                                              <div class="col-md-12">
                                                  <div class="row">
                                               <?php
                                                $db->query("SELECT * FROM file_corsi WHERE id_corso= '".$_POST['id']."' AND tipo_file='quiz' ");          
                                                $files=$db->resultset();
                                                foreach ($files AS $file){ ?>
                                                  <div class="col-md-2" for="<?=$file['id'];?>" id='div-file-<?=$file['id'];?>' style="margin-right:4px;height:120px;border:solid 1px #dedede;padding:5px;">  
                                                          <div style='font-size:15px;color:#158bee;height:23px;'> <b><?=ucfirst(strtolower($file['nome']));?></b></div> 
                                         
                                                          <br />
                                                          <a href='<?=BASE_URL;?>file/corsi/<?=$file['percorso'];?>' style="margin-left:25px;" target="_blank"> <i class="fas fa-file-alt" style="font-size:45px;"></i>  </a>
                                                  </div>    
                                                    
                                                <?php } ?>
                                               
                                               
                                                  </div>
                                              </div>
                                        </div>
                                        <br /> 
                             

                                    </div>


                                </div>
                        </div>
                </div>
        </div>
</div>

    
<?php  
}
?>