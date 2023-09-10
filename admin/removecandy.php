<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $candidate_id = $_GET['id'];
    
    $stmt_remove = $conn->prepare("UPDATE  voterlist SET nomenation=0 WHERE id = ?");
    
    if ($stmt_remove === false) {
        die("Error in preparing the statement: " . $conn->error);
    }
    
    $stmt_remove->bind_param("i", $candidate_id);
    
    if (!$stmt_remove->execute()) {
        die("Error executing the statement: " . $stmt_remove->error);
    }
    $_SESSION['candidate_remove'] = true;
    
    header("Location: candidateadd.php?dept=" . $_GET['dept']);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>remove Candidate</title>
    <?php include 'links.php'?>
</head>
<body>
    <?php include 'header.php'?>
    <?php include 'footer.php'?>
    <?php include 'jslinks.php'?>
    <script>
        alert("Candidate remove successfully!");
        window.location.href = "candidateadd.php?dept=<?php echo $_GET['dept']; ?>";
    </script>
</body>
</html>
