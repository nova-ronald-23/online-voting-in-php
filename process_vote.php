<?php
session_start();
include 'admin/dbcon.php';

// Check if the necessary session variables are set
if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user data from the session
$user_id = $_SESSION['user_id'];
$regno = $_SESSION['regno'];
$uname = $_SESSION['uname'];
$position = $_SESSION['position'];
$userPhoto = $_SESSION['userphoto'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voterPassword = $_POST['voter_password'];

    // Retrieve the voter's data from the database
    $voterQuery = "SELECT * FROM voterlist WHERE name = '$voterName' AND password = '$voterPassword'";
    $voterResult = mysqli_query($conn, $voterQuery);

    if ($voterResult && mysqli_num_rows($voterResult) === 1) {
        // Update votepoling value to 1
        $updateQuery = "UPDATE voterlist SET votepolling = 1 WHERE name = '$voterName'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            // Store voting details in a result table
            $insertResultQuery = "INSERT INTO voting_results (candidate_name, voter_name, regno, department, shift) VALUES ('$candidateName', '$voterName', '$regno', '$department', '$shift')";
            $insertResultResult = mysqli_query($conn, $insertResultQuery);

            if ($insertResultResult) {
                // Perform other actions or redirections as needed
                header("Location: popup.php");
                exit();
            } else {
                die("Insert into voting_results table failed: " . mysqli_error($conn));
            }
        } else {
            die("Update failed: " . mysqli_error($conn));
        }
    } else {
        // Invalid voter's credentials
        header("Location: confirmation.php?candidate_name=$candidateName&voter_name=$voterName&candidate_department=$candidateDepartment&candidate_regno=$candidateRegno&candidate_shift=$candidateShift&error=1");
        exit();
    }
}
?>
