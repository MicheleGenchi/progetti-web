<!DOCTYPE html>
<head>

</head>
<style>
    .form_prenota 
        { display:none;};
</style>
<body>
<form class="form_prenota" method="get" action="/prenota">
	<input type="hidden" name="veicolo" value="'.get_the_title().'" />
	<input type="hidden" name="prezzoGG" value="'.$prezzoGG.'" />
	<label for="inizio">Inizio Noleggio:</label>
	<input type="date" name="inizio" value="" min="'.<?=date("Y-m-d",strtotime("now+1 day"));?>.'"><br>
	<label for="fine">Fine Noleggio:</label>
	<input type="date" name="fine" value="" min="'.<?=date("Y-m-d",strtotime("now+1 day"));?>.'"><br>
	<input type="submit" value="Prenota">
</form>
</body>
