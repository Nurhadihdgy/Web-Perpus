<?php
include "header.php";
require "../config.php";
$conn = db_connect();

// Fetch data from t_buku and t_kategori tables using INNER JOIN
$sql = "SELECT t_buku.f_id, t_buku.f_idkategori, t_kategori.f_kategori, t_buku.f_judul, t_buku.f_gambar, t_buku.f_pengarang, t_buku.f_penerbit, t_buku.f_deskripsi
        FROM t_buku 
        INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id";
$result = $conn->query($sql);

?>



<!-- Begin Page Content -->
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Buku</h1>
    <p class="mb-4">Tabel Buku</p>
   

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Buku</h6>
            
            <!-- Button to trigger modal for adding a book -->
            <button class="btn btn-success btn-icon-split btn-sm float-right" data-toggle="modal"
                data-target="#addBookModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Buku</span>
            </button>
        </div>
        <div class="card-body">
            <!-- Book Cards -->
    <div class="row">
        <?php
        // Loop through the result set and output data in cards
        while ($row = $result->fetch_assoc()) {
            echo "<div class='col-xl-4 col-md-6 mb-4'>";
            echo "<div class='card border-left-info shadow h-100 py-2'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $row['f_judul'] . "</h5>";
            echo "<h6 class='card-subtitle mb-2 text-muted'>" . $row['f_kategori'] . "</h6>";
            echo "<img style='height:200px;' src='img/" . $row['f_gambar'] . "' alt='Gambar Buku' class='img-fluid mb-3'>";
            echo "<p class='card-text'>Pengarang: " . $row['f_pengarang'] . "</p>";
            echo "<p class='card-text'>Penerbit: " . $row['f_penerbit'] . "</p>";
             // Kolom Stok
echo "<td>";
$eksemplar = $conn->query("SELECT COUNT(*) as jumlah FROM t_detailbuku WHERE f_status='Tersedia' AND f_idbuku = " . $row['f_id']);
$eksemplar = $eksemplar->fetch_assoc();
echo "<nav aria-label='stock'>";
echo "<ul class='pagination'>";
// Disable the "Kurang" button if the stock is equal to 1
$disableKurang = ($eksemplar['jumlah'] == 1) ? 'disabled' : '';
echo "<li class='page-item'><a class='page-link' href='#'>Stok : " . $eksemplar['jumlah'] . "</a></li>";
echo "</ul>";
echo "</nav>";
echo "</td>";
            echo "<div class='d-flex justify-content-between align-items-center'>";
            
            // Button to trigger modal for updating a book
            echo "<button class='btn btn-warning' data-toggle='modal' data-target='#updateBookModal' 
                  data-id='" . $row['f_id'] . "' data-idkategori='" . $row['f_idkategori'] . "' 
                  data-judul='" . $row['f_judul'] . "' data-gambar='" . $row['f_gambar'] . "' 
                  data-pengarang='" . $row['f_pengarang'] . "' data-penerbit='" . $row['f_penerbit'] . "' 
                  data-deskripsi='" . $row['f_deskripsi'] . "'>Ubah</button>";
                  
            // Button to trigger modal for deleting a book
            echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteBookModal' 
                  data-hapusid='" . $row['f_id'] . "'>Hapus</button>";
                  
            // Button to trigger modal for viewing details of a book
           // Button to trigger modal for viewing details of a book
echo "<button class='btn btn-primary view-details-btn' data-toggle='modal' data-target='#viewDetailsModal' 
data-id='" . $row['f_id'] . "'>Lihat Detail</button>";


            echo "</div>"; // .d-flex
            echo "</div>"; // .card-body
            echo "</div>"; // .card
            echo "</div>"; // .col
        }
        ?>
    </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- style untuk modal -->
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<?php include "footer.php"; ?>

<!-- View Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailsModalLabel">Detail Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="book-details-content">
                    <!-- Content will be dynamically populated using JavaScript -->
                </div>
                
                <!-- Add Stock Form -->
