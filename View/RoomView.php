<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>

    <link rel="stylesheet" href="../Asset/Room.css">
</head>

<body onload="loadRooms()">

<div class="container">

    <!-- TOP BAR -->
    <div class="topbar">
        <h1>Room Management</h1>

    </div>


    <!-- FORM -->
    <div class="form-container">

        <h2>Add / Edit Room</h2>

        <form id="roomForm" onsubmit="addRoom(event)">

            <!-- hidden ID for update -->
            <input type="hidden" id="roomId">

            <!-- ROOM NUMBER -->
            <div class="input-group">
                <label>Room Number</label>
                <input type="text" id="roomNumber" placeholder="Enter Room Number" required>
            </div>


            <!-- ROOM TYPE (IMPORTANT: ID based) -->
            <div class="input-group">
                <label>Room Type</label>
                <select id="roomType" required>
                    <option value="">Select Type</option>
                    <option value="1">Standard</option>
                    <option value="2">Deluxe</option>
                    <option value="3">Suite</option>
                </select>
            </div>


            <!-- FLOOR -->
            <div class="input-group">
                <label>Floor</label>
                <input type="number" id="floor" placeholder="Enter Floor Number" required>
            </div>


            <!-- STATUS -->
            <div class="input-group">
                <label>Status</label>
                <select id="status" required>
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="dirty">Dirty</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="blocked">Blocked</option>
                </select>
            </div>


            <!-- BUTTONS -->
            <div class="btn-group">
                <button type="submit" class="save-btn">
                    Save Room
                </button>

                <button type="reset" class="cancel-btn">
                    Cancel
                </button>
            </div>

        </form>

    </div>


    <!-- TABLE -->
    <div class="table-container">

        <h2>All Rooms</h2>

        <table>

            <thead>
                <tr>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th>Floor</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <!-- AJAX loads here -->
            <tbody id="roomTable"></tbody>

        </table>

    </div>

</div>


<!-- AJAX SCRIPT -->
<script src="../Asset/Room.ajax.js"></script>

</body>
</html>