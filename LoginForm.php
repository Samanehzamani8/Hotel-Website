<?php

session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header("Location: ./Home.php");
    exit();
}

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./Login.css">
</head>
<body>
    <div class='main'>
        <h1>Login</h1>

        <div id="errorBox" class="errorBox" style="display:none;"></div>
        <div id="successBox" class="successBox" style="display:none;"></div>

        <form action="Login.php" method="POST">
            <input type="text" name="userNameEmail" placeholder="Username Or Email">
            <input type="password" name="password" placeholder="Password">
            <p><a href="./Register.html">Don't have an account?</a></p>
            <button type="submit" name="login">Login</button>
        </form>
    </div>

    <script>

    const params = new URLSearchParams(window.location.search);
    const error = params.get('error');
    const messages = {
    empty:     '⚠️ Please fill in all fields.',
    wrongpass: '❌ Incorrect password, Please try again.',
    notfound:  '❌ No account found with this username or email.',
    server:    '🔧 Server error, Please try again later.'
    
    };
    if (error && messages[error]) {
        const box = document.getElementById('errorBox');
        box.textContent = messages[error];
        box.style.display = 'block';
        document.body.style.color = "red";
    }

    </script>
</body>
</html>