<?php
require("../inc_config.php");

//Se ancora non sono loggato vado al login
if ((!isset($_SESSION['user'])) ||  ($_SESSION['livello'] != "Admin" AND $_SESSION['livello'] != "Studente") ) {
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
    "c.nome",
    "s.nome",
    "c.durata", 
    "c.descrizione",
    "c.modulo_assicurazione",
    "",
    ""
);

// the table being queried
$table = "studente_corso u";

// any JOIN operations that you need to do
$joins = " INNER JOIN anagrafica_corsi c ON c.id=u.id_corso
           INNER JOIN anagrafica_scuole s ON s.id=u.id_scuola";

// filtering

// filtering

$fixedWhere = " WHERE u.id_studente ='".$_SESSION['user']."' ";
$sql_where = " ";

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

$main_query = $db->query("SELECT u.id AS id_iscrizione,u.sblocca_attestato, s.nome AS nomescuola, c.*, c.id AS id_corso FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}");
// $q = "SELECT u.*, t.nome_" . $lng . " AS `tipo_professionista` FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit}";
//echo "SELECT u.id AS id_iscrizione, c.*, c.id AS id_corso FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}";
$recordquerymain = $db->resultset($main_query);
$db->execute();

// get the number of filtered rows
$filtered_rows_query = $db->query("SELECT u.id AS id_iscrizione,u.sblocca_attestato,s.nome AS nomescuola, c.*, c.id AS id_corso FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order}");

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

    $newrow[0] = $row['id_iscrizione'];
    $newrow[1] = $row['nome'];
    $newrow[2] = $row['nomescuola'];
    $newrow[3] = $row['durata'];
    $newrow[4] = $row['descrizione'];
    if($row['modulo_assicurazione']!=''){
    $newrow[5] ='<a title="Scarica il modulo di assicurazione" href="'.BASE_URL.'file/corsi/'.$row['modulo_assicurazione'].'" target="_blank"><i class="fas fa-file-alt"></i></a>';
    } else {  $newrow[5] ='';}
//    $newrow[6] ='<a ';
//    if($row['sblocca_attestato']=='s'){
//    $newrow[6].= ' href="'.BASE_URL.'stampe/stampa_cert_pdf.php?val='.$row['id_iscrizione'].'" target="_blank" > ';
//    } else {
//    $newrow[6].= ' href="javascript:void(null)" target="_blank"  style="opacity:0.5"> ';    
//    }
//    $newrow[6].= ' <i class="fas fa-file-alt"></i></a>';
        $newrow[6]='';
    $newrow[7] ='<a href="javascript:void(null)" class="load_materiale" for="'.$row['id_corso'].'"><i class="fas fa-file-alt"></i></a>';


    

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
