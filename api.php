<?php

header('Access-Control-Allow-Origin: http://localhost:4200');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Access-Control-Allow-Headers: *');
header('Content-Type:Application/json');

require_once './model/worksManager.php';
require_once './model/servicesManager.php';
require_once './model/contactsManager.php';
require_once './model/detailsManager.php';

$type = null;
$accepted_types = ['works', 'services', 'contacts', 'details'];

if (isset($_GET['type']) && in_array($_GET['type'], $accepted_types)) {
    $type = $_GET['type'];
}

$data = [];

if ($type == 'works') {
    $data = getWorks();
}else if ($type == 'services') {
    $data = getServices();
} else if ($type == 'contacts') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        handleContactForm();
    }else if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS')  {
        http_response_code(405);
    } else {

    }

}else if ($type == 'details'){
    $data = getDetails();
}else{
    http_response_code(404);
    die();
}


echo json_encode($data);

