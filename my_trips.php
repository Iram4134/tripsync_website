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
    <title>My Trips - TripSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">TripSync</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="create_trip.php">Create Trip</a></li>
                <li><a href="my_trips.php">My Trips</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-header">
        <h1>My Trips</h1>
        <p>Your planned adventures</p>
    </div>

    <div class="container">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM trips WHERE user_id = ? ORDER BY travel_date ASC");
        $stmt->execute([$_SESSION['user_id']]);
        
        if ($stmt->rowCount() > 0):
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Destination</th>
                    <th>Travel Date</th>
                    <th>Budget</th>
                    <th>Group Size</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php while($trip = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($trip['destination']); ?></td>
                    <td><?php echo date('F j, Y', strtotime($trip['travel_date'])); ?></td>
                    <td>₹<?php echo number_format($trip['budget'], 2); ?></td>
                    <td><?php echo $trip['group_size']; ?> people</td>
                    <td><?php echo ucfirst($trip['status']); ?></td>
                    <td><?php echo date('M j, Y', strtotime($trip['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="card">
            <h3>No trips planned yet</h3>
            <p>Start planning your Kashmir adventure!</p>
            <a href="create_trip.php" class="btn">Create Your First Trip</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
