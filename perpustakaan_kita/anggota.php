<?php
include "header.php";
require "../config.php";
$conn = db_connect();

// Fetch data from t_anggota table
$sql = "SELECT * FROM t_anggota";
$result = $conn->query($sql);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Anggota</h1>
    <p class="mb-4">Tabel Anggota</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Anggota</h6>
            <!-- Button to trigger modal for adding a member -->
            <button class="btn btn-success btn-icon-split btn-sm float-right" data-toggle="modal"
                data-target="#addMemberModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Anggota</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through the result set and output data
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['f_id'] . "</td>";
                            echo "<td>" . $row['f_nama'] . "</td>";
                            echo "<td>" . $row['f_username'] . "</td>";
                            echo "<td>" . $row['f_tempatlahir'] . "</td>";
                            echo "<td>" . $row['f_tanggallahir'] . "</td>";
                            echo "<td>" . $row['created_at'] . "</td>";
                            echo "<td>" . $row['updated_at'] . "</td>";
                            echo "<td class='d-flex'>";
                            // Button to trigger modal for editing a member
                            echo "<button class='btn btn-warning mx-3' data-toggle='modal' data-target='#editMemberModal' data-id='" . $row['f_id'] . "' data-nama='" . $row['f_nama'] . "' data-username='" . $row['f_username'] . "' data-tempatlahir='" . $row['f_tempatlahir'] . "' data-tanggallahir='" . $row['f_tanggallahir'] . "'>";
                            echo "<i class='fas fa-edit'></i>Edit";
                            echo "</button>";
                            // Button to trigger modal for deleting a member
                            echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteMemberModal' data-id='" . $row['f_id'] . "'>";
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

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Tambah Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add Member Form -->
                <form action="anggota_crud.php" id="addMemberForm" method="post">
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="tempatlahir">Tempat Lahir:</label>
                        <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggallahir">Tanggal Lahir:</label>
                        <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Member Modal -->
<div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog" aria-labelledby="editMemberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMemberModalLabel">Ubah Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Member Form -->
                <form action="anggota_crud.php" id="editMemberForm" method="post">
                    <input type="hidden" id="editMemberId" name="id">
                    <div class="form-group">
                        <label for="editNama">Nama:</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="editUsername">Username:</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="editPassword">Password:</label>
                        <input type="password" class="form-control" id="editPassword" name="password">
                    </div>
                    <div class="form-group">
                        <label for="editTempatlahir">Tempat Lahir:</label>
                        <input type="text" class="form-control" id="editTempatlahir" name="tempatlahir" required>
                    </div>
                    <div class="form-group">
                        <label for="editTanggallahir">Tanggal Lahir:</label>
                        <input type="date" class="form-control" id="editTanggallahir" name="tanggallahir" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript to set values when the Edit modal is triggered
$('#editMemberModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var memberId = button.data('id'); // Extract member ID from data-id attribute
    var memberNama = button.data('nama'); // Extract member name from data-nama attribute
    var memberUsername = button.data('username'); // Extract member username from data-username attribute
    var memberTempatlahir = button.data('tempatlahir'); // Extract member tempatlahir from data-tempatlahir attribute
    var memberTanggallahir = button.data('tanggallahir'); // Extract member tanggallahir from data-tanggallahir attribute

    // Update the modal's content
    var modal = $(this);
    modal.find('#editMemberId').val(memberId);
    modal.find('#editNama').val(memberNama);
    modal.find('#editUsername').val(memberUsername);
    modal.find('#editTempatlahir').val(memberTempatlahir);
    modal.find('#editTanggallahir').val(memberTanggallahir);
});
</script>

<!-- Delete Member Modal -->
<div class="modal fade" id="deleteMemberModal" tabindex="-1" role="dialog" aria-labelledby="deleteMemberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMemberModalLabel">Hapus Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Delete Member Form -->
                <form action="anggota_crud.php" id="deleteMemberForm" method="post">
                    <input type="hidden" id="deleteMemberId" name="id">
                    <p>Anda yakin ingin menghapus anggota ini?</p>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript to set values when the Edit modal is triggered
$('#deleteMemberModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var memberId = button.data('id'); // Extract member ID from data-id attribute
   

    // Update the modal's content
    var modal = $(this);
    modal.find('#deleteMemberId').val(memberId);
});
</script>