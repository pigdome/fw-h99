<?php
$response = [];

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/x-png")
        || ($_FILES["file"]["type"] == "image/png"))
    && in_array($extension, $allowedExts)
) {

    if ($_FILES["file"]["error"] > 0) {
        $response['error'] = $_FILES["file"]["error"];
    } else {

        //Move the file to the uploads folder
        move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $_FILES["file"]["name"]);

        //Get the File Location
        $filelocation = '/uploads/' . $_FILES["file"]["name"];

        $response['url'] = $filelocation;
    }
} else {
    //File type was invalid, so throw up a red flag!
    $response['error'] = "Invalid File Type";
    $response['filetype'] = $_FILES["file"]["type"];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
