<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");
 include_once "../../lib/create_image.php";
 include_once "../../lib/function.php";

if (
  
    isset($_POST["admin_name"])
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
    $admin_token = $_POST["admin_token"];
    $insertArray = array();
    array_push($insertArray, htmlspecialchars(strip_tags($admin_name)));
    array_push($insertArray, htmlspecialchars(strip_tags($admin_password)));
    array_push($insertArray, htmlspecialchars(strip_tags($admin_email)));
    array_push($insertArray, htmlspecialchars(strip_tags($admin_active)));
    array_push($insertArray, htmlspecialchars(strip_tags($admin_note)));
    array_push($insertArray, htmlspecialchars(strip_tags($admin_token)));
    array_push($insertArray, htmlspecialchars(strip_tags($img_image)));
    array_push($insertArray, htmlspecialchars(strip_tags($img_thumbnail)));
    $sql = "insert into admins(admin_name , admin_password , admin_email , admin_active , admin_note , admin_datetime , admin_lastdate,admin_token,admin_image,admin_thumbnail)
            values(? , ? , ? , ? 
            ,? , now() , now(),?,?,?)";
    $result = dbExec($sql, $insertArray);

    $readArray = array();
    array_push($readArray, htmlspecialchars(strip_tags($admin_email)));
	
    $sql = "select * from admins where admin_email = ?  order by admin_id desc limit 0,1";
    $result = dbExec($sql, $readArray);
    $arrJson = array();
    if ($result->rowCount() > 0) {
        $arrJson  = $result->fetch();
	}

    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
