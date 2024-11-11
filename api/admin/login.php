<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../lib/function.php";
if (
    isset($_GET["admin_password"])
    && isset($_GET["admin_email"])
    && is_auth()
) {
    $admin_password = htmlspecialchars(strip_tags($_GET["admin_password"]));
    $admin_email = htmlspecialchars(strip_tags($_GET["admin_email"]));

    $selectArray = array();
    array_push($selectArray, $admin_password);
    array_push($selectArray, $admin_email);
    $sql = "select * from admins where admin_password = ? and admin_email = ?";
    $result = dbExec($sql, $selectArray);
    $arrJson = array();
    if ($result->rowCount() > 0) {
        $arrJson  = $result->fetch();
        $resJson = array("result" => "success", "code" => "200", "message" => $arrJson);
        echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
    } else {
        //bad request
        $resJson = array("result" => "empty", "code" => "400", "message" => "empty");
        echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
    }
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}