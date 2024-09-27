<?php
// Start the session
session_start();

// Include the database connection file
include('setup.php');

// Assuming the user is logged in, fetch the customer ID from the session
// Modify as needed based on your session structure
$CustomerID = $_SESSION['CustomerID'];

// Initialize variables
$success = "";
$error = "";

// Fetch customer details
$query = "SELECT * FROM customers WHERE CustomerID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $CustomerID);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Handle form submission to update customer details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Update query
    $update_query = "UPDATE customers SET Name = ?, Email = ?, Phone = ?, Password = ? WHERE CustomerID = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param('ssssi', $name, $email, $phone, $password, $CustomerID);

    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
        // Refresh customer details after update
        $customer['Name'] = $name;
        $customer['Email'] = $email;
        $customer['Phone'] = $phone;
        $customer['Password'] = $password;
    } else {
        $error = "Failed to update profile. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[readonly] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Profile</h2>

    <!-- Success or error messages -->
    <div class="message">
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
    </div>

    <form action="user_profile.php" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($customer['Name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($customer['Email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($customer['Phone']); ?>" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="text" name="dob" id="dob" value="<?php echo htmlspecialchars($customer['DateOfBirth']); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <input type="text" name="gender" id="gender" value="<?php echo htmlspecialchars($customer['Gender']); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="password">Password (Leave blank to keep the current password):</label>
            <input type="password" name="password" id="password">
        </div>

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>