<form id="addStockForm">
    <input type="hidden" name="bookId" id="bookId" value="">
    <div class="form-group">
        <label for="stockQuantity">Tambah Stok</label>
        <input type="number" class="form-control" value="1" id="stockQuantity" name="stockQuantity" required>
    </div>
    <div class="form-group">
        <label for="stockDate">Tanggal Penambahan</label>
        <input type="date" class="form-control" id="stockDate" name="stockDate" required>
    </div>
    <button type="submit" class="btn btn-success">Tambah Stok</button>
</form>

            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle details modal content and add stock functionality
// JavaScript to handle details modal content and add stock functionality
$('.view-details-btn').on('click', function () {
    var bookId = $(this).data('id');
    $.ajax({
        type: 'POST',
        url: 'buku_crud.php',
        data: { bookId: bookId },
        dataType: 'json',
        success: function (data) {
            if (data) {
                // Dynamically populate modal content
                $('#viewDetailsModal .modal-title').text('Detail Buku: ' + data.f_judul);
                var modalContent = "<img style='height:100px;' src='img/" + data.f_gambar + "' alt='Gambar Buku' class='img-fluid mb-3'>";
                modalContent += "<p>Pengarang: " + data.f_pengarang + "</p>";
                modalContent += "<p>Penerbit: " + data.f_penerbit + "</p>";
                modalContent += "<p>Deskripsi: " + data.f_deskripsi + "</p>";
                modalContent += "<p>Tanggal Ditambahkan : " + data.created_at + "</p>";
                modalContent += "<p>Terakhir Diubah : " + data.updated_at + "</p>";
                $('#viewDetailsModal .book-details-content').html(modalContent);

                // Set book ID in the form for adding stock
                $('#bookId').val(bookId);
                
                // Show the modal
                $('#viewDetailsModal').modal('show');
            } else {
                // Handle error if data is not received
                $('#viewDetailsModal .modal-title').text('Detail Buku: Not Found');
                $('#viewDetailsModal .book-details-content').html('Failed to fetch book details.');
            }
        },
        error: function () {
            // Handle AJAX error if needed
            console.error('Failed to fetch book details.');
        }
    });
});

// JavaScript to handle add stock form submission
$('#addStockForm').submit(function (event) {
    // Prevent the default form submission
    event.preventDefault();

    // Get the form data
    var formData = $(this).serialize();

    // Send an AJAX request to add stock
    $.ajax({
        url: 'add_stock.php',
        type: 'post',
        data: formData,
        success: function(response){
          location.reload();
        }
    });
});

</script>







