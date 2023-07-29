<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sjcvote";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables to hold error messages
$regnoError = $passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regno = $_POST["regno"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, regno, uname, position, userphoto FROM users WHERE regno = ? AND password = ?");
    $stmt->bind_param("ss", $regno, $password);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        // Login successful
        $stmt->bind_result($userId, $regno, $uname, $Position, $userPhoto);
        $stmt->fetch();

        $_SESSION['user_id'] = $userId;
        $_SESSION['regno'] = $regno;
        $_SESSION['uname'] = $uname; // Fixed: Added the 'uname' to the session
        $_SESSION['position'] = $Position;
        $_SESSION['userphoto'] = $userPhoto;

        // Redirect the user based on their position
        if ($Position == "admin") {
            header("Location: admin/adminindex.php");
            exit();
        } elseif ($Position == "tech") {
            header("Location: techdesh.php");
            exit();
        } elseif ($Position == "stud") {
            header("Location: stud.php");
            exit();
        } else {
            // Invalid position (optional: redirect to login page with an error message)
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // Check for invalid regno and password
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE regno = ?");
        $stmt->bind_param("s", $regno);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count == 0) {
            $regnoError = "Invalid Reg no";
        } else {
            $passwordError = "Invalid Password";
        }
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <form method="post">
            <img src="image/logo.png" class="container text-center" style="padding-left: 90px; padding-bottom: 17px;">
            <h1 style="font-family: Verdana, Geneva, Tahoma, sans-serif">Voting Login</h1>
            <div class="input-box">
                <input type="text" name="regno" placeholder="Reg no" required>
                <i class='bx bxs-user'></i>
                <?php echo $regnoError; ?>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
                <?php echo $passwordError; ?>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
