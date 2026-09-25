<style>
nav#menu-canva {
           display:none;
}

nav#main-menu ul {
       background-color:white;
  }

nav#main-menu  ul#menu {
    display:inline-block;
    font-family: Verdana, sans-serif;
    font-size: 18px;
    margin: 0;
    padding: 0;
    list-style: none;
}

nav#main-menu ul#menu li {
    display: block;
    height: 30px;
    margin: 2px;
    padding-left:10px;
    padding-right:10px;
    float: left; /* elementi su singola riga */
}

nav#main-menu ul#menu li a {
    color:black;
    text-decoration: none;
}

nav#main-menu ul#menu li.active, nav#main-menu ul#menu li:hover {
    border-bottom: 5px solid red;
    font-weight: bold;
}

nav#main-menu ul#menu li ul {
	margin:0;
	padding:0;
	display:inline-block;
	list-style: none;
	opacity: 0;
	visibility: hidden;
	position: absolute;
	top: 36px;
	left: 0;
	z-index:9999;
    background-color: white;
	-webkit-transition: all 0.6s ease;
	-moz-transition: all 0.6s ease;
	-ms-transition: all 0.6s ease;
	-o-transition: all 0.6s ease;
	transition: all 0.6s ease;
	text-align:left;
}

nav#main-menu ul#menu li ul li {
    float:none;
    font-weight: 300;
}

nav#main-menu  ul#menu li#chi-siamo:hover>ul
{
	display:block;
	opacity: 1;
	visibility: visible;
	list-style: none;
                     font-weight: bold;
                     top: 36px;
	left: 370px;
	z-index:9999;
}

nav#main-menu  ul#menu li#corsi:hover>ul
{
	display:block;
	opacity: 1;
	visibility: visible;
	list-style: none;
                     font-weight: bold;
                     top: 36px;
	left: 450px;
	z-index:9999;
}

nav#main-menu  ul#menu li#docenti:hover>ul {
	display:block;
	opacity: 1;
	visibility: visible;
	list-style: none;
                     font-weight: bold;
                     top: 65px;
	left: 120px;
	z-index:9999;
}

@media screen and (max-width: 992px) {
  nav#main-menu {
           display:none;
}	
}

</style>
<nav id="main-menu">
    <ul id="menu">
        <li><a href="/">Home</a></li>
        <li id="chi-siamo"><a href="/#chi-siamo">Chi siamo</a>
            <ul>
                <li><a href="/la-mission.php">La mission</a></li>
                <li><a href="/didattica.php">Didattica</a></li>
                <li id="docenti"><a href="/i-docenti.php">I docenti</a>
	                <ul>
                        <li><a href="/i-nostri-gruppi.php">I&nbsp;nostri&nbsp;gruppi</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li id="corsi"><a href="/#corsiprofessionali">Corsi</a>
            <ul>
                <li><a href="/i-nostri-master.php">alta-formazione</a></li>
            </ul>    
        </li>
        <li><a href="/i-nostri-master.php">Master</a></li>
        <li><a href="/studenti.php">Studenti</a></li>
        <li><a href="/#contatti">Contatti</a></li>
    </ul>
</nav>
