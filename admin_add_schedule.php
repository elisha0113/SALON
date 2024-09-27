<?php
session_start();
include 'setup.php';

// Check if admin is logged in.
if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch employees for dropdown
$employees_query = "SELECT EmployeeID, Name FROM employees";
$employees_result = mysqli_query($con, $employees_query);

if (isset($_POST['add_schedule'])) {
    $employee_id = mysqli_real_escape_string($con, $_POST['employee_id']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $start_time = mysqli_real_escape_string($con, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($con, $_POST['end_time']);
    $availability_status = mysqli_real_escape_string($con, $_POST['availability_status']);

    // Generate a unique schedule ID between 500 and 1000
    do {
        $schedule_id = rand(500, 1000);
        // Check for uniqueness in the database
        $check_query = "SELECT * FROM schedules WHERE ScheduleID = '$schedule_id'";
        $check_result = mysqli_query($con, $check_query);
    } while (mysqli_num_rows($check_result) > 0);

    $query = "INSERT INTO schedules (ScheduleID, EmployeeID, Date, StartTime, EndTime, AvailabilityStatus) 
              VALUES ('$schedule_id', '$employee_id', '$date', '$start_time', '$end_time', '$availability_status')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Schedule added successfully'); </script>";
    } else {
        echo "<script>alert('Error adding schedule');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedule</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h2>Add Schedule</h2>
    <form method="POST">
        <label for="employee_id">Employee:</label>
        <select name="employee_id" required>
            <?php while ($employee = mysqli_fetch_assoc($employees_result)) { ?>
                <option value="<?php echo $employee['EmployeeID']; ?>"><?php echo $employee['Name']; ?></option>
            <?php } ?>
        </select>
        
        <label for="date">Date:</label>
        <input type="date" name="date" required>
        
        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" required>
        
        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" required>
        
        <label for="availability_status">Availability Status:</label>
        <input type="text" name="availability_status" required>
        
        <button type="submit" name="add_schedule">Add Schedule</button>
    </form>
</body>
</html>