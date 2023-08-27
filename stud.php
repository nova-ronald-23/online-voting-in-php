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

// Retrieve user's department and shift
$userDataQuery = "SELECT departmentname, shift FROM voterlist WHERE regno = ?";
$userDataStmt = $conn->prepare($userDataQuery);
$userDataStmt->bind_param("s", $regno);

if (!$userDataStmt->execute()) {
    die("User data retrieval failed: " . $userDataStmt->error);
}

$userDataResult = $userDataStmt->get_result();
if ($userDataResult) {
    $userData = $userDataResult->fetch_assoc();
    $department = $userData['departmentname'];
    $shift = $userData['shift'];
} else {
    die("User data retrieval failed");
}

// Fetch candidates who match department, shift, and nomination from the voterlist table
$query = "SELECT name, userimage, regno FROM voterlist WHERE departmentname = ? AND shift = ? AND nomenation = 1";
$resultStmt = $conn->prepare($query);
$resultStmt->bind_param("ss", $department, $shift);

if (!$resultStmt->execute()) {
    die("Query failed: " . $resultStmt->error);
}

$result = $resultStmt->get_result();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SJC</title>
    <?php include 'links.php'?>
    <link rel="stylesheet" href="pop.css">
</head>
<body>
   <?php include 'header.php'?>
   <main>
    <section>
        <div class="row">
        <p style="font-family: 'Times New Roman', Times, serif; font-size: 28px; color: #CD5700"> STUDENT CANDIDATES </p>
     
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="column">
                <div class="card">
                    <div class="img-container">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['userimage']); ?>" alt="Candidate Image" width="170" height="120"/>
                    </div>
                    <h3><?php echo $row['name']; ?></h3>
                    <h3><?php echo $department; ?></h3>
                    <p><?php echo $row['regno']; ?></p>
                    <div class="icons">
                    <a href="confirmation.php?candidate_name=<?php echo urlencode($row['name']); ?>&voter_name=<?php echo urlencode($uname); ?>&candidate_department=<?php echo urlencode($department); ?>&candidate_regno=<?php echo urlencode($row['regno']); ?>&candidate_shift=<?php echo urlencode($shift); ?>">
                            <button type="button" class="btn btn-outline-dark">VOTE</button>
                        </a>

                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        
    </section>
</main>
   <?php include 'footer.php'?>
   <?php include 'jslinks.php'?>
</body>
</html>