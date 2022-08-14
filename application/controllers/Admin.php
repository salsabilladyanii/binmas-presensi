<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Admin_Model', 'admin');
        $this->load->model('Siswa_Model', 'siswa');
        $this->load->model('Kelas', 'kelas');
        $this->load->model('Presensi', 'presensi');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        is_admin();
    }

    public function index()
    {
        $data['total_students'] = count($this->db->get('siswa')->result());
        $data['total_classes'] = count($this->db->get('kelas')->result());
        $data['total_events'] = count($this->db->get('event')->result());
        $data['total_admin'] = count($this->db->get('admin')->result());

        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/admin', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function profile()
    {
        $this->form_validation->set_rules('nama_admin', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/navbar/admin', $data);
            $this->load->view('admin/profile', $data);
            $this->load->view('templates/footer');
        } else {

            if ($_FILES['gambar']['name']) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg|PNG|GIF|JPG|JPEG';
                $config['max_size']     = '5048';
                $config['upload_path'] = './assets/app-assets/user/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')) {
                    $old_image = $data['admin']->gambar;
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . '/assets/app-assets/user/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $data = [
                        'nama_admin' => $this->input->post('nama_admin'),
                        'gambar' => $new_image
                    ];

                    $this->db->where('email', $this->input->post('email'));
                    $sql = $this->db->update('admin', $data);

                    if ($sql) {
                        $this->session->set_flashdata('pesan', '
                            <script>
                                Swal.fire(
                                    "Berhasil!",
                                    "Data Berhasil Di Update",
                                    "success"
                                );
                            </script>
                        ');
                        redirect('admin/profile');
                    }
                } else {
                    echo $this->upload->display_errors();
                }
            } else {
                $data = [
                    'nama_admin' => $this->input->post('nama_admin'),
                ];

                $this->db->where('email', $this->input->post('email'));
                $sql = $this->db->update('admin', $data);

                if ($sql) {
                    $this->session->set_flashdata('pesan', '
                    <script>
                        Swal.fire(
                            "Berhasil!",
                            "Data Berhasil Di Update",
                            "success"
                        );
                    </script>
                ');
                    redirect('admin/profile');
                }
            }
        }
    }

    // ========== ADMIN ==========

    // HALAMAN DATA ADMIN
    public function admlist()
    {
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();
        $data['admin_list'] = $this->admin->getlist();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/admin', $data);
        $this->load->view('admin/user/admin', $data);
        $this->load->view('templates/footer');
    }

    // HALAMAN TAMBAH DATA ADMIN
    public function addadmin()
    {
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();
        // SET FORM VALIDATION
        $this->form_validation->set_rules('additional', 'Additional', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header');
            $this->load->view('templates/navbar/admin', $data);
            $this->load->view('admin/user/add-admin');
            $this->load->view('templates/footer');
        } else {
            // Ambil data yang dikirim dari form
            $nama_admin = $this->input->post('nama_admin'); // Ambil data nama_admin dan masukkan ke variabel nama_admin
            $data_admin = array();

            $index = 0; // Set index array awal dengan 0
            foreach ($nama_admin as $nama) { // Kita buat perulangan berdasarkan nama_admin sampai data terakhir
                array_push($data_admin, array(
                    'nama_admin' => $this->input->post('nama_admin', true)[$index],
                    'email' => $this->input->post('email', true)[$index],
                    'password' => password_hash($this->input->post('password')[$index], PASSWORD_DEFAULT),
                    'role' => 1,
                    'date_created' => time(),
                    'is_active' => 1,
                    'gambar' => "default.jpg"
                ));

                $index++;
            }

            // var_dump($data_admin);
            // die;

            $sql = $this->admin->insert_bulk($data_admin);

            // Cek apakah query insert nya sukses atau gagal
            if ($sql) { // Jika sukses
                $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Disimpan!',
                        })
                </script>
                ");
                redirect('admin/admlist');
            } else { // Jika gagal
                $this->session->set_flashdata('pesan', "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal Disimpan!',
                                })
                        </script>
                        ");
                redirect('admin/admlist');
            }
        }
    }

    // UPDATE DATA ADMIN
    public function updateadmin()
    {
        $data = [
            'nama_admin' => $this->input->post('nama_admin', true),
        ];

        $this->db->where('email', $this->input->post('email'));
        $this->db->update('admin', $data);

        $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Di Update!',
                        })
                </script>
                ");
        redirect('admin/admlist');
    }

    //  AJAX UPDATE DATA ADMIN
    public function ajaxupdateadmin()
    {
        if ($this->input->is_ajax_request()) {
            $email = decrypt_url($this->input->post('email'));
            $admin = $this->db->get_where('admin', ['email' => $email])->row();
            echo json_encode($admin);
        } else {
            redirect('eror');
        }
    }

    // HAPUS DATA ADMIN
    public function delete($data)
    {
        $email = decrypt_url($data);

        $this->db->delete('admin', ['email' => $email]);

        $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Dihapus!',
                        })
                </script>
                ");
        redirect('admin/admlist');
    }

    // ========== END ADMIN =============

    // ========== STUDENT ============


    // Student list
    public function students()
    {
        // $this->db->select("*");
        // $this->db->from('siswa');
        // $this->db->join('kelas', 'kelas.kode_kelas = siswa.kelas_siswa');
        // $this->db->order_by('id_siswa', 'ASC');
        $data['siswa_list'] = $this->db->get('siswa')->result();
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        // var_dump($data['siswa_list']);
        // die;

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/admin', $data);
        $this->load->view('admin/user/students', $data);
        $this->load->view('templates/footer');
    }

    // ADD STUDENTS
    public function addstudent()
    {
        $data['siswa_list'] = $this->siswa->getsiswa();
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $this->form_validation->set_rules('additional', 'Additional', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/navbar/admin', $data);
            $this->load->view('admin/user/add-students', $data);
            $this->load->view('templates/footer');
        } else {
            // Ambil data yang dikirim dari form
            $no_induk = $this->input->post('nim');
            $data_siswa = array();

            $index = 0; // Set index array awal dengan 0
            foreach ($no_induk as $nim) {

                array_push($data_siswa, array(
                    'nim' => $this->input->post('nim', true)[$index],
                    'nama_siswa' => $this->input->post('nama_siswa', true)[$index],
                    'kelas_siswa' => $this->input->post('kelas_kode', true)[$index],
                    'jenis_kelamin' => $this->input->post('jenis_kelamin', true)[$index],
                    // 'tanggal_lahir' => $this->input->post('tanggal_lahir', true)[$index],
                    // 'tempat_lahir' => $this->input->post('tempat_lahir', true)[$index],
                    // 'email' => $this->input->post('email', true)[$index],
                    'password' => password_hash($this->input->post('nim', true)[$index], PASSWORD_DEFAULT),
                    'role' => 2,
                    'date_created' => time(),
                    'is_active' => 1,
                    'gambar' => "default.jpg"
                ));

                $index++;
            }


            $sql = $this->siswa->insert_bulk($data_siswa);

            // Cek apakah query insert nya sukses atau gagal
            if ($sql) { // Jika sukses
                $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Disimpan!',
                        })
                </script>
                ");
                redirect('admin/students');
            } else { // Jika gagal
                $this->session->set_flashdata('pesan', "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal Disimpan!',
                                })
                        </script>
                        ");
                redirect('admin/students');
            }
        }
    }

    // HAPUS SISWA
    public function delete_student($data)
    {
        $nim = decrypt_url($data);

        $sql = $this->db->delete('siswa', ['nim' => $nim]);

        // Cek apakah query insert nya sukses atau gagal
        if ($sql) { // Jika sukses
            $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Dihapus!',
                        })
                </script>
                ");
            redirect('admin/students');
        } else { // Jika gagal
            $this->session->set_flashdata('pesan', "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal Dihapus!',
                                })
                        </script>
                        ");
            redirect('admin/students');
        }
    }

    // UPDATE DATA SISWA
    public function updatestudents()
    {
        $data = [
            'nim' => $this->input->post('nim', true),
            'nama_siswa' => $this->input->post('nama_siswa', true),
            'kelas_siswa' => $this->input->post('kelas_siswa'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
            'is_active' => $this->input->post('is_active', true),
        ];

        $this->db->where('id_siswa', $this->input->post('id_siswa'));
        $this->db->update('siswa', $data);

        $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Di Update!',
                        })
                </script>
                ");
        redirect('admin/students');
    }

    //  AJAX UPDATE DATA SISWA
    public function ajaxupdatestudents()
    {
        if ($this->input->is_ajax_request()) {
            $nim = decrypt_url($this->input->post('nim'));
            $siswa = $this->db->get_where('siswa', ['nim' => $nim])->row();
            echo json_encode($siswa);
        } else {
            redirect('eror');
        }
    }

    // ========== END STUDENTS ===========

    // ========== CLASSES ===========

    // KELAS LIST
    public function classes()
    {
        $data['kelas_list'] = $this->kelas->getclass();
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/admin', $data);
        $this->load->view('admin/class/list', $data);
        $this->load->view('templates/footer');
    }

    // TAMBAH KELAS
    public function addclass()
    {
        $data['kelas_list'] = $this->kelas->getclass();
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $this->form_validation->set_rules('additional', 'Additioinal', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header');
            $this->load->view('templates/navbar/admin', $data);
            $this->load->view('admin/class/add-class', $data);
            $this->load->view('templates/footer');
        } else {
            // Ambil data yang dikirim dari form
            $kode_kelas = $this->input->post('kode_kelas', true);
            $data_kelas = array();

            $index = 0; // Set index array awal dengan 0
            foreach ($kode_kelas as $kelas) {
                array_push($data_kelas, array(
                    'kode_kelas' => $this->input->post('kode_kelas', true)[$index],
                    'nama_kelas' => $this->input->post('nama_kelas', true)[$index]
                ));

                $index++;
            }

            $sql = $this->kelas->insert_bulk($data_kelas);

            // Cek apakah query insert nya sukses atau gagal
            if ($sql) { // Jika sukses
                $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Disimpan!',
                        })
                </script>
                ");
                redirect('admin/classes');
            } else { // Jika gagal
                $this->session->set_flashdata('pesan', "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal Disimpan!',
                                })
                        </script>
                        ");
                redirect('admin/classes');
            }
        }
    }

    //  AJAX UPDATE DATA KELAS
    public function ajaxupdatekelas()
    {
        if ($this->input->is_ajax_request()) {
            $kelas = decrypt_url($this->input->post('kelas'));
            $data_kelas = $this->db->get_where('kelas', ['kode_kelas' => $kelas])->row();
            echo json_encode($data_kelas);
        } else {
            redirect('eror');
        }
    }

    // UPDATE DATA KELAS
    public function updateclass()
    {
        $data = [
            'nama_kelas' => $this->input->post('nama_kelas', true),
        ];

        $this->db->where('kode_kelas', $this->input->post('kode_kelas'));
        $this->db->update('kelas', $data);

        $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Di Update!',
                        })
                </script>
                ");
        redirect('admin/classes');
    }

    // DELETE CLASS
    public function delete_class($data)
    {
        $kode_kelas = decrypt_url($data);

        $this->db->delete('kelas', ['kode_kelas' => $kode_kelas]);
        $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Dihapus!',
                        })
                </script>
                ");
        redirect('admin/classes');
    }

    // ========== END CLASSESS ==========


    // ========== ABSENSI ===============

    public function presensi()
    {
        $data['presensi_list'] = $this->presensi->getpresensi();
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/admin', $data);
        $this->load->view('admin/presensi/list', $data);
        $this->load->view('templates/footer');
    }

    public function addpresensi()
    {
        $this->load->helper('string');
        $data['presensi_list'] = $this->presensi->getall();
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $this->form_validation->set_rules('no_event', 'Nomor Event', 'required');
        $this->form_validation->set_rules('nama_event', 'Nama Event', 'required');
        $this->form_validation->set_rules('tgl_event', 'Tanggal Event', 'required');
        $this->form_validation->set_rules('dari_jam', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('sampai_jam', 'Jam Selesai', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/navbar/admin', $data);
            $this->load->view('admin/presensi/add-presensi', $data);
            $this->load->view('templates/footer');
        } else {


            $this->load->library('ciqrcode');
            $config['cahceable'] = true;
            $config['cahcedir'] = './assets/app-assets/qr';
            $config['errorlog'] = './assets/app-assets/qr';
            $config['imagedir'] = './assets/app-assets/qr/img/'; //Penyimpanan QR COde
            $config['quality'] = true;
            $config['size'] = '1024';
            $config['black'] = [224, 225, 255];
            $config['white'] = [70, 130, 180];

            $this->ciqrcode->initialize($config);

            $img_name = random_string('alnum', 16) . '.png'; //Penamaan QR Code

            $params['data'] = encrypt_url($this->input->post('no_event'));
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH . $config['imagedir'] . $img_name;

            $hasil_qr = $this->ciqrcode->generate($params);

            if ($hasil_qr) {
                $data_presensi = [
                    'no_event' => $this->input->post('no_event', true),
                    'nama_event' => $this->input->post('nama_event', true),
                    'tgl_event' => $this->input->post('tgl_event', true),
                    'dari_jam' => $this->input->post('dari_jam', true),
                    'sampai_jam' => $this->input->post('sampai_jam', true),
                    'qr_event' => $img_name,
                ];

                $this->db->insert('event', $data_presensi);
                $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Berhasil Disimpan!',
                        })
                </script>
                ");
                redirect('admin/presensi');
            } else {
                $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi error!, Gagal Disimpan',
                        })
                </script>
                ");
                redirect('admin/presensi');
            }
        }
    }

    public function showpresensi($data)
    {
        $no_event = decrypt_url($data);
        // echo $no_event;
        // die;

        $query1 = $this->db->query("SELECT * FROM siswa WHERE nim NOT IN ( SELECT nim_siswa FROM absen WHERE no_event = '$no_event')");
        $query1_result = $query1->result();
        $presensi['belum_absen'] = $query1_result;

        // $data['event'] = $this->presensi->getpresensibynoevent($no_event);
        // $data['presensi'] = $this->presensi->getbynoevent($no_event);
        $presensi['event'] = $this->presensi->presensibyno($no_event);
        $presensi['absen'] = $this->presensi->getbynoevent($no_event);
        $presensi['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $waktu_sekarang = date('Y-m-d H:i', time());
        $tgl_event = $presensi['event']->tgl_event;
        $jam_akhir = $presensi['event']->sampai_jam;
        $akhir_event = "$tgl_event $jam_akhir";

        if (strtotime($waktu_sekarang) < strtotime($akhir_event)) {
            $presensi['berakhir'] = "masih"; //Masih
        } else {
            $presensi['berakhir'] = "berakhir"; //Beakhir
        }

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/admin', $presensi);
        $this->load->view('admin/presensi/show-presensi', $presensi);
        $this->load->view('templates/footer');
    }

    public function sudah_absen()
    {
        if ($this->input->is_ajax_request()) {
            $no_event = $this->input->post('content');

            $presensi =  $this->presensi->absensiswa($no_event);

            $html = '';

            if ($presensi) {
                foreach ($presensi as $row) {
                    $siswa = $this->db->get_where('siswa', ['nim' => $row->nim_siswa])->row();
                    $kelas = $this->db->get('kelas')->result();

                    if ($row->absen_masuk == 0 && $row->izinkan == 0) {
                        $telat = '<span class="badge badge-warning mb-2">Pending</span>';
                    }
                    if ($row->absen_masuk == 0 && $row->izinkan == 1) {
                        $telat = '<span class="badge badge-primary mb-2">Izin</span>';
                    }
                    if ($row->is_telat != null && $row->is_telat == 0) {
                        $telat = '<span class="badge badge-success mb-2">Sukses</span>';
                    }
                    if ($row->is_telat != null && $row->is_telat == 1) {
                        $telat = '<span class="badge badge-danger mb-2">Terlambat</span>';
                    }
                    $html .= '
                    <div class="col-sm-3 mt-3 shadow-sm bg-white rounded">
                        <a href="#" class="friends-suggestions-list">
                            <div class="position-relative">
                                <div class="float-left mb-0 mr-3">
                                    <img src="' . base_url('assets/app-assets/user/') . $siswa->gambar . '" alt="" class="rounded-circle thumb-md mt-2">
                                </div>
                                <div class="desc">
                                    <h5 class="font-14 mb-1 pt-2 text-dark">' . $row->nama_siswa . '</h5>';
                    foreach ($kelas as $kel) {
                        if ($kel->kode_kelas == $siswa->kelas_siswa) {
                            $html .= '<small>' . $kel->nama_kelas . '</small><br>';
                        }
                    }
                    $html .= '' . $telat . '
                                </div>
                            </div>
                        </a>
                    </div>
                ';
                }
            } else {
                $html .= '
                    <div class="alert alert-danger" role="alert">
                        Belum Ada Data.
                    </div>
                ';
            }

            echo $html;
        } else {
            redirect('eror');
        }
    }

    public function belum_absen_masuk()
    {
        if ($this->input->is_ajax_request()) {
            $no_event = $this->input->post('content');

            $query1 = $this->db->query("SELECT * FROM siswa WHERE nim NOT IN ( SELECT nim_siswa FROM absen WHERE no_event = '$no_event')");
            $query1_result = $query1->result();
            $belum_absen = $query1_result;

            $html = '';

            if ($belum_absen) {
                foreach ($belum_absen as $row) {
                    $kelas = $this->db->get('kelas')->result();
                    $html .= '
                    <div class="col-sm-3 mt-3 shadow-sm bg-white rounded">
                        <a href="#" class="friends-suggestions-list">
                            <div class="position-relative">
                                <div class="float-left mb-0 mr-3">
                                    <img src="' . base_url('assets/app-assets/user/') . $row->gambar . '" alt="" class="rounded-circle thumb-md mt-2">
                                </div>
                                <div class="desc">
                                    <h5 class="font-14 mb-1 pt-2 text-dark">' . $row->nama_siswa . '</h5>';
                    foreach ($kelas as $kel) {
                        if ($kel->kode_kelas == $row->kelas_siswa) {
                            $html .= '<small>' . $kel->nama_kelas . '</small><br>';
                        }
                    }
                    $html .= '<span class="badge badge-danger mb-2">Belum Absen</span>';
                    $html .= '</div>
                            </div>
                        </a>
                    </div>
                ';
                }
            } else {
                $html .= '
                    <div class="alert alert-success" role="alert">
                        Sudah Absen semua
                    </div>
                ';
            }

            echo $html;
        } else {
            redirect('eror');
        }
    }

    public function showpresensikeluar($data)
    {
        $no_event = decrypt_url($data);
        // $data['event'] = $this->presensi->getpresensibynoevent($no_event);
        // $data['presensi'] = $this->presensi->getbynoevent($no_event);
        $presensi['event'] = $this->presensi->presensibyno($no_event);
        $presensi['absen'] = $this->presensi->getbynoevent($no_event);
        $presensi['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $waktu_sekarang = date('Y-m-d H:i', time());
        $tgl_event = $presensi['event']->tgl_event;
        $jam_akhir = $presensi['event']->sampai_jam;
        $akhir_event = "$tgl_event $jam_akhir";

        if (strtotime($waktu_sekarang) < strtotime($akhir_event)) {
            $presensi['berakhir'] = "masih"; //Masih
        } else {
            $presensi['berakhir'] = "berakhir"; //Beakhir
        }

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/admin', $presensi);
        $this->load->view('admin/presensi/absen-keluar', $presensi);
        $this->load->view('templates/footer');
    }

    public function sudah_absen_keluar()
    {
        if ($this->input->is_ajax_request()) {
            $no_event = $this->input->post('content');

            $presensi =  $this->presensi->absensiswa($no_event);

            $html = '';

            if ($presensi) {
                foreach ($presensi as $row) {
                    if ($row->absen_keluar != 0 || $row->izinkan == '0' || $row->izinkan == '1') {

                        $siswa = $this->db->get_where('siswa', ['nim' => $row->nim_siswa])->row();
                        $kelas = $this->db->get('kelas')->result();

                        if ($row->izinkan == '1') {
                            $telat = '<span class="badge badge-primary mb-2">Izin</span>';
                        }
                        if ($row->izinkan == '0') {
                            $telat = '<span class="badge badge-warning mb-2">Pending</span>';
                        }
                        if ($row->keterangan == "Selesai Sebelum Waktu" && $row->absen_masuk != 0 && $row->absen_keluar !== 0) {
                            $telat = '<span class="badge badge-danger mb-2">Selesai Sebelum Waktu</span>';
                        }
                        if ($row->keterangan == "Tepat Waktu" && $row->absen_masuk != 0 && $row->absen_keluar !== 0) {
                            $telat = '<span class="badge badge-success mb-2">Sukses</span>';
                        }

                        $html .= '
                            <div class="col-sm-3 mt-3 shadow-sm bg-white rounded">
                                <a href="#" class="friends-suggestions-list">
                                    <div class="position-relative">
                                        <div class="float-left mb-0 mr-3">
                                            <img src="' . base_url('assets/app-assets/user/') . $siswa->gambar . '" alt="" class="rounded-circle thumb-md mt-2">
                                        </div>
                                        <div class="desc">
                                            <h5 class="font-14 mb-1 pt-2 text-dark">' . $row->nama_siswa . '</h5>';
                        foreach ($kelas as $kel) {
                            if ($kel->kode_kelas == $siswa->kelas_siswa) {
                                $html .= '<small class="text-muted">' . $kel->nama_kelas . '</small><br>';
                            }
                        }
                        $html .= $telat;
                        $html .= '
                                        </div>
                                    </div>
                                </a>
                            </div>
                        ';
                    }
                }
            } else {
                $html .= '
                    <div class="alert alert-danger" role="alert">
                        Belum Ada Data.
                    </div>
                ';
            }

            echo $html;
        } else {
            redirect('eror');
        }
    }

    public function belum_absen_keluar()
    {
        if ($this->input->is_ajax_request()) {
            $no_event = $this->input->post('content');

            $presensi =  $this->presensi->absensiswa($no_event);

            $html = '';

            if ($presensi) {
                foreach ($presensi as $row) {
                    if ($row->absen_masuk != 0 && $row->absen_keluar == '0') {

                        $siswa = $this->db->get_where('siswa', ['nim' => $row->nim_siswa])->row();
                        $kelas = $this->db->get('kelas')->result();

                        $html .= '
                            <div class="col-sm-3 mt-3 shadow-sm bg-white rounded">
                                <a href="#" class="friends-suggestions-list">
                                    <div class="position-relative">
                                        <div class="float-left mb-0 mr-3">
                                            <img src="' . base_url('assets/app-assets/user/') . $siswa->gambar . '" alt="" class="rounded-circle thumb-md">
                                        </div>
                                        <div class="desc">
                                            <h5 class="font-14 mb-1 pt-2 text-dark">' . $row->nama_siswa . '</h5>';
                        foreach ($kelas as $kel) {
                            if ($kel->kode_kelas == $siswa->kelas_siswa) {
                                $html .= '<p class="text-muted">' . $kel->nama_kelas . '</p>';
                            }
                        }
                        $html .= '                                            
                                        </div>
                                    </div>
                                </a>
                            </div>
                        ';
                    }
                }
            } else {
                $html .= '
                    <div class="alert alert-success" role="alert">
                        Sudah Absen Semua
                    </div>
                ';
            }

            echo $html;
        } else {
            redirect('eror');
        }
    }

    // PERMOHONAN IZIN
    public function listpermohonan($data)
    {
        $no_event = decrypt_url($data);
        $where = [
            'no_event' => $no_event,
            'absen_masuk' => '0',
        ];

        $presensi['list_izin'] = $this->db->get_where('absen', $where)->result();
        $presensi['event'] = $this->db->get_where('event', ['no_event' => $no_event])->row();
        $presensi['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/admin', $presensi);
        $this->load->view('admin/presensi/list-izin', $presensi);
        $this->load->view('templates/footer');
    }

    public function izinkan()
    {
        $nim = decrypt_url($this->input->get('siswa'));
        $no_event = decrypt_url($this->input->get('event'));

        $where = [
            'no_event' => $no_event,
            'nim_siswa' => $nim
        ];

        $this->db->set('izinkan', 1);
        $this->db->where($where);
        $this->db->update('absen');

        $this->session->set_flashdata('pesan', "
                <script>
                   Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Permohonan Di izinkan',
                        })
                </script>
                ");

        redirect('admin/listpermohonan/' . $this->input->get('event'));
    }

    // ========== END ABSENSI ===========
}
