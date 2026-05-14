// ===============================
// LOAD ALL BOOKINGS
// ===============================
function loadBookings(){

    let status = document.getElementById("statusFilter").value;

    let roomType = document.getElementById("roomTypeFilter").value;

    let source = document.getElementById("sourceFilter").value;

    let fromDate = document.getElementById("fromDate").value;

    let toDate = document.getElementById("toDate").value;


    let xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/BookingController.php?" +
        "status=" + encodeURIComponent(status) +
        "&room_type_id=" + encodeURIComponent(roomType) +
        "&source=" + encodeURIComponent(source) +
        "&from_date=" + encodeURIComponent(fromDate) +
        "&to_date=" + encodeURIComponent(toDate),
        true
    );


    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4){

            console.log(xhr.responseText);

            if(xhr.status === 200){

                let response = JSON.parse(xhr.responseText);

                let table = document.getElementById("bookingTable");

                table.innerHTML = "";


                if(response.status === "success"){

                    let data = response.data;


                    if(data.length === 0){

                        table.innerHTML = `
                            <tr>
                                <td colspan="8">
                                    No bookings found
                                </td>
                            </tr>
                        `;

                        return;
                    }


                    for(let i = 0; i < data.length; i++){

                        table.innerHTML += `
                            <tr>

                                <td>${data[i].id}</td>

                                <td>${data[i].guest_name}</td>

                                <td>${data[i].room_type_id}</td>

                                <td>${data[i].checkin_date}</td>

                                <td>${data[i].checkout_date}</td>

                                <td>${data[i].status}</td>

                                <td>${data[i].source}</td>

                                <td>${data[i].total_price}</td>

                            </tr>
                        `;
                    }

                }else{

                    table.innerHTML = `
                        <tr>
                            <td colspan="8">
                                Failed to load bookings
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
// RESET FILTERS
// ===============================
function resetFilters(){

    document.getElementById("statusFilter").value = "";

    document.getElementById("roomTypeFilter").value = "";

    document.getElementById("sourceFilter").value = "";

    document.getElementById("fromDate").value = "";

    document.getElementById("toDate").value = "";


    loadBookings();
}