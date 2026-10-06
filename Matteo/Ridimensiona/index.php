<?php

/*
    funziona solo da riga di comando
*/
//tipo immagine
/**
 * Summary of imageCreateFromAny
 * @param mixed $myfile
 * @return GdImage|bool|resource|null
 * ritorna null se il file non esiste o se il tipo non è un'immagine
 * altrimenti ritorna l'immagine del file $myfile
 */
function imageCreateFromAny($myfile): ?\GdImage
{
    echo "\nfile = ", $myfile;
    return match (exif_imagetype($myfile)) {
        // gif
        1 => imageCreateFromGif($myfile),
        // jpg
        2 => imageCreateFromJpeg($myfile),
        // png
        3 => imageCreateFromPng($myfile),
        // bmp
        6 => imageCreateFromBmp($myfile),
        // tipo non è un imamgine ritorna null;
        default => null,
    };
}

//parametri di default per nomefile altezza ed ampiezza
$_DEFAULT = [
    'file' => 'none',
    'h' => 1000,
    'w' => 1000
];

//parametri passati da riga di comando (di default se non sono inseriti)
parse_str(implode('&', array_slice($argv, 1)), $_GET);
foreach (array_keys($_DEFAULT) as $key) {
    $_GET[$key] = array_key_exists($key, $_GET) ? $_GET[$key] : $_DEFAULT[$key];
}


if (!file_exists($_GET['file'])) {
    echo "Il file non esiste";
    exit;
}

//prametri da riga di comando
$new_width = $_GET["w"]; //1000 se non è parametrizzato
$new_height = $_GET["h"]; //1000 se non è parametrizzato
$filename = $_GET["file"]; //none se non è parametrizzato

$source = imageCreateFromAny($filename); //restituisce l'immagine di $filename
if (is_null($source)) {
    echo "\nIl tipo di file non è consentito";
    exit;
}

//popola le variabili $width,$height e $type con le proprietà dell'immagine sorgente
list($width, $height, $type) = getimagesize($filename);
echo "\nampiezza w=", $width;
echo "\naltezza h=", $height;
echo "\nnomefile=",$filename;
echo "\ntipo=",$type;

$new_image = imagecreatetruecolor($new_width, $new_height);
// Resize -> copia nella nuova immagine la vecchia immagine con le nuove dimensioni
imagecopyresized($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

switch ($type) {
    case 1:
        imagegif($new_image,'newimageresize.gif');
        break;
    case 2:
        imagejpeg($new_image, 'newimageresize.jpg');
        break; // best quality
    case 3:
        imagepng($new_image, 'newimageresize.png');
        break; // no compression
    default:
        echo '';
        break;
}

//popola le variabili $width,$height e $type con le proprietà dell'immagine destinazione
list($width, $height, $type) = getimagesize('newimageresize.jpg');
echo "\nnuova ampiezza w=", $new_width;
echo "\nnuova altezza h=", $new_height;
echo "\nnomefile=newimageresize.jpg";
echo "\ntipo=",$type;
?>