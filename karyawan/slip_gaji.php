<?php
include '../koneksi.php';

$id_karyawan = $_GET['id_karyawan'];

$query = "SELECT p.*, k.nama, k.jabatan, k.departemen FROM penggajian p
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
            background-color: #f8f9fa;
            padding: 20px;
        }
        .slip-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 30px;
        }
        .company-logo {
            max-height: 80px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .company-address {
            color: #666;
            font-size: 14px;
        }
        .slip-title {
            font-size: 22px;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .employee-details, .salary-details {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            text-align: right;
        }
        .total-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .total-amount {
            font-size: 18px;
            color: #28a745;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
        }
        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }
            .slip-container {
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="slip-container">
        <!-- Header Section -->
        <div class="header">
            <img src="../assets/images/logo.png" alt="Company Logo" class="company-logo">
            <div class="company-name">PT. NAMA PERUSAHAAN</div>
            <div class="company-address">
                Jl. Contoh No. 123, Jakarta Selatan<br>
                Telp: (021) 555-0123 | Email: info@perusahaan.com
            </div>
        </div>

        <div class="slip-title">
            SLIP GAJI KARYAWAN<br>
            <small>Periode: <?= date('F Y', strtotime($data['tanggal_pembayaran'])) ?></small>
        </div>

        <!-- Employee Details -->
        <div class="employee-details">
            <div class="section-title">Informasi Karyawan</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label">Nama</span>
                        <span class="info-value"><?= htmlspecialchars($data['nama']) ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label">Jabatan</span>
                        <span class="info-value"><?= htmlspecialchars($data['jabatan']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Departemen</span>
                        <span class="info-value"><?= htmlspecialchars($data['departemen']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Salary Details -->
        <div class="salary-details">
            <div class="section-title">Rincian Gaji</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label">Gaji Pokok</span>
                        <span class="info-value">Rp <?= number_format($data['gaji_pokok'], 0, ',', '.') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tunjangan Transport</span>
                        <span class="info-value">Rp <?= number_format($data['gaji_pokok'] * 0.1, 0, ',', '.') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tunjangan Makan</span>
                        <span class="info-value">Rp <?= number_format($data['gaji_pokok'] * 0.05, 0, ',', '.') ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label">Potongan PPh 21</span>
                        <span class="info-value">Rp <?= number_format($data['gaji_pokok'] * 0.05, 0, ',', '.') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Potongan BPJS</span>
                        <span class="info-value">Rp <?= number_format($data['gaji_pokok'] * 0.02, 0, ',', '.') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Potongan Lainnya</span>
                        <span class="info-value">Rp <?= number_format($data['gaji_pokok'] * 0.03, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>

            <!-- Total Section -->
            <div class="total-section">
                <div class="info-row">
                    <span class="info-label">Total Gaji Diterima</span>
                    <span class="info-value total-amount">Rp <?= number_format($data['total_gaji'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>Bagian Keuangan</p>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>Karyawan</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Slip gaji ini diterbitkan secara elektronik dan sah tanpa tanda tangan basah.</p>
            <p>Dicetak pada: <?= date('d-m-Y H:i:s') ?></p>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-4 no-print">
            <button class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Slip Gaji
            </button>
        </div>
    </div>
</body>
</html>
<?php
} else {
    echo "<div class='alert alert-danger'>Data karyawan tidak ditemukan.</div>";
}
$stmt->close();
$koneksi->close();
?>