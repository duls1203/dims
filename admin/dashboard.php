<?php
// Include authentication and database connection
include '../config.php';

// Fetch statistics (example queries, adapt to your database structure)
$total_inventory = 0; 
$total_cash_in_hand = 0;
$total_cash_distributed = 0;
$total_donations = 0;

// Fetch Total Inventory
$inventoryQuery = "SELECT SUM(quantity) AS total_quantity FROM inventory";
$result = $conn->query($inventoryQuery);
if ($result && $row = $result->fetch_assoc()) {
    $total_inventory = $row['total_quantity'];
}

// Fetch Total Cash in Hand
$cashInHandQuery = "SELECT SUM(amount) AS total_cash FROM cash_in";
$cashResult = $conn->query($cashInHandQuery);
if ($cashResult && $row = $cashResult->fetch_assoc()) {
    $total_cash_in_hand = $row['total_cash'];
}

// Fetch Total Cash Distributed
$cashOutQuery = "SELECT SUM(amount_received) AS total_distributed FROM cash_out";
$cashOutResult = $conn->query($cashOutQuery);
if ($cashOutResult && $row = $cashOutResult->fetch_assoc()) {
    $total_cash_distributed = $row['total_distributed'];
}

// Fetch Total Donations
$total_donations = $total_cash_in_hand + $total_cash_distributed;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <!-- Top Header -->
        <header class="header">
            <div class="logo">City College of Calamba Donation System</div>
        </header>

        <!-- Sidebar -->
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="add_donation.php">Add Donation</a></li>
                    <li><a href="inventory.php">Inventory</a></li>
                    <li><a href="distribution.php">Distribution</a></li>
                    <li><a href="user_management.php">User Management</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="../index.html">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-content">
            <h1>Dashboard</h1>
            <div class="stats-container">
                <div class="stat-box">
                    <h2><a href="inventory.php">Total Inventory</a></h2>
                    <p><?php echo $total_inventory; ?></p>
                </div>
                <div class="stat-box">
                    <h2><a href="">Cash in Hand</a></h2>
                    <p>₱<?php echo number_format($total_cash_in_hand, 2); ?></p>
                </div>
                <div class="stat-box">
                    <h2>Cash Distributed</h2>
                    <p>₱<?php echo number_format($total_cash_distributed, 2); ?></p>
                </div>
                <div class="stat-box">
                    <h2>Total Donations</h2>
                    <p>₱<?php echo number_format($total_donations, 2); ?></p>
                </div>
                <div class="stat-box">
                    <h2>Pending Requests</h2>
                    <p>0</p> <!-- Placeholder for pending requests -->
                </div>
            </div>
        </main>
    </div>
</body>
</html>
