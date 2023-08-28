<?php
session_start();
include 'admin/dbcon.php';

$candidateName = $_GET['candidate_name'] ?? '';
$candidateDepartment = $_GET['candidate_department'] ?? '';
$candidateRegno = $_GET['candidate_regno'] ?? '';
$candidateShift = $_GET['candidate_shift'] ?? '';
$voterName = $_SESSION['uname'] ?? '';

$error = ''; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voterPassword = $_POST['voter_password'];
    

    $voterQuery = "SELECT * FROM voterlist WHERE name = '$voterName' AND password = '$voterPassword'";

    echo "Voter Query: $voterQuery<br>";

    $voterResult = mysqli_query($conn, $voterQuery);

    if ($voterResult) {
        echo "Number of rows returned: " . mysqli_num_rows($voterResult) . "<br>";

        if (mysqli_num_rows($voterResult) === 1) {
            $updateQuery = "UPDATE voterlist SET votepolling = 1 WHERE name = '$voterName'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Store voting details in a result table
                $insertResultQuery = "UPDATE voting_results SET votespolled = votespolled+1 WHERE candidate_name = '$candidateName'";
                $insertResultResult = mysqli_query($conn, $insertResultQuery);

                if ($insertResultResult) {
                    header("Location: popup.php");
                    exit();
                } else {
                    $error = "Insert into voting_results table failed: " . mysqli_error($conn);
                }
            } else {
                $error = "Update failed: " . mysqli_error($conn);
            }
        } else {
            echo "Voter authentication unsuccessful.<br>";
            $error = "Invalid voter's credentials";
        }
    } else {
        echo "Database Error: " . mysqli_error($conn) . "<br>";
        $error = "Voter query failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SJC</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="confirmation.css">
</head>
<body>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">
            <img src="poll.png" id="icon" style="width: 200px; height: 225px; padding-top:20px; padding-bottom: 20px;" alt="User Icon" />
        </div>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" id="login" class="fadeIn second" name="candidate_name" placeholder="Candidate Name" value="<?php echo htmlspecialchars($candidateName); ?>" readonly>
            <input type="text" id="login" class="fadeIn second" name="candidate_regno" placeholder="Candidate Regno" value="<?php echo htmlspecialchars($candidateRegno); ?>" readonly>
            <input type="text" id="name" class="fadeIn third" name="voter_name" placeholder="Voter Name" value="<?php echo htmlspecialchars($voterName); ?>" readonly>
            <input type="password" id="password" class="fadeIn third" name="voter_password" placeholder="Voter password">
            <br><br>
            <button type="submit" class="btn btn-primary"> Confirm </button>

            <?php if (!empty($error)) { ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php } ?>
        </form>
    </div>
</div>
</body>
</html>
