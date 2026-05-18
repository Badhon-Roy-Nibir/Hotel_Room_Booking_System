// =========================
// LOGIN
// =========================
function Login(event) {

    event.preventDefault();

    var email    = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../Controller/AdminController.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            try {
                var res = JSON.parse(xhr.responseText);

                if (res.status === "success") {
                    window.location.href = "../View/Admin.DashboardView.php";
                } else {
                    alert(res.message);
                }

            } catch (e) {
                console.log(xhr.responseText);
                console.error("Login JSON Error", e);
            }
        }
    };
    xhr.send(
        "action=Login" +
        "&email="    + encodeURIComponent(email) +
        "&password=" + encodeURIComponent(password)
    );
}


// =========================
// LOAD TODAY'S REVENUE
// =========================
function loadTodaysRevenue() {

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/AdminController.php?action=GetTodaysRevenue",
        true
    );

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            try {
                var res = JSON.parse(xhr.responseText);

                if (res.status === "success") {
                    document.getElementById("todaysRevenue").innerHTML =
                        res.todays_revenue ?? "0";
                }

            } catch (error) {
                console.log(xhr.responseText);
                console.error("Revenue JSON Error:", error);
            }
        }
    };

    xhr.send();
}


// =========================
// LOAD OCCUPANCY RATE
// =========================
function loadOccupancyRate() {

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/AdminController.php?action=GetOccupancyRate",
        true
    );

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            try {
                var res = JSON.parse(xhr.responseText);

                if (res.status === "success") {
                    document.getElementById("occupancyRate").innerHTML =
                        res.occupancy_rate + "%";
                }

            } catch (error) {
                console.error("Occupancy JSON Error:", error);
            }
        }
    };

    xhr.send();
}
// =========================
// LOAD AVAILABLE ROOMS
// =========================
function loadAvailableRooms() {

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/AdminController.php?action=GetAvailableRooms",
        true
    );

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            try {
                var res = JSON.parse(xhr.responseText);

                var tableBody = document.getElementById("availableRoomsTable");
                tableBody.innerHTML = "";

                if (res.status === "success" && res.data.length > 0) {

                    res.data.forEach(function (room) {

                        tableBody.innerHTML += `
                            <tr>
                                <td>${room.room_number}</td>
                            </tr>
                        `;
                    });

                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td>No rooms available</td>
                        </tr>
                    `;
                }

            } catch (error) {
                console.error("Available Rooms JSON Error:", error);
            }
        }
    };

    xhr.send();
}
function loadOccupiedRooms(){

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/AdminController.php?action=GetOccupiedRooms",
        true
    );

    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4 && xhr.status === 200){

            try{

                var res = JSON.parse(xhr.responseText);

                var table = document.getElementById("occupiedRoomsTable");
                table.innerHTML = "";

                if(res.status === "success" && res.data.length > 0){

                    res.data.forEach(function(room){

                        table.innerHTML += `
                            <tr>
                                <td>Room ${room.room_number}</td>
                            </tr>
                        `;
                    });

                } else {
                    table.innerHTML = `
                        <tr>
                            <td>No occupied rooms</td>
                        </tr>
                    `;
                }

            } catch(e){
                console.log(xhr.responseText);
                console.error("JSON Error:", e);
            }
        }
    };

    xhr.send();
}
function loadActiveIssues(){

    var xhr = new XMLHttpRequest();

    xhr.open("GET", "../Controller/AdminController.php?action=GetActiveIssues", true);

    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4 && xhr.status === 200){

            console.log("RAW RESPONSE:", xhr.responseText);

            try {

                var res = JSON.parse(xhr.responseText);

                if(res.status === "success"){

                    var tableBody = document.getElementById("issuesTableBody");
                    tableBody.innerHTML = "";

                    if(Array.isArray(res.data) && res.data.length > 0){

                        res.data.forEach(function(issue){

                            tableBody.innerHTML += `
                                <tr>
                                    <td>${issue.room_id}</td>
                                    <td>${issue.description}</td>
                                    <td>${issue.status}</td>
                                    <td>${issue.reported_at}</td>
                                </tr>
                            `;
                        });

                    } else {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="4">No active issues found</td>
                            </tr>
                        `;
                    }

                } else {
                    console.error("Server returned error:", res.message);
                }

            } catch (e) {
                console.error("JSON PARSE ERROR:");
                console.error(xhr.responseText);
            }
        }
    };

    xhr.send();
}
function loadPendingReviews(){

    var xhr = new XMLHttpRequest();

    xhr.open("GET", "../Controller/AdminController.php?action=GetPendingReviews", true);

    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4 && xhr.status === 200){

            console.log("RAW RESPONSE:", xhr.responseText);

            try {

                var res = JSON.parse(xhr.responseText);

                if(res.status === "success"){

                    var tableBody = document.getElementById("pendingReviewsTable");
                    tableBody.innerHTML = "";

                    if(Array.isArray(res.data) && res.data.length > 0){

                        res.data.forEach(function(review){

                            tableBody.innerHTML += `
                                <tr>
                                    <td>${review.booking_id}</td>
                                    <td>${review.guest_id}</td>
                                    <td>${review.overall_rating}</td>
                                    <td>${review.cleanliness_rating}</td>
                                    <td>${review.service_rating}</td>
                                    <td>${review.review_text}</td>
                                    <td>${review.created_at}</td>
                                </tr>
                            `;
                        });

                    } else {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="7">No pending reviews found</td>
                            </tr>
                        `;
                    }

                } else {
                    console.error("Server Error:", res.message);
                }

            } catch (e) {
                console.error("JSON PARSE ERROR:", xhr.responseText);
            }
        }
    };

    xhr.send();
}