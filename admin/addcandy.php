<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $candidate_id = $_GET['id'];

    // Update the "nomenation" field in the "voterlist" table
    $stmt_add = $conn->prepare("UPDATE  voterlist SET nomenation=1 WHERE id = ?");

    if ($stmt_add === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt_add->bind_param("i", $candidate_id);

    if (!$stmt_add->execute()) {
        die("Error executing the statement: " . $stmt_add->error);
    }

    // Now, insert the nominated candidate's details into the "result" table
    $stmt_insert_result = $conn->prepare("INSERT INTO result (candidate_name, cregno, departmentname, shift, votespolled) SELECT  name, regno, departmentname, shift, 0 FROM voterlist WHERE id = ?");
    
    if ($stmt_insert_result === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt_insert_result->bind_param("i", $candidate_id);

    if (!$stmt_insert_result->execute()) {
        die("Error inserting result: " . $stmt_insert_result->error);
    }

    $_SESSION['candidate_add'] = true;
    header("Location: candidateadd.php?dept=" . $_GET['dept']);
    exit();
}
?>
