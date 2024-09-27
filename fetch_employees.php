<?php
include('setup.php');

if (isset($_GET['serviceID'])) {
    $serviceID = $_GET['serviceID'];

    // Get the RoleID from the service_roles table
    $role_query = "SELECT RoleID FROM service_roles WHERE ServiceID = '$serviceID'";
    $role_result = mysqli_query($con, $role_query);
    $role_data = mysqli_fetch_assoc($role_result);
    $roleID = $role_data['RoleID'];

    // Fetch employees with that RoleID
    $employee_query = "SELECT EmployeeID, Name FROM employees WHERE RoleID = '$roleID' AND EmployeeStatus = 'Active'";
    $employee_result = mysqli_query($con, $employee_query);

    while ($employee = mysqli_fetch_assoc($employee_result)) {
        echo "<option value='{$employee['EmployeeID']}'>{$employee['Name']}</option>";
    }
}
?>
