<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/database.php';
    include_once '../models/marker.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $marker = new Marker($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $marker->id = $data->id;
    
    $marker->username = $data->username;
    $marker->address = $data->address;
    $marker->lat = $data->lat;
    $marker->lng = $data->lng;
    $marker->amount = $data->amount;

    if($marker->update()){
    
        http_response_code(200);
    
        echo json_encode(array("message" => "Marker was updated."));
    }
    
    else{
    
        http_response_code(503);
    
        echo json_encode(array("message" => "Unable to update marker."));
    }
?>