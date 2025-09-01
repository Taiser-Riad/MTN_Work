<?php
//require "config.php";
// Get the form data
?>
<?php
// Include your database connection code here
//require 'db_connection.php'; // Assuming db_connection.php contains the connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];




    $sqll = "SELECT USERNAME, PASS, DEPARTMENT FROM USERS WHERE USERNAME =:username";

        $stmtt = oci_parse($conn, $sqll);
        oci_bind_by_name($stmtt, ':username', $username);
        $result = oci_execute($stmtt);
        
        // $row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS)
        // $results = [];

        if ($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)) {
          $results[] = $row; // Collect each row into the results array
           $db_userr    = $results[0]['USERNAME'];
           $db_password = $results[0]['PASS'];
           $db_dep = $results[0]['DEPARTMENT'];


      

 if($row['PASS'] == $password){
    setcookie("loggedInUser", $db_userr, time() + 3600, "/");
    
    header("location:HomePage.php?user=$db_userr");
    exit;

  }
}
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Login and registration page </title>
    <style>
        .password-strength-indicator {
    display: flex;
    align-items: center;
    margin-top: 10px;
  }
  .password-strength-indicator span {
    width: 20%;
    height: 5px;
    background-color: #ccc;
    margin-right: 5px;
  }
  .password-strength-indicator span.active {
    background-color: #4CAF50;
  }
    </style>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web\css\all.min.css">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
</head>

<body>
    <div class="container">

        <div class="cover">
            <div class="front">
                <img src="img1.jpg">
                <div class="text">
                    <span class="text-1">Success is liking yourself, liking what you do, and liking how you do
                        it.</span>
                    <span class="text-2">It always seems impossible until it's done.</span>
                </div>
            </div>
            <div class="back">
                <img class="backimg" src="img3.jpg">
                <div class="text">
                    <span class="text-1">Success is liking yourself, liking what you do, and liking how you do
                        it.</span>
                    <span class="text-2">It always seems impossible until it's done.</span>
                </div>
            </div>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" placeholder="Enter your username" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="password" name="password" placeholder="Enter your Password" required>
                        </div>
    
                        <!-- <div class="text"><a href="#"> Forgot password?</a></div> -->
                        <div class="button input-box">
                            <input type="submit" value="Submit">
                        </div>
                        <div class="text login-text">Don't have an account? <label for="flip"><a href="register.php">Signup now</a></label></div>
                    </div>
                </div>


            </div>
        </form>
    </div>


  
</body>

</html>