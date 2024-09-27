<?php
require 'setup.php';
include 'header.php';

if(isset($_POST['cust_id'])){
    $CustomerID = $_POST['cust_id'];
    $Name = $_POST['cust_name'];
    $Email = $_POST['cust_mail'];
    $Phone = $_POST['cust_num'];
    $DateOfBirth = $_POST['cust_dob'];
    $Gender = $_POST['gender'];
    $Password = $_POST['cust_pwd'];

    $custsave = "INSERT INTO customers(CustomerID,Name,Email,Phone,DateOfBirth,Gender,Password)
              VALUES ('$CustomerID', '$Name', '$Email', '$Phone', '$DateOfBirth', '$Gender', '$Password')";
    $result = mysqli_query($con, $custsave);

    if($result){
        session_start();
        $_SESSION["CustomerID"] = $CustomerID;
        echo "<script>alert('Registration successful'); window.location='cust_index.php'</script>";
    } else {
        echo "<script>alert('Registration failed, you may have already registered'); window.location='login.php'</script>";
    }
}
?>
