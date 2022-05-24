<?php

// Fonction getUsers pour récupérer les utilisateurs dans la base de données

function getUsers(): array {
    $db = getDB();
    $statement = 'SELECT * FROM `users`';
    $query = $db->prepare($statement);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer le token de l'utilisateur dans la DB

function getToken($username) {
    $db = getDB();
    $statement = 'SELECT user_token FROM `users` WHERE user_name =:username';
    $query = $db->prepare($statement);
    $query->bindValue(':username', $username);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getAllToken() {
    $db = getDB();
    $statement = 'SELECT user_token FROM `users`';
    $query = $db->prepare($statement);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
