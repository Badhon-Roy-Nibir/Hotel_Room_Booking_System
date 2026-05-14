<!DOCTYPE html>
<html lang="en">
<head>
    <title>Financial Reports</title>
</head>

<body onload="loadFinancialReport()">

    <h1>Financial Reports Dashboard</h1>

    <!-- ================= FILTER SECTION ================= -->
    <div>

        <!-- DATE RANGE -->
        <label>From Date:</label>
        <input type="date" id="fromDate" onchange="loadFinancialReport()">

        <label>To Date:</label>
        <input type="date" id="toDate" onchange="loadFinancialReport()">

        <!-- PERIOD FILTER -->
        <label>View By:</label>
        <select id="periodFilter" onchange="loadFinancialReport()">
            <option value="day">Daily</option>
            <option value="week">Weekly</option>
            <option value="month">Monthly</option>
        </select>

        <button onclick="loadFinancialReport()">Apply</button>
        <button onclick="resetFilters()">Reset</button>

    </div>

    <hr>

    <!-- ================= SUMMARY CARDS ================= -->
    <div>

        <h2>Total Revenue</h2>
        <h3 id="totalRevenue">0</h3>

    </div>

    <hr>

    <!-- ================= REVENUE BY PERIOD ================= -->
    <h2>Revenue Breakdown (By Selected Period)</h2>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Period</th>
                <th>Total Revenue</th>
            </tr>
        </thead>

        <tbody id="periodTable">
            <!-- AJAX DATA -->
        </tbody>
    </table>

    <br>

    <!-- ================= ROOM TYPE BREAKDOWN ================= -->
    <h2>Revenue by Room Type</h2>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Room Type</th>
                <th>Revenue</th>
            </tr>
        </thead>

        <tbody id="roomTypeTable">
            <!-- AJAX DATA -->
        </tbody>
    </table>

    <br>

    <!-- ================= EXTRAS & SERVICES ================= -->
    <h2>Revenue from Extras & Services</h2>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Total Revenue</th>
            </tr>
        </thead>

        <tbody id="serviceTable">
            <!-- AJAX DATA -->
        </tbody>
    </table>

    <script src="../Asset/ReportAjax.js"></script>

</body>
</html>