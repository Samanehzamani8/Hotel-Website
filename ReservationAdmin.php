<?php
session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || $_SESSION['user'] !== 'Admin') {
    header("Location: ./LoginForm.php");
    exit();
}

$link = mysqli_connect("localhost", "root", "", "otelio_hotel");
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT b.*, c.userName, c.email, c.phoneNumber 
        FROM booking b 
        LEFT JOIN customer c ON b.customer_ID = c.customer_ID 
        ORDER BY b.created_at";
$result = mysqli_query($link, $sql);

$reservations = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reservations[] = $row;
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations - Admin</title>
    <link rel="stylesheet" href="./ReservationAdmin.css">
    
</head>
<body>

    <main class="hero">
        <header class="navbar">
            <div>
                <h2>Control Panel</h2>
            </div>
            <div class="dashboard">
                <a href="./Admin.php">Dashboard</a>
                <a href="./ReservationAdmin.php" style="color: #E0B973;">Reservations</a>
                <a href="./RoomsAdmin.php">Rooms</a>
                <a href="./LogOut.php" class="panelItem panelLogout">
                    <span>Logout</span>
                </a>
            </div>
        </header>
    </main>

    <div class="reservation-container">
        <div class="reservation-header">
            <h1>📋 All Reservations</h1>
            <a href="./Admin.php" class="btn-back">← Back to Dashboard</a>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Room Type</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reservations)): ?>
                        <?php foreach ($reservations as $res): 
                            $statusClass = '';
                            $statusText = ucfirst($res['bookingStatus'] ?? 'pending');
                            switch(strtolower($res['bookingStatus'] ?? 'pending')) {
                                case 'pending': $statusClass = 'status-pending'; break;
                                case 'confirmed': $statusClass = 'status-confirmed'; break;
                                case 'cancelled': $statusClass = 'status-cancelled'; break;
                                case 'completed': $statusClass = 'status-completed'; break;
                                default: $statusClass = 'status-pending';
                            }
                        ?>
                        <tr>
                            <td>#<?php echo $res['booking_ID']; ?></td>
                            <td><strong><?php echo htmlspecialchars($res['name'] ?? $res['userName'] ?? 'N/A'); ?></strong></td>
                            <td><?php echo htmlspecialchars($res['number'] ?? $res['phoneNumber'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($res['email'] ?? 'N/A'); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($res['typeRoom'] ?? 'N/A')); ?></td>
                            <td><?php echo date('M d, Y', strtotime($res['checkInDate'])); ?></td>
                            <td><?php echo date('M d, Y', strtotime($res['checkOutDate'])); ?></td>
                            <td><strong>$<?php echo htmlspecialchars($res['totalPrice'] ?? '0'); ?></strong></td>
                            <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                            <td><?php echo date('M d, Y H:i', strtotime($res['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">
                                <div class="no-data">
                                    <span>📭</span>
                                    No reservations found yet.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>