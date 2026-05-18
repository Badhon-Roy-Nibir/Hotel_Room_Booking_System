<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Room Types</title>
    <link rel="stylesheet" href="../Asset/RoomTypes.css">
</head>
<body onload="loadRoomTypes()">
    <h1>Room Types</h1>
    <form method="post" enctype="multipart/form-data"id="roomTypeForm" onsubmit="saveRoomType(event)">
        <input type="hidden" id="roomTypeId">
        <label>Name: </label>
        <select name="name" id="roomName">
            <option value="Standard">Standard</option>
            <option value="Deluxe">Deluxe</option>
            <option value="Suite">Suite</option>
        </select>
        <br>
        <label>Room Description</label>
        <textarea id="description" rows="3" placeholder="Enter room description" name="description">
        </textarea><br>
        <label>Price: </label>
        <input type="number" placeholder="Enter price" min="0" step="0.01" required id="price" name="price"><br>

        <label>Capacity</label>
        <input type="number" placeholder="Enter guest capacity" min="1" required id="capacity" name="capacity"><br>

    <div class="amenities-list">
        <label>Amenities List</label>

        <label>
            <input type="checkbox" name="amenities[]" value="WiFi">WiFi
        </label>

        <label>
            <input type="checkbox" name="amenities[]" value="AC">Air Conditioning
        </label>

        <label>
            <input type="checkbox" name="amenities[]" value="TV">Television
        </label>
        <label>
            <input type="checkbox" name="amenities[]" value="Balcony">Balcony
        </label>

        <label>
            <input type="checkbox" name="amenities[]" value="Breakfast">Free Breakfast
        </label>

    </div><br>
    <label>Thumbnail Image</label>
    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required><br>

    <input type="submit" value="Save" name="Save">
    <input type="reset" value="Clear">

    </form>
    <table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price Per Night</th>
            <th>Capacity</th>
            <th>Amenities</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="roomTypeTable"></tbody>
    </table>

    <script src="../Asset/RoomTypeAjax.js"></script>
</body>
</html>