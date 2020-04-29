<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Humanresource extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     is_logged_in();
    // }


    public function index()
    {
        $data['title'] = 'Data Freelance';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebarhuman', $data);
        $this->load->view('templates/topbarhuman', $data);
        $this->load->view('humanresource/index', $data);
        $this->load->view('templates/footer');
    }
}
