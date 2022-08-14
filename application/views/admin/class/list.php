<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Classes</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item active">Classes</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0">Class List</h4>
                        <a href="<?= base_url('admin/addclass'); ?>" class="btn btn-outline-primary m-b-10">Tambah data Kelas</a>
                        <?php if (count($kelas_list) > 0) : ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th class="th">#</th>
                                            <th class="th">CODE</th>
                                            <th class="th">NAMA</th>
                                            <th class="th">OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($kelas_list as $kelas) : ?>
                                            <tr>
                                                <td align="center"><?= $no++; ?></td>
                                                <td align="center"><?= $kelas->kode_kelas; ?></td>
                                                <td align="center"><?= $kelas->nama_kelas; ?></td>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-edit-class" data-toggle="modal" data-kelas="<?= encrypt_url($kelas->kode_kelas); ?>" data-target="#modaleditclass"><i class="mdi mdi-cogs"></i></a>
                                                        <a href="<?= base_url('admin/delete_class/') . encrypt_url($kelas->kode_kelas); ?>" class="btn btn-danger btn-hapus"><i class="mdi mdi-trash-can-outline"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <br>
                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn-block">Tidak Ada Data</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->

<?= $this->session->flashdata('pesan'); ?>

<!-- MODAL EDIT -->
<div id="modaleditclass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditclassLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/updateclass') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modaleditclassLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body modal-body-admin">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input class="form-control" type="text" name="nama_kelas" required>
                        <input type="hidden" name="kode_kelas">
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