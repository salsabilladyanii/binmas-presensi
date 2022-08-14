<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Absen Keluar <br> <?= $event->nama_event; ?></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Absen Masuk</a></li>
                        <li class="breadcrumb-item active"><?= $event->nama_event; ?></li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php if ($absen_siswa) : ?>
                        <?php if ($absen_siswa->absen_masuk != 0 && $absen_siswa->absen_keluar != 0) : ?>
                            <div class="card-body">
                                <h4 class="card-title font-16 mt-0">Detail</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Waktu Absen</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>jam <?= date('H:i', $absen_siswa->absen_keluar); ?></td>
                                                <td>
                                                    <?php if ($absen_siswa->keterangan == "Selesai Sebelum Waktu") : ?>
                                                        <span class="badge badge-danger">Selesai Sebelum Waktu</span>
                                                    <?php else : ?>
                                                        <span class="badge badge-primary">Tepat Waktu</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($absen_siswa->absen_masuk != 0 && $absen_siswa->absen_keluar == 0) : ?>
                            <div class="card-body card-body-scan">
                                <h4 class="card-title font-16 mt-0">Scan Here!</h4>
                                <video id="camera" height="450"></video>
                            </div>
                        <?php endif; ?>
                        <?php if ($absen_siswa->absen_masuk == 0 && $absen_siswa->absen_keluar == 0) : ?>
                            <div class="card-body">
                                <h4 class="card-title font-16 mt-0">Detail</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Waktu Absen</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($absen_siswa->izinkan == '0') : ?>
                                                <tr align="center">
                                                    <td>-</td>
                                                    <td>
                                                        <span class="badge badge-warning">PENDING</span>
                                                    </td>
                                                </tr>
                                            <?php else : ?>
                                                <tr align="center">
                                                    <td>-</td>
                                                    <td>
                                                        <span class="badge badge-primary">IZIN</span>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="card-body card-body-scan">
                            <h4 class="card-title font-16 mt-0">Scan Here!</h4>
                            <video id="camera" height="450"></video>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->

<script>
    <?php
    $data1 = decrypt_url($this->uri->segment(3));
    $data2 = $this->session->userdata('nim');
    $this->db->select("*");
    $this->db->from('absen');
    $this->db->join('event', 'event.no_event = absen.no_event');
    $this->db->where('absen.no_event', $data1);
    $this->db->where('absen.nim_siswa', $data2);
    $hasil = $this->db->get()->row(); ?>
    <?php if ($hasil->absen_masuk != 0 && $hasil->absen_keluar == 0) : ?>
        let scanner = new Instascan.Scanner({
            video: document.getElementById("camera"),
            mirror: false,
            width: 450,
            height: 300
        });
        // let resultado = document.getElementById("qrcode");
        scanner.addListener("scan", function(content) {
            // resultado.innerText = content;
            scanner.stop();
            $.ajax({
                type: 'POST',
                data: {
                    content: content
                },
                url: "<?= base_url('students/absen_keluar/') ?>",
                async: true,
                success: function() {
                    Swal.fire({
                        title: 'Berhasil',
                        text: "Anda sudah mengisi presensi",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })

                }
            });
            scanner.stop();

        });
        Instascan.Camera.getCameras()
            .then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[cameras.length - 1]);
                } else {
                    resultado.innerText = "No cameras found.";
                }
            })
            .catch(function(e) {
                resultado.innerText = e;
            });
    <?php endif; ?>
</script>