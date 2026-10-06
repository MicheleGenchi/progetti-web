<?php include("include/head.php"); ?>



<body>

  <?php //HEADER 

  ?>

  <div class="header-white">

    <div class="container">

      <div class="row">

        <div class="col-md-6 col-6">

          <a href="/"><img src="images/logook.jpg" class="logo" alt="Libera Università Svizzera"></a>

        </div>

        <div class="col-md-6 col-6 text-right assistant">

          <a class="chiama hidden-mob" href="mailto:info@uniswiss.info">

            <i class="fa fa-envelope icn"></i> info@uniswiss.info

          </a>

          <a class="chiama" href="tel:800173063">

            <i class="fa fa-phone icn"></i> <span class="hidden-mob">800173063</span>

          </a>

        </div>

      </div>

      <div class="row">

      <div class="col-md-12 col-12">

      <center><?php include("include/menu.php"); ?></center>

      </div>

      </div>

    </div>

  </div>

  <style>

    .obliquo {



      -webkit-transform: rotate(-20deg);



      -moz-transform: rotate(-20deg);



      -o-transform: rotate(-20deg);



      -ms-transform: rotate(-20deg);



      transform: rotate(-20deg);

    }



    h1 {

      font-size:58px;

    }



    .intro>p {

      text-align:left;

      font-size:22px!important;

      line-height:1.5!important;

    }

    h2 {

        margin-top:50px;

        text-align: center;

        margin-bottom:20px;

    }    

</style>

  </style>

  <div style="background-image:url('images/Diritto-del-lavoro.png'); background-color:white; width:100%; height:400px">

    <h1 class="obliquo">Master ed Alta formazione</h1>

  </div>

  <?php //ELENCO MASTER 

  ?>

  <link rel="stylesheet" href="css/elenco.css">

  <section class="come">

    <div class="container">

      <div class="intro">

        <h2 class="mb-3">I nostri Master</h2>

        <p>

          I nostri corsi sono concepiti per offrire conoscenze accademiche avanzate in grado di rispondere alle esigenze 

          dei professionisti in cerca di formazione specialistica e aggiornamento.<br> 

          Le nozioni fornite sono fortemente ricercate nei profili dirigenziali che richiedono elevati livelli di istruzione 

          e responsabilità. I nostri corsi offrono infatti a ragazzi e ragazze neolaureati o a giovani professionisti 

          programmi di perfezionamento in tutte le aree formative di potenziale interesse per futuri manager, ricercatori, 

          professionisti, docenti, artisti.<br> 

          Anche uomini e donne con una carriera già avviata possono decidere di diventare allievi di questi master, 

          per acquisire sempre nuove competenze che diano loro opportunità di crescita professionale.<br>

          Gli studenti possono contare su una solida preparazione accademica unita a esercitazioni pratiche, 

          project work ed esperienze dirette di lavoro sul campo. 

          In alcuni casi è possibile seguire parte delle lezioni in web o in presenza presenti anche in altre nazioni, 

          per unire all’alta formazione anche un arricchimento culturale e personale. 

        </p>

      </div>

      <div class="elenco">

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Mobility Management</h2>

          <div class="risposta"><?php include "include/master/mobility-management.php"; ?></div>

        </div>

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Analisi economico Finanziaria PMI</h2>

          <div class="risposta"><?php include "include/master/analisi-economico-finanziaria-pmi.php"; ?></div>

        </div>

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Master in antiriciclaggio cft & compliance</h2>

          <div class="risposta"><?php include "include/master/master-in-antiriciclaggio-cft&compliance.php"; ?></div>

        </div>

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Corso beni culturali</h2>

          <div class="risposta"><?php include "include/master/corso-beni-culturali.php"; ?></div>

        </div>

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Finanza comportamentale</h2>

          <div class="risposta"><?php include "include/master/finanza-comportamentale.php"; ?></div>

        </div>

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Corso di risorse umane</h2>

          <div class="risposta"><?php include "include/master/risorse-umane.php"; ?></div>

        </div>

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Master in diritto bancario europeo</h2>

          <div class="risposta"><?php include "include/master/economia-europea.php"; ?></div>

        </div>

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Innovazione finanziaria e fintech</h2>

          <div class="risposta"><?php include "include/master/Innovazione-finanziaria-fintech.php"; ?></div>

        </div>

        <div class="voce_elenco">

          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Finanziamenti agevolati, imprese e autoimprenditorialità</h2>

          <div class="risposta"><?php include "include/master/finanziamenti-autoimprenditorialita.php"; ?></div>

        </div>

      </div>

    </div>

  </section>

  <script>

    prec_domanda = null;

    prec_risposta = null;



    function expand(e, attrname) {

      console.log(e.getAttribute(attrname));

      if (e != null) {

        if (e.getAttribute(attrname) === "close") {

          if (prec_risposta != null) {

            prec_domanda = e.getAttribute(attrname);

            prec_risposta.style.display = "none";

          }

          e.setAttribute(attrname, 'open');

          e.nextElementSibling.style.display = "block";

          prec_domanda = e;

          prec_risposta = e.nextElementSibling;

        } else {

          e.nextElementSibling.style.display = "none";

          e.setAttribute(attrname, 'close');

          prec_domanda = null;

          prec_risposta = null;

        }

      } else {

        alert("Errore!");

      }

    }

  </script>



  <?php //FOOTER 

  ?>

  <footer class="page-footer">

    <div class="container text-center">

      <img src="images/logook.jpg" class="logo img-fluid">

      <p class="copy"> ©Università Degli Studi Svizzera <br>

        Sede Sociale: Chiasso ch - 6830(Switzerland) <br>

        registrato al registro di commercio del Canton Ticino CH <br>

      </p>

    </div>

  </footer>

  <div class="fixed-bottom fissa-cta">

    <div class="container">

      <div class="row">

        <div class="col-6 text-center">

          <a class="whatsapp2" href="mailto:info@uniswiss.info">

            <i class="fas fa-envelope">

            </i> Email </a>

        </div>

        <div class="col-6 text-right">

          <a class="chiama2" href="tel:800173063">

            <i class="fas fa-phone">

            </i> 800173063 </a>

        </div>

      </div>

    </div>

  </div>

  <?php include("include/library.php"); ?>