<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Damocorp Spacewar : Conclusion du jeu</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<?php
$nbLines = 0;
$nbrPage = 0;
$nbrCaractere = 0;
$nbrImg = 0;
$arrayImg = array('gif','jpg','jpeg','png','xcf','svg','tff','psd');
$arrayFiles = array('js','css','htm','html','php','txt','xml');

function compteur($currentPath = '..') {
    global $nbLines,$nbrPage,$nbrLignes,$nbrCaractere,$nbrImg,$arrayImg,$arrayFiles;
    $dirsInDir = array();
    $filesInDir = array();
    if ($recup = opendir($currentPath)) {
        while (false !== ($file = readdir($recup))) {
            if ($file != "." && $file != "..") {
                $path = $currentPath.'/'.$file;
                if (is_dir($path)) {
                    if ( substr_count($path, '.git') == 0 
                         && substr_count($path, 'download') == 0 
                         && substr_count($path, 'jquery') == 0 
                         && substr_count($path, 'forum') == 0 ){
                        $dirsInDir[]=$path;
                    }
                } else {
                    $filesInDir[]=$file;
                }
            }
        }
    }
    closedir($recup);
    $nbFiles = count($filesInDir) > 0;
    $nbDirs  = count($dirsInDir) > 0;
    if($nbFiles || $nbDirs) {
        // Si des fichiers existent
        if($nbFiles) {
            foreach ($filesInDir as $file) {
                $pathinfo = pathinfo($file);
                $nbrPage++;
                //gif, jpg, jpeg, psd, png
                if ( isset($pathinfo['extension']) && in_array($pathinfo['extension'],$arrayImg) ){
                    $nbrImg++;
                // php js css html
                } elseif ( isset($pathinfo['extension']) && in_array($pathinfo['extension'],$arrayFiles) ){
                    
                    $contenuFichier = file_get_contents($currentPath.'/'.$file);
                    // nbr ligne
                    $nbrLignes += count(file($currentPath.'/'.$file));
                    // nbr caractère
                    $nbrCaractere += strlen($contenuFichier);

                } else {
                    echo 'Non Classé =>'.$currentPath.'/'.$file.'<br />';
                }

            }
        }
        // Si des dossiers existent
        if($nbDirs) {
            // Tri inverse
            rsort($dirsInDir);
            foreach ($dirsInDir as $dir ) {
                compteur($dir);
            }
        }
    }
}

compteur();
echo number_format($nbrPage,0,'.',' ').' pages<br />'.number_format($nbrLignes,0,'.',' ').' lignes<br />'.number_format($nbrCaractere,0,'.',' ').' Caractères<br />'.number_format($nbrImg,0,'.',' ').' Images<br />';

?>
</body>
</html>