<?php
session_start();
include 'setup.php';

if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

$role_id = $_GET['role_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $role_name = mysqli_real_escape_string($con, $_POST['role_name']);
    $role_categories = mysqli_real_escape_string($con, $_POST['role_categories']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Update role in the database
    $query = "UPDATE roles SET RoleName='$role_name', RoleCategories='$role_categories', Description='$description' 
              WHERE RoleID='$role_id'";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Role updated successfully'); window.location.href='admin.php?page=roles';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch role details for editing
$query = "SELECT * FROM roles WHERE RoleID='$role_id'";
$result = mysqli_query($con, $query);
$role = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Role</title>
</head>
<body>
    <h2>Edit Role</h2>
    <form method="POST">
        <label for="role_name">Role Name:</label>
        <input type="text" name="role_name" value="<?php echo $role['RoleName']; ?>" required>

        <label for="role_categories">Role Categories:</label>
        <input type="text" name="role_categories" value="<?php echo $role['RoleCategories']; ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo $role['Description']; ?></textarea>

        <button type="submit">Update Role</button>
    </form>
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

form input[type="text"],
form textarea {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 100%; /* Full width for inputs */
    margin-bottom: 15px; /* Space below inputs */
}

form textarea {
    resize: vertical; /* Allow vertical resizing for textarea */
    height: 100px; /* Default height for textarea */
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

/* Responsive Design */
@media (max-width: 768px) {
    form {
        padding: 15px; /* Adjust padding on smaller screens */
    }
    form input[type="text"],
    form textarea {
        width: 90%; /* Adjust input width on smaller screens */
    }
}

</style>