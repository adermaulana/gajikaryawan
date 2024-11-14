<?php
require_once '../koneksi.php';

// Ambil parameter tanggal jika ada
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Query untuk mengambil data
$query = "SELECT p.*, k.nama FROM penggajian p
          JOIN karyawan k ON p.id_karyawan = k.id";
if ($start_date && $end_date) {
    $query .= " WHERE p.tanggal_pembayaran BETWEEN '$start_date' AND '$end_date'";
}

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penggajian</title>
    <style>
        /* CSS untuk laporan */
        @media print {
            /* Menyembunyikan tombol print pada hasil cetakan */
            .no-print {
                display: none;
            }
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        /* Format mata uang */
        .currency {
            text-align: right;
        }
    </style>
    <script>
        // Script untuk memunculkan print dialog secara otomatis
        window.onload = function() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="header">
        <h2>Laporan Penggajian Karyawan</h2>
        <?php if ($start_date && $end_date): ?>
        <p>Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?></p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Potongan</th>
                <th>Total Gaji</th>
                <th>Tanggal Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total_semua_gaji = 0;
            while ($data = mysqli_fetch_array($result)): 
                $total_semua_gaji += $data['total_gaji'];
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['jabatan'] ?></td>
                <td class="currency">Rp <?= number_format($data['gaji_pokok'], 0, ',', '.') ?></td>
                <td>10%</td>
                <td class="currency">Rp <?= number_format($data['total_gaji'], 0, ',', '.') ?></td>
                <td><?= date('d/m/Y', strtotime($data['tanggal_pembayaran'])) ?></td>
                <td><?= $data['status'] ?></td>
            </tr>
            <?php endwhile; ?>
            <!-- Menambahkan total gaji -->
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Total Gaji:</strong></td>
                <td class="currency"><strong>Rp <?= number_format($total_semua_gaji, 0, ',', '.') ?></strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

</body>
</html>