<?php
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';
$selected_destination = $_GET['destination'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination = trim($_POST['destination']);
    $travel_date = $_POST['travel_date'];
    $budget = $_POST['budget'];
    $group_size = $_POST['group_size'] ?? 1;
    $whatsapp_link = $_POST['whatsapp_link'];
    
    if (empty($destination) || empty($travel_date) || empty($budget)) {
        $error = "Please fill all required fields!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO trips (user_id, destination, travel_date, budget, group_size, whatsapp_link) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$_SESSION['user_id'], $destination, $travel_date, $budget, $group_size,$whatsapp_link])) {
            $success = "Trip created successfully!";
        } else {
            $error = "Failed to create trip. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Trip - TripSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">TripSync</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="my_trips.php">My Trips</a></li>
                <li><a href="destinations.php">Destinations</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 2rem; color: #667eea;">Plan Your Trip</h2>
        
        <?php if($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
                <a href="my_trips.php" style="display: block; margin-top: 1rem; text-align: center;">View My Trips</a>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="destination">Destination</label>
                <select name="destination" id="destination" class="form-control" required>
                    <option value="">Select Destination</option>
                    <?php
                    $stmt = $pdo->query("SELECT name FROM destinations");
                    while($dest = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <option value="<?php echo htmlspecialchars($dest['name']); ?>" 
                            <?php echo ($selected_destination == $dest['name']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($dest['name']); ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="travel_date">Travel Date</label>
                <input type="date" id="travel_date" name="travel_date" class="form-control" 
                       min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="budget">Budget (₹)</label>
                <input type="number" id="budget" name="budget" class="form-control" 
                       min="1000" step="100" required>
            </div>
            
            <div class="form-group">
                <label for="group_size">Group Size</label>
                <input type="number" id="group_size" name="group_size" class="form-control" 
                       min="1" max="20" value="1" required>
            </div>
            <label>WhatsApp Group Link</label>
            <input type="text" name="whatsapp_link" placeholder="Paste WhatsApp invite link">
            <button type="submit" class="btn" style="width: 100%;">Create Trip</button>
        </form>
    </div>
</body>
</html>
