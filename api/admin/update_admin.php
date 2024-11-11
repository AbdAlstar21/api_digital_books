<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../lib/create_image.php";
include_once "../../lib/function.php";
if (
    isset($_POST["admin_id"])
    && is_numeric($_POST["admin_id"])
    && isset($_POST["admin_name"])
    && isset($_POST["admin_password"])
    && isset($_POST["admin_email"])
    && is_auth()
) {if (!empty($_FILES["file"]['name']) )
	{
		$images = uploadImage("file" , '../../images/admins/' , 200 , 600);
		$img_image = $images["image"];
		$img_thumbnail = $images["thumbnail"];
    
	}
	else
	{
		$img_image = "";
		$img_thumbnail = "";
	}
    $admin_name = $_POST["admin_name"];
    $admin_password = $_POST["admin_password"];
    $admin_email = $_POST["admin_email"];
    $admin_active = isset($_POST["admin_active"]) ? $_POST["admin_active"] : "0";
    $admin_note = isset($_POST["admin_note"]) ? $_POST["admin_note"] : "";
    $admin_id = $_POST["admin_id"];

    $updateArray = array();
    array_push($updateArray, htmlspecialchars(strip_tags($admin_name)));
    array_push($updateArray, htmlspecialchars(strip_tags($admin_password)));
    array_push($updateArray, htmlspecialchars(strip_tags($admin_email)));
    array_push($updateArray, htmlspecialchars(strip_tags($admin_active)));
    array_push($updateArray, htmlspecialchars(strip_tags($admin_note)));
    
	if($img_image != "")
	{
		array_push($updateArray, htmlspecialchars(strip_tags($img_image)));
		array_push($updateArray, htmlspecialchars(strip_tags($img_thumbnail)));
	}
    array_push($updateArray, htmlspecialchars(strip_tags($admin_id)));
    if($img_image != "")
	{
		
        $sql = "update admins set admin_name=?,admin_password=?,admin_email=?,admin_active=?,admin_note=?,admin_lastdate=now(), admin_image = ? , admin_thumbnail = ?
        where admin_id=?";
	}
	else
	{
		
        $sql = "update admins set admin_name=?,admin_password=?,admin_email=?,admin_active=?,admin_note=?,admin_lastdate=now()
        where admin_id=?";
	}


    $result = dbExec($sql, $updateArray);

    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}