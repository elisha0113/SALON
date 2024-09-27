<?php
// Include the database connection
include('setup.php');

// Initialize an empty search keyword and category
$search_keyword = '';
$search_category = '';

// Fetch all categories for the dropdown list
$category_query = "SELECT * FROM productcategories";
$category_result = mysqli_query($con, $category_query);

// Check if the form is submitted with a search keyword
if (isset($_POST['search'])) {
    $search_keyword = mysqli_real_escape_string($con, $_POST['keyword']);

    // Modify the query to include a WHERE clause for search keyword
    $query = "SELECT * FROM products WHERE (Name LIKE '%$search_keyword%' OR Details LIKE '%$search_keyword%')";
} elseif (isset($_POST['view_all'])) {
    // Default query to fetch all products
    $query = "SELECT * FROM products";
} elseif (isset($_POST['filter_category'])) {
    $search_category = mysqli_real_escape_string($con, $_POST['category']);

    // Modify the query to include a WHERE clause for the selected category
    if (!empty($search_category)) {
        $query = "SELECT * FROM products WHERE CategoryID = '$search_category'";
    } else {
        $query = "SELECT * FROM products"; // No category selected, fetch all products
    }
} else {
    // Default query to fetch all products
    $query = "SELECT * FROM products";
}

$result = mysqli_query($con, $query);
?>

<h2>Products</h2>

<!-- Search form -->
<form method="POST" action="">
    <!-- Search by product name or details -->
    <input type="text" name="keyword" placeholder="Search by product name or details" value="<?php echo htmlspecialchars($search_keyword); ?>">
    <input type="submit" name="search" value="Search">
    <input type="submit" name="view_all" value="View All Products">
</form>

<!-- Category filter form -->
<form method="POST" action="">
    <!-- Search by category -->
    <select name="category">
        <option value="">Select Category</option>
        <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
            <option value="<?php echo $category['CategoryID']; ?>" <?php if ($search_category == $category['CategoryID']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($category['CategoryName']); ?>
            </option>
        <?php } ?>
    </select>
    <input type="submit" name="filter_category" value="Filter by Category">
</form>

<a href="admin_add_product.php">Add Product</a>
<a href="admin_add_category.php">Add Category</a> <!-- Add Category button -->

<table border="1">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Details</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Category Name</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                // Fetch the category name for the product
                $category_id = $row['CategoryID'];
                $category_name_query = "SELECT CategoryName FROM productcategories WHERE CategoryID = '$category_id'";
                $category_name_result = mysqli_query($con, $category_name_query);
                $category_name = mysqli_fetch_assoc($category_name_result)['CategoryName'];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['ProductID']); ?></td>
                <td><?php echo htmlspecialchars($row['Name']); ?></td>
                <td><?php echo htmlspecialchars($row['Price']); ?></td>
                <td><?php echo htmlspecialchars($row['Details']); ?></td>
                <td><?php echo htmlspecialchars($row['Stock']); ?></td>
                <td><?php echo htmlspecialchars($row['Status']); ?></td>
                <td><?php echo htmlspecialchars($category_name); ?></td>
                <td><a href="admin_edit_product.php?id=<?php echo $row['ProductID']; ?>">Edit</a></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="8">No products found matching your search or category.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>



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
    justify-content: center;
    margin-bottom: 20px;
    flex-wrap: wrap; /* Wrap form elements */
}

form input[type="text"],
form select {
    padding: 10px;
    border: 1px solid #c2a68d; /* Light coffee color */
    border-radius: 5px;
    font-size: 1rem;
    margin-right: 10px;
    flex: 1; /* Grow to fill space */
    min-width: 250px; /* Minimum width for inputs */
}

form input[type="submit"] {
    padding: 10px 15px;
    background-color: #6f4c3e; /* Coffee button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
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
    form input[type="text"],
    form select {
        min-width: 100%; /* Full width on smaller screens */
        margin-bottom: 10px; /* Space between elements */
    }
}


</style>