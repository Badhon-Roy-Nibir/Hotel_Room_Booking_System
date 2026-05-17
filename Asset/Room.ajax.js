
// =============================
// ROOM TYPE MAP (IMPORTANT FIX)
// =============================
const roomTypes = {
    1: "Standard",
    2: "Deluxe",
    3: "Suite"
};


// =============================
// LOAD ALL ROOMS
// =============================
function loadRooms() {

    let xhr = new XMLHttpRequest();

    xhr.open("GET", "../Controller/RoomController.php?action=GetRooms", true);

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            console.log(xhr.responseText);

            let res = JSON.parse(xhr.responseText);

            let table = document.getElementById("roomTable");

            table.innerHTML = "";

            if (res.status === "success") {

                let data = res.data;

                for (let i = 0; i < data.length; i++) {

                    table.innerHTML += `
                        <tr>

                            <td>${data[i].room_number}</td>

                            <td>${roomTypes[data[i].room_type_id] || "Unknown"}</td>

                            <td>${data[i].floor}</td>

                            <td>${data[i].status}</td>

                            <td>
                                <button onclick="editRoom(${data[i].id})">Edit</button>
                                <button onclick="deleteRoom(${data[i].id})">Delete</button>
                            </td>

                        </tr>
                    `;
                }
            }
        }
    };

    xhr.send();
}


// =============================
// ADD / UPDATE ROOM
// =============================
function addRoom(event) {

    event.preventDefault();

    let id = document.getElementById("roomId").value;
    let roomNumber = document.getElementById("roomNumber").value;
    let roomTypeId = document.getElementById("roomType").value;
    let floor = document.getElementById("floor").value;
    let status = document.getElementById("status").value;

    let action = (id === "") ? "AddRoom" : "UpdateRoom";

    let xhr = new XMLHttpRequest();

    xhr.open("POST", "../Controller/RoomController.php", true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            console.log(xhr.responseText);

            let res = JSON.parse(xhr.responseText);

            alert(res.message);

            if (res.status === "success") {

                loadRooms();

                document.getElementById("roomForm").reset();
                document.getElementById("roomId").value = "";
            }
        }
    };

    let data =
        "action=" + encodeURIComponent(action) +
        "&id=" + encodeURIComponent(id) +
        "&roomNumber=" + encodeURIComponent(roomNumber) +
        "&roomTypeId=" + encodeURIComponent(roomTypeId) +
        "&floor=" + encodeURIComponent(floor) +
        "&status=" + encodeURIComponent(status);

    xhr.send(data);
}


// =============================
// DELETE ROOM
// =============================
function deleteRoom(id) {

    if (!confirm("Are you sure you want to delete this room?")) return;

    let xhr = new XMLHttpRequest();

    xhr.open("GET", "../Controller/RoomController.php?action=DeleteRoom&id=" + id, true);

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            let res = JSON.parse(xhr.responseText);

            alert(res.message);

            if (res.status === "success") {
                loadRooms();
            }
        }
    };

    xhr.send();
}


// =============================
// EDIT ROOM
// =============================
function editRoom(id) {

    let xhr = new XMLHttpRequest();

    xhr.open("GET", "../Controller/RoomController.php?action=GetRoomById&id=" + id, true);

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            let res = JSON.parse(xhr.responseText);

            if (res.status === "success") {

                let data = res.data;

                document.getElementById("roomId").value = data.id;
                document.getElementById("roomNumber").value = data.room_number;
                document.getElementById("roomType").value = data.room_type_id;
                document.getElementById("floor").value = data.floor;
                document.getElementById("status").value = data.status;
            }
        }
    };

    xhr.send();
}