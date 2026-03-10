<?php
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TripSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">TripSync</a>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="destinations.php">Destinations</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding: 2rem 20px;">
        <h1 style="color: #667eea; margin-bottom: 2rem;">Welcome back, <?php echo htmlspecialchars($user_name); ?>!</h1>
        
        <div class="dashboard-grid">
            <a href="create_trip.php" class="dashboard-card">
                <h3>📅</h3>
                <h3>Plan New Trip</h3>
                <p>Create your next adventure</p>
            </a>
            
            <a href="my_trips.php" class="dashboard-card">
                <h3>✈️</h3>
                <h3>My Trips</h3>
                <p>View your planned trips</p>
            </a>
            
            <a href="destinations.php" class="dashboard-card">
                <h3>🏔️</h3>
                <h3>Destinations</h3>
                <p>Explore Kashmir locations</p>
            </a>
            
            <a href="groups.php" class="dashboard-card">
                <h3>👥</h3>
                <h3>Travel Groups</h3>
                <p>Find travel partners</p>
            </a>
            
            <a href="budget.php" class="dashboard-card">
                <h3>💰</h3>
                <h3>Budget Calculator</h3>
                <p>Plan your expenses</p>
            </a>
            
            <a href="reviews.php" class="dashboard-card">
                <h3>⭐</h3>
                <h3>Reviews</h3>
                <p>Share your experiences</p>
            </a>
        </div>

        <!-- Recent Trips -->
        <h2 style="margin-top: 3rem; color: #667eea;">Your Recent Trips</h2>
        <div class="grid">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM trips WHERE user_id = ? ORDER BY created_at DESC LIMIT 3");
            $stmt->execute([$_SESSION['user_id']]);
            
            if ($stmt->rowCount() > 0) {
                while ($trip = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="card">
                <h3 class="card-title"><?php echo htmlspecialchars($trip['destination']); ?></h3>
                <p class="card-text">
                    <strong>Date:</strong> <?php echo date('F j, Y', strtotime($trip['travel_date'])); ?><br>
                    <strong>Budget:</strong> ₹<?php echo number_format($trip['budget'], 2); ?><br>
                    <strong>Group Size:</strong> <?php echo $trip['group_size']; ?> people
                </p>
            </div>
            <?php 
                endwhile;
            } else {
                echo '<p>No trips planned yet. <a href="create_trip.php">Plan your first trip!</a></p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
