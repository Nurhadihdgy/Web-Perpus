<?php
include "header.php";
require "../config.php";
$conn = db_connect();

$id = $_SESSION['f_id'];

$sql = "SELECT t_peminjaman.f_id AS idp, t_peminjaman.f_expireddate, t_buku.f_judul, t_kategori.f_kategori, t_admin.f_nama AS admin, t_anggota.f_nama AS anggota, t_peminjaman.f_tanggalpeminjaman,t_detailbuku.f_id AS idbuku, t_detailpeminjaman.f_tanggalkembali
    FROM t_peminjaman
    INNER JOIN t_admin ON t_peminjaman.f_idadmin = t_admin.f_id
    INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id
    INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
    INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
    INNER JOIN t_buku ON t_detailbuku.f_idbuku = t_buku.f_id
    INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id WHERE t_anggota.f_id =$id;";
$row = $conn->query($sql);
$no = 1;

// Initialize arrays to store overdue and soon-to-be-overdue books
$overdueBooks = [];
$soonToBeOverdueBooks = [];

// Get the current date
$currentDate = new DateTime();
$currentDate->setTime(0, 0, 0); // Set time to midnight

// Check each book's status
foreach ($row as $r) {
    if ($r['f_tanggalkembali'] == '0000-00-00' && $currentDate->format('Y-m-d') > $r['f_expireddate']) {
        // Get the expire date
        $expireDate = new DateTime($r['f_expireddate']);
        $overdueBooks[] = $r;
    
    } elseif ($r['f_tanggalkembali'] == '0000-00-00' && $currentDate->format('Y-m-d') == $r['f_expireddate']) {
        $soonToBeOverdueBooks[] = $r;
    }
}

// Display notifications only if there are relevant books
if (!empty($overdueBooks)) {
    // Display Danger Notification for Overdue Books
    echo "<div class='alert alert-danger' role='alert'>There are overdue books!</div>";
}

if (!empty($soonToBeOverdueBooks)) {
    // Display Warning Notification for Soon-to-be-overdue Books
    echo "<div class='alert alert-warning' role='alert'>There are books that will soon be overdue!</div>";
}





?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Peminjaman Buku</h1>
    <p class="mb-4">Daftar Peminjaman Buku</p>

    <!-- Notifications for overdue books -->
<?php if (!empty($overdueBooks)) : ?>
    <div class="card text-white bg-danger mb-3">
        <div class="card-header text-dark">Notifikasi</div>
        <div class="card-body">
            <h5 class="card-title">Ada peminjaman yang sudah expired:</h5>
            <?php foreach ($overdueBooks as $overdueBook) : ?>
                <p class="card-text">
                <?php echo $overdueBook['idbuku']; ?> - <?php echo $overdueBook['f_judul']; ?> - <?php echo $overdueBook['f_kategori']; ?> <br>
                    ID Peminjaman : <?php echo $overdueBook['idp']; ?>
                </p>
            <?php endforeach ?>
        </div>
    </div>
<?php endif; ?>

<!-- Notifications for soon-to-be-overdue books -->
<?php if (!empty($soonToBeOverdueBooks)) : ?>
    <div class="card text-dark bg-warning mb-3">
        <div class="card-header text-dark">Notifikasi</div>
        <div class="card-body">
            <h5 class="card-title">Warning!!! Ada peminjaman yang akan segera expired:</h5>
            <?php foreach ($soonToBeOverdueBooks as $soonToBeOverdueBook) : ?>
                <p class="card-text">
                <?php echo $soonToBeOverdueBook['idbuku']; ?> - <?php echo $soonToBeOverdueBook['f_judul']; ?> - <?php echo $soonToBeOverdueBook['f_kategori']; ?> <br>
                    ID Peminjaman : <?php echo $soonToBeOverdueBook['idp']; ?>
                </p>
            <?php endforeach ?>
        </div>
    </div>
<?php endif; ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Peminjaman Buku</h6>
            <a class="btn btn-secondary btn-icon-split btn-sm float-right" href="export.php">
                <span class="icon text-white-50">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                </span>
                <span class="text"> Export</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Admin</th>
                            <th>Anggota</th>
                            <th>Kode Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Expired Date</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($row)) { ?>
                        <?php foreach ($row as $r) : ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $r['f_judul'] ?></td>
                            <td><?php echo $r['f_kategori'] ?></td>
                            <td><?php echo $r['admin'] ?></td>
                            <td><?php echo $r['anggota'] ?></td>
                            <td><?php echo $r['idbuku'] ?></td>
                            <td><?php echo $r['f_tanggalpeminjaman'] ?></td>
                            <td><?php echo $r['f_expireddate'] ?></td>
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
        // Calculate the difference in days
        $currentDate = new DateTime();
        $expireDate = new DateTime($r['f_expireddate']);
        $difference = $currentDate->diff($expireDate)->days;
    
        if ($currentDate > $expireDate) {
            echo "<p type='text'>Belum Kembali (Expired $difference Hari)</p>";
        } else {
            echo "<p type='text'>Belum Kembali</p>";
        }
    } else {
        if ($r['f_tanggalkembali'] <= $r['f_expireddate']) {
            echo "<p type='text'>Sudah Kembali</p>";
        } else {
            $currentDate = new DateTime();
            $expireDate = new DateTime($r['f_expireddate']);
            $difference = $currentDate->diff($expireDate)->days;
    
            if ($currentDate > $expireDate) {
                echo "<p type='text'>Sudah Kembali (Expired $difference Hari)</p>";
            } else {
                echo "<p type='text'>Belum Kembali</p>";
            }
        }
    }
    
    ?>
</td>

                        </tr>
                        <?php endforeach ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include "footer.php"; ?>