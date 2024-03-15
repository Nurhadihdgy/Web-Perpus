<?php
include "header.php";
require "../config.php";
$conn = db_connect();

$_SESSION['user_id'];
$_SESSION['user_nama'];


// Fetch data from t_peminjaman, t_detailpeminjaman, t_admin, t_anggota, t_detailbuku, t_buku, and t_kategori tables using INNER JOIN
$sql = "SELECT t_peminjaman.f_id,t_peminjaman.update_at, t_peminjaman.f_expireddate, t_peminjaman.f_idadmin, t_admin.f_nama AS admin_nama, 
               t_peminjaman.f_idanggota, t_anggota.f_nama AS anggota_nama, 
               t_peminjaman.f_tanggalpeminjaman, t_detailpeminjaman.f_id AS detail_id, 
               t_detailpeminjaman.f_idpeminjaman, t_detailpeminjaman.f_iddetailbuku, 
               t_detailpeminjaman.f_tanggalkembali, t_buku.f_judul, t_kategori.f_kategori
        FROM t_peminjaman
        INNER JOIN t_admin ON t_peminjaman.f_idadmin = t_admin.f_id
        INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id
        INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
        INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
        INNER JOIN t_buku ON t_detailbuku.f_idbuku = t_buku.f_id
        INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id
        WHERE t_detailpeminjaman.f_tanggalkembali = '0000-00-00'";


$result = $conn->query($sql);

if (isset($_POST['simpan'])) {
    $admin = $_POST['f_idadmin'];
    $anggota = $_POST['f_idanggota'];
    $judulbuku = $_POST['judulbuku'];

    // Explicitly set the timezone to Jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Get the current timestamp in Jakarta timezone
    $currentDateTime = date('Y-m-d');

    // Calculate the expireddate (3 days after the current date)
    $expireddate = date('Y-m-d ', strtotime($currentDateTime . ' + 3 days'));

    // Query SQL untuk menambah peminjaman
    $sqlPeminjaman = "INSERT INTO t_peminjaman (f_idadmin, f_idanggota, f_tanggalpeminjaman, f_expireddate) VALUES ('$admin', '$anggota', '$currentDateTime', '$expireddate')";
    $conn->query($sqlPeminjaman);

    // Query SQL untuk menambah detail peminjaman
    $idpeminjamanterakhir = $conn->insert_id; // Mengambil ID peminjaman terakhir
    $sqlDetailPeminjaman = "INSERT INTO t_detailpeminjaman VALUES('', '$idpeminjamanterakhir', '$judulbuku', '0000-00-00')";
    $conn->query($sqlDetailPeminjaman);

    // Query SQL untuk mengupdate status buku menjadi 'Tidak Tersedia'
    $sqlUpdateStatusBuku = "UPDATE t_detailbuku SET f_status = 'Tidak Tersedia' WHERE f_id = $judulbuku";
    $conn->query($sqlUpdateStatusBuku);

    // Pesan berhasil dan redirect
    echo "<script>
        alert ('Berhasil Ditambah!');
        window.location.assign('?peminjaman=success');
        </script>";
}

if (isset($_POST['ubah'])) {
    $idpeminjaman_ubah = $_POST['idpeminjaman_ubah'];
    $admin_ubah = $_POST['f_idadmin_ubah'];
    $anggota_ubah = $_POST['f_idanggota_ubah'];
    $judulbuku_ubah = $_POST['judulbuku_ubah'];
    $tgl_ubah = $_POST['f_tanggalpeminjaman_ubah'];

     // Explicitly set the timezone to Jakarta
     date_default_timezone_set('Asia/Jakarta');

     // Get the current timestamp in Jakarta timezone
     $currentDateTime = date('Y-m-d H:i:s');

    // Query SQL untuk mendapatkan ID buku yang sebelumnya dipinjam
    $sqlGetOldBook = "SELECT f_iddetailbuku FROM t_detailpeminjaman WHERE f_idpeminjaman = $idpeminjaman_ubah";
    $resultOldBook = $conn->query($sqlGetOldBook);
    $rowOldBook = $resultOldBook->fetch_assoc();
    $idOldBook = $rowOldBook['f_iddetailbuku'];

    // Query SQL untuk mengubah status buku yang sebelumnya dipinjam menjadi 'Tersedia'
    $sqlUpdateStatusOldBook = "UPDATE t_detailbuku SET f_status = 'Tersedia' WHERE f_id = $idOldBook";
    $conn->query($sqlUpdateStatusOldBook);

    // Query SQL untuk mengubah status buku yang dipilih sekarang menjadi 'Tidak Tersedia'
    $sqlUpdateStatusNewBook = "UPDATE t_detailbuku SET f_status = 'Tidak Tersedia' WHERE f_id = $judulbuku_ubah";
    $conn->query($sqlUpdateStatusNewBook);

    // Query SQL untuk mengubah detail peminjaman
    $sqlUpdateDetailPeminjaman = "UPDATE t_detailpeminjaman SET f_iddetailbuku = '$judulbuku_ubah' WHERE f_idpeminjaman = $idpeminjaman_ubah";
    $conn->query($sqlUpdateDetailPeminjaman);

    $sqlUpdateAt = "UPDATE t_peminjaman SET update_at = '$currentDateTime' WHERE f_id = $idpeminjaman_ubah";
    $conn->query($sqlUpdateStatusOldBook);

    // Pesan berhasil dan redirect
    echo "<script>
        alert ('Berhasil Diubah!');
        window.location.assign('?peminjaman=success');
        </script>";
}




