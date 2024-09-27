<?php
#to connect with SQL
$con = mysqli_connect("localhost","root","","salon");
#Prompt messages if connect fail
if (mysqli_connect_errno()){
    echo "The database is not connected!".mysqli_connect_error();
}
?>

