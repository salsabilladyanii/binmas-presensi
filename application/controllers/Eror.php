<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eror extends CI_Controller
{
    public function index()
    {
        $this->load->view('error');
    }
}
