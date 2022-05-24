<?php

require_once 'connect.php';
require_once 'errorsManager.php';

// Récupérer les contacts

function getContacts(): array {
    $db = getDB();
    $statement = 'SELECT * FROM `contacts`';
    $query = $db->prepare($statement);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Formulaire de contact : récupérer le contenu du post, valider les données puis créer contact

function handleContactForm() {
    $inputString = file_get_contents('php://input'); // file_get_contents pour lire son contenu
    // php://input est un flux en lecture seule qui permet de lire des données brutes depuis le corps de la requête.

    $_POST = json_decode($inputString, true); // Pour alimenter le $_POST

    $errors = getContactFormErrors(); // Valider le $_POST et les données

    if (count($errors) == 0) {
        // Si valide, on envoie dans la DB
        $date = date("Y-m-d");
        createContact($date, validatedData($_POST['contact_firstname']), validatedData($_POST['contact_lastname']), validatedData($_POST['contact_email']), strip_tags($_POST['contact_message']));

    }else{
        foreach ($errors as $error)
            echo '<p class="error_message">'.$error.'</p>'; // Faire une div conditionnelle si erreurs pour afficher les erreurs (DOM) ? Plus besoin comme reactive form avec validators
    }

    // Valider le $_POST
    // Valider les données
    // Si valide, on envoie dans la DB
    // Envoyer des erreurs ou pas - Si erreur de validation, c'est que la requete est mauvaise, donc erreur poru dire bad request
    // Bonus, envoyer un mail mais pas pour cette année
}

// Ajouter un contact dans la base de données via le formulaire

function createContact($date, $firstname, $lastname, $email, $message){
    $pdo = getDB();
    $statement = 'INSERT INTO `contacts` (contact_date, contact_firstname, contact_lastname, contact_email, contact_message) VALUES (:date, :firstname, :lastname, :email, :message)'; // absolument utiliser des paramètres pour se protéger des injections mysql
    $query = $pdo->prepare($statement);
    $query->execute([
        'date' => $date,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'message' => $message
    ]);
}
