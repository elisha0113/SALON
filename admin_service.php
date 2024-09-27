<?php
include 'setup.php'; // Connect to the database

// Fetch all services from the database
$query = "SELECT * FROM services";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    // Show error message if query fails
    echo "Error fetching services: " . mysqli_error($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Services</title>
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <h1>All Services</h1>

    <!-- Add Service Button -->
    <a href="admin_add_service.php">Add New Service</a>


    <!-- Display all services -->
    <table border="1">
        <tr>
            <th>Service Name</th>
            <th>Description</th>
            <th>Duration</th>
            <th>Price</th>
            <th>Role</th>
            <th>Service Image</th>
            <th>Edit</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ServiceName'] . "</td>";
            echo "<td>" . $row['Description'] . "</td>";
            echo "<td>" . $row['Duration'] . " minutes</td>";
            echo "<td>RM " . $row['Price'] . "</td>";
            echo "<td>" . $row['RoleID'] . "</td>";
            echo "<td>" . $row['service_img_name'] . "</td>";
            echo "<td><a href='admin_edit_service.php?edit=" . $row['ServiceID'] . "'>Edit</a></td>";
            echo "</tr>";
        }
        ?>
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
h2, h3 {
    text-align: center;
    color: #6f4c3e; /* Coffee brown */
    margin-bottom: 20px;
}

/* Common Form Styles */
form {
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    align-items: center; /* Center align items */
    margin-bottom: 20px;
}

form label {
    margin-bottom: 5px; /* Space between label and input */
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