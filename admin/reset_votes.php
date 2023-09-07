<?php
// Include the database connection code
include 'dbcon.php';

// Check if the "Reset Votes" button is clicked and departmentname is provided
if (isset($_POST['reset_votes']) && isset($_POST['departmentname'])) {
    $departmentname = $_POST['departmentname'];

    // Write SQL code to reset the votes for all candidates in the specified department
    $sql = "UPDATE voterlist SET votepolling = 0 WHERE departmentname = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    // Bind the department name as a parameter
    $stmt->bind_param("s", $departmentname);

    if (!$stmt->execute()) {
        die("Error executing the statement: " . $stmt->error);
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Redirect back to the candidates.php page
    header("Location: departmentnamelist.php?dept=" . urlencode($departmentname));
    exit();
} else {
    // Redirect to an error page or display an error message
    echo "Invalid request.";
}
?>
