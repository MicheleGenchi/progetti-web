<?php include("include/head.php"); ?>

<body>
  <?php //HEADER 
  ?>
  <div class="header-white">
    <div class="container">
        <div class="row">
        <div class="col-md-6 col-6">
          <img src="images/logook.jpg" class="logo" alt="Libera Università Svizzera">
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
      <div class="row" id="main-menu">
      <div class="col-md-12 col-12">
      <center><?php include("include/menu.php"); ?></center>
      </div>
      </div>
    </div>
  </div>
 <div class="col-md-13 col-13" id="menu-canva-toggle"><?php include("include/menu-canva.php") ?></div>
  <?php include("include/hero.php"); ?>
  <?php //PLUS 
  ?>
  <section class="servizi">
    <div class="container text-center">
      <div class="intro">
        <h2>Offerta formativa</h2>
        <p>Offerta formativa completa laurea e post laurea</p>
      </div>
      <div class="row">
        <div class="col-md-3 text-center br-30">
          <img src="images/icn-corsilaurea.svg" width="80" alt="">
          <p>Corsi di Laurea</p>
        </div>
        <div class="col-md-3 text-center br-30">
          <img src="images/icn-corsiperfezionamento.svg" width="80" alt="">
          <p>Corsi di perfezionamento</p>
        </div>
        <div class="col-md-3 text-center">
          <img src="images/icn-specializzazione.svg" width="80" alt="">
          <p>Scuole di specializzazione</p>
        </div>
        <div class="col-md-3 text-center">
          <img src="images/icn-learning.svg" width="80" alt="">
          <p>Risorse per l'e-learning</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 text-center br-30">
          <img src="images/icn-master.svg" width="80" alt="">
          <p>Master</p>
        </div>
        <div class="col-md-3 text-center br-30">
          <img src="images/icn-pubblicazioni.svg" width="80" alt="">
          <p>Pubblicazioni</p>
        </div>
        <div class="col-md-3 text-center">
          <img src="images/icn-dottorato.svg" width="80" alt="">
          <p>Dottorati</p>
        </div>
        <div class="col-md-3 text-center">
          <img src="images/icn-conferenza.svg" width="80" alt="">
          <p>Convegni</p>
        </div>
      </div>
      <p class="benefit">Siamo gemellati con Università di Malta, Università di Londra, Università di Dubai e Università di Albania</p>
      <div class="col-md-3 text-center" style="border: 1px solid #fff; border-radius:10px; width: fit-content; margin: auto; padding: 10px 10px 0 10px;"
      style="background:red">
        <a style="color:#fff; text-decoration: none; " href="i-nostri-master.php"><p>Vedi i nostri master</p></a>
      </div>
    </div>
  </section>

  <div class="container"><a name="chisiamo"><?php include("include/chi_siamo.php"); ?></a></div>
        
  <?php //CORSI FORMAZIONE
  ?>
  <link rel="stylesheet" href="css/elenco.css">
  <section class="come">
    <div class="container">
      <div class="intro">
        <a name="corsiprofessionali"></a>
        <h2 class="mb-3">I nostri corsi di Laurea</h2>
      </div>
      <div class="elenco">
        <div class="voce_elenco">
          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Corso di Laurea (online) in Scienze economiche e della gestione aziendale (Economics and Business Organizations)</h2>
          <div class="risposta"><?php include("include/corso-economia.php"); ?></div>
        </div>
        <div class="voce_elenco">
          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Corso di Laurea (online) in Scienze Giuridiche e dell'Organizzazione</h2>
          <div class="risposta"><?php include("include/corso-giurisprudenza.php"); ?></div>
        </div>
        <div class="voce_elenco">
          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Corso di Laurea (online) in Management e Internazionalizzazioni</h2>
          <div class="risposta"><?php include("include/corso-management.php"); ?></div>
        </div>
        <div class="voce_elenco">
          <h2 class="domanda segno" data-switch="close" onclick="expand(this,'data-switch')">&nbsp;Corso di Laurea Triennale (online) in Ingegneria Civile</h2>
          <div class="risposta"><?php include("include/corso-ingegneria.php"); ?></div>
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

<style>
#main-menu {
      display:block;
}
#menu-canva-toggle {
      dispaly:none;	
}
.docenti-studenti {
          margin:5% auto 5% auto;
}

.docenti-studenti>div.row>div:not(div.no-shadow) {
         box-shadow: 0px 3px 6px black;
}

.docenti-studenti img {
        margin-top:20px;
}

.docenti-studenti  a {
         display:inline-block;	
         text-decoration:none;
         min-width:100%;	
}
.docenti-studenti>div.row>div:hover {
        opacity:0.8;
}

          #menu-toggle {
                   display:none;
                   color:black; 
          }	
          #menu-canva-toggle {
             display:none;  
       }

@media screen and (max-width: 992px) {
           .docenti-studenti div{
	display:block;
	min-width:80%;	
	margin:2% auto 2% auto;
           }  
          #menu-canva-toggle {
                   display:block;
                   color:black; 
          }	
          #main-menu {
                   display:block;	
         }
}

</style>
<div class="container docenti-studenti">
      <div class="row">
        <div class="col-md-5 col-5" onclick="myhref('/i-docenti.php');" style="background-image:url('images/corpo-docenti.jpg'); background-color:white; width:100%; height:400px">
	<h1>I nostri docenti</h1>
        </div>
<script type="text/javascript">
    function myhref(web){
      window.location.href = web;}
</script>
        <div class="col-md-1 col-1 no-shadow">
       </div>
        <div class="col-md-5 col-5" onclick="myhref('/studenti.php');" style="background-image:url('images/didattica.jpeg'); background-color:white; width:100%; height:400px">
	<h1>I nostri studenti</h1>
        </div>
<script type="text/javascript">
    function myhref(web){
      window.location.href = web;
}
</script>
      </div>
</div>	
  <div class="container-fluid scarica-certificato">
    <div class="text-center">
      <img src="images/icn-pubblicazioni.svg" alt="" class="img-fluid" width="80">
    </div>
    <h2 class="text-center"> Matricola </h2>
    <div class="container">
      <div class="form">
        <div class="row justify-content-md-center">
          <div class="col-md-8 form-int">
            <h3> Convalida titolo richiedi copia smarrimento </h3>
                <form id="MatricolaForm" class="mt-3" action="javascript:void(null)" method="post">
                  <div class="row mb-3">
                    <div class="col-md-12 mar-bot">
                      <input id="certificato" name="certificato" type="text" class="form-control" placeholder="Inserisci il tuo numero di Matricola" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ck_cond_privacy" type="checkbox" required>
                        <small> Ho letto e sono d 'accordo con la Tutela della Privacy </small>
                      </label>
                    </div>
                  </div> <button type="submit" class="mt-3 btn btn-lg btn-block btn-lg"> VERIFICA MATRICOLA </button>
                  <div id="controllo" class="mt-3">
                  </div>
                </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php //FORM ?>
  <a name="contatti"><?php include("include/form.php"); ?></a>
  <?php //FOOTER ?>
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
</body>
