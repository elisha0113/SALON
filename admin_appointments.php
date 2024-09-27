<?php
include 'setup.php';

// Get the current month and year, or use the provided month and year from the URL
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Fetch appointments for the current month
$query = "
    SELECT a.AppointmentID, c.Name AS customer_name, a.EmployeeID, a.ServiceID, a.AppointmentDate, a.AppointmentTime, a.Status
    FROM appointments a
    JOIN customers c ON a.CustomerID = c.CustomerID
    WHERE MONTH(a.AppointmentDate) = ? AND YEAR(a.AppointmentDate) = ?
";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $month, $year);
$stmt->execute();
$appointmentsResult = $stmt->get_result();

// Organize appointments by date
$appointmentsByDate = [];
while ($row = $appointmentsResult->fetch_assoc()) {
    $appointmentsByDate[$row['AppointmentDate']][] = $row;
}
$stmt->close();

// Generate calendar
$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
$totalDays = date('t', $firstDayOfMonth);
$dayOfWeek = date('w', $firstDayOfMonth);
$dayOfWeek = ($dayOfWeek == 0) ? 6 : $dayOfWeek - 1; // Adjust to make Monday the first day of the week

// Display calendar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments Management</title>
    <style>
        /* Simple CSS for the calendar */
        #calendar {
            display: flex;
            flex-wrap: wrap;
            max-width: 800px; /* Adjust width as needed */
            margin: 0 auto;
        }
        .day {
            border: 1px solid #ccc;
            width: calc(100% / 7); /* 7 days a week */
            height: 120px; /* Increased height for larger cells */
            position: relative;
            box-sizing: border-box;
        }
        .day-header {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            padding: 5px 0;
        }
        .day-content {
            padding: 5px;
            text-align: center;
            position: absolute;
            top: 30px; /* Adjust to accommodate header */
            left: 0;
            right: 0;
        }
        .week-header {
            display: flex;
            width: 100%;
        }
        .week-header div {
            width: calc(100% / 7); /* Equal width for each day of the week */
            text-align: center;
            font-weight: bold;
            background-color: #e0e0e0;
            padding: 10px 0;
        }
    </style>
</head>
<body>

<h2>Appointments Management</h2>

<!-- Calendar Navigation -->
<div>
    <a href="admin_appointments.php?month=<?php echo $month - 1; ?>&year=<?php echo $year; ?>">Previous Month</a>
    <a href="admin_appointments.php?month=<?php echo $month + 1; ?>&year=<?php echo $year; ?>">Next Month</a>
</div>

<!-- Days of the Week -->
<div class="week-header">
    <div>Monday</div>
    <div>Tuesday</div>
    <div>Wednesday</div>
    <div>Thursday</div>
    <div>Friday</div>
    <div>Saturday</div>
    <div>Sunday</div>
</div>

<div id="calendar">
    <?php for ($i = 0; $i < $dayOfWeek; $i++): ?>
        <div class="day"></div> <!-- Empty cells for days before the first -->
    <?php endfor; ?>

    <?php for ($day = 1; $day <= $totalDays; $day++): ?>
        <?php $date = sprintf('%04d-%02d-%02d', $year, $month, $day); ?>
        <div class="day">
            <div class="day-header"><?php echo $day; ?></div>
            <div class="day-content">
                <?php if (isset($appointmentsByDate[$date])): ?>
                    <strong><?php echo count($appointmentsByDate[$date]); ?> Appointment(s)</strong><br>
                    <a href="admin_appointments.php?date=<?php echo $date; ?>">View Details</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endfor; ?>
</div>

<!-- Appointments List -->
<?php if (isset($_GET['date'])): ?>
    <h3>Appointments on <?php echo htmlspecialchars($_GET['date']); ?></h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Employee ID</th>
                <th>Service ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $selectedDate = $_GET['date'];
            $appointmentsQuery = "
                SELECT a.AppointmentID, c.Name AS customer_name, a.EmployeeID, a.ServiceID, a.AppointmentDate, a.AppointmentTime, a.Status
                FROM appointments a
                JOIN customers c ON a.CustomerID = c.CustomerID
                WHERE a.AppointmentDate = ?
            ";
            $appointmentsStmt = $con->prepare($appointmentsQuery);
            $appointmentsStmt->bind_param("s", $selectedDate);
            $appointmentsStmt->execute();
            $appointmentsResult = $appointmentsStmt->get_result();

            while ($row = $appointmentsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['AppointmentID']; ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td><?php echo $row['EmployeeID']; ?></td>
                    <td><?php echo $row['ServiceID']; ?></td>
                    <td><?php echo $row['AppointmentDate']; ?></td>
                    <td><?php echo $row['AppointmentTime']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td>
                        <?php if ($row['Status'] != 'Cancelled' && $row['Status'] != 'Completed'): ?>
                            <form method="post" action="" onsubmit="return confirm('Are you sure you want to change the status?');">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['AppointmentID']; ?>">
                                <input type="submit" name="action" value="cancel" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                <input type="submit" name="action" value="complete" onclick="return confirm('Are you sure you want to mark this appointment as completed?');">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            <?php $appointmentsStmt->close(); ?>
        </tbody>
    </table>
<?php endif; ?>

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



/* Main content margin to accommodate the sidebar */
.main-content {
    margin-left: 270px; /* Space for sidebar */
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