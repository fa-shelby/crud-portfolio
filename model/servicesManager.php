<?php

require_once 'connect.php';

// Récupérer un service

function getOneServiceById($id) {
    $db = getDB();
    $statement = 'SELECT * FROM `services` WHERE services_id =:id';
    $query = $db->prepare($statement);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
}

// Récupérer les services

function getServices(): array {
    $db = getDB();
    $statement = 'SELECT * FROM `services`';
    $query = $db->prepare($statement);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Ajouter un service dans la base de données

function createService($title, $description, $img, $current){

    $current = ($current == 'on') ? 1 : 0; // Sinon, $current vaut 'on'

    $pdo = getDB();
    $statement = 'INSERT INTO `services` (services_title, services_description, services_img, services_current) VALUES (:title, :description, :img, :current_service)'; // absolument utiliser des paramètres (comme ici :name) pour se protéger des injections mysql
    $query = $pdo->prepare($statement);
    $query->execute([
        'title' => $title,
        'description' => $description,
        'img' => $img,
        'current_service' => $current
    ]);
}

// Modifier un service dans la base de données

function updateService($title, $description, $img, $current, $id){

    $current = ($current == 'on') ? 1 : 0; // Sinon, $current vaut 'on'

    $pdo = getDB();
    $statement = 'UPDATE services SET services_title=:title, services_description=:description, services_img=:img, services_current=:current_service WHERE services_id = :id'; // absolument utiliser des paramètres (comme ici :name) pour se protéger des injections mysql
    $query = $pdo->prepare($statement);
    $query->execute([
        'title' => $title,
        'description' => $description,
        'img' => $img,
        'current_service' => $current,
        'id' => $id,
    ]);
}

// Supprimer un service

function deleteService($id){
    $pdo = getDB();
    $statement = 'DELETE FROM services WHERE services_id = :id';
    $query = $pdo->prepare($statement);
    $query->execute([
        'id' => $id
    ]);
}
