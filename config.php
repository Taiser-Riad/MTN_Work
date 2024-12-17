
<?php
// Database connection details
$username = "C##Hadeel";
$password = "MTN";
$connection_string = "//localhost/XE"; // Change XE if your SID is different

// Connect to Oracle
$conn = oci_connect($username, $password, $connection_string);

if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}
else {
    //echo"connect Successfully";
}
?>