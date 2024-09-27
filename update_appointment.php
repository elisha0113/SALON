<?php
include('setup.php'); // Include database connection

// Start session to get customer data
session_start();
$customer_id = $_SESSION['CustomerID']; // Assuming customer ID is stored in the session

// Get appointment data from POST
$appointment_id = $_POST['appointment_id'];
$date = $_POST['date'];
$time = $_POST['time'];
$service_id = $_POST['service'];
$employee_id = $_POST['employee'];

// Check employee availability
$schedule_query = "SELECT * FROM schedules 
                   WHERE EmployeeID = '$employee_id' 
                   AND Date = '$date' 
                   AND (StartTime <= '$time' AND EndTime >= '$time')";
$schedule_result = mysqli_query($con, $schedule_query);

if (mysqli_num_rows($schedule_result) == 0) {
    die('The selected employee is not available at the chosen time.');
}

// Update appointment
$update_query = "UPDATE appointments 
                 SET AppointmentDate = '$date', 
                     AppointmentTime = '$time', 
                     ServiceID = '$service_id', 
                     EmployeeID = '$employee_id' 
                 WHERE AppointmentID = '$appointment_id' 
                 AND CustomerID = '$customer_id'";
if (mysqli_query($con, $update_query)) {
    echo 'Appointment updated successfully.';
} else {
    echo 'Error updating appointment: ' . mysqli_error($con);
}
?>
