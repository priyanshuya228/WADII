<?php
require('connection.inc.php');


if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['username']);
   $email = mysqli_real_escape_string($conn, $_POST['email_id']);
   $mob = mysqli_real_escape_string($conn, $_POST['contact_no']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);

   $select = " SELECT * FROM admin_users WHERE email_id = '$email' && username = '$name' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'User already exists !';

   }else{

      if($pass != $cpass){
         $error[] = 'Password not matched!';
      }else{
         $insert = "INSERT INTO admin_users(username, email_id, contact_no, password, role, status) VALUES('$name','$email', '$mob', '$pass',1, 1)";
         mysqli_query($conn, $insert);
         header("location:admin/login.php");
         exit;
      }
   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Seller Registration Form</title>
   <link rel="stylesheet" href="css/seller_login.css">
   <style>

      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

      *{
         font-family: 'Poppins', sans-serif;
         margin:0; padding:0;
         box-sizing: border-box;
         outline: none; border:none;
         text-decoration: none;
      }

      .form-container {
         display: flex;
         align-items: center;
         justify-content: center;
         height: 100vh;
         width: 100%;
      }

      .signup_form{
         background-color: white;
         padding: 30px 30px 30px 30px;
         border-radius: 10px;
         box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
         text-align: center;
      }

      .signup_form h3 {
         color: #c43b68;
         font-size: 24px;
         font-weight: bold;
         margin-bottom: 20px;
      }

      .error-msg {
         color: #ff0000;
         display: block;
         margin-bottom: 10px;
      }

      input[type="text"],
      input[type="email"],
      input[type="password"] {
         border: 2px solid #c43b68;
         color: black;
         padding: 10px;
         width: 100%;
         border-radius: 5px;
      }

      input[type="submit"] {
         background-color: #c43b68;
         border: none;
         color: white;
         padding: 10px 20px;
         margin-top: 10px;
         border-radius: 5px;
         cursor: pointer;
      }

      input[type="submit"]:hover {
         background-color: #ff4981;
      }
   </style>
</head>
<body>
   
<div class="form-container" style="background-image: url('media/background.jpg'); background-size: cover; padding:20px 30px;">

<form action="" method="post" class="signup_form">
      <h1 style="color:#c43b68; margin-bottom:20px;">Register as a Seller</h1>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="username" style="margin-top:10px;" required placeholder="Enter your name">
      <input type="email" name="email_id" style="margin-top:10px;"  required placeholder="Enter your email">
      <input type="text" name="contact_no" style="margin-top:10px;"  required placeholder="Enter your contact number">
      <input type="password" name="password" style="margin-top:10px;"  required placeholder="Enter your password">
      <input type="password" name="cpassword" style="margin-top:10px;"  required placeholder="Confirm your password">

      <input type="submit" name="submit" value="REGISTER" class="" style="background-color:#c43b68; margin-top:20px">
   </form>

</div>

</body>
</html>