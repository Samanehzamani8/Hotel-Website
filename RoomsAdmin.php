<?php
session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || $_SESSION['user'] !== 'Admin') {
    header("Location: ./LoginForm.php");
    exit();
}

$link = mysqli_connect("localhost", "root", "", "otelio_hotel");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $roomId = (int)$_GET['delete'];
    $deleteSql = "DELETE FROM room WHERE room_ID = $roomId";
    if (mysqli_query($link, $deleteSql)) {
        $successMsg = "✅ Room deleted successfully!";
    } else {
        $errorMsg = "❌ Failed to delete room: " . mysqli_error($link);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_room'])) {
    $roomId = (int)$_POST['room_ID'];
    $roomNumber = mysqli_real_escape_string($link, $_POST['roomNumber']);
    $price = mysqli_real_escape_string($link, $_POST['price']);
    $typeRoom = mysqli_real_escape_string($link, $_POST['typeRoom']);
    $status = mysqli_real_escape_string($link, $_POST['status']);
    $description = mysqli_real_escape_string($link, $_POST['description']);

    $updateSql = "UPDATE room SET 
                  roomNumber = '$roomNumber',
                  priceOfNight = '$price',
                  roomType = '$typeRoom',
                  status = '$status',
                  description = '$description'
                  WHERE room_ID = $roomId";

    if (mysqli_query($link, $updateSql)) {
        $successMsg = "✅ Room updated successfully!";
    } else {
        $errorMsg = "❌ Failed to update room: " . mysqli_error($link);
    }
}

$sql = "SELECT * FROM room ORDER BY room_ID DESC";
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
    <title>Manage Rooms - Admin</title>
    <link rel="stylesheet" href="./RoomsAdmin.css">
    <style>
        
    </style>
</head>
<body>

    <main class="hero">
        <header class="navbar">
            <div>
                <h2>Control Panel</h2>
            </div>
            <div class="dashboard">
                <a href="./Admin.php">Dashboard</a>
                <a href="./ReservationAdmin.php">Reservations</a>
                <a href="./RoomsAdmin.php" style="color: #E0B973;">Rooms</a>
                <a href="./LogOut.php" class="panelItem panelLogout">
                    <span>Logout</span>
                </a>
            </div>
        </header>
    </main>

    <div class="rooms-container">
        <div class="rooms-header">
            <h1>🏨 Manage Rooms</h1>
            <div class="actions">
                <a href="./ProductRoom.html" class="btn-add">+ Add New Room</a>
                <a href="./Admin.php" class="btn-back">← Back</a>
            </div>
        </div>

        <?php if (isset($successMsg)): ?>
            <div class="alert alert-success"><?php echo $successMsg; ?></div>
        <?php endif; ?>
        <?php if (isset($errorMsg)): ?>
            <div class="alert alert-error"><?php echo $errorMsg; ?></div>
        <?php endif; ?>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room Number</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rooms)): ?>
                        <?php foreach ($rooms as $room): 
                            $statusClass = '';
                            switch(strtolower($room['status'] ?? '')) {
                                case 'available': $statusClass = 'status-available'; break;
                                case 'booked': $statusClass = 'status-booked'; break;
                                case 'maintenance': $statusClass = 'status-maintenance'; break;
                                default: $statusClass = '';
                            }
                            $isEditing = isset($_GET['edit']) && $_GET['edit'] == $room['room_ID'];
                        ?>
                        <tr class="<?php echo $isEditing ? 'editing' : ''; ?>">
                            <td>#<?php echo $room['room_ID']; ?></td>
                           
                            <?php if ($isEditing): ?>
                                
                                <form method="POST" style="display: contents;">
                                    <input type="hidden" name="room_ID" value="<?php echo $room['room_ID']; ?>">
                                    <input type="hidden" name="edit_room" value="1">
                                    <td><input type="number" name="roomNumber" value="<?php echo htmlspecialchars($room['roomNumber']); ?>" required></td>
                                    <td>
                                        <select name="typeRoom" required>
                                            <option value="single" <?php echo $room['roomType'] == 'single' ? 'selected' : ''; ?>>Single</option>
                                            <option value="double" <?php echo $room['roomType'] == 'double' ? 'selected' : ''; ?>>Double</option>
                                            <option value="twin" <?php echo $room['roomType'] == 'twin' ? 'selected' : ''; ?>>Twin</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="price" value="<?php echo htmlspecialchars($room['priceOfNight']); ?>" required></td>
                                    <td>
                                        <select name="status" required>
                                            <option value="available" <?php echo $room['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                                            <option value="booked" <?php echo $room['status'] == 'booked' ? 'selected' : ''; ?>>Booked</option>
                                            <option value="maintenance" <?php echo $room['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                                        </select>
                                    </td>
                                    <td><textarea name="description" rows="1"><?php echo htmlspecialchars($room['description'] ?? ''); ?></textarea></td>
                                    <td><?php echo date('M d, Y', strtotime($room['created_at'])); ?></td>
                                    <td>
                                        <div class="edit-actions">
                                            <button type="submit" class="btn-save">💾 Save</button>
                                            <a href="./rooms-admin.php" class="btn-cancel">✖ Cancel</a>
                                        </div>
                                    </td>
                                </form>
                            <?php else: ?>
                                
                                <td><strong><?php echo htmlspecialchars($room['roomNumber']); ?></strong></td>
                                <td><?php echo ucfirst(htmlspecialchars($room['roomType'])); ?></td>
                                <td><strong>$<?php echo htmlspecialchars($room['priceOfNight']); ?></strong></td>
                                <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo ucfirst(htmlspecialchars($room['status'])); ?></span></td>
                                <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo htmlspecialchars(substr($room['description'] ?? '', 0, 40)); ?>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($room['created_at'])); ?></td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="?edit=<?php echo $room['room_ID']; ?>" class="btn-edit">✏️ Edit</a>
                                        <a href="?delete=<?php echo $room['room_ID']; ?>" 
                                           class="btn-delete" 
                                           onclick="return confirm('Are you sure you want to delete this room?');">🗑️ Delete</a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="no-data">
                                    <span>🏨</span>
                                    No rooms found. Add your first room!
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