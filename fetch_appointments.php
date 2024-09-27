<?php
include 'setup.php';

// Fetch appointments from the database
$query = "SELECT AppointmentID, AppointmentDate, AppointmentTime, (SELECT Name FROM customers WHERE customers.CustomerID = appointments.CustomerID) as CustomerName, (SELECT Name FROM employees WHERE employees.EmployeeID = appointments.EmployeeID) as EmployeeName FROM appointments";
$result = mysqli_query($con, $query);

$appointments = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Format the appointment data for FullCalendar
    $appointments[] = [
        'id' => $row['AppointmentID'],
        'title' => $row['CustomerName'] . " with " . $row['EmployeeName'],
        'start' => $row['AppointmentDate'] . 'T' . $row['AppointmentTime']
    ];
}

// Return the appointments as JSON
header('Content-Type: application/json');
echo json_encode($appointments);
?>
