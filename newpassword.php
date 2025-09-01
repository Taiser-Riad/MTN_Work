<?php 
include "config.php";
?>
<?php

// if(isset($_GET['ID']))
// {
//     $username =$_GET['ID'];
//     $sqll= "SELECT * FROM USERS WHERE USERNAME= :username";
//     $result = oci_parse($conn,$sqll);
//     oci_bind_by_name($result, ':username' ,$username);
//     oci_execute($result);
//     $row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);
//     $userrname = $row['USERNAME'];
//     $dep = $row['DEPARTMENT'];
//     //echo $userrname;
    

// //$sitecode = $row['SITE_CODE'];
// }



 // Start the session

// // Check if the session variable is set
// if (isset($_SESSION['username'])) {
//     $username = $_SESSION['username']; // Get the username from the session
//     echo "<h1>Reset Password for: " . htmlspecialchars($username) . "</h1>";
    
//     // Here you can add your form or logic to reset the password
// } else {
//     echo "No username provided.";
// }


$password  = $newpassword = "";
$password_err = $newpassword_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter new password.";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty(trim($_POST["newpassword"]))) {
        $newpassword_err = "Please confirm your password.";
    } else {
        $newpassword = trim($_POST["newpassword"]);
    }
    if (empty($password_err) && empty($newpassword_err)) 
    {
        if ($password == $newpassword)





    $sql= "UPDATE USERS SET PASS WHERE USERNAME = :userr";
    $result = oci_parse($conn,$sql);
    oci_bind_by_name($result ,':userr' ,$userrname);
    //oci_bind_by_name($result ,':pas' ,$password);
    oci_execute($result);
    $results = [];
while ($row = oci_fetch_array($result)) {
    $results[] = $row; // Collect each row into the results array
    //$db_password = $row['PASSWORD'];
}

if (count($results) === 1) {
    // Exactly one row was returned
    //echo "User found: " . htmlspecialchars($results[1]['USERNAME']);
   $db_password = $results[0]['PASS'];
   $db_userr    = $results[0]['USERNAME'];
   $db_dep      = $results[0]['DEPARTMENT'];
    if($password == $db_password){
    header("location:Homepage.php?");
    }
    else {
        echo"Wrong Password";
        //echo $results[0]['USERNAME'];
    }
}
else {
    $usernamee = 'windows_user';
    $passwordd = password_hash('user_password', PASSWORD_DEFAULT);
    echo "No user found.";
    echo $usernamee;
    echo $passwordd;
    //$windowsUsername = getenv('USERNAME');
    //echo $windowsUsername;
}
}

//oci_execute($result);



}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title> Password page </title>
        <link rel="stylesheet" href= "style.css">
        <link rel="stylesheet" href= "fontawesome-free-6.5.2-web\css\all.min.css">
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
    </head>
    <body>
        <div class="container">
            
            <div class="cover">
            <div class="front">
                <img src="img1.jpg">
                <div class="text">
                <span class="text-1">Success is liking yourself, liking what you do, and liking how you do it.</span>
                <span class="text-2">It always seems impossible until it's done.</span>
                </div>
            </div>
            <div class="back">
                <img class="backimg" src="img3.jpg">
                <div class="text">
                <span class="text-1">Success is liking yourself, liking what you do, and liking how you do it.</span>
                <span class="text-2">It always seems impossible until it's done.</span>
                </div>
            </div>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-content">
            <div class="login-form">
            <div class="title">Change Password</div>
            <div class="input-boxes">
            <i class="fas fa-user"></i>
                <input type="text" name="username"  value =<?php echo "$username;" ?>>
                </div>
                <div class="input-box">
                <i class="fas fa-key"></i>
                <input type="text" name="password" placeholder="Enter New Password" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-key"></i>
                    <input type="newpassword" name="password" placeholder="Confirm Password" required>
                </div>
                <!-- <div class="text"><a href="#"> Forgot password?</a></div> -->
                <div class="button input-box">
                        <input type="submit" name="submit" value="Submit">
                </div>
                <!-- <div class="text login-text">Don't have an account? <label for="flip"><a href= "register.php">Signup now</a></label></div> -->
            </div>
        </div>

      
       </div>
        </form>
        </div>
        

    </body>
</html>


