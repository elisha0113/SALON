<!DOCTYPE html>
<?php
session_start();
include 'setup.php';
include 'header.php';

if (isset($_POST['ic']) && isset($_POST['cust_pwd'])) {
    $user = mysqli_real_escape_string($con, $_POST['ic']);
    $password = mysqli_real_escape_string($con, $_POST['cust_pwd']);

    $query = mysqli_query($con, "SELECT * FROM customers WHERE CustomerID='$user'");
    $row = mysqli_fetch_assoc($query);

    if (mysqli_num_rows($query) == 0) {
        echo "<script>alert('IC number not found');</script>";
    } else {
        if ($row['Password'] === $password) {
            $_SESSION["CustomerID"] = $row['CustomerID'];
            header("Location: index2.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    }
}
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="resolution.css" rel="stylesheet" />
    

    <title>May Salon Login Page</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form method="post" class="sign-in-form">
            <h2 class="title">Welcome Back!</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input onblur="checkLength(this)" type="text" name="ic" placeholder="IC number without -" maxLength='13' required autofocus />
                    
              <script>
              function checkLength(el){
              if (el.value.length < 12){
              alert("Write your IC number")
              }
              }

              function checkLength(el){
              if (el.value.length > 12){
              alert("IC number invalid")
              }
              }
              </script>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="cust_pwd" placeholder="Password" maxlength="8" required />
            </div>
            <input type="submit" value="Login" class="btn solid" />
          </form>
            
              <!-- Admin button positioned at the bottom corner -->
            <div class="admin-button">
                <a href="admin.php" class="btn transparent">Admin Login</a>
            </div>
              
        <div class="admin-button">
            <a href="admin.php">
            <button style='font-size:20px ;color:white; background-color:#bcb4a3; padding: 10px;
            border: none; outline: none; border-radius: 49px;'> Admin Login <i class='far fa-user-circle'></i></button></a>
        </div>
          
     
              
          <form action="cust_save.php" class="sign-up-form" method="POST">
            <h2 class="title">Welcome to MaY SaLoN.</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="cust_id" placeholder="Ic number" maxlength="12" required />
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="cust_name" placeholder="Name" required />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="cust_mail" placeholder="Email" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="cust_pwd" placeholder="Password" maxlength="8" required />
            </div>
            <div class="input-field">
              <i class="fas fa-phone"></i>
              <input type="tel" name="cust_num" placeholder="Phone Number" maxlength="11" required />
            </div>
            <div class="input-field">
              <i class="fas fa-calendar"></i>
              <input type="date" name="cust_dob" required />
            </div>
            <div class="input-field">
              <i class="fas fa-venus-mars"></i>
              <select name="gender" required>
                <option value="" disabled selected>Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <input type="submit" class="btn" value="Sign up" />
          </form>
        </div>
      </div>
        

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Not a member?</h3>
            <p>
              Register now and unlock a world of possibilities with us! 
              By creating an account, start enjoying the benefits!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="SignOut.jpeg" class="image" alt="" />
        </div>

        <div class="panel right-panel">
          <div class="content">
            <h3>Sign in here</h3>
            <p>
              We’re excited to have you back. 
              Sign in to your account to pick up where you left off, explore new offers, and enjoy exclusive content!
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="SignIn.jpeg" class="image" alt="" />
        </div>
      </div>
    </div>
      
    

    <script src="app.js"></script>
  </body>
</html>