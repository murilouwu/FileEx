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

    echo '<a href="index.php?past='.$pastDad.'" id="click">index.php</a>';
	echo '
		<script>
	        window.onload = ()=>{
	            let div = document.querySelector("#click");
	            div.click();
	        };
	    </script>
	';
?>