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
                        <a href="<?= base_url('admin/addpresensi'); ?>" class="btn btn-outline-primary m-b-10">Tambah data Presensi</a>
                        <?php if (count($presensi_list) > 0) : ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th class="th">#</th>
                                            <th class="th">NO PRESENSI</th>
                                            <th class="th">NAMA</th>
                                            <th class="th">TANGGAL</th>
                                            <th class="th">JAM</th>
                                            <th class="th">OPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($presensi_list as $presensi) : ?>
                                            <tr>
                                                <td align="center"><?= $no++; ?></td>
                                                <td align="center"><?= $presensi->no_event; ?></td>
                                                <td align="center"><?= $presensi->nama_event; ?></td>
                                                <td align="center"><?= $presensi->tgl_event; ?></td>
                                                <td align="center"><?= $presensi->dari_jam . " - " . $presensi->sampai_jam; ?></td>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Absen</button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?= base_url('admin/showpresensi/') . encrypt_url($presensi->no_event); ?>">Masuk</a>
                                                            <a class="dropdown-item" href="<?= base_url('admin/showpresensikeluar/') . encrypt_url($presensi->no_event); ?>">Keluar</a>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group m-l-2">
                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?= base_url('pdf/absensi/') . encrypt_url($presensi->no_event); ?>" target="_blank">PDF</a>
                                                            <!-- <a href="javascript:void(0);" class=" dropdown-item"> Edit</a> -->
                                                            <a href="<?= base_url('admin/listpermohonan/') . encrypt_url($presensi->no_event); ?>" class=" dropdown-item"> Lihat Permohonan Izin</a>
                                                        </div>
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