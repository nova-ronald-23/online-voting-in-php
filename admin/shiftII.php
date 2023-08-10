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

    $stmt_shift2 = $conn->prepare("SELECT departmentname FROM department WHERE shift = 'II'");
    if ($stmt_shift2 === false) {
        die("Error in shiftII.php query: " . $conn->error);
    }
    
    if (!$stmt_shift2->execute()) {
        die("Error executing shiftII.php query: " . $stmt_shift2->error);
    }
    
    $result_shift2 = $stmt_shift2->get_result();?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Shift II</title>
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
            <a href="shiftI.php"  >
            <i class="bi bi-circle"></i><span>Shitf I</span>
            </a>
        </li>
        <li>
            <a href="shiftII.php" class="active">
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
    </aside><main id="main" class="main">
        <!-- Page content -->
        <div class="pagetitle">
            <h1>Shift II</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminindex.php">Dashboard</a></li>
                    <li class="breadcrumb-item">Department</li>
                    <li class="breadcrumb-item active">Shift II</li>
                </ol>
            </nav>
        </div>
        <h1>Shift II Departments</h1>
        <section class="section">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Default</h5>
                            <ul>
                                <?php while ($row_shift2 = $result_shift2->fetch_assoc()) { ?>
                                    <li><a href="departmentnamelist.php?dept=<?php echo $row_shift2['departmentname']; ?>"><?php echo $row_shift2['departmentname']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'?>
    <?php include 'jslinks.php'?>
</body>
</html>