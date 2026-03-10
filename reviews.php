<?php
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $destination_id = $_POST['destination_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, destination_id, rating, review_text) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$_SESSION['user_id'], $destination_id, $rating, $review_text])) {
        $message = '<div class="alert alert-success">Review submitted successfully!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - TripSync</title>
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
                <li><a href="reviews.php">Reviews</a></li>
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
        <h1>Destination Reviews</h1>
        <p>Share your experiences</p>
    </div>

    <div class="container">
        <?php echo $message; ?>
        
        <?php if(isset($_SESSION['user_id'])): ?>
        <div class="form-container">
            <h3>Write a Review</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="destination_id">Destination</label>
                    <select name="destination_id" id="destination_id" class="form-control" required>
                        <option value="">Select Destination</option>
                        <?php
                        $stmt = $pdo->query("SELECT id, name FROM destinations");
                        while($dest = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <option value="<?php echo $dest['id']; ?>">
                            <?php echo htmlspecialchars($dest['name']); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select name="rating" id="rating" class="form-control" required>
                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                        <option value="4">⭐⭐⭐⭐ Very Good</option>
                        <option value="3">⭐⭐⭐ Good</option>
                        <option value="2">⭐⭐ Fair</option>
                        <option value="1">⭐ Poor</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="review_text">Your Review</label>
                    <textarea name="review_text" id="review_text" class="form-control" 
                              rows="4" required></textarea>
                </div>
                
                <button type="submit" class="btn" style="width: 100%;">Submit Review</button>
            </form>
        </div>
        <?php endif; ?>

        <h2 style="margin-top: 3rem;">Recent Reviews</h2>
        
        <?php
        $stmt = $pdo->query("
            SELECT r.*, u.name as user_name, d.name as destination_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            JOIN destinations d ON r.destination_id = d.id 
            ORDER BY r.created_at DESC 
            LIMIT 10
        ");
        
        while($review = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
        <div class="review-card">
            <div class="review-header">
                <span class="review-author"><?php echo htmlspecialchars($review['user_name']); ?></span>
                <span class="review-rating"><?php echo str_repeat('⭐', $review['rating']); ?></span>
            </div>
            <h4><?php echo htmlspecialchars($review['destination_name']); ?></h4>
            <p class="review-text"><?php echo htmlspecialchars($review['review_text']); ?></p>
            <small style="color: #999;">
                <?php echo date('F j, Y', strtotime($review['created_at'])); ?>
            </small>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
