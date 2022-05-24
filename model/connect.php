<?php

/* -------------------
       DONNÉES
---------------------*/

// Connexion à la base de données

function getDB(){
    $pdo = new PDO('mysql:host=localhost;dbname=benoit;charset=utf8', 'benoit', 'S56BEVCGkmhn9uHp');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}