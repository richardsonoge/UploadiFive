<?php
/*
UploadiFive
Copyright (c) 2012 applications réactives, Ronnie Garcia
*/

/*
IMPORTANT: Ce script nécessite la bibliothèque PHP GD
*/

// Définit le répertoire uplaod
$uploadDir = '/uploads/';

function errorHandler($errno, $errstr, $errfile, $errline) {
	// Dans ce script, supprime silencieusement toute erreur générée par getimagesize
	// qui provoquera une erreur si "l'image" n'est pas une image
	// ie n'a pas une largeur / hauteur valide

    /* N'exécute pas le gestionnaire d'erreurs internes PHP */
    return true;
}

$old_error_handler = set_error_handler("errorHandler");

// Vérifie si le fichier a une largeur et une hauteur
function isImage($tempFile) {

	// Obtenir la taille de l'image
    $size = getimagesize($tempFile);

	if (isset($size) && $size[0] && $size[1] && $size[0] *  $size[1] > 0) {
		return true;
	} else {
		return false;
	}

}

if (!empty($_FILES)) {

	$fileData = $_FILES['Filedata'];

	if ($fileData) {
		$tempFile   = $fileData['tmp_name'];
		$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
		$targetFile = $uploadDir . $fileData['name'];

		// Valider le type de fichier
		$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Extensions de fichiers autorisées
		$fileParts = pathinfo($fileData['name']);

		// Valider le type de fichier
		if (in_array(strtolower($fileParts['extension']), $fileTypes) && filesize($tempFile) > 0 && isImage($tempFile)) {
			
			// Sauvegarder le fichier
			move_uploaded_file($tempFile, $targetFile);
			echo 1;
			
		} else {

			// Le type de fichier n'était pas autorisé
			echo 'Invalid file type.';
		}
	}
}
?>