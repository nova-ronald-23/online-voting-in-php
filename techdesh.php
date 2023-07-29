
<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['username']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user data from the session
$user_id = $_SESSION['user_id'];
$regno = $_SESSION['regno'];
$username = $_SESSION['username'];
$position = $_SESSION['position'];
$userPhoto = $_SESSION['userphoto'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SJC</title>
    <?php include 'links.php'?>

   
</head>
<body>
   <?php include 'header.php'?>
   <?php include 'footer.php'?>
   <?php include 'jslinks.php'?>
</body>
</html>