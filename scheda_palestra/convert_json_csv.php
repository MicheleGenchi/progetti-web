<?php
$jsonData = file_get_contents("js/esercizi.json");
$jsonDecoded = json_decode($jsonData, true); // add true, will handle as associative array    

$fh = fopen('fileout.csv', 'w');
$conta=0;
foreach ($jsonDecoded as $day => $esercizi) {
    $conta=0;
    $line[$conta]=$day;
    foreach ($esercizi as $esercizio => $data) {
      foreach ($data as $field => $value) {  
        $conta++;
        $line[$conta]=$value;
      }   
    }
    fputcsv($fh,$line);
}   
fclose($fh);
print_r('Converted Successfully');