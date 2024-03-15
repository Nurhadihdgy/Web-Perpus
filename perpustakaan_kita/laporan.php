<?php
include "header.php";
require "../config.php";
$conn = db_connect(); // Assuming you have a function for database connection

// Fetch data from t_kategori table
$sql_kategori = "SELECT f_id, f_kategori FROM t_kategori";
$result_kategori = $conn->query($sql_kategori);

// Fetch other data as needed
$sql_bukuseluruh = "SELECT COUNT(f_judul) FROM t_buku";
$result_bukuseluruh = $conn->query($sql_bukuseluruh);
$bukuseluruh = $result_bukuseluruh->fetch_row()[0];

$sql_bukupinjam = "SELECT COUNT(f_judul) FROM t_buku INNER JOIN t_detailbuku ON t_buku.f_id=t_detailbuku.f_idbuku WHERE f_status='Tidak Tersedia'";
$result_bukupinjam = $conn->query($sql_bukupinjam);
$bukupinjam = $result_bukupinjam->fetch_row()[0];

$sql_bukutersedia = "SELECT COUNT(f_judul) FROM t_buku INNER JOIN t_detailbuku ON t_buku.f_id=t_detailbuku.f_idbuku WHERE f_status='Tersedia'";
$result_bukutersedia = $conn->query($sql_bukutersedia);
$bukutersedia = $result_bukutersedia->fetch_row()[0];

$sql_satubuku = "SELECT f_judul, COUNT(*) AS dipinjam FROM t_peminjaman 
                INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id=t_detailpeminjaman.f_idpeminjaman 
                INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku=t_detailbuku.f_id 
                INNER JOIN t_buku ON t_detailbuku.f_idbuku=t_buku.f_id 
                WHERE NOT f_tanggalkembali = '0000-00-00'
                GROUP BY f_judul ORDER BY COUNT(*) DESC LIMIT 1";
$result_satubuku = $conn->query($sql_satubuku);
$satubuku = $result_satubuku->fetch_all(MYSQLI_ASSOC);

$sql_limaanggota = "SELECT f_nama, COUNT(*) AS pinjam FROM t_anggota 
                    INNER JOIN t_peminjaman ON t_anggota.f_id=t_peminjaman.f_idanggota 
                    GROUP BY f_nama ORDER BY COUNT(*) DESC LIMIT 5";
$result_limaanggota = $conn->query($sql_limaanggota);
$limaanggota = $result_limaanggota->fetch_all(MYSQLI_ASSOC);

