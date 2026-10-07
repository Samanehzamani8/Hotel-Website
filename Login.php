<?php

session_start();

if (isset($_POST['userNameEmail']) && !empty($_POST['userNameEmail']) && (isset($_POST['password']) && !empty($_POST['password']))) {
    $emailValue = $_POST['userNameEmail'];
    $passwordValue = $_POST['password'];

} 
else {
    header("Location: ./LoginForm.php?error=empty");
    exit();
}

$link = mysqli_connect("localhost","root","","otelio_hotel");
if (mysqli_connect_errno()) {
    header("Location: ./LoginForm.php?error=server");
    exit();
}

if ($emailValue == 'Admin' && $passwordValue == '123') {
    $_SESSION['isLoggedIn'] = true;
    $_SESSION['user'] = 'Admin';
    header("Location: ./Admin.php");
    exit();
} else {
    $getUser = "SELECT userName, password FROM `customer` WHERE email='$emailValue' OR userName='$emailValue' ";
    
    $getResult = mysqli_query($link,$getUser);
    
    if ($getResult && mysqli_num_rows($getResult) > 0) {
        $row = mysqli_fetch_assoc($getResult);
    
        if (password_verify($passwordValue, $row['password'])) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['user'] = $row['userName'];
            $_SESSION['customer_ID'] = $row['customer_ID'];
            header("Location: ./Home.php");
            exit();
        } else {
            header("Location: ./LoginForm.php?error=wrongpass");
            exit();
        }
    } else {
        header("Location: ./LoginForm.php?error=notfound");
        exit();
    }
}


mysqli_close();

?>
