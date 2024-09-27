<?php
session_start();
include 'setup.php';

// Check if admin is logged in.
if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch admin details.
$admin_name = $_SESSION["AdminName"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>May Salon Admin</title>
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>

    <div class="header">
        <div class="logo">May Salon Admin</div>
        <div class="admin-name">Welcome, <?php echo $admin_name; ?></div>
    </div>

    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="admin.php?page=employees">Employees</a></li>
                <li><a href="admin.php?page=appointments">Appointments</a></li>
                <li><a href="admin.php?page=products">Products</a></li>
                <li><a href="admin.php?page=roles">Roles</a></li>
                <li><a href="admin.php?page=schedules">Schedules</a></li>
                <li><a href="admin.php?page=services">Services</a></li> <!-- New Service link added -->
            </ul>
            <div class="logout">
                <a href="admin_logout.php">Sign Out</a>
            </div>
        </div>

        <div class="main-content">
            <?php
            // Include the correct page based on the menu selection.
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'appointment_details':
                        include 'admin_appointment_details.php';
                        break;
                    case 'employees':
                        include 'admin_employees.php';
                        break;
                    case 'appointments':
                        include 'admin_appointments.php';
                        break;
                    case 'products':
                        include 'admin_products.php';
                        break;
                    case 'roles':
                        include 'admin_roles.php';
                        break;
                    case 'schedules':
                        include 'admin_schedules.php';
                        break;
                    case 'services':
                        include 'admin_service.php'; // New case for services
                        break;
                    default:
                        echo "<h2>Welcome to the Admin Dashboard</h2>";
                        break;
                }
            } else {
                echo "<h2>Welcome to the Admin Dashboard</h2>";
            }
            ?>
        </div>
    </div>

</body>

</html>
