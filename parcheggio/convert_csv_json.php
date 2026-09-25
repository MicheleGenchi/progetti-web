<?php

class via
{
    public $id;
    public $via;
    public $da;
    public $a;
}

class Giorno
{
    public $giorno;
    public array $vie;
}

$csvData = file_get_contents("fileout.csv");
$array = array_map("str_getcsv", explode("\n", $csvData));
$json = [];
//print_r($array);
$json = [];
foreach ($array as $i => $data) {
    $giorno = new Giorno();
    $giorno->giorno=$data[0];
    $giorno->vie=[];
    $conta = 0;
    $via = new Via();
    foreach ($data as $x => $value) {
        if ($conta == 1) {
            //print_r(['id' => $value]);
            $via->id = $value;
        }
        if ($conta == 2) {
            //print_r(['esercizio' => $value]);
            $via->via = $value;
        }
        if ($conta == 3) {
            //print_r(['serie' => $value]);
            $via->da = $value;
        }
        if ($conta == 4) {
            //print_r(['ripetizioni' => $value]);
            $via->a = $value;
            //print_r($single_esercizio);
            array_push($giorno->vie, $via);
            $via = new Via();
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
