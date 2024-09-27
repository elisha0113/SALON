<?php
session_start();
include 'header.php';

// Check if the session variable CustomerID is set
if(!isset($_SESSION["CustomerID"])){
    header('Location: login.php');
    exit();
}

require 'setup.php'; // Make sure the database connection is established

$CUSTOMER = $_SESSION["CustomerID"];

// Query to get user information from the database
$showname = mysqli_query($con, "SELECT Name FROM customers WHERE CustomerID='$CUSTOMER'");
$info1 = mysqli_fetch_array($showname);

// Check if the query was successful and the result is not empty
if ($info1) {
    $username = $info1['Name'];
} else {
    echo "<script>alert('Unable to fetch user details'); window.location='login.php'</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Hello, <?php echo htmlspecialchars($username); ?>!</h1>
    <p>Welcome to our website!</p>
</body>
</html>
