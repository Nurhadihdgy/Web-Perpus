<?php
require_once '../config.php';
$db = db_connect();

// Manually execute the query
$sql = "SELECT f_judul, COUNT(*) AS dipinjam FROM t_peminjaman 
        INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman 
        INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id 
        INNER JOIN t_buku ON t_detailbuku.f_idbuku = t_buku.f_id 
        WHERE NOT f_tanggalkembali = '0000-00-00'
        GROUP BY f_judul ORDER BY COUNT(*) DESC";

$result = $db->query($sql); // Assuming executeSelectQuery is a method in your dbcontroller for SELECT queries
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto+Mono&family=Scada&display=swap" rel="stylesheet">
    <title>PERPUSTAKAAN KITA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <script>
        window.print();
    </script>

    <div class="container mt-5">
        <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; color: black;">Judul Buku Peminjaman Terbanyak</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">JUDUL BUKU</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($result)) { ?>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['f_judul'] ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies (you might need to adjust the paths) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
