<?php
// Include the setup.php to connect to the database
include 'setup.php';
include 'header.php';

// Check if a category is selected
$selectedCategoryID = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

// Fetch all categories from the productcategories table
$query = "SELECT * FROM productcategories";
$result = mysqli_query($con, $query);

// Display categories
echo "<h1>Product Categories</h1>";
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li><a href='?category_id=" . $row['CategoryID'] . "'>" . $row['CategoryName'] . "</a> - " . $row['Description'] . "</li>";
}
echo "</ul>";

// If a category is selected, fetch and display products in that category
if ($selectedCategoryID) {
    $productQuery = "SELECT * FROM products WHERE CategoryID = $selectedCategoryID";
    $productResult = mysqli_query($con, $productQuery);

    if (mysqli_num_rows($productResult) > 0) {
        echo "<h2>Products in Category: " . mysqli_fetch_assoc(mysqli_query($con, "SELECT CategoryName FROM productcategories WHERE CategoryID = $selectedCategoryID"))['CategoryName'] . "</h2>";
        echo "<ul>";
        while ($product = mysqli_fetch_assoc($productResult)) {
            echo "<li>";
            echo "<h3>" . $product['Name'] . "</h3>";
            echo "<p>" . $product['Details'] . "</p>";
            echo "<p>Price: RM " . number_format($product['Price'], 2) . "</p>";
            echo "<img src='" . $product['Product_img_name'] . "' alt='" . $product['Name'] . "' style='width:100px;'/>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No products found in this category.</p>";
    }
}
