<?php
include 'setup.php';

// Check if admin is logged in.
if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

// Handle role deletion
if (isset($_GET['delete'])) {
    $role_id = mysqli_real_escape_string($con, $_GET['delete']);
    $delete_query = "DELETE FROM roles WHERE RoleID='$role_id'";
    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Role deleted successfully'); window.location.href='admin_roles.php';</script>";
    } else {
        echo "<script>alert('Error deleting role');</script>";
    }
}

// Fetch roles and their categories
$roles_query = "SELECT r.RoleID, r.RoleName, r.Description, rc.CategoryName 
                FROM roles r
                JOIN rolecategories rc ON r.RoleCategoryID = rc.RoleCategoryID";
$roles_result = mysqli_query($con, $roles_query);

// Handle search functionality
$search_query = "";
if (isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($con, $_POST['search_term']);
    $search_query = " AND (r.RoleName LIKE '%$search_term%' OR rc.CategoryName LIKE '%$search_term%')";
}

$roles_query .= " WHERE 1=1" . $search_query;
$roles_result = mysqli_query($con, $roles_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Roles</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h2>Manage Roles</h2>

    <!-- Search Form -->
    <form method="POST">
        <input type="text" name="search_term" placeholder="Search roles..." value="<?php echo isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : ''; ?>">
        <button type="submit" name="search">Search</button>
    </form>

    <a href="admin_add_role.php">Add New Role</a>

    <table border="1">
        <thead>
            <tr>
                <th>Role ID</th>
                <th>Role Name</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($role = mysqli_fetch_assoc($roles_result)) { ?>
                <tr>
                    <td><?php echo $role['RoleID']; ?></td>
                    <td><?php echo $role['RoleName']; ?></td>
                    <td><?php echo $role['CategoryName']; ?></td>
                    <td><?php echo $role['Description']; ?></td>
                    <td>
                        <a href="admin_edit_role.php?id=<?php echo $role['RoleID']; ?>">Edit</a>
                        <a href="admin_roles.php?delete=<?php echo $role['RoleID']; ?>" onclick="return confirm('Are you sure you want to delete this role?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
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

/* Common Form Styles */
form {
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    align-items: center; /* Center align items */
    margin-bottom: 20px;
}

form input[type="text"],
form input[type="date"],
form input[type="time"],
form select {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 80%; /* Adjust width as needed */
    margin-bottom: 10px; /* Space between inputs */
}

form button {
    padding: 10px 15px;
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

/* Link Styles */
a {
    display: inline-block;
    margin: 10px 0;
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

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #d4b99f; /* Light coffee border color */
}

th {
    background-color: #6f4c3e; /* Header background color */
    color: #fff;
}

tr:hover {
    background-color: #f2e4db; /* Light cream on row hover */
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