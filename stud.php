
<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user data from the session
$user_id = $_SESSION['user_id'];
$regno = $_SESSION['regno'];
$uname = $_SESSION['uname'];
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
   <main>
   <section>
    <img src="logo.png" style="width: 90px; height 90px; margin-left: 604px;">
        <div class="row">
            <p style="font-family: 'Times New Roman', Times, serif; font-size: 28px; color: #CD5700"> STUDENT PORTAL </p>
        </div>
        <div class="row">
            <!--Column-->
            <div class="column">
                <div class="card">
                    <div class="img-container">
                        <img src="def.png"/>
                    </div>
                    <h3>Pavalan</h3>
                    <p>22PCA131 II MCA</p>
                    <div class="icons">
                    <a href="confirmation.php">
                    <button type="button" class="btn btn-outline-dark">VOTE</button>
                    </div>
                    </a>
                </div>
            </div>
            <!--Column 2-->
            <div class="column">
                <div class="card">
                    <div class="img-container">
                        <img src="def.png" style="width: 30px height: 30px"/>
                    </div>
                    <h3>Nova Ronald</h3>
                    <p>22PCA134 II MCA</p>
                    <div class="icons">
                    <a href="confirmation.php">
                    <button type="button" class="btn btn-outline-dark">VOTE</button>
                    </a>
                    </div>
                </div>
            </div>
            <!--Column 3-->
            <div class="column">
                <div class="card">
                    <div class="img-container">
                        <img src="def.png"/>
                    </div>
                    <h3>Sarmesh</h3>
                    <p>22PCA161 II MCA</p>
                    <div class="icons">
                    <a href="confirmation.php">
                    <button type="button" class="btn btn-outline-dark">VOTE</button>
                    </a>
                    </div>
                </div>
            </div>
</main>
   <?php include 'footer.php'?>
   <?php include 'jslinks.php'?>
</body>
</html>