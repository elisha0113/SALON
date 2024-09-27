<?php
include('setup.php');

if (isset($_GET['employeeID']) && isset($_GET['date'])) {
    $employeeID = $_GET['employeeID'];
    $date = $_GET['date'];

    // Fetch the employee's schedule for the selected date
    $schedule_query = "SELECT StartTime, EndTime FROM schedules WHERE EmployeeID = '$employeeID' AND Date = '$date' AND AvailabilityStatus = 'Available'";
    $schedule_result = mysqli_query($con, $schedule_query);

    if (mysqli_num_rows($schedule_result) > 0) {
        $schedule = mysqli_fetch_assoc($schedule_result);
        $startTime = $schedule['StartTime'];
        $endTime = $schedule['EndTime'];

        // Generate time slots in 30-minute intervals
        $time = $startTime;
        while (strtotime($time) < strtotime($endTime)) {
            echo "<option value='$time'>$time</option>";
            $time = date('H:i', strtotime($time) + 30 * 60); // 30 minutes interval
        }
    } else {
        echo "<option value=''>No available times</option>";
    }
}
?>
