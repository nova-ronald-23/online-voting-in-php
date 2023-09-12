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
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="nomenilistI.php" >
            <i class="bi bi-circle" ></i><span>Shitf I</span>
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
        <ul id="icons-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="resultI.php" >
              <i class="bi bi-circle"></i><span>shiftI</span>
            </a>
          </li>
          <li>
            <a href="resultII.php" class="active" >
              <i class="bi bi-circle"></i><span>shiftII</span>
            </a>
          </li>
        </ul>
      </li>
    </aside>
    <main id="main" class="main">
            <div class="pagetitle">
                <h1>Shift II Winner List</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="adminindex.php">Dashboard</a></li>
                        <li class="breadcrumb-item">result</li>
                        <li class="breadcrumb-item active">Shift II</li>
                    </ol>
                </nav>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Photo</th>
                        <th>Student Name</th>
                        <th>Register Number</th>
                        <th>votes polled</th>
                    </tr>
                </thead>
                <tbody>
                    
                        <tr>
                        <td></td>
                            <td><?php  ?></td>
                            <td><?php  ?></td>
                            <td><?php ?></td>
                            <td><?php ?></td>
                            
                        </tr>
              
                </tbody>
            </table>

        </main>
        <?php include 'footer.php'?>
        <?php include 'jslinks.php'?>
    </body>
    </html>