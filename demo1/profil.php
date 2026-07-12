<?php include '../konek.php'; ?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Data Profil</h4>
                        <!-- <a href="#" class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-plus"></i>
                            Add User
                        </a> -->

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Profil</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Text</label>
                                                <textarea name="text" id="" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Photo</label>
                                                <input type="file" name="poto" class="form-control"">
                                            </div>
                                    </div>
                                    <div class=" modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="simpan" class="btn btn-primary">Save changes</button>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="table-responsive">
                                <table id="add" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Text</th>
                                            <th>Poto</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $tampil = "SELECT * FROM profil";
                                        $query = mysqli_query($konek, $tampil);
                                        while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                            $text = $data['text'];
                                            $poto = $data['poto'];
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $text; ?></td>
                                                <td><img src="../dataFoto/profil/<?= $poto; ?>" width="100px" alt=""></td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="?halaman=editprofil&id=<?= $data['id_profil']; ?>" type="button" class="btn btn-link btn-primary btn-lg" data-original-title="Edit User">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>