<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Tambah Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add Book Form -->
                <form action="buku_crud.php" id="addBookForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="idkategori">ID Kategori:</label>
                        <select class="form-control" id="idkategori" name="idkategori" required>
                            <?php
                            // Fetch data from t_kategori table
                            $kategoriSql = "SELECT * FROM t_kategori";
                            $kategoriResult = $conn->query($kategoriSql);

                            // Output options for select
                            while ($kategoriRow = $kategoriResult->fetch_assoc()) {
                                echo "<option value='" . $kategoriRow['f_id'] . "'>" . $kategoriRow['f_kategori'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="judul">Judul:</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>

                    <div class="form-group">
                        <label for="gambar">Gambar:</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" required>
                    </div>

                    <div class="form-group">
                        <label for="pengarang">Pengarang:</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                    </div>

                    <div class="form-group">
                        <label for="penerbit">Penerbit:</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi:</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="stok">Stok:</label>
                        <input type="number" class="form-control" value="1" id="stok" name="stok" required>
                    </div>

                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Book Modal -->
<div class="modal fade" id="updateBookModal" tabindex="-1" role="dialog" aria-labelledby="updateBookModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBookModalLabel">Ubah Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Update Book Form -->
                <form action="buku_crud.php" id="updateBookForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="updateBookId" name="id">
                    <div class="form-group">
                        <label for="updateIdkategori">ID Kategori:</label>
                        <select class="form-control" id="updateIdkategori" name="idkategori" required>
                            <?php
                            // Fetch data from t_kategori table
                            $kategoriSql = "SELECT * FROM t_kategori";
                            $kategoriResult = $conn->query($kategoriSql);

                            // Output options for select
                            while ($kategoriRow = $kategoriResult->fetch_assoc()) {
                                echo "<option value='" . $kategoriRow['f_id'] . "'>" . $kategoriRow['f_kategori'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="updateJudul">Judul:</label>
                        <input type="text" class="form-control" id="updateJudul" name="judul" required>
                    </div>

                    <div class="form-group">
                        <label for="updateGambar">Gambar:</label>
                        <input type="file" class="form-control" id="updateGambar" name="gambar">
                    </div>

                    <div class="form-group">
                        <label for="updatePengarang">Pengarang:</label>
                        <input type="text" class="form-control" id="updatePengarang" name="pengarang" required>
                    </div>

                    <div class="form-group">
                        <label for="updatePenerbit">Penerbit:</label>
                        <input type="text" class="form-control" id="updatePenerbit" name="penerbit" required>
                    </div>

                    <div class="form-group">
                        <label for="updateDeskripsi">Deskripsi:</label>
                        <textarea class="form-control" id="updateDeskripsi" name="deskripsi" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    // JavaScript to set values when the Update Book modal is shown
$('#updateBookModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var bookId = button.data('id'); // Extract book ID from data-id attribute
    var bookIdkategori = button.data('idkategori');
    var bookJudul = button.data('judul');
    var bookPengarang = button.data('pengarang');
    var bookPenerbit = button.data('penerbit');
    var bookDeskripsi = button.data('deskripsi');

    // Update the modal's content
    var modal = $(this);
    modal.find('#updateBookId').val(bookId);
    modal.find('#updateIdkategori').val(bookIdkategori);
    modal.find('#updateJudul').val(bookJudul);
    modal.find('#updatePengarang').val(bookPengarang);
    modal.find('#updatePenerbit').val(bookPenerbit);
    modal.find('#updateDeskripsi').val(bookDeskripsi);
});

// JavaScript to handle clear values when the Update Book modal is closed
$('#updateBookModal').on('hidden.bs.modal', function (event) {
    var modal = $(this);
    modal.find('#updateBookId').val('');
    modal.find('#updateIdkategori').val('');
    modal.find('#updateJudul').val('');
    modal.find('#updatePengarang').val('');
    modal.find('#updatePenerbit').val('');
    modal.find('#updateDeskripsi').val('');
});

// JavaScript to handle update form submission
$('#btnUpdateBook').click(function () {
    // Get the form data
    var formData = $('#updateBookForm').serialize();

    // Send an AJAX request to update the book
    $.ajax({
        url: 'buku_crud.php',
        type: 'post',
        data: formData,
        success: function(response){
            // Reload the page or update the specific table row if needed
            location.reload();
        }
    });
});

</script>



<!-- Delete Book Modal -->
<div class="modal fade" id="deleteBookModal" tabindex="-1" role="dialog" aria-labelledby="deleteBookModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBookModalLabel">Hapus Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Delete Book Form -->
                <form id="deleteBookForm" method="post" action="buku_crud.php">
                    <input type="hidden" id="deleteBookId" name="hapusid">
                    <p>Anda yakin ingin menghapus buku ini?</p>
                    <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle delete confirmation and send data
    $('#deleteBookModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var bookId = button.data('hapusid'); // Extract book ID from data-hapusid attribute

        // Update the modal's content
        var modal = $(this);
        modal.find('#deleteBookId').val(bookId);
    });

    // JavaScript to handle delete form submission
    
</script>



