<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $candidate_id = $_GET['id'];
    
    $stmt_add = $conn->prepare("UPDATE  voterlist SET nomenation=1 WHERE id = ?");
    
    if ($stmt_add === false) {
        die("Error in preparing the statement: " . $conn->error);
    }
    
    $stmt_add->bind_param("i", $candidate_id);
    
    if (!$stmt_add->execute()) {
        die("Error executing the statement: " . $stmt_add->error);
    }
    $_SESSION['candidate_add'] = true;
    
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>add Candidate</title>
    <?php include 'links.php'?>
</head>
<body>
    <?php include 'header.php'?>
    <?php include 'footer.php'?>
    <?php include 'jslinks.php'?>
    <script>
        alert("Candidate added successfully!");
        ; 
    </script>
</body>
</html>
