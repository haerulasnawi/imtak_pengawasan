<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Humanresource extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {

        $data['title'] = 'Data Freelance';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');
        $data['freelance'] = $this->menu->getFreelance();
        $data['useraja'] = $this->db->get_where('user', ['role_id' => 2])->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[freelance.name]', [
            'is_unique' => 'This name has already exist in this table!'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Telepon', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[freelance.email]', [
            'is_unique' => 'This email has already exist in this table!'
        ]);
        $this->form_validation->set_rules('language', 'Language', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('humanresource/index', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email');
            $data = [
                'name' => $this->input->post('name'),
                'alamat' => $this->input->post('alamat'),
                'no_telp' => $this->input->post('no_telp'),
                'email' => $email,
                'language' => $this->input->post('language')
            ];

            $this->db->insert('freelance', $data);
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Congratulation, new freelance has been added! </div>');
            redirect('humanresource');
        }
    }

    public function deleteFreelance($id)
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['user'] = $this->db->get('freelance')->result_array();


        $this->load->model('Menu_model', 'menu');

        if ($this->menu->deleteFreelance($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Data freelance successfully deleted! </div>');
            redirect('humanresource');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting data freelance! </div>');
            redirect('humanresource');
        }
    }
}
