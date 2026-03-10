<?php
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$total = 0;
$breakdown = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $days = intval($_POST['days']);
    $hotel = floatval($_POST['hotel']);
    $food = floatval($_POST['food']);
    $transport = floatval($_POST['transport']);
    $activities = floatval($_POST['activities']);
    
    $breakdown = [
        'Accommodation' => $hotel * $days,
        'Food' => $food * $days,
        'Transportation' => $transport,
        'Activities' => $activities
    ];
    
    $total = array_sum($breakdown);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Calculator - TripSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">TripSync</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="budget.php">Budget Calculator</a></li>
                <li><a href="my_trips.php">My Trips</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-header">
        <h1>Trip Budget Calculator</h1>
        <p>Plan your expenses wisely</p>
    </div>

    <div class="container">
        <div class="form-container budget-form">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="days">Number of Days</label>
                    <input type="number" id="days" name="days" class="form-control" 
                           min="1" max="30" value="3" required>
                </div>
                
                <div class="form-group">
                    <label for="hotel">Hotel Cost (per night)</label>
                    <input type="number" id="hotel" name="hotel" class="form-control" 
                           min="0" step="100" placeholder="2000" required>
                </div>
                
                <div class="form-group">
                    <label for="food">Food Cost (per day)</label>
                    <input type="number" id="food" name="food" class="form-control" 
                           min="0" step="50" placeholder="800" required>
                </div>
                
                <div class="form-group">
                    <label for="transport">Transportation (total)</label>
                    <input type="number" id="transport" name="transport" class="form-control" 
                           min="0" step="100" placeholder="5000" required>
                </div>
                
                <div class="form-group">
                    <label for="activities">Activities & Sightseeing (total)</label>
                    <input type="number" id="activities" name="activities" class="form-control" 
                           min="0" step="100" placeholder="3000" required>
                </div>
                
                <button type="submit" class="btn" style="width: 100%;">Calculate Budget</button>
            </form>
        </div>

        <?php if ($total > 0): ?>
        <div class="budget-result">
            <h3>Estimated Trip Budget</h3>
            <div class="budget-total">₹<?php echo number_format($total, 2); ?></div>
            
            <div style="margin-top: 2rem; text-align: left;">
                <h4>Breakdown:</h4>
                <?php foreach($breakdown as $category => $amount): ?>
                <p><?php echo $category; ?>: ₹<?php echo number_format($amount, 2); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
