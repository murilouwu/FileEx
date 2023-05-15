<?php
    include('config.php');
    HeaderEcho('File Explore','style.css');
?>
    <form class="modal" id="modal" method="post" enctype="multipart/form-data">
        <i onclick="oclModal('#modal', 0)" class="iconModal fa-solid fa-circle-xmark"></i>
        <div class="modalCenter" id="modalCenter">
            
        </div>
        <input type="submit" class="btnModal" value="Criar" name="env">
    </form>
    <div class="legenda">
        <div class="ul"><i class="icon fa-solid fa-file"></i> Arquivo</div>
        <div class="ul"><i class="icon fa-solid fa-solid fa-image"></i> Imagem</div>
        <div class="ul"><i class="icon fa-solid fa-film"></i> Video</div>
        <div class="ul"><i class="icon fa-solid fa-volume-off"></i> Audio</div>
        <div class="ul"><i class="icon fa-solid fa-cube"></i> Objeto 3D</div>
        <div class="ul"><i class="icon fa-solid fa-desktop"></i> Web Page</div>
        <div class="ul"><i class="icon fa-regular fa-file-lines"></i> Documento</div>
        <div class="ul"><i class="fa-solid fa-file-code"></i> Código</div>
        <div class="ul"><i class="icon fa-solid fa-file-zipper"></i> Compactado</div>
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
                    }else if(in_array($ext, $exts[3])){
                        $icon = 'fa-solid fa-cube';
                    }else if(in_array($ext, $exts[4])){
                        $icon = 'fa-solid fa-desktop';
                    }else if(in_array($ext, $exts[5])){
                        $icon = 'fa-regular fa-file-lines';
                    }else if(in_array($ext, $exts[6])){
                        $icon = 'fa-regular ';
                    }else if(in_array($ext, $exts[7])){
                        $icon = 'fa-regular ';
                    }else{
                        $icon = 'fa-solid fa-file';
                    }
                }
            }
            $TextFin = $file != '..'? ($icon!='fa-solid fa-file'? 
                                            '
                                                <div class="linha" onclick="ulOnclick(this)">
                                                    <input type="checkbox" id="'.$past.'/'.$file.'">
                                                    <i class="icon '.$icon.'"></i>
                                                    <label>'.$nmFile.'</label>
                                                    <a class="btn" href="ex.php?past='.$past.'/'.$file.'&pastDad='.$past.'">Excluir</a>
                                                    <a class="btn" href="rename.php?past='.$past.'/'.$file.'&pastDad='.$past.'&name='.$file.'">Renomear</a>
                                                    <a class="btn" href="index.php?past='.$past.'/'.$file.'">Abrir</a>
                                                    <a class="btn" href="duplic.php?past='.$past.'/'.$file.'&pastDad='.$past.'&name='.$file.'">Duplicar</a>
                                                </div>
                                            ':
                                            '
                                                <div class="linha" onclick="ulOnclick(this)">
                                                    <input type="checkbox" id="'.$past.'/'.$file.'">
                                                    <i class="icon '.$icon.'"></i>
                                                    <label>'.$file.'</label>
                                                    <a class="btn" href="ex.php?past='.$past.'/'.$file.'&pastDad='.$past.'">Excluir</a>
                                                    <a class="btn" href="rename.php?past='.$past.'/'.$file.'&pastDad='.$past.'&name='.$file.'">Renomear</a>
                                                    <a class="btn" href="index.php?past='.$past.'/'.$file.'">Abrir</a>
                                                    <a class="btn" href="duplic.php?past='.$past.'/'.$file.'&pastDad='.$past.'&name='.$file.'">Duplicar</a>
                                                </div>
                                            '
                                        )
            :'
                <div class="linha">
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
    <script>
        $('#modalCenter').on('change', '#UploadFile', function() {
            let label = document.querySelector('#labInputFile');
            label.innerHTML = 'Arquivo enviado';
            label.setAttribute("for", null);
            label.classList.add('label-hover');
            label.classList.remove('lbM');
        });
    </script>
<?php
    footEcho();
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
            move('index.php');
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
            move('index.php');
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
                move('index.php');
            } else {
                mensage('Arquivo inválido');
            }
        }
    }
?>
