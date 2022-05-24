<?php

/* --------------------------
     AFFICHAGE DES TABLES
----------------------------*/

// Afficher la page d'accueil avec toutes les tables disponibles

function displayTableList($tables) : string {
    $listOfTables = '<h1 class="welcome">Bienvenue !</h1><h2>Choisir une table</h2>
      <table class="all-tables">
        <thead>
            <tr>
                <th>Tables disponibles</th>                            
            </tr>
        </thead>
        <tbody>';

    foreach ($tables as $key => $value) {
        $listOfTables .= '<tr>
    <td><a href="?type='. $key .'&action=read">' . $value . '</a></td> 
   </tr>';
    }

    $listOfTables .= '</tbody></table>';
    return $listOfTables;
}

// Affichage des travaux

function getHtmlWorksList($works): string {
    $list = '<h1>Liste des travaux</h1>
<div><a class="btn create_btn create_work_btn" href="?type=works&action=create">Ajouter un travail</a>
      <table>            
        <thead>
            <tr>
                <th>Id</th> 
                <th>Titre</th>
                <th>Description - Partie 1</th>
                <th>Description - Partie 2</th>
                <th>Image</th> 
                <th>Lien vers PDF</th>   
                <th>Date</th>
                <th>Modifier</th>                
                <th>Supprimer</th>                
            </tr>
        </thead>
        <tbody>';

    foreach ($works as $work) {
        $list .= '<tr>
    <td>' . $work['works_id'] . '</td>
    <td>' . $work['works_title'] . '</td>
    <td>' . $work['works_description_part1'] . '</td>
    <td>' . $work['works_description_part2'] . '</td>
    <td><img src="' . $work['works_img'] . '" width="100px"></td>
    <td><embed src="' . $work['works_link'] . '" width="320px"></td>
    <td>' . $work['works_date'] . '</td>
    <td><a class="btn update_btn" href="?type=works&action=update&id=' . $work['works_id'] . '">Update</a></td>
    <td><button class="btn delete_btn" onclick="document.getElementById(\'delete-work'. $work['works_id'] .'\').style.display=\'block\'">Delete</button></td>
    <div id="delete-work'. $work['works_id'] .'" class="modal-container">
        <div class="modal">   
            <h1>Attention !</h1>
            <p class="alert_message">Vous êtes sur le point de supprimer le travail n°'. $work['works_id'] .' : '. $work['works_title'] .'</p>
            <p>Êtes-vous sûr de vouloir continuer ?</p>                      
            <button onclick="document.getElementById(\'delete-work'. $work['works_id'] .'\').style.display=\'none\'" class="btn cancel_btn">Non</button>
            <a href="?type=works&action=delete&id=' . $work['works_id'] . '" onclick="document.getElementById(\'delete-work'. $work['works_id'] .'\').style.display=\'none\'" class="btn delete_btn">Oui</a>
        </div> 
    </div>   
</tr>';
    }

    $list .= '</tbody></table></div>';
    return $list;
}

// Affichage des services

