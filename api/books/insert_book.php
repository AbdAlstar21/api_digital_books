<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");
 include_once "../../lib/create_image.php";
 include_once "../../lib/function.php";
if ( 
        isset($_POST["book_name"])
     && isset($_POST["book_publisher"])
     && isset($_POST["book_author_name"])
     && isset($_POST["book_lang"])
     && isset($_POST["book_summary"])
     && is_auth() 
) {
    if (!empty($_FILES["image"]['name']) )
	{
		$images = uploadImage("image" , '../../images/books/' , 200 , 600);
		$img_image = $images["image"];
		$img_thumbnail = $images["thumbnail"]; 
        
	}
	else
	{
		$img_image = "";
		$img_thumbnail = "";
	}
    if (!empty($_FILES["myfile"]['name']))
	{ 
        $myFile = $_FILES['myfile']['name']; 
        $myFileTmpName =$_FILES["myfile"]["tmp_name"];
        $upLoadFolder= "../../files/".$myFile; 
        move_uploaded_file($myFileTmpName,$upLoadFolder);
	}
	else
	{
		$myFile = "";
	}
    $cat_id = $_POST["cat_id"];
    // $user_id = $_POST["user_id"];
    
    $book_name = $_POST["book_name"];
    $book_author_name = $_POST["book_author_name"];
    $book_lang = $_POST["book_lang"];
    $book_block = isset($_POST["book_block"]) ? $_POST["book_block"] : "0";
    $book_summary =$_POST["book_summary"];
    $book_token = $_POST["book_token"];
    // $book_eva=isset($_POST["book_eva"]) ? $_POST["book_eva"] : 0.0;
    $book_download=0;
    $book_publisher = $_POST["book_publisher"];
    $book_size = $_POST["book_size"];
    

    $insertArray = array();
    array_push($insertArray, htmlspecialchars(strip_tags($cat_id)));
    // array_push($insertArray, htmlspecialchars(strip_tags($user_id)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_name)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_author_name)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_lang)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_block)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_summary)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_token)));
    array_push($insertArray, htmlspecialchars(strip_tags($img_image)));
    array_push($insertArray, htmlspecialchars(strip_tags($img_thumbnail)));
    array_push($insertArray, htmlspecialchars(strip_tags($myFile)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_download)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_publisher)));
    array_push($insertArray, htmlspecialchars(strip_tags($book_size)));
    

    $sql = "insert into books(cat_id , book_name , book_author_name , book_lang , book_block, book_summary , book_date , book_token , book_image , book_thumbnail , book_file , book_download , book_publisher , book_size)
            values(? , ? , ? , ? , ? , ? , now() , ? , ? , ? , ? , ? , ? , ?)";
    $result = dbExec($sql, $insertArray);

    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}