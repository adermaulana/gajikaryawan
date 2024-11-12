<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){
    session_unset();
    session_destroy();
    header("location:../");
}

// Get all employees
$karyawan = "SELECT COUNT(*) as id FROM karyawan";
$resultkaryawan = $koneksi->query($karyawan);
$rowkaryawan = $resultkaryawan->fetch_assoc();
$jumlah_karyawan = $rowkaryawan["id"];

// Get total expenses
$pengeluaran = "SELECT SUM(total_gaji) as total_pengeluaran FROM penggajian";
$resultpengeluaran = $koneksi->query($pengeluaran);
$rowpengeluaran = $resultpengeluaran->fetch_assoc();
$total_pengeluaran = $rowpengeluaran["total_pengeluaran"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Dashboard Admin</title>

  <!-- Custom fonts -->
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">

  <!-- Custom styles -->
  <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
  <style>
  /* Modern, clean, and engaging design */
  body, html {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(120deg, #f5f7fa, #c3cfe2);
    height: 100%;
    color: #4a4a4a;
  }

  .sidebar {
    background: linear-gradient(45deg, #6a11cb, #2575fc);
    color: #ffffff;
  }

  .sidebar .nav-item .nav-link {
    color: #ffffff;
    font-weight: 500;
    transition: all 0.3s ease-in-out;
  }

  .sidebar .nav-item.active .nav-link,
  .sidebar .nav-item .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
  }

  .navbar {
    background: #ffffff;
    border-bottom: 2px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .navbar-brand, .navbar-nav .nav-link {
    color: #4a4a4a;
    font-weight: 600;
  }

  .card {
    border: none;
    border-radius: 16px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }

  .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
  }

  .card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #4a4a4a;
  }

  .card-icon {
    font-size: 2.5rem;
    color: rgba(50, 115, 220, 0.8);
  }

  .badge {
    padding: 8px 14px;
    border-radius: 12px;
  }

  .badge-danger {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
    color: #fff;
  }

  .badge-success {
    background: linear-gradient(135deg, #42e695, #3bb2b8);
    color: #fff;
  }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">Features</div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Data Karyawan</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="karyawan.php">Karyawan</a>
            <a class="collapse-item" href="tambahkaryawan.php">Tambah Data</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Penggajian</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="gaji.php">Gaji</a>
            <a class="collapse-item" href="tambahgaji.php">Tambah Data</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporanGaji" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-file-alt"></i>
          <span>Laporan Gaji</span>
        </a>
        <div id="laporanGaji" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="laporan.php">Laporan</a>
          </div>
        </div>
      </li>
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['nama_admin'] ?></span>
                <img class="img-profile rounded-circle" src="../assets/img/undraw_profile.svg">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>

        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="card-title text-primary text-uppercase mb-1">Total Employees</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_karyawan ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users card-icon"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="card-title text-success text-uppercase mb-1">Total Expenses</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= "Rp" . number_format($total_pengeluaran, 2, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign card-icon"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

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
        <a class="btn btn-primary" href="hapusSession.php">Logout</a>
      </div>
    </div>
  </div>
</div>

      <!-- Bootstrap core JavaScript-->
      <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/chart-area-demo.js"></script>
    <script src="../assets/js/demo/chart-pie-demo.js"></script>
</body>
</html>