<?php
include 'setup.php';

// Check if employee ID is set in the URL
if (isset($_GET['id'])) {
    $employeeID = $_GET['id'];

    // Fetch employee details including role
    $query = "SELECT e.*, r.RoleName FROM employees e
              LEFT JOIN roles r ON e.RoleID = r.RoleID
              WHERE e.EmployeeID = '$employeeID'";
    $result = mysqli_query($con, $query);
    $employee = mysqli_fetch_assoc($result);

    if (!$employee) {
        echo "Employee not found!";
        exit();
    }
} else {
    echo "Employee ID not provided!";
    exit();
}

// Handle form submission
if (isset($_POST['update_employee'])) {
    $email = mysqli_real_escape_string($con, $_POST['Email']);
    $phone = mysqli_real_escape_string($con, $_POST['Phone']);
    $roleID = mysqli_real_escape_string($con, $_POST['RoleID']);
    $status = mysqli_real_escape_string($con, $_POST['EmployeeStatus']);

    // Update the employee record in the database
    $updateQuery = "UPDATE employees 
                    SET Email = '$email', Phone = '$phone', RoleID = '$roleID', EmployeeStatus = '$status' 
                    WHERE EmployeeID = '$employeeID'";

    if (mysqli_query($con, $updateQuery)) {
        echo "Employee updated successfully!";
    } else {
        echo "Error updating employee: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
</head>
<body>

<h2>Edit Employee</h2>

<form method="POST">
    <label for="Email">Email:</label>
    <input type="email" name="Email" value="<?php echo $employee['Email']; ?>" required><br>

    <label for="Phone">Phone:</label>
    <input type="text" name="Phone" value="<?php echo $employee['Phone']; ?>" required><br>

    <label for="RoleID">Role:</label>
    <select name="RoleID" required>
        <?php
        // Fetch available roles from the database
        $roleQuery = "SELECT * FROM roles";
        $roleResult = mysqli_query($con, $roleQuery);

        while ($role = mysqli_fetch_assoc($roleResult)) {
            $selected = ($employee['RoleID'] == $role['RoleID']) ? 'selected' : '';
            echo "<option value='" . $role['RoleID'] . "' $selected>" . $role['RoleName'] . "</option>";
        }
        ?>
    </select><br>

    <label for="EmployeeStatus">Status:</label>
    <select name="EmployeeStatus" required>
        <option value="Active" <?php if ($employee['EmployeeStatus'] == 'Active') echo 'selected'; ?>>Active</option>
        <option value="On Leave" <?php if ($employee['EmployeeStatus'] == 'On Leave') echo 'selected'; ?>>On Leave</option>
        <option value="Retired" <?php if ($employee['EmployeeStatus'] == 'Retired') echo 'selected'; ?>>Retired</option>
        <option value="Resigned" <?php if ($employee['EmployeeStatus'] == 'Resigned') echo 'selected'; ?>>Resigned</option>
    </select><br>

    <button type="submit" name="update_employee">Update Employee</button>
</form>

<!-- Button to go back to the admin dashboard -->
<br>
<a href="admin.php?page=employees">
    <button type="button">Back to Admin Page</button>
</a>

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
    background: linear-gradient(to bottom, #fff9f2, #d4b99f); /* Light cream to coffee beige gradient */
    color: #4a3c31; /* Dark coffee color */
    line-height: 1.6;
    padding: 20px;
}

/* Heading Style */
h2 {
    text-align: center;
    color: #6f4c3e; /* Coffee brown */
    margin-bottom: 30px;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column; /* Column layout for form items */
    align-items: center; /* Center align the form items */
    background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px; /* Max width for the form */
    margin: auto; /* Center the form on the page */
}

form label {
    margin-bottom: 5px; /* Space between label and input */
    font-weight: bold; /* Bold labels */
}

form input[type="email"],
form input[type="text"],
form select {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 100%; /* Full width for inputs */
    margin-bottom: 15px; /* Space below inputs */
}

form button {
    padding: 10px 15px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; /* Full width for button */
}

form button:hover {
    background-color: #5a3a31; /* Darker coffee color on hover */
}

/* Link Styles */
a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #c2a68d; /* Light coffee background for links */
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color: #b79b7e; /* Slightly darker coffee on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        padding: 15px; /* Adjust padding on smaller screens */
    }
    form input[type="email"],
    form input[type="text"],
    form select {
        width: 90%; /* Adjust input width on smaller screens */
    }
}

</style>