<?php
session_start();
include 'admin/dbcon.php';

// Check if the necessary session variables are set
if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['password']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user data from the session
$user_id = $_SESSION['user_id'];
$regno = $_SESSION['regno'];
$uname = $_SESSION['uname'];
$password = $_SESSION['password'];
$position = $_SESSION['position'];
$userPhoto = $_SESSION['userphoto'];

$department = '';
$shift = '';


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SJC</title>
    <?php include 'links.php'?>

    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0; /* Adjust the background color */
        }
        .buttons-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .btn {
            font-size: 24px;
            padding: 20px; 
            margin: 20px;
            width: 500px;
            border: none;
            cursor: pointer;   
             box-shadow: 0 0 2.2em rgba(25, 0, 58, 0.15);
            padding: 3.5em 1em;
            border-radius: 0.6em;
            color: #1f003b;
            cursor:pointer;
            transition: 0.3s;
            background-color: #ffffff;
        }
        .btn:hover {
            background: linear-gradient(#6045ea, #8567f7);
    color: #ffffff;
}
    </style>
</head>
<body>
    <?php include 'header.php'?>
    <main>
        <div class="buttons-container">
        <a href="studnominationform.php">  <button class="btn">Nomination</button></a>
           <a href="stud.php"> <button class="btn">Vote Now</button></a>
        </div>
    </main>
    
    <?php include 'jslinks.php'?>
</body>
</html>