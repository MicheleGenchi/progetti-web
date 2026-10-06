<?php

require("../inc_config.php");
//ini_set('display_errors', 1); error_reporting(E_ALL);
//QUINDI ESTRAGGO DAL NOME DELL'INPUT LA COLONNA INTERESSATA

$cont=0;     
foreach ($_FILES as $key=>$file){ $cont++; if($cont==1){ $nomeinput=$key;}  }   

$parti=explode("§",$nomeinput);
$nomecol=$parti[0];     
$id_iscrizione=$parti[1];

        //Loop through each file
  
        //Get the temp file path
        $tmpFilePath = $_FILES[$nomeinput]['tmp_name'];
      
            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES[$nomeinput]['name'];

                //save the url and the file
                $nomefile=strtolower($_FILES[$nomeinput]['name']);
                $percorso=$id_corso.'-'.$nomefile;
                $filePath = '../file/bonifici/'.$id_corso.'-'.$nomefile;
                $nome_senza_ext=pathinfo($nomefile, PATHINFO_FILENAME);

//                     $filePath = 'file/'. date('d-m-Y-H-i-s').'-'.$_FILES['file_attivita']['name'];

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {
                    
                      $db->query("INSERT INTO bonifici_iscrizioni(nome,percorso,id_iscrizione)   
                                  VALUES(:nomefile,:percorso,'".$id_iscrizione."') ");
                      $db->execute(array(  ":nomefile" => $nome_senza_ext,
                                           ":percorso" => $percorso)); 

                      $arr = array("nomefile"=>"","nomeinput"=>"");
                      echo json_encode($arr);
             
              }
        
 }





?>
