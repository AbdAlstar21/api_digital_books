   <?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../lib/function.php";

if (
    isset($_POST["eva_note"])
    &&
    isset($_POST["user_id"])
    && isset($_POST["book_id"])
    && is_auth()  
) {
    $user_id = $_POST["user_id"];
    $book_id = $_POST["book_id"];
    $eva_note = $_POST["eva_note"];
     $eva_avg = $_POST["eva_avg"];
	
	

    $insertArray = array();
    array_push($insertArray, htmlspecialchars(strip_tags($book_id)));

    array_push($insertArray, htmlspecialchars(strip_tags($user_id)));
    array_push($insertArray, htmlspecialchars(strip_tags($eva_note)));
   array_push($insertArray, htmlspecialchars(strip_tags($eva_avg)));

    $sql = "insert into evas(book_id , user_id , eva_note , eva_avg , eva_date)
            values(? , ? , ? , ? , now())";
    $result = dbExec($sql, $insertArray);

	  $readArray = array();
	
    array_push($readArray, htmlspecialchars(strip_tags($user_id)));
	array_push($readArray, htmlspecialchars(strip_tags($book_id)));
	
    $sql = "select * from evas where user_id = ? and book_id = ?  order by book_id desc limit 0,1";
    $result = dbExec($sql, $readArray); 
    $arrJson = array();
    if ($result->rowCount() > 0) {
        $arrJson  = $result->fetch();
	}
    $resJson = array("result" => "success", "code" => "200", "message" => $arrJson);
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}