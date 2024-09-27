<?php
include 'setup.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $employee_id = $_POST['employee_id'];
    $service_id = $_POST['service_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = $_POST['status'];

    // Insert the new appointment into the database
    $query = "INSERT INTO appointments (CustomerID, EmployeeID, ServiceID, AppointmentDate, AppointmentTime, Status) 
              VALUES ('$customer_id', '$employee_id', '$service_id', '$appointment_date', '$appointment_time', '$status')";

    if (mysqli_query($con, $query)) {
        echo "Appointment added successfully.";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!-- HTML Form for adding a new appointment -->
<form method="POST">
    <label for="customer_id">Customer ID:</label>
    <input type="text" name="customer_id" required><br>
    
    <label for="employee_id">Employee ID:</label>
    <input type="text" name="employee_id" required><br>
    
    <label for="service_id">Service ID:</label>
    <input type="text" name="service_id" required><br>
    
    <label for="appointment_date">Appointment Date:</label>
    <input type="date" name="appointment_date" required><br>
    
    <label for="appointment_time">Appointment Time:</label>
    <input type="time" name="appointment_time" required><br>
    
    <label for="status">Status:</label>
    <select name="status" required>
        <option value="Scheduled">Scheduled</option>
        <option value="Completed">Completed</option>
        <option value="Canceled">Canceled</option>
    </select><br>
    
    <button type="submit">Add Appointment</button>
</form>


<style>

/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif; /* Ensure this font is imported */
}

body {
    background: linear-gradient(to bottom, #fff9f2, #d4b99f); /* Light cream to coffee beige gradient */
    color: #4a3c31; /* Dark coffee color */
    line-height: 1.6;
    padding: 20px;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    align-items: center; /* Center align items */
    margin-bottom: 20px;
    border: 1px solid #c2a68d; /* Light coffee border */
    border-radius: 10px;
    padding: 10px; /* Reduced padding for a tighter look */
    background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background */
}

form label {
    margin-bottom: 3px; /* Reduced space between label and input */
}

form input[type="text"],
form input[type="date"],
form input[type="time"],
form select {
    padding: 8px; /* Reduced padding for inputs */
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 80%; /* Adjust width as needed */
    margin-bottom: 8px; /* Reduced space between inputs */
}

form button {
    padding: 8px 12px; /* Reduced padding for the button */
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 80%; /* Match button width to inputs */
}

form button:hover {
    background-color: #5a3a31; /* Darker coffee color on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    form input[type="text"],
    form input[type="date"],
    form input[type="time"],
    form select {
        width: 100%; /* Full width on smaller screens */
    }
}


</style>