<?php session_start();

if (isset($_SESSION['user']) && $_SESSION['user'] === 'Admin') {
    header("Location: ./Admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otelio Hotel</title>
    <link rel="stylesheet" href="./Home.css">
</head>
<body>

    <main class="hero">
        <header class="navbar">
            <div class="navbarNameHotel">
                <span class="nameHotel">OTELIO</span>
                <span class="textHotel">HOTEL</span>
            </div>
            <div class="navText">
                <a href="./Home.php">Home</a>
                <a href="./Facilities.php">Facilities</a>
                <a href="./Room.php">Rooms</a>
                <a href="./Contact.html">Contact-us</a>
            </div>

            <div class="userArea">

                <?php if (isset($_SESSION['user'])): ?>

                    <div class="userDropdownWrapper">
                        <button class="userAvatarBtn" onclick="togglePanel()" id="avatarBtn">
                            <?php echo strtoupper(substr(htmlspecialchars($_SESSION['user']), 0, 1)); ?>
                        </button>
                        <div class="userPanel" id="userPanel">
                            <div class="panelHeader">
                                <div class="panelAvatar"><?php echo strtoupper(substr(htmlspecialchars($_SESSION['user']), 0, 1)); ?></div>
                                <div class="panelUserInfo">
                                    <span class="panelName"><?php echo htmlspecialchars($_SESSION['user']); ?></span>
                                    <span class="panelMember">Gold Member</span>
                                </div>
                            </div>
                            <div class="panelSection">
                                <a href="./MyBookings.php" class="panelItem">
                                    <span class="panelIcon">🏨</span>
                                    <span>My Reservations</span>
                                    <span class="panelBadge">2</span>
                                </a>
                                <a href="#" class="panelItem">
                                    <span class="panelIcon">📋</span>
                                    <span>Stay History</span>
                                </a>
                            </div>
                            <div class="panelSection">
                                <a href="#" class="panelItem">
                                    <span class="panelIcon">👤</span>
                                    <span>Profile</span>
                                </a>
                                <a href="#" class="panelItem">
                                    <span class="panelIcon">🎧</span>
                                    <span>Support</span>
                                </a>
                            </div>
                            <div class="panelSection">
                                <a href="./LogOut.php" class="panelItem panelLogout">
                                    <span class="panelIcon">🚪</span>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>

                <?php else: ?>

                    <a href="LoginForm.php" class="bookNow">LOGIN</a>

                <?php endif; ?>

            </div>
        </header>
    
        <section>
            <div class="heroText">
                <span class="textWel">WELCOME TO</span>
                <span class="textName">OTELIO</span>
                <span class="textHotel1">HOTEL</span>
                <span class="text">Book your stay and enjoy otelio<br> redefined at the most affordable rates.</span>
            </div>
            <div>

                <?php

                    if (isset($_SESSION['user'])) {
                        echo '<button class="book"><a href="./Booking.html">BOOK NOW</a></button>';
                    } else {
                        echo '<button class="book"><a href="./LoginForm.php">BOOK NOW</a></button>';
                    }
                ?>

            </div>
        </section>
    </main>

<script>
function togglePanel() {
    const panel = document.getElementById('userPanel');
    panel.classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const wrapper = document.querySelector('.userDropdownWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        document.getElementById('userPanel').classList.remove('open');
    }
});
</script>

</body>
</html>