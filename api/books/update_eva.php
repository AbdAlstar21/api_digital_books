<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../lib/function.php";
if (
    isset($_POST["book_id"])&&
    isset($_POST["eva_avg"])
    && is_numeric($_POST["book_id"])
    && is_auth()
) {
    $eva_avg = $_POST["eva_avg"];
    $book_id = $_POST["book_id"];
    
    $updateArray = array();
    array_push($updateArray, htmlspecialchars(strip_tags($book_id)));
    $sql = "update books set book_sum_eva = book_sum_eva + eva_avg , book_number_of_reviews = book_number_of_reviews + 1
    where book_id=?";
    $result = dbExec($sql,$updateArray);

    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}