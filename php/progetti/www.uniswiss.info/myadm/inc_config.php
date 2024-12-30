<?php
//session_cache_limiter('private, must-revalidate');
//$cache_limiter = session_cache_limiter();
//session_cache_expire(60); // in minutes
session_start();

//echo $_SERVER['DOCUMENT_ROOT']; die();
//ini_set('display_errors', '1');
//error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);

$pagename = basename($_SERVER['PHP_SELF']);


# COSTANTI
//define("BASE_PATH", '');
define("BASE_PATH", '/web/htdocs/www.uniswiss.info/home/myadm/');


define("BASE_URL", 'http://www.uniswiss.info/myadm/');
define("IMAGES_BASE_URL", BASE_URL . "images/");

define("LOGO_NAME", "Uniswiss");
//define("LOGO_NAME", "IA GEST");
define("DEBUG_MODE", true);

//define("ITALIA", '110');

# LOGIN

//**************************DATI DATABASE *****************************************//
define("DB_HOST", '89.46.111.177');
define("DB_NAME", 'Sql1415597_4');
define("DB_USER", 'Sql1415597');
define("DB_PW", 'b3jg06w44x');
//***************************************************************//
# CONNESSIONE a DB PDO
require_once ("classe_Database.php");
$db = new Database(DB_HOST, DB_USER, DB_PW, DB_NAME);
//***************************************************************//

# LINGUA                              
// if (isset($_REQUEST['setlng'])) {
//     unset($_SESSION['lng']);
//     switch ($_REQUEST['setlng']) {
//         case 'it':
//             $_SESSION['lng'] = 'it';
//             break;
//         default:
//             $_SESSION['lng'] = 'it';
//     }
// }

// if (!isset($_SESSION['lng'])) {
    $_SESSION['lng'] = 'it';
    $lng = $_SESSION['lng'];
// } else {
//     $lng = $_SESSION['lng'];
// }

// require("lang_" . $lng . ".php");
//***************************************************************//    

if (isset($_REQUEST['logout'])) {
    if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])) {
        setcookie("cookname", "", time() - 60 * 60 * 24 * 100, "/");
        setcookie("cookpass", "", time() - 60 * 60 * 24 * 100, "/");
    }
    session_unset();
    session_destroy();
    header("Location: index.php");
}

setlocale(LC_MONETARY, 'it_IT');


$vettexclude=array("login.php","stampa_cert_esempio.php","stampa_cert.php");

if(!in_array($pagename,$vettexclude)){
//SE LA SESSIONE è SCADUTA ESCO
if (!isset($_SESSION['user'])){ header("Location: ".BASE_URL."login.php");}
}
function sistemadata($cdate){
        list($day,$month,$year)=explode("/",$cdate);
        return $year."-".$month."-".$day;
} 
?>