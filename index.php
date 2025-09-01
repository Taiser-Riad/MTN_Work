<?php 
include "config.php";
session_start();
?>
<?php
$username = $password = "";
$username_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty($username_err) && empty($password_err)) 
    {
    $sql= "SELECT * FROM USERS WHERE USERNAME = :userr";
    $result = oci_parse($conn,$sql);
    oci_bind_by_name($result ,':userr' ,$username);
    //oci_bind_by_name($result ,':pas' ,$password);
    oci_execute($result);
    $results = [];
if ($row = oci_fetch_array($result)) {
    $results[] = $row; // Collect each row into the results array
    //$db_password = $row['PASSWORD'];
     $db_userr = $results[0]['USERNAME'];
     $db_dep      = $results[0]['DEPARTMENT'];
     $db_password = $results[0]['PASS'];

     if ($row['PASS'] == $password) {
        //cookie that expires in 1 hour 
        setcookie("loggedInUser", $db_userr, time() + 3600, "/");

        header("location:Mainpage.php?user=$db_userr");
    }
}

if (count($results) === 1) {



if($db_userr == trim($_POST["username"]) && trim($_POST["password"]) == $db_password ){

    
        //$results[0]['USERNAME'] = $db_userr;
//echo $db_userr;
    header("location:Mainpage.php?user=$db_userr");
}
    elseif ($_POST["username"] == $db_userr && $_POST["password"] != $db_password) {
        //echo"Wrong Password";
        echo '<script>alert("Wrong Password")</script>'; 
    }



// elseif($_POST["username"] != $db_userr){
//     echo "User Not Found!!";
// }
}
else {

    //echo "No user found.";
    echo '<script>alert("User Not Found!!")</script>';  
 
}
}

//oci_execute($result);



}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Login page </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web\css\all.min.css">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
</head>

<body>
<div class="system-header">
        <div class="system-logo">
            <div class="logo-circle">
                <i class="fas fa-chart-network"></i>
            </div>
        </div>
        <h1>Network Database System</h1>
        <p>Advanced Database platform for network analytics and performance insights</p>
    </div>
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
                            <i class="fas fa-key"></i>
                            <input type="password" name="password" placeholder="Enter your Password" required>
                        </div>
                        <!-- <div class='text'> Forgot password?</div> -->
                        <div class="button input-box">
                            <input type="submit" name="submit" value="Submit">
                        </div>
                        <div class="text login-text">Don't have an account? <label for="flip"><a
                                    href="register.php">Signup now</a></label></div>
                    </div>
                </div>


            </div>
        </form>
    </div>


</body>

</html>