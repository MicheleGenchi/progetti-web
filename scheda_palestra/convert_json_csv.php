<?php

use function PHPSTORM_META\elementType;

function getData(&$csv, $arr, $fh)
{
    if (is_array($arr)) {
        foreach ($arr as $key => $value) {
            getData($csv, $value, $fh);
            if (!is_Array($value))
                array_push($csv, $value);
        }
    }
}

$jsonData = file_get_contents(filename: "fileout.json");
$jsonDecoded = json_decode($jsonData, true); // add true, will handle as associative array    
$fh = fopen('fileout.csv', 'w');
$csv=[];
foreach ($jsonDecoded as $key => $data) {
    getData($csv, $data, $fh);
    //print_r($csv);
    fputcsv($fh,$csv);
    $csv=[];
}

fclose($fh);
print_r("\rConverted Successfully");