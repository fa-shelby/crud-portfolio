<?php

/*------------------------------------
      FORMULAIRES : VÉRIFICATIONS
-------------------------------------*/

// Vérifier si le formulaire a été soumis

function isFormPosted(): bool {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// Sécurisation et validation des données

function validatedData($data): string {
    $data = trim((string) $data); // The trim() function removes whitespace and other predefined characters from both sides of a string.
    $data = stripslashes($data); // Returns a string with backslashes stripped off
    $data = strip_tags($data); // The strip_tags() function strips a string from HTML, XML, and PHP tags.
    return $data;
}

/*------------------------------------
   FORMULAIRES : GESTION DES ERREURS
-------------------------------------*/

// Afficher les erreurs

function getHtmlFormErrors($errors): string {

    $errorMessage = '<p class="error_message">Attention, les données encodées ne sont pas correctes !</p>';

    foreach($errors as $error) {
        $errorMessage .= '<p class="error_message">'.$error.'</p>';
    }

    return $errorMessage;

}

// Détecter et retourner les éventuelles erreurs dans les fichiers uploadés (image)

function getUploadedImgErrors() : array {
    $errors = [];

    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $max_img_size = 1024 * 1024;  // Maximum un Mo
        $imgFileInfo = pathinfo($_FILES['img']['name']);
        $imgName = strtolower($imgFileInfo['basename']);
        $imgExtension = strtolower($imgFileInfo['extension']);
        $allowedImageExtensions = ['jpg', 'jpeg', 'gif', 'webp', 'png'];

        if ($_FILES['img']['size'] > $max_img_size)
            $errors[] = 'Maximum ' . $max_img_size . ' bytes autorisés par image (1Mo) !';
        if (!in_array($imgExtension, $allowedImageExtensions))
            $errors[] = 'Seuls les fichiers images sont autorisés pour le champ image !';
        if(!preg_match("/^[a-z0-9]+([a-z0-9-]?[a-z0-9]+)*\.(jpg|jpeg|gif|webp|png)$/",$imgName))
            $errors[] = 'Le nom de l\'image ne peut pas contenir de caractères spéciaux (sauf tiret) ou d\'espace.'; // Le nom de l'image doit commencer par une lettre ou un chiffre, peut contenir un ou plusieurs tiret(s) mais pas juste avant le point et doit se terminer par une extension autorisée

    } else {
        $errors[] = 'Le fichier image indiqué n\'existe pas ou une erreur est survenue.<br>Essayez à nouveau en diminuant le poids de l\'image.';
    }

    return $errors;

}

// Détecter et retourner les éventuelles erreurs dans les fichiers uploadés (fichier pdf)

function getUploadedLinkErrors() : array {
    $errors = [];

    if (isset($_FILES['link']) && $_FILES['link']['error'] == 0) {
        $max_link_size = 1300000;
        $linkFileInfo = pathinfo($_FILES['link']['name']);
        $linkName = strtolower($linkFileInfo['basename']);
        $linkExtension = strtolower($linkFileInfo['extension']);
        $allowedLinkExtensions = ['pdf'];

        if ($_FILES['link']['size'] > $max_link_size)
            $errors[] = 'Maximum ' . $max_link_size . ' bytes pour le lien (fichier PDF) !';
        if (!in_array($linkExtension, $allowedLinkExtensions))
            $errors[] = 'Seuls les fichiers PDF sont autorisés pour le lien !';
        if(!preg_match("/^[a-z0-9]+([a-z0-9-]?[a-z0-9]+)*\.pdf$/",$linkName))
            $errors[] = 'Le nom du lien ne peut pas contenir de caractères spéciaux (sauf tiret) ou d\'espace.'; // Le nom du fichier doit commencer par une lettre ou un chiffre, peut contenir un ou plusieurs tiret(s) mais pas juste avant le point et doit se terminer par pdf
    } else {
        $errors[] = 'Le fichier indiqué pour le lien n\'existe pas ou une erreur est survenue.<br>Essayez à nouveau en diminuant le poids du PDF.';
    }

    return $errors;

}

// Travaux : détecter et retourner les éventuelles erreurs dans le formulaire

function getWorksFormErrors($action): array {
    $errors = [];

    if (isset($_POST, $_FILES) && !empty($_POST) && !empty($_FILES)) {
        if (empty($_POST['title']))
            $errors[] = 'Le titre ne peut pas être vide.';
        if (strlen($_POST['title']) > 20)
            $errors[] = 'Le titre ne peut pas dépasser 20 caractères.';
        if (empty($_POST['description1']))
            $errors[] = 'La description (partie 1) doit être complétée.';
        if (strlen($_POST['description1']) > 160)
            $errors[] = 'La description (partie 1) ne peut pas dépasser 160 caractères.';
        if (strlen($_POST['description2']) > 160)
            $errors[] = 'La description (partie 2) ne peut pas dépasser 160 caractères.';
        if ($action === 'create') {
            if (empty($_FILES['img']))
                $errors[] = 'Le formulaire doit contenir une image.';
            if (!empty($_FILES['img']))
                $imgErrors = getUploadedImgErrors();
            foreach ($imgErrors as $imgError){
                $errors[] = $imgError;
            }
            if (empty($_FILES['link']))
                $errors[] = 'Le formulaire doit contenir un lien (fichier pdf).';
            if (!empty($_FILES['link']))
                $linkErrors = getUploadedLinkErrors();
            foreach ($linkErrors as $linkError){
                $errors[] = $linkError;
            }
        }

    }else{
        $errors[] = 'Le formulaire n\'a pas été envoyé ou une erreur est survenue.';
    }
    return $errors;
}

