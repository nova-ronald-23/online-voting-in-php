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


    $stmt_shift1 = $conn->prepare("SELECT departmentname FROM department WHERE shift = 'I'" );
    if ($stmt_shift1 === false) {
        die("Error in shiftI.php query: " . $conn->error);
    }

    if (!$stmt_shift1->execute()) {
        die("Error executing shiftI.php query: " . $stmt_shift1->error);
    }

    $result_shift1 = $stmt_shift1->get_result();
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
        <ul id="components-nav" class="nav-content collapse  " data-bs-parent="#sidebar-nav">
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
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Candidate</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
        <li>
            <a href="nomenilistI.php" class="active">
            <i class="bi bi-circle" ></i><span>Shitf I</span>
            </a>
        </li>
        <li>
            <a href="nomenilistII.php">
            <i class="bi bi-circle"></i><span>Shitf II</span>
            </a>
        </ul>
    </li>
    </aside>
    <main id="main" class="main">
            <div class="pagetitle">
                <h1>Shift I</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="adminindex.php">Dashboard</a></li>
                        <li class="breadcrumb-item">Candidate</li>
                        <li class="breadcrumb-item active">Shift I</li>
                    </ol>
                </nav>
            </div>
            <h1>Shift I Departments</h1>
            <section class="section">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Department List</h5>
                                <ul>
                                 <?php while ($row_shift1 = $result_shift1->fetch_assoc()) { ?>
                                   <li><a href="candidateadd.php?dept=<?php echo $row_shift1['departmentname']; ?>"><?php echo $row_shift1['departmentname']; ?></a></li>
                                     <?php } ?>
                                        </ul>

                                
                            </div>
                        </div>
                    </div>
                </div>
            
            <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">Add Department to Shift I</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add Department</button>
            </div>
        </div>
    </div>
</div></section>
        </main>
        <?php include 'footer.php'?>
        <?php include 'jslinks.php'?>
    </body>
    </html>