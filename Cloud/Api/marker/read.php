<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/markers.php';
  
$datasbase = new Database();
$db = $database->getConnection();
  
$marker = new Marker($db);

$stmt = $marker->read();
$num = $stmt->rowCount();
  
if($num>0){
  
    $marker_arr=array();
    $marker_arr["records"]=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        
        $marker_item=array(
            "id" => $id,
            "username" => $username,
            "address" => html_entity_decode($address),
            "lat" => $lat,
            "lng" => $lng,
            "amount" => $amount
        );
  
        array_push($marker_arr["records"], $marker_item);
    }
  
    http_response_code(200);
  
    echo json_encode($marker_arr);
}
else{
  
    http_response_code(404);
  
    echo json_encode(
        array("message" => "No markers found.")
    );
}