?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Peminjaman</h1>
    <p class="mb-4">Tabel Peminjaman</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Peminjaman</h6>
            <button class="btn btn-success btn-icon-split btn-sm float-right" data-toggle="modal" data-target="#modalTambahPeminjaman">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Peminjaman</span>
            </button>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Admin</th>
                            <th>Anggota</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Expired Date</th>
                            <th>Updated At</th>
                            <th>Detail ID Buku</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
    // Loop through the result set and output data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['f_id'] . "</td>";
        echo "<td>" . $row['admin_nama'] . "</td>";
        echo "<td>" . $row['anggota_nama'] . "</td>";
        echo "<td>" . $row['f_tanggalpeminjaman'] . "</td>";
        echo "<td>" . $row['f_expireddate'] . "</td>";
        echo "<td>" . $row['update_at'] . "</td>";
        echo "<td>" . $row['f_iddetailbuku'] . "</td>";
        echo "<td>" . $row['f_judul'] . "</td>";
        echo "<td>" . $row['f_kategori'] . "</td>";
        echo "<td>";

        
       
        echo '<form action="peminjaman_crud.php" method="post">';
    echo '<input type="hidden" name="id" value="' . $row['f_id'] . '">';
    echo '<button type="button" class="btn btn-warning mx-3 btn-ubah-peminjaman" data-toggle="modal" data-target="#editLoanModal" data-id="' . $row['f_id'] . '" data-admin="' . $row['f_idadmin'] . '" data-anggota="' . $row['f_idanggota'] . '" data-judul="' . $row['f_iddetailbuku'] . '" data-tanggal="' . $row['f_tanggalpeminjaman'] . '">
            <i class="fas fa-edit"></i>Ubah Peminjaman
        </button>';
   
    echo '</form>';
    
        
        




echo "</td>";

        echo "</tr>";
    }
    ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?php

// Mendapatkan data admin
$adminResult = $conn->query("SELECT * FROM t_admin ORDER BY f_nama ASC");
$admin = $adminResult->fetch_all(MYSQLI_ASSOC);

// Mendapatkan data anggota
$anggotaResult = $conn->query("SELECT * FROM t_anggota ORDER BY f_id ASC");
$anggota = $anggotaResult->fetch_all(MYSQLI_ASSOC);


