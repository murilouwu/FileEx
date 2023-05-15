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