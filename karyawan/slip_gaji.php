<?php
include '../koneksi.php';

// Get the employee ID from the URL
$id_karyawan = $_GET['id_karyawan'];

// Fetch employee salary details
$query = "SELECT p.*, k.nama, k.jabatan FROM penggajian p
          JOIN karyawan k ON p.id_karyawan = k.id
          WHERE k.id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_karyawan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Slip Gaji - <?= htmlspecialchars($data['nama']) ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                padding: 20px;
                background-color: #f8f9fa;
                border-radius: 5px;
            }
            .slip-container {
                background: #ffffff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                text-align: center;
                color: #343a40;
            }
            .info {
                margin-bottom: 20px;
            }
            .info p {
                margin: 5px 0;
            }
            .total {
                font-size: 1.5em;
                color: #28a745;
                font-weight: bold;
            }
            .print-button {
                margin-top: 20px;
                display: flex;
                justify-content: center;
            }
            @media print {
                .print-button {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="slip-container">
            <h1>Slip Gaji</h1>
            <div class="info">
                <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></p>
                <p><strong>Jabatan:</strong> <?= htmlspecialchars($data['jabatan']) ?></p>
                <p><strong>Gaji Pokok:</strong> Rp <?= number_format($data['gaji_pokok'], 0, ',', '.') ?></p>
                <p><strong>Potongan:</strong> 10% (Rp <?= number_format($data['gaji_pokok'] * 0.1, 0, ',', '.') ?>)</p>
                <p class="total"><strong>Total Gaji:</strong> Rp <?= number_format($data['total_gaji'], 0, ',', '.') ?></p>
                <p><strong>Tanggal Pembayaran:</strong> <?= date('d-m-Y', strtotime($data['tanggal_pembayaran'])) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($data['status']) ?></p>
            </div>
            <div class="print-button">
                <button class="btn btn-success" onclick="window.print()"><i class="fas fa-print"></i> Print Slip</button>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<div class='alert alert-danger'>Data not found.</div>";
}
$stmt->close();
$koneksi->close();
?>
