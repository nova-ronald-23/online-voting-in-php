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

$department = "";

if (isset($_GET['dept'])) {
    $department = $_GET['dept'];

    $stmt_candidates = $conn->prepare("SELECT id,name,departmentname,regno,userimage,votepolling  FROM voterlist WHERE departmentname = ?");
    
    if ($stmt_candidates === false) {
        die("Error in preparing the statement: " . $conn->error);
    }
    
    $stmt_candidates->bind_param("s", $department);
    
    if (!$stmt_candidates->execute()) {
        die("Error executing the statement: " . $stmt_candidates->error);
    }
    
    $result_candidates = $stmt_candidates->get_result();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $department; ?> Students List</title>
    <?php include 'links.php'?>
</head>
<body>
        <?php include 'header.php'?>
        <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link " href="adminindex.php">
        <i class="bi bi-grid"></i>
        <span>Deshboard</span>
        </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Department</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse show " data-bs-parent="#sidebar-nav">
        <li>
            <a href="shiftI.php"  >
            <i class="bi bi-circle"></i><span>Shitf I</span>
            </a>
        </li>
        <li>
            <a href="shiftII.php">
            <i class="bi bi-circle"></i><span>Shitf II</span>
            </a>
        </li>
        
        </ul>
    </li><!-- End Components Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Candidate</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="nomenilistI.php">
            <i class="bi bi-circle"></i><span>Shitf I</span>
            </a>
        </li>
        <li>
            <a href="nomenilistII.php">
            <i class="bi bi-circle"></i><span>Shitf II</span>
            </a>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-medal"></i><span>Result</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="resultI.php">
              <i class="bi bi-circle"></i><span>shiftI</span>
            </a>
          </li>
          <li>
            <a href="resultII.php">
              <i class="bi bi-circle"></i><span>shiftII</span>
            </a>
          </li>
        </ul>
      </li>
    </aside>
    <main id="main" class="main">
    <h1><?php echo $department; ?> list</h1>
    <?php if ($result_candidates->num_rows > 0) { ?>
        <form method="post" action="reset_votes.php">
                <input type="hidden" name="departmentname" value="<?php echo $department; ?>">
                <button type="submit" name="reset_votes" class="btn btn-warning">Reset Votes</button>
            </form>
        <table class="table">
                <thead>
                    <tr>
                        <th>Student Photo</th>
                        <th>Student Name</th>
                        <th>Register Number</th>
                        <th>vote polled</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_candidate = $result_candidates->fetch_assoc()) { ?>
                        <tr>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row_candidate['userimage']); ?>" alt="Candidate Image" width="100" height="100"></td>
                            <td><?php echo $row_candidate['name']; ?></td>
                            <td><?php echo $row_candidate['regno']; ?></td>
                            <td><?php echo $row_candidate['votepolling']; ?></td>
                            <td><a href="delete.php?id=<?php echo $row_candidate['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="col-8">
              <div class="card recent-sales overflow-auto">

           

                <div class="card-body">
                <h2>Upload Student List</h2>
    <form enctype="multipart/form-data" action="upload.php" method="post">
        <input type="file" name="file" accept=".csv, .xlsx">
        <input type="submit" value="Upload">
    </form>
        
    <?php } else { ?>
        <p>No candidates found for <?php echo $department; ?></p>
    <?php } ?>
    </main>
    <?php include 'footer.php'?>
    <?php include 'jslinks.php'?>
</body>
</html>
