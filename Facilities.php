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
    <title>Otelio Facilities</title>
    <link rel="stylesheet" href="./Facilities.css">
</head>
<body>

    <main class="hero">
        <header class="navbar">
            <div class="navbarNameHotel">
                <span class="nameHotel">OTELIO</span>
                <span class="textHotel">HOTEL</span>
            </div>
            <div class="navText">
                <a href="./Home.Php">Home</a>
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
                <button class="book"><a href="./LoginForm.php
                ">BOOK NOW</a></button>
            </div>
        </section>
    </main>
    <section class="roomPage">
        <div class="textRoom">
            <span class="textRoom1">Facilities</span>
            <span class="textRoom2">We want your stay at our lush hotel to be truly unforgettable. That is why we give special attention to all of your needs so<br> that we can ensure an experience quite uniquw. Luxury hotels offers the perfect setting with stunning views for leisure<br> and our modern luxury resort facilities will help you enjoy the best of all. </span>
        </div>
        <div class="roomBlog">
            <img src="./img/gym.png" alt="" width="100%">
            <p class="nameRoom">THE GYM</p>
        </div>
        <div class="roomBlog">
            <img src="./img/bar.png" alt="" width="100%">
            <p class="nameRoom">POOLSIDE BAR</p>
        </div>
        <div class="roomBlog">
            <img src="./img/spa.png" alt="" width="100%">
            <p class="nameRoom">THE SPA</p>
        </div>

        <div class="roomBlog">
            <img src="./img/pool.png" alt="" width="100%">
            <p class="nameRoom">SWIMMING POOL</p>
        </div>
        <div class="roomBlog">
            <img src="./img/restaurant.png" alt="" width="100%">
            <p class="nameRoom">RESTAURANT</p>
        </div>
        <div class="roomBlog">
            <img src="./img/laundry.png" alt="" width="100%">
            <p class="nameRoom">LAUNDRY</p>
        </div>

        <section class="info">
            <div class="textInfo">
                <span class="text1">Testimonials</span>
                <span class="text2">"Calm, Serene, Retro – What a way to relax and enjoy"</span>
            </div>
            <div class="btnArow">
                <a href="./Home.Php"><</a>
                <a href="./Room.php">></a>
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