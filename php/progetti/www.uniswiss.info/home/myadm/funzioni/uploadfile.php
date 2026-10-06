<?php

require("../inc_config.php");

//QUINDI ESTRAGGO DAL NOME DELL'INPUT LA COLONNA INTERESSATA

$cont=0;     
foreach ($_FILES as $key=>$file){ $cont++; if($cont==1){ $nomeinput=$key;}  }   

$parti=explode("§",$nomeinput);
$nomecol=$parti[0];     
$nometab=$parti[1];

        //Loop through each file
  
        //Get the temp file path
        $tmpFilePath = $_FILES[$nomeinput]['tmp_name'];
      

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES[$nomeinput]['name'];

                //save the url and the file
                $nomefile=strtolower(str_replace(" ","",date('d-m-Y-H-i-s').'-'.$_FILES[$nomeinput]['name']));
                $filePath = '../file/'.$parti[1].'/'.$nomefile;

//                     $filePath = 'file/'. date('d-m-Y-H-i-s').'-'.$_FILES['file_attivita']['name'];

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {
                      $arr = array("nomefile"=>$nomefile,"nomeinput"=>$nomecol);
                      echo json_encode($arr);

                }
              }
        
   






?>
