<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Management System</title>
    <link rel="stylesheet" href="user.css">
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
                    <li><a href="#home">Home</a></li>
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

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1>Streamlining Donations for a Better Future</h1>
                <p>Welcome to the City College of Calamba’s centralized donation and inventory system. Make a difference with every donation!</p>
                <div class="hero-buttons">
                    <a href="donate.php" class="btn primary-btn">Donate Now</a>
                    <a href="#about" class="btn secondary-btn">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <h2>About Our System</h2>
            <p>Our system aims to simplify donation management and inventory tracking for the City College of Calamba. By providing a centralized platform, we promote transparency and efficiency in managing resources.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2>Key Features</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <h3>Donation Tracking</h3>
                    <p>Monitor donations in real time with detailed reports.</p>
                </div>
                <div class="feature-item">
                    <h3>Inventory Management</h3>
                    <p>Keep track of resources efficiently and reduce waste.</p>
                </div>
                <div class="feature-item">
                    <h3>User Management</h3>
                    <p>Ensure secure access with multi-user authentication.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call-to-Action Section -->
    <section class="cta" id="donate">
        <div class="container">
            <h2>Make a Difference Today!</h2>
            <p>Your donation can help improve lives and empower our community. Join us in making a positive impact!</p>
            <a href="donate.php" class="btn primary-btn">Donate Now</a>
        </div>
    </section>

    <!-- How to Use Section -->
    <section class="how-to-use" id="how-to-use">
        <div class="container">
            <h2>How to Use the System</h2>
            <div class="steps-grid">
                <div class="step">
                    <h3>Step 1: Register</h3>
                    <p>Create your account by providing your basic details.</p>
                </div>
                <div class="step">
                    <h3>Step 2: Explore</h3>
                    <p>Browse available donation opportunities and inventory reports.</p>
                </div>
                <div class="step">
                    <h3>Step 3: Donate</h3>
                    <p>Choose what you’d like to donate and confirm your contribution.</p>
                </div>
                <div class="step">
                    <h3>Step 4: Track</h3>
                    <p>Monitor the status of your donation and its impact.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <p>If you have any questions or need assistance, feel free to reach out!</p>
            <form action="#" method="post">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                <button type="submit" class="btn primary-btn">Send Message</button>
            </form>
        </div>
    </section>

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

