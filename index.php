<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/39cab4bf95.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.js" integrity="sha256-tA8y0XqiwnpwmOIl3SGAcFl2RvxHjA8qp0+1uCGmRmg=" crossorigin="anonymous"></script>  
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>File Explore</title>
</head>
<body>
    <form class="modal" id="modal" method="post" enctype="multipart/form-data">
        <div class="modalCenter" id="modalCenter">
            
        </div>
        <input type="submit" class="btnModal" value="Criar" name="env">
    </form>
    <div class="legenda">
        <div class="ul"><i class="icon fa-solid fa-file"></i> Arquivo</div>
        <div class="ul"><i class="icon fa-solid fa-solid fa-image"></i> Imagem</div>
        <div class="ul"><i class="icon fa-solid fa-film"></i> Video</div>
        <div class="ul"><i class="icon fa-solid fa-volume-off"></i> Audio</div>
        <div class="ul"><i class="icon fa-solid fa-folder"></i> Pasta</div>
    </div>
<?php
    $past = "FolderAdm";
    if(isset($_GET["past"])){
        $past = $_GET["past"];
    }
    if(is_dir($past)){
        echo '
        <div class="tolls">
            <div class="toll" onclick="ModalOpen(0, \''.$past.'\', \'#modalCenter\')"><h3>Criar Arquivo</h3><i class="icon fa-solid fa-plus"></i></div>
            <div class="toll" onclick="ModalOpen(1, \''.$past.'\', \'#modalCenter\')"><h3>Criar Pasta</h3><i class="icon fa-solid fa-folder-plus"></i></div>
            <div class="toll" onclick=""><h3>Deletar Marcados</h3><i class="icon fa-solid fa-trash"></i></div>
        </div>
        ';
        echo '<div class="painel">';
        $exts = array(
            array('jpg', 'jpeg', 'png', 'gif'),//imagem
            array('mp4', 'avi', 'mov', 'wmv'),//video
            array('mp3', 'wav', 'ogg')//audio
        );
        $nmFile = "";
        $ext = "";
        $icon = "";
        $dir = dir($past);
        $DirPai = dirname($past);
        while(($file = $dir->read()) !== false){
            if($file == '.' || $DirPai == '.' && $file == '..') {
                continue;
            }
            if($file){
                $filePath = $past . '/' . $file;
                if (is_dir($filePath)) {
                    $nmFile = $file;
                    $icon = 'fa-solid fa-folder';
                } else {
                    $fileInfo = pathinfo($file);
                    $nmFile = $fileInfo['filename'];
                    $ext = $fileInfo['extension'];
                    if(in_array($ext, $exts[0])){
                        $icon = 'fa-solid fa-image';
                    }else if(in_array($ext, $exts[1])){
                        $icon = 'fa-solid fa-film';
                    }else if(in_array($ext, $exts[2])){
                        $icon = 'fa-solid fa-volume-off';
                    }else{
                        $icon = 'fa-solid fa-file';
                    }
                }
            }
            $TextFin = $file != '..'? ($icon!='fa-solid fa-file'? 
                                            '
                                                <div class="linha" onclick="ulOnclick(this)">
                                                    <input type="checkbox" id="'.$nmFile.'">
                                                    <i class="icon '.$icon.'"></i>
                                                    <label>'.$nmFile.'</label>
                                                    <button class="btn">Excluir</button>
                                                    <button class="btn">Renomear</button>
                                                    <a class="btn" href="index.php?past='.$past.'/'.$nmFile.'">Abrir</a>
                                                    <button class="btn">Clonar</button>
                                                </div>
                                            ':
                                            '
                                                <div class="linha" onclick="ulOnclick(this)">
                                                    <input type="checkbox" id="'.$nmFile.'">
                                                    <i class="icon '.$icon.'"></i>
                                                    <label>'.$file.'</label>
                                                    <button class="btn">Excluir</button>
                                                    <button class="btn">Renomear</button>
                                                    <a class="btn" href="index.php?past='.$past.'/'.$nmFile.'">Abrir</a>
                                                    <button class="btn">Clonar</button>
                                                </div>
                                            '
                                        )
            :'
                <div class="linha">
                    <input type="checkbox" id="'.$nmFile.'">
                    <i class="icon '.$icon.'"></i>
                    <label> <-- </label>
                    <a class="btn" href="index.php?past='.$DirPai.'">Voltar</a>
                </div>
            ';
            echo $TextFin;
        }
        $dir->close();
        echo '</div>';
    }else{

    }
?>
</body>
</html>
<?php
    function mensage($txt){
        echo '<script>alert("'.$txt.'");</script>';
    }
    function UpFile($file, $dir, $name, $ext){
        $linkF = $dir.'/'.$name.'.'.$ext;
        move_uploaded_file($file['tmp_name'], $linkF);
    }

    if(isset($_POST['env'])){
        $folder = $_POST['PastFile'];
        
        if(isset($_FILES['Upload']) && $_FILES['Upload']['size'] != 0){
            $UPFile = $_FILES['Upload'];
            $path = $UPFile['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $com = mb_strlen($path)-mb_strlen($ext) - 1;
            $nm = substr($path, 0, $com);
        
            $lp = true;
            $a = 1;
            while($lp == true){
                $filename = $folder.'/'.$nm.'.'.$ext;
                if(!file_exists($filename)){
                    UpFile($UPFile, $folder, $nm, $ext);
                    $lp = false;
                }else{
                    $nm = $nm.'('.$a.')';
                    $a++;
                    continue;
                }
            };
        }else if(isset($_POST['NomePast'])){
            $filename = $folder.'/'.$_POST['NomePast'];

            $lp = true;
            $a = 1;
            while($lp == true){
                if(!file_exists($filename)){
                    mkdir(__DIR__.'/'.$filename, 0777, true);
                    $lp = false;
                }else{
                    $filename = $filename.'('.$a.')';
                    $a++;
                    continue;
                }
            };
        }else{
            $path = $_POST['Filename'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $path);

            if ($ext != '') {
                $lp = true;
                $a = 1;
                while ($lp == true) {
                    $filename = $folder.'/'.$nm.'.'.$ext;
                    if (!file_exists($filename)) {
                        file_put_contents($filename, '');
                        $lp = false;
                    } else {
                        $nm = $nm.'('.$a.')';
                        $a++;
                        continue;
                    }
                };
            } else {
                mensage('Arquivo inválido');
            }
        }
    }
?>