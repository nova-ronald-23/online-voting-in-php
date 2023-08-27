<?php
session_start();
include 'admin/dbcon.php'; 
// Variables to hold error messages
$regnoError = $passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regno = ($_POST["regno"]);
    $password = $_POST["password"];
    
    $thirdLetter = strtoupper($regno[2]);
    
    $stmt = null;
    

    if ($thirdLetter == 'U') {
        $voterQuery = "SELECT id, name, password, position,userimage FROM voterlist WHERE regno = ? AND password = ?";
        $stmt = $conn->prepare($voterQuery);
        echo "Using Voter Query<br>";
    } elseif ($thirdLetter == 'A' || $thirdLetter == 'F') {
        $userQuery = "SELECT id, uname, password, position, userimage FROM users WHERE regno = ? AND password = ?";
        $stmt = $conn->prepare($userQuery);
        echo "Using User Query<br>";
    } else {
        $stmt = false;
        echo "Invalid Third Letter<br>";
    }

    if ($stmt !== null && $stmt !== false) {
        // Bind the parameters here
        $stmt->bind_param("ss", $regno, $password);
        
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            // Login successful
            if ($thirdLetter == 'U') {
                $stmt->bind_result($userId, $uname, $password, $position, $userimage);
                echo "Using Voter Query<br>";
            } elseif ($thirdLetter == 'A' || $thirdLetter == 'F') {
                $stmt->bind_result($userId, $uname, $password, $position, $userimage);
                echo "Using User Query<br>";
            }
            $stmt->fetch();
    
            $_SESSION['user_id'] = $userId;
            $_SESSION['regno'] = $regno;
            $_SESSION['uname'] = $uname;
            $_SESSION['password'] = $password;
            $_SESSION['position'] = $position;
            $_SESSION['userphoto'] = $userimage;
            
            if ($position == "admin") {
                header("Location: admin/adminindex.php");
                exit();
            } elseif ($position == "tech") {
                header("Location: techdesh.php");
                exit();
            } elseif ($position == "stud") {
                header("Location: stud.php");
                exit();
            } else {
                header("Location: login.php?error=1");
                exit();
            }
        } else {
            // Check for invalid regno and password
            $countStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE regno = ?");
            if ($countStmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            $countStmt->bind_param("s", $regno);
            $countStmt->execute();
            $countStmt->bind_result($count);
            $countStmt->fetch();
    
            if ($count == 0) {
                $regnoError = "Invalid Reg no";
            } else {
                $passwordError = "Invalid Password";
            }
    
            $countStmt->close();
        }
    
        $stmt->close();
    }
    
    $conn->close();
}

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
