// ===============================
// LOAD FINANCIAL REPORT
// ===============================
function loadFinancialReport() {

    let fromDate = document.getElementById("fromDate").value;
    let toDate = document.getElementById("toDate").value;
    let period = document.getElementById("periodFilter").value;

    let xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../Controller/ReportController.php?from_date=" + fromDate +
        "&to_date=" + toDate +
        "&period=" + period,
        true
    );

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            console.log(xhr.responseText);

            let res = JSON.parse(xhr.responseText);

            if (res.status === "success") {

                // ===============================
                // TOTAL REVENUE
                // ===============================
                document.getElementById("totalRevenue").innerText =
                    res.total_revenue;


                // ===============================
                // PERIOD TABLE (Daily/Weekly/Monthly)
                // ===============================
                let periodTable = document.getElementById("periodTable");
                periodTable.innerHTML = "";

                if (res.period_data.length === 0) {
                    periodTable.innerHTML =
                        "<tr><td colspan='2'>No data found</td></tr>";
                } else {

                    for (let i = 0; i < res.period_data.length; i++) {

                        periodTable.innerHTML += `
                            <tr>
                                <td>${res.period_data[i].period}</td>
                                <td>${res.period_data[i].revenue}</td>
                            </tr>
                        `;
                    }
                }


                // ===============================
                // ROOM TYPE TABLE
                // ===============================
                let roomTable = document.getElementById("roomTypeTable");
                roomTable.innerHTML = "";

                if (res.room_data.length === 0) {
                    roomTable.innerHTML =
                        "<tr><td colspan='2'>No data found</td></tr>";
                } else {

                    for (let i = 0; i < res.room_data.length; i++) {

                        roomTable.innerHTML += `
                            <tr>
                                <td>${res.room_data[i].room_type}</td>
                                <td>${res.room_data[i].revenue}</td>
                            </tr>
                        `;
                    }
                }


                // ===============================
                // SERVICES TABLE
                // ===============================
                let serviceTable = document.getElementById("serviceTable");
                serviceTable.innerHTML = "";

                if (res.service_data.length === 0) {
                    serviceTable.innerHTML =
                        "<tr><td colspan='2'>No data found</td></tr>";
                } else {

                    for (let i = 0; i < res.service_data.length; i++) {

                        serviceTable.innerHTML += `
                            <tr>
                                <td>${res.service_data[i].service_name}</td>
                                <td>${res.service_data[i].revenue}</td>
                            </tr>
                        `;
                    }
                }

            } else {
                alert(res.message);
            }
        }
    };

    xhr.send();
}


// ===============================
// RESET FILTERS
// ===============================
function resetFilters() {

    document.getElementById("fromDate").value = "";
    document.getElementById("toDate").value = "";
    document.getElementById("periodFilter").value = "day";

    loadFinancialReport();
}