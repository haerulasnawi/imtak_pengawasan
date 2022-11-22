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
        $data['pengumuman'] = $this->db->get_where('informasi', ['is_active' => 1])->result_array();
        $this->load->view('landingpage/landing-page-fix', $data);
    }

    public function strukturOrganisasi()
    {
        $this->load->view('landingpage/struktur');
    }

    public function survei()
    {
        $data['title'] = 'Survei';

        $data['databidang'] = $this->db->get('bidang')->result_array();

        $this->load->view('templates/auth_header', $data);
        $this->load->view('landingpage/survei', $data);
        $this->load->view('templates/auth_footer');



        // $this->form_validation->set_rules('id_task_reqtask', 'Task', 'required');
        // $this->form_validation->set_rules('task_type', 'Task type', 'required');
        // $this->form_validation->set_rules('target_lang', 'Target Language', 'required');
        // $this->form_validation->set_rules('source_lang', 'SourceLanguage', 'required');
        // $this->form_validation->set_rules('job_value', 'Value', 'required');
        // $this->form_validation->set_rules('date_completed', 'Date Completed', 'required');
        // $this->form_validation->set_rules('email_freelance', 'Freelance email', 'required');
    }
}
