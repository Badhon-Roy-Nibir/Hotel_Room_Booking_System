<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Housekeeping Supervisor Management</title>

    <link rel="stylesheet" href="../Asset/Receptionist.css">
</head>

<body onload="loadSupervisors()">

    <div class="container">

        <h1>Housekeeping Supervisor Management</h1>

        <!-- =========================
             FORM SECTION
        ========================== -->

        <div class="form-container">

            <h2>Add / Edit Supervisor</h2>

            <form 
                id="supervisorForm"
                onsubmit="saveSupervisor(event)"
            >

                <input type="hidden" id="supervisorId">

                <!-- NAME -->
                <label>Full Name</label>

                <input 
                    type="text"
                    id="name"
                    placeholder="Enter supervisor name"
                    required
                >


                <!-- EMAIL -->
                <label>Email</label>

                <input 
                    type="email"
                    id="email"
                    placeholder="Enter email"
                    required
                >


                <!-- PASSWORD -->
                <label>Password</label>

                <input 
                    type="password"
                    id="password"
                    placeholder="Enter password"
                >


                <!-- PHONE -->
                <label>Phone</label>

                <input 
                    type="text"
                    id="phone"
                    placeholder="Enter phone number"
                >


                <!-- NATIONALITY -->
                <label>Nationality</label>

                <input 
                    type="text"
                    id="nationality"
                    placeholder="Enter nationality"
                >


                <!-- ID NUMBER -->
                <label>ID Number</label>

                <input 
                    type="text"
                    id="idNumber"
                    placeholder="Enter ID / NID / Passport Number"
                >


                <!-- PROFILE IMAGE -->
                <label>Profile Picture</label>

                <input 
                    type="file"
                    id="profilePic"
                    accept="image/*"required
                >


                <!-- STATUS -->
                <label>Account Status</label>

                <select id="status">

                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Deactivated
                    </option>

                </select>


                <!-- BUTTONS -->
                <div class="btn-group">

                    <button type="submit">
                        Save Supervisor
                    </button>

                    <button type="reset">
                        Clear
                    </button>

                </div>

            </form>

        </div>



        <!-- =========================
             TABLE SECTION
        ========================== -->

        <div class="table-container">

            <h2>All Receptionists</h2>

            <table border="1">

                <thead>

                    <tr>

                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Nationality</th>
                        <th>ID Number</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody id="supervisorTable">

                </tbody>

            </table>

        </div>

    </div>

    <script src="../Asset/SupervisorAjax.js"></script>

</body>
</html>