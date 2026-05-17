// =========================
// LOAD ROOM TYPES
// =========================
function loadRoomTypes(){

    var xhr = new XMLHttpRequest();

    xhr.open("GET", "../Controller/RoomTypeController.php?action=GetRoomTypes", true);

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            console.log(xhr.responseText);

            var res = JSON.parse(xhr.responseText);

            var table = document.getElementById("roomTypeTable");
            table.innerHTML = "";

            if(res.status === "success"){

                var data = res.data;

                for(var i = 0; i < data.length; i++){

                    table.innerHTML += `

                        <tr>

                            <td>${data[i].name}</td>

                            <td>${data[i].description}</td>

                            <td>${data[i].price_per_night}</td>

                            <td>${data[i].max_capacity}</td>

                            <td>${data[i].amenities ? JSON.parse(data[i].amenities).join(", ") : ""}</td>

                            <td>
                                <img 
                                    src="data:${data[i].thumbnail_type};base64,${data[i].thumbnail}"
                                    width="80"
                                    height="60"
                                    onerror="this.src='../Assets/no-image.png'"
                                >
                            </td>

                            <td>

                                <button onclick="editRoomType(${data[i].id})">
                                    Edit
                                </button>

                                <button onclick="deleteRoomType(${data[i].id})">
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



// =========================
// ADD / UPDATE ROOM TYPE
// =========================
function saveRoomType(event){

    event.preventDefault();

    var id = document.getElementById("roomTypeId").value;

    var name = document.getElementById("roomName").value;
    var description = document.getElementById("description").value;
    var price = document.getElementById("price").value;
    var capacity = document.getElementById("capacity").value;

    var thumbnailInput = document.getElementById("thumbnail");
    var thumbnail = thumbnailInput.files[0];



    // VALIDATE IMAGE ON ADD
    if(id === "" && !thumbnail){
        alert("Please select a thumbnail image.");
        return;
    }



    // GET CHECKBOX VALUES
    var amenities = [];

    var checkedAmenities = document.querySelectorAll('input[name="amenities[]"]:checked');

    checkedAmenities.forEach(function(item){
        amenities.push(item.value);
    });



    // FORM DATA
    var formData = new FormData();

    var action = (id === "") ? "AddRoomType" : "UpdateRoomType";

    formData.append("action", action);
    formData.append("id", id);

    formData.append("name", name);
    formData.append("description", description);
    formData.append("price", price);
    formData.append("capacity", capacity);

    formData.append("amenities", JSON.stringify(amenities));

    // ONLY APPEND THUMBNAIL IF SELECTED
    if(thumbnail){
        formData.append("thumbnail", thumbnail);
    }



    // AJAX
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "../Controller/RoomTypeController.php", true);

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            console.log(xhr.responseText);

            var res = JSON.parse(xhr.responseText);

            alert(res.message);

            if(res.status === "success"){

                loadRoomTypes();

                document.getElementById("roomTypeForm").reset();

                document.getElementById("roomTypeId").value = "";
            }
        }
    };

    xhr.send(formData);
}



// =========================
// DELETE ROOM TYPE
// =========================
function deleteRoomType(id){

    if(!confirm("Are you sure you want to delete this room type?")){
        return;
    }

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/RoomTypeController.php?action=DeleteRoomType&id=" + id,
        true
    );

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            var res = JSON.parse(xhr.responseText);

            alert(res.message);

            if(res.status === "success"){
                loadRoomTypes();
            }
        }
    };

    xhr.send();
}



// =========================
// EDIT ROOM TYPE
// =========================
function editRoomType(id){

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/RoomTypeController.php?action=GetRoomTypeById&id=" + id,
        true
    );

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            var res = JSON.parse(xhr.responseText);

            if(res.status === "success"){

                var data = res.data;

                document.getElementById("roomTypeId").value = data.id;

                document.getElementById("roomName").value = data.name;

                document.getElementById("description").value = data.description;

                document.getElementById("price").value = data.price_per_night;

                document.getElementById("capacity").value = data.max_capacity;



                // UNCHECK ALL
                var checkboxes = document.querySelectorAll('input[name="amenities[]"]');

                checkboxes.forEach(function(box){
                    box.checked = false;
                });



                // SAFE JSON PARSE
                var amenities = [];

                try {
                    if(data.amenities){
                        amenities = JSON.parse(data.amenities);
                    }
                } catch(e) {
                    console.error("Failed to parse amenities:", e);
                }



                // CHECK AMENITIES
                amenities.forEach(function(item){

                    var checkbox = document.querySelector(
                        'input[value="' + item + '"]'
                    );

                    if(checkbox){
                        checkbox.checked = true;
                    }
                });



                // PREVIEW CURRENT IMAGE
                var preview = document.getElementById("thumbnailPreview");

                if(preview){
                    preview.src = "data:" + data.thumbnail_type + ";base64," + data.thumbnail;
                    preview.style.display = "block";
                }



                // SCROLL TO FORM
                document.getElementById("roomTypeForm").scrollIntoView({ behavior: "smooth" });
            }
        }
    };

    xhr.send();
}