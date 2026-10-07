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
    <title>Otelio Room</title>
    <link rel="stylesheet" href="./Room.css">
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
                <button class="book"><a href="./LoginForm.php">BOOK NOW</a></button>
            </div>
        </section>
    </main>
    <section class="roomPage">
        <div class="textRoom">
            <span class="textRoom1">ROOMS AND RATES</span>
            <span class="textRoom2">Each of our bright, light-flooded rooms come with everything you could possibly need for a comfortable stay. And yes,<br> comfort isn’t our only objective, we also value good design, sleek contemporary furnishing complemented<br> by the rich tones of nature’s palette as visible from our rooms’ sea-view windows and terraces. </span>
        </div>
        <div class="roomBlog">
            <img src="./img/devon-janse-van-rensburg-_WEDFTZV0qU-unsplash 1.png" alt="" width="100%">
            <p class="nameRoom">SINGLE ROOM</p>
            <div class="roomDetails">
                <div>
                    <a href="./SingleRoom.php" class="details">+</a>
                    <span>VIEW ROOM DETAILS</span>
                </div>
                 <span href="./Booking.html" class="price">$147 Avg/night</span>
            </div>
        </div>
        <div class="roomBlog">
            <img src="./img/double-room 1.png" alt="" width="100%">
            <p class="nameRoom">DOUBLE ROOM</p>
            <div class="roomDetails">
                <div>
                    <a href="./DoubleRoom.php" class="details">+</a>
                    <span>VIEW ROOM DETAILS</span>
                </div>
                <span href="./Booking.html" class="price">$155 Avg/night</span>
            </div>
        </div>
        <div class="roomBlog">
            <img src="./img/fred-kleber-gTbaxaVLvsg-unsplash 1.png" alt="" width="100%">
            <p class="nameRoom">TWIN ROOM</p>
            <div class="roomDetails">
                <div>
                    <a href="./TwinRoom.php" class="details">+</a>
                    <span>VIEW ROOM DETAILS</span>
                </div>
                <span href="./Booking.html" class="price">$155 Avg/night</span>
            </div>
        </div>

        <section class="info">
            <div class="textInfo">
                <span class="text1">Testimonials</span>
                <span class="text2">"Calm, Serene, Retro – What a way to relax and enjoy"</span>
            </div>
            <div class="btnArow">
                <a href="./Facilities.php"><</a>
                <a href="./Contact.html">></a>
            </div>
        </section>
    </section>


    <footer class="footer">
        <div class="footerText1">
            <div class="navbarNameHotel1">
                <span class="textNameFooter">OTELIO</span>
                <span class="textHotel2">HOTEL</span>
            </div>
            <span>497 Evergreen Rd. Roseville, CA 95673<br>+44 345 678 903 <br>luxury_hotels@gmail.com</span>
        </div>
        <div class="footerText1">
            <span>About Us</span>
            <span>Contact</span>
            <span>Terms & Conditions</span>
        </div>
        <div class="footerText1">
            <div class="contact">
                <img src="./img/Path 38.png" alt="">
                <span>Facebook</span>
            </div>
            <div class="contact">
                <img src="./img/Path 39.png" alt="">
                <span>Twitter</span>
            </div>
            <div class="contact">
                <img src="./img/Path 40.png" alt="">
                <span>Instagram</span>
            </div>
        </div>
        <div class="footerText1">
            <span>Subscribe to our newsletter</span>
            <div class="footerContact">
                <input type="email" placeholder="Email Address">
                <button>OK</button>
            </div>
        </div>
    </footer>
    
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