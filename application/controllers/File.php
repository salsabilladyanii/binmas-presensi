<?php
defined('BASEPATH') or exit('No direct script access allowed');

class File extends CI_Controller
{
    function suket($nama)
    {
        // $data['materi'] = $this->materi->getMateriById($id_materi);

        force_download('./assets/app-assets/izin/' . decrypt_url($nama), NULL);
    }
}
