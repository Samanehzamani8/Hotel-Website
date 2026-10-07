<?php
session_start();

if (isset($_SESSION['user']) && $_SESSION['user'] === 'Admin') {
    header("Location: ./Admin.php");
    exit();
}

$link = mysqli_connect("localhost", "root", "", "otelio_hotel");
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM room WHERE LOWER(roomType) = 'double' ORDER BY room_ID DESC";
$result = mysqli_query($link, $sql);

$rooms = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Double Rooms - Otelio</title>
    <link rel="stylesheet" href="./SingleRoom.css">
</head>
<body>

<div class="roomContainer">

    <div style="margin-bottom: 25px;">
        <a href="./Room.php" style="
            display: inline-block;
            background: transparent;
            color: #14274A;
            border: 2px solid #14274A;
            padding: 10px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s;
        " onmouseover="this.style.background='#14274A'; this.style.color='white'; this.style.transform='translateX(-5px)';" 
        onmouseout="this.style.background='transparent'; this.style.color='#14274A'; this.style.transform='translateX(0)';">
            ← Back to Rooms
        </a>
    </div>

    <div class="pageTitle">
        <h1>🛏️ Double Rooms</h1>
        <p>Spacious and elegant double rooms for couples and families</p>
    </div>

    <div class="roomGrid">
        <?php if (!empty($rooms)): ?>
            <?php foreach ($rooms as $room): 
                $statusClass = '';
                switch(strtolower($room['status'] ?? '')) {
                    case 'available': $statusClass = 'status-available'; break;
                    case 'booked': $statusClass = 'status-booked'; break;
                    case 'maintenance': $statusClass = 'status-maintenance'; break;
                    default: $statusClass = '';
                }
            ?>
            <div class="roomCard">
                <img src="<?php echo htmlspecialchars($room['imageRoom']); ?>" 
                     alt="<?php echo htmlspecialchars($room['roomType']); ?>" 
                     class="roomImage"
                     onerror="this.src='./img/default-room.jpg'">
                
                <div class="roomInfo">
                    <span class="roomBadge">DOUBLE</span>
                    <h2 class="roomTitle">Double Room</h2>
                    <p class="roomSubtitle">Room #<?php echo htmlspecialchars($room['roomNumber'] ?? 'N/A'); ?></p>
                    
                    <div class="roomPrice">
                        $<?php echo htmlspecialchars($room['priceOfNight'] ?? '0'); ?> <span>/ night</span>
                    </div>
                    
                    <span class="roomStatus <?php echo $statusClass; ?>">
                        ● <?php echo ucfirst(htmlspecialchars($room['status'] ?? 'Unknown')); ?>
                    </span>
                    
                    <p class="roomDescription">
                        <?php echo htmlspecialchars($room['description'] ?? 'A spacious double room with all modern amenities for a comfortable stay.'); ?>
                    </p>
                    
                    <div class="roomMeta">
                        <div class="metaItem">
                            <span class="metaIcon">🛏️</span>
                            <span>Double Bed</span>
                        </div>
                        <div class="metaItem">
                            <span class="metaIcon">👥</span>
                            <span>2 Guests</span>
                        </div>
                    </div>
                    
                    <?php

                    if (isset($_SESSION['user'])) {
                        echo '<a href="Booking.html" class="btnBook">Book Now</a>';
                    } else {
                        echo '<a href="LoginForm.php" class="btnBook">Book Now</a>';
                    }
                    ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="errorCard">
                <span>🛏️</span>
                <h2>No Double Rooms Available</h2>
                <p>We currently don't have any double rooms available.</p>
                <a href="./Room.php" class="btnBook">← Back to Rooms</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>