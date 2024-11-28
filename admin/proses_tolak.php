<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    $query = mysqli_query($koneksi, "UPDATE pengajuan SET status = 'ditolak' WHERE id = '$id'");
    
    if($query) {
        // Optional: Add any additional processing for rejected submissions
        echo "<script>
            alert('Ajuan berhasil ditolak!');
            document.location='pengajuan.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Ajuan gagal ditolak!');
            document.location='pengajuan.php';
        </script>";
        exit();
    }
} else {
    header("Location: daftar_pengajuan.php");
    exit();
}
?>