function getHtmlServicesList($services): string {
    $list = '<h1>Liste des services</h1>
<div><a class="btn create_btn create_service_btn" href="?type=services&action=create">Ajouter un service</a>
      <table class="services-table">
        <thead>
            <tr>
                <th>Id</th> 
                <th>Titre</th>
                <th>Description</th>
                <th>Image</th>                         
                <th>Actuel</th>               
                <th>Modifier</th>                
                <th>Supprimer</th>                
            </tr>
        </thead>
        <tbody>';

    foreach ($services as $service) {
        $list .= '<tr>
    <td>' . $service['services_id'] . '</td>
    <td>' . $service['services_title'] . '</td>
    <td>' . $service['services_description'] . '</td>
    <td><img src="' . $service['services_img'] . '" width="100px"></td>
    <td>' . $service['services_current'] . '</td>
    <td><a class="btn update_btn" href="?type=services&action=update&id=' . $service['services_id'] . '">Update</a></td>
    <td><button class="btn delete_btn" onclick="document.getElementById(\'delete-service'. $service['services_id'] .'\').style.display=\'block\'">Delete</button></td>
    <div id="delete-service'. $service['services_id'] .'" class="modal-container">
        <div class="modal">   
            <h1>Attention !</h1>
            <p class="alert_message">Vous êtes sur le point de supprimer le service n°'. $service['services_id'] .' : '. $service['services_title'] .'</p>
            <p>Êtes-vous sûr de vouloir continuer ?</p>                      
            <button onclick="document.getElementById(\'delete-service'. $service['services_id'] .'\').style.display=\'none\'" class="btn cancel_btn">Non</button>
            <a href="?type=services&action=delete&id=' . $service['services_id'] . '" onclick="document.getElementById(\'delete-service'. $service['services_id'] .'\').style.display=\'none\'" class="btn delete_btn">Oui</a>
        </div> 
    </div>
</tr>';
    }

    $list .= '</tbody></table></div>';
    return $list;
}

// Affichage des contacts

function getHtmlContactsList($contacts): string {
    $list = '<h1>Liste des contacts</h1>
      <table class="contacts-table">
        <thead>
            <tr>
                <th>Id</th> 
                <th>Date</th>
                <th>Prénom</th>
                <th>Nom</th>                         
                <th>Email</th>                         
                <th>Message</th>
                </tr>
        </thead>
        <tbody>';

    foreach ($contacts as $contact) {
        $list .= '<tr>
    <td>' . $contact['contact_id'] . '</td>
    <td>' . $contact['contact_date'] . '</td>
    <td>' . $contact['contact_firstname'] . '</td>
    <td>' . $contact['contact_lastname'] . '</td>
    <td>' . $contact['contact_email'] . '</td>  
    <td>' . $contact['contact_message'] . '</td>   
</tr>';
    }

    $list .= '</tbody></table>';
    return $list;
}

// Affichage des coordonnées personnelles

function getHtmlDetailsList($details): string {
    $list = '<h1>Mes coordonnées</h1>
    <div><a class="btn create_btn create_details_btn" href="?type=details&action=create">Ajouter des coordonnées</a>
      <table class="details-table">            
        <thead>
            <tr>
                <th>Id</th> 
                <th>Adresse - Ligne 1</th>
                <th>Adresse - Ligne 2</th>
                <th>GSM</th>                         
                <th>Email</th>           
                <th>Modifier</th>                
                <th>Supprimer</th>                
            </tr>
        </thead>
        <tbody>';

    foreach ($details as $detail) {
        $list .= '<tr>
    <td>' . $detail['details_id'] . '</td>
    <td>' . $detail['details_address_line1'] . '</td>
    <td>' . $detail['details_address_line2'] . '</td>
    <td>' . $detail['details_number'] . '</td>
    <td>' . $detail['details_email'] . '</td>
    <td><a class="btn update_btn" href="?type=details&action=update&id='. $detail['details_id'] .'">Update</a></td>
    <td><button class="btn delete_btn" onclick="document.getElementById(\'delete-details'. $detail['details_id'] .'\').style.display=\'block\'">Delete</button></td>    
    <div id="delete-details'. $detail['details_id'] .'" class="modal-container">
        <div class="modal">   
            <h1>Attention !</h1>
            <p class="alert_message">Vous êtes sur le point de supprimer les coordonnées n°'. $detail['details_id'] .'.</p>
            <p>Êtes-vous sûr de vouloir continuer ?</p>                      
            <button onclick="document.getElementById(\'delete-details'. $detail['details_id'] .'\').style.display=\'none\'" class="btn cancel_btn">Non</button>
            <a href="?type=details&action=delete&id='. $detail['details_id'] .'" onclick="document.getElementById(\'delete-details'. $detail['details_id'] .'\').style.display=\'none\'" class="btn delete_btn">Oui</a>
        </div> 
    </div>    
</tr>';
    }

    $list .= '</tbody></table></div>';
    return $list;
}








