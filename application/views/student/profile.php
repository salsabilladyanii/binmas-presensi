<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Profile</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Students</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0"></h4>
                        <img src="<?= base_url('assets/app-assets/user/') . $siswa->gambar; ?>" alt="E-Presensi Abduloh" class="img-thumbnail">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0">Update My Profile</h4>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">NRP</label>
                                        <input type="text" name="nim" value="<?= $siswa->nim; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" name="nama_siswa" value="<?= $siswa->nama_siswa; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Kelas</label>
                                        <?php $kelas = $this->db->get('kelas')->result();
                                        foreach ($kelas as $key) : ?>
                                            <?php if ($key->kode_kelas == $siswa->kelas_siswa) : ?>
                                                <input type="text" name="kelas_siswa" value="<?= $key->nama_kelas; ?>" class="form-control" readonly>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Gender</label>
                                        <select name="jenis_kelamin" class="form-control">
                                            <option value="L">Laki- Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" value="<?= $siswa->tanggal_lahir; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" value="<?= $siswa->tempat_lahir; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <?php if ($siswa->email) : ?>
                                            <input type="email" name="email" value="<?= $siswa->email; ?>" class="form-control" readonly>
                                        <?php else : ?>
                                            <input type="email" name="email" class="form-control">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Foto</label>
                                        <input type="file" name="gambar" id="">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->
<?= $this->session->flashdata('pesan'); ?>