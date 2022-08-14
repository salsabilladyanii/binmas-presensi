<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">PEGAWAI List</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">PEGAWAI List</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">PEGAWAI Data List</h3>
                        <a href="<?= base_url('admin/addstudent'); ?>" class="btn btn-outline-primary m-b-10">Tambah data Pegawai</a>
                        <?php if (count($siswa_list) > 0) : ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive">
                                    <thead>
                                        <tr>
                                            <th class="th">#</th>
                                            <th class="th">NRP</th>
                                            <th class="th">NAMA</th>
                                            <th class="th">KELAS</th>
                                            <th class="th">JK</th>
                                            <th class="th">EMAIL</th>
                                            <th class="th">ACTIVE</th>
                                            <th class="th">IMAGE</th>
                                            <th class="th">OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($siswa_list as $siswa) : ?>
                                            <tr>
                                                <td align="center"><?= $no++; ?></td>
                                                <td align="center"><?= $siswa->nim; ?></td>
                                                <td align="center"><?= $siswa->nama_siswa; ?></td>
                                                <td align="center">
                                                    <?php $kelas = $this->db->get('kelas')->result();
                                                    foreach ($kelas as $key) : ?>
                                                        <?php if ($key->kode_kelas == $siswa->kelas_siswa) : ?>
                                                            <?= $key->nama_kelas; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td align="center"><?= $siswa->jenis_kelamin; ?></td>
                                                <td align="center"><?= $siswa->email; ?></td>
                                                <td align="center">
                                                    <?php if ($siswa->is_active == 1) : ?>
                                                        <span class="badge badge-pill badge-primary">Yes</span>
                                                    <?php else : ?>
                                                        <span class="badge badge-pill badge-danger">No</span>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <img src="<?= base_url('assets/app-assets/user/') . $siswa->gambar; ?>" alt="" class="rounded-circle thumb-sm">
                                                </td>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-edit-siswa" data-toggle="modal" data-siswa="<?= encrypt_url($siswa->nim); ?>" data-target="#modaleditsiswa"><i class="mdi mdi-cogs"></i></a>
                                                        <a href="<?= base_url('admin/delete_student/') . encrypt_url($siswa->nim); ?>" class="btn btn-danger btn-hapus"><i class="mdi mdi-trash-can-outline"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <br>
                            <a href="javascript:void(0);" class="btn btn-danger btn-block waves-effect waves-light">Tidak Ada Data</a>
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
<div id="modaleditsiswa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditsiswaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/updatestudents') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modaleditsiswaLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body modal-body-admin">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="">nrp</label>
                                <input class="form-control" type="text" name="nim">
                                <input type="hidden" name="id_siswa">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input class="form-control" type="text" name="nama_siswa">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="">KELAS</label>
                                <select name="kelas_siswa" class="form-control">
                                    <option value="">Kelas</option>
                                    <?php $kelas = $this->db->get('kelas')->result();
                                    foreach ($kelas as $key) : ?>
                                        <option value=" <?= $key->kode_kelas; ?>"><?= $key->nama_kelas; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="">GENDER</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">AKTIF</label>
                        <select name="is_active" class="form-control">
                            <option value="1">YES</option>
                            <option value="0">NO</option>
                        </select>
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