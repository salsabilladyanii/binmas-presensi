<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>E-Presensi</title>
    <meta content="Aplikasi Presensi Berbasis Website" name="description" />
    <meta content="Abduloh Malela" name="author" />
    <link rel="shortcut icon" href="<?= base_url('assets/img/'); ?>rb.png">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>../plugins/morris/morris.css">

    <link href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>assets/css/style.css" rel="stylesheet" type="text/css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- SWAL -->
    <script src="<?= base_url('assets/app-assets/template/presensi-abdul/plugins/swal/sweetalert2.all.js'); ?>"></script>

    <!-- DataTables -->
    <link href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Select 2 -->
    <link href="<?= base_url('assets/app-assets/template/presensi-abdul/horizontal/'); ?>../plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <script src="<?= base_url('assets/app-assets/qr'); ?>/instascan.min.js"></script>
    <style>
        #camera {
            position: relative;
        }

        .card-body-scan::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 40%;
            left: 0;
            bottom: 0;
            background: #fff;
            z-index: 999;
        }
    </style>
</head>

<body>