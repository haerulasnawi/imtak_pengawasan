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

    public function getubahfreelance()
    {

        $this->load->model('Menu_model', 'menu');
        echo json_encode($this->menu->getDataUbahFree($_POST['id']));
    }

    public function editfreelance()
    {
        $data['title'] = 'Data Freelance';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['freelance'] = $this->menu->getFreelance();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Telepon', 'required');
        $this->form_validation->set_rules('language', 'Language', 'required');
        $this->load->model('Menu_model', 'menu');
        if ($this->menu->ubahfree($_POST) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Data freelance successfully changed! </div>');
            redirect('humanresource');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while changing data freelance! </div>');
            redirect('humanresource');
        }
    }

    public function taskInvoice()
    {
        $data['title'] = 'Task to Invoice';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['taskinvoice'] = $this->menu->gettasksinvoice();
        // $data['taskinvoice'] = $this->db->get_where('task_invoice', ['status' => 'pending invoice'])->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('humanresource/taskinvoice', $data);
        $this->load->view('templates/footer');
    }

    public function verify_taskFinal()
    {
        $email = $this->input->get('email');
        $file = $this->input->get('file');
        $token = $this->input->get('token');
        $task_id = $this->input->get('task_id');
        $user_email = $this->input->get('user');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // $user = $this->db->get_where('user_token', ['file' => $file])->row_array();

        if ($user) {
            $hr_token = $this->db->get_where('hr_token', ['token' => $token])->row_array();

            if ($hr_token) {
                $this->db->set('status', 'Ready to invoicing');
                // $this->db->where('email', $email);
                $this->db->where('file_final', $file);
                $this->db->where('id_reqtask', $task_id);
                $this->db->update('task_invoice');

                $this->db->set('status', 'finished');
                // $this->db->where('email', $email);
                $this->db->where('id', $task_id);
                $this->db->update('request_task');

                $this->db->delete('hr_token', ['file' => $file, 'task_id' => $task_id]);

                $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task has been accepted! Please send a invoice to freelance ASAP</div>');
                redirect('humanresource/taskInvoice');
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid token task, please contact admin!</div>');
                redirect('humanresource/taskInvoice');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Failed when sending task! Wrong email </div>');
            redirect('humanresource/taskInvoice');
        }
    }


    function downloadtaskfinal($id)
    {
        $data = $this->db->get_where('task_invoice', ['id' => $id])->row();
        force_download('assets/taskfilesfinal/' . $data->file_final, NULL);

        redirect('humanresource/taskInvoice');
    }
    public function deletetaskfinal($id)
    {
        $data['title'] = 'Request Tasks';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['taskinvoice'] = $this->menu->gettasksinvoice();

        if ($this->menu->deleteTaskInvoice($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task successfully deleted! </div>');
            redirect('humanresource/taskInvoice');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting task! </div>');
            redirect('humanresource/taskInvoice');
        }
    }

    public function invoicedata()
    {
        $data['title'] = 'Send Invoice Data';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['datain'] = $this->db->get('invoice')->result_array();
        $data['taskinvoice'] = $this->db->get_where('task_invoice', ['status' => 'Ready to invoicing'])->result_array();
        $data['reqtask'] = $this->db->get_where('request_task', ['status' => 'finished'])->result_array();

        $this->form_validation->set_rules('id_task_reqtask', 'Task', 'required');
        $this->form_validation->set_rules('task_type', 'Task type', 'required');
        $this->form_validation->set_rules('target_lang', 'Target Language', 'required');
        $this->form_validation->set_rules('source_lang', 'SourceLanguage', 'required');
        $this->form_validation->set_rules('job_value', 'Value', 'required');
        $this->form_validation->set_rules('date_completed', 'Date Completed', 'required');
        $this->form_validation->set_rules('email_freelance', 'Freelance email', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('humanresource/invoicedata', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->model('Menu_model', 'menu');
            $email = $this->input->post('email_freelance');
            $id_reqtask = $this->input->post('id_task_reqtask');

            $data = [
                'id_task_reqtask' => $id_reqtask,
                'task_type' => $this->input->post('task_type'),
                'target_lang' => $this->input->post('target_lang'),
                'source_lang' => $this->input->post('source_lang'),
                'job_value' => $this->input->post('job_value'),
                'status' => 'Waiting for invoice',
                'date_completed' => $this->input->post('date_completed'),
                'email_freelance' => htmlspecialchars($email),
                'file_invoice' => $file = $this->_filetouploadinvoice()
            ];

            $token = base64_encode(random_bytes(32));
            $invoice_token = [
                'file' => $file,
                'id_reqtask' => $id_reqtask,
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('invoice', $data);
            $this->db->insert('invoice_token', $invoice_token);
            $this->_sendEmailInvoice($token, 'verify_Invoice', $file, $id_reqtask);

            $this->session->set_flashdata('menus', '<div class="alert alert-success" role="alert">The invoice successfully send!</div>');
            redirect('humanresource/invoicedata');
        }
    }
    private function _sendEmailInvoice($token, $type, $file, $id_reqtask)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'allandanshiva@gmail.com',
            'smtp_pass' => 'alandanshiva',
            'smtp_port' => '465',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('allandanshiva@gmail.com', 'HR PT. STAR Software Indonesia');
        $this->email->to($this->input->post('email_freelance'));

        if ($type == 'verify_Invoice') {
            $this->email->subject('You have a new request invoice!');
            $this->email->message('Click this link to login & get invoice : <a href=" ' . base_url() . 'user/verify_Invoice?email=' . $this->input->post('email_freelance') . '& token=' . urlencode($token) .  '& file=' . $file .  '& id_reqtask=' . $id_reqtask . '">Login</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    private function _filetouploadinvoice()
    {

        $config['upload_path'] = './assets/invoicefiles/';
        $config['allowed_types'] = 'doc|docx|pdf|xlsx|csv|zip|rar';
        $config['max_size']     = 0;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file_invoice')) {
            return $this->upload->data("file_name");
        }

        return true;
    }

    public function deleteinvoice($id)
    {
        $data['title'] = 'Request Tasks';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['datainvoice'] = $this->menu->dataInvoice();

        if ($this->menu->deleteInvoice($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Invoice successfully deleted! </div>');
            redirect('humanresource/invoicedata');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting invoice! </div>');
            redirect('humanresource/invoicedata');
        }
    }

    function downloadinvoice($id)
    {
        $data = $this->db->get_where('invoice', ['id' => $id])->row();
        force_download('assets/invoicefiles/' . $data->file_invoice, NULL);

        redirect('humanresource/invoicedata');
    }

    public function invoiceDataFromUser()
    {
        $data['title'] = 'Invoiced Data';
        $data['user'] = $this->db->get_where('user', ['email' => $user = $this->session->userdata('email')])->row_array();
        $data['datainvoiceTask'] = $this->db->get_where('user_invoice')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('humanresource/invoiceDataFromUser', $data);
        $this->load->view('templates/footer');
    }

    function downloadinvoiceData($id)
    {
        $data = $this->db->get_where('user_invoice', ['id' => $id])->row();
        force_download('assets/invoicefiles/' . $data->file_invoice, NULL);

        redirect('humanresource/invoiceDataFromUser');
    }

    public function verify_InvoiceHR()
    {
        $email = $this->input->get('email');
        $file = $this->input->get('file');
        $token = $this->input->get('token');
        $id_reqtask = $this->input->get('id_reqtask');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // $user = $this->db->get_where('user_token', ['file' => $file])->row_array();

        if ($user) {
            $task_token = $this->db->get_where('user_invoice_token', ['token' => $token])->row_array();

            if ($task_token) {

                $this->db->set('status', 'Invoiced');
                $this->db->where('id_task_reqtask', $id_reqtask);
                $this->db->update('invoice');

                $this->db->set('status', 'Invoiced');
                $this->db->where('id', $id_reqtask);
                $this->db->update('request_task');

                $this->db->set('status', 'Invoiced');
                $this->db->where('id_reqtask', $id_reqtask);
                $this->db->update('task_invoice');

                $this->db->set('status', 'Invoiced');
                $this->db->where('file_invoice', $file);
                $this->db->where('id_task_reqtask', $id_reqtask);
                $this->db->update('user_invoice');

                $this->db->delete('user_invoice_token', ['email' => $email, 'id_reqtask' => $id_reqtask, 'file' => $file]);

                $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Invoice has been accepted!</div>');
                redirect('humanresource/invoiceDataFromUser');
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid token invoice, please contact admin!</div>');
                redirect('humanresource/invoiceDataFromUser');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Failed when sending invoice! Wrong email </div>');
            redirect('humanresource/invoiceDataFromUser');
        }
    }

    public function userlist()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['userlist'] = $this->db->get('user')->result_array();
        $data['user_role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        $this->form_validation->set_rules('role_id', 'role_id', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/userlist', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' =>  htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpeg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id', true),
                'is_active' => 0,
                'date_created' => time()

            ];
            //siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Congratulation, account has been created, please activate your account! </div>');
            redirect('menu/userlist');
        }
    }
    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'allandanshiva@gmail.com',
            'smtp_pass' => 'alandanshiva',
            'smtp_port' => '465',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('allandanshiva@gmail.com', 'HR PT. STAR Software Indonesia');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href=" ' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '& token=' . urlencode($token) . '">Activate</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function deleteuser($id)
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['user'] = $this->db->get('user')->result_array();


        $this->load->model('Menu_model', 'menu');

        if ($this->menu->deleteUser($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">User successfully deleted! </div>');
            redirect('humanresource/userlist');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting user! </div>');
            redirect('humanresource/userlist');
        }
    }
}
