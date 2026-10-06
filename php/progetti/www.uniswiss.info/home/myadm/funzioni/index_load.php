<?php
require("../inc_config.php");

//Se ancora non sono loggato vado al login
if ((!isset($_SESSION['user'])) ||  ($_SESSION['livello'] != "Admin" AND  $_SESSION['livello'] != "Scuola" AND  $_SESSION['livello'] != "Agente") ) {
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
    "u.telefono",
    "u.comune_nascita",
    "u.data_nascita",
    "t.nome",
    "u.attivo",
    "u.doc_identita",
    "u.cod_fiscale",
    "u.statino_esami",
    "u.titolo_studio",
    "u.data_laurea",
    "u.matricola",
    "",
    ""
);

// the table being queried
$table = "anagrafica_studenti_swiss u";

// any JOIN operations that you need to do
$joins = " LEFT JOIN provincia t ON u.id_provincia = t.id ";

// filtering

 $fixedWhere = " WHERE 1=1 ";


$sql_where = " ";

if (isset($_GET['search']) && $_GET['search']['value'] != '') {
    $sql_where .= " AND (";
    $numcol = count(array_filter($columns));
    $lastCol = $numcol - 6; 
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
} else $sql_order = ' ORDER BY `data_registrazione` DESC ';

// paging
$sql_limit = "";
if (isset($_GET['start']) && $_GET['length'] != '-1') {
    $sql_limit = " LIMIT " .  intval($_GET['start'])  . ", " .  intval($_GET['length']);
}

$main_query = $db->query("SELECT u.*, t.nome AS nomeprov FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}");
// $q = "SELECT u.*, t.nome_" . $lng . " AS `tipo_professionista` FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit}";
//echo "SELECT u.*, t.nome AS nomeprov, s.nome AS nomescuola FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order} {$sql_limit}"; die();
$recordquerymain = $db->resultset($main_query);
$db->execute();

// get the number of filtered rows
$filtered_rows_query = $db->query("SELECT u.*, t.nome AS nomeprov FROM {$table} {$joins} {$fixedWhere} {$sql_where} {$sql_order}");

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
    
    $db->query("SELECT COUNT(id) AS totale FROM studente_corso WHERE id_studente = '".$row['id']."' ");
    $temp_iscr=$db->single();
    $num_iscr=$temp_iscr['totale'];
    
   

    //METTE L'ID SU OGNI <tr> della tabella. COME ID mette  $row['id'] che è l'id dell'utente
    // $newrow['DT_RowId'] = $row['id'];
    if($row['attivo']=='s' ){
        $active = '<i class="far fa-check-circle good" style="font-size:20px;color:green;"></i>';   
    }else{
      $active =  '<i class="fas fa-times-circle" style="color:red;font-size:20px;"></i>';
    }

    if($row['doc_identita']!='' ){
        $docin = '<a href="'.BASE_URL.'file/studenti/'.$row['doc_identita'].'" target="_blank" > 
            <i class="la flaticon-file" style="font-size:20px;color:blue;"></i>
            </a>';   
    }else{
        $docin ='<i class="fas fa-times-circle" style="color:red;font-size:20px;"></i>';
    } 

    
    if($row['cod_fiscale']!='' ){
        $codfisc = '<a href="'.BASE_URL.'file/studenti/'.$row['cod_fiscale'].'" target="_blank" > 
            <i class="la flaticon-file" style="font-size:20px;color:blue;"></i>
            </a>';   
    }else{
        $codfisc ='<i class="fas fa-times-circle" style="color:red;font-size:20px;"></i>';
    }
    
       if($row['statino_esami']!='' ){
        $statino_esami = '<a href="'.BASE_URL.'file/studenti/'.$row['statino_esami'].'" target="_blank" > 
            <i class="la flaticon-file" style="font-size:20px;color:blue;"></i>
            </a>';   
    }else{
        $statino_esami ='<i class="fas fa-times-circle" style="color:red;font-size:20px;"></i>';
    }
    
    $newrow[0] = $row['id'];
    $newrow[1] = $row['nome'];
    $newrow[2] = $row['email'];
    $newrow[3] = $row['telefono'];
    $newrow[4] = $row['comune_nascita'];
    $newrow[5] = date('d/m/Y',strtotime($row['data_nascita']));
    $newrow[6] = $row['nomeprov'];
    $newrow[7] ='<a href="javascript:void(null)" class="deactivaten" data-stato="'.$row['attivo'].'" for="' . $row['id'] . '">' . $active . '</a>';
    $newrow[8]=$docin;
    $newrow[9]=$codfisc;
    $newrow[10]=$statino_esami;
    $newrow[11]=$row['titolo_studio'];
    $newrow[12] = date('d/m/Y',strtotime($row['data_laurea']));
    $newrow[13] = $row['matricola'];
    //if($_SESSION['livello'] == "Admin"){
    $newrow[14] = '<a href="javascript:void(null)" class="ins_edit" for="' . $row['id'] . '"><i class="fas fa-user-edit" style="color:#48abf7;"></i></a>';
    //}else{ $newrow[14] ='';}
   // if($_SESSION['livello'] == "Scuola"){ 
    $newrow[15] = '<a href="javascript:void(null)" class="deleten" for="' . $row['id'] . '"><i class="fas fa-trash" style="color:#48abf7;"></i></a>';
  //  }else{ $newrow[15] ='';}
    

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
