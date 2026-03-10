<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations - TripSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">TripSync</a>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="destinations.php">Destinations</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="page-header">
        <h1>Kashmir Destinations</h1>
        <p>Explore the paradise on Earth</p>
    </div>

    <div class="container">
        <div class="grid">
            <?php
            $stmt = $pdo->query("SELECT * FROM destinations");
            while($dest = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="destination-card">
                <div class="destination-image">
                    <?php echo htmlspecialchars($dest['name']); ?>
                </div>
                <div class="destination-content">
                    <h3 class="destination-title"><?php echo htmlspecialchars($dest['name']); ?></h3>
                    <p class="destination-description">
                        <?php echo htmlspecialchars($dest['description']); ?>
                    </p>
                    <div class="destination-meta">
                        <span>📍 <?php echo htmlspecialchars($dest['location']); ?></span>
                        <span>🌤️ <?php echo htmlspecialchars($dest['best_season']); ?></span>
                    </div>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="create_trip.php?destination=<?php echo urlencode($dest['name']); ?>" class="btn" style="margin-top: 1rem;">Plan Trip Here</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
