<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Fetch submission details before updating
    $query_details = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id = '$id'");
    $submission_details = mysqli_fetch_assoc($query_details);
    
    if (!$submission_details) {
        echo "<script>
            alert('Pengajuan tidak ditemukan!');
            document.location='pengajuan.php';
        </script>";
        exit();
    }
    
    // Update submission status
    $query = mysqli_query($koneksi, "UPDATE pengajuan SET status = 'diterima' WHERE id = '$id'");
    
    if($query) {
        // Prepare and send email
        try {
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sepriyanimassa@gmail.com';
            $mail->Password   = 'degl iffu pvrr zoin';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            
            // Fetch email of the submitter
            $email_query = mysqli_query($koneksi, "SELECT email FROM karyawan WHERE id = '{$submission_details['id_karyawan']}'");
            $email_data = mysqli_fetch_assoc($email_query);
            
            if (!$email_data) {
                echo "<script>
                    alert('Email penerima tidak ditemukan!');
                    document.location='pengajuan.php';
                </script>";
                exit();
            }
            
            $current_date = date('d F Y', strtotime('now'));
            $subject = "Status Pengajuan Anda Telah Diperbarui";
            $content = "
                        <html>
                        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;'>
                            <div style='max-width: 600px; margin: 20px auto; background-color: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>
                                <div style='background-color: #2c3e50; color: white; padding: 20px; border-top-left-radius: 10px; border-top-right-radius: 10px;'>
                                    <h1 style='margin: 0; font-size: 24px; text-align: center;'>Pengajuan Diterima</h1>
                                </div>
                                
                                <div style='padding: 30px;'>
                                    <p style='color: #2c3e50; font-size: 16px; margin-bottom: 20px;'>Kepada Yth. Bapak/Ibu Pemohon,</p>
                                    
                                    <div style='background-color: #e9f5ff; border-left: 5px solid #3498db; padding: 15px; margin-bottom: 20px;'>
                                        <p style='margin: 0; color: #2c3e50;'>
                                            Kami dengan senang hati memberitahukan bahwa <strong>Pengajuan Anda Telah Diterima</strong>.
                                        </p>
                                    </div>
                                    
                                    <table style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>
                                        <tr style='background-color: #f8f9fa; border-bottom: 1px solid #e9ecef;'>
                                            <td style='padding: 10px; width: 40%; font-weight: bold; color: #495057;'>Nomor Pengajuan</td>
                                            <td style='padding: 10px; color: #212529;'>" . htmlspecialchars($submission_details['id']) . "</td>
                                        </tr>
                                        <tr style='background-color: #ffffff; border-bottom: 1px solid #e9ecef;'>
                                            <td style='padding: 10px; font-weight: bold; color: #495057;'>Tanggal Pengajuan</td>
                                            <td style='padding: 10px; color: #212529;'>" . htmlspecialchars($current_date) . "</td>
                                        </tr>
                                        <tr style='background-color: #f8f9fa;'>
                                            <td style='padding: 10px; font-weight: bold; color: #495057;'>Status Terbaru</td>
                                            <td style='padding: 10px; color: #28a745; font-weight: bold;'>DITERIMA</td>
                                        </tr>
                                    </table>
                                    
                                    <div style='background-color: #f1f3f5; border-radius: 5px; padding: 15px; margin-bottom: 20px;'>
                                        <p style='margin: 0; color: #2c3e50; font-style: italic;'>
                                            Pengajuan Anda sedang dalam proses lebih lanjut. Kami akan segera menghubungi Anda dengan informasi tambahan.
                                        </p>
                                    </div>
                                    
                                    <div style='text-align: center; margin-top: 30px;'>
                                        <p style='color: #6c757d; margin-bottom: 10px;'>Terima kasih atas kepercayaan Anda.</p>
                                        <p style='color: #2c3e50; font-weight: bold; margin: 0;'>Tim Pelayanan</p>
                                    </div>
                                </div>
                                
                                <div style='background-color: #f1f3f5; padding: 15px; text-align: center; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;'>
                                    <p style='margin: 0; color: #6c757d; font-size: 12px;'>
                                        Email ini dikirim secara otomatis. Mohon tidak membalas.
                                    </p>
                                </div>
                            </div>
                        </body>
                        </html>";
            
            // Email recipients
            $mail->setFrom('sepriyanimassa@gmail.com', 'Pengajuan Gaji');
            $mail->addAddress($email_data['email']);
            
            // Email content settings
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $content;
            
            // Send email
            $mail->send();
            
            // Success message
            echo "<script>
                alert('Ajuan berhasil diterima dan email notifikasi telah dikirim!');
                document.location='pengajuan.php';
            </script>";
            exit();
        } catch (Exception $e) {
            // Email sending failed, but submission was updated
            echo "<script>
                alert('Ajuan berhasil diterima, tetapi gagal mengirim email notifikasi: " . $mail->ErrorInfo . "');
                document.location='pengajuan.php';
            </script>";
            exit();
        }
    } else {
        // Submission update failed
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