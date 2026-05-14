// ===============================
// LOAD ALL SUPERVISORS
// ===============================
function loadSupervisors(){

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/SupervisorController.php?action=GetSupervisors",
        true
    );

    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4 && xhr.status === 200){

            console.log(xhr.responseText);

            var res = JSON.parse(xhr.responseText);

            var table = document.getElementById("supervisorTable");

            table.innerHTML = "";


            if(res.status === "success"){

                var data = res.data;


                if(data.length === 0){

                    table.innerHTML = `
                        <tr>
                            <td colspan="8">
                                No supervisors found
                            </td>
                        </tr>
                    `;

                    return;
                }


                for(let i = 0; i < data.length; i++){

                    var statusText =
                        data[i].is_active == 1
                        ? "Active"
                        : "Deactivated";


                    var imageSrc = "";

                    if(data[i].profile_pic){

                        imageSrc =
                            "data:" +
                            data[i].profile_pic_type +
                            ";base64," +
                            data[i].profile_pic;
                    }


                    table.innerHTML += `
                        <tr>

                            <td>
                                <img 
                                    src="${imageSrc}" 
                                    width="70" 
                                    height="70"
                                >
                            </td>

                            <td>${data[i].name}</td>

                            <td>${data[i].email}</td>

                            <td>${data[i].phone}</td>

                            <td>${data[i].nationality}</td>

                            <td>${data[i].id_number}</td>

                            <td>${statusText}</td>

                            <td>

                                <button onclick="editSupervisor(${data[i].id})">
                                    Edit
                                </button>

                                <button onclick="deactivateSupervisor(${data[i].id})">
                                    Deactivate
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



// ===============================
// SAVE SUPERVISOR
// ===============================
function saveSupervisor(event){

    event.preventDefault();

    var id = document.getElementById("supervisorId").value;

    var formData = new FormData();


    var action =
        id === ""
        ? "AddSupervisor"
        : "UpdateSupervisor";


    formData.append("action", action);

    formData.append("id", id);

    formData.append(
        "name",
        document.getElementById("name").value
    );

    formData.append(
        "email",
        document.getElementById("email").value
    );

    formData.append(
        "password",
        document.getElementById("password").value
    );

    formData.append(
        "phone",
        document.getElementById("phone").value
    );

    formData.append(
        "nationality",
        document.getElementById("nationality").value
    );

    formData.append(
        "id_number",
        document.getElementById("idNumber").value
    );

    formData.append(
        "is_active",
        document.getElementById("status").value
    );


    var file =
        document.getElementById("profilePic").files[0];

    if(file){

        formData.append("profile_pic", file);
    }


    var xhr = new XMLHttpRequest();

    xhr.open(
        "POST",
        "../Controller/SupervisorController.php",
        true
    );


    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4 && xhr.status === 200){

            console.log(xhr.responseText);

            var res = JSON.parse(xhr.responseText);

            alert(res.message);


            if(res.status === "success"){

                document
                    .getElementById("supervisorForm")
                    .reset();

                document
                    .getElementById("supervisorId")
                    .value = "";


                loadSupervisors();
            }
        }
    };

    xhr.send(formData);
}



// ===============================
// EDIT SUPERVISOR
// ===============================
function editSupervisor(id){

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/SupervisorController.php?action=GetSupervisorById&id=" + id,
        true
    );


    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4 && xhr.status === 200){

            console.log(xhr.responseText);

            var res = JSON.parse(xhr.responseText);


            if(res.status === "success"){

                let data = res.data;


                document.getElementById("supervisorId").value =
                    data.id;

                document.getElementById("name").value =
                    data.name;

                document.getElementById("email").value =
                    data.email;

                document.getElementById("phone").value =
                    data.phone;

                document.getElementById("nationality").value =
                    data.nationality;

                document.getElementById("idNumber").value =
                    data.id_number;

                document.getElementById("status").value =
                    data.is_active;

                document.getElementById("password").value =
                    "";
            }
        }
    };

    xhr.send();
}



// ===============================
// DEACTIVATE SUPERVISOR
// ===============================
function deactivateSupervisor(id){

    var confirmDelete = confirm(
        "Are you sure you want to deactivate this supervisor?"
    );


    if(!confirmDelete){

        return;
    }


    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/SupervisorController.php?action=DeactivateSupervisor&id=" + id,
        true
    );


    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4 && xhr.status === 200){

            console.log(xhr.responseText);

            let res = JSON.parse(xhr.responseText);

            alert(res.message);


            if(res.status === "success"){

                loadSupervisors();
            }
        }
    };

    xhr.send();
}