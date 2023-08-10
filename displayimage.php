<?php
include 'dbcon.php';

if (isset($_GET['id'])) {
    $candidate_id = $_GET['id'];
    
    $stmt_image = $conn->prepare("SELECT userimage FROM voterlist WHERE id = ?");
    
    if ($stmt_image === false) {
        die("Error in preparing the statement: " . $conn->error);
    }
    
    $stmt_image->bind_param("i", $candidate_id);
    
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
