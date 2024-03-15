<?php
require_once '../config.php';
$db = db_connect();

$sql = "SELECT f_nama, COUNT(*) AS kembali FROM t_anggota 
        INNER JOIN t_peminjaman ON t_anggota.f_id = t_peminjaman.f_idanggota
        INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman 
        WHERE f_tanggalkembali ='0000-00-00' 
        GROUP BY f_nama ORDER BY COUNT(*) DESC";
$row = $db->query($sql);
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

    <form id="compose" name="compose" method="post" action="" enctype="multipart/form-data">
        <div class="container mt-5">
            <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; color: black;">Anggota Yang Belum Mengembalikan Buku</h2>
            <table class="table table-bordered w-80">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Banyak Anggota Yang Belum Mengembalikan</th>
                        <th scope="col">Banyak Buku</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($row)) { ?>
                        <?php foreach ($row as $r) : ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $r['f_nama'] ?></td>
                                <td><?php echo $r['kembali'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </form>

    <!-- Bootstrap JS and dependencies (you might need to adjust the paths) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
