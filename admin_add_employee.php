<?php
include 'setup.php';

// Handle form submission
if (isset($_POST['add_employee'])) {
    $name = mysqli_real_escape_string($con, $_POST['Name']);
    $email = mysqli_real_escape_string($con, $_POST['Email']);
    $phone = mysqli_real_escape_string($con, $_POST['Phone']);
    $roleID = mysqli_real_escape_string($con, $_POST['RoleID']);
    $hireDate = mysqli_real_escape_string($con, $_POST['HireDate']);
    $status = mysqli_real_escape_string($con, $_POST['EmployeeStatus']);
    $icNumber = mysqli_real_escape_string($con, $_POST['ICNumber']);
    $salary = mysqli_real_escape_string($con, $_POST['Salary']);

    // Insert the employee record into the database
    $insertQuery = "INSERT INTO employees (Name, Email, Phone, RoleID, HireDate, EmployeeStatus, ICNumber, Salary)
                    VALUES ('$name', '$email', '$phone', '$roleID', '$hireDate', '$status', '$icNumber', '$salary')";

    if (mysqli_query($con, $insertQuery)) {
        echo "Employee added successfully!";
    } else {
        echo "Error adding employee: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>

<h2>Add New Employee</h2>

<form method="POST">
    <label for="Name">Name:</label>
    <input type="text" name="Name" required><br>

    <label for="Email">Email:</label>
    <input type="email" name="Email" required><br>

    <label for="Phone">Phone:</label>
    <input type="text" name="Phone" required><br>

    <label for="RoleID">Role:</label>
    <select name="RoleID" required>
        <?php
        // Fetch available roles from the database
        $roleQuery = "SELECT * FROM roles";
        $roleResult = mysqli_query($con, $roleQuery);

        while ($role = mysqli_fetch_assoc($roleResult)) {
            echo "<option value='" . $role['RoleID'] . "'>" . $role['RoleName'] . "</option>";
        }
        ?>
    </select><br>

    <label for="HireDate">Hire Date:</label>
    <input type="date" name="HireDate" required><br>

    <label for="EmployeeStatus">Status:</label>
    <select name="EmployeeStatus" required>
        <option value="Active">Active</option>
        <option value="On Leave">On Leave</option>
        <option value="Retired">Retired</option>
        <option value="Resigned">Resigned</option>
    </select><br>

    <label for="ICNumber">IC Number:</label>
    <input type="text" name="ICNumber" required><br>

    <label for="Salary">Salary:</label>
    <input type="number" name="Salary" step="0.01" required><br>

    <button type="submit" name="add_employee">Add Employee</button>
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
    margin-bottom: 20px;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    align-items: center; /* Center align items */
    margin: auto; /* Center the form */
    width: 80%; /* Set a max width */
    max-width: 500px; /* Max width for larger screens */
    border: 1px solid #c2a68d; /* Light coffee border */
    border-radius: 10px;
    padding: 20px; /* Padding for the form */
    background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

form label {
    margin-bottom: 5px; /* Space between label and input */
    font-weight: bold; /* Bold labels */
}

form input[type="text"],
form input[type="email"],
form input[type="date"],
form input[type="number"],
form select {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 100%; /* Full width for inputs */
    margin-bottom: 15px; /* Space between inputs */
}

form button {
    padding: 10px 15px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; /* Match button width to inputs */
}

form button:hover {
    background-color: #5a3a31; /* Darker coffee color on hover */
}

/* Back Button Style */
a button {
    margin-top: 20px;
    padding: 10px 15px;
    background-color: #c2a68d; /* Light coffee background */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

a button:hover {
    background-color: #b79b7e; /* Slightly darker coffee on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        width: 100%; /* Full width on smaller screens */
    }
}

</style>