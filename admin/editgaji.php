<?php
include '../koneksi.php';

session_start();

if ($_SESSION['status'] != 'login') {
    session_unset();
    session_destroy();
    header('location:../');
    exit();
}

// Check if an ID is provided for editing
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>
        alert('ID Gaji tidak valid!');
        document.location='gaji.php';
    </script>";
    exit();
}

$id_gaji = $_GET['id'];

// Fetch existing salary record
$query = mysqli_query($koneksi, "SELECT * FROM penggajian WHERE id = '$id_gaji'");
$data_gaji = mysqli_fetch_assoc($query);

if (!$data_gaji) {
    echo "<script>
        alert('Data gaji tidak ditemukan!');
        document.location='gaji.php';
    </script>";
    exit();
}

if (isset($_POST['simpan'])) {
    // Extract the month and year from the input
    $bulan_gaji = $_POST['bulan_gaji'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $id_karyawan = $_POST['id_karyawan'];

    // Check for existing entry for the same month, year, and employee, excluding current record
    $cek_duplikat = mysqli_query(
        $koneksi,
        "SELECT * FROM penggajian 
        WHERE id_karyawan = '$id_karyawan' 
        AND bulan_gaji = '$bulan_gaji' 
        AND YEAR(tanggal_pembayaran) = YEAR('$tanggal_pembayaran')
        AND id != '$id_gaji'"
    );

    if (mysqli_num_rows($cek_duplikat) > 0) {
        // Duplicate entry found
        echo "<script>
            alert('Data gaji untuk $bulan_gaji tahun " .
            date('Y', strtotime($tanggal_pembayaran)) .
            " sudah ada!');
            document.location='editgaji.php?id=$id_gaji';
        </script>";
    } else {
        // No duplicate found, proceed with update
        $update = mysqli_query(
            $koneksi,
            "UPDATE penggajian SET
            id_karyawan = '$_POST[id_karyawan]', 
            jabatan = '$_POST[jabatan]', 
            bulan_gaji = '$_POST[bulan_gaji]', 
            gaji_pokok = '$_POST[gaji_pokok]', 
            status = '$_POST[status]', 
            tanggal_pembayaran = '$_POST[tanggal_pembayaran]', 
            jam_lembur = '$_POST[jam_lembur]', 
            hadir = '$_POST[hadir]', 
            alpa = '$_POST[alpa]', 
            sakit = '$_POST[sakit]', 
            bayaran_lembur = '$_POST[bayaran_lembur]', 
            total_gaji = '$_POST[total_gaji]',
            tunjangan = '$_POST[tunjangan]'
            WHERE id = '$id_gaji'"
        );

        if ($update) {
            echo "<script>
                alert('Update data sukses!');
                document.location='gaji.php';
            </script>";
        } else {
            echo "<script>
                alert('Update data Gagal!');
                document.location='editgaji.php?id=$id_gaji';
            </script>";
        }
    }
}

// Query untuk mengambil nilai pajak
$query_pajak = mysqli_query($koneksi, 'SELECT * FROM pajak LIMIT 1');
$data_pajak = mysqli_fetch_assoc($query_pajak);
$nilai_pajak = isset($data_pajak['pajak']) ? $data_pajak['pajak'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">


    <style>
        /* Modern, clean, and engaging design */
        body,
        html {
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

        .navbar-brand,
        .navbar-nav .nav-link {
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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Fitur
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
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

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Penggajian</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="gaji.php">Gaji</a>
                        <a class="collapse-item" href="tambahgaji.php">Tambah Data</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#jabatan"
                    aria-expanded="true" aria-controls="jabatan">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Jabatan</span>
                </a>
                <div id="jabatan" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="jabatan.php">Jabatan</a>
                        <a class="collapse-item" href="tambahjabatan.php">Tambah Data</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporanGaji"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Laporan Gaji</span>
                </a>
                <div id="laporanGaji" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="laporan.php">Laporan</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengajuan"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Pengajuan Naik Gaji</span>
                </a>
                <div id="pengajuan" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="pengajuan.php">Lihat Ajuan Gaji</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['nama_admin'] ?></span>
                                <img class="img-profile rounded-circle" src="../assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Gaji</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="gaji.php" class="btn btn-success btn-icon-split">
                                <span class="text">Kembali</span>
                            </a>
                        </div>
                        <div class="card-body">
<form method="post" class="user" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran"
                                        class="form-control form-control-user col-6" 
                                        value="<?= $data_gaji['tanggal_pembayaran'] ?>">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="id_karyawan" value="<?= $data_gaji['id_karyawan'] ?>">
                                    <select  id="id_karyawan" class="form-control col-6" style="appearance: none; -webkit-appearance: none; -moz-appearance: none;" required disabled>
                                        <option value="" disabled>Pilih Karyawan</option>
                                        <?php
                                        $tampil = mysqli_query($koneksi, "SELECT karyawan.*, jabatan.jabatan, jabatan.gaji AS gaji_pokok, jabatan.tunjangan 
                                                                      FROM karyawan 
                                                                      JOIN jabatan ON karyawan.id_jabatan = jabatan.id");
                                        while($data = mysqli_fetch_array($tampil)):
                                        ?>
                                        <option value="<?= $data['id'] ?>" 
                                            data-gaji="<?= $data['gaji_pokok'] ?>"
                                            data-jabatan="<?= $data['jabatan'] ?>" 
                                            data-tunjangan="<?= $data['tunjangan'] ?>"
                                            <?= $data['id'] == $data_gaji['id_karyawan'] ? 'selected' : '' ?>>
                                            <?= $data['nama'] ?>
                                        </option>
                                        <?php
                                        endwhile; 
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="jabatan" class="form-control form-control-user col-6"
                                        placeholder="Jabatan" readonly 
                                        value="<?= $data_gaji['jabatan'] ?>">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="gaji_pokok"
                                        class="form-control form-control-user col-6" placeholder="Gaji Pokok"
                                        readonly value="<?= $data_gaji['gaji_pokok'] ?>">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="tunjangan"
                                        class="form-control form-control-user col-6" placeholder="Tunjangan"
                                        readonly value="<?= $data_gaji['tunjangan'] ?>">
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user col-6"
                                        placeholder="Potongan"
                                        value="<?= $nilai_pajak ?> Persen (<?= $nilai_pajak ?>%)" readonly>
                                </div>
                                <div class="form-group">
                                    <select name="bulan_gaji" class="form-control col-6" required>
                                        <option value="" disabled>Pilih Bulan Gaji</option>
                                        <?php
                                        $bulan_list = [
                                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                        ];
                                        foreach($bulan_list as $bulan):
                                        ?>
                                        <option value="<?= $bulan ?>" 
                                            <?= $bulan == $data_gaji['bulan_gaji'] ? 'selected' : '' ?>>
                                            <?= $bulan ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="hadir">Hari Hadir</label>
                                    <input type="number" name="hadir" id="hadir"
                                        class="form-control form-control-user col-6" 
                                        value="<?= $data_gaji['hadir'] ?>"
                                        placeholder="Jumlah Hari Hadir" min="0" max="31" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="alpa">Potongan Hari Alpa (per hari): Rp 50.000</label>
                                    <input type="number" name="alpa" id="alpa"
                                        class="form-control form-control-user col-6" 
                                        value="<?= $data_gaji['alpa'] ?>"
                                        placeholder="Jumlah Hari Alfa" min="0" max="31" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="sakit">Potongan Hari Sakit (per hari): Rp 25.000</label>
                                    <input type="number" name="sakit" id="sakit"
                                        class="form-control form-control-user col-6" 
                                        value="<?= $data_gaji['sakit'] ?>"
                                        placeholder="Jumlah Hari Sakit" min="0" max="31" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="">Jam Lembur</label>
                                    <input type="number" name="jam_lembur" id="jam_lembur"
                                        class="form-control form-control-user col-6" 
                                        value="<?= $data_gaji['jam_lembur'] ?>"
                                        placeholder="Jam Lembur" min="0">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="">Bayaran Lembur (per jam): Rp 30.000</label>
                                    <input type="number" name="bayaran_lembur" id="bayaran_lembur"
                                        class="form-control form-control-user col-6" 
                                        value="<?= $data_gaji['bayaran_lembur'] ?>"
                                        placeholder="" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="number" id="total_gaji" name="total_gaji"
                                        class="form-control form-control-user col-6" 
                                        value="<?= $data_gaji['total_gaji'] ?>"
                                        placeholder="Total Gaji" readonly>
                                </div>
                                <div class="form-group">
                                    <select name="status" class="form-control col-6" required>
                                        <option value="" disabled>Status</option>
                                        <option value="Belum Dibayar" 
                                            <?= $data_gaji['status'] == 'Belum Dibayar' ? 'selected' : '' ?>>
                                            Belum Dibayar
                                        </option>
                                        <option value="Sudah Dibayar" 
                                            <?= $data_gaji['status'] == 'Sudah Dibayar' ? 'selected' : '' ?>>
                                            Sudah Dibayar
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="simpan" class="btn btn-primary btn-icon-split">
                                        <span class="text">Update</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Yakin Ingin Keluar?</div>
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

    <?php
    // Asumsi parameter pengurangan
    $potongan_alpa_per_hari = 50000; // Contoh: Rp 50.000 per hari alfa
    $potongan_sakit_per_hari = 25000; // Contoh: Rp 25.000 per hari sakit
    
    function hitungPenguranganGaji($gaji_pokok, $alpa, $sakit)
    {
        global $potongan_alpa_per_hari, $potongan_sakit_per_hari;
    
        $total_potongan = $alpa * $potongan_alpa_per_hari + $sakit * $potongan_sakit_per_hari;
    
        return $total_potongan;
    }
    
    ?>



    <script type="text/javascript">
        const nilai_pajak = <?php echo $nilai_pajak; ?>;

        function calculateTotalSalary() {
            const gapok = $('#id_karyawan option:selected').data('gaji');
            const tunjangan = $('#id_karyawan option:selected').data('tunjangan');
            const hadir = parseInt($('#hadir').val()) || 0;
            const alpa = parseInt($('#alpa').val()) || 0;
            const sakit = parseInt($('#sakit').val()) || 0;
            const jamLembur = parseFloat($('#jam_lembur').val()) || 0;

            // Hitung potongan pajak
            const potongan = nilai_pajak / 100;
            const totalGajiDasar = gapok * (1 - potongan) + tunjangan;

            // Hitung potongan absensi
            const potonganAlpa = alpa * 50000; // Rp 50.000 per hari alfa
            const potonganSakit = sakit * 25000; // Rp 25.000 per hari sakit
            const totalPotonganAbsensi = potonganAlpa + potonganSakit;

            // Hitung jam lembur
            const upahPerJam = 30000;
            const gajiLembur = Math.round(jamLembur * upahPerJam);

            // Hitung total gaji akhir
            const totalGaji = Math.round(
                totalGajiDasar + gajiLembur - totalPotonganAbsensi
            );

            $('#bayaran_lembur').val(gajiLembur);
            $('#total_gaji').val(totalGaji);
        }

        // Attach the calculation to multiple input events
        $('#hadir, #alpa, #sakit, #jam_lembur').on('input', function() {
            const totalWorkDays =
                parseInt($('#hadir').val() || 0) +
                parseInt($('#alpa').val() || 0) +
                parseInt($('#sakit').val() || 0);

            if (totalWorkDays > 30) {
                alert('Total hari tidak boleh melebihi 30 hari');
                $(this).val('');
                return;
            }

            calculateTotalSalary();
        });

        $('#id_karyawan').on('change', function() {
            // ambil data dari elemen option yang dipilih
            const gapok = $('#id_karyawan option:selected').data('gaji');
            const jabatan = $('#id_karyawan option:selected').data('jabatan');
            const tunjangan = $('#id_karyawan option:selected').data('tunjangan');

            // tampilkan data ke element
            $('[name=jabatan]').val(`${jabatan}`);
            $('[name=gaji_pokok]').val(`${gapok}`);
            $('[name=tunjangan]').val(`${tunjangan}`);

            // Hitung total gaji dasar setelah pajak
            const potongan = nilai_pajak / 100; // Konversi persen ke desimal
            const totalGajiDasar = gapok * (1 - potongan) + tunjangan; // Total gaji setelah potongan

            // Reset jam lembur dan bayaran lembur
            $('#jam_lembur').val(0);
            $('#bayaran_lembur').val(0);

            // Inisialisasi total gaji awal tanpa lembur
            $('#total_gaji').val(Math.round(totalGajiDasar));
        });
    </script>

    <script>
        // Mendapatkan tanggal saat ini
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // Januari = 0
        var year = today.getFullYear();

        // Format tanggal menjadi YYYY-MM-DD
        var currentDate = year + '-' + month + '-' + day;

        // Set tanggal pada input field
        document.getElementById('tanggal_pembayaran').value = currentDate;
    </script>

</body>


</html>
