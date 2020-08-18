<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Projectmanager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }


    public function index()
    {

        $data['title'] = 'My Project';
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
            $this->load->view('projectmanager/tasks', $data);
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
            redirect('projectmanager');
        }
    }

    function download($id)
    {
        $data = $this->db->get_where('request_task', ['id' => $id])->row();
        force_download('assets/taskfiles/' . $data->task_files, NULL);

        redirect('projectmanager/tasks');
    }
    private function _sendEmailTask($token, $type, $file)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'projectmanagerstar@gmail.com',
            'smtp_pass' => 'projectmanager12',
            'smtp_port' => '465',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('projectmanagerstar@gmail.com', 'Project Manager PT. STAR Software Indonesia');
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

        $config['upload_path'] = './assets/taskfiles/';
        $config['allowed_types'] = 'doc|docx|pdf|xlsx|csv|zip|rar';
        $config['max_size']     = 0;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('task_files')) {
            return $this->upload->data("file_name");
        }

        return true;
    }

    public function deletetask($id)
    {
        $data['title'] = 'Request Tasks';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['reqtasks'] = $this->menu->gettasks();

        if ($this->menu->deleteTask($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task successfully deleted! </div>');
            redirect('projectmanager');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting task! </div>');
            redirect('projectmanager');
        }
    }


    // public function deleteFreelance($id)
    // {
    //     $data['title'] = 'User Management';
    //     $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    //     $data['user'] = $this->db->get('freelance')->result_array();


    //     $this->load->model('Menu_model', 'menu');

    //     if ($this->menu->deleteFreelance($id) > 0) {
    //         $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Data freelance successfully deleted! </div>');
    //         redirect('humanresource');
    //     } else {
    //         $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting data freelance! </div>');
    //         redirect('humanresource');
    //     }
    // }

    // public function getubahfreelance()
    // {

    //     $this->load->model('Menu_model', 'menu');
    //     echo json_encode($this->menu->getDataUbahFree($_POST['id']));
    // }

    // public function editfreelance()
    // {
    //     $data['title'] = 'Data Freelance';
    //     $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    //     $this->load->model('Menu_model', 'menu');
    //     $data['freelance'] = $this->menu->getFreelance();

    //     $this->form_validation->set_rules('name', 'Name', 'required');
    //     $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    //     $this->form_validation->set_rules('no_telp', 'Telepon', 'required');
    //     $this->form_validation->set_rules('language', 'Language', 'required');
    //     $this->load->model('Menu_model', 'menu');
    //     if ($this->menu->ubahfree($_POST) > 0) {
    //         $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Data freelance successfully changed! </div>');
    //         redirect('humanresource');
    //     } else {
    //         $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while changing data freelance! </div>');
    //         redirect('humanresource');
    //     }
    // }

    public function taskInvoice()
    {
        $data['title'] = 'Project Result';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['taskinvoice'] = $this->menu->gettasksinvoice();
        // $data['taskinvoice'] = $this->db->get_where('task_invoice', ['status' => 'pending invoice'])->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('projectmanager/taskinvoice', $data);
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
                redirect('projectmanager/taskInvoice');
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid token task, please contact admin!</div>');
                redirect('projectmanager/taskInvoice');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Failed when sending task! Wrong email </div>');
            redirect('projectmanager/taskInvoice');
        }
    }


    function downloadtaskfinal($id)
    {
        $data = $this->db->get_where('task_invoice', ['id' => $id])->row();
        force_download('assets/taskfilesfinal/' . $data->file_final, NULL);

        redirect('projectmanager/taskInvoice');
    }
    public function deletetaskfinal($id)
    {
        $data['title'] = 'Request Tasks';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['taskinvoice'] = $this->menu->gettasksinvoice();

        if ($this->menu->deleteTaskInvoice($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task successfully deleted! </div>');
            redirect('projectmanager/taskInvoice');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting task! </div>');
            redirect('projectmanager/taskInvoice');
        }
    }

    public function invoicedata()
    {
        $data['title'] = 'Send PO Data';
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
            $this->load->view('projectmanager/invoicedata', $data);
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

            $this->session->set_flashdata('menus', '<div class="alert alert-success" role="alert">The purchase order successfully send!</div>');
            redirect('projectmanager/invoicedata');
        }
    }
    private function _sendEmailInvoice($token, $type, $file, $id_reqtask)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'projectmanagerstar@gmail.com',
            'smtp_pass' => 'projectmanager12',
            'smtp_port' => '465',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('projectmanagerstar@gmail.com', 'Project Manager PT. STAR Software Indonesia');
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
        $data['title'] = 'Send PO Data';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['datainvoice'] = $this->menu->getdataInvoice();

        if ($this->menu->deleteInvoice($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Invoice successfully deleted! </div>');
            redirect('projectmanager/invoicedata');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting invoice! </div>');
            redirect('projectmanager/invoicedata');
        }
    }

    function downloadinvoice($id)
    {
        $data = $this->db->get_where('invoice', ['id' => $id])->row();
        force_download('assets/invoicefiles/' . $data->file_invoice, NULL);

        redirect('projectmanager/invoicedata');
    }

    public function invoiceDataFromUser()
    {
        $data['title'] = 'Invoiced Data';
        $data['user'] = $this->db->get_where('user', ['email' => $user = $this->session->userdata('email')])->row_array();
        $data['datainvoiceTask'] = $this->db->get_where('user_invoice')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('projectmanager/invoiceDataFromUser', $data);
        $this->load->view('templates/footer');
    }

    function downloadinvoiceData($id)
    {
        $data = $this->db->get_where('user_invoice', ['id' => $id])->row();
        force_download('assets/invoicefiles/' . $data->file_invoice, NULL);

        redirect('projectmanager/invoiceDataFromUser');
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
                redirect('projectmanager/invoiceDataFromUser');
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid token invoice, please contact admin!</div>');
                redirect('projectmanager/invoiceDataFromUser');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Failed when sending invoice! Wrong email </div>');
            redirect('projectmanager/invoiceDataFromUser');
        }
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('projectmanager/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            //cek jika ada gambar yang akan diupload

            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '5048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpeg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('menus', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('projectmanager/edit');
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Your profile successfully changed! </div>');
            redirect('projectmanager/edit');
        }
    }

    public function changepassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('projectmanager/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Wrong current password! </div>');
                redirect('projectmanager/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">New password can not be the same as current password! </div>');
                    redirect('projectmanager/changepassword');
                } else {
                    $password_hash = password_hash(
                        $new_password,
                        PASSWORD_DEFAULT
                    );
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Succes change password!</div>');
                    redirect('projectmanager/changepassword');
                }
            }
        }
    }
}
