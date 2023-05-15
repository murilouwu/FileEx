<?php
    function moveLink($past){
        echo '<a href="index.php?past='.$past.'" id="click">index</a>';
        echo '
            <script>
                window.onload = ()=>{
                    let div = document.querySelector("#click");
                    div.click();
                };
            </script>
        ';
    }
    function renameFolder($source, $destination) {
        if (!is_dir($source)) {
            return false;
        }

        if (!is_writable(dirname($destination))) {
            return false;
        }

        if (is_dir($destination)) {
            return false;
        }

        if (!rename($source, $destination)) {
            return false;
        }

        $files = scandir($destination);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fileSource = $destination . DIRECTORY_SEPARATOR . $file;
            $fileDestination = $destination . DIRECTORY_SEPARATOR . str_replace($source, $destination, $fileSource);

            if (is_dir($fileSource)) {
                renameFolder($fileSource, $fileDestination);
            } else {
                rename($fileSource, $fileDestination);
            }
        }

        return true;
    }

    function rrmdir($dir) {
        if(is_dir($dir)){
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }else{
            unlink($dir);
        }
    }

    function clone_file($past, $pastDad, $name){
        $i = 1;
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $name_no_ext = pathinfo($name, PATHINFO_FILENAME);

        // Verifica se o arquivo é um diretório
        if (is_dir($past)) {
            $new_path = $pastDad . '/' . $name_no_ext . '('.$i.')';

            // Cria o novo diretório clonado
            while(file_exists($new_path)) {
                $new_path = $pastDad . '/' . $name_no_ext . '('.$i.')';
                $i++;
            }
            mkdir($new_path);

            // Copia todos os arquivos dentro do diretório clonado
            foreach(scandir($past) as $file) {
                if (!in_array($file, array(".", ".."))) {
                    clone_file($past . '/' . $file, $new_path, $file);
                }
            }
        }
        else { // Se o arquivo é um arquivo
            $new_path = $pastDad . '/' . $name_no_ext . '('.$i.')';

            // Adiciona um número no final do nome, se necessário
            while(file_exists($new_path . '.' . $ext)) {
                $new_path = $pastDad . '/' . $name_no_ext . '('.$i.')';
                $i++;
            }

            // Copia o arquivo
            copy($past, $new_path . '.' . $ext);
        }
    }

    function move($page){
        echo '<script>red("'.$page.'");</script>';
    }

    function mensage($txt){
        echo '<script>alert("'.$txt.'");</script>';
    }

    function UpFile($file, $dir, $name, $ext){
        $linkF = $dir.'/'.$name.'.'.$ext;
        move_uploaded_file($file['tmp_name'], $linkF);
    }

    function HeaderEcho($Title, $css){
        $res = '
            <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <script src="https://kit.fontawesome.com/39cab4bf95.js" crossorigin="anonymous"></script>
                    <script src="https://code.jquery.com/jquery-3.2.1.slim.js" integrity="sha256-tA8y0XqiwnpwmOIl3SGAcFl2RvxHjA8qp0+1uCGmRmg=" crossorigin="anonymous"></script>  
                    <script src="script.js"></script>
                    <link rel="stylesheet" href="'.$css.'">
                    <title>'.$Title.'</title>
                </head>
                <body>
        ';
        echo($res);
    }

    function footEcho(){
        $res = '
                </body>
            </html>
        ';
        echo($res);
    }
