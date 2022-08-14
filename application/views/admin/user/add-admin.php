<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Tambah Admin</h4>
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
            <div class="col-md-7">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Form Tambah Admin</h3>
                        <button type="button" class="btn btn-outline-primary mt-2 mb-3 tambah-baris-admin">Tambah Baris</button>
                        <form action="" method="POST">
                            <input type="hidden" name="additional" value="additional">
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive nowrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>NAMA</th>
                                            <th>EMAIL</th>
                                            <th>PASSWORD</th>
                                            <th>OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-data-admin">
                                        <tr>
                                            <td><input type="text" name="nama_admin[]" placeholder="nama" style="border: none; background: transparent; text-align: center;" required></td>
                                            <td><input type="email" name="email[]" placeholder="email" style="border: none; background: transparent; text-align: center;" required></td>
                                            <td><input type="password" name="password[]" placeholder="password" style="border: none; background: transparent; text-align: center;" required></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="<?= base_url('admin/admlist'); ?>" class="btn btn-outline-warning mt-3">Back</a>
                                <button type=" submit" class="btn btn-outline-success mt-3 ml-1">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">WARNING!</h3>
                        <p>Pastikan untuk tidak memasukan data yang sama agar tidak terjadi error atau malfunction kedepannya</p>
                        <span class="blockquote-footer">BINMAS</span>
                    </div>
                </div>
            </div>
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>