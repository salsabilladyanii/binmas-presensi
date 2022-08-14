<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Presensi Masuk <?= $event->nama_event; ?></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Presensi</a></li>
                        <li class="breadcrumb-item active"><?= $event->nama_event; ?></li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <?php if ($berakhir == "masih") : ?>
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h1>SCAN HERE!</h1>
                    <div class="mt-4">
                        <img src=" <?= base_url('assets/app-assets/qr/img/') . $event->qr_event; ?>">
                    </div>
                    <a href="<?= base_url('pdf/exportqr/') . encrypt_url($event->no_event); ?>" target="_blank" class="btn btn-primary mt-2 ml-auto">Export QR</a>
                </div>
            <?php else : ?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <div class="alert alert-success mb-0" role="alert">
                                    <h4 class="alert-heading mt-0 font-18">Well done!</h4>
                                    <p>Presensi Telah Berakhir</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row mt-2">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-2">Sudah Presensi</h4>
                        <div class="friends-suggestions">
                            <div class="row" id="sudah-absen">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-2">Belum Presensi</h4>
                        <div class="friends-suggestions">
                            <div class="row" id="belum-absen">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->

<?= $this->session->flashdata('pesan'); ?>

<script>
    setInterval(() => {
        const content = "<?= decrypt_url($this->uri->segment(3)); ?>"
        $.ajax({
            type: 'POST',
            data: {
                content: content
            },
            url: "<?= base_url('admin/sudah_absen') ?>",
            async: true,
            success: function(data) {
                $('#sudah-absen').html(data);
            }
        })
    }, 100);
    setInterval(() => {
        const content = "<?= decrypt_url($this->uri->segment(3)); ?>"
        $.ajax({
            type: 'POST',
            data: {
                content: content
            },
            url: "<?= base_url('admin/belum_absen_masuk') ?>",
            async: true,
            success: function(data) {
                $('#belum-absen').html(data);
            }
        })
    }, 100);
</script>