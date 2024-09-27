<?php
include('setup.php'); // Include database connection

// Start session
session_start();

// Check if the customer ID is set in the session
if (!isset($_SESSION['CustomerID'])) {
    header("Location: login.php");
    exit();
}

// Fetch the customer name from the session to greet the user
$customer_id = $_SESSION['CustomerID'];
$customer_query = "SELECT Name FROM customers WHERE CustomerID = '$customer_id'";
$customer_result = mysqli_query($con, $customer_query);
$customer_data = mysqli_fetch_assoc($customer_result);
$customer_name = $customer_data['Name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Appointments</title>
    <link rel="stylesheet" type="text/css" href="index2.css">
</head>
<body>
    <!-- Header2 inclusion -->
    <?php include('header2.php'); ?>

    <!-- Greeting -->
    <h2>Welcome, <?php echo htmlspecialchars($customer_name); ?>!</h2>

    <!-- Tabs Navigation -->
    <ul class="tabs">
        <li><a href="#makeAppointment">Make Appointment</a></li>
        <li><a href="#appointmentHistory">Appointment History</a></li>
        <li><a href="#futureAppointments">Future Appointments</a></li>
        <li><a href="#feedbackForm">Feedback Form</a></li>
    </ul>

    <!-- Tab Content -->
    <div id="makeAppointment" class="tabContent">
        <h2>Make an Appointment</h2>
        <form method="POST" action="make_appointment.php">
            <label for="service">Select Service:</label>
            <select id="service" name="service" onchange="showEmployees(this.value)" required>
                <option value="">Select Service</option>
                <?php
                // Fetch available services
                $service_query = "SELECT * FROM services";
                $service_result = mysqli_query($con, $service_query);
                while($service = mysqli_fetch_assoc($service_result)) {
                    echo "<option value='{$service['ServiceID']}'>{$service['ServiceName']}</option>";
                }
                ?>
            </select><br><br>

            <label for="employee">Select Employee:</label>
            <select id="employee" name="employee" onchange="checkAvailableTimes()" required>
                <option value="">Select Employee</option>
            </select><br><br>

            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" onchange="checkAvailableTimes()" required><br><br>

            <label for="time">Select Time:</label>
            <select id="time" name="time" required>
                <option value="">Select Time</option>
            </select><br><br>

            <input type="submit" value="Book Appointment">
        </form>
        <!-- Exit Button -->
        <br>
        <button onclick="window.location.href='index.php'">Exit</button>
    </div>

    <!-- Appointment History Tab -->
    <div id="appointmentHistory" class="tabContent">
        <h2>Appointment History</h2>
        <table border="1">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Service</th>
                <th>Employee</th>
            </tr>
            <?php
            $current_time = date('Y-m-d H:i:s');
            $history_query = "SELECT appointments.AppointmentDate, appointments.AppointmentTime, services.ServiceName, employees.Name as EmployeeName 
                            FROM appointments 
                            JOIN services ON appointments.ServiceID = services.ServiceID 
                            JOIN employees ON appointments.EmployeeID = employees.EmployeeID 
                            WHERE appointments.CustomerID = '$customer_id' AND CONCAT(appointments.AppointmentDate, ' ', appointments.AppointmentTime) <= '$current_time'";
            $history_result = mysqli_query($con, $history_query);
            while ($row = mysqli_fetch_assoc($history_result)) {
                echo "<tr>
                        <td>{$row['AppointmentDate']}</td>
                        <td>{$row['AppointmentTime']}</td>
                        <td>{$row['ServiceName']}</td>
                        <td>{$row['EmployeeName']}</td>
                    </tr>";
            }
            ?>
        </table>
        <!-- Exit Button -->
        <br>
        <button onclick="window.location.href='index.php'">Exit</button>
    </div>

    <!-- Future Appointments Tab -->
    <div id="futureAppointments" class="tabContent">
        <h2>Future Appointments</h2>
        <table border="1">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Service</th>
                <th>Employee</th>
            </tr>
            <?php
            $future_query = "SELECT appointments.AppointmentDate, appointments.AppointmentTime, services.ServiceName, employees.Name as EmployeeName 
                            FROM appointments 
                            JOIN services ON appointments.ServiceID = services.ServiceID 
                            JOIN employees ON appointments.EmployeeID = employees.EmployeeID 
                            WHERE appointments.CustomerID = '$customer_id' AND CONCAT(appointments.AppointmentDate, ' ', appointments.AppointmentTime) > '$current_time'";
            $future_result = mysqli_query($con, $future_query);
            while ($row = mysqli_fetch_assoc($future_result)) {
                echo "<tr>
                        <td>{$row['AppointmentDate']}</td>
                        <td>{$row['AppointmentTime']}</td>
                        <td>{$row['ServiceName']}</td>
                        <td>{$row['EmployeeName']}</td>
                    </tr>";
            }
            ?>
        </table>
        <!-- Exit Button -->
        <br>
        <button onclick="window.location.href='index.php'">Exit</button>
    </div>

    <!-- Feedback Form Tab -->
<div id="feedbackForm" class="tabContent">
    <h2>Feedback Form</h2>
    <form method="POST" action="submit_feedback.php">
        <label for="service">Select Service:</label>
        <select id="service" name="service" required>
            <option value="">Select Service</option>
            <?php
            // Fetch services for feedback
            $service_result = mysqli_query($con, "SELECT * FROM services");
            while($service = mysqli_fetch_assoc($service_result)) {
                echo "<option value='{$service['ServiceID']}'>{$service['ServiceName']}</option>";
            }
            ?>
        </select><br><br>

        <label for="employee">Select Employee:</label>
        <select id="employee" name="employee" required>
            <option value="">Select Employee</option>
            <?php
            // Fetch employees for feedback
            $employee_result = mysqli_query($con, "SELECT * FROM employees");
            while($employee = mysqli_fetch_assoc($employee_result)) {
                echo "<option value='{$employee['EmployeeID']}'>{$employee['Name']}</option>";
            }
            ?>
        </select><br><br>

        <label for="comments">Comments:</label><br>
        <textarea id="comments" name="comments" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Submit Feedback">
    </form>
    <!-- Exit Button -->
    <br>
    <button onclick="window.location.href='index.php'">Exit</button>
</div>


    <!-- Script to handle tabs and employee fetching -->
    <script>
    // Tab functionality
    const tabLinks = document.querySelectorAll('.tabs a');
    const tabContent = document.querySelectorAll('.tabContent');

    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            tabContent.forEach(tab => tab.style.display = 'none');
            document.querySelector(this.getAttribute('href')).style.display = 'block';
        });
    });
    document.querySelector('.tabContent').style.display = 'block'; // Show first tab on load

    // Fetch employees based on selected service
    function showEmployees(serviceID) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("employee").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "fetch_employees.php?serviceID=" + serviceID, true);
        xhttp.send();
    }

    // Fetch available times based on employee schedule
    function checkAvailableTimes() {
        var employeeID = document.getElementById('employee').value;
        var date = document.getElementById('date').value;
        if (employeeID && date) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("time").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "fetch_available_times.php?employeeID=" + employeeID + "&date=" + date, true);
            xhttp.send();
        }
    }
    </script>
</body>
</html>
