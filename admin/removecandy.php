<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $candidate_id = $_GET['id'];
    
    // First, remove the nomination status from the 'voterlist' table
    $stmt_remove_nomination = $conn->prepare("UPDATE  voterlist SET nomenation=0 WHERE id = ?");
    
    if ($stmt_remove_nomination === false) {
        die("Error in preparing the statement to remove nomination: " . $conn->error);
    }
    
    $stmt_remove_nomination->bind_param("i", $candidate_id);
    
    if (!$stmt_remove_nomination->execute()) {
        die("Error executing the statement to remove nomination: " . $stmt_remove_nomination->error);
    }

    // Second, delete the corresponding row from the 'result' table
    $stmt_remove_result = $conn->prepare("DELETE FROM result WHERE candidate_name = (SELECT name FROM voterlist WHERE id = ?)");
    
    if ($stmt_remove_result === false) {
        die("Error in preparing the statement to remove from result: " . $conn->error);
    }
    
    $stmt_remove_result->bind_param("i", $candidate_id);
    
    if (!$stmt_remove_result->execute()) {
        die("Error executing the statement to remove from result: " . $stmt_remove_result->error);
    }
    
    $_SESSION['candidate_remove'] = true;
    
    header("Location: candidateadd.php?dept=" . $_GET['dept']);
    exit();
}
?>
