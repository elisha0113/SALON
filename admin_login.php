<?php
session_start();
include 'setup.php';  // Assuming this file sets up the database connection.

if (isset($_POST['admin_id']) && isset($_POST['admin_pwd'])) {
    // Get admin credentials from the form.
    $admin_id = mysqli_real_escape_string($con, $_POST['admin_id']);
    $admin_pwd = mysqli_real_escape_string($con, $_POST['admin_pwd']);

    // Query to check if the admin exists in the database.
    $query = mysqli_query($con, "SELECT * FROM admins WHERE AdminID='$admin_id'");
    $row = mysqli_fetch_assoc($query);

    if (mysqli_num_rows($query) == 0) {
        // If AdminID is not found.
        echo "<script>alert('Admin ID not found');</script>";
    } else {
        // Check if the password matches.
        if ($row['Password'] === $admin_pwd) {
            // Set session variable for the admin.
            $_SESSION["AdminID"] = $row['AdminID'];
            $_SESSION["AdminName"] = $row['Name'];

            // Redirect to the admin dashboard or homepage.
            header("Location: admin.php");
            exit();
        } else {
            // If the password is incorrect.
            echo "<script>alert('Incorrect password');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>

<body>
    <div class="login-container">
        <form method="POST">
            <h2>Admin Login</h2>
            
            <input type="text" name="admin_id" placeholder="Admin ID" required>
            <input type="password" name="admin_pwd" placeholder="Password" required>
            
            <button type="submit" class="button">Log In</button>
        </form>
    </div>
</body>

</html>


<style>

/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif; /* Ensure this font is imported */
}

body {
    background: linear-gradient(to bottom, #f9f4ec, #d4b99f); /* Soft gradient background */
    color: #4a3c31; /* Dark coffee color */
    line-height: 1.6;
    padding: 20px;
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    height: 100vh; /* Full height for vertical centering */
}

/* Login Container */
.login-container {
    max-width: 400px; /* Max width for the login form */
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.95); /* Light transparent background */
    border-radius: 12px; /* More rounded corners */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* Deeper shadow for depth */
    transition: transform 0.3s; /* Animation for hover effect */
}

.login-container:hover {
    transform: scale(1.02); /* Slightly scale up on hover */
}

/* Heading Style */
.login-container h2 {
    text-align: center;
    color: #6f4c3e; /* Coffee brown */
    margin-bottom: 20px;
    font-size: 1.8rem; /* Larger font size for the heading */
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column; /* Column layout for form items */
}

form input[type="text"],
form input[type="password"] {
    padding: 12px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 8px; /* More rounded input fields */
    font-size: 1rem;
    margin-bottom: 15px; /* Space below inputs */
    transition: border 0.3s; /* Transition for input border on focus */
}

form input[type="text"]:focus,
form input[type="password"]:focus {
    border-color: #6f4c3e; /* Dark coffee color on focus */
    outline: none; /* Remove default outline */
}

form button {
    padding: 12px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 8px; /* Rounded button */
    cursor: pointer;
    font-size: 1rem; /* Consistent font size */
    transition: background-color 0.3s ease, transform 0.3s; /* Smooth transition */
}

form button:hover {
    background-color: #5a3a31; /* Darker coffee color on hover */
    transform: scale(1.05); /* Slightly scale up on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    body {
        padding: 10px; /* Adjust padding on smaller screens */
    }
    .login-container {
        padding: 20px; /* Adjust padding for the container */
    }
    form input[type="text"],
    form input[type="password"] {
        width: 100%; /* Full width for inputs */
    }
}

</style>