<?php
require "config.php";
// Get the form data
?>
<?php
// Include your database connection code here
//require 'db_connection.php'; // Assuming db_connection.php contains the connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate Windows credentials (this part is simplified)
    if (validateWindowsCredentials($username, $password)) {
        // Prepare an SQL statement to insert the username and password
        $sql = "INSERT INTO USERS (USERNAME, PASS) VALUES (:username, :password)";
        
        // Prepare the statement
        $stmt = oci_parse($conn, $sql);
        
        // Bind parameters
        oci_bind_by_name($stmt, ':username', $username);
        oci_bind_by_name($stmt, ':password', $password); // Note: Storing passwords in plain text is not secure!

        // Execute the statement
        $result = oci_execute($stmt);
        
        if ($result) {
            echo "Login successful and credentials saved.";
        } else {
            $e = oci_error($stmt);
            echo 'Error: ' . htmlentities($e['message']);
        }
    } else {
        echo "Invalid Windows username or password.";
    }
}

// Function to validate Windows credentials (placeholder)
function validateWindowsCredentials($username, $password) {
    // Implement actual Windows authentication logic here
    // For example, using LDAP or other methods
    return true; // Placeholder: Always returns true for demonstration
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
</head>
<body >
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="username">Windows Username:</label>
    <input type="text" name="username" id="username" required>
    
    <label for="password">Windows Password:</label>
    <input type="password" name="password" id="password" required>
    
    <input type="submit" value="Login">
</form>
</body>
</html>