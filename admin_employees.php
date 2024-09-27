<?php
// Fetch employees with their roles using a JOIN query between employees and roles
$query = "SELECT employees.EmployeeID, employees.Name, employees.Email, employees.Phone, roles.RoleName 
          FROM employees 
          JOIN roles ON employees.RoleID = roles.RoleID";
$result = mysqli_query($con, $query);

if (isset($_POST['search'])) {
    $search_value = mysqli_real_escape_string($con, $_POST['search_value']);
    $query = "SELECT employees.EmployeeID, employees.Name, employees.Email, employees.Phone, roles.RoleName 
              FROM employees 
              JOIN roles ON employees.RoleID = roles.RoleID 
              WHERE employees.Name LIKE '%$search_value%'";
    $result = mysqli_query($con, $query);
}
?>

<h2>Employees Management</h2>

<form method="POST" action="admin.php?page=employees">
    <input type="text" name="search_value" placeholder="Search employees">
    <button type="submit" name="search">Search</button>
</form>

<a href="admin_add_employee.php">Add Employee</a>
<a href="admin_add_role.php">Add Role</a>

<table border="1">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['EmployeeID']; ?></td>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Phone']; ?></td>
            <td><?php echo $row['RoleName']; ?></td> <!-- Display Role Name -->
            <td><a href="admin_edit_employee.php?id=<?php echo $row['EmployeeID']; ?>">Edit</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>



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
    justify-content: center;
    margin-bottom: 20px;
}

form input[type="text"] {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 60%;
    margin-right: 10px;
}

form button {
    padding: 10px 15px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #5a3a31; /* Darker coffee color on hover */
}

/* Link Styles */
a {
    display: inline-block;
    margin: 10px 15px;
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
    form input[type="text"] {
        width: 70%; /* Adjust input width on smaller screens */
    }
}



</style>