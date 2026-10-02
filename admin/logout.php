<?php

session_start();

// Destroy the admin session
session_unset();
session_destroy();

// Redirect to login page
header("Location: login.php");
exit;

?>