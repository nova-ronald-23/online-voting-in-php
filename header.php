
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="../" class="logo d-flex align-items-center">
    <img src="image/logo.png" alt="">
    <span class="d-none d-lg-block">SJC Online Voting </span>
  </a>
</div>
<nav class="header-nav ms-auto">
 

   
    <li class="nav">

    <a class="nav-link nav-profile d-flex align-items-center " href="#" data-bs-toggle="dropdown">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($row_candidate['userimage']); ?>"  class="img-profile rounded-circle" >
    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $regno; ?></span>
</a>

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6><?php echo $regno; ?></h6>
          <span><?php echo $position; ?></span>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul>
    </li>

  </ul>
</nav>

</header>