<?php
include('setup.php'); // Include database connection

// Start session to get customer data
session_start();
$customer_id = $_SESSION['CustomerID']; // Assuming customer ID is stored in the session

// Fetch appointment ID from URL
$appointment_id = isset($_GET['id']) ? $_GET['id'] : die('Appointment ID missing');

// Fetch appointment details
$query = "SELECT * FROM appointments WHERE AppointmentID = '$appointment_id' AND CustomerID = '$customer_id'";
$result = mysqli_query($con, $query);
$appointment = mysqli_fetch_assoc($result);

if (!$appointment) {
    die('Appointment not found');
}

// Fetch available services
$service_query = "SELECT * FROM services";
$service_result = mysqli_query($con, $service_query);

// Fetch employees for the selected service
$employee_query = "SELECT * FROM employees";
$employee_result = mysqli_query($con, $employee_query);
?>

<h2>Edit Appointment</h2>
<form method="POST" action="update_appointment.php">
    <input type="hidden" name="appointment_id" value="<?php echo $appointment['AppointmentID']; ?>">

    <label for="date">Select Date:</label>
    <input type="date" id="date" name="date" value="<?php echo $appointment['AppointmentDate']; ?>" required><br><br>

    <label for="time">Select Time:</label>
    <input type="time" id="time" name="time" value="<?php echo $appointment['AppointmentTime']; ?>" required><br><br>

    <label for="service">Select Service:</label>
    <select id="service" name="service" onchange="showEmployees(this.value)" required>
        <option value="">Select Service</option>
        <?php
        while ($service = mysqli_fetch_assoc($service_result)) {
            $selected = ($service['ServiceID'] == $appointment['ServiceID']) ? 'selected' : '';
            echo "<option value='{$service['ServiceID']}' $selected>{$service['ServiceName']}</option>";
        }
        ?>
    </select><br><br>

    <label for="employee">Select Employee:</label>
    <select id="employee" name="employee" required>
        <option value="">Select Employee</option>
        <?php
        while ($employee = mysqli_fetch_assoc($employee_result)) {
            $selected = ($employee['EmployeeID'] == $appointment['EmployeeID']) ? 'selected' : '';
            echo "<option value='{$employee['EmployeeID']}' $selected>{$employee['Name']}</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" value="Update Appointment">
</form>

<!-- Script to fetch employees based on the selected service -->
<script>
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
</script>
