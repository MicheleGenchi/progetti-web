<?php
require("../inc_config.php");

//Se ancora non sono loggato vado al login
if ((!isset($_SESSION['user'])) ||  ($_SESSION['livello'] != "Admin" AND  $_SESSION['livello'] != "Agente") ) {
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
    "a.nome",
    "u.nome", 
    "u.email",
    "u.telefono",
    "u.piva",
    "t.nome",
    "u.attivo",
    "",
    "u.iscrizioni",
    "u.incasso",
    "",
    ""
);

// the table being queried
$table = "anagrafica_scuole u";

// any JOIN operations that you need to do
$joins = " LEFT JOIN provincia t ON u.id_provincia = t.id
           INNER JOIN anagrafica_agenti a ON u.id_agente = a.id ";

// filtering
if ($_SESSION['livello']=='Scuola') {
    $fixedWhere = " WHERE u.id= '".$_SESSION['user']."' ";
} else if($_SESSION['livello']=='Agente') {
    $fixedWhere = " WHERE u.id_agente='".$_SESSION['user']."' ";
}else {
    $fixedWhere = " WHERE 1=1 ";
}

$sql_where = " ";

if (isset($_GET['search']) && $_GET['search']['value'] != '') {
    $sql_where .= " AND (";
    $numcol = count(array_filter($columns));
    $lastCol = $numcol - 3;
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

$main_query = $db->query("SELECT u.*, a.nome AS nomeagente , t.nome AS nomeprov FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}");
// $q = "SELECT u.*, t.nome_" . $lng . " AS `tipo_professionista` FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit}";
//echo "SELECT u.*, a.nome AS nomeagente , t.nome AS nomeprov FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}";
$recordquerymain = $db->resultset($main_query);
$db->execute();

// get the number of filtered rows
$filtered_rows_query = $db->query("SELECT u.*, a.nome AS nomeagente, t.nome AS nomeprov FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order}");

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
    
    $db->query("SELECT COUNT(id) AS totale FROM studente_corso WHERE id_scuola = '".$row['id']."' ");
    $temp_iscr=$db->single();
    $num_iscr=$temp_iscr['totale'];
    
    $db->query("SELECT SUM((anagrafica_corsi.costo/studente_corso.num_rate)*studente_corso.num_rate_pagate) AS totale 
                FROM studente_corso
                INNER JOIN anagrafica_corsi ON anagrafica_corsi.id=studente_corso.id_corso
                WHERE studente_corso.id_scuola = '".$row['id']."' 
               ");
    $temp_incasso=$db->single();
    $incasso=$temp_incasso['totale'];

    //METTE L'ID SU OGNI <tr> della tabella. COME ID mette  $row['id'] che è l'id dell'utente
    // $newrow['DT_RowId'] = $row['id'];
    if($row['attivo']=='s' ){
        $active = '<i class="far fa-check-circle good" style="font-size:20px;color:green;"></i>';   
    }else{
      $active =  '<i class="fas fa-times-circle" style="color:red;font-size:20px;"></i>';
    }
    if($row['doc_identita']!='' ){
        $doc_id = '<i class="far fa-check-circle good" style="font-size:20px;color:green;"></i>';   
    }else{
       $doc_id = '<i class="fas fa-times-circle" style="color:red;font-size:20px;"></i>';
    }
    if($row['tessera_sanitaria']!='' ){
        $tess_san = '<i class="far fa-check-circle good" style="font-size:20px;color:green;"></i>';   
    }else{
        $tess_san ='<i class="fas fa-times-circle" style="color:red;font-size:20px;"></i>';
    } 
    

    $newrow[0] = $row['id'];
    $newrow[1] = $row['nomeagente'];
    $newrow[2] = $row['nome'];
    $newrow[3] = $row['email'];
    $newrow[4] = $row['telefono'];
    $newrow[5] = $row['piva'];
    $newrow[6] = $row['nomeprov'];
    $newrow[7] ='<a href="javascript:void(null)" class="deactivaten" data-stato="'.$row['attivo'].'" for="' . $row['id'] . '">' . $active . '</a>';
    $newrow[8] = '<a href="javascript:void(null)" class="send_contratto" data-email="'.$row['email'].'" for="'.$row['id'].'" title="Invia contratto di collaborazione"><i class="fas fa-file-alt" ></i></a>';
    $newrow[9]=$num_iscr;
    $newrow[10]=$incasso;
    if($_SESSION['livello']=='Admin'){ 
    $newrow[11] = '<a href="javascript:void(null)" class="ins_edit" for="'.$row['id'].'"><i class="fas fa-user-edit" style="color:#48abf7;"></i></a>';
    }else{$newrow[11] ='';}
    if($_SESSION['livello']=='Admin'){ 
    $newrow[12] = '<a href="javascript:void(null)" class="deleten" for="'.$row['id'].'"><i class="fas fa-trash" style="color:#48abf7;"></i></a>';
    }else{$newrow[12] ='';}
    

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
