<?php

class Esercizio
{
    public $id;
    public $esercizio;
    public $serie;
    public $ripetizioni;
}

class Giorno
{
    public $giorno;
    public array $esercizi;
}


$csvData = file_get_contents("fileout.csv");
$array = array_map("str_getcsv", explode("\n", $csvData));
//print_r($array);
$json = [];
foreach ($array as $i => $data) {
    $giorno = new Giorno();
    $giorno->giorno=$data[0];
    $giorno->esercizi=[];
    $conta = 0;
    $single_esercizio = new Esercizio();
    foreach ($data as $x => $value) {
        if ($conta == 1) {
            //print_r(['id' => $value]);
            $single_esercizio->id = $value;
        }
        if ($conta == 2) {
            //print_r(['esercizio' => $value]);
            $single_esercizio->esercizio = $value;
        }
        if ($conta == 3) {
            //print_r(['serie' => $value]);
            $single_esercizio->serie = $value;
        }
        if ($conta == 4) {
            //print_r(['ripetizioni' => $value]);
            $single_esercizio->ripetizioni = $value;
            //print_r($single_esercizio);
            array_push($giorno->esercizi, $single_esercizio);
            $single_esercizio = new Esercizio();
            $conta=0;
        }
        $conta++;
    }
    array_push($json, $giorno);
}

$file = fopen('fileout.json', 'w');
fwrite($file, json_encode($json,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
print_r('Converted Successfully');

fclose($file);


