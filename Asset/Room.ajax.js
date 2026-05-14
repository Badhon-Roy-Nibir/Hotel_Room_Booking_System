// LOAD ALL ROOMS
function loadRooms(){

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../Controller/RoomController.php?action=GetRooms", true);

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            console.log(xhr.responseText);

            var res = JSON.parse(xhr.responseText);

            var table = document.getElementById("roomTable");
            table.innerHTML = "";

            if(res.status === "success"){

                var data = res.data;

                for(var i = 0; i < data.length; i++){

                    table.innerHTML += `
                        <tr>
                            <td>${data[i].room_number}</td>
                            <td>${data[i].room_type}</td>
                            <td>${data[i].floor}</td>
                            <td>${data[i].status}</td>

                            <td>

                                <button onclick="editRoom(${data[i].id})">
                                    Edit
                                </button>

                                <button onclick="deleteRoom(${data[i].id})">
                                    Delete
                                </button>

                            </td>
                        </tr>
                    `;
                }
            }
        }
    };

    xhr.send();
}


// ADD ROOM
function addRoom(event){

    event.preventDefault();

    var id = document.getElementById("roomId").value;
    var roomNumber = document.getElementById("roomNumber").value;
    var roomTypeId = document.getElementById("roomType").value;
    var floor = document.getElementById("floor").value;
    var status = document.getElementById("status").value;

    var action = (id === "") ? "AddRoom" : "UpdateRoom";

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../Controller/RoomController.php", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            console.log(xhr.responseText);

            var res = JSON.parse(xhr.responseText);

            alert(res.message);

            if(res.status === "success"){

                loadRooms();

                document.getElementById("roomForm").reset();
                document.getElementById("roomId").value = "";
            }
        }
    };

    xhr.send(
        "action=" + action +
        "&id=" + id +
        "&roomNumber=" + roomNumber +
        "&roomTypeId=" + roomTypeId +
        "&floor=" + floor +
        "&status=" + status
    );
}


// DELETE ROOM
function deleteRoom(id){

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../Controller/RoomController.php?action=DeleteRoom&id=" + id, true);

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            var res = JSON.parse(xhr.responseText);

            alert(res.message);

            if(res.status === "success"){
                loadRooms();
            }
        }
    };

    xhr.send();
}

// EDIT ROOM (LOAD DATA)
function editRoom(id){

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../Controller/RoomController.php?action=GetRoomById&id=" + id, true);

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            var res = JSON.parse(xhr.responseText);

            if(res.status === "success"){

                var data = res.data;

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