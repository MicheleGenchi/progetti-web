<?php
// procedura controllo codici
/*function controllo_codici($atts) {
	$atts = shortcode_atts(
		array(
			'codes' => ''
		), $atts, 'myshortcode' );
*/// procedura controllo codici
function controllo_codici($atts) {
    // verifica codice
    $codice=$_REQUEST['inputcode'] ?? null;	
	//codici validi
	$validators=explode(",",$atts['codes']);
	$myform="<form id='myform' method='post' action='#footer'>";
    $myform.="<input type='text' placeholder='codice transazione' id='inputcode' name='inputcode' value='".$codice."'><br>";		
	$myform.="<input type='submit' value='VERIFICA' name='verifica'>";
	$myform.="</form>";
	$out=$myform;
	//se clicco su verifica"
	if (isset($_REQUEST['verifica'])) {
		 if (!empty($codice)) {
		 	//test codici $out="<p>".json_encode($codes, JSON_PRETTY_PRINT)."</p>";
         	if (in_array($codice, $validators)) {
    			$out.="<br><div style='display:inline;'><h3 style='display:inline;vertical-align:middle'>Transazione verificata</h3>&emsp;";//<button style='width:140px;vertical-align:middle' onclick='document.getElementById('myForm').reset();'>RIPROVA</button></div>";
		 	} else {
				$out.="<br><div style='display:inline'><h3 style='display:inline;vertical-align:middle'>Transazione non verificata</h3>&emsp;";//<button style='width:140px;vertical-align:middle' onclick='document.getElementById('myForm').reset();'>RIPROVA</button></div>";
		 	}
        } else {
			$out.="<br><div style='display:inline'><h3 style='display:inline;vertical-align:middle'>Aggiungere una transazione da verificare</h3>&emsp;";	 
		}
	  }
   return $out;	
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

	<?php echo controllo_codici(['codes' => '159318603769284286,174379403168542924,146507421739050372,128096311803246865,147485295035864134,113463967081225842,184376225395048591']);	?>

</body>
</html>