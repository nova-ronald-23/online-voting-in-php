<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SJC Online voting Admin</title>
  <meta content="../image/logo.png" name="description">
  <meta content="../image/logo.png" name="keywords">

  
<?php include 'links.php'?>


</head>

<body>
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

$countQuery = "SELECT COUNT(*) AS total FROM voterlist";
$countResult = mysqli_query($conn, $countQuery);

$totalVote = 0; 

if ($countResult && mysqli_num_rows($countResult) === 1) {
    $row = mysqli_fetch_assoc($countResult);
    $totalVote = $row['total'];
}

$votePolledQuery = "SELECT COUNT(*) AS votePolledCount FROM voterlist WHERE votepolling = 1";
$votePolledResult = mysqli_query($conn, $votePolledQuery);

$votePolledCount = 0; 

if ($votePolledResult && mysqli_num_rows($votePolledResult) === 1) {
    $row = mysqli_fetch_assoc($votePolledResult);
    $votePolledCount = $row['votePolledCount'];
}
$votetoPollQuery = "SELECT COUNT(*) AS votetoPollCount FROM voterlist WHERE votepolling = 0";
$votetoPollResult = mysqli_query($conn, $votetoPollQuery);

$votetoPollCount = 0; 

if ($votetoPollResult && mysqli_num_rows($votePolledResult) === 1) {
    $row = mysqli_fetch_assoc($votetoPollResult);
    $votetoPollCount = $row['votetoPollCount'];
}

?>
 <?php include 'header.php'?>
<?php include 'sidenav.php'?>
 
  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">vote polled</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-hand-index"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $votePolledCount; ?></h6>
                      
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Total Vote</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $totalVote; ?></h6>
                      
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Vote To Poll</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-hand-index"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $votetoPollCount; ?></h6>
                     
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Today</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>
                  <canvas id="myChart" width="400" height="400"></canvas>
                  <script>
    document.addEventListener("DOMContentLoaded", () => {
        const ctx = document.getElementById('myChart').getContext('2d');

        // Your data for the chart
        const data = {
            labels: ['Vote Polled', 'Total Vote', 'Vote To Poll'],
            datasets: [
                {
                    label: 'Count',
                    data: [
                        <?php echo $votePolledCount; ?>,
                        <?php echo $totalVote; ?>,
                        <?php echo $votetoPollCount; ?>,
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1,
                },
            ],
        };

        // Chart configuration
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };

        // Create and render the chart
        const myChart = new Chart(ctx, config);
    });
</script>

                  <!-- End Line Chart -->

                </div>

              </div>
            </div>
        </div>
        <!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

        

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->
 

  <?php include 'footer.php'?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
 <?php include 'jslinks.php'?>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>