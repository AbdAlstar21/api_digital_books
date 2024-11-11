<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../lib/function.php";
if (
    isset($_GET["start"])
    && is_numeric($_GET["start"])
    && isset($_GET["end"])
    && is_numeric($_GET["end"])
	 && isset($_GET["user_id"])
    && is_numeric($_GET["user_id"])
	
    && is_auth()
) {
    $start = $_GET["start"];
    $end = $_GET["end"];
	$user_id = $_GET["user_id"];
	$sqlWhere = "";
	
	$txtsearch = !isset($_GET["txtsearch"])   ? "" : $_GET["txtsearch"]  ;
 	$selectArray = array();
	
    array_push($selectArray, "%" . htmlspecialchars(strip_tags($txtsearch)) . "%");
	if(trim($txtsearch) != "")
	{
		$sql = "select books.* , eva_id from books inner join evas on 
		books.book_id = evas.book_id where book_name like ?order by eva_avg  desc limit $start , $end";
		$result = dbExec($sql, $selectArray);
	}
	else
	{
		$sql = "select books.* , eva_id from books inner join evas on 
		books.book_id = evas.book_id order by eva_avg desc limit $start , $end";
	
		$result = dbExec($sql, []);
	}
    $arrJson = array();
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
         extract($row);
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