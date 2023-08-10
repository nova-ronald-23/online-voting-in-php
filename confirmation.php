<?php
include 'admin/dbcon.php';

$candidateName = $_GET['candidate_name'] ?? '';
$voterName = $_GET['voter_name'] ?? '';
$candidateDepartment = $_GET['candidate_department'] ?? '';
$candidateRegno = $_GET['candidate_regno'] ?? '';
$candidateShift = $_GET['candidate_shift'] ?? '';

$error = ''; // Initialize the error variable
$voterResult = null; // Initialize the voterResult variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voterPassword = $_POST['voter_password'];
    
    // Retrieve the voter's data from the database
    $voterQuery = "SELECT * FROM users WHERE uname = '$voterName' AND password = '$voterPassword'";
    
    // Debug: Output the voter query
    echo "Voter Query: $voterQuery<br>";
    
    $voterResult = mysqli_query($conn, $voterQuery);

    if ($voterResult) {
        if (mysqli_num_rows($voterResult) === 1) {
            // Debug: Output success message
            echo "Voter authentication successful!<br>";
            
            // Update votepoling value to 1
            $updateQuery = "UPDATE voterlist SET votepolling = 1 WHERE name = '$voterName'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Store voting details in a result table
                $insertResultQuery = "INSERT INTO voting_results (candidate_name, voter_name, regno, department, shift) VALUES ('$candidateName', '$voterName', '$regno', '$department', '$shift')";
                $insertResultResult = mysqli_query($conn, $insertResultQuery);

                if ($insertResultResult) {
                    // Perform other actions or redirections as needed
                    header("Location: popup.php");
                    exit();
                } else {
                    $error = "Insert into voting_results table failed: " . mysqli_error($conn);
                }
            } else {
                $error = "Update failed: " . mysqli_error($conn);
            }
        } else {
            // Debug: Output unsuccessful message
            echo "Voter authentication unsuccessful.<br>";
            
            // Invalid voter's credentials
            $error = "Invalid voter's credentials";
        }
    } else {
        // Debug: Output database error
        echo "Database Error: " . mysqli_error($conn) . "<br>";
        
        $error = "Voter query failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head> <meta charset="UTF-8">
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
        <!-- Debug: Output the received voter name -->
        <p>Received Voter Name: <?php echo $voterName; ?></p>
    </div>
</div>
</body>
</html>
