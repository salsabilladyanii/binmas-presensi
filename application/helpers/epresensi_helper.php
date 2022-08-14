<?php

function no_event()
{
    $ci = get_instance();

    $data = $ci->db->get('event')->last_row();
    if ($data) {
        $noEvent = $data->no_event;

        // mengambil angka dari kode Produk terbesar, menggunakan fungsi substr
        // dan diubah ke integer dengan (int)
        $urutan = (int) substr($noEvent, 5, 4);

        // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
        $urutan++;

        // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
        // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
        // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG
        $huruf = "EVNT-";
        $no_event = $huruf . sprintf("%03s", $urutan);
        return $no_event;
    } else {
        return 'EVNT-001';
    }
}

function is_admin()
{
    $ci = get_instance();

    $data = [
        'email' => $ci->session->userdata('email'),
        'role' => $ci->session->userdata('role'),
    ];

    if ($data) {
        if ($data['role'] != 1) {
            redirect('eror');
        }
    } else {
        redirect('admin');
    }
}

function is_students()
{
    $ci = get_instance();

    $data = [
        'email' => $ci->session->userdata('email'),
        'role' => $ci->session->userdata('role'),
    ];

    if ($data) {
        if ($data['role'] != 2) {
            redirect('eror');
        }
    } else {
        redirect('students');
    }
}
