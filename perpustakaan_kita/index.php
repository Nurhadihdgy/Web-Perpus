<?php
include "header.php";
require "../config.php";
$conn = db_connect(); // Assuming you have a function for database connection

// Mendapatkan data buku berdasarkan judul
$sql_jumlah_buku_per_judul = "SELECT t_buku.f_judul, COUNT(t_detailbuku.f_idbuku) AS jumlah
                              FROM t_buku
                              LEFT JOIN t_detailbuku ON t_buku.f_id = t_detailbuku.f_idbuku
                              GROUP BY t_buku.f_judul";
$result_jumlah_buku_per_judul = $conn->query($sql_jumlah_buku_per_judul);

// Menginisialisasi array untuk label dan data
$labels = [];
$data = [];

// Mengisi array dengan hasil query
while ($row = $result_jumlah_buku_per_judul->fetch_assoc()) {
    $labels[] = $row['f_judul'];
    $data[] = $row['jumlah'];
}
// Mendapatkan jumlah buku
$sql_jumlah_buku = "SELECT COUNT(*) FROM t_buku";
$result_jumlah_buku = $conn->query($sql_jumlah_buku);
$jumlah_buku = $result_jumlah_buku->fetch_row()[0];

// Mendapatkan jumlah anggota
$sql_jumlah_anggota = "SELECT COUNT(*) FROM t_anggota";
$result_jumlah_anggota = $conn->query($sql_jumlah_anggota);
$jumlah_anggota = $result_jumlah_anggota->fetch_row()[0];

// Mendapatkan jumlah buku yang dipinjam
$sql_jumlah_buku_dipinjam = "SELECT COUNT(*) FROM t_detailpeminjaman WHERE f_tanggalkembali = '0000-00-00'";
$result_jumlah_buku_dipinjam = $conn->query($sql_jumlah_buku_dipinjam);
$jumlah_buku_dipinjam = $result_jumlah_buku_dipinjam->fetch_row()[0];

// Mendapatkan jumlah pustakawan
$sql_jumlah_pustakawan = "SELECT COUNT(*) FROM t_admin";
$result_jumlah_pustakawan = $conn->query($sql_jumlah_pustakawan);
$jumlah_pustakawan = $result_jumlah_pustakawan->fetch_row()[0];
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Jumlah Buku Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Buku</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_buku; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Anggota Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Anggota</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_anggota; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Buku yang Dipinjam Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Buku Yang Dipinjam
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $jumlah_buku_dipinjam; ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: <?php echo ($jumlah_buku_dipinjam / $jumlah_buku) * 100; ?>%" aria-valuenow="<?php echo ($jumlah_buku_dipinjam / $jumlah_buku) * 100; ?>"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Pustakawan Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Admin/Pustakawan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_pustakawan; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jumlah Buku Card Example -->
    <div class="col-xl-12 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Buku Per Judul</div>
                            <div class="bar-chart-container">
                                <canvas id="jumlahBukuChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
    var ctx = document.getElementById('jumlahBukuChart').getContext('2d');
    var jumlahBukuChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Jumlah Buku',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php
include "footer.php";
?>