$jumlahdata = $conn->query("SELECT f_nama FROM t_anggota 
                            INNER JOIN t_peminjaman ON t_anggota.f_id=t_peminjaman.f_idanggota
                            INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id=t_detailpeminjaman.f_idpeminjaman 
                            WHERE f_tanggalkembali ='0000-00-00' 
                            GROUP BY f_nama DESC");
$jumlahdata = $jumlahdata->num_rows;
$banyak = 5;

if (isset($_GET['p'])) {
    $p = $_GET['p'];
    $mulai = ($p * $banyak) - $banyak;
} else {
    $mulai = 0;
}

$sql_anggota = "SELECT f_nama, COUNT(*) AS kembali FROM t_anggota 
                INNER JOIN t_peminjaman ON t_anggota.f_id=t_peminjaman.f_idanggota
                INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id=t_detailpeminjaman.f_idpeminjaman 
                WHERE f_tanggalkembali ='0000-00-00' 
                GROUP BY f_nama ORDER BY COUNT(*) DESC LIMIT $mulai, $banyak";
$result_anggota = $conn->query($sql_anggota);
$anggota = $result_anggota->fetch_all(MYSQLI_ASSOC);
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Laporan</h1>
    <p class="mb-4">Tabel Laporan</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Laporan</h6>

        </div>
        <div class="card-body">
            <div class="row-lg-12 mt-4">
                <center>
                
        
  
                    <ul class="list-group list-group-flush" style="width: 100vh;">
                        <li class="list-group-item" style="width: 100%;"> Judul Buku Peminjaman Terbanyak :
                        <p></p>
                            <div class="col-md-2 mb-3">
                                <div class="">
                                    <a class="btn btn-dark" href="bukupinjamterbanyak.php" role="button"><i
                                            class="fas fa-download fa-sm text-white-50"></i>
                                        Print</a>
                                </div>
                            </div>
                            <canvas id="bukuPeminjamanChart" width="400" height="200"></canvas>
                            <br>
                        </li>

                        <br>
                        <hr style="color: black;">

                        <div class="row mt-4">
                            <div class="col-md-10 mb-3">
                                <li class="list-group-item"> Jumlah Buku Yang
                                    Belum Dikembalikan : <?= $bukupinjam ?></li>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="">
                                    <a class="btn btn-dark" href="bukubelumkembali.php" role="button"><i
                                            class="fas fa-download fa-sm text-white-50"></i> Print
                                    </a>
                                </div>
                            </div>
                            <canvas id="belumDikembalikanChart" width="400" height="200"></canvas>
</li>
                        </div>
                        <hr style="color: black;">
                        <br>


                        <hr style="color: black;">

                        <li class="list-group-item"> Anggota Yang Belum
                            Mengembalikan Buku :
                            <p></p>
                            <div class="col-md-2 mb-3">
                                <div class="">
                                    <a class="btn btn-dark" href="belumkembali.php" role="button"> <i
                                            class="fas fa-download fa-sm text-white-50"></i> Print </a>
                                </div>
                            </div>
                            <canvas id="belumKembaliChart" width="400" height="200"></canvas>


                        </li>

                        <br>
                        <hr style="color: black;">

                        <li class="list-group-item"> Anggota Yang Sering
                            Meminjam Buku :
                            <p></p>
                            <div class="col-md-2 mb-3">
                                <div class="">
                                    <a class="btn btn-dark" href="anggotaseringpinjam.php" role="button"><i
                                            class="fas fa-download fa-sm text-white-50"></i> Print </a>
                                </div>
                            </div>
                            <!-- Tambahkan elemen canvas untuk grafik -->
                             <canvas id="anggotaChart" width="400" height="200"></canvas>



                        </li>
                    </ul>
                </center>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<script>
    // Mengasumsikan $bukupinjam berisi data untuk grafik jumlah buku yang belum dikembalikan
    var bukuBelumKembaliData = <?= json_encode($bukupinjam) ?>;

    // Ekstrak label dan data dari array PHP
    var bukuBelumKembaliLabels = ["Belum Dikembalikan", "Sudah Dikembalikan"]; // Sesuaikan dengan label yang sesuai

    // Menghitung jumlah buku yang sudah dikembalikan berdasarkan tanggal pengembalian
    var bukuSudahKembali = <?= $conn->query("SELECT COUNT(f_judul) FROM t_buku INNER JOIN t_detailbuku ON t_buku.f_id=t_detailbuku.f_idbuku INNER JOIN t_detailpeminjaman ON t_detailbuku.f_id=t_detailpeminjaman.f_iddetailbuku WHERE f_status='Tersedia' AND NOT f_tanggalkembali = '0000-00-00'")->fetch_row()[0] ?>;

    var bukuBelumKembaliCountData = [bukuBelumKembaliData, bukuSudahKembali];

    // Dapatkan elemen canvas
    var belumKembaliChartCanvas = document.getElementById('belumDikembalikanChart').getContext('2d');

    // Buat grafik lingkaran (pie chart)
var belumKembaliChart = new Chart(belumKembaliChartCanvas, {
    type: 'pie',
    data: {
        labels: bukuBelumKembaliLabels,
        datasets: [{
            data: bukuBelumKembaliCountData,
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(75, 192, 192, 0.2)'], // Sesuaikan dengan warna yang sesuai
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: true, // Set ke false agar bisa mengatur lebar dan tinggi secara bebas
        responsive: true,
        radius: 200 // Sesuaikan dengan ukuran radius yang diinginkan
    }
});

</script>



<script>
    // Mengasumsikan $anggota berisi data untuk grafik anggota yang belum mengembalikan buku
    var belumKembaliData = <?= json_encode($anggota) ?>;

    var belumKembaliLabels = belumKembaliData.map(function(item) {
        return item.f_nama;
    });

    var belumKembaliCountData = belumKembaliData.map(function(item) {
        return item.kembali;
    });

    var belumKembaliChartCanvas = document.getElementById('belumKembaliChart').getContext('2d');

    var belumKembaliChart = new Chart(belumKembaliChartCanvas, {
        type: 'line',
        data: {
            labels: belumKembaliLabels,
            datasets: [{
                label: 'Jumlah Buku Belum Kembali',
                data: belumKembaliCountData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
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

<script>
    // Mengasumsikan $satubuku berisi data untuk grafik buku peminjaman terbanyak
    var bukuPeminjamanData = <?= json_encode($satubuku) ?>;

    var bukuPeminjamanLabels = bukuPeminjamanData.map(function(item) {
        return item.f_judul;
    });

    var bukuPeminjamanCountData = bukuPeminjamanData.map(function(item) {
        return item.dipinjam;
    });

    var bukuPeminjamanChartCanvas = document.getElementById('bukuPeminjamanChart').getContext('2d');

    var bukuPeminjamanChart = new Chart(bukuPeminjamanChartCanvas, {
        type: 'bar',
        data: {
            labels: bukuPeminjamanLabels,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: bukuPeminjamanCountData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
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

<script>
    // Mengasumsikan $limaanggota berisi data untuk grafik
    var anggotaData = <?= json_encode($limaanggota) ?>;

    // Ekstrak label dan data dari array PHP
    var anggotaLabels = anggotaData.map(function(item) {
        return item.f_nama;
    });

    var anggotaPinjamData = anggotaData.map(function(item) {
        return item.pinjam;
    });

    // Dapatkan elemen canvas
    var anggotaChartCanvas = document.getElementById('anggotaChart').getContext('2d');

    // Buat grafik batang
    var anggotaChart = new Chart(anggotaChartCanvas, {
        type: 'bar',
        data: {
            labels: anggotaLabels,
            datasets: [{
                label: 'Banyak Buku Dipinjam',
                data: anggotaPinjamData,
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


<?php include "footer.php"; ?>