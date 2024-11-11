<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../lib/function.php";
if (
    isset($_GET["eva_id"])
    && is_numeric($_GET["eva_id"])
    && is_auth()
) {
    $eva_id = htmlspecialchars(strip_tags($_GET["eva_id"]));

    $selectArray = array();
    array_push($selectArray, $eva_id);
    $sql = "select * from evas where eva_id = ?";
    $result = dbExec($sql, $selectArray);
    $arrJson = array();
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $arrJson[] = $row;
        }
    }
    $resJson = array("result" => "success", "code" => "200", "message" => $arrJson);
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}