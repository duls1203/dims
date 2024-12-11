<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Include database configuration
include '../config.php';

// Fetch all donations
$sql = "SELECT item_name, category, description, quantity, unit, expiry_date FROM inventory";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Donations</title>
    <link rel="stylesheet" href="inventory.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="#"><img src="../images/CCC logo.png" alt="Logo"></a>
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="user.php">Home</a></li>
                    <li><a href="donate.php">Donate</a></li>
                    <li><a href="my_donations.php">My Donations</a></li>
                    <li><a href="inventory.php">Inventory</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="../index.html" class="btn logout-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Sticky Donate Button -->
    <a href="donate.php" class="sticky-donate-btn">Donate</a>

        <!-- Main Content -->
        <main class="inventory-content">
            <h1>Inventory</h1>
            <div class="search-container">
                <input type="text" id="search" placeholder="Search Inventory..." onkeyup="filterTable()">
            </div>
            <table id="inventory-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['unit']); ?></td>
                            <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="pagination">
                <!-- Placeholder pagination buttons -->
                <button>« Previous</button>
                <button>1</button>
                <button>2</button>
                <button>3</button>
                <button>Next »</button>
            </div>
        </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 City College of Calamba. All rights reserved.</p>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
