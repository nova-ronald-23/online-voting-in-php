
<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, show the protected content
?>

<html lang="en">



</body >

<?php include 'header.php';?>
<div class="bg">

</div>
</body>

<?php include 'footer.php';?>

</html>

<?php
} else {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}
?>

