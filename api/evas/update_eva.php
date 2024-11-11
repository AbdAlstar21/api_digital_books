<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../lib/function.php";
if (
    isset($_POST["eva_id"])
    && is_numeric($_POST["eva_id"])
    && isset($_POST["eva_note"])
    
    && is_auth()
) {
	
	
    $eva_note = $_POST["eva_note"];
    $eva_avg = $_POST["eva_avg"];
    $eva_id = $_POST["eva_id"];

    $updateArray = array();
    array_push($updateArray, htmlspecialchars(strip_tags($eva_note)));
    array_push($updateArray, htmlspecialchars(strip_tags($eva_avg)));

	
    array_push($updateArray, htmlspecialchars(strip_tags($eva_id)));

	
		$sql = "update evas set eva_note=?, eva_avg=? ,eva_date=now()
		where eva_id=?";
	
    $result = dbExec($sql, $updateArray);


    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}