<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    create_session();

    if (!check_if_valid_session_exists()) {
        header("Location: login.html");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">Welcome Admin!</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <img class="d-none d-md-inline-block mr-0 mr-md-3 my-2 my-md-0 ml-pourcentage-70" style="height: 2em;" src="img/name.png">


    <ul class="navbar-nav">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>
<!--Might be useful later for user settings-->
<!--    &lt;!&ndash; Navbar &ndash;&gt;-->
<!--    <ul class="navbar-nav ml-auto ml-md-0">-->
<!--      <li class="nav-item dropdown no-arrow mx-1">-->
<!--        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--          <i class="fas fa-bell fa-fw"></i>-->
<!--          <span class="badge badge-danger">9+</span>-->
<!--        </a>-->
<!--        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">-->
<!--          <a class="dropdown-item" href="#">Action</a>-->
<!--          <a class="dropdown-item" href="#">Another action</a>-->
<!--          <div class="dropdown-divider"></div>-->
<!--          <a class="dropdown-item" href="#">Something else here</a>-->
<!--        </div>-->
<!--      </li>-->
<!--      <li class="nav-item dropdown no-arrow mx-1">-->
<!--        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--          <i class="fas fa-envelope fa-fw"></i>-->
<!--          <span class="badge badge-danger">7</span>-->
<!--        </a>-->
<!--        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">-->
<!--          <a class="dropdown-item" href="#">Action</a>-->
<!--          <a class="dropdown-item" href="#">Another action</a>-->
<!--          <div class="dropdown-divider"></div>-->
<!--          <a class="dropdown-item" href="#">Something else here</a>-->
<!--        </div>-->
<!--      </li>-->
<!--      <li class="nav-item dropdown no-arrow">-->
<!--        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--          <i class="fas fa-user-circle fa-fw"></i>-->
<!--        </a>-->
<!--        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">-->
<!--          <a class="dropdown-item" href="#">Settings</a>-->
<!--          <a class="dropdown-item" href="#">Activity Log</a>-->
<!--          <div class="dropdown-divider"></div>-->
<!--          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>-->
<!--        </div>-->
<!--      </li>-->
<!--    </ul>-->

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Stats</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Alerts</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-arrow-alt-circle-down"></i>
                </div>
                <div class="mr-5">0 new alerts</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View report</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>

        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Area Chart Example</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Annelida 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="controller/LogoutManager.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

</body>

</html>