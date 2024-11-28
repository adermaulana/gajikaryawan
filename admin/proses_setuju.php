<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    $query = mysqli_query($koneksi, "UPDATE pengajuan SET status = 'diterima' WHERE id = '$id'");
    
    if($query) {
        // Optional: Add any additional processing for approved submissions
        echo "<script>
            alert('Ajuan berhasil diterima!');
            document.location='pengajuan.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Ajuan gagal diterima!');
            document.location='pengajuan.php';
        </script>";
        exit();
    }
} else {
    header("Location: daftar_pengajuan.php");
    exit();
}
?>