// Mendapatkan data buku yang tersedia dengan kategori
$bukuResult = $conn->query("SELECT t_detailbuku.f_id AS f_iddetailbuku, f_judul, f_deskripsi, f_kategori
    FROM t_buku
    INNER JOIN t_detailbuku ON t_buku.f_id = t_detailbuku.f_idbuku
    INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id
    WHERE f_status = 'Tersedia'");
$buku = $bukuResult->fetch_all(MYSQLI_ASSOC);


// Mendapatkan data buku yang tersedia
$bukueditResult = $conn->query("SELECT t_detailbuku.f_id AS f_iddetailbuku, f_judul, f_deskripsi, f_kategori
FROM t_buku
INNER JOIN t_detailbuku ON t_buku.f_id = t_detailbuku.f_idbuku
INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id");
$bukuedit = $bukueditResult->fetch_all(MYSQLI_ASSOC);


// Tutup koneksi database
$conn->close();
?>
<!-- Modal Tambah Peminjaman -->
<div class="modal fade" id="modalTambahPeminjaman" tabindex="-1" role="dialog" aria-labelledby="modalTambahPeminjamanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPeminjamanLabel">Tambah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Peminjaman -->
<form action="" method="post">
    <!-- Admin/Pustakawan -->
    <div class="form-group">
        <label for="f_idadmin">Admin/Pustakawan</label>
        
        <?php
        // Check if the admin information is available in the session
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_nama'])) {
            // Use the admin information to pre-fill the hidden input
            echo '<input type="hidden" name="f_idadmin" value="' . $_SESSION['user_id'] . '">';
            echo '<input type="text" class="form-control" value="' . $_SESSION['user_nama'] . '" readonly>';
        }
    ?>
    </div>
   <!-- Anggota -->
<div class="form-group">
    <label for="f_idanggota">ID Anggota</label>
    <select name="f_idanggota" id="f_idanggota" class="form-control">
        <?php foreach ($anggota as $r) : ?>
            <option value="<?php echo $r['f_id'] ?>"><?php echo $r['f_id'] ?></option>
        <?php endforeach ?>
    </select>
</div>

<!-- Nama Anggota -->
<div class="form-group">
    <label for="f_namaanggota">Nama Anggota</label>
    <input type="text" name="f_namaanggota" id="f_namaanggota" class="form-control" readonly>
</div>

<script>
    $(document).ready(function () {
        // Handle change event of the ID Anggota dropdown
        $('#f_idanggota').on('change', function () {
            // Get the selected ID Anggota
            var selectedIdAnggota = $(this).val();

            // Find the corresponding Nama Anggota based on the selected ID Anggota
            var selectedAnggota = <?php echo json_encode($anggota); ?>.find(function (anggota) {
                return anggota.f_id == selectedIdAnggota;
            });

            // Update the Nama Anggota input and disable it
            $('#f_namaanggota').val(selectedAnggota.f_nama).prop('disabled', true);
        });
    });
</script>

    <!-- Judul Buku -->
    <div class="form-group">
        <label for="judulbuku">Judul Buku</label>
        <select name="judulbuku" id="judulbuku" class="form-control">
            <?php foreach ($buku as $r) : ?>
                <option value="<?php echo $r['f_iddetailbuku'] ?>">
                <?php echo $r['f_iddetailbuku'] . "." . $r['f_judul'] . " - " . $r['f_kategori']; ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    
    <!-- Tombol Simpan -->
    <button type="submit" class="btn btn-dark" name="simpan" value="simpan">Simpan</button>
</form>
<!-- End Form Tambah Peminjaman -->
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah Peminjaman -->

<!-- Modal Ubah Peminjaman -->
<div class="modal fade" id="editLoanModal" tabindex="-1" role="dialog" aria-labelledby="editLoanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLoanModalLabel">Ubah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Loan Form -->
                <form action="" id="editLoanForm" method="post">
                    <input type="hidden" id="editLoanId" name="idpeminjaman_ubah">
                    <div class="form-group">
    <label for="editAdmin">Admin/Pustakawan</label>
    <select name="f_idadmin_ubah" id="editAdmin" class="form-control" disabled>
        <?php foreach ($admin as $r) : ?>
            <option value="<?php echo $r['f_id'] ?>"><?php echo $r['f_nama'] ?></option>
        <?php endforeach ?>
    </select>
    <input type="hidden" name="f_idadmin_ubah" value="<?php echo $admin[0]['f_id']; ?>">
</div>

<div class="form-group">
    <label for="editAnggota">Anggota</label>
    <select name="f_idanggota_ubah" id="editAnggota" class="form-control" disabled>
        <?php foreach ($anggota as $r) : ?>
            <option value="<?php echo $r['f_id'] ?>"><?php echo $r['f_nama'] ?></option>
        <?php endforeach ?>
    </select>
    <input type="hidden" name="f_idanggota_ubah" value="<?php echo $anggota[0]['f_id']; ?>">
</div>

                    
                    <div class="form-group">
                        <label for="editJudulBuku">Judul Buku</label>
                        <select name="judulbuku_ubah" id="editJudulBuku" class="form-control">
                            <?php foreach ($bukuedit as $r) : ?>
                                <option value="<?php echo $r['f_iddetailbuku'] ?>">
                                    <?php echo $r['f_iddetailbuku'] . "." . $r['f_judul'] . " - " . $r['f_kategori']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning" name="ubah" value="ubah">Ubah Peminjaman</button>
                </form>
            </div>
        </div>
    </div>
</div>





<script>
// JavaScript to set values when the Edit modal is triggered
$(document).ready(function () {
    $('.btn-ubah-peminjaman').click(function () {
        var idPeminjaman = $(this).data('id');
        var idAdmin = $(this).data('admin');
        var idAnggota = $(this).data('anggota');
        var idDetailBuku = $(this).data('judul');
        var tanggalPeminjaman = $(this).data('tanggal');

        console.log('ID Peminjaman:', idPeminjaman);
        console.log('ID Admin:', idAdmin);
        console.log('ID Anggota:', idAnggota);
        console.log('ID Detail Buku:', idDetailBuku);
        console.log('Tanggal Peminjaman:', tanggalPeminjaman);

        // Mengisi formulir modal dengan data peminjaman yang akan diubah
        $('#editLoanId').val(idPeminjaman);
        $('#editAdmin').val(idAdmin);
        $('#editAnggota').val(idAnggota);
        $('#editJudulBuku').val(idDetailBuku);
        $('#editTanggalPeminjaman').val(tanggalPeminjaman);

        // Membuka modal
        $('#editLoanModal').modal('show');
    });
});


</script>


<?php include "footer.php"; ?>


