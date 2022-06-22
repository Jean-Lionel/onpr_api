<?php  

function direBonjour(){

	$startTime = time();

	$i = 1;
	for ($i=0; $i < 50000; $i++) { 
		// code...
		$i += 1;
	}

	$endTime = time();

	return 'TEMPS PASSE : '.($endTime - $startTime) . ' La valeur de i = '.	$i;
}