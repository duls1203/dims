<?php
include '../config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch data for the table (you may replace this query with pagination logic as needed)
$query = "SELECT * FROM inventory LIMIT 10";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="inventory.css">
    <title>Inventory</title>
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
                    <li><a href="inventory.php" class="active">Inventory</a></li>
                    <li><a href="distribution.php">Distribution</a></li>
                    <li><a href="user_management.php">User Management</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="../index.html">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="inventory-content">
            <h1>Inventory</h1>
            <div class="search-container">
                <input type="text" id="search" placeholder="Search Inventory..." onkeyup="filterTable()">
            </div>
            <table id="inventory-table">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Expiry Date</th>
                        <th>Date Received</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['item_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['unit']); ?></td>
                            <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_received']); ?></td>
                            <td><?php echo htmlspecialchars($row['remarks']); ?></td>
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
    </div>

    <script>
        // JavaScript to filter the inventory table
        function filterTable() {
            const searchValue = document.getElementById("search").value.toLowerCase();
            const rows = document.querySelectorAll("#inventory-table tbody tr");

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? "" : "none";
            });
        }
    </script>
</body>
</html>
