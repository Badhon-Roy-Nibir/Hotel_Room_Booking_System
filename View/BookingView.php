<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hotel Booking Management</title>
    <link rel="stylesheet" href="../Asset/BookingStyle.css">
</head>

<body onload="loadBookings()">

    <h1>All Hotel Bookings</h1>

    <!-- ================= FILTER SECTION ================= -->
    <div>

        <!-- STATUS -->
        <label>Status:</label>
        <select id="statusFilter" onchange="loadBookings()">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
        </select>

        <!-- ROOM TYPE -->
        <label>Room Type:</label>
        
        <input type="text" placeholder="e.g. 101, 102,..." id="roomTypeFilter" onchange="loadBookings()">

        <!-- SOURCE -->
        <label>Source:</label>
        <select id="sourceFilter" onchange="loadBookings()">
            <option value="">All</option>
            <option value="online">Online</option>
            <option value="walk_in">Walk_in</option>
        </select>

        <br><br>

        <!-- DATE RANGE -->
        <label>From:</label>
        <input type="date" id="fromDate" onchange="loadBookings()">

        <label>To:</label>
        <input type="date" id="toDate" onchange="loadBookings()">

        <button onclick="loadBookings()">Apply Filter</button>
        <button onclick="resetFilters()">Reset</button>

    </div>

    <br>

    <!-- ================= BOOKINGS TABLE ================= -->
    <table border="1" width="100%">

        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Guest Name</th>
                <th>Room Type</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>Source</th>
                <th>Total Price</th>
            </tr>
        </thead>

        <tbody id="bookingTable">
            <!-- AJAX DATA WILL LOAD HERE -->
        </tbody>

    </table>

    <script src="../Asset/BookingAjax.js"></script>

</body>
</html>