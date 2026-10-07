<?php

if (isset($_POST['userName']) && !empty($_POST['userName']) && isset($_POST['birthday']) && !empty($_POST['birthday']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['number']) && !empty($_POST['number']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword'])) {
    $nameValue = $_POST['userName'];
    $birthdayValue = $_POST['birthday'];
    $age = date('Y') - date('Y', strtotime($birthdayValue));
    $emailValue = $_POST['email'];
    $phoneNumberValue = $_POST['number'];
    $passwordValue = $_POST['password'];
    $confirmPasswordValue = $_POST['confirmPassword'];
    $hashed = password_hash($passwordValue,PASSWORD_DEFAULT);
} 
else {
    header("Location: ./Register.html?error=empty");
    exit();
}

if ($age < 20) {
    header("Location: ./Register.html?error=age");
    exit();
}

if ($passwordValue !== $confirmPasswordValue) {
    header("Location: ./Register.html?error=passmatch");
    exit();
}

$link = mysqli_connect("localhost","root","","otelio_hotel");
if (mysqli_connect_errno()) {
    header("Location: ./Register.html?error=server");
    exit();
}

$getUser = "SELECT * FROM `customer` WHERE userName='$nameValue' OR email='$emailValue' OR phoneNumber='$phoneNumberValue' ";

$getResult = mysqli_query($link,$getUser);

if ($getResult && mysqli_num_rows($getResult) > 0) {
    header("Location: ./Register.html?error=exists");
    exit();
}

else {
    $insertQuery = "INSERT INTO `customer` (`customer_ID`, `userName`, `birthday`, `phoneNumber`, `email`, `password`, `created_at`) VALUES (NULL, '$nameValue', '$birthdayValue', '$phoneNumberValue', '$emailValue', '$hashed', NOW())";

    $saveUserResult = mysqli_query($link,$insertQuery);

    if ($saveUserResult) {
    header("Location: ./Register.html?success=registered");
    exit();
    } else {
    header("Location: ./Register.html?error=server");
    exit();
    }
}
?>
