<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:admin");
    }

    if(isset($_POST['login'])){

        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $login = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' and password='$password'");
        $cek = mysqli_num_rows($login);

        $loginKaryawan = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE username='$username' and password='$password'");
        $cekKaryawan = mysqli_num_rows($loginKaryawan);

        if($cek > 0) {
            $admin_data = mysqli_fetch_assoc($login);
            $_SESSION['id_admin'] = $admin_data['id'];
            $_SESSION['nama_admin'] = $admin_data['nama'];
            $_SESSION['username_admin'] = $username;
            $_SESSION['status'] = "login";
            header('location:admin');

        } else if ($cekKaryawan > 0) {
            $admin_data = mysqli_fetch_assoc($loginKaryawan);
            $_SESSION['id_karyawan'] = $admin_data['id'];
            $_SESSION['nama_karyawan'] = $admin_data['nama'];
            $_SESSION['username_karyawan'] = $username;
            $_SESSION['status'] = "login";
            header('location:karyawan');

        } else {
            echo "<script>
            alert('Login Gagal, Periksa Username dan Password Anda!');
            header('location:login.php');
                 </script>";
        }
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
  <title>Login</title>

  <!-- Custom fonts -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles -->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <style>
    body {
      background-image: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    }
    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 400px;
    }
    .login-card h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #4e73df;
      font-weight: 600;
    }
    .login-card .form-control {
      border-radius: 50px;
      padding: 12px 20px;
      font-size: 16px;
    }
    .login-card .btn-primary {
      border-radius: 50px;
      font-size: 16px;
      padding: 12px 30px;
      background-color: #4e73df;
      border-color: #4e73df;
    }
    .login-card .btn-primary:hover {
      background-color: #2e59d9;
      border-color: #2e59d9;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <h1>Welcome Back!</h1>
      <form class="user" method="POST">
        <div class="form-group">
          <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Enter Username...">
        </div>
        <div class="form-group">
          <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
        <hr>
      </form>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>