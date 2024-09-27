<?php
session_start();
$LOGIN=$_SESSION['AdminId'];
if(!isset($_SESSION['AdminId'])){
header('Location: admin_login.php');
exit(); }
?>
