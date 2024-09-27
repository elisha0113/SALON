<?php
include('setup.php');
session_start();

$customerID = $_SESSION['CustomerID'];
$appointmentDate = $_POST['appointmentDate'];
$appointmentTime = $_POST['appointmentTime'];
$serviceID = $_POST['serviceID'];
$employeeID = $_POST['employeeID'];

// Insert the appointment into the database
$insertQuery = "INSERT INTO appointments (CustomerID, EmployeeID, ServiceID, AppointmentDate, AppointmentTime, Status) 
                VALUES ('$customerID', '$employeeID', '$serviceID', '$appointmentDate', '$appointmentTime', 'Pending')";

if (mysqli_query($conn, $insertQuery)) {
    echo "Appointment booked successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

header("Location: index2.php");
exit;
?>
