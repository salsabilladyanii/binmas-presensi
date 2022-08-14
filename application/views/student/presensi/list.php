<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Presensi</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item active">Presensi List</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0">Presensi List</h4>
                        <?php if (count($presensi_list) > 0) : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr align="center">
                                            <th class="th">NAMA</th>
                                            <th class="th">TANGGAL</th>
                                            <th class="th">JAM</th>
                                            <th class="th">ABSEN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($presensi_list as $presensi) : ?>
                                            <tr>
                                                <td align="center"><?= $presensi->nama_event; ?></td>
                                                <td align="center"><?= $presensi->tgl_event; ?></td>
                                                <td align="center"><?= $presensi->dari_jam . " - " . $presensi->sampai_jam; ?></td>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <a href="<?= base_url('students/absenmasuk/') . encrypt_url($presensi->no_event); ?>" class="btn btn-primary">Masuk</a>
                                                        <a href="<?= base_url('students/absenkeluar/') . encrypt_url($presensi->no_event); ?>" class="btn btn-success">Keluar</a>
                                                        <a href="<?= base_url('students/izin/') . encrypt_url($presensi->no_event); ?>" class="btn btn-warning">Izin/Dinas</a>
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