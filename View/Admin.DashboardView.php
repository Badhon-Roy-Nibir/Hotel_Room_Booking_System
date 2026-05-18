<?php
    session_start();

    if(!isset($_SESSION["email"])){
        header("Location: Admin.LoginView.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Asset/AdminDashboardStyle.css">
</head>

<body onload="loadTodaysRevenue(); loadOccupancyRate(); loadAvailableRooms(); loadOccupiedRooms(); loadActiveIssues(); loadPendingReviews();">

<div class="dashboard-container">

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">
        <h2>ROY HOTEL</h2>

        <ul>
            <li><a href="RoomView.php">Rooms</a></li>
            <li><a href="RoomTypesView.php">Room Types</a></li>
            <li><a href="ReceptionistView.php">Receptionist</a></li>
            <li><a href="SupervisorView.php">Housekeeping</a></li>
            <li><a href="GuestView.php">Guests</a></li>
            <li><a href="BookingView.php">Booking</a></li>
            <li><a href="AdminLogout.php">Logout</a></li>
        </ul>
    </div>

    <!-- ================= MAIN CONTENT ================= -->
    <div class="main-content">

        <!-- TOP BAR -->
        <div class="topbar">
            <h1>Admin Dashboard</h1>
            <p>Welcome Back, Admin</p>
        </div>

        <!-- ================= CARDS ================= -->
        <div class="card-container">

            <div class="card">
                <h3>Today's Revenue</h3>
                <p>$<span id="todaysRevenue">0</span></p>
            </div>

            <div class="card">
                <h3>Occupancy Rate</h3>
                <p><span id="occupancyRate">0%</span></p>
            </div>

            <div class="card">
                <h3>Rooms Available</h3>
                <table>
                    <thead>
                        <tr><th>Room Number</th></tr>
                    </thead>
                    <tbody id="availableRoomsTable">
                        <tr><td>Loading...</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3>Rooms Occupied</h3>
                <table>
                    <thead>
                        <tr><th>Room Number</th></tr>
                    </thead>
                    <tbody id="occupiedRoomsTable">
                        <tr><td>Loading...</td></tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ================= TABLES (STACKED) ================= -->
        <div class="table-section">

            <!-- ACTIVE ISSUES -->
            <div class="table-box">
                <h2>Active Maintenance Issues</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Issue</th>
                            <th>Status</th>
                            <th>Reported At</th>
                        </tr>
                    </thead>

                    <tbody id="issuesTableBody">
                        <tr><td colspan="4">Loading...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- PENDING REVIEWS -->
            <div class="table-box">
                <h2>Pending Guest Reviews</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Guest ID</th>
                            <th>Rating</th>
                            <th>Cleanliness</th>
                            <th>Service</th>
                            <th>Review</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody id="pendingReviewsTable">
                        <tr><td colspan="7">Loading reviews...</td></tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<script src="../Asset/AdminAjax.js" defer></script>

</body>
</html>