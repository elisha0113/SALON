<html>
    <head>
        <link rel="stylesheet" href="header_style.css">
    </head>
<body>
<header>
            <div class="nav nav-container">
                <a href="" class="logo">May Salon</a>
                <div class="navbar">
                    <a href="index2.php" class="nav-link">Home</a>
                    <a href="aboutus.php" class="nav-link">About Us</a>
                    <a href="FAQs.html" class="nav-link">Services</a>
                    <a href="Drinks Menu.html" class="nav-link">Contact Us</a>
                    <a href="mp_rewards.html" class="nav-link">Feedback</a>
                    <a href="upload_profile.php">
                    <div class="dropdown">
        <!-- Profile picture that triggers the dropdown -->
         
        <img src="<?php session_start(); echo isset($_SESSION['profile_picture']) ? htmlspecialchars($_SESSION['profile_picture']) . '?t=' . time() : 'maysalonprofilepicture.jpg'; ?>" alt="Profile" class="profile-img">

        <!-- Dropdown options -->
        <div class="dropdown-content">
            <!-- Change Profile Picture Option -->
            <a href="upload_profile.php">Change Profile Picture</a>
            <!-- Logout Option -->
            <a href="logout.php">Logout</a>
        </div>
                </header>

<style>
    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%; /* Makes the image circular */
        object-fit: cover;
    }
</style>

</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture Options</title>
    <style>
        /* Style for the dropdown container */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Style for the profile picture (icon) */
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        /* Style for the dropdown links */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change background color when hovering over a link */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown when hovering over the profile picture */
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

</html>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $upload_dir = 'nbproject/'; // Ensure this directory exists and is writable
        $file_name = basename($_FILES['profile_picture']['name']);
        $target_file = $upload_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file type
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($file_type, $allowed_types)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                // Success: Update the profile picture URL in your database or session
                // Example: $_SESSION['profile_picture'] = $target_file;
                $_SESSION['profile_picture'] = $target_file;
                echo "Profile picture updated successfully!";
            } else {
                echo "Error uploading your file.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
?>




<div class="container">
    <div class="header">
        <h1>Change Profile Picture</h1>
    </div>
    <img src="<?php echo isset($_SESSION['profile_picture']) ? htmlspecialchars($_SESSION['profile_picture']) : 'maysalonprofilepicture.jpg'; ?>" alt="Profile Picture" class="profile-pic">


    <form method="post" enctype="multipart/form-data">
        <input type="file" id="file-upload" name="profile_picture" accept="image/*" style="display:none;" onchange="previewImage(event)">
        <label for="file-upload" class="upload-btn">Upload New Picture</label>
        <p class="info-text">Select a new picture to update your profile.</p>
        <button type="submit" class="upload-btn">Done</button>
    </form>


    <div class="footer">
        <p>&copy; 2024 May Salon | <a href="#">Privacy Policy</a></p>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

:root {
    --main-color: #54372a;
    --second-color: #6f4e37;
    --text-color: #060413;
    --bg-color: #EAE0D5;
    --container-color: #f8e4be;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    color: var(--text-color);
    background: var(--bg-color);
    margin: 100;
}


.container {
    max-width: 800px;
    margin: auto;
    padding: 2rem;
    text-align: center;
}

.header {
    margin-bottom: 2rem;
}

.header h1 {
    font-size: 2.5rem;
    font-weight: 600;
    color: var(--main-color);
}

.profile-pic {
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 5px solid var(--second-color);
    margin-bottom: 1rem;
}

.upload-btn {
    background-color: var(--main-color);
    color: var(--bg-color);
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.upload-btn:hover {
    background-color: var(--second-color);
}

.info-text {
    margin-top: 1rem;
    font-size: 1rem;
    color: var(--text-color);
}

.footer {
    margin-top: 3rem;
    font-size: 0.8rem;
    color: var(--text-color);
}

.footer a {
    color: var(--main-color);
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}

/* Responsive Styles */
@media (max-width: 600px) {
    .header h1 {
        font-size: 2rem;
    }

    .profile-pic {
        width: 120px;
        height: 120px;
    }
}
</style>


<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector('.profile-pic').src = e.target.result; // Change src to uploaded image
                document.querySelector('.profile-img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>