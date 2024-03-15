<?php
require_once '../config.php';
$db = db_connect();

// Manually execute the query
$sql = "SELECT DISTINCT t_detailbuku.f_id AS f_iddetailbuku, t_buku.f_id as f_id , f_judul, f_kategori, f_pengarang, f_penerbit, f_deskripsi FROM t_buku 
        INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id
        LEFT JOIN t_detailbuku ON t_buku.f_id = t_detailbuku.f_idbuku WHERE f_status = 'Tidak Tersedia'
        GROUP BY t_buku.f_id ORDER BY t_detailbuku.f_id ASC";

$result = $db->query($sql); // Assuming executeSelectQuery is a method in your dbcontroller for SELECT queries
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
        <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; color: black;">Jumlah Buku Yang Belum Dikembalikan</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Pengarang</th>
                    <th scope="col">Penerbit</th>
                    <th scope="col">Kode Buku</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($result)) { ?>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['f_judul'] ?></td>
                            <td><?php echo $row['f_pengarang'] ?></td>
                            <td><?php echo $row['f_penerbit'] ?></td>
                            <td><?php echo $row['f_iddetailbuku'] ?></td>
                            <td><?php echo $row['f_kategori'] ?></td>
                            <td>
                                <?php
                                $query = "SELECT COUNT(*) as count FROM `t_detailbuku` WHERE f_status='Tidak Tersedia' AND `f_idbuku` = " . $row['f_id'];
                                $result_stock = $db->query($query);

                                if ($result_stock && $result_stock->num_rows > 0) {
                                    $eksemplar = $result_stock->fetch_assoc()['count'];
                                    echo $eksemplar;
                                } else {
                                    echo 0; // Set default value if no result is found
                                }
                                ?>
                            </td>
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
