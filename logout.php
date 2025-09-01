<?php
if (isset($_COOKIE['loggedInUser'])) {
    setcookie("loggedInUser", "", time() - 3600, "/");
}

header("Location: index.php");
exit;
?>
