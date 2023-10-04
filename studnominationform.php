<?php
session_start();
include 'admin/dbcon.php';

// Check if the necessary session variables are set
if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['password']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user data from the session
$user_id = $_SESSION['user_id'];
$regno = $_SESSION['regno'];
$uname = $_SESSION['uname'];
$password = $_SESSION['password'];
$position = $_SESSION['position'];
$userPhoto = $_SESSION['userphoto'];

$department = '';
$shift = '';


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SJC</title>
    <?php include 'links.php'?>

    <style>
        body {
            min-height: 100vh;
            margin-top: 100px;
            margin-left: 450px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'?>

    <main>
        <div class="col-7">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title"><center>Nomination Form</center></h5>
                    <form method="post" action="add_student.php" enctype="multipart/form-data">
                        <input type="hidden" name="departmentname" value="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Student Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo isset($uname) ? $uname : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="regno" class="form-label">Register Number</label>
                            <input type="text" class="form-control" name="regno" value="<?php echo isset($regno) ? $regno : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Student Image" class="form-label">Student Image</label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="departmentName" class="form-label">Department Name</label>
                            <input type="text" class="form-control" name="departmentName" value="<?php echo isset($department) ? $department : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="shift" class="form-label">Shift</label>
                            <input type="text" class="form-control" name="shift" value="<?php echo isset($shift) ? $shift : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acknowledge" required>
                            <label class="form-check-label" for="acknowledge">I acknowledge that this nomination is valid and authorized.</label>
                        </div>
                        <button type="submit" name="add_student" class="btn btn-primary">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'?>
    <?php include 'jslinks.php'?>
</body>
</html>
