<?php
include '../koneksi.php';
session_start();

if (isset($_POST['update_status'])) {
    $id_penggajian = $_POST['id_penggajian'];
    $status = $_POST['status'];
    
    try {
        // Perbaiki query SQL - hapus koma sebelum WHERE
        $query = "UPDATE penggajian SET status = ? WHERE id = ?";
                 
        $stmt = $koneksi->prepare($query);
        // Perbaiki bind_param - sesuaikan dengan jumlah parameter
        $stmt->bind_param("si", $status, $id_penggajian);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Berhasil Update Status!');
                document.location='gaji.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal Update Status!');
                document.location='gaji.php';
            </script>";
        }
        
        $stmt->close();
        $koneksi->close();
        
    } catch (Exception $e) {
        echo "<script>
            alert('Terjadi kesalahan: " . $e->getMessage() . "');
            document.location='gaji.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Invalid Request!');
        document.location='gaji.php';
    </script>";
}
?>