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

$stmt_shift1 = $conn->prepare("SELECT departmentname FROM department WHERE shift = 'I'");
if ($stmt_shift1 === false) {
    die("Error in shiftI.php query: " . $conn->error);
}

if (!$stmt_shift1->execute()) {
    die("Error executing shiftI.php query: " . $stmt_shift1->error);
}

$result_shift1 = $stmt_shift1->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departmentName = $_POST['departmentName'];
    $shift = 'I'; // Hardcoding shift to 'I'
    $dcode = $_POST['dcode'];

    // Check if the dcode field has exactly three characters
    if (strlen($dcode) === 3) {
        $stmt = $conn->prepare("INSERT INTO department (departmentname, shift, dcode) VALUES (?, ?, ?)");

        if ($stmt === false) {
            die("Error preparing SQL statement: " . $conn->error);
        }

        $stmt->bind_param("sss", $departmentName, $shift, $dcode);

        if ($stmt->execute()) {
            // Department added successfully
            header("Location: shiftI.php");
            exit();
        } else {
            // Error occurred while adding department
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Display an error message for an invalid dcode
        echo "Department Code must be exactly three characters.";
    }
}

$conn->close();
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Shift I</title>
        <?php include 'links.php'?>
    </head>
    <body>
        <?php include 'header.php'?>
        <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link " href="adminindex.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Department</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse show " data-bs-parent="#sidebar-nav">
        <li>
            <a href="shiftI.php"  class="active">
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
            <div class="pagetitle">
                <h1>Shift I</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="adminindex.php">Dashboard</a></li>
                        <li class="breadcrumb-item">Department</li>
                        <li class="breadcrumb-item active">Shift I</li>
                    </ol>
                </nav>
            </div>
            <h1>Shift I Departments</h1>
            <section class="section">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Department List</h5>
                                <ul>
                                 <?php while ($row_shift1 = $result_shift1->fetch_assoc()) { ?>
                                   <li><a href="departmentnamelist.php?dept=<?php echo $row_shift1['departmentname']; ?>"><?php echo $row_shift1['departmentname']; ?></a></li>
                                     <?php } ?>
                                        </ul>

                                
                            </div>
                        </div>
                    </div>
                </div>
            
            
                
           
<div class="col-8">
              <div class="card recent-sales overflow-auto">

           

                <div class="card-body">
                  <h5 class="card-title">Add Department to Shift I </h5>
                     <form method="post"> 
                <div class="mb-3">
                    <label for="departmentName" class="form-label">Department Name</label>
                    <input type="text" class="form-control" id="departmentName" name="departmentName" required>
                </div>
                <div class="mb-3">
                    <label for="shift" class="form-label">Shift</label>
                    <input type="text" class="form-control" id="Shift" name="Shift"value="I" required>
                 
               
                </div>
                <div class="mb-3">
    <label for="dcode" class="form-label">Department Code </label>
    <input type="text" class="form-control" id="dcode" name="dcode" maxlength="3" required>
</div>
                <button type="submit" class="btn btn-primary">Add Department</button>
            </form>
                 

                </div>

              </div>
            </div>
</section>
        </main>
        <?php include 'footer.php'?>
        <?php include 'jslinks.php'?>
    </body>
    </html>