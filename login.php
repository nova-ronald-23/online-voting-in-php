<?php
session_start();
include 'admin/dbcon.php';

$regnoError = $passwordError = '';
$alreadyVotedMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regno = $_POST["regno"];
    $password = $_POST["password"];

    $thirdLetter = strtoupper($regno[2]);

    $stmt = null;

    if ($thirdLetter == 'U' || $thirdLetter == 'P') {
        $voterQuery = "SELECT id, name, password, position, userimage, votepolling FROM voterlist WHERE regno = ? AND password = ?";
        $stmt = $conn->prepare($voterQuery);
    } elseif ($thirdLetter == 'A' || $thirdLetter == 'F') {
        $userQuery = "SELECT id, uname, password, position, userimage FROM users WHERE regno = ? AND password = ?";
        $stmt = $conn->prepare($userQuery);
    } else {
        $stmt = false;
        echo "Invalid Third Letter<br>";
    }

    if ($stmt !== null && $stmt !== false) {
        $stmt->bind_param("ss", $regno, $password);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['regno'] = $regno;
            $_SESSION['uname'] = $thirdLetter == 'U' ? $row['name'] : $row['uname'];
            $_SESSION['password'] = $password;
            $_SESSION['position'] = $row['position'];
            $_SESSION['userphoto'] = $row['userimage'];

            if ($thirdLetter == 'U' && $row['votepolling'] == 1) {
                $alreadyVotedMessage = "You have already polled your vote.";
            } else {
                // Redirect based on position
                switch ($_SESSION['position']) {
                    case "admin":
                        header("Location: admin/adminindex.php");
                        break;
                    case "tech":
                        header("Location: techdesh.php");
                        break;
                    case "stud":
                        header("Location: stud.php");
                        break;
                    default:
                        header("Location: login.php?error=1");
                        break;
                }
                exit();
            }
        } else {
            $passwordError = "Invalid Reg no or Password";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <?php if (!empty($alreadyVotedMessage)) { ?>
            <p><?php echo $alreadyVotedMessage; ?></p>
        <?php } else { ?>
            <form method="post">
                <img src="image/logo.png" class="container text-center" style="padding-left: 90px; padding-bottom: 17px;">
                <h1 style="font-family: Verdana, Geneva, Tahoma, sans-serif">Voting Login</h1>
                <div class="input-box">
                    <input type="text" name="regno" placeholder="Reg no" required>
                    <i class='bx bxs-user'></i>
                    <?php echo $regnoError; ?>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                    <?php echo $passwordError; ?>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
