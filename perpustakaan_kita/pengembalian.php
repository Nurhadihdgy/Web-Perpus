<?php
include "header.php";
require "../config.php";
$conn = db_connect();

// Fetch data from t_peminjaman, t_detailpeminjaman, t_admin, t_anggota, t_detailbuku, and t_buku tables using INNER JOIN
$sql = "SELECT t_peminjaman.f_id, t_peminjaman.f_expireddate,t_peminjaman.f_idadmin, t_admin.f_nama AS admin_nama, 
               t_peminjaman.f_idanggota, t_anggota.f_nama AS anggota_nama, 
               t_peminjaman.f_tanggalpeminjaman, t_detailpeminjaman.f_id AS detail_id, 
               t_detailpeminjaman.f_idpeminjaman, t_detailpeminjaman.f_iddetailbuku, 
               t_detailpeminjaman.f_tanggalkembali, t_buku.f_judul
        FROM t_peminjaman
        INNER JOIN t_admin ON t_peminjaman.f_idadmin = t_admin.f_id
        INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id
        INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
        INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
        INNER JOIN t_buku ON t_detailbuku.f_idbuku = t_buku.f_id";
$result = $conn->query($sql);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Pengembalian</h1>
    <p class="mb-4">Tabel Pengembalian</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengembalian</h6>
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
                            <th>Detail ID Buku</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Kembali</th>
                            <th>Kembalikan</th>
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
                            echo "<td>" . $row['f_iddetailbuku'] . "</td>";
                            echo "<td>" . $row['f_judul'] . "</td>";
                            // Check if the book has been returned
if ($row['f_tanggalkembali'] === "0000-00-00") {
    // Book has not been returned
    if (strtotime($row['f_expireddate']) < strtotime(date('Y-m-d'))) {
        // Expired
        echo "<td>Belum Kembali (Expired)</td>";
    } else {
        // Not yet expired
        echo "<td>Belum Kembali</td>";
    }
} else {
    // Book has been returned
    echo "<td>" . $row['f_tanggalkembali'] . "</td>";
}

                            // Check if the book has been returned
if ($row['f_tanggalkembali'] === "0000-00-00") {
    // Book has not been returned
    echo "<td><button class='btn btn-primary btn-kembalikan' data-detail-id='" . $row['detail_id'] . "'>Kembalikan</button></td>";
} else {
    // Book has been returned
    if (strtotime($row['f_tanggalkembali']) > strtotime($row['f_expireddate'])) {
        // Returned late
        echo "<td>Sudah Dikembalikan Terlambat</td>";
    } else {
        // Returned on time
        echo "<td>Sudah Dikembalikan</td>";
    }
}

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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Handle the return action asynchronously
        $('.btn-kembalikan').click(function () {
            var detailId = $(this).data('detail-id');
            var currentTimestamp = new Date().toISOString(); // Get the current timestamp

            // AJAX request to handle the return action
            $.ajax({
                type: "POST",
                url: "process_return.php",
                data: { detailId: detailId, timestamp: currentTimestamp },
                success: function (response) {
                    // Reload the page or update the table as needed
                    location.reload();
                },
                error: function (error) {
                    console.log("Error:", error);
                }
            });
        });
    });
</script>
<?php include "footer.php"; ?>




