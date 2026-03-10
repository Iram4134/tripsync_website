<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery - TripSync</title>
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
                <li><a href="gallery.php">Gallery</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="page-header">
        <h1>Photo Gallery</h1>
        <p>Beautiful moments from Kashmir</p>
    </div>

    <div class="container">
        <div class="gallery-grid">
            <?php
            $images = [
                'Dal Lake Sunrise',
                'Gulmarg Snow',
                'Pahalgam Valley',
                'Sonamarg Meadows',
                'Mughal Gardens',
                'Betaab Valley View',
                'Kashmir Tulips',
                'Shikara Ride',
                'Mountain Vista',
                'Traditional Houseboat',
                'Kashmir Cuisine',
                'Local Handicrafts'
            ];
            
            foreach($images as $image):
            ?>
            <div class="gallery-item">
                <?php echo $image; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
