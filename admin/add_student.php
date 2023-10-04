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
$shift = isset($_POST['shift']) ? $_POST['shift'] : ''; // Retrieve 'shift' from the form

$image = file_get_contents($_FILES['image']['tmp_name']); // Open the image file in binary mode
$position = "stud";

// Generate JavaScript to output values to the console
//echo "<script>";
//echo "console.log('Name: $name');";
//echo "console.log('Register Number: $regno');";
//echo "console.log('Department: $department');";
//echo "console.log('Image Size: " . strlen($image) . " bytes');";
//echo "console.log('Position: $position');";
//echo "console.log('Password: $password');";
//echo "console.log('Shift: $shift');";
//echo "</script>";
// Prepare the SQL statement to insert data into the voterlist table
$stmt = $conn->prepare("INSERT INTO voterlist (name, regno, departmentname, userimage, position, password, shift) VALUES (?, ?, ?, ?, ?, ?, ?)");
//echo "POST parameters: " . json_encode($_POST);

if ($stmt === false) {
    die("Error in preparing the statement: " . $conn->error);
}

$stmt->bind_param("sssssss", $name, $regno, $department, $image, $position, $password, $shift);

if (!$stmt->execute()) {
    die("Error executing the statement: " . $stmt->error);
}

$stmt->close();
$conn->close();

// Redirect to the previous page after adding the student
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>
