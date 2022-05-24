<?php

session_start();

// index.php est le routeur mais ici, il contient aussi les contrôleurs
// Commencé à mettre les contrôleurs à part mais je ne voyais pas comment faire pour ne pas dupliquer le code tout le temps

require_once './model/worksManager.php';
require_once './model/servicesManager.php';
require_once './model/contactsManager.php';
require_once './model/detailsManager.php';
require_once './model/usersManager.php';
require_once './view/template.php';
require_once './view/readView.php';
require_once './view/createView.php';
require_once './view/updateView.php';
require_once './upload.php';

// On teste la présence du cookie 'token'
if (!isset($_COOKIE['token'])){

    // Si l'utilisateur n'est pas connecté (le cookie 'token' n'est pas présent), il est redirigé vers la page de connexion
    header ('Location: login.php');

} else {
    // S'il y a un cookie 'token', on récupère sa valeur
    $tokenCookie = $_COOKIE['token'];

    // On récupère les données de la table des utilisateurs
    $users = getUsers();

    // Et on vérifie si le token du cookie est bien dedans
    $key = array_search($tokenCookie, array_column($users, 'user_token')); // S'il est trouvé, retournera son index, sinon, renverra false

    if (isset($users[$key])) {

        // On récupère le token de la DB
        $row = $users[$key];
        $tokenDB = $row['user_token'];

        // Si les 2 ne correspondent pas, l'utilisateur n'est pas connecté, on le renvoie vers le formulaire de login
        if($tokenCookie !== $tokenDB ){
           header ('Location: login.php');
        }
    }
}

$type = isset($_GET['type']) && ($_GET['type'] === 'all'
                             || $_GET['type'] === 'works'
                             || $_GET['type'] === 'services'
                             || $_GET['type'] === 'contacts'
                             || $_GET['type'] === 'details') ? $_GET['type'] : 'all';

$action = isset($_GET['action']) && ($_GET['action'] === 'read'
                                 || $_GET['action'] === 'create'
                                 || $_GET['action'] === 'update'
                                 || $_GET['action'] === 'delete' ) ? $_GET['action'] : 'read';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? strip_tags($_GET['id']) : null;

