<?php 
include "config.php";
?>
<?php
$username = $password = $dep = "";
$username_err = $password_err = $dep_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
        if (strlen($username) < 6) {
            $username_err = "Username must be at least 6 characters.";
            //echo $username_err;
            echo '<script>alert("'.$username_err.'")</script>';
            
        }
    }
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $password_err = "Password must contain at least one uppercase letter and one number.";
            //echo ""$password_err;
            echo '<script>alert("'.$password_err.'")</script>';  
        }
    }
    // Check if passcode is empty
    if (empty(trim($_POST["dep"]))) {
        $dep_err = "Please enter your dep.";
    } else {
        $dep = trim($_POST["dep"]);
    }
    // Check if username already exists
    $sql = "SELECT * FROM USERS WHERE USERNAME = :username";
    $result = oci_parse($conn,$sql);
    oci_bind_by_name($result ,':username',$username);
    if (oci_execute($result)) {
        $results = [];
        if ($row = oci_fetch_array($result)) {
            // Collect each row into the results array
            //$db_password = $row['PASSWORD'];
      
                // Only add the first result
                $results[] = $row;
                //echo "User Already Exist!!!";
                echo '<script>alert("User Already Exist!!!")</script>'; 
            
        }
        // if (count($results) === 1) { 
           
     
        // }
        else{
            if (empty($username_err) && empty($password_err) && empty($dep_err)) {
                $sql = "INSERT INTO USERS (USERNAME,PASS,DEPARTMENT) 
                        VALUES (:username,:pass ,:dep)";
                         $result = oci_parse($conn,$sql);
                          oci_bind_by_name($result, ':username' , $username);
                          oci_bind_by_name($result, ':pass', $password);
                          oci_bind_by_name($result, ':dep', $dep);
                          if (oci_execute($result)) {
                            //echo"User Created Successfully";
                            echo '<script>alert("User Created Successfully")</script>'; 
                header("location: index.php");
            }
        }

    }
 

 
}

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title> registration page </title>
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
            <div class="title">Register New User</div>
            <div class="input-boxes">
                <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Enter your username" value="<?php //echo $username; ?>">
                <!-- <span><?php //echo $username_err; ?></span> -->
                </div>
                <div class="input-box">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" placeholder="Enter your Password">
                    <span><?php //echo $password_err; ?></span>
                </div>
                <div class ="input-box">
                <i class="fas fa-users"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = "color:gray";>Department:</span></br>
                </div>
                    
                    <select class ="input-box" name="dep" required style = "border:2px solid goldenrod; border-radius: 7px;">
                    <option value="Power">Power</option>
                        <option value="Radio">Radio</option>
                        <option value="Quality">Quality</option>
                        <option value="Tx">TX</option>
                        <option value="Rollout">Rollout</option>
                    </select> 
                    


                <div class="button input-box">
                        <input type="submit" name="submit" value="Submit">
            
        </div>

      
       </div>
        </form>
        </div>
        

    </body>
</html>