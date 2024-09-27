<?php
session_start();
include 'setup.php';

if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch product categories from the database
$category_query = "SELECT CategoryID, CategoryName FROM productcategories";
$category_result = mysqli_query($con, $category_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $stock = mysqli_real_escape_string($con, $_POST['stock']);
    $status = ($stock == 0) ? 'Out of stock' : mysqli_real_escape_string($con, $_POST['status']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']); // Get selected category ID
    
    // Handle product image name (optional)
    $product_img_name = isset($_POST['product_img_name']) ? mysqli_real_escape_string($con, $_POST['product_img_name']) : NULL;

    // Validate price and stock
    if (!is_numeric($price) || $price < 0) {
        echo "<script>alert('Invalid price.');</script>";
        return;
    }

    if (!is_numeric($stock) || $stock < 0) {
        echo "<script>alert('Invalid stock.');</script>";
        return;
    }

    // Insert new product into the database
    $query = "INSERT INTO products (Name, Price, Stock, Status, Details, CategoryID" . 
             ($product_img_name ? ", Product_img_name" : "") . 
             ") VALUES ('$name', '$price', '$stock', '$status', '$description', '$category_id" . 
             ($product_img_name ? ", '$product_img_name'" : "") . 
             "')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Product added successfully'); window.location.href='admin.php?page=products';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        error_log("Query failed: $query");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="price">Price:</label>
        <input type="text" name="price" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" required>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Available">Available</option>
            <option value="No longer sold">No longer sold</option>
        </select>

        <label for="category">Category:</label>
        <select name="category_id" required>
            <option value="">Select a category</option>
            <?php
            // Populate category dropdown
            while ($row = mysqli_fetch_assoc($category_result)) {
                echo "<option value='" . $row['CategoryID'] . "'>" . $row['CategoryName'] . "</option>";
            }
            ?>
        </select>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <label for="product_img_name">Image Name (Optional):</label>
        <input type="text" name="product_img_name"> <!-- This is optional -->

        <button type="submit">Add Product</button>
    </form>

    <br>
    <button onclick="window.location.href='admin.php?page=products'">Exit to Admin</button>
</body>
</html>



<style>

/* General Body Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #4b3d3d; /* Dark Coffee Brown */
    color: #704c43; /* Beige for contrast */
    margin: 0;
    padding: 20px;
}


/* Form Container Styles */
form {
    background-color: rgba(255, 245, 238, 0.9); /* Light Cream with transparency */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* Form Input Styles */
form input[type="text"],
form input[type="number"],
form input[type="email"],
form select,
form textarea {
    width: calc(100% - 20px); /* Full width with padding */
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #c4c4c4; /* Light Grey border */
    border-radius: 5px;
    background-color: #fff3e6; /* Light Coffee Cream */
    color: #3d2a2a; /* Dark Coffee text */
}

/* Form Textarea Styles */
form textarea {
    height: 100px; /* Height for the textarea */
}

/* Form Button Styles */
form button {
    background-color: #8d6e63; /* Coffee Brown */
    color: #ffffff; /* White text */
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Button Hover Effects */
form button:hover {
    background-color: #704c43; /* Darker Coffee Brown on hover */
}

/* Form Label Styles */
form label {
    font-weight: bold;
}

/* Back Button Styles */
a button {
    margin-top: 20px;
    padding: 10px 15px;
    background-color: #8d6e63; /* Coffee Brown */
    color: #704c43; /* White text */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Back Button Hover Effects */
a button:hover {
    background-color: #704c43; /* Darker Coffee Brown on hover */
}


h2 {
    color:#ffffff;
}

</style>