<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }


    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">New Role successfully added! </div>');
            redirect('admin/role');
        }
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Access changed! </div>');
    }

    public function tasks()
    {
        $data['title'] = 'Request Tasks';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['reqtasks'] = $this->menu->gettasks();
        $data['freelance'] = $this->db->get('freelance')->result_array();

        $this->form_validation->set_rules('task_type', 'task_type', 'required');
        $this->form_validation->set_rules('source_lang', 'source_lang', 'required');
        $this->form_validation->set_rules('id_freelance', 'id_freelance', 'required');
        $this->form_validation->set_rules('task_files', 'task_files', 'required');
        $this->form_validation->set_rules('deadline', 'deadline', 'required');
        $this->form_validation->set_rules('name', 'name', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/tasks', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'task_type' => $this->input->post('task_type'),
                'date_created' => $this->input->post('date_created'),
                'source_lang' => $this->input->post('source_lang'),
                'id_freelance' => $this->input->post('id_freelance'),
                'task_files' => $this->input->post('task_files'),
                'deadline' => $this->input->post('deadline'),
                'name' => $this->input->post('name')

            ];
            $this->db->insert('request_task', $data);
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert"New Task successfully posted! </div>');
            redirect('admin/tasks');
        }
    }
}
