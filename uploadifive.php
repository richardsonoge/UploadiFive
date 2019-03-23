<?php
/*
UploadiFive
Copyright (c) 2012 applications réactives, Ronnie Garcia
*/

// Définit le répertoire de téléchargement
$uploadDir = '/uploads/';

// Définir les extensions de fichier autorisées
$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Extensions de fichiers autorisées

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
	$targetFile = $uploadDir . $_FILES['Filedata']['name'];

	// Valider le type de fichier
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

		// Sauvegarder le fichier
		move_uploaded_file($tempFile, $targetFile);
		echo 1;

	} else {

		// Le type de fichier n'était pas autorisé
		echo 'Invalid file type.';

	}
}
?>