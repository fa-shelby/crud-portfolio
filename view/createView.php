<?php

/*--------------------------------
       FORMULAIRES : CREATE
---------------------------------*/

// Formulaire pour ajouter un travail (CREATE WORK)

function getHtmlWorksForm(): string {
    $title = '';
    $description1 = '';
    $description2 = '';
    $date = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description1 = $_POST['description1'];
        $description2 = $_POST['description2'];
        $date = $_POST['work_date'];
    }
        $form = '<h1>Complétez le formulaire ci-dessous pour ajouter un travail :</h1><div class="form-container"><form method="post" enctype="multipart/form-data">
      <div>
           <label for="title">Titre du travail :</label>
           <input type="text" name="title" id="title" value="' . $title . '" required maxlength="20"> 
      </div>
      <div>
            <label for="description1">Description - Partie 1 :</label>
            <textarea name="description1" id="description1" required maxlength="160">' . $description1 . '</textarea>
      </div>
      <div>
            <label for="description2">Description - Partie 2 :</label>
            <textarea name="description2" id="description2" maxlength="160">' . $description2 . '</textarea>
      </div>
      <div>
            <label for="uploadImage">Image :</label>
            <input id="uploadImage" type="file" name="img" required maxlength="145" onchange="previewImage(this)">  
             <img id="previewUploadImage" class="preview" width="100px">  
      </div> 
       <div>
            <label for="uploadLink">Lien :</label>
            <input type="file" name="link" id="uploadLink" required maxlength="145" onchange="previewLink(this)">  
            <embed id="previewUploadLink" class="preview" width="320px">
      </div>
      <div>
            <label for="work_date">Date :</label>
            <input type="date" name="work_date" id="work_date" value="'. $date .'">    
      </div>             
      <div>
             <button type="submit">Ajouter un travail</button>
      </div>
    </form></div><div><a class="btn read_btn" href="?type=works&action=read">Afficher la liste des travaux</a></div>';

    return $form;
}

// Formulaire pour ajouter un service (CREATE SERVICE)

function getHtmlServicesForm(): string {
    $title = '';
    $description = '';
    $choice = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $choice = !empty($_POST['current_service']) && $_POST['current_service'] === 'on' ? 'checked="checked"' : '';
    }

    $form = '<h1>Complétez le formulaire ci-dessous pour ajouter un service :</h1><div class="form-container"><form method="post" enctype="multipart/form-data">
      <div>
           <label for="title">Titre du service :</label>
           <input type="text" name="title" id="title" value="' . $title . '" required maxlength="25"> 
      </div>
      <div>
            <label for="description">Description :</label>
            <textarea name="description" id="description" required maxlength="205">' . $description . '</textarea>
      </div>
      <div>
            <label for="uploadImage">Image :</label>
            <input id="uploadImage" type="file" name="img" required maxlength="145" onchange="previewImage(this)">   
             <img id="previewUploadImage" class="preview" width="100px">
      </div>     
       <div>
            <label for="current_service">Cocher si le service est actuel :</label>
            <input type="hidden" name="current_service" value="0">
            <input type="checkbox" name="current_service" id="current_service" '. $choice .' >
      </div>       
      <div>
             <button type="submit">Ajouter un service</button>
      </div>
    </form></div><div><a class="btn read_btn" href="?type=services&action=read">Afficher la liste des services</a></div>';

    return $form;
}

// Formulaire pour ajouter des coordonnées (CREATE DETAILS)

function getHtmlDetailsForm(): string {
    $address_line1 = '';
    $address_line2 = '';
    $phone_number = '';
    $email = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $address_line1 = $_POST['address_line1'];
        $address_line2 = $_POST['address_line2'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
    }

    $form = '<h1>Complétez le formulaire ci-dessous pour ajouter vos coordonnées :</h1><div class="form-container"><form method="post">
      <div>
           <label for="address_line1">Adresse - Ligne 1 :</label>
           <input type="text" name="address_line1" id="address_line1" value="'. $address_line1 .'" required maxlength="45"> 
      </div>     
      <div>
            <label for="address_line2">Adresse - Ligne 2 :</label>
            <input type="text" name="address_line2" id="address_line2" value="'. $address_line2 .'" required maxlength="45">    
      </div>     
       <div>
            <label for="phone_number">Numéro de téléphone :</label>
            <input type="text" name="phone_number" id="phone_number" value="'. $phone_number .'" required maxlength="13">    
      </div>
      <div>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="'. $email .'" required maxlength="45">    
      </div>             
      <div> 
             <button type="submit">Ajouter des coordonnées</button>
      </div>
    </form></div><div><a class="btn read_btn" href="?type=details&action=read">Afficher les coordonnées</a></div>';

    return $form;
}

