<?php

session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header("Location: ./LoginForm.php?error=login");
    exit();
}

if (!isset($_POST['name']) || empty($_POST['name']) ||
    !isset($_POST['number']) || empty($_POST['number']) ||
    !isset($_POST['email']) || empty($_POST['email']) ||
    !isset($_POST['CheckIn']) || empty($_POST['CheckIn']) ||
    !isset($_POST['CheckOut']) || empty($_POST['CheckOut']) ||
    !isset($_POST['roomType']) || empty($_POST['roomType'])) {
    header("Location: ./Booking.html?error=empty");
    exit();
}

$userNameValue = $_POST['name'];
$numberValue   = $_POST['number'];
$emailValue    = $_POST['email'];
$checkInValue  = $_POST['CheckIn'];
$checkOutValue = $_POST['CheckOut'];
$typeValue     = $_POST['roomType'];
$customerID    = $_SESSION['customer_ID'];

if ($checkOutValue <= $checkInValue) {
    header("Location: ./Booking.html?error=dates");
    exit();
}

$link = mysqli_connect("localhost","root","","otelio_hotel");

if (mysqli_connect_errno()) {
    header("Location: ./Booking.html?error=server");
    exit();
}

$query = "INSERT INTO `booking` (`booking_ID`, `customer_ID`, `name`, `number`, `typeRoom`, `checkInDate`, `checkOutDate`, `totalPrice`, `bookingStatus`, `created_at`) VALUES (NULL, '$customerID', '$userNameValue', '$numberValue', '$typeValue', '$checkInValue', '$checkOutValue', '', 'pending', NOW())";

$resultResarrv = mysqli_query($link,$query);

if ($resultResarrv) {
    header("Location: ./Booking.html?success=booked");
    exit();
} else {
    header("Location: ./Booking.html?error=server");
    exit();
}

?>
