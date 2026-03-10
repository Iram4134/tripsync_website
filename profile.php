<?php
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get trip statistics
$stmt = $pdo->prepare("SELECT COUNT(*) as trip_count FROM trips WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - TripSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">TripSync</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="my_trips.php">My Trips</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-header">
        <h1>My Profile</h1>
        <p>Your TripSync account information</p>
    </div>

    <div class="container">
        <div class="form-container">
            <div class="card">
                <h2 style="color: #667eea; margin-bottom: 2rem;">Account Details</h2>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong>Name:</strong><br>
                    <p style="font-size: 1.1rem; margin-top: 0.5rem;">
                        <?php echo htmlspecialchars($user['name']); ?>
                    </p>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong>Email:</strong><br>
                    <p style="font-size: 1.1rem; margin-top: 0.5rem;">
                        <?php echo htmlspecialchars($user['email']); ?>
                    </p>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong>Member Since:</strong><br>
                    <p style="font-size: 1.1rem; margin-top: 0.5rem;">
                        <?php echo date('F j, Y', strtotime($user['created_at'])); ?>
                    </p>
                </div>
                
                <hr style="margin: 2rem 0;">
                
                <h3 style="color: #667eea; margin-bottom: 1rem;">Statistics</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="card" style="text-align: center; background: #f8f9fa;">
                        <h4><?php echo $stats['trip_count']; ?></h4>
                        <p>Total Trips</p>
                    </div>
                    
                    <div class="card" style="text-align: center; background: #f8f9fa;">
                        <h4>Active</h4>
                        <p>Account Status</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
