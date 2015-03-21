<?php 
    
include 'varutile.php';


$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
$extension_fichier = strtolower(substr(strrchr($_FILES['le_fichier']['name'], '.'), 1)); 


$fichier = $_FILES['le_fichier']['tmp_name'];
$destination = "upload/" . $_FILES['le_fichier']['name'];

if ($_FILES['le_fichier']['error'] > 0) {
/*    echo "Error: ". $_FILES['le_fichier']['error'] . "<br>";
*/      
        $erreur_fichier = "Une erreur est survenue (halbatar!)";
        header('Location: index.php');
}
else if (in_array($extension_fichier, $extensions_valides)) {
        move_uploaded_file($fichier, $destination);
        $transfer_reussi = "Votre image a bien été uploadée :)";
        header('Location: index.php');
    }
else {
    $mauvaise_extension = "Votre fichier n'est pas au bon format";
    header('Location: index.php');
}

