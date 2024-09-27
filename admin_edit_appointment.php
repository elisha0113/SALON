<?php
include 'setup.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];

    // Define allowed status values
    $allowed_statuses = ['Scheduled', 'Completed', 'Canceled'];

    if (!in_array($status, $allowed_statuses)) {
        die('Invalid status value.');
    }

    // Prepare and execute the query
    $query = "UPDATE appointments SET AppointmentDate = ?, AppointmentTime = ?, Status = ? WHERE AppointmentID = ?";
    $stmt = $con->prepare($query);
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }

    $stmt->bind_param("sssi", $date, $time, $status, $appointment_id);

    if ($stmt->execute()) {
        echo "Appointment updated successfully.";
    } else {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}
?>


<style>

    /* General Body Styles */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to bottom, #ffffff, #f5f5dc); /* Gradient from white to light beige */
    color: #3e2723; /* Dark Coffee text */
    margin: 0;
    padding: 20px;
}

/* Heading Styles */
h1 {
    text-align: center;
    color: #4e342e; /* Darker Coffee for the heading */
}

/* Form Container Styles */
form {
    background-color: rgba(255, 255, 255, 0.95); /* Slightly transparent white */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    max-width: 600px; /* Maximum width for the form */
    margin: auto; /* Center the form on the page */
}

/* Form Input Styles */
form input[type="text"],
form input[type="date"],
form input[type="time"],
form select,
form textarea {
    width: calc(100% - 20px); /* Full width with padding */
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #bdbdbd; /* Light Grey border */
    border-radius: 5px;
    background-color: #d7ccc8; /* Light Coffee */
    color: #3e2723; /* Dark Coffee text */
}

/* Form Button Styles */
form button {
    background-color: #8d6e63; /* Medium Coffee */
    color: #ffffff; /* White text */
    border: none;
    border-radius: 5px;
    padding: 12px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: bold;
    margin-top: 10px; /* Margin to separate from input */
}

/* Button Hover Effects */
form button:hover {
    background-color: #6f4c3e; /* Darker Coffee on hover */
}

/* Back Link Styles */
a {
    display: inline-block; /* Make the link a block element */
    margin-top: 20px; /* Space above */
    text-align: center;
    color: #3e2723; /* Dark Coffee text */
    text-decoration: none; /* Remove underline */
    font-weight: bold;
}

a:hover {
    color: #6f4c3e; /* Darker Coffee on hover */
}

</style>