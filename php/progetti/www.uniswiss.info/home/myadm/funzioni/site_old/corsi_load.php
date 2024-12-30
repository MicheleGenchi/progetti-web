<?php
require("../inc_config.php");

//Se ancora non sono loggato vado al login
if ((!isset($_SESSION['user'])) ||  ($_SESSION['livello'] == "Studente" ) ) {
    // header("Location:" . BASE_URL . "login.php");
    $errore = "Utente non loggato o sessione scaduta. Ricaricare la pagina.";

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();
}

// the columns to be filtered, ordered and returned
// must be in the same order as displayed in the table
$columns = array(
    "u.id",
    "u.nome",
    "u.email",
    "u.durata", 
    "u.descrizione",
    "u.costo",
    "u.attivo",
    "",
    "",
    "",
    "",
    "",
    "",
    ""
);

// the table being queried
$table = "anagrafica_corsi u";

// any JOIN operations that you need to do
$joins = "  ";
// any JOIN operations that you need to do
if($_SESSION['livello'] == "Scuola"){
$joins = "  INNER JOIN corsi_scuole cs ON cs.id_corso =u.id ";
}

// filtering

// filtering

$fixedWhere = " WHERE 1=1 ";
if($_SESSION['livello'] == "Scuola"){
$sql_where = " AND cs.id_scuola ='".$_SESSION['user']."' ";
}


if (isset($_GET['search']) && $_GET['search']['value'] != '') {
    $sql_where .= " AND (";
    $numcol = count(array_filter($columns));
    $lastCol = $numcol - 1;
    $x = 0;
    
    foreach (array_filter($columns) as $column) {
        
        if ($_GET['columns'][$x]['searchable'] == "true") {
            if ($x != $lastCol) {
                $sql_where .=  " LOWER(" . $column . ") LIKE '%" . addslashes(strtolower($_GET['search']['value'])) . "%' OR ";
            } else  $sql_where .= " LOWER(" . $column . ") LIKE '%" . addslashes(strtolower($_GET['search']['value'])) . "%' ) ";
        }
        $x++;
    }
}

// ordering
$sql_order = "";
if (isset($_GET['order']) and $_GET['order'][0]['column'] != '') {
    $columnIdx = intval($_GET['order'][0]['column']);
    $sql_order = " ORDER BY " . $columns[$columnIdx] . " " . strtoupper($_GET['order'][0]['dir']);
    //echo $sql_order;
} else $sql_order = ' ORDER `u.nome` DESC ';

// paging
$sql_limit = "";
if (isset($_GET['start']) && $_GET['length'] != '-1') {
    $sql_limit = " LIMIT " .  intval($_GET['start'])  . ", " .  intval($_GET['length']);
}

$main_query = $db->query("SELECT u.*,u.costo AS costocorso FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}");
if($_SESSION['livello'] == "Scuola"){
             $main_query = $db->query("SELECT u.*, cs.costo AS costocorso  FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}");  
}
// $q = "SELECT u.*, t.nome_" . $lng . " AS `tipo_professionista` FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit}";
//echo "SELECT u.* FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}";
$recordquerymain = $db->resultset($main_query);
$db->execute();

// get the number of filtered rows
$filtered_rows_query = $db->query("SELECT u.*,u.costo AS costocorso FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order}");
if($_SESSION['livello'] == "Scuola"){
                      $filtered_rows_query = $db->query("SELECT u.*, cs.costo AS costocorso  FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order}");  
}
$row = $db->resultset($filtered_rows_query);
$response['iTotalDisplayRecords'] = $db->rowCount($row);
//echo $response['iTotalDisplayRecords'] ."----";

// get the number of rows in total
$total_query = $db->query("SELECT u.id FROM  {$table} {$joins} {$fixedWhere}");
$row = $db->resultset($total_query);
$response['iTotalRecords'] = $db->rowCount($row);

$response['aaData'] = array();

// // this line is important in case there are no results
// $response['aaData'] = array();
foreach ($recordquerymain as $row) {
    // var_dump($row);
    $newrow = array();

    //METTE L'ID SU OGNI <tr> della tabella. COME ID mette  $row['id'] che è l'id dell'utente
    // $newrow['DT_RowId'] = $row['id'];
    if($row['attivo']=='s' ){
        $active = '<i class="far fa-check-circle good" style="font-size:20px;color:green;"></i>';   
    }else{
      $active =  '<i class="fas fa-times-circle" style="color:red;font-size:20px;"></i>';
    }

    if($row['id_utente']!=$_SESSION['user']){ 
      $newrow['DT_RowClass']='evidenzia';
    }
    $newrow[0] = $row['id'];
    $newrow[1] = $row['nome'];
    $newrow[2] = $row['email'];
    $newrow[3] = $row['durata'];
    $newrow[4] = substr($row['descrizione'],0,160)."...";
    $newrow[5] = $row['costocorso'];
    if($_SESSION['livello']=='Admin'){ 
    $newrow[6] ='<a href="javascript:void(null)" class="deactivaten" data-stato="'.$row['attivo'].'" for="'.$row['id'].'">' . $active . '</a>';
    }else {
     $newrow[6] ='';   
    }
    
    $newrow[7] ='<a href="'.BASE_URL.'stampe/stampa_cert_esempio_pdf.php?val='.$row['id'].'" target="_blank"><i class="fas fa-file-alt"></i></a>';
    
    if($row['manifesto']!=''){
    $newrow[8] ='<a href="'.BASE_URL.'file/corsi/'.$row['manifesto'].'" target="_blank"><i class="fas fa-file-alt"></i></a>';
    } else {  $newrow[8] ='';}
    if($row['contratto']!=''){
    $newrow[9] ='<a href="'.BASE_URL.'file/corsi/'.$row['contratto'].'" target="_blank"><i class="fas fa-file-alt"></i></a>';
    } else {  $newrow[9] ='';}
    if($row['modulo_assicurazione']!=''){
    $newrow[10] ='<a href="'.BASE_URL.'file/corsi/'.$row['modulo_assicurazione'].'" target="_blank"><i class="fas fa-file-alt"></i></a>';
    } else {  $newrow[10] ='';}
     if($_SESSION['livello']!='Studente'){ 
    $newrow[11] ='<a href="javascript:void(null)" class="load_materiale" for="'.$row['id'].'"><i class="fas fa-file-alt"></i></a>';
     }else{$newrow[11] ='';}
     if($_SESSION['livello']=='Admin'){ 
          $newrow[12] ='<a href="javascript:void(null)" class="ins_edit" for="'.$row['id'].'"><i class="fas fa-user-edit" style="color:#48abf7;"></i></a>'; 
     }else{
      $newrow[12] ='';   
     }
    if($_SESSION['livello']=='Admin'){ 
          $newrow[13] = '<a href="javascript:void(null)" class="deleten"  for="'.$row['id'].'"><i class="fas fa-trash" style="color:#48abf7;"></i></a> ';
     } else $newrow[13] = '';

    

    //    $newrow = array_values($newrow);
    $response['aaData'][] = $newrow;
}

// prevent caching and echo the associative array as json
// header('Cache-Control: no-cache');
// header('Pragma: no-cache');
// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
// header('Content-type: application/json');
// echo json_encode($response);

$datifinali = array(
    "draw" => isset($_GET['draw']) ?
        intval($_GET['draw']) : 0,
    "recordsTotal"    => $response['iTotalRecords'],
    "recordsFiltered" => $response['iTotalDisplayRecords'],
    "data"            => $response['aaData']
    // , "Q" => $q
);

echo json_encode($datifinali);