// Services : détecter et retourner les éventuelles erreurs dans le formulaire

function getServicesFormErrors($action): array {
    $errors = [];

    if (isset($_POST, $_FILES) && !empty($_POST) && !empty($_FILES)) {
        if (empty($_POST['title']))
            $errors[] = 'Le titre ne peut pas être vide.';
        if (strlen($_POST['title']) > 25)
            $errors[] = 'Le titre ne peut pas dépasser 20 caractères.';
        if (empty($_POST['description']))
            $errors[] = 'La description doit être complétée.';
        if (strlen($_POST['description']) > 205)
            $errors[] = 'La description ne peut pas dépasser 160 caractères.';
        if ($action === 'create') {
            if (!empty($_FILES['img']))
                $imgErrors = getUploadedImgErrors();
            foreach ($imgErrors as $imgError){
                $errors[] = $imgError;
            }
            if (empty($_FILES['img']))
                $errors[] = 'Le formulaire doit contenir une image.';
        }
    }else{
        $errors[] = 'Le formulaire n\'a pas été envoyé ou une erreur est survenue.';
    }
    return $errors;
}

// Coordonnées : détecter et retourner les éventuelles erreurs dans le formulaire

function getDetailsFormErrors(): array {
    $errors = [];
    if (isset($_POST) && !empty($_POST)) {
        if (empty($_POST['address_line1']))
            $errors[] = 'La ligne 1 de l\'adresse ne peut pas être vide.';
        if (strlen($_POST['address_line1']) > 45)
            $errors[] = 'La ligne 1 de l\'adresse ne peut pas dépasser 45 caractères.';
        if (empty($_POST['address_line2']))
            $errors[] = 'La ligne 2 de l\'adresse ne peut pas être vide.';
        if (strlen($_POST['address_line2']) > 45)
            $errors[] = 'La ligne 2 de l\'adresse ne peut pas dépasser 45 caractères.';
        if (empty($_POST['phone_number']))
            $errors[] = 'Le numéro de téléphone ne peut pas être vide.';
        if (strlen($_POST['phone_number']) > 13)
            $errors[] = 'Le numéro de téléphone ne peut pas dépasser 13 caractères.';
        if(!preg_match("/^[0-9]+\/?[.0-9- ]+[0-9]$/", $_POST['phone_number']))
            $errors[] = 'Le numéro de téléphone n\'est pas au bon format.';
        if (empty($_POST['email']))
            $errors[] = 'L\'email ne peut pas être vide.';
        if (strlen($_POST['email']) > 45)
            $errors[] = 'L\'email ne peut pas dépasser 45 caractères.';
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
            $errors[] = 'Le format de l\'email encodé n\'est pas valide.';
    }else{
        $errors[] = 'Le formulaire n\'a pas été envoyé ou une erreur est survenue.';
    }
    return $errors;
}

// Contacts : détecter et retourner les éventuelles erreurs dans le formulaire

function getContactFormErrors(): array {

    $errors = [];

    if (isset($_POST) && !empty($_POST)) {
        if (empty($_POST['contact_lastname']))
            $errors[] = 'Le nom ne peut pas être vide.';
        if (strlen($_POST['contact_lastname']) > 205)
            $errors[] = 'Le nom ne peut pas dépasser 205 caractères.';
        if (empty($_POST['contact_firstname']))
            $errors[] = 'Le prénom ne peut pas être vide.';
        if (strlen($_POST['contact_firstname']) > 205)
            $errors[] = 'Le prénom ne peut pas dépasser 205 caractères.';
        if (empty($_POST['contact_email']))
            $errors[] = 'Merci de renseigner une adresse mail à laquelle vous contacter.';
        if (strlen($_POST['contact_email']) > 45)
            $errors[] = 'L\'email ne peut pas dépasser 45 caractères.';
        if (filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL) === false)
            $errors[] = 'Le format de l\'email encodé n\'est pas valide.';
    }else {
        // Si erreur de validation, c'est que la requete est mauvaise, donc erreur poru dire bad request
        http_response_code(400);
    }

    return $errors;
}

// Vérifier si le formulaire pour supprimer des données est valide

function getDeleteFormErrors(): array {
    $errors = [];
    if ((isset($_POST) && !empty($_POST))) {
        if (empty($_POST['delete_confirmation']))
            $errors[] = 'Une case doit être cochée pour pouvoir envoyer le formulaire.';
        }else{
            $errors[] = 'Le formulaire n\'a pas été soumis ou une erreur est survenue.';
    }
    return $errors;
}
