<?php

require_once 'connect.php';

// Récupérer un travail

function getOneWorkById($id) {
    $db = getDB();
    $statement = 'SELECT * FROM `works` WHERE works_id =:id';
    $query = $db->prepare($statement);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
}

// Récupérer les travaux

function getWorks(): array {
    $db = getDB();
    $statement = 'SELECT * FROM `works`';
    $query = $db->prepare($statement);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Ajouter un travail dans la base de données

function createWork($title, $description1, $description2, $img, $link, $date){
    $pdo = getDB();
    $statement = 'INSERT INTO `works` (works_title, works_description_part1, works_description_part2, works_img, works_link, works_date) VALUES (:title, :description1, :description2, :img, :link, :work_date)'; // absolument utiliser des paramètres (comme ici :name) pour se protéger des injections mysql
    $query = $pdo->prepare($statement);
    $query->execute([
        'title' => $title,
        'description1' => $description1,
        'description2' => $description2,
        'img' => $img,
        'link' => $link,
        'work_date' => $date
    ]);
}

// Modifier un travail dans la base de données

function updateWork($title, $description1, $description2, $img, $link, $date, $id){
    $pdo = getDB();
    $statement = 'UPDATE works SET works_title=:title, works_description_part1=:description1, works_description_part2=:description2, works_img=:img, works_link=:link, works_date=:work_date WHERE works_id = :id'; // absolument utiliser des paramètres (comme ici :name) pour se protéger des injections mysql
    $query = $pdo->prepare($statement);
    $query->execute([
        'title' => $title,
        'description1' => $description1,
        'description2' => $description2,
        'img' => $img,
        'link' => $link,
        'work_date' => $date,
        'id' => $id,
    ]);
}

// Supprimer un travail

function deleteWork($id){
    $pdo = getDB();
    $statement = 'DELETE FROM works WHERE works_id = :id';
    $query = $pdo->prepare($statement);
    $query->execute([
        'id' => $id
    ]);
}