<?php
include 'admin/dbcon.php';

if (isset($_GET['regno'])) {
    $regno = $_GET['regno'];
    
    $stmt_image = $conn->prepare("SELECT userimage FROM voterlist WHERE regno = ?");
    
    if ($stmt_image === false) {
        die("Error in preparing the statement: " . $conn->error);
    }
    
    $stmt_image->bind_param("s", $regno);
    
    if (!$stmt_image->execute()) {
        die("Error executing the statement: " . $stmt_image->error);
    }
    
    $stmt_image->bind_result($userimage);
    
    if ($stmt_image->fetch()) {
        header("Content-Type: image/jpeg"); 
        echo $userimage;
        exit();
    }
}
?>
