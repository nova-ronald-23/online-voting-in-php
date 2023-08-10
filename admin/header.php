
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="adminindex.php" class="logo d-flex align-items-center">
    <img src="logo.png" alt="">
    <span class="d-none d-lg-block">SJC Admin</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div>
<nav class="header-nav ms-auto">
 
<li class="nav">

<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
<img src="data:image/jpeg;base64,<?php echo base64_encode($row_candidate['userimage']); ?>" alt="Profile" class="rounded-circle">
  <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $regno; ?></span>
</a><!-- End Profile Iamge Icon -->

<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
  <li class="dropdown-header">
    <h6><?php echo $uname; ?></h6>
    <span><?php echo $position; ?></span>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="../logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->