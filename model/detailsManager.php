<?php

 require_once 'connect.php';

// Récupérer une ligne de coordonnées

function getDetailsById($id) {
    $db = getDB();
    $statement = 'SELECT * FROM `details` WHERE details_id =:id';
    $query = $db->prepare($statement);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
}

// Récupérer les coordonnées personnelles

function getDetails(): array {
    $db = getDB();
    $statement = 'SELECT * FROM `details`';
    $query = $db->prepare($statement);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Ajouter des coordonnées dans la base de données

function createDetails($address_line1, $address_line2, $number, $email){
    $pdo = getDB();
    $statement = 'INSERT INTO `details` (details_address_line1, details_address_line2, details_number, details_email) VALUES (:address_line1, :address_line2, :number, :email)'; // absolument utiliser des paramètres (comme ici :name) pour se protéger des injections mysql
    $query = $pdo->prepare($statement);
    $query->execute([
        'address_line1' => $address_line1,
        'address_line2' => $address_line2,
        'number' => $number,
        'email' => $email
    ]);
}

// Modifier les coordonnées dans la base de données

function updateDetails($address_line1, $address_line2, $number, $email, $id){
    $pdo = getDB();
    $statement = 'UPDATE details SET details_address_line1=:address_line1 , details_address_line2=:address_line2, details_number=:phone_number, details_email=:email WHERE details_id = :id'; // absolument utiliser des paramètres (comme ici :name) pour se protéger des injections mysql
    $query = $pdo->prepare($statement);
    $query->execute([
        'address_line1' => $address_line1,
        'address_line2' => $address_line2,
        'phone_number' => $number,
        'email' => $email,
        'id' => $id
    ]);
}

// Supprimer les coordonnées personnelles

function deleteDetails($id){
    $pdo = getDB();
    $statement = 'DELETE FROM details WHERE details_id = :id';
    $query = $pdo->prepare($statement);
    $query->execute([
        'id' => $id
    ]);
}