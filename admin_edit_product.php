<?php
session_start();
include 'setup.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

// Check if ProductID is set in the URL
if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['id']);

    // Fetch product details for editing
    $query = "SELECT * FROM products WHERE ProductID='$product_id'";
    $result = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($result);

    // Check if the product exists
    if (!$product) {
        echo "<script>alert('Product not found.'); window.location.href='admin.php?page=products';</script>";
        exit();
    }

    // Handle form submission for updating the product
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize form inputs
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $stock = mysqli_real_escape_string($con, $_POST['stock']);
        $status = ($stock == 0) ? 'Out of stock' : mysqli_real_escape_string($con, $_POST['status']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $category_id = mysqli_real_escape_string($con, $_POST['category']);

        // Update product in the database
        $query = "UPDATE products SET Name='$name', Price='$price', Stock='$stock', Status='$status', Details='$description', CategoryID='$category_id' 
                  WHERE ProductID='$product_id'";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Product updated successfully'); window.location.href='admin.php?page=products';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
} else {
    echo "<script>alert('No ProductID specified.'); window.location.href='admin.php?page=products';</script>";
    exit();
}

// Fetch all categories for the category dropdown
$category_query = "SELECT * FROM productcategories";
$category_result = mysqli_query($con, $category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['Name']); ?>" required>

        <label for="price">Price:</label>
        <input type="text" name="price" value="<?php echo htmlspecialchars($product['Price']); ?>" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" value="<?php echo htmlspecialchars($product['Stock']); ?>" required>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Available" <?php if ($product['Status'] == 'Available') echo 'selected'; ?>>Available</option>
            <option value="No longer sold" <?php if ($product['Status'] == 'No longer sold') echo 'selected'; ?>>No longer sold</option>
            <option value="Out of stock" <?php if ($product['Status'] == 'Out of stock') echo 'selected'; ?>>Out of stock</option>
        </select>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($product['Details']); ?></textarea>

        <label for="category">Category:</label>
        <select name="category" required>
            <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
                <option value="<?php echo $category['CategoryID']; ?>" <?php if ($product['CategoryID'] == $category['CategoryID']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($category['CategoryName']); ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Update Product</button>
    </form>
    <a href="admin.php?page=products">Back to Product List</a>
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
    flex-direction: column; /* Column layout for form items */
    align-items: center; /* Center align the form items */
    background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px; /* Max width for the form */
    margin: auto; /* Center the form on the page */
}

form label {
    margin-bottom: 5px; /* Space between label and input */
    font-weight: bold; /* Bold labels */
}

form input[type="text"],
form input[type="number"],
form select,
form textarea {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    width: 100%; /* Full width for inputs */
    margin-bottom: 15px; /* Space below inputs */
}

form textarea {
    resize: vertical; /* Allow vertical resizing for textarea */
    height: 100px; /* Default height for textarea */
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
    margin-top: 10px;
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

/* Responsive Design */
@media (max-width: 768px) {
    form {
        padding: 15px; /* Adjust padding on smaller screens */
    }
    form input[type="text"],
    form input[type="number"],
    form select,
    form textarea {
        width: 90%; /* Adjust input width on smaller screens */
    }
}

</style>