$exts = array(
     // Imagem 0
    array('JPG', 'JPEG', 'PNG', 'GIF', 'TIFF', 'SVG', 'BMP', 'PSD', 'AI', 'EPS', 'ICO', 'PCX', 'RAW', 'PDF', 'WEBP', 'HEIC', 'ARW', 'CR2', 'NEF', 'DNG', 'jpg', 'jpeg', 'png', 'gif', 'tiff', 'svg', 'bmp', 'psd', 'ai', 'eps', 'ico', 'pcx', 'raw', 'pdf', 'webp', 'heic', 'arw', 'cr2', 'nef', 'dng'),
    // Vídeo 1
    array('MP4', 'AVI', 'MOV', 'WMV', 'FLV', 'MKV', '3GP', 'MPEG', 'VOB', 'MPG', 'WEBM', 'RMVB', 'OGV', 'ASF', 'QT', 'MTS', 'M2TS', 'TS', 'SWF', 'AVCHD', 'mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', '3gp', 'mpeg', 'vob', 'mpg', 'webm', 'rmvb', 'ogv', 'asf', 'qt', 'mts', 'm2ts', 'ts', 'swf', 'avchd'),
    // Áudio 2
    array('MP3', 'WAV', 'FLAC', 'OGG', 'AAC', 'WMA', 'M4A', 'AMR', 'AC3', 'APE', 'AIFF', 'ALAC', 'DSF', 'DSD', 'MIDI', 'MP2', 'MPC', 'OPUS', 'RA', 'WV', 'mp3', 'wav', 'flac', 'ogg', 'aac', 'wma', 'm4a', 'amr', 'ac3', 'ape', 'aiff', 'alac', 'dsf', 'dsd', 'midi', 'mp2', 'mpc', 'opus', 'ra', 'wv'),
    // 3D 3
    array('3DS', 'MAX', 'OBJ', 'FBX', 'BLEND', 'DXF', 'DAE', 'STL', 'VRML', 'FBX', 'IGES', 'STEP', 'X_T', 'JT', 'PLY', 'SKP', 'DWG', 'IFC', 'X3D', 'U3D', '3ds', 'max', 'obj', 'fbx', 'blend', 'dxf', 'dae', 'stl', 'vrml', 'fbx','iges', 'step', 'x_t', 'jt', 'ply', 'skp', 'dwg', 'ifc', 'x3d', 'u3d'),
    // Página Web 4
    array('HTML', 'CSS', 'JS', 'PHP', 'ASP', 'JSP', 'XML', 'JSON', 'RSS', 'ATOM', 'PDF', 'XHTML', 'HTM', 'ASPX', 'CSHTML', 'SHTML', 'DHTML', 'VBHTML', 'JHTML', 'PHTML', 'html', 'css', 'js', 'php', 'asp', 'jsp', 'xml', 'json', 'rss', 'atom', 'pdf', 'xhtml', 'htm', 'aspx', 'cshtml', 'shtml', 'dhtml', 'vbhtml', 'jhtml', 'phtml'),
    // Documentos 5
    array('DOC', 'DOCX', 'PDF', 'TXT', 'ODT', 'RTF', 'XLS', 'XLSX', 'CSV', 'PPT', 'PPTX', 'ODP', 'ODS', 'ODG', 'EPS', 'AI', 'PS', 'INDD', 'QXP', 'PUB', 'doc', 'docx', 'pdf', 'txt', 'odt', 'rtf', 'xls', 'xlsx', 'csv', 'ppt', 'pptx', 'odp', 'ods', 'odg', 'eps', 'ai', 'ps', 'indd', 'qxp', 'pub'),
    // Código 6
    array('CPP', 'C', 'JAVA', 'PY', 'CS', 'JS', 'PHP', 'RUBY', 'HTML', 'CSS', 'XML', 'JSON', 'SQL', 'ASM', 'VHD', 'VHDL', 'BAS', 'SH', 'BAT', 'CMD', 'cpp', 'c', 'java', 'py', 'cs', 'js', 'php', 'ruby', 'html', 'css', 'xml', 'json', 'sql', 'asm', 'vhd', 'vhdl', 'bas', 'sh', 'bat', 'cmd'),
    // Arquivo compactado 7
    array('ZIP', 'RAR', '7Z', 'TAR', 'GZ', 'BZ2', 'CAB', 'ARJ', 'LZH', 'ISO', 'IMG', 'VHD', 'VHDX', 'WIM', 'SFX', 'Z', 'TAR.GZ', 'TAR.BZ2', 'TAR.XZ', 'LZMA', 'zip', 'rar', '7z', 'tar', 'gz', 'bz2', 'cab', 'arj', 'lzh', 'iso', 'img', 'vhd', 'vhdx', 'wim', 'sfx', 'z', 'tar.gz', 'tar.bz2', 'tar.xz', 'lzma')
);
?>