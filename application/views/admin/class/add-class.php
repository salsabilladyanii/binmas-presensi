<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Tambah Pangkat</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/admlist'); ?>">Admin</a></li>
                        <li class="breadcrumb-item active">Add Admin</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Form Tambah Pangkat</h3>
                        <button type="button" class="btn btn-outline-primary mt-2 mb-3 tambah-baris-kelas">Tambah Baris</button>
                        <form action="" method="POST">
                            <input type="hidden" name="additional" value="additional">
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive nowrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>KODE</th>
                                            <th>NAMA</th>
                                            <th>OPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-data-kelas">
                                        <tr>
                                            <td><input type="text" name="kode_kelas[]" placeholder="kode " style="border: none; background: transparent; text-align: center;" autocomplete="off" required></td>
                                            <td><input type="text" name="nama_kelas[]" placeholder="Nama " style="border: none; background: transparent; text-align: center;" autocomplete="off" required></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="<?= base_url('admin/classes'); ?>" class="btn btn-outline-warning mt-3">Back</a>
                                <button type="submit" class="btn btn-outline-success mt-3 ml-1">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card m-b-30">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>