<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Donation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="distribution.css">
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
                    <li><a href="add_donation.php" class="active">Add Donation</a></li>
                    <li><a href="inventory.php">Inventory</a></li>
                    <li><a href="distribution.php">Distribution</a></li>
                    <li><a href="user_management.php">User Management</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="../index.html">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <h1>Distribute Donation</h1>
            <div class="distribution-box-container">
                <div class="distribution-box">
                    <h2>Cash Distribution</h2>
                    <p>Record a cash distributed.</p>
                    <a href="cash_distribution.php" class="btn">Go to Cash Distribution</a>
                </div>
                <div class="distribution-box">
                    <h2>In-Kind Distribution</h2>
                    <p>Record an in-kind distributed.</p>
                    <a href="in-kind_distribution.php" class="btn">Go to In-Kind Distribution</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
