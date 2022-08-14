<script>
    $(document).ready(function() {
        $("#datatable").DataTable();

        $('.kelas-select2').select2({
            placeholder: 'Pilih Kelas'
        });

        // BUTTON HAPUS
        $('.btn-hapus').click(function(e) {
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Data yang akan dihapus tidak bisa dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href
                }
            })
        });
        // END BUTTON HAPUS

        // BUTTON IZINKAN
        $('.btn-izinkan').click(function(e) {
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Izinkan?',
                text: "Siswa ini akan mendapatkan izin untuk tidak mengikuti kegiatan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, izinkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href
                }
            })
        });
        // END BUTTON IZINKAN

        // TAMBAH ADMIN
        $('.tambah-baris-admin').click(function() {
            var baru = `
                <tr>
                    <td>
                        <input type="text" name="nama_admin[]" placeholder="nama" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="email" name="email[]" placeholder="email" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="password" name="password[]" placeholder="password" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs remove-baris-admin"><i class="mdi mdi-close-circle"></i></button>
                    </td>
                </tr>
           `;
            $('#tbody-data-admin').append(baru);
        });
        // END TAMBAH ADMIN

        // TAMBAH KELAS
        $('.tambah-baris-kelas').click(function() {
            var baru = `
                <tr>
                    <td>
                        <input type="text" name="kode_kelas[]" placeholder="kode kelas" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="text" name="nama_kelas[]" placeholder="Nama Kelas" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs remove-baris-kelas"><i class="mdi mdi-close-circle"></i></button>
                    </td>
                </tr>
           `;
            $('#tbody-data-kelas').append(baru);
        });
        // END TAMBAH KELAS

        // TAMBAH SISWA
        $('.tambah-baris-siswa').click(function() {
            var baru = `
                <tr>
                    <td><input type="text" name="nim[]" placeholder="Nomor Induk Siswa" style="border: none; background: transparent; text-align: center;" autocomplete="off" minlength="10" maxlength="10" required></td>
                    <td><input type="text" name="nama_siswa[]" placeholder="nama" style="border: none; background: transparent; text-align: center;" autocomplete="off" required></td>
                    <td>
                        <select name="kelas_kode[]" style="border: none; background: transparent; text-align: center;">
                            <option value="">Kelas</option>
                            <?php $kelas = $this->db->get('kelas')->result();
                            foreach ($kelas as $key) : ?>
                                <option value="<?= $key->kode_kelas; ?>"><?= $key->nama_kelas; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="jenis_kelamin[]" style="border: none; background: transparent; text-align: center;">
                            <option value="">Jenis Kelamin</option>
                            <option value="L">Laki - Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs remove-baris-siswa"><i class="mdi mdi-close-circle"></i></button>
                    </td>
                </tr>
           `;
            $('#tbody-data-siswa').append(baru);
        });
        // END TAMBAH SISWA

        // HAPUS ROW ADMIN
        $('#tbody-data-admin').on('click', 'tr td button', function() {
            $(this).parents('tr').remove();
        })
        // END HAPUS ROW ADMIN

        // HAPUS ROW KELAS
        $('#tbody-data-kelas').on('click', 'tr td button', function() {
            $(this).parents('tr').remove();
        })
        // END HAPUS ROW KELAS

        // HAPUS ROW SISWA
        $('#tbody-data-siswa').on('click', 'tr td button', function() {
            $(this).parents('tr').remove();
        })
        // END HAPUS ROW SISWA


        // AJAX UPDATE ADMIN
        $('.btn-edit-admin').click(function() {
            const email = $(this).data('admin');
            $.ajax({
                type: 'POST',
                data: {
                    email: email
                },
                dataType: "JSON",
                url: "<?= base_url('admin/ajaxupdateadmin') ?>",
                success: function(data) {
                    $.each(data, function(id_admin, nama_admin, email, password, role, date_created, is_active, gambar) {
                        $("input[name=nama_admin]").val(data.nama_admin);
                        $("input[name=email]").val(data.email);
                    })
                }
            })
        });
        // END AJAX UPDATE ADMIN

        // AJAX UPDATE KELAS
        $('.btn-edit-class').click(function() {
            const kelas = $(this).data('kelas');
            $.ajax({
                type: 'POST',
                data: {
                    kelas: kelas
                },
                dataType: "JSON",
                url: "<?= base_url('admin/ajaxupdatekelas') ?>",
                success: function(data) {
                    $.each(data, function(id_kelas, kode_kelas, nama_kelas) {
                        $("input[name=kode_kelas]").val(data.kode_kelas);
                        $("input[name=nama_kelas]").val(data.nama_kelas);
                    })
                }
            })
        });
        // END AJAX UPDATE KELAS

        // AJAX UPDATE SISWA
        $('.btn-edit-siswa').click(function() {
            const nim = $(this).data('siswa');
            $.ajax({
                type: 'POST',
                data: {
                    nim: nim
                },
                dataType: "JSON",
                url: "<?= base_url('admin/ajaxupdatestudents') ?>",
                success: function(data) {
                    $.each(data, function(id_siswa, nim, nama_siswa, kelas_siswa, jenis_kelamin, tanggal_lahir, tempat_lahir, email, password, role, is_active, gambar) {
                        $("input[name=id_siswa]").val(data.id_siswa);
                        $("input[name=nim]").val(data.nim);
                        $("input[name=nama_siswa]").val(data.nama_siswa);
                    })
                }
            })
        });
        // END AJAX UPDATE SISWA

    });
</script>