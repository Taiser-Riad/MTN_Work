<?php 
include "config.php";
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
$user = $_POST['username'];
$pass = $_POST['password'];
$sql= "SELECT * FROM clients WHERE User_Name= '$user' AND Pass_Word= '$pass'";
$result = mysqli_query($conn,$sql);
if ($result==1)
{
    header("location:Add Site.php");
}
else
{
    echo "Login Failed!!";
}

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Login and registration page </title>
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <div class="text"><a href="#"> Forgot password?</a></div>
                        <div class="button input-box">
                            <input type="submit" value="Submit">
                        </div>
                        <div class="text login-text">Don't have an account? <label for="flip">Signup now</label></div>
                    </div>
                </div>


            </div>
        </form>
    </div>


</body>

</html>