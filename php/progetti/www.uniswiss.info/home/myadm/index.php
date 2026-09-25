<?php
require("inc_config.php");

//Se ancora non sono loggato vado al login
if ((!isset($_SESSION['user'])) || ($_SESSION['livello'] != "Admin" )) {
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
                                        <h4 class="card-title">STUDENTI</h4>
                                       
                                        <a href="javascript:void(null)"  for="0" class="btn btn-primary btn-round ml-auto ins_edit">
                                        <b><i class="fa fa-plus"></i> AGGIUNGI</b>
                                        </a>
                                        
                                    </div>
                            
                                </div>
                                
                                
                                <div class="card-body">
                                    <!-- <div class="table-responsive"> -->
                                    <div class="row">
                                        <table id="studenti_datatable" class="display table table-striped table-hover table-thin-td table-centered-td">
                                            <thead>
                                                <tr>
                                                     <th scope="col" style="display: none">id</th>
                                                    <th scope="col" style="width: 10%">Nome</th>
                                                    <th scope="col" style="width: 10%">Email</th>
                                                    <th scope="col" style="width: 5%">Telefono</th>
                                                    <th scope="col" style="width: 10%">Comune Nascita</th>
                                                    <th scope="col" style="width: 7%">Data Nascita</th>
                                                    <th scope="col" style="width: 7%">Prov. Res.</th>
                                                    <th scope="col" style="width: 3%" class="dt-center">Attivo</th>
                                                     <th scope="col" style="width:7%">Doc. Iden.</th>
                                                    <th scope="col" style="width: 7%">Cod. Fisc.</th>
                                                    <th scope="col" style="width: 5%">Statino</th>
                                                    <th scope="col" style="width: 7%">Tit. Studio</th>
                                                     <th scope="col" style="width: 7%">Data laurea</th>
                                                    <th scope="col" style="width: 5%">Matricola</th>
                                                    <th scope="col" style="width: 3%"><i class="fas fa-user-edit"></i></th>
                                                    <th scope="col" style="width: 3%"><i class="fas fa-trash"></i></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                     <th scope="col" style="display: none">id</th>
                                                    <th scope="col" style="width: 10%">Nome</th>
                                                    <th scope="col" style="width: 10%">Email</th>
                                                    <th scope="col" style="width: 5%">Telefono</th>
                                                    <th scope="col" style="width: 10%">Comune Nascita</th>
                                                    <th scope="col" style="width: 7%">Data Nascita</th>
                                                    <th scope="col" style="width: 7%">Prov. Res.</th>
                                                    <th scope="col" style="width: 3%" class="dt-center">Attivo</th>
                                                     <th scope="col" style="width:7%">Doc. Iden.</th>
                                                    <th scope="col" style="width: 7%">Cod. Fisc.</th>
                                                    <th scope="col" style="width: 5%">Statino</th>
                                                    <th scope="col" style="width: 7%">Tit. Studio</th>
                                                     <th scope="col" style="width: 7%">Data laurea</th>
                                                    <th scope="col" style="width: 5%">Matricola</th>
                                                    <th scope="col" style="width: 3%"><i class="fas fa-user-edit"></i></th>
                                                    <th scope="col" style="width: 3%"><i class="fas fa-trash"></i></th>
                                                </tr>
                                            </tfoot>

                                            <tbody>
                                            </tbody>
                                        </table>
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