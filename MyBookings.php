<?php
session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header("Location: ./LoginForm.php");
    exit();
}

if (isset($_SESSION['user']) && $_SESSION['user'] === 'Admin') {
    header("Location: ./Admin.php");
    exit();
}

$customerID = $_SESSION['customer_ID'];

$link = mysqli_connect("localhost", "root", "", "otelio_hotel");
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM booking WHERE customer_ID = '$customerID' ORDER BY created_at DESC";
$result = mysqli_query($link, $sql);

$bookings = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
    <link rel="stylesheet" href="./MyBookings.css">
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
                            <a href="./MyBookings.php" class="panelItem" style="color: #E0B973 !important;">
                                <span class="panelIcon">🏨</span>
                                <span>My Reservations</span>
                                <span class="panelBadge"><?php echo count($bookings); ?></span>
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
            </div>
        </header>
    </main>

    <div class="reservation-container">
        <div class="reservation-header">
            <h1>📋 My Reservations <span class="booking-count"><?php echo count($bookings); ?></span></h1>
            <a href="./Home.php">← Back to Home</a>
        </div>

        <?php if (!empty($bookings)): ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Room Type</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Booked At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): 
                            $statusClass = '';
                            switch(strtolower($booking['bookingStatus'] ?? 'pending')) {
                                case 'pending': $statusClass = 'status-pending'; break;
                                case 'confirmed': $statusClass = 'status-confirmed'; break;
                                case 'cancelled': $statusClass = 'status-cancelled'; break;
                                case 'completed': $statusClass = 'status-completed'; break;
                                default: $statusClass = 'status-pending';
                            }
                        ?>
                        <tr>
                            <td><strong>#<?php echo htmlspecialchars($booking['booking_ID']); ?></strong></td>
                            <td><?php echo ucfirst(htmlspecialchars($booking['typeRoom'] ?? 'N/A')); ?></td>
                            <td><?php echo date('M d, Y', strtotime($booking['checkInDate'])); ?></td>
                            <td><?php echo date('M d, Y', strtotime($booking['checkOutDate'])); ?></td>
                            <td class="price-highlight">$<?php echo htmlspecialchars($booking['totalPrice'] ?? '0'); ?></td>
                            <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo ucfirst($booking['bookingStatus'] ?? 'Pending'); ?></span></td>
                            <td><?php echo date('M d, Y H:i', strtotime($booking['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-data">
                <span>📭</span>
                <h2>No Reservations Yet</h2>
                <p style="color: #8892a8; font-size: 16px;">You haven't made any reservations. Book your stay now!</p>
                <a href="./Room.php" class="btn-ghost" style="display: inline-block; margin-top: 15px;">Browse Rooms</a>
            </div>
        <?php endif; ?>
    </div>

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