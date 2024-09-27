<?php
session_start();
include 'setup.php';

// Check if admin is logged in.
if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

$schedule_id = mysqli_real_escape_string($con, $_GET['id']);
$schedule_query = "SELECT * FROM schedules WHERE ScheduleID='$schedule_id'";
$schedule_result = mysqli_query($con, $schedule_query);
$schedule = mysqli_fetch_assoc($schedule_result);

// Fetch employees for dropdown
$employees_query = "SELECT EmployeeID, Name FROM employees";
$employees_result = mysqli_query($con, $employees_query);

if (isset($_POST['update_schedule'])) {
    $employee_id = mysqli_real_escape_string($con, $_POST['employee_id']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $start_time = mysqli_real_escape_string($con, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($con, $_POST['end_time']);
    $availability_status = mysqli_real_escape_string($con, $_POST['availability_status']);

    $query = "UPDATE schedules SET EmployeeID='$employee_id', Date='$date', StartTime='$start_time', 
              EndTime='$end_time', AvailabilityStatus='$availability_status' WHERE ScheduleID='$schedule_id'";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Schedule updated successfully'); window.location.href='admin.php?page=schedules';</script>";
    } else {
        echo "<script>alert('Error updating schedule');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h2>Edit Schedule</h2>
    <form method="POST">
        <label for="employee_id">Employee:</label>
        <select name="employee_id" required>
            <?php while ($employee = mysqli_fetch_assoc($employees_result)) { ?>
                <option value="<?php echo $employee['EmployeeID']; ?>" <?php if ($employee['EmployeeID'] == $schedule['EmployeeID']) echo 'selected'; ?>>
                    <?php echo $employee['Name']; ?>
                </option>
            <?php } ?>
        </select>
        
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo $schedule['Date']; ?>" required>
        
        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" value="<?php echo $schedule['StartTime']; ?>" required>
        
        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" value="<?php echo $schedule['EndTime']; ?>" required>
        
        <label for="availability_status">Availability Status:</label>
        <input type="text" name="availability_status" value="<?php echo $schedule['AvailabilityStatus']; ?>" required>
        
        <button type="submit" name="update_schedule">Update Schedule</button>
    </form>
    <a href="admin.php?page=schedules" class="back-button">
    <button type="button">Back to Admin Page</button>
</a>
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
    flex-direction: column; /* Stack elements vertically */
    align-items: center; /* Center align the form elements */
    margin-bottom: 20px;
}

form label {
    margin: 10px 0 5px; /* Space above and below labels */
    font-weight: bold;
}

form select,
form input[type="date"],
form input[type="time"],
form input[type="text"] {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 80%; /* Adjusted width */
    margin-bottom: 15px;
}

form button {
    padding: 10px 15px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 80%; /* Match button width with input fields */
}

form button:hover {
    background-color: #5a3a31; /* Darker coffee color on hover */
}

/* Link Styles */
a {
    display: inline-block;
    margin: 20px 0;
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

/* Back Button Styles */
.back-button {
    display: block; /* Make the link behave like a block element */
    margin-top: 20px; /* Space above the button */
}

.back-button button {
    padding: 5px 10px; /* Smaller padding for a smaller button */
    background-color: #c2a68d; /* Light coffee background */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: auto; /* Fit content */
}

.back-button button:hover {
    background-color: #b79b7e; /* Slightly darker coffee on hover */
}

/* Positioning the back button at the bottom left */
body {
    position: relative; /* Ensure body is positioned relatively for absolute child */
}

.back-button {
    position: absolute; /* Positioning the button */
    bottom: 20px; /* Space from the bottom */
    left: 20px; /* Space from the left */
}



/* Responsive Design */
@media (max-width: 768px) {
    form select,
    form input[type="date"],
    form input[type="time"],
    form input[type="text"] {
        width: 90%; /* Adjust input width on smaller screens */
    }
}


</style>