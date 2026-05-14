// =========================
// LOAD RECEPTIONISTS
// =========================
function loadReceptionists(){

    var xhr = new XMLHttpRequest();

    xhr.open("GET", "../Controller/ReceptionistController.php?action=GetReceptionists",true);

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4){

            console.log(xhr.responseText);

            if(xhr.status == 200){

                var res = JSON.parse(xhr.responseText);

                var table = document.getElementById("receptionistTable");
                table.innerHTML = "";

                if(res.status === "success"){

                    var data = res.data;

                    for(var i = 0; i < data.length; i++){

                        var statusText = data[i].is_active == 1
                            ? "Active"
                            : "Deactivated";

                        var imageSrc = data[i].profile_pic
                            ? `data:${data[i].profile_pic_type};base64,${data[i].profile_pic}`
                            : "";

                        table.innerHTML += `
                            <tr>

                                <td>
                                    <img src="${imageSrc}" width="70" height="70">
                                </td>

                                <td>${data[i].name}</td>
                                <td>${data[i].email}</td>
                                <td>${data[i].phone}</td>
                                <td>${data[i].nationality}</td>
                                <td>${data[i].id_number}</td>
                                <td>${statusText}</td>

                                <td>
                                    <button onclick="editReceptionist(${data[i].id})">
                                        Edit
                                    </button>

                                    <button onclick="deactivateReceptionist(${data[i].id})">
                                        Deactivate
                                    </button>
                                </td>

                            </tr>
                        `;
                    }
                }
            }
        }
    };

    xhr.send();
}



// =========================
// SAVE RECEPTIONIST (ADD / UPDATE)
// =========================
function saveReceptionist(event){

    event.preventDefault();

    var id = document.getElementById("receptionistId").value;

    var formData = new FormData();

    var action = (id === "") ? "AddReceptionist" : "UpdateReceptionist";

    formData.append("action", action);
    formData.append("id", id);

    formData.append("name", document.getElementById("name").value);
    formData.append("email", document.getElementById("email").value);
    formData.append("password", document.getElementById("password").value);
    formData.append("phone", document.getElementById("phone").value);
    formData.append("nationality", document.getElementById("nationality").value);
    formData.append("id_number", document.getElementById("idNumber").value);
    formData.append("is_active", document.getElementById("status").value);

    var file = document.getElementById("profilePic").files[0];

    if(file){
        formData.append("profile_pic", file);
    }



    var xhr = new XMLHttpRequest();

    xhr.open("POST",
        "../Controller/ReceptionistController.php",
        true
    );

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4){

            console.log(xhr.responseText);

            if(xhr.status == 200){

                var res = JSON.parse(xhr.responseText);

                alert(res.message);

                if(res.status === "success"){

                    loadReceptionists();

                    document.getElementById("receptionistForm").reset();
                    document.getElementById("receptionistId").value = "";
                }
            }
        }
    };

    xhr.send(formData);
}



// =========================
// EDIT RECEPTIONIST
// =========================
function editReceptionist(id){

    var xhr = new XMLHttpRequest();

    xhr.open("GET",
        "../Controller/ReceptionistController.php?action=GetReceptionistById&id=" + id,
        true
    );

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            var res = JSON.parse(xhr.responseText);

            if(res.status === "success"){

                var data = res.data;

                document.getElementById("receptionistId").value = data.id;
                document.getElementById("name").value = data.name;
                document.getElementById("email").value = data.email;
                document.getElementById("phone").value = data.phone;
                document.getElementById("nationality").value = data.nationality;
                document.getElementById("idNumber").value = data.id_number;
                document.getElementById("status").value = data.is_active;

                // IMPORTANT: password not auto-filled for security
                document.getElementById("password").value = "";
            }
        }
    };

    xhr.send();
}



// =========================
// DEACTIVATE RECEPTIONIST
// =========================
function deactivateReceptionist(id){

    if(!confirm("Are you sure you want to deactivate this receptionist?")){
        return;
    }

    var xhr = new XMLHttpRequest();

    xhr.open("GET",
        "../Controller/ReceptionistController.php?action=DeactivateReceptionist&id=" + id,
        true
    );

    xhr.onreadystatechange = function(){

        if(xhr.readyState == 4 && xhr.status == 200){

            var res = JSON.parse(xhr.responseText);

            alert(res.message);

            if(res.status === "success"){
                loadReceptionists();
            }
        }
    };

    xhr.send();
}