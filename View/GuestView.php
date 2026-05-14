<?php
// echo " i am guest";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Guest Account Management</title>
    <link rel="stylesheet" href="../Asset/GuestStyle.css">
</head>

<body onload="loadGuests()">

    <h1>Manage Guest Accounts</h1>

    <!-- ================= SEARCH SECTION ================= -->
    <div>
        <input 
            type="text"
            id="searchInput"
            placeholder="Search guest by name or email"
            onkeyup="searchGuests()"
        >

        <button onclick="loadGuests()">
            Refresh
        </button>
    </div>

    <br>

    <!-- ================= GUEST TABLE ================= -->
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Profile</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody id="guestTable">
            <!-- AJAX DATA WILL LOAD HERE -->
        </tbody>
    </table>

    <script src="../Asset/GuestAjax.js"></script>

</body>
</html>