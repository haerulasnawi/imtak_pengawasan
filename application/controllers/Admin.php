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

    public function getubahrole()
    {
        $this->load->model('Menu_model', 'menu');
        echo json_encode($this->menu->getDataUbahRole($_POST['id']));
    }

    public function editRole()
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->load->model('Menu_model', 'menu');
        if ($this->menu->ubahrole($_POST) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Role successfully changed! </div>');
            redirect('admin/role');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while changing role! </div>');
            redirect('admin/role');
        }
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
        $this->form_validation->set_rules('target_lang', 'target_lang', 'required');
        $this->form_validation->set_rules('id_freelance', 'id_freelance', 'required');
        $this->form_validation->set_rules('job_value', 'job_value', 'required');
        // $this->form_validation->set_rules('task_files', 'task_files', 'required');
        $this->form_validation->set_rules('deadline', 'deadline', 'required');
        $this->form_validation->set_rules('name', 'name', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/tasks', $data);
            $this->load->view('templates/footer');
        } else {

            $this->load->model('Menu_model', 'menu');
            $email = $this->input->post('email');

            $data = [
                'task_type' => $this->input->post('task_type'),
                'source_lang' => $this->input->post('source_lang'),
                'target_lang' => $this->input->post('target_lang'),
                'id_freelance' => $this->input->post('id_freelance'),
                'job_value' => $this->input->post('job_value'),
                'status' => 'pending',
                'deadline' => $this->input->post('deadline'),
                'name' => $this->input->post('name'),
                'email' => htmlspecialchars($email),
                'task_files' => $file = $this->_filetoupload()
            ];

            // $task_type = htmlspecialchars($this->input->post('task_type'));
            // $source_lang = htmlspecialchars($this->input->post('source_lang'));
            // $target_lang = htmlspecialchars($this->input->post('target_lang'));
            // $id_freelance = htmlspecialchars($this->input->post('id_freelance'));
            // $date_created = $this->input->post(time());
            // $deadline = $this->input->post('deadline');
            // $name =  htmlspecialchars($this->input->post('name'));
            // $email = htmlspecialchars($this->input->post('email'));
            // $fileupload = $this->_filetoupload();
            //siapkan token
            $token = base64_encode(random_bytes(32));
            $task_token = [
                'file' => $file,
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            // $this->menu->uploadfile($dataFile);
            // $query = "INSERT INTO request_task VALUES
            //  ('','$task_type','$date_created','$source_lang','$target_lang','$id_freelance','$fileupload','$deadline','$name','pending','$email')";

            // return $this->db->query($query)->row();
            $this->db->insert('request_task', $data);
            $this->db->insert('task_token', $task_token);
            $this->_sendEmailTask($token, 'verify_task', $file);

            $this->session->set_flashdata('menus', '<div class="alert alert-success" role="alert">New task successfully created!</div>');
            redirect('admin/tasks');
        }
    }

    function download($id)
    {
        $data = $this->db->get_where('request_task', ['id' => $id])->row();
        force_download('assets/taskfiles/' . $data->task_files, NULL);

        redirect('admin/tasks');
    }
    private function _sendEmailTask($token, $type, $file)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'pt.starjogjaindonesia@gmail.com',
            'smtp_pass' => 'Ptstarindonesia2020.',
            'smtp_port' => '465',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('pt.starjogjaindonesia@gmail.com', 'Admin PT. STAR Software Indonesia');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify_task') {
            $this->email->subject('You have a new request task!');
            $this->email->message('Click this link to login & accept/deny the task : <a href=" ' . base_url() . 'user/verify_task?email=' . $this->input->post('email') . '& token=' . urlencode($token) .  '& file=' . $file . '">Accept </a> <a href=" ' . base_url() . 'user/verify_taskdenied?email=' . $this->input->post('email') . '& token=' . urlencode($token) .  '& file=' . $file . '"> Deny</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    private function _filetoupload()
    {

        $config['upload_path'] = './assets/informasi/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']     = 10240;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            return $this->upload->data("file_name");
        }

        return true;
    }

    public function informasi()
    {
        $data['title'] = 'Pengumuman';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['pengumuman'] = $this->db->get('informasi')->result_array();
        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('uraian', 'Uraian', 'required');
        // $this->form_validation->set_rules('image', 'Gambar', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/pengumuman', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id' => $this->input->post('id'),
                'title' => $this->input->post('title'),
                'uraian' => $this->input->post('uraian'),
                'date_created' => time(),
                'is_active' => $this->input->post('is_active'),
                'image' => $file = $this->_filetoupload()
            ];

            $this->db->insert('informasi', $data);

            $this->session->set_flashdata('menus', '<div class="alert alert-success" role="alert">New announcement successfully created!</div>');
            redirect('admin/informasi');
        }
    }

    public function deletepengumuman($id)
    {
        $data['title'] = 'Pengumuman';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        if ($this->menu->deletepengumuman($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Announcement successfully deleted! </div>');
            redirect('admin/informasi');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting announcement! </div>');
            redirect('admin/informasi');
        }
    }

    public function edit_pengumuman($id)
    {
        $data['title'] = 'Pengumuman';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['pengumuman'] = $this->db->get_where('informasi', ['id' => $id])->row_array();
        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('uraian', 'Uraian', 'required');
        // $this->form_validation->set_rules('image', 'Gambar', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/pengumuman', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id' => $this->input->post('id'),
                'title' => $this->input->post('title'),
                'uraian' => $this->input->post('uraian'),
                'date_created' => time(),
                'is_active' => $this->input->post('is_active'),
                'image' => $file = $this->_filetoupload()
            ];

            $this->db->set('title', $data['title']);
            $this->db->set('uraian', $data['uraian']);
            $this->db->set('date_created', $data['date_created']);
            $this->db->set('is_active', $data['is_active']);
            $this->db->set('image', $data['image']);
            $this->db->where('id', $id);

            $this->db->update('informasi');

            $this->session->set_flashdata('menus', '<div class="alert alert-success" role="alert">Succesfully updated!</div>');
            redirect('admin/informasi');
        }
    }

    public function deletetask($id)
    {
        $data['title'] = 'Request Tasks';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['reqtasks'] = $this->menu->gettasks();

        if ($this->menu->deleteTask($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task successfully deleted! </div>');
            redirect('admin/tasks');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting task! </div>');
            redirect('admin/tasks');
        }
    }

    public function deleteRole($id)
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();


        $this->load->model('Menu_model', 'menu');

        if ($this->menu->deleteRole($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Role successfully deleted! </div>');
            redirect('admin/role');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting role! </div>');
            redirect('admin/role');
        }
    }

    // public function getubahtask()
    // {
    //     $this->load->model('Menu_model', 'menu');
    //     echo json_encode($this->menu->getDataUbahTask($_POST['id']));
    // }

    // public function editTask()
    // {
    //     $data['title'] = 'Request Tasks';
    //     $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    //     $this->load->model('Menu_model', 'menu');

    //     $data['reqtasks'] = $this->db->get('request_task')->result_array();

    //     $this->load->model('Menu_model', 'menu');
    //     if ($this->menu->ubahtask($_POST) > 0) {
    //         $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task successfully changed! </div>');
    //         redirect('admin/tasks');
    //     } else {
    //         $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while changing Task! </div>');
    //         redirect('admin/tasks');
    //     }
    // }
}
