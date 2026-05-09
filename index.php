<?php
	include('./includes/config.inc.php');
	$oldal = $_GET['oldal'] ?? ''; 

	if ($oldal != "") {
		// Így már csak a 'crud' kulcsot fogja keresni a tömbben
		if (isset($oldalak[$oldal]) && file_exists("./templates/pages/{$oldalak[$oldal]['fajl']}.tpl.php")) {
			$keres = $oldalak[$oldal];
		}
		else { 
			$keres = $hiba_oldal;
			header("HTTP/1.0 404 Not Found");
		}
	}
	else $keres = $oldalak['/'];
	include('./templates/index.tpl.php'); 
?>
