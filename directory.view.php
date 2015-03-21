<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
    <label for="ze_file">Toi aussi pose ton pix !</label><br>
    <input type="file" id="ze_file" name="le_fichier"><br>
    <input type="submit" value="upload">
</form>

 <?php 

    include 'class.upload.php';

    if($_FILES) {

        $document = new Upload($_FILES['le_fichier']); 
        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' ); //extensions acceptées
        $extension_fichier = strtolower(substr(strrchr($_FILES['le_fichier']['name'], '.'), 1)); ////extension du fichier 

        if (in_array($extension_fichier, $extensions_valides)) { //on compare extension du fichier avec extensions autorisées
            $miniature = $document;
            if ($document->uploaded) {
                $miniature->image_resize    = true;
                $miniature->image_ratio_fill     = true;
                $miniature->image_y         = 40;
                $miniature->image_x         = 40;
                $miniature->file_new_name_body   = 'mosaicaloid';
                $miniature->Process('miniature/'); //on crée la miniature

                $document->file_new_name_body   = 'mosaicaloid'; //on renomme les fichiers en cas de problemes dans l'original
                $document->Process('upload/'); //on déplace le fichier
            
                 if ($document->processed) {
                    echo "<h3>Votre image a bien été uploadée : )</3>";
                    $document->clean();
                }
                else {
                    echo "<h3>Une erreur est survenue (halbatar!)</h3>";
                }
            }
        }
        else if ($extension_fichier == "") {
            echo "<h3>Vous n'avez pas sélectionné de fichier : (</h3>";
        }
        else {
            echo "<h3>Votre fichier n'est pas au bon format : (</h3>";
        }
    }

?>

<ol>
    <?php 
        $dossier = 'upload/'; //on indique le dossier dans lequel les grandes 
        $files = scandir('./' . $dossier); //on indique le chemin du fichier
        $dossier_miniature = "miniature/"; //on indique le dossier des miniatures
        $order = array(); //on crée un tableau pour trier plus tard du plus ancien au plus récent

        foreach ($files as $f) {
            if ($f != '..' && $f != '.') { 
                $date = filemtime($dossier.$f);
                $order[$date] = "<li><span></span><a href='".$dossier.$f."' target='_blank'><img src='".$dossier_miniature.$f."'></a></li>";
            }
            
        }

        ksort($order); // on trie le dossier


        foreach ($order as  $li) {
            echo $li; //on affiche les li
        }

    ?>

</ol>


