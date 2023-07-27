<?php
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["regno"];
    $password = $_POST["password"];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT id, position FROM users WHERE regno = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Login successful
        $stmt->bind_result($userId, $Position);
        $stmt->fetch();

        if ($Position == "admin") {
            header("Location: admin/adminindex.php");
        } elseif ($Position == "tech") {
            header("Location: techdesh.php");
        } else {
            header("Location: stud.php");
        }
        exit();
    } else {
        // Login failed
        echo "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>

<html>
<head>
    <title>SJC</title>
</head>
<body>
    <link rel="stylesheet" href="style.css">
    <div class="wrapper">
        <form action="login.php" method="Post">
            <img src="image/logo.png" class="container text-center" style="padding-left: 90px; padding-bottom: 17px;">
            <h1 style="font-family: Verdana, Geneva, Tahoma, sans-serif">Voting Login</h1>
            <div class="input-box">
                <input type="text" name="regno" placeholder="Reg no" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
