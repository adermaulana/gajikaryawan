

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayrollPro - Sistem Manajemen Gaji Karyawan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 24px;
            font-weight: 700;
        }

        .logo span {
            color: #00ff88;
        }

        /* Hero Section */
        .hero {
            padding-top: 120px;
            padding-bottom: 60px;
            text-align: center;
            color: white;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            background: linear-gradient(to right, #ffffff, #00ff88);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 40px;
            color: #e0e0e0;
        }

        /* Login Form */
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            max-width: 400px;
            margin: 0 auto;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: white;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 0 2px #00ff88;
        }

        .btn-login {
            background: linear-gradient(45deg, #00ff88, #00b8ff);
            color: #1e3c72;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 255, 136, 0.4);
        }

        /* Features Section */
        .features {
            padding: 60px 0;
            text-align: center;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            color: white;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 40px;
            color: #00ff88;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            margin-bottom: 15px;
            font-size: 20px;
        }

        .feature-card p {
            color: #e0e0e0;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 16px;
            }
            
            .login-container {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-content">
            <div class="logo">Penggajian<span> Karyawan</span></div>
            <a class="btn-login" href="login.php">Login</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Sistem Manajemen Gaji Karyawan</h1>
            <p>Kelola penggajian karyawan Anda dengan mudah, cepat, dan aman</p>
        </div>
    </section>



    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3>Perhitungan Otomatis</h3>
                    <p>Hitung gaji, tunjangan, dan potongan secara otomatis dengan akurat</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Tepat Waktu</h3>
                    <p>Proses penggajian yang cepat dan tepat waktu setiap bulannya</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Keamanan Terjamin</h3>
                    <p>Data penggajian tersimpan dengan aman dan terenkripsi</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>