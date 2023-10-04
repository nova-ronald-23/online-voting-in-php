<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $candidate_id = $_GET['id'];

    // Update the "nomination" field in the "voterlist" table
    $stmt_update_voterlist = $conn->prepare("UPDATE voterlist SET nomenation = 1 WHERE id = ?");

    if ($stmt_update_voterlist === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt_update_voterlist->bind_param("i", $candidate_id);

    if (!$stmt_update_voterlist->execute()) {
        die("Error executing the statement: " . $stmt_update_voterlist->error);
    }

    // Insert the nominated candidate's details into the "result" table
    $stmt_insert_result = $conn->prepare("INSERT INTO result (candidate_name, cregno, departmentname, shift, votespolled) SELECT name, regno, departmentname, shift, 0 FROM voterlist WHERE id = ?");
    
    if ($stmt_insert_result === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt_insert_result->bind_param("i", $candidate_id);

    if (!$stmt_insert_result->execute()) {
        die("Error inserting result: " . $stmt_insert_result->error);
    }
    
    // Insert the nominated candidate's details into the "candidates" table
    $stmt_insert_candidate = $conn->prepare("INSERT INTO candidates (name, regno, departmentname, shift, userimage) SELECT name, regno, departmentname, shift, userimage FROM voterlist WHERE id = ?");

    if ($stmt_insert_candidate === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt_insert_candidate->bind_param("i", $candidate_id);

    if (!$stmt_insert_candidate->execute()) {
        die("Error inserting candidate: " . $stmt_insert_candidate->error);
    }

    $_SESSION['candidate_add'] = true;
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
}
?>
