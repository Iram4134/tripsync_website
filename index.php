<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripSync - Your Kashmir Travel Companion</title>
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
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Discover Kashmir with TripSync</h1>
            <p>Plan your perfect trip, find travel partners, and explore the paradise on Earth</p>
            <div class="hero-buttons">
                <a href="destinations.php" class="btn">Explore Destinations</a>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <a href="register.php" class="btn btn-secondary">Get Started</a>
                <?php else: ?>
                    <a href="create_trip.php" class="btn btn-secondary">Plan a Trip</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2>Why Choose TripSync?</h2>
            <div class="grid">
                <div class="feature-card">
                    <div class="feature-icon">🗺️</div>
                    <h3>Discover Destinations</h3>
                    <p>Explore the most beautiful locations in Kashmir with detailed information and reviews</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Find Travel Partners</h3>
                    <p>Connect with like-minded travelers heading to the same destinations</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Budget Planning</h3>
                    <p>Calculate and manage your travel budget with our smart calculator</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📸</div>
                    <h3>Share Experiences</h3>
                    <p>View and share stunning photos from your Kashmir adventures</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Destinations -->
    <section style="padding: 60px 0;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 2rem; color: #667eea;">Popular Destinations</h2>
            <div class="grid">
                <?php
                $stmt = $pdo->query("SELECT * FROM destinations LIMIT 3");
                while($dest = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                <div class="destination-card">
                    <div class="destination-image">
                        <?php echo htmlspecialchars($dest['name']); ?>
                    </div>
                    <div class="destination-content">
                        <h3 class="destination-title"><?php echo htmlspecialchars($dest['name']); ?></h3>
                        <p class="destination-description">
                            <?php echo htmlspecialchars(substr($dest['description'], 0, 100)) . '...'; ?>
                        </p>
                        <div class="destination-meta">
                            <span>📍 <?php echo htmlspecialchars($dest['location']); ?></span>
                            <span>🌤️ <?php echo htmlspecialchars($dest['best_season']); ?></span>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
</body>
</html>
