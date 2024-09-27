<!DOCTYPE html>

<html lang="en">

<?php
include 'header.php';
include 'setup.php'; // This connects to your database
?>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>May Salon Feedback Page</title>
    <link href="review.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/fav-icon.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

</head>

<body>

    <section id="testimonials">
    
        <div class="testimonial-heading">
            <br><br><br><br><br>
            <h1>Welcome to May Salon's Feedback Page!</h1>
            <p>We value your thoughts and suggestions to keep improving our services. Check out some of the reviews from our customers, and feel free to leave your own feedback below!</p>
            <br>
        </div>

        <div class="testimonial-box-container">

            <?php
            // Fetch reviews from the database
            $query = "
                SELECT r.Comments, r.ReviewDate, c.Name, c.CustomerID
                FROM reviews r
                INNER JOIN customers c ON r.CustomerID = c.CustomerID
                ORDER BY r.ReviewDate DESC";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['Name'];
                    $comments = $row['Comments'];
                    $reviewDate = $row['ReviewDate'];
                    $timeDiff = '';

                    // Get the time difference between the review date and the current date
                    $currentDate = new DateTime();
                    $reviewDateTime = new DateTime($reviewDate);
                    $interval = $currentDate->diff($reviewDateTime);

                    if ($interval->days == 0) {
                        $timeDiff = 'today';
                    } elseif ($interval->days == 1) {
                        $timeDiff = 'yesterday';
                    } elseif ($interval->days < 7) {
                        $timeDiff = $interval->days . ' days ago';
                    } else {
                        $timeDiff = $reviewDateTime->format('F j, Y');
                    }

                    echo "
                    <div class='testimonial-box'>
                        <div class='box-top'>
                            <div class='profile'>
                                <div class='name-user'>
                                    <strong>$name</strong>
                                </div>
                            </div>
                        </div>
                        <div class='client-comment'>
                            <p>$comments</p>
                            </div>
                            <p class='review-date'>Posted $timeDiff</p>
                    </div>";
                }
            } else {
                echo "<p>No reviews found.</p>";
            }
            ?>


        </div>

        <div class="copyright">
            <p class="copyright"> &copy; 2024 May Salon. All rights reserved. </p>
            <script src="https://unpkg.com/scrollreveal"></script>
            <script src="index_js.js"></script>
        </div>

    </section>

</body>

</html>


<script>

// Get all testimonial boxes
const testimonialBoxes = document.querySelectorAll('.testimonial-box');

// Define random colors
const colors = ['#f5e3d3', '#ccb9a8', '#8c7a6b', '#e8d6cb', '#d5c2b0'];

// Function to get contrasting text color (black or white)
function getTextColor(backgroundColor) {
    const rgb = backgroundColor.replace(/[^\d,]/g, '').split(',');
    const brightness = (parseInt(rgb[0]) * 299 + parseInt(rgb[1]) * 587 + parseInt(rgb[2]) * 114) / 1000;
    return brightness > 186 ? '#000000' : '#ffffff';
}

// Apply random colors to each testimonial box
testimonialBoxes.forEach(box => {
    const randomColor = colors[Math.floor(Math.random() * colors.length)];
    box.style.backgroundColor = randomColor;
    const textColor = getTextColor(window.getComputedStyle(box).backgroundColor);
    box.style.color = textColor; // Adjust text color
});


</script>