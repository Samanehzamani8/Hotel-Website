<?php

if (isset($_POST['roomNumber']) && !empty($_POST['roomNumber']) && 
    isset($_POST['price']) && !empty($_POST['price']) && 
    isset($_POST['typeRoom']) && !empty($_POST['typeRoom']) &&  
    isset($_FILES["imgRoom"]) && $_FILES["imgRoom"]["error"] == 0 && 
    isset($_POST['status']) && !empty($_POST['status']) && 
    isset($_POST['description']) && !empty($_POST['description'])) {

    $roomNumberValue = $_POST['roomNumber'];
    $priceValue = $_POST['price'];
    $typeRoomValue = $_POST['typeRoom'];
    $statusValue = $_POST['status'];
    $descriptionValue = $_POST['description'];
} 
else {
    header("Location: ./ProductRoom.html?error=empty");
    exit();
}

$isImage = getimagesize($_FILES["imgRoom"]["tmp_name"]);
if (!$isImage) {
    header("Location: ./ProductRoom.html?error=image");
    exit();
}

$fileSize = $_FILES["imgRoom"]["size"];
$maxUploadSize = 5000 * 1024;
if ($fileSize > $maxUploadSize) {
    header("Location: ./ProductRoom.html?error=size");
    exit();
}

$imageExtension = $_FILES["imgRoom"]["type"];
if (($imageExtension !== "image/png" && $imageExtension !== "image/jpeg" && $imageExtension !== "image/jpg" )) {
    header("Location: ./ProductRoom.html?error=format");
    exit();
}

$imageName = $_FILES["imgRoom"]["name"];
$imageType = $_FILES["imgRoom"]["type"];

$targetDirectory = "img/Product/";
$fullTargertFile = $targetDirectory . $imageName;

if (file_exists($fullTargertFile)) {
    $fullTargertFile = $targetDirectory . $imageName . time();
}

$isMoved = move_uploaded_file($_FILES["imgRoom"]["tmp_name"], $fullTargertFile);
if (!$isMoved) {
    header("Location: ./ProductRoom.html?error=upload");
    exit();
}

$link = mysqli_connect("localhost","root","","otelio_hotel");
if (mysqli_connect_errno()) {
    header("Location: ./ProductRoom.html?error=server");
    exit();
}

$query = "INSERT INTO `room` (`room_ID`, `roomNumber`, `imageRoom`, `roomType`, `priceOfNight`, `status`, `description`, `created_at`) VALUES (NULL, '$roomNumberValue', '$fullTargertFile', '$typeRoomValue', '$priceValue', '$statusValue', '$descriptionValue', NOW())";

// var_dump($query);
$Result = mysqli_query($link,$query);

if ($Result === true) {
    header("Location: ./ProductRoom.html?success=imported");
    exit();
} else {
    header("Location: ./ProductRoom.html?error=server");
    exit();
}

mysqli_close($link);

?>


