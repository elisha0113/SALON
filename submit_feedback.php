<?php
// Include the database connection
include 'setup.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected service ID, employee ID, and comments from the form
    $serviceID = $_POST['service'];
    $employeeID = $_POST['employee'];
    $comments = mysqli_real_escape_string($con, $_POST['comments']);

    // Get the customer ID from the session (you should set this during the login process)
    session_start();
    $customerID = $_SESSION['CustomerID']; // Assuming you've stored the CustomerID in the session

    // Prepare the SQL query to insert feedback into the reviews table
    $sql = "INSERT INTO reviews (CustomerID, ServiceID, EmployeeID, Comments, ReviewDate) VALUES (?, ?, ?, ?, NOW())";
    
    // Prepare the statement
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "iiis", $customerID, $serviceID, $employeeID, $comments);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Feedback submitted successfully!";
        } else {
            echo "Error: Could not submit feedback. Please try again later.";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Could not prepare the SQL statement.";
    }
} else {
    echo "Invalid request method.";
}
// Redirect back to the feedback form or index page after submission
header("Location: index2.php#feedbackForm");
exit();
?>
