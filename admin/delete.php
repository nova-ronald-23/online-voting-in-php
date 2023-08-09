<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $candidate_id = $_GET['id'];
    
    // Delete candidate from the database
    $stmt_delete = $conn->prepare("DELETE FROM voterlist WHERE id = ?");
    
    if ($stmt_delete === false) {
        die("Error in preparing the statement: " . $conn->error);
    }
    
    $stmt_delete->bind_param("i", $candidate_id);
    
    if (!$stmt_delete->execute()) {
        die("Error executing the statement: " . $stmt_delete->error);
    }
    
    // Set a session variable to indicate deletion
    $_SESSION['candidate_deleted'] = true;
    
    // Redirect back to the department list page
    header("Location: departmentnamelist.php?dept=" . $_GET['dept']);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Candidate</title>
    <?php include 'links.php'?>
</head>
<body>
    <?php include 'header.php'?>
    <!-- Display a confirmation message or UI here if needed -->
    <?php include 'footer.php'?>
    <?php include 'jslinks.php'?>
    <script>
        // Display an alert and then redirect
        alert("Candidate deleted successfully!");
        window.location.href = "departmentnamelist.php?dept=<?php echo $_GET['dept']; ?>";
    </script>
</body>
</html>
