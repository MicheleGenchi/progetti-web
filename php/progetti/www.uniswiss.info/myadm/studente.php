<?php
require("inc_config.php");

//Se ancora non sono loggato vado al login
if ((!isset($_SESSION['user'])) || ($_SESSION['livello'] != "Studente" )) {
    header("Location:" . BASE_URL . "login.php");
}

require(BASE_PATH . "inc_header.php");
?>
</head>

<body>

    <?php
    require(BASE_PATH . "modali/insstudente.php");
    ?>

    <div class="wrapper">
        <div class="main-header">
            <?php include BASE_PATH . "inc_logo_header.php"; ?>

            <!-- Navbar Header -->
            <?php
            require_once(BASE_PATH . "inc_navbar_header.php");
            ?>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <?php
        require_once(BASE_PATH . "inc_sidebar.php");
          
        $db->query("SELECT * FROM anagrafica_studenti_swiss WHERE id='".$_SESSION['user']."' ");
        $studente=$db->single();
    
        ?>
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">STUDENTE <?=  strtoupper($studente['nome']);?></h4>
                                       
<!--                                        <a href="javascript:void(null)"  for="0" class="btn btn-primary btn-round ml-auto ins_edit">
                                        <b><i class="fa fa-plus"></i> AGGIUNGI</b>
                                        </a>-->
                                        
                                    </div>
                            
                                </div>
                                
                                
                                <div class="card-body">
                                    <!-- <div class="table-responsive"> -->
                                    <div class="row" style="font-size:18px;">
                               
                                        <div class="col-md-3"> <b>Matricola:</b>  <?=$studente['matricola'];?></div>  
                                        <div class="col-md-3"> <b>Email:</b>  <?=$studente['email'];?> </div>
                                        <div class="col-md-3"> <b>Telefono:</b>  <?=$studente['telefono'];?></div>
                                        <div class="col-md-3"> <b>Titolo di studio:</b>  <?=$studente['titolo_studio'];?> </div>
                                        <div class="col-md-3"> <b>Data laurea:</b>  <?=date('d/m/Y',strtotime($studente['data_laurea']));?>  </div>
                                        <div class="col-md-3"> <b>Statino esami:</b>  <a href="<?=BASE_URL;?>file/studenti/<?=$studente['statino_esami'];?>" target="_blank" >
                                             <i class="la flaticon-file" style="font-size:29px;color:blue;"></i>
                                             </a> </div>
                                        <div class="col-md-3">  </div>
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require BASE_PATH . 'inc_main_panel_footer.php'; ?>
        </div>
    </div>

    <?php require BASE_PATH . 'inc_footer.php'; ?>


   <script src="<?= BASE_URL; ?>funzionijs/index.js" type="text/javascript"></script>
   <script src="<?=BASE_URL;?>fileinput/js/fileinput_orig.js"></script>
   <script src="<?=BASE_URL;?>fileinput/js/locales/it.js"></script>
       <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</body>

</html>