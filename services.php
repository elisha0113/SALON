<!DOCTYPE html>
<?php
include 'header.php';
include 'setup.php'; // Database connection

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>May Salon Services</title>
    <link href="ServiceStyle.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="resolution.css" rel="stylesheet"> 
</head>

<body>
<div id="resolution">
    <!-- Cover Picture Section -->
    <div class="cover-image">
        <img src="Background1.jpg" alt="Salon Cover Image">
        <div class="cover-text">
            <h1>Welcome to May Salon</h1>
            <p>Unleash Your True Radiance</p>
        </div>
    </div>

    <section class="descript">
        <h2>Our Services</h2>
        <p>At May Salon, we offer more than just an ordinary salon experience. We provide convenience, personalization, and transformation—all at affordable prices. 
        From quick trims and vibrant hair coloring to complete makeovers, everything you need for your hair is available under one roof.</p>
    </section>

    <div class="container">
        <?php
        // Fetch services from the database
        $query = "SELECT ServiceName, Description, service_img_name FROM services";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            // Loop through the services and display them
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';
                echo '<img src="'.$row['service_img_name'].'" alt="'.$row['ServiceName'].'">';
                echo '<h3>'. $row['ServiceName'] .'</h3>';
                echo '<p>'. $row['Description'] .'</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No services available at the moment.</p>';
        }
        ?>
    </div>
</div>
</body>
</html>
