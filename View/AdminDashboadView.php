<?php
session_start();

// protect dashboard
if(!isset($_SESSION["email"])){
    header("Location: ../View/AdminLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Asset/AdminDashboardStyle.css">
</head>
<body>

<div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Roy Hotel</h2>

        <ul>
            <li>Dashboard</li>
            <li>Rooms</li>
            <li>Bookings</li>
            <li>Guests</li>
            <li>Reports</li>
        </ul>

        <!-- Logout -->
        <a href="../Controller/LogoutController.php" class="logout-btn">
            Logout
        </a>

    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="top-bar">
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                Logged in as: <?php echo $_SESSION["email"]; ?>
            </div>
        </div>

        <!-- Cards -->
        <div class="cards">

            <div class="card">
                <h3>Occupancy Rate</h3>
                <p>78%</p>
            </div>

            <div class="card">
                <h3>Today's Revenue</h3>
                <p>$12,450</p>
            </div>

            <div class="card">
                <h3>Rooms Status</h3>
                <p>120 Available / 380 Occupied</p>
            </div>

        </div>

        <!-- Bottom Section -->
        <div class="grid">

            <div class="box">
                <h3>Active Maintenance Issues</h3>
                <ul>
                    <li>Room 205 - AC not working</li>
                    <li>Room 310 - Water leakage</li>
                    <li>Room 112 - Light issue</li>
                </ul>
            </div>

            <div class="box">
                <h3>Pending Guest Reviews</h3>
                <ul>
                    <li>John Doe - Room 101</li>
                    <li>Sarah Khan - Room 220</li>
                    <li>Mike Ross - Room 305</li>
                </ul>
            </div>

        </div>

    </div>

</div>

</body>
</html>