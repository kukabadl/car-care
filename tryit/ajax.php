<!DOCTYPE HTML>
       <html lang="en">
       <head>
               <meta charset="utf-8">
               <title>Login</title>
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
               <link rel="stylesheet" type="text/css" href="form-style.css">
       </head>

 <body>
       <?php
               // define variables and set to empty values
               $username = $passwd = "";

               if ($_SERVER["REQUEST_METHOD"] == "POST") {
                       $username = test_input($_POST["username"]);
                       $passwd = test_input($_POST["passwd"]);
                       checkPassword($username, $passwd);
               }

               function test_input($data) {
                 $data = trim($data);
                 $data = stripslashes($data);
                 $data = htmlspecialchars($data);
                 return $data;
               }

               function checkPassword($usr, $psd){
                 if (file_exists("config.php")){
                    $execute = `config.php`;
                    // Create connection
                    echo $dbname;
                    echo $username;
                    echo $password;
                    echo $servername;
                    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT password FROM users WHERE username='"."$usr"."';";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            $hashed = $row["password"];
                        }
                    } else {
                        echo '<script>
                        $(document).ready(function(){
                          $("span:nth-of-type(1)").show();
                        });
                        </script>';
                    }
                    if (password_verify($psd, $hashed)){
                        echo "Correct password!";
                      }

                    else {
                            echo "Incorrect password";
                            echo '<script>
                            $(document).ready(function(){
                              $("span:nth-of-type(2)").show();
                            });
                            </script>';
                    }
                            mysqli_close($conn);
                    }
                    else {
                      echo "Invalid configuration file.";
                    }
                 }
                 ?>
       <script>
       $(document).ready(function(){
         $("span").hide();
       });
       </script>

 <div class="login-box" style="width: 360px; height: 400px;">
 <img src="avatar.png" class="avatar" alt="">
 <h1>Login Here</h1>
  <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
  <p>Username <span>(Non-existent username!)</span></p>
   <input type="text" name="username" placeholder="Your Username or Email" required>
   <p>Password <span>(Wrong password!!)</span></p>
   <input type="password" name="passwd" placeholder="Enter Password" required>
   <input type="submit" name="submit" value="Login">
   <a href="register.html">Don't have an account yet?</a><br>
   <a href="forgotten_passwd.html">Forgotten password?</a><br>
   <span class="login-text">
   </span>
   </form>
  </div>
 </body>
</html>
