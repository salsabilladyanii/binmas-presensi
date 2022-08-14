<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Tambah Presensi</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/presensi'); ?>">Presensi</a></li>
                        <li class="breadcrumb-item active">Add Presensi</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Form Tambah Presensi</h3>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">No Event</label>
                                        <input type="text" name="no_event" value="<?= no_event(); ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" name="nama_event" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Tanggal</label>
                                        <input type="date" name="tgl_event" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Jam Mulai</label>
                                        <input type="time" name="dari_jam" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Jam Selesai</label>
                                        <input type="time" name="sampai_jam" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= base_url('admin/presensi'); ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">WARNING!</h3>
                        <span class="blockquote-footer">Abduloh Malela</span>
                    </div>
                </div>
            </div> -->
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>