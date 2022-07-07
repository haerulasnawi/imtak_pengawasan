<?php
class Landingpage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->load->view('landingpage/landing-page');
    }

    public function strukturOrganisasi()
    {
        $this->load->view('landingpage/struktur');
    }
}
?>