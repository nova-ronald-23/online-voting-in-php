<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$regno = $_SESSION['regno'];
$uname = $_SESSION['uname'];
$position = $_SESSION['position'];
$userPhoto = $_SESSION['userphoto'];

$department = $_POST['departmentname'];  // Get department from the form
$name = $_POST['name'];
$regno = $_POST['regno'];
$password = $_POST['password'];
$shift = $_POST['shift'];

// Output the "shift" value for debugging purposes
echo "Shift: " . $shift;
$image = file_get_contents($_FILES['image']['tmp_name']); // Open the image file in binary mode
$position= "stud";

// Prepare the SQL statement to insert data into the voterlist table
$stmt = $conn->prepare("INSERT INTO voterlist (name, regno, departmentname, userimage,position,password,shift) VALUES (?,?,?,?,?,?,?)");

if ($stmt === false) {
    die("Error in preparing the statement: " . $conn->error);
}

$stmt->bind_param("sssssss", $name, $regno, $department, $image,$position,$password,$shift);

if (!$stmt->execute()) {
    die("Error executing the statement: " . $stmt->error);
}

$stmt->close();
$conn->close();
    

// Redirect to the previous page after adding the student
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>
