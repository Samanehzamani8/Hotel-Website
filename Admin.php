<?php

session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header("Location: ./LoginForm.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./Admin.css">
</head>
<body>

    <main class="hero">
        <header class="navbar">
            <div>
                <h2>Control Panel</h2>
            </div>
            <div class="dashboard">
                <a href="">Dashboard</a>
                <a href="./ReservationAdmin.php">Reservations</a>
                <a href="./RoomsAdmin.php">Rooms</a>
                <a href="./LogOut.php" class="panelLogout">
                    <span>Logout</span>
                </a>
            </div>
        </header>
    </main>

</body>
</html>