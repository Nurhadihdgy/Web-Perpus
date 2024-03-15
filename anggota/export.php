<?php
session_start();
require_once "../config.php";
$db = db_connect();


$id = $_SESSION['f_id'];

$sql = "SELECT t_peminjaman.f_id AS idp, t_buku.f_judul, t_kategori.f_kategori, t_admin.f_nama AS admin, t_anggota.f_nama AS anggota, t_peminjaman.f_tanggalpeminjaman, t_detailpeminjaman.f_tanggalkembali
    FROM t_peminjaman
    INNER JOIN t_admin ON t_peminjaman.f_idadmin=t_admin.f_id
    INNER JOIN t_anggota ON t_peminjaman.f_idanggota=t_anggota.f_id
    INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id=t_detailpeminjaman.f_idpeminjaman
    INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku=t_detailbuku.f_id
    INNER JOIN t_buku ON t_detailbuku.f_idbuku=t_buku.f_id
    INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id WHERE t_anggota.f_id = $id";
$row = $db->query($sql);
$no = 1;
?>

<!DOCTYPE html>
<head>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto+Mono&family=Scada&display=swap" rel="stylesheet">
    <title>PERPUSTAKAAN KITA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<script>
    window.print();
</script>

<body>
    <form id="compose" name="compose" method="post" action="" enctype="multipart/form-data">
        <strong>
            <center>
                <h2 style="font-family: 'Poppins', sans-serif; color: black;">PEMINJAMAN</h2>
            </center>
        </strong>
        <div class="mt-5">
            <div class="container">
                <table class="table table-bordered w-80">
                    <tr class="table-dark">
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Admin</th>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                    <tbody>
                        <?php if (!empty($row)) : ?>
                            <?php foreach ($row as $r) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $r['f_judul'] ?></td>
                                    <td><?php echo $r['f_kategori'] ?></td>
                                    <td><?php echo $r['admin'] ?></td>
                                    <td><?php echo $r['anggota'] ?></td>
                                    <td><?php echo $r['f_tanggalpeminjaman'] ?></td>
                                    <td>
                                        <?php
                                        if ($r['f_tanggalkembali'] == '0000-00-00') {
                                            echo "<center> - </center> ";
                                        } else {
                                            echo $r['f_tanggalkembali'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($r['f_tanggalkembali'] == '0000-00-00') {
                                            echo "<p type='text'> Belum Kembali </p>";
                                        } else {
                                            echo "<p type='text'> Sudah Kembali </p>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8">No records found</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

</body>

</html>
