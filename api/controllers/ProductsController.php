<?php

include_once './GeneralController.php';


$controller = new GeneralController();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $controller->getRequest();
        break;
    case 'POST':
        $controller->postRequest();
        break;
    case 'DELETE':
        $controller->deleteRequest();
        break;
    default:
        echo json_encode(array("error" => true, "message" => "Wrong HTTP method"), JSON_UNESCAPED_UNICODE);
        break;
}

