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

    
    $stmt->close();

    $sql ="UPDATE result set votespolled =0 WHERE departmentname =?";
    $up = $conn->prepare($sql);

    if ($up === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

   
    $up->bind_param("s", $departmentname);

    if (!$up->execute()) {
        die("Error executing the statement: " . $up->error);
    }

    
    $up->close();

    $conn->close();


    header("Location: departmentnamelist.php?dept=" . urlencode($departmentname));
    exit();
} else {
  
    echo "Invalid request.";
}
?>
