<?php
session_start();
include 'setup.php';

if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $role_name = mysqli_real_escape_string($con, $_POST['role_name']);
    $role_categories = mysqli_real_escape_string($con, $_POST['role_categories']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Insert new role into the database
    $query = "INSERT INTO roles (RoleName, RoleCategoryID, Description) 
              VALUES ('$role_name', '$role_categories', '$description')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Role added successfully'); window.location.href='admin.php?page=roles';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Role</title>
</head>
<body>
    <h2>Add Role</h2>
    <form method="POST">
        <label for="role_name">Role Name:</label>
        <input type="text" name="role_name" required>

        <label for="role_categories">Role Categories:</label>
        <select name="role_categories" required>
            <?php
            // Fetch role categories from the database
            $query = "SELECT RoleCategoryID, CategoryName FROM rolecategories";
            $result = mysqli_query($con, $query);

            // Check if there are any categories
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['RoleCategoryID'] . "'>" . $row['CategoryName'] . "</option>";
                }
            } else {
                echo "<option value=''>No categories available</option>";
            }
            ?>
        </select>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <button type="submit">Add Role</button>
    </form>

<a href="admin.php?page=employees">
    <button type="button">Back to Admin Page</button>
</a>

</body>
</html>


<style>

    /* General Body Styles */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to bottom, #ffffff, #f5f5dc); /* Gradient from white to light beige */
    color: #3e2723; /* Dark Coffee text */
    margin: 0;
    padding: 20px;
}

/* Form Container Styles */
form {
    background-color: rgba(255, 255, 255, 0.95); /* Slightly transparent white */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Form Input Styles */
form input[type="text"],
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

/* Form Textarea Styles */
form textarea {
    height: 100px; /* Height for the textarea */
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
}

/* Button Hover Effects */
form button:hover {
    background-color: #6f4c3e; /* Darker Coffee on hover */
}

/* Form Label Styles */
form label {
    font-weight: bold;
}

/* Back Button Styles */
a button {
    margin-top: 20px;
    padding: 12px 15px;
    background-color: #8d6e63; /* Medium Coffee */
    color: #ffffff; /* White text */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: bold;
}

/* Back Button Hover Effects */
a button:hover {
    background-color: #6f4c3e; /* Darker Coffee on hover */
}


</style>