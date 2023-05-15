<?php
	if(isset($_GET["past"])){
	    $past = $_GET["past"];
	}
	if(isset($_GET["pastDad"])){
	    $pastDad = $_GET["pastDad"];
	}
	if(isset($_GET["name"])){
	    $name = $_GET["name"];
	}
	include('config.php');
    HeaderEcho($past,'style.css');
    $ext = pathinfo($name, PATHINFO_EXTENSION);
?>
	<form class="formRename" method="post">
		<input type="text" name="oldName" value="<?php echo $past?>" class="ocultar">
		<input type="text" name="past" value="<?php echo $pastDad?>" class="ocultar">
		<label class="labelRename">
			Antigo nome: <?php echo $name?>
		</label>
		<input type="text" name="NewName" class="inputRename" placeholder="Novo Nome" minlength="1" maxlength="150">
		<input type="text" name="NewExt" class="inputRename" placeholder="extenção ex:png" minlength="1" maxlength="7" value="<?php echo $ext?>">
		<input type="submit" name="env" class="envRename" value="Renomear">
	</form>
<?php
    if(isset($_POST['env'])){
    	$oldName = $_POST['oldName'];
    	$folder = $_POST['past'];
    	$newName = $_POST['NewName'];
    	$ext = pathinfo($newName, PATHINFO_EXTENSION);

    	if (empty($ext)) {
    		if(is_dir($oldName)){
    			$nmFinal = $folder.'/'.$newName;
    			renameFolder($oldName, $nmFinal);
    			
    			moveLink($folder);
    		}else{
    			$extNew = 'a.'.$_POST['NewExt'];
		        if(!empty(pathinfo($extNew, PATHINFO_EXTENSION))){
		        	$nmFinal = $folder.'/'.$newName.'.'.$_POST['NewExt'];
					rename($oldName, $nmFinal);

					moveLink($folder);
				} else {
					mensage('Coloque uma extenção Real!!'); 
				}
    		}
	    }else{
	    	mensage('Não coloque a extenção no input de nome!!');    
	    }
    }
    footEcho();
?>