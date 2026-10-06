<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
  .menu-canva * {
    font-size: 28px;
  }

  .menu-canva a:hover {
    font-weight: bold;
  }

  .menu-canva .custom {
    color: black !important;
    font-weight: 300;
  }

  .menu-canva li.nav-item.dropdown>ul>li.nav-item.dropdown>a {
    margin-left: 22px;
  }

  .menu-canva li.nav-item.dropdown>ul>li.nav-item.dropdown:hover {
    background-color: #f8f9fa;
  }

  .menu-canva #Dropdown2.hide {
    display: none;
  }

  .menu-canva #Dropdown2.visible {
    display: block;
  }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid menu-canva">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Chi siamo
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/chi-siamo.php">Chi siamo</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="/la-mission.php">La missione</a></li>
            <li><a class="dropdown-item" href="/didattica.php">Didattica</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle custom" href="#" id="navbarDropdown2" aria-expanded="false">
                Docenti
              </a>
              <ul class="dropdown-menu hide" aria-labelledby="navbarDropdown" id="Dropdown2">
                <li><a class="dropdown-item" href="/i-docenti.php">Docenti</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/i-nostri-gruppi.php">Gruppi</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Corsi
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/#corsiprofessionali">Corsi</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="/i-nostri-master.php">Alta formazione</a></li>
            <li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="/i-nostri-master.php">Master</a></li>
        <li class="nav-item"><a class="nav-link" href="/studenti.php">Studenti</a></li>
        <li class="nav-item"><a class="nav-link" href="/#contatti">Contatti</a></li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var maindrop = document.getElementById("navbarDropdown");
    var drop = document.getElementById("navbarDropdown2");
    drop.addEventListener("click", function(event) {
      var dropnext = document.getElementById("Dropdown2");
      //verificare se l'ul che sta dopo "navbarDropdown2"  è visibile
      if (dropnext.classList.contains('hide')) {
        dropnext.classList.remove('hide');
        dropnext.classList.add('visible');
      } else {
        dropnext.classList.remove('visible');
        dropnext.classList.add('hide');
      }
      event.stopPropagation();
    });
  });
</script>