if ($type === 'all') { // READ all tables
    $title = 'Liste des tables disponibles';
    $tables = ['works' => 'Travaux', 'services' => 'Services', 'contacts' => 'Contact', 'details' => 'Mes coordonnées'];
    $html = displayTableList($tables); // Le contenu sera la table avec toutes les tables disponibles
    printPage($title, $html);

}else if ($type === 'works') {  // READ WORKS
    if ($action === 'read') {
        $title = 'Liste des travaux';
        $works = getWorks();
        $html = getHtmlWorksList($works);
        printPage($title, $html);

    }else if ($action === 'create'){   // CREATE WORK
        if (isFormPosted()) {
            $errors = getWorksFormErrors($action);
            if (count($errors) == 0){
                $image = uploadImage();
                $link = uploadLink();
                createWork(validatedData($_POST['title']), validatedData($_POST['description1']), validatedData($_POST['description2']), $image, $link, validatedData($_POST['work_date']));
                header('location: ?type=works&action=read');
            }else{
                $title = 'Erreur - Ajouter un travail';
                $html = getHtmlFormErrors($errors);
                $html .= getHtmlWorksForm();
                printPage($title, $html);
            }
        }else {
            $title = 'Ajouter un travail';
            $html = getHtmlWorksForm();
            printPage($title, $html);
        }

    }else if ($action === 'update'){   // UPDATE WORK
        if (isFormPosted()) {
            $errors = getWorksFormErrors($action);
            if (count($errors) == 0){
                $work = getOneWorkById($id); // Récupérer un travail par son ID

                $image = uploadImage(); // Si une image a été uploadée, on prend sa valeur
                if ($image === 'null'){
                    $image = $work['works_img']; // Sinon, on reprend l'image stockée en DB
                }

                $link = uploadLink(); // Idem avec le lien vers le PDF
                if ($link === 'null'){
                    $link = $work['works_link'];
                }

                updateWork(validatedData($_POST['title']), validatedData($_POST['description1']), validatedData($_POST['description2']), $image, $link, validatedData($_POST['work_date']), $id);
                header('location: ?type=works&action=read');
            }else{
                $title = 'Erreur - Modifier un travail';
                $work = getOneWorkById($id); // Récupérer un travail par son ID
                $html = getHtmlFormErrors($errors); // Afficher les messages d'erreurs
                $html .= getHtmlUpdateWorkForm($work); // Afficher à nouveau le formulaire prérempli avec les données de la DB
                printPage($title, $html);
            }
        }else {
            $title = 'Modifier un travail';
            $work = getOneWorkById($id);
            $html = getHtmlUpdateWorkForm($work);
            printPage($title, $html);
        }

    }else if ($action === 'delete') {    // DELETE WORK
       deleteWork($id);
       header('location: ?type=works&action=read');
    }

}else if ($type === 'services') {     // READ SERVICE
    if ($action === 'read') {
        $title = 'Liste des services';
        $services = getServices();
        $html = getHtmlServicesList($services);
        printPage($title, $html);

    }else if ($action === 'create'){   // CREATE SERVICE
        if (isFormPosted()) {
            $errors = getServicesFormErrors($action);
            if (count($errors) == 0) {
                    $image = uploadImage();
                    createService(validatedData($_POST['title']), validatedData($_POST['description']), $image, validatedData($_POST['current_service']));
                    header('location: ?type=services&action=read');
                }else{
                    $title = 'Erreur - Ajouter un service';
                    $html = getHtmlFormErrors($errors);
                    $html .= getHtmlServicesForm();
                    printPage($title, $html);
                }
            } else {
                $title = 'Ajouter un service';
                $html = getHtmlServicesForm();
                printPage($title, $html);
        }

    }else if ($action === 'update'){   // UPDATE SERVICE
        if (isFormPosted()) {
            $errors = getServicesFormErrors($action);
            if (count($errors) == 0) {
                $service = getOneServiceById($id); // Récupérer un service par son ID

                $image = uploadImage();
                if ($image === 'null'){ // S'il n'y a pas d'image uploadée
                    $image = $service['services_img']; // On reprend l'image de la base de données
                }

                updateService(validatedData($_POST['title']), validatedData($_POST['description']), $image, validatedData($_POST['current_service']), $id);
                header('location: ?type=services&action=read');
            }else{
                $title = 'Erreur - Modifier un service';
                $service = getOneServiceById($id);
                $html = getHtmlFormErrors($errors);
                $html .= getHtmlUpdateServiceForm($service);
                printPage($title, $html);
            }
        }else {
            $title = 'Modifier un service';
            $service = getOneServiceById($id);
            $html = getHtmlUpdateServiceForm($service);
            printPage($title, $html);
        }

    }else if ($action === 'delete') {    // DELETE SERVICE
        deleteService($id);
        header('location: ?type=services&action=read');
    }

}else if ($type === 'contacts') {
    if ($action === 'read') {    // READ CONTACTS
        $title = 'Liste des contacts';
        $contacts = getContacts();
        $html = getHtmlContactsList($contacts);
        printPage($title, $html);    }

}else if ($type === 'details') {
    if ($action === 'read') {   // READ DETAILS
        $title = 'Afficher les coordonnées';
        $details = getDetails();
        $html = getHtmlDetailsList($details);
        printPage($title, $html);

    } else if ($action === 'create') {    // CREATE DETAILS
        if (isFormPosted()) {
            $errors = getDetailsFormErrors();
            if (count($errors) == 0) {
                createDetails(validatedData($_POST['address_line1']), validatedData($_POST['address_line2']), validatedData($_POST['phone_number']), validatedData($_POST['email']));
                header('location: ?type=details&action=read');
            } else {
                $title = 'Erreur - Ajouter des coordonnées';
                $html = getHtmlFormErrors($errors);
                $html .= getHtmlDetailsForm();
                printPage($title, $html);
            }
        } else {
            $title = 'Ajouter des coordonnées';
            $html = getHtmlDetailsForm();
            printPage($title, $html);
        }

    }else if ($action === 'update') {   // UPDATE DETAILS
        if (isFormPosted()) {
            $errors = getDetailsFormErrors();
            if (count($errors) == 0){
                updateDetails(validatedData($_POST['address_line1']), validatedData($_POST['address_line2']), validatedData($_POST['phone_number']), validatedData($_POST['email']), $id);
                header('location: ?type=details&action=read');
            } else {
                $title = 'Erreur - Modifier les coordonnées';
                $detail = getDetailsById($id);
                $html = getHtmlFormErrors($errors);
                $html .= getHtmlUpdateDetailForm($detail);
                printPage($title, $html);
            }
        } else {
            $title = 'Modifier les coordonnées';
            $detail = getDetailsById($id);
            $html = getHtmlUpdateDetailForm($detail);
            printPage($title, $html);
        }

    }else if ($action === 'delete') {    // DELETE DETAILS
        deleteDetails($id);
        header('location: ?type=details&action=read');
    }
}