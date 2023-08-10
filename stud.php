<?php
session_start();
include 'admin/dbcon.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['regno']) || !isset($_SESSION['uname']) || !isset($_SESSION['position']) || !isset($_SESSION['userphoto']) ) {
    header("Location: login.php");
    exit();
}

// Retrieve user data from the session
$user_id = $_SESSION['user_id'];
$regno = $_SESSION['regno'];
$uname = $_SESSION['uname'];
$position = $_SESSION['position'];
$userPhoto = $_SESSION['userphoto'];

$department = 'I B.Sc.computer science';

// Fetch candidates who match department and nomination from both tables using JOIN
$query = "SELECT v.name, v.userimage, v.regno FROM voterlist v
          JOIN users u 
          WHERE v.departmentname = '$department' AND v.nomenation = 1";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
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
        </div>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="column">
                <div class="card">
                    <div class="img-container">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['userimage']); ?>" alt="Candidate Image" width="100" height="100"/>
                    </div>
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['regno']; ?></p>
                    <div class="icons">
                        <a href="confirmation.php">
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
