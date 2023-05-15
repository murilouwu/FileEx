<?php
	include('config.php');
	if(isset($_GET["past"])){
	    $past = $_GET["past"];
	}

	if (file_exists($past)){
		rrmdir($past);
	}

	if(isset($_GET["pastDad"])){
	    $pastDad = $_GET["pastDad"];
	}

	moveLink($pastDad);
?>