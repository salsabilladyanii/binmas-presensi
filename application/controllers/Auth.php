<?php

use Mpdf\Tag\Input;

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index($login_registre = '', $login_create = 'none')
    {
        // Data login dan signup Jika terjadi eror pada saat sign up
        $data['login_registre'] = $login_registre;
        $data['login_create'] = $login_create;

        // Validasi Form username dan password harus disi
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/index', $data);
        } else {
            // Data Admin Dicari berdasarkan email
            $user = $this->db->get_where('admin', ['email' => $this->input->post('username')])->row();

            // Jika Data Admin ada maka lanjut ke verifikasi password
            // Jika data admin tidak ada maka akan mencari data siswa
            // artinya, jika bukan admin yg sedang login, berarti siswa yg sedang login
            if ($user) {

                // MEngecek Password
                if (password_verify($this->input->post('password'), $user->password)) {

                    // Jika Password Benar Maka siapkan data session dan arahkan kehalaman admin
                    $data = [
                        'email' => $user->email,
                        'nama' => $user->nama_admin,
                        'role' => $user->role
                    ];
                    $this->session->set_userdata($data);
                    redirect('admin');

                    // Jika Password salah maka siapkan alert salah dan arahkan ke halaman login
                } else {
                    $this->session->set_flashdata(
                        'pesan',
                        '<script>
                                Swal.fire(
                                "Oopss!",
                                "Wrong Password!",
                                "error"
                                )
                            </script>'
                    );
                    redirect('auth');
                }
            } else {

                // Mengambil data siswa berdasarkan email / NIM yang di inputkan di form login
                $user = $this->db->get_where('siswa', ['email' => $this->input->post('username')])->row();
                if (!$user) {
                    $user = $this->db->get_where('siswa', ['nim' => $this->input->post('username')])->row();
                }

                // Mengecek Jika data siswanya ada maka lanjut ke verifikasi passsword
                if ($user) {
                    // Pengecekan password
                    // Jika Password ada maka siapkan data session dan alihkan kehalaman siswa
                    if (password_verify($this->input->post('password'), $user->password)) {
                        $data = [
                            'email' => $user->email,
                            'nama' => $user->nama_siswa,
                            'role' => $user->role,
                            'nim' => $user->nim
                        ];
                        $this->session->set_userdata($data);
                        redirect('students');

                        // Jika Password salah maka siapkan alert salah dan alihkan kehalaman login
                    } else {
                        $this->session->set_flashdata(
                            'pesan',
                            '<script>
                                Swal.fire(
                                "Oopss!",
                                "Wrong Password!",
                                "error"
                                )
                            </script>'
                        );
                        redirect('auth');
                    }
                } else {
                    // Jika data siswanya tidak ada maka siapkan alert data tidak ada dan alihkan kehalaman login
                    $this->session->set_flashdata(
                        'pesan',
                        '<script>
                            Swal.fire(
                            "Oopss!",
                            "Akun Tidak Ada!",
                            "error"
                            )
                        </script>'
                    );
                    redirect('auth');
                }
            }
        }
    }

    // Registrasi
    public function registration()
    {
        // Cek apakah email yang dimasukan sudah terdaftar di database
        // jika iyaa maka siapkan pesan error dan alihkan kehalaman login
        if ($this->db->get_where('admin', ['email' => $this->input->post('email')])->row()) {
            $this->session->set_flashdata(
                'pesan',
                "<script>
                    Swal.fire(
                    'Oops..! ',
                    'Email Sudah Dipakai',
                    'error'
                    )
            </script>"
            );
            redirect('auth');
        }

        // Siapkan Data Untuk Dimasukan Kedalam Database
        $data = [
            'nama_admin' => $this->input->post('username', true),
            'email' => $this->input->post('email', true),
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'role' => 1,
            'date_created' => time(),
            'is_active' => 1,
            'gambar' => "default.jpg"
        ];

        $sql = $this->db->insert('admin', $data);

        if ($sql) {
            $this->session->set_flashdata(
                'pesan',
                "<script>
                    Swal.fire(
                    'Berhasil!',
                    'Akun Admin sudah dibuat',
                    'success'
                    )
            </script>"
            );
            redirect('auth');
        } else {
            $this->session->set_flashdata(
                'pesan',
                "<script>
                    Swal.fire(
                    'Oops..! ',
                    'Gagal Daftar',
                    'error'
                    )
            </script>"
            );
            redirect('auth');
        }
    }

    public function exampleemail()
    {
        // Siapkan token
        $email = $this->input->post('email');
        $token = encrypt_url($email);
        $user_token = [
            'email' => $email,
            'token' => $token,
            'date_created' => time()
        ];

        // KIRIM EMAIL UNTUK AKTIVASI
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'e.presensi.abdul@gmail.com', //masukan email kalian
            'smtp_pass' => 'anteiku123', // masukkan password kalian
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        $this->email->initialize($config);

        $this->email->set_newline("\r\n");

        $this->load->library('email', $config);

        $this->email->from('e.presensi.abdul@gmail.com', 'E-Presensi'); //masukkan email kalian
        $this->email->to($email);

        $this->email->subject('Account');
        $this->email->message('
            <div style="color: #000; padding: 10px;">
                <div style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; font-size: 20px; color: #1C3FAA; font-weight: bold;">
                    E-PRESENSI
                </div>
                <small style="color: #000;">V 1.0/small>
                <br>
                <p style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; color: #000;">Hallo ' . $this->input->post('name', true) . ' <br>
                    <span style="color: #000;">Your account successfully added, click the button to verify your account</span></p>
                <br>
                <a href="' . base_url('auth/verify?email=') . $this->input->post('email') . '&token=' . $token . '" style="display: inline-block; width: 100px; height: 30px; background: darkblue; color: #fff; text-decoration: none; border-radius: 5px; text-align: center; line-height: 30px; font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif;">Verify</a>
            </div>
        ');
        if ($this->email->send()) {
            // $this->db->insert('user_token', $user_token);
            // $this->db->insert('siswa', $data);
        } else {
            echo $this->email->print_debugger();
            die();
        }
        // END KIRIM EMAIL UNTUK AKTIVASI

        $this->session->set_flashdata(
            'pesan',
            "<script>
                    Swal.fire(
                    'Success..! ',
                    'Your Account Has been Created!<br>Please Check your email to verify',
                    'success'
                    )
            </script>"
        );
        redirect('auth');
    }

    // Verifikasi Akun
    public function verify()
    {
        // Ambil data email dan token dari tombol yg diklik di pesan email
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        // Ambil data user berdasarkan email
        $user = $this->db->get_where('siswa', ['email' => $email])->row_array();

        // Cek Jika usernya ada Maka Lanjut
        // Jika tidak ada maka siapkan alert error dan alihkan kehalaman login
        if ($user) {

            // Abil data token berdasarkan token email
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            // Jika Tokennya tersedia maka lanjut
            // Jika tokennya tidak ada maka siapkan pesan error dan alihkan kehalaman login
            if ($user_token) {

                // Mengecek apakah token sudah lebih dari 1 hari
                // Jika lebih maka siapkan pesan error dan alihkan kehalaman login
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {

                    // Edit Data User agar aktif
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('siswa');

                    // Menghapus token karena akun sudah berhasil aktif
                    $this->db->delete('user_token', ['email' => $email]);
                    // Siapkan pesan sukses dan alihkan kehalaman login
                    $this->session->set_flashdata(
                        'pesan',
                        "<script>
                            Swal.fire(
                            'success!',
                            '" . $email . " has been activated!',
                            'success'
                            )
                            </script>"
                    );
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata(
                        'pesan',
                        "<script>
                        Swal.fire(
                        'Error',
                        'Account Activation failed!<br>Token Expired',
                        'error'
                        )
                        </script>"
                    );
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    "<script>
                    Swal.fire(
                    'Error',
                    'Account Activation failed!<br>Invalid Token',
                    'error'
                    )
                    </script>"
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'pesan',
                "<script>
                Swal.fire(
                'Error',
                'Account Activation failed!<br>Wrong email',
                'error'
                 )
                </script>"
            );
            redirect('auth');
        }
    }

    // Logout
    public function logout()
    {
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('role');
        $this->session->set_flashdata(
            'pesan',
            '<script>
                Swal.fire(
                "Success",
                "You have been logged out",
                "success"
                )
            </script>'
        );

        // Kembalikan ke halaman login
        redirect('auth');
    }
}
