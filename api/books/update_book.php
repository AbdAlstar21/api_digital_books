<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../lib/create_image.php";
include_once "../../lib/function.php";
if (
    isset($_POST["book_id"])
    && is_numeric($_POST["book_id"])
    && isset($_POST["book_name"])
    && isset($_POST["book_author_name"])
     && isset($_POST["book_lang"])
     && isset($_POST["book_summary"])
    && is_auth()
) {
    if (!empty($_FILES["file"]['name']) )
	{
		$images = uploadImage("file" , '../../images/books/' , 200 , 600);
		$img_image = $images["image"];
		$img_thumbnail = $images["thumbnail"];
    
	}
	else
	{
		$img_image = "";
		$img_thumbnail = "";
	}
    
    $book_name = $_POST["book_name"];
    $book_author_name = $_POST["book_author_name"];
    $book_lang = $_POST["book_lang"];
    $book_block = isset($_POST["book_block"]) ? $_POST["book_block"] : "0";
    $book_summary =$_POST["book_summary"];
    // $book_file = isset($_POST["book_file"]) ? $_POST["book_file"] : "";
    // $book_price = isset($_POST["book_price"]) ? $_POST["book_price"] : "";
    $book_id = $_POST["book_id"];
    $cat_id = $_POST["cat_id"];

    $updateArray = array();
    array_push($updateArray, htmlspecialchars(strip_tags($book_name)));
    array_push($updateArray, htmlspecialchars(strip_tags($book_author_name)));
    array_push($updateArray, htmlspecialchars(strip_tags($book_lang)));
    // array_push($updateArray, htmlspecialchars(strip_tags($book_free)));
    array_push($updateArray, htmlspecialchars(strip_tags($book_block)));
    array_push($updateArray, htmlspecialchars(strip_tags($book_summary)));
    // array_push($updateArray, htmlspecialchars(strip_tags($book_file)));
    // array_push($updateArray, htmlspecialchars(strip_tags($book_price)));
    // array_push($updateArray, htmlspecialchars(strip_tags($book_offer)));
    array_push($updateArray, htmlspecialchars(strip_tags($cat_id)));
    
    if($img_image != "")
	{
		array_push($updateArray, htmlspecialchars(strip_tags($img_image)));
		array_push($updateArray, htmlspecialchars(strip_tags($img_thumbnail)));
	
    }

    array_push($updateArray, htmlspecialchars(strip_tags($book_id)));

    if($img_image != "")
	{
        $sql = "update books set book_name=?,book_author_name=?,book_lang=?,book_block=?,book_summary=?,book_date=now(),book_image = ? , book_thumbnail = ? cat_id = ?
        where book_id=?";
	}
	else
	{
        $sql = "update books set book_name=?,book_author_name=?,book_lang=?,book_block=?,book_summary=?,book_date=now(),cat_id = ?
        where book_id=?";
	}


    // $sql = "update books set book_name=?,book_author_name=?,book_lang=?,book_block=?,book_summary=?,book_date=now()
    // where book_id=?";


    $result = dbExec($sql, $updateArray);

    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}