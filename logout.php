<?php
// Expire the cookie by setting its timeframe to 1 hour ago
setcookie('loggedInUser', '', time() - 3600, "/");


// Redirect back to login page
header("Location: index.php");
exit();
?>