<?php 
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select_user = $connect->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
       $_SESSION['user_id'] = $row['id'];
       //header('location:home.php');
       header('location:home.php');
      $message[] = 'Login Successful';

      // check if the Remember Me checkbox is selected
      if (isset($_POST['remember_me']) && $_POST['remember_me'] == 1) {
        // set cookie with user info - mail and username
        setcookie("remembered_user", $email, time() + 86400, "/"); // 1 days expiration time
      }
      // Redirect to home page
      header('location:home.php');

    }else{
       $message[] = 'Incorrect Username or Password';
    }
 
 }

 if(isset($_COOKIE["remembered_user"]) && !isset($_SESSION['user_id'])){
    // Retrieve mail from cookie
    $remembered_email = $_COOKIE["remembered_user"];

        // Look up user by email
        $select_user= $connect->prepare("SELECT * FROM `users` WHERE email = ?");
         $select_user->execute([$remembered_email]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);

         if ($select_user->rowCount() > 0) {
            // Set the user's session
            $_SESSION['user_id'] = $row['id'];
            // Redirect to the home page
            header('location: home.php');
        }
 
    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <!--- Font Awesome Plug-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--- CSS Link-->
    <link rel="stylesheet" href="css/style.css">

<?php 
  include 'components/user_header.php';?>

  <!---- User Login Section Starts -->

<section class="form-container">

    <form action="" method="POST">
        <h3>Log in to your Account</h3>

        <input type="email" required maxlength="50" name="email" placeholder="Enter Your E-Mail" class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">

        <input type="password" required maxlength="20" name="pass" placeholder="Enter Your Password" class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">

        <input type="submit" value="login now" class="btn" name="submit">
       
        <input type="checkbox" id="remember_me" name="remember_me" value="1" class="remember_me">
        <label for="remember_me" class="remember_me-label"> Remember Me</label>

        <p>Don't have an account?</p>
       <a href="user_register.php" class="option-btn">Register Now</a>
        
        
    </form>

</section> 
  <!---- User Login Section Ends -->


 








<?php include 'components/footer.php'; ?>

   <!----- JS Link -->
   <script src="js/script.js"></script> 


</body>
</html>