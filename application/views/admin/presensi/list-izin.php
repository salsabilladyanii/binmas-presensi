<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">LIst Permohonan Izin</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/presensi'); ?>">Presensi</a></li>
                        <li class="breadcrumb-item active">Permohonan Izin</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0 mb-3">Permohonan Izin <?= $event->nama_event; ?></h4>
                        <?php if ($list_izin) : ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr align="center">
                                            <th class="th">#</th>
                                            <th class="th">NAMA</th>
                                            <th class="th">NIM</th>
                                            <th class="th">KELAS</th>
                                            <th class="th">IZIN</th>
                                            <th class="th">SUKET</th>
                                            <th class="th">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($list_izin as $izin) : ?>
                                            <tr align="center">
                                                <td><?= $no++; ?></td>
                                                <td><?= $izin->nama_siswa; ?></td>
                                                <td><?= $izin->nim_siswa; ?></td>
                                                <td><?= $izin->kelas; ?></td>
                                                <td><?= $izin->keterangan; ?></td>
                                                <td>
                                                    <a href="<?= base_url('file/suket/') . encrypt_url($izin->suket); ?>" class="btn btn-success">Unduh</a>
                                                </td>
                                                <td>
                                                    <?php if ($izin->izinkan == 0) : ?>
                                                        <a href="<?= base_url('admin/izinkan/?siswa=') . encrypt_url($izin->nim_siswa) . '&event=' . encrypt_url($event->no_event); ?>" class="badge badge-warning btn-izinkan">Pending</a>
                                                    <?php else : ?>
                                                        <span class="badge badge-success">Di Izinkan</span>
                                                    <?php endif; ?>
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