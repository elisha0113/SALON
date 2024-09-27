<html>
    <head>
        <link rel="stylesheet" href="header_style.css">
    </head>
<body>
<header>
            <div class="nav nav-container">
                <a href="" class="logo">May Salon</a>
                <div class="navbar">
                    <a href="upload_profile.php">
                    <div class="dropdown">
        <!-- Profile picture that triggers the dropdown -->
         
        <div class="profile-container">
        <div class="profile-img">
        <?php if (isset($_SESSION['profile_picture'])): ?>
            <img src="<?php echo htmlspecialchars($_SESSION['profile_picture']) . '?t=' . time(); ?>" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);" onclick="window.location.href='profile.php';">
<?php else: ?>
    <img src="maysalonprofilepicture.jpg" alt="Default Profile Picture" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);" onclick="window.location.href='profile.php';">
<?php endif; ?>

</div>        
            <!-- Dropdown options -->
        <div class="dropdown-content">
            <!-- Change Profile Picture Option -->
            <a href="upload_profile.php">Change Profile Picture</a>
            <!-- Profile -->
            <a href="user_profile.php">My Profile</a>
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
