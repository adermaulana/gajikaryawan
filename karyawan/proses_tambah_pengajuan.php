<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $id_karyawan = mysqli_real_escape_string($koneksi, $_POST['id_karyawan']);
    $nominal = mysqli_real_escape_string($koneksi, $_POST['nominal']);
    $alasan = mysqli_real_escape_string($koneksi, $_POST['alasan']);

    // Set default status to 'pending'
    $status = 'pending';

    // Prepare SQL to prevent SQL injection
    $query = "INSERT INTO pengajuan (id_karyawan, nominal, alasan, status) 
              VALUES (?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "iiss", $id_karyawan, $nominal, $alasan, $status);
    
    if (mysqli_stmt_execute($stmt)) {
        // Successful insertion
        echo "<script>
            alert('Ajuan sukses!');
            document.location='pengajuan.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Ajuan Gagal!');
            document.location='pengajuan.php';
        </script>";
        exit();
    }
} else {
    // Redirect if accessed directly without POST
    header("Location: pengajuan.php");
    exit();
}
?>