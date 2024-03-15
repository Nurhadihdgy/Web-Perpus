<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto+Mono&family=Scada&display=swap" rel="stylesheet">
<style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000; /* Warna latar belakang tema dark */
            color: #ffffff; /* Warna teks pada tema dark */
        }

        .card {
            background-color: #164863;
            width: 500px; /* Lebar kartu diperbesar menjadi 400px */
            margin: auto;
            margin-top: 200px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(to right, #4CAF50, #45a049); /* Gradient hijau pada card header */
            color: #ffffff;
            font-size: 50px;
            font-family: 'Poppins', sans-serif;
            font-weight:bolder;
        }

        .btn-gradient {
            background: linear-gradient(to right, #98FB98, #45a049); /* Gradient hijau pada tombol */
            border: none;
            color: #ffffff;
        }

        .btn-gradient:hover {
            background: linear-gradient(to right, #45a049, #4CAF50); /* Efek hover pada tombol */
            color: #ffffff;
        }
    </style>
    <title>Login</title>
</head>
<body>

<div class="card">
    <div class="card-header text-center">
        Login
    </div>
    <div class="card-body">
        <!-- Form login -->
        <form action="cek_login_anggota.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-gradient btn-block">Login</button>
        </form>
        <!-- Akhir form login -->
    </div>
</div>

<!-- Tautan Bootstrap JS dan Popper.js (diperlukan oleh Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
