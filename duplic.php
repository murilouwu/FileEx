<?php
	include('config.php');
	if(isset($_GET["past"])){
	    $past = $_GET["past"];
	}
	if(isset($_GET["pastDad"])){
	    $pastDad = $_GET["pastDad"];
	}
	if(isset($_GET["name"])){
	    $name = $_GET["name"];
	}
    
	clone_file($past, $pastDad, $name);

	moveLink($pastDad);
?>