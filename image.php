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

if (isset($_GET['id'])) {
    $imageId = $_GET['id'];
    $stmt = $conn->prepare("SELECT userphoto FROM users WHERE id = ?");
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $stmt->bind_result($userphoto);
    $stmt->fetch();
    $stmt->close();

    header("Content-type: image/jpeg"); 
    echo $userphtoto;
}

$conn->close();
?>
