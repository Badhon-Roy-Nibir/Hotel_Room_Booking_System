const API_URL = "../Controller/GuestController.php";


// ===============================
// LOAD ALL GUESTS
// ===============================
function loadGuests() {

    let xhr = new XMLHttpRequest();

    xhr.open("GET", API_URL + "?action=GetGuests", true);

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            let res = JSON.parse(xhr.responseText);

            let table = document.getElementById("guestTable");
            table.innerHTML = "";

            if (res.status === "success") {

                let data = res.data;

                for (let i = 0; i < data.length; i++) {

                    let statusText = data[i].is_active == 1
                        ? "Active"
                        : "Deactivated";

                    let image = data[i].profile_pic
                        ? `<img src="data:${data[i].profile_pic_type};base64,${data[i].profile_pic}" width="50" height="50">`
                        : "No Image";

                    table.innerHTML += `
                        <tr>

                            <td>${data[i].id}</td>

                            <td>${image}</td>

                            <td>${data[i].name}</td>

                            <td>${data[i].email}</td>

                            <td>${data[i].phone}</td>

                            <td>${statusText}</td>

                            <td>
                                <button onclick="deactivateGuest(${data[i].id})">
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
// SEARCH GUESTS (CLIENT FILTER)
// ===============================
function searchGuests() {

    let input = document.getElementById("searchInput").value.toLowerCase();

    let rows = document.getElementById("guestTable").getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {

        let name = rows[i].cells[2].innerText.toLowerCase();
        let email = rows[i].cells[3].innerText.toLowerCase();

        if (name.includes(input) || email.includes(input)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}


// ===============================
// DEACTIVATE GUEST
// ===============================
function deactivateGuest(id) {

    if (!confirm("Are you sure you want to deactivate this guest?")) {
        return;
    }

    let xhr = new XMLHttpRequest();

    xhr.open("GET", API_URL + "?action=DeactivateGuest&id=" + id, true);

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            let res = JSON.parse(xhr.responseText);

            alert(res.message);

            if (res.status === "success") {
                loadGuests();
            }
        }
    };

    xhr.send();
}