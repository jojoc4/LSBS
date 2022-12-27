<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>BSRVS</title>
  <meta name="description" content="Benchmark scheduling and results visualization system" />
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap" />
  <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css" />
</head>

<body id="page-top">
  <div id="wrapper">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
      <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
          <div class="sidebar-brand-icon rotate-n-15"></div>
          <div class="sidebar-brand-text mx-3"><span>BSRVS</span></div>
        </a>
        <hr class="sidebar-divider my-0" />
        <ul class="navbar-nav text-light" id="accordionSidebar">
          <li class="nav-item">
            <a class="nav-link <?php if (!isset($_GET['p'])) echo "active"; ?>" href="/"><i class="fas fa-tachometer-alt"></i><span>Home</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (isset($_GET['p']) && $_GET['p'] == 's') echo "active"; ?>" href="/?p=s"><i class="fas fa-server"></i><span>Systems</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (isset($_GET['p']) && $_GET['p'] == 'p') echo "active"; ?>" href="/?p=p"><i class="fas fa-calendar"></i><span>Schedule</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (isset($_GET['p']) && $_GET['p'] == 'r') echo "active"; ?>" href="/?p=r"><i class="fas fa-chart-bar"></i><span>Results</span></a>
          </li>
        </ul>
        <div class="text-center d-none d-md-inline">
          <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
        </div>
      </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
      <div id="content">
        <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
          <div class="container-fluid">
            <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button">
              <i class="fas fa-bars"></i>
            </button>
          </div>
        </nav>
        <div class="container-fluid">
          <?php
          //router
          if (!isset($_GET['p'])) {
            include 'home.php';
          } else {
            switch ($_GET['p']) {
              case 's':
                include 'systems.php';
                break;
              case 'p':
                include 'schedule.php';
                break;
              case 'r':
                include 'results.php';
                break;
              case 't':
                include 'target.php';
                break;
            }
          }
          ?>
        </div>
      </div>
      <footer class="bg-white sticky-footer">
        <div class="container my-auto">
          <div class="text-center my-auto copyright">
            <span>Copyright © BSRVS 2022</span>
          </div>
        </div>
      </footer>
    </div>
    <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
  </div>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/bs-init.js"></script>
  <script src="assets/js/theme.js"></script>
</body>

</html>