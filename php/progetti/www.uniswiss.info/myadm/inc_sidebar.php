<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                
               <?php  if ($_SESSION['livello'] == "Studente") { ?>
          
                <li class="nav-item <?php if ($pagename == "index.php") echo ' active'; ?>">
                    <a href="<?= BASE_URL; ?>index.php">
                        <i class="fas fa-home"></i>
                        <span>DASHBOARD</span>
                    </a>
                </li>
                   <?php }   
               
      
                if ($_SESSION['livello'] == "Admin") { ?>
                ?>
                <li class="nav-item <?php if ($pagename == "index.php")  echo ' active'; ?>">
                    <a href="<?=BASE_URL;?>index.php">
                        <i class="fas fa-user-graduate"></i>
                        <span>STUDENTI</span>
                    </a>
                </li>
      
                <?php }  ?>
             
                  <li class="nav-item">
                    <a href="<?=BASE_URL;?>?logout=1">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>LOGOUT</span>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</div>