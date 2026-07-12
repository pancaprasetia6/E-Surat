<?php include '../konek.php'; ?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(134, 7, 7, 0.1);
        border: none;
    }

    .card-header {
        background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
    }

    .table thead th {
        background: #464f58ff;
        color: white;
        border: none;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background-color: rgba(53, 0, 22, 0.05);
    }

    .btn-primary {
        background: linear-gradient(135deg, #becadaff 0%, #464f58ff 100%);
        border: none;
        border-radius: 6px;
        font-weight: 500;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(21, 114, 232, 0.3);
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .action-buttons .btn {
        padding: 6px 10px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: scale(1.1);
    }

    .badge-pemohon {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-rt {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-rw {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }

    .table-responsive {
        overflow-x: auto !important;
        overflow-y: hidden !important;
        -webkit-overflow-scrolling: touch !important;
        width: 100% !important;
    }

    .dataTables_wrapper {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
    }

    table {
        min-width: 500px !important;
    }

    .page-inner {
        padding: 20px;
    }
</style>

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0" style="color:white"><i class="fas fa-users mr-2"></i> Data User</h4>
                        <small>Manajemen data pengguna sistem</small>
                    </div>
                    <a href="?halaman=tambah_user" class="btn btn-light btn-round">
                        <i class="fa fa-plus mr-2"></i> Add User
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filter Hak Akses -->
                    <form method="GET" class="mb-3 d-flex justify-content-end align-items-center">
                        <input type="hidden" name="halaman" value="tampil_user">
                        <label for="filter" class="mr-2 mb-0"><strong>Filter Hak Akses:</strong></label>
                        <select name="filter" id="filter" class="form-control" style="width: 200px;" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <?php if ($hak_akses == 'RT' || $hak_akses == 'RW'): ?>
                                <option value="pemohon" <?= (isset($_GET['filter']) && $_GET['filter'] == 'pemohon') ? 'selected' : '' ?>>Pemohon</option>
                                <option value="RT" <?= (isset($_GET['filter']) && $_GET['filter'] == 'RT') ? 'selected' : '' ?>>RT</option>
                                <option value="RW" <?= (isset($_GET['filter']) && $_GET['filter'] == 'RW') ? 'selected' : '' ?>>RW</option>
                            <?php else: ?>
                                <option value="pemohon" <?= (isset($_GET['filter']) && $_GET['filter'] == 'pemohon') ? 'selected' : '' ?>>Pemohon</option>
                                <option value="RT" <?= (isset($_GET['filter']) && $_GET['filter'] == 'RT') ? 'selected' : '' ?>>RT</option>
                                <option value="RW" <?= (isset($_GET['filter']) && $_GET['filter'] == 'RW') ? 'selected' : '' ?>>RW</option>
                            <?php endif; ?>
                        </select>
                    </form>

                    <div class="table-responsive">
                        <table id="userTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">NIK</th>
                                    <th width="20%">Nama</th>
                                    <th width="15%">Hak Akses</th>
                                    <th width="15%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $filter_hak_akses = isset($_GET['filter']) ? $_GET['filter'] : '';

                                // Semua hak akses bisa lihat semua data user
                                $sql = "SELECT * FROM data_user WHERE 1=1";
                                if (!empty($filter_hak_akses)) {
                                    $sql .= " AND hak_akses='$filter_hak_akses'";
                                }
                                $sql .= " ORDER BY hak_akses, rt, rw, nama";

                                $query = mysqli_query($konek, $sql);

                                if (mysqli_num_rows($query) > 0) {
                                    while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                        $nik = $data['nik'];
                                        $nama = $data['nama'];
                                        $user_hak_akses = strtoupper($data['hak_akses']);
                                        $rt = $data['rt'];
                                        $rw = $data['rw'];
                                ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><strong><?= $nik; ?></strong></td>
                                            <td><strong><?= $nama; ?></strong></td>
                                            <td>
                                                <?php
                                                if ($user_hak_akses == 'PEMOHON') {
                                                    echo "<span class='badge-pemohon'>$user_hak_akses</span>";
                                                } elseif ($user_hak_akses == 'RT') {
                                                    echo "<span class='badge-rt'>$user_hak_akses</span>";
                                                } elseif ($user_hak_akses == 'RW') {
                                                    echo "<span class='badge-rw'>$user_hak_akses</span>";
                                                } else {
                                                    echo "<span class='badge badge-secondary'>$user_hak_akses</span>";
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <a href="main2.php?halaman=detail_user&nik=<?= $nik; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="Lihat Detail">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="?halaman=ubah_user&nik=<?= $nik; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit User">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <?php if ($hak_akses == 'RW' || $hak_akses == 'RT'): ?>
                                                        <button onclick="confirmDelete('<?= $nik; ?>', '<?= $nama; ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus User">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn btn-danger btn-sm" disabled data-toggle="tooltip" title="Tidak dapat menghapus user">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center py-4 text-muted'><i class='fas fa-users fa-2x mb-2'></i><br>Tidak ada data user</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "scrollX": true,
            "scrollCollapse": true,
            "autoWidth": false,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            },
            "columnDefs": [{
                "orderable": false,
                "targets": [4]
            }],
            "drawCallback": function() {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });

    function confirmDelete(nik, nama) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Anda akan menghapus user: " + nama + " (NIK: " + nik + ")",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                window.location.href = "?halaman=tampil_user&delete_nik=" + nik;
            }
        });
    }

    <?php
    if (isset($_GET['delete_nik'])) {
        $nik_to_delete = $_GET['delete_nik'];
        $sql_hapus = "DELETE FROM data_user WHERE nik='" . mysqli_real_escape_string($konek, $nik_to_delete) . "'";
        $query_hapus = mysqli_query($konek, $sql_hapus);
        if ($query_hapus) {
            echo "swal('Berhasil!', 'Data user berhasil dihapus', 'success').then(function() { 
                window.location.href = '?halaman=tampil_user" . (!empty($filter_hak_akses) ? "&filter=" . $filter_hak_akses : "") . "';
            });";
        } else {
            echo "swal('Gagal!', 'Terjadi kesalahan saat menghapus data', 'error');";
        }
    }
    ?>
</script>