<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../Asset/AdminDashboard.css">
</head>
<body>

    <div class="dashboard-container">

        <!-- Sidebar -->
        <div class="sidebar">
            <h2>ROY HOTEL</h2>

            <ul>
                <li><a href="RoomView.php">Rooms</a></li>
                <li><a href="RoomTypesView.php">Room Types</a></li>
                <li><a href="ReceptionistView.php">Receptionist</a></li>
                <li><a href="SupervisorView.php">Housekeeping Supervisor</a></li>
                <li><a href="GuestView.php">Guests</a></li>
                <li><a href="BookingView.php">Booking</a></li>
                <li><a href="ReportView.php">Financial Reports</a></li>
                <li>Maintenance</li>
                <li>Reviews</li>
                <li><a href="Admin.LoginView.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">

            <div class="topbar">
                <h1>Admin Dashboard</h1>
                <p>Welcome Back, Admin</p>
            </div>

            <!-- Cards -->
            <div class="card-container">

                <div class="card">
                    <h3>Current Occupancy Rate</h3>
                    <p>82%</p>
                </div>

                <div class="card">
                    <h3>Today's Total Revenue</h3>
                    <p>$12,450</p>
                </div>

                <div class="card">
                    <h3>Rooms Available</h3>
                    <p>45 Rooms</p>
                </div>

                <div class="card">
                    <h3>Rooms Occupied</h3>
                    <p>205 Rooms</p>
                </div>

                <div class="card">
                    <h3>Active Maintenance Issues</h3>
                    <p>7 Issues</p>
                </div>

                <div class="card">
                    <h3>Pending Guest Reviews</h3>
                    <p>18 Reviews</p>
                </div>

            </div>

            <!-- Tables -->
            <div class="table-section">

                <div class="table-box">
                    <h2>Maintenance Requests</h2>

                    <table>
                        <tr>
                            <th>Room</th>
                            <th>Issue</th>
                            <th>Status</th>
                        </tr>

                        <tr>
                            <td>203</td>
                            <td>AC Not Working</td>
                            <td>Pending</td>
                        </tr>

                        <tr>
                            <td>117</td>
                            <td>Broken Shower</td>
                            <td>In Progress</td>
                        </tr>

                        <tr>
                            <td>309</td>
                            <td>Light Replacement</td>
                            <td>Pending</td>
                        </tr>
                    </table>
                </div>

                <div class="table-box">
                    <h2>Pending Guest Reviews</h2>

                    <table>
                        <tr>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Rating</th>
                        </tr>

                        <tr>
                            <td>John Doe</td>
                            <td>204</td>
                            <td>4.5</td>
                        </tr>

                        <tr>
                            <td>Sarah Smith</td>
                            <td>111</td>
                            <td>5.0</td>
                        </tr>

                        <tr>
                            <td>Michael Lee</td>
                            <td>315</td>
                            <td>4.0</td>
                        </tr>
                    </table>
                </div>

            </div>

        </div>

    </div>

</body>
</html>