<?php
include('setup.php');
session_start();

// Get form data
$customer_id = $_SESSION['CustomerID'];
$date = $_POST['date'];  // Appointment date chosen by the customer
$time = $_POST['time'];  // Appointment time chosen by the customer
$service_id = $_POST['service'];
$employee_id = $_POST['employee'];

// Convert date and time into a single DateTime object
$appointmentDateTime = new DateTime($date . ' ' . $time);
$currentDateTime = new DateTime(); // Current date and time

// Prevent booking for past dates/times
if ($appointmentDateTime < $currentDateTime) {
    echo "Error: You cannot book an appointment in the past.";
    exit();
}

// Check if the employee is available starting from the selected date and at the selected time
$query = "SELECT * FROM schedules 
          WHERE EmployeeID = '$employee_id' 
          AND Date <= '$date'  -- Employee is available from this date onward
          AND StartTime <= '$time' 
          AND EndTime >= '$time'
          AND AvailabilityStatus = 'available'";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Error: The selected employee is not available at the chosen time.";
    exit();
}

// Default status value
$status = 'Pending';

// Validate status before inserting
$allowed_status = ['Pending', 'Completed', 'Canceled'];

if (!in_array($status, $allowed_status)) {
    echo "Invalid status value!";
} else {
    // Proceed with the insert if the status is valid
    $query = "INSERT INTO appointments (CustomerID, EmployeeID, ServiceID, AppointmentDate, AppointmentTime, Status) 
              VALUES ('$customer_id', '$employee_id', '$service_id', '$date', '$time', '$status')";

    if (mysqli_query($con, $query)) {
        // Redirect only after successful query execution
        echo "Appointment booked successfully!";
        header('Location: index2.php');
        exit(); // Stop execution after header redirect
    } else {
        // Output detailed MySQL error for debugging
        echo "Error booking appointment: " . mysqli_error($con);
    }
}
?>
