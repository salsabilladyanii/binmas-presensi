<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Admin List</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admin List</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Admin Data List</h3>
                        <a href="<?= base_url('admin/addadmin'); ?>" class="btn btn-outline-primary m-b-10">Tambah data Admin</a>
                        <?php if (count($admin_list) > 0) : ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th class="th">#</th>
                                            <th class="th">NAMA</th>
                                            <th class="th">EMAIL</th>
                                            <th class="th">DATE CREATED</th>
                                            <th class="th">ACTIVE</th>
                                            <th class="th">IMAGE</th>
                                            <th class="th">OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($admin_list as $admin) : ?>
                                            <tr>
                                                <td align="center"><?= $no++; ?></td>
                                                <td align="center"><?= $admin->nama_admin; ?></td>
                                                <td align="center"><?= $admin->email; ?></td>
                                                <td align="center"><?= date('d-M-Y', $admin->date_created); ?></td>
                                                <td align="center">
                                                    <?php if ($admin->is_active == 1) : ?>
                                                        <span class="badge badge-pill badge-primary">Yes</span>
                                                    <?php else : ?>
                                                        <span class="badge badge-pill badge-danger">No</span>
                                                    <?php endif ?>
                                                </td>
                                                <td><?= $admin->gambar; ?></td>
                                                <td align="center">
                                                    <?php if ($admin->email == $this->session->userdata('email')) : ?>
                                                        <button type="button" class="btn btn-primary">You</button>
                                                    <?php else : ?>
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0);" class="btn btn-success btn-edit-admin" data-toggle="modal" data-admin="<?= encrypt_url($admin->email); ?>" data-target="#modaleditadmin"><i class="mdi mdi-cogs"></i></a>
                                                            <a href="<?= base_url('admin/delete/') . encrypt_url($admin->email); ?>" class="btn btn-danger btn-hapus"><i class="mdi mdi-trash-can-outline"></i></a>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light">Tidak Da Data</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>
<?= $this->session->flashdata('pesan'); ?>

<!-- MODAL EDIT -->
<div id="modaleditadmin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditadminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/updateadmin') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modaleditadminLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body modal-body-admin">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input class="form-control" type="text" name="nama_admin">
                        <input type="hidden" name="email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- MODAL EDIT -->