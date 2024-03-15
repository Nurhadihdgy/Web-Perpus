<?php
include "header.php";
require "../config.php";
$conn = db_connect();


// Fetch data from t_kategori table
$sql = "SELECT * FROM t_kategori";
$result = $conn->query($sql);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Kategori</h1>
    <p class="mb-4">Tabel Kategori</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kategori</h6>
            <!-- Button to trigger modal for adding a category -->
            <button class="btn btn-success btn-icon-split btn-sm float-right" data-toggle="modal"
                data-target="#addCategoryModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Kategori</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through the result set and output data
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['f_id'] . "</td>";
                            echo "<td>" . $row['f_kategori'] . "</td>";
                            echo "<td>" . $row['created_at'] . "</td>";
                            echo "<td>" . $row['updated_at'] . "</td>";
                            echo "<td>";
                            // Button to trigger modal for editing a category
                            echo "<button class='btn btn-warning mx-3' data-toggle='modal' data-target='#editCategoryModal' data-id='" . $row['f_id'] . "' data-editkategori='" . $row['f_kategori'] . "'>";
                            echo "<i class='fas fa-edit'></i>Edit";
                            echo "</button>";
                            // Button to trigger modal for deleting a category
                            echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteCategoryModal' data-hapusid='" . $row['f_id'] . "'>";
                            echo "<i class='fas fa-trash'></i>Delete";
                            echo "</button>";
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

<?php include "footer.php"; ?>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add Category Form -->
                <form action="kategori_crud.php" id="addCategoryForm" method="post">
                    <div class="form-group">
                        <label for="kategori">Kategori:</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Ubah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Category Form -->
                <form action="kategori_crud.php" id="editCategoryForm" method="post">
                    <div class="form-group">
                        <label for="editKategori">Kategori Baru:</label>
                        <input type="text" class="form-control" id="editKategori" name="editkategori" required>
                    </div>
                    <input type="hidden" id="editCategoryId" name="id">
                    <button type="submit" class="btn btn-warning" id="btnSimpanPerubahan">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

// JavaScript to set values when the Edit modal is fully shown
$('#editCategoryModal').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var categoryId = button.data('id'); // Extract category ID from data-id attribute
    var categoryKategori = button.data('editkategori'); // Extract category name from data-kategori attribute

    // Update the modal's content
    var modal = $(this);
    modal.find('#editKategori').val(categoryKategori);
    modal.find('#editCategoryId').val(categoryId);
});

// JavaScript to handle clear values when the Edit modal is closed
$('#editCategoryModal').on('hidden.bs.modal', function (event) {
    var modal = $(this);
    modal.find('#editKategori').val('');
    modal.find('#editCategoryId').val('');
});



</script>





<!-- Delete Category Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Hapus Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Delete Category Form -->
                <form action="kategori_crud.php" id="deleteCategoryForm" method="post">
                    <input type="hidden" id="deleteCategoryId" name="hapusid">
                    <p>Anda yakin ingin menghapus kategori ini?</p>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // JavaScript to handle delete confirmation and send data
    $('#deleteCategoryModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var CategoryId = button.data('hapusid'); // Extract Category ID from data-hapusid attribute

        // Update the modal's content
        var modal = $(this);
        modal.find('#deleteCategoryId').val(CategoryId);
    });

   
</script>

