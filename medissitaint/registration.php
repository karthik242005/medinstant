<?php
   session_start();
   include("database.php");
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>medissitaint</title>
    <link rel="stylesheet" href="./css/registration.css">
</head>
<body><div class="container">
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <div class="input-group">
      <label for="name">User Name:</label>
      <input type="text" id="name" name="username" required>
    </div>
    <div class="input-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="input-group">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="input-group">
      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="phone" required>
    </div>
    <div class="input-group">
      <label>Gender:</label>
      <input type="radio" name="sex" value="male" required> Male
      <input type="radio" name="sex" value="female"> Female
    </div>
    <div>
      <input type="submit" class="btn">
    </div>
        <p>already registered ?</p>
        <a href="login.php">login</a>
    </form>
  </div>
</body>
</html>


<?php
  
  if($_SERVER["REQUEST_METHOD"]=="POST"){

      $username=filter_input(INPUT_POST,"username", FILTER_SANITIZE_SPECIAL_CHARS);
      $password=filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);
      $email=filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL);
      $phone=filter_input(INPUT_POST,"phone",FILTER_SANITIZE_NUMBER_INT);
      $sex=$_POST["sex"];

      if(empty($username)){
        echo "enter the username";
      }elseif (empty($password)) {
        echo "enter the password";
      }elseif (empty($email)) {
        echo "enter email";
      }elseif (empty($phone)) {
        echo "enter phone number";
      }elseif (empty($sex)) {
        echo "select your sex";
      }
      else{
        $ciphering = "AES-128-CTR";
 
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
 
// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
 
// Store the encryption key
$encryption_key = "medi";
 
// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($password, $ciphering,
            $encryption_key, $options, $encryption_iv);
        $sql="INSERT INTO users (username,password,email,phone,sex)
              VALUES('$username','$encryption','$email','$phone','$sex')";
       try{
        mysqli_query($conn,$sql);
       header("Location:./doctor1.html");
       }
       catch(mysqli_sql_exception){
        
       }
       
      }

  }
?>