<?php
   include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>medissitaint</title>
</head>
<body>
<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <label>username</label><br>
        <input type="text" name="username"><br>
        <label>password</label><br>
        <input type="password" name="password"><br>
        <input type="submit" name="phone_number">
    </form>
</body>
</html>
<?php
  
  if($_SERVER["REQUEST_METHOD"]=="POST"){

      $username=filter_input(INPUT_POST,"username", FILTER_SANITIZE_SPECIAL_CHARS);
      $password=filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);

      if(empty($username)){
        echo "enter the username";
      }elseif (empty($password)) {
        echo "enter the password";
      }
      else{
        $sql="SELECT *FROM users where username='$username'";
       $result=mysqli_query($conn,$sql);
       $row=mysqli_fetch_assoc($result,);
       $pass= $row["password"];
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
       $hash=password_hash($password,PASSWORD_DEFAULT);
       if($encryption==$pass){
        echo "you are now logged in";
       }
       else{
        echo "the password is incorrect";
       }
      }

  }
    mysqli_close($conn);
?>
