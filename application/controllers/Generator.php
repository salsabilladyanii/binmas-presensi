<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generator extends CI_Controller
{
    public function index($data)
    {
        $this->load->library('ciqrcode');
        is_admin();

        $config['cahceable'] = true;
        $config['cahcedir'] = './assets/app-assets/qr';
        $config['errorlog'] = './assets/app-assets/qr';
        $config['imagedir'] = './assets/app-assets/qr/img/'; //Penyimpanan QR COde
        $config['quality'] = true;
        $config['size'] = '1024';
        $config['black'] = [224, 225, 255];
        $config['white'] = [70, 130, 180];

        $this->ciqrcode->initialize($config);

        $img_name = random_string('alnum', 16) . 'png'; //Penamaan QR Code

        $params['data'] = $data;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $img_name;

        $this->ciqrcode->generate($params);
    }
}
