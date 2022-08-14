<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Students extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Siswa_Model', 'siswa');
        $this->load->model('Kelas', 'kelas');
        $this->load->model('Presensi', 'presensi');
        date_default_timezone_set('Asia/Jakarta');
        // if (!$this->session->userdata('email') || !$this->session->userdata('nim')) {
        //     redirect('auth');
        // }
        is_students();
    }

    public function index()
    {
        $data['siswa'] = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();
        $this->load->view('templates/header');
        $this->load->view('templates/navbar/student', $data);
        $this->load->view('student/dashboard');
        $this->load->view('templates/footer');
    }

    public function profile()
    {
        $this->form_validation->set_rules('nim', 'Nim', 'required');
        $this->form_validation->set_rules('nama_siswa', 'Nama', 'required');
        $this->form_validation->set_rules('kelas_siswa', 'Kelas', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Gender', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        $data['siswa'] = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/navbar/student', $data);
            $this->load->view('student/profile', $data);
            $this->load->view('templates/footer');
        } else {

            if ($_FILES['gambar']['name']) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg|PNG|GIF|JPG|JPEG';
                $config['max_size']     = '5048';
                $config['upload_path'] = './assets/app-assets/user/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')) {
                    $old_image = $data['siswa']->gambar;
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . '/assets/app-assets/user/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $data = [
                        'nama_siswa' => $this->input->post('nama_siswa'),
                        'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                        'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                        'tempat_lahir' => $this->input->post('tempat_lahir'),
                        'email' => $this->input->post('email'),
                        'gambar' => $new_image
                    ];

                    $this->db->where('nim', $this->input->post('nim'));
                    $sql = $this->db->update('siswa', $data);

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
                        redirect('students/profile');
                    }
                } else {
                    echo $this->upload->display_errors();
                }
            } else {
                $data = [
                    'nama_siswa' => $this->input->post('nama_siswa'),
                    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                    'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                    'tempat_lahir' => $this->input->post('tempat_lahir'),
                    'email' => $this->input->post('email'),
                ];

                $this->db->where('nim', $this->input->post('nim'));
                $sql = $this->db->update('siswa', $data);

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
                    redirect('students/profile');
                }
            }
        }
    }


    public function presensi()
    {

        $data['presensi_list'] = $this->presensi->getpresensi();
        $data['siswa'] = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

        $data['presensi_siswa'] = $this->db->get_where('absen', ['nim_siswa' => $data['siswa']->nim])->row();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/student', $data);
        $this->load->view('student/presensi/list', $data);
        $this->load->view('templates/footer');
    }

    public function absenmasuk($data)
    {

        $no_event = decrypt_url($data);

        $siswa = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

        if (!$siswa) {
            $siswa = $this->db->get_where('siswa', ['email' => $this->session->userdata('email')])->row();
        }

        $presensi['absen_siswa'] = $this->presensi->absensiswa1($no_event, $siswa->nim);
        $presensi['event'] = $this->presensi->presensibyno($no_event);
        $presensi['siswa'] = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/student', $presensi);
        $this->load->view('student/presensi/absen-masuk', $presensi);
        $this->load->view('templates/footer');
    }

    public function absen_masuk()
    {
        if ($this->input->is_ajax_request()) {
            $no_event = decrypt_url($this->input->post('content'));
            $event = $this->presensi->presensibyno($no_event);

            $siswa = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

            if (!$siswa) {
                $siswa = $this->db->get_where('siswa', ['email' => $this->session->userdata('email')])->row();
            }

            $waktu_scan =  date('H:i', time());
            $waktu_scan2 = time();
            $batas1 = $event->dari_jam;
            // $batas2 = intval($batas1);
            // $batas = date('H:i', $batas1);
            if ((strtotime($waktu_scan) > strtotime($batas1))) {
                echo "<b>Batas waktu sudah berakhir</b><br>";
                $telat = 1;
            } else {
                echo "<b>Masih dalam jangka waktu</b><br>";
                $telat = 0;
            }
            $kelas = $this->db->get_where('kelas', ['kode_kelas' => $siswa->kelas_siswa])->row();
            $data = [
                'no_event' => $no_event,
                'nama_siswa' => $siswa->nama_siswa,
                'nim_siswa' => $siswa->nim,
                'kelas' => $kelas->nama_kelas,
                'absen_masuk' => $waktu_scan2,
                'is_telat' => $telat,
            ];
            $this->db->insert('absen', $data);
        } else {
            redirect('eror');
        }
    }

    public function absenkeluar($data_event)
    {

        $no_event = decrypt_url($data_event);

        $siswa = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

        if (!$siswa) {
            $siswa = $this->db->get_where('siswa', ['email' => $this->session->userdata('email')])->row();
        }

        $data['absen_siswa'] = $this->presensi->absensiswa1($no_event, $siswa->nim);
        $data['event'] = $this->presensi->presensibyno($no_event);
        $data['siswa'] = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

        // var_dump($data['absen_siswa']);
        // die;

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/student', $data);
        $this->load->view('student/presensi/absen-keluar', $data);
        $this->load->view('templates/footer');
    }

    public function absen_keluar()
    {
        if ($this->input->is_ajax_request()) {
            $no_event = decrypt_url($this->input->post('content'));
            $event = $this->presensi->presensibyno($no_event);

            $siswa = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

            if (!$siswa) {
                $siswa = $this->db->get_where('siswa', ['email' => $this->session->userdata('email')])->row();
            }

            $cek = [
                'no_event' => $no_event,
                'nim_siswa' => $siswa->nim
            ];

            $cek_sudah_absen = $this->db->get_where('absen', $cek)->row();

            if (!$cek_sudah_absen) {
                $this->session->set_flashdata('pesan', '
                            <script>
                                Swal.fire(
                                    "Oops!",
                                    "Anda tidak bisa melakukan presensi keluar, dikarenakan belum melakukan presensi masuk,",
                                    "error"
                                );
                            </script>
                        ');
                redirect('students/presensi');
            }

            $waktu_scan =  date('H:i', time());
            $waktu_scan2 = time();
            $batas1 = $event->sampai_jam;
            // $batas2 = intval($batas1);
            // $batas = date('H:i', $batas1);
            if ((strtotime($waktu_scan) < strtotime($batas1))) {
                $keterangan = "Selesai Sebelum Waktu";
            } else {
                $keterangan = "Tepat Waktu";
            }
            $data = [
                'absen_keluar' => $waktu_scan2,
                'keterangan' => $keterangan,
            ];
            $where = [
                'no_event' => $no_event,
                'nim_siswa' => $siswa->nim
            ];
            $this->db->update('absen', $data, $where);
        } else {
            redirect('eror');
        }
    }

    public function izin($data_izin)
    {
        $no_event = decrypt_url($data_izin);
        $where = [
            'no_event' => $no_event,
            'nim_siswa' => $this->session->userdata('nim'),
            'absen_masuk' => '0',
            'absen_keluar' => '0',
            'izinkan' => 0
        ];

        $where2 = [
            'no_event' => $no_event,
            'nim_siswa' => $this->session->userdata('nim'),
        ];


        $data['list_izin'] = $this->db->get_where('absen', $where)->row();
        $data['list_presensi'] = $this->db->get_where('absen', $where2)->row();

        // var_dump($data['list_presensi']);
        // die;

        $data['event'] = $this->db->get_where('event', ['no_event' => $no_event])->row();
        $data['siswa'] = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();

        $this->load->view('templates/header');
        $this->load->view('templates/navbar/student', $data);
        $this->load->view('student/presensi/izin', $data);
        $this->load->view('templates/footer');
    }

    public function kirim_izin()
    {
        $no_event = decrypt_url($this->input->post('no_event'));
        $siswa = $this->db->get_where('siswa', ['nim' => $this->session->userdata('nim')])->row();
        $kelas = $this->db->get_where('kelas', ['kode_kelas' => $siswa->kelas_siswa])->row();

        $config['allowed_types'] = 'gif|jpg|png|jpeg|PNG|GIF|JPG|JPEG|pdf|doc|docx|';
        $config['max_size']     = '5048';
        $config['upload_path'] = './assets/app-assets/izin/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('suket')) {
            $suket = $this->upload->data('file_name');
            $data = [
                'no_event' => $no_event,
                'nama_siswa' => $siswa->nama_siswa,
                'nim_siswa' => $siswa->nim,
                'kelas' => $kelas->nama_kelas,
                'izinkan' => 0,
                'suket' => $suket,
                'keterangan' => $this->input->post('keterangan')

            ];

            $sql = $this->db->insert('absen', $data);

            if ($sql) {
                $this->session->set_flashdata('pesan', '
                    <script>
                         Swal.fire(
                            "Berhasil!",
                            "Data Berhasil Dikirim",
                            "success"
                        );
                    </script>
                ');
                redirect('students/izin/' . encrypt_url($no_event));
            } else {
                $this->session->set_flashdata('pesan', '
                    <script>
                         Swal.fire(
                            "Oopss!",
                            "Gagal Dikirim",
                            "error"
                        );
                    </script>
                ');
                redirect('students/izin/' . encrypt_url($no_event));
            }
        } else {
            $this->session->set_flashdata('pesan', '
                    <script>
                         Swal.fire(
                            "Oopss!",
                            "Gagal Dikirim",
                            "error"
                        );
                    </script>
                ');
            redirect('students/izin/' . encrypt_url($no_event));
        }
    }
}
