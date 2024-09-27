<?php
include 'setup.php';

if (!isset($_GET['id'])) {
    echo "No appointment selected.";
    exit();
}

$appointment_id = $_GET['id'];

// Fetch appointment details
$query = "
    SELECT a.*, c.Name AS customer_name
    FROM appointments a
    JOIN customers c ON a.CustomerID = c.CustomerID
    WHERE a.AppointmentID = ?
";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if (!$appointment) {
    echo "Appointment not found.";
    exit();
}
?>

<h2>Appointment Details</h2>
<form action="admin_edit_appointment.php" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointment['AppointmentID']); ?>">
    <label for="customer_name">Customer Name:</label>
    <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($appointment['customer_name']); ?>" readonly>
    <br>
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($appointment['AppointmentDate']); ?>" required>
    <br>
    <label for="time">Time:</label>
    <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($appointment['AppointmentTime']); ?>" required>
    <br>
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Scheduled" <?php echo ($appointment['Status'] == 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
        <option value="Completed" <?php echo ($appointment['Status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
        <option value="Canceled" <?php echo ($appointment['Status'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
    </select>
    <br>
    <input type="submit" value="Edit Appointment">
</form>



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
    flex-direction: column; /* Change to column for better layout */
    align-items: center; /* Center align the form items */
    background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px; /* Max width for the form */
    margin: auto; /* Center the form on the page */
}

form input[type="text"],
form input[type="date"],
form input[type="time"],
form select {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 100%; /* Full width for inputs */
    margin-bottom: 15px; /* Space below inputs */
}

form button {
    padding: 10px 15px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; /* Full width for button */
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
    form {
        padding: 15px; /* Adjust padding on smaller screens */
    }
    form input[type="text"],
    form input[type="date"],
    form input[type="time"],
    form select {
        width: 90%; /* Adjust input width on smaller screens */
    }
}



</style>