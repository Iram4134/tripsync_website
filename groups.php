<?php
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Groups - TripSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">TripSync</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="groups.php">Travel Groups</a></li>
                <li><a href="my_trips.php">My Trips</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-header">
        <h1>Travel Groups</h1>
        <p>Find travel partners for your journey</p>
    </div>

    <div class="container">
        <h2 style="margin-bottom: 2rem;">Upcoming Group Trips</h2>
        <div class="grid">
            <?php
            // Get trips from other users with group_size > 1
            $stmt = $pdo->prepare("
                SELECT t.*, u.name as user_name 
                FROM trips t 
                JOIN users u ON t.user_id = u.id 
                WHERE t.travel_date >= CURDATE() 
                AND t.group_size > 1
                ORDER BY t.travel_date ASC 
                LIMIT 12
            ");
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                while ($trip = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="card">
                <h3 class="card-title"><?php echo htmlspecialchars($trip['destination']); ?></h3>
                <p class="card-text">
                    <strong>Organizer:</strong> <?php echo htmlspecialchars($trip['user_name']); ?><br>
                    <strong>Date:</strong> <?php echo date('F j, Y', strtotime($trip['travel_date'])); ?><br>
                    <strong>Budget:</strong> ₹<?php echo number_format($trip['budget'], 2); ?><br>
                    <strong>Group Size:</strong> <?php echo $trip['group_size']; ?> people<br>
                    <small style="color: #999;">Posted: <?php echo date('M j', strtotime($trip['created_at'])); ?></small>
                </p>
                <?php if ($trip['user_id'] != $_SESSION['user_id']): ?>
                    <?php echo $trip['whatsapp_link']; ?>
                    <a href="https://chat.whatsapp.com/H8lgXi2W594FELd72WqXDH?mode=gi_t"target="_blank" class="btn btn-success">
                      Join WhatsApp Group
                   </a>
                <?php else: ?>
                    <span style="color: #667eea;">Your Trip</span>
                <?php endif; ?>
            </div>
            <?php 
                endwhile;
            } else {
                echo '<p>No group trips available at the moment. <a href="create_trip.php">Create one!</a></p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
