<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
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
            $this->load->view('user/edit', $data);
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
                    redirect('user');
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Your profile successfully changed! </div>');
            redirect('user');
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
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Wrong current password! </div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">New password can not be the same as current password! </div>');
                    redirect('user/changepassword');
                } else {
                    $password_hash = password_hash(
                        $new_password,
                        PASSWORD_DEFAULT
                    );
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Succes change password!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    public function verify_task()
    {
        $email = $this->input->get('email');
        $file = $this->input->get('file');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // $user = $this->db->get_where('user_token', ['file' => $file])->row_array();

        if ($user) {
            $task_token = $this->db->get_where('task_token', ['token' => $token])->row_array();

            if ($task_token) {
                if (time() - $task_token['date_created'] < (60 * 60 * 24 * 2)) {
                    $this->db->set('status', 'accepted');
                    $this->db->where('email', $email);
                    $this->db->where('task_files', $file);
                    $this->db->update('request_task');

                    $this->db->delete('task_token', ['email' => $email]);

                    $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task has been accepted! Please check your current tasks</div>');
                    redirect('user/requestedTask');
                } else {
                    $this->db->set('status', 'denied');
                    $this->db->where('email', $email);
                    $this->db->where('task_files', $file);
                    $this->db->update('request_task');
                    $this->db->delete('task_token', ['email' => $email]);
                    $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Task Expired!</div>');
                    redirect('user/requestedTasks');
                }
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid token task, please contact admin!</div>');
                redirect('user/requestedTasks');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Failed when sending task! Wrong email </div>');
            redirect('user/requestedTask');
        }
    }

    public function verify_taskdenied()
    {
        $email = $this->input->get('email');
        $file = $this->input->get('file');
        $token = $this->input->get('token');


        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $task_token = $this->db->get_where('task_token', ['token' => $token])->row_array();

            if ($task_token) {
                if (time() - $task_token['date_created'] < (60 * 60 * 24 * 2)) {
                    $this->db->set('status', 'denied');
                    $this->db->where('email', $email);
                    $this->db->where('task_files', $file);
                    $this->db->update('request_task');

                    $this->db->delete('task_token', ['email' => $email, 'file' => $file]);

                    $this->session->set_flashdata('menus', '<div class="alert alert-warning alert-dismissible" role="alert">Task has been denied!</div>');
                    redirect('user/requestedTask');
                } else {
                    $this->db->set('status', 'denied');
                    $this->db->where('email', $email);
                    $this->db->where('task_files', $file);
                    $this->db->update('request_task');
                    $this->db->delete('task_token', ['email' => $email, 'file' => $file]);
                    $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Task Expired!</div>');
                    redirect('user/requestedTasks');
                }
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid token task, please contact admin!</div>');
                redirect('user/requestedTasks');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Failed when sending task! Wrong email </div>');
            redirect('user/requestedTask');
        }
    }

    public function requestedTask()
    {
        $data['title'] = 'Requested Tasks';
        $data['user'] = $this->db->get_where('user', ['email' => $user = $this->session->userdata('email')])->row_array();

        $data['taskuser'] = $this->db->get_where('request_task', ['email' => $user])->result_array();

        // if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/requestedTasks', $data);
        $this->load->view('templates/footer');
        // } else {
        // }
    }
    function download($id)
    {
        $data = $this->db->get_where('request_task', ['id' => $id])->row();
        force_download('assets/taskfiles/' . $data->task_files, NULL);

        redirect('user/curtask');
    }

    public function curtask()
    {
        $data['title'] = 'Current Tasks';
        $data['user'] = $this->db->get_where('user', ['email' => $user = $this->session->userdata('email')])->row_array();

        $data['taskuser'] = $this->db->get_where('request_task', ['email' => $user, 'status' => 'accepted'])->result_array();

        // if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/curtask', $data);
        $this->load->view('templates/footer');
        // } else {
        // }
    }

    public function invoiceAwait()
    {
        $data['title'] = 'Awaiting Invoice';
        $data['user'] = $this->db->get_where('user', ['email' => $user = $this->session->userdata('email')])->row_array();

        // $this->db->select('*');
        // $this->db->from('task_invoice');
        // $this->db->join('request_task', 'task_invoice.id_reqtask = request_task.id');
        // $this->db->where('request_task.email', $user);

        // $data['taskinvoiceuser'] = $this->db->

        $this->load->model('Menu_model', 'menu');
        $data['taskinvoiceuser'] = $this->menu->gettasksinvoice();
        $data['taskinvoiceuser'] = $this->db->get_where('task_invoice', ['email' => $user, 'status' => 'pending invoice', 'status' => 'Ready to invoicing'])->result_array();
        $data['humanr'] = $this->db->get_where('user', ['role_id' => 4])->result_array();
        $data['reqtask'] = $this->db->get_where('request_task', ['email' => $user, 'status' => 'accepted'])->result_array();

        $this->form_validation->set_rules('email_hr', 'Email HR', 'required|trim');
        $this->form_validation->set_rules('name', 'Your Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Your Email', 'required|trim');
        $this->form_validation->set_rules('id_reqtask', 'Base Task ID', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/invoiceawait', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->model('Menu_model', 'menu');
            $email = $this->input->post('email_hr');
            $password = $this->input->post('password');
            $task_id =  $this->input->post('id_reqtask');

            $data = [
                'id_reqtask' => $task_id,
                'name' => $this->input->post('name'),
                'email_hr' => $this->input->post('email_hr'),
                'email' => $this->input->post('email'),
                'status' => 'pending invoice',
                'file_final' => $file = $this->_filetouploads()
            ];

            $token = base64_encode(random_bytes(32));
            $hr_token = [
                'user' => $user,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'task_id' => $task_id,
                'file' => $file,
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('task_invoice', $data);
            $this->db->insert('hr_token', $hr_token);
            $this->_sendEmailTaskuser($token, 'verify_taskFinal', $file, $user, $password, $task_id);

            $this->session->set_flashdata('menus', '<div class="alert alert-success" role="alert">The task successfully submitted!</div>');
            redirect('user/invoiceAwait');
        }
    }

    function downloadtaskfinal($id)
    {
        $data = $this->db->get_where('task_invoice', ['id' => $id])->row();
        force_download('assets/taskfilesfinal/' . $data->file_final, NULL);

        redirect('user/invoiceAwait');
    }
    private function _sendEmailTaskuser($token, $type, $file, $user, $password, $task_id)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => $user,
            'smtp_pass' => $password,
            'smtp_port' => '465',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from($user, 'Freelance PT. STAR Software Indonesia');
        $this->email->to($this->input->post('email_hr'));

        if ($type == 'verify_taskFinal') {
            $this->email->subject('New task ready to invoice!');
            $this->email->message('Click this link to login & invoicing the task : <a href=" ' . base_url() . 'humanresource/verify_taskFinal?email=' . $this->input->post('email') . '& token=' . urlencode($token) .  '& file=' . $file . '& task_id=' . $task_id . '">Accept</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    private function _filetouploads()
    {

        $config['upload_path'] = './assets/taskfilesfinal/';
        $config['allowed_types'] = 'doc|docx|pdf|xlsx|csv|zip|rar';
        $config['max_size']     = 0;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file_final')) {
            return $this->upload->data("file_name");
        }

        return true;
    }

    public function deletetaskfinal($id)
    {
        $data['title'] = 'Awaiting Invoice';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['taskinvoice'] = $this->menu->gettasksinvoice();

        if ($this->menu->deleteTaskInvoice($id) > 0) {
            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task successfully deleted! </div>');
            redirect('user/invoiceAwait');
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Error while deleting task! </div>');
            redirect('user/invoiceAwait');
        }
    }

    public function invoiceReady()
    {
        $data['title'] = 'Ready to Invoice';
        $data['user'] = $this->db->get_where('user', ['email' => $user = $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['datainvoice'] = $this->menu->dataInvoice();
        $data['datainvoice'] = $this->db->get_where('invoice', ['email_freelance' => $user, 'status' => 'Waiting for invoice'])->result_array();
        $data['humanr'] = $this->db->get_where('user', ['role_id' => 4])->result_array();
        $data['reqtask'] = $this->db->get_where('request_task', ['email' => $user, 'status' => 'finished'])->result_array();

        // $this->load->model('Menu_model', 'menu');

        // $data['taskinvoice'] = $this->db->get_where('task_invoice', ['status' => 'Ready to invoicing', 'id' => 'id'])->result_array();

        // $this->form_validation->set_rules('email_hr', 'Email HR', 'required|trim');
        // $this->form_validation->set_rules('name', 'Your Name', 'required|trim');
        // $this->form_validation->set_rules('email', 'Your Email', 'required|trim');
        // $this->form_validation->set_rules('id_reqtask', 'Base Task ID', 'required|trim');

        // if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/invoiceReady', $data);
        $this->load->view('templates/footer');
        // } else {
        //     $this->load->model('Menu_model', 'menu');
        //     $email = $this->input->post('email_hr');
        //     $password = $this->input->post('password');
        //     $task_id =  $this->input->post('id_reqtask');

        //     $data = [
        //         'id_reqtask' => $task_id,
        //         'name' => $this->input->post('name'),
        //         'email_hr' => $this->input->post('email_hr'),
        //         'email' => $this->input->post('email'),
        //         'status' => 'pending invoice',
        //         'file_final' => $file = $this->_filetouploads()
        //     ];

        //     $token = base64_encode(random_bytes(32));
        //     $hr_token = [
        //         'user' => $user,
        //         'password' => password_hash($password, PASSWORD_DEFAULT),
        //         'task_id' => $task_id,
        //         'file' => $file,
        //         'email' => $email,
        //         'token' => $token,
        //         'date_created' => time()
        //     ];

        //     $this->db->insert('task_invoice', $data);
        //     $this->db->insert('hr_token', $hr_token);
        //     $this->_sendEmailTaskuser($token, 'verify_taskFinal', $file, $user, $password, $task_id);

        //     $this->session->set_flashdata('menus', '<div class="alert alert-success" role="alert">The task successfully submitted!</div>');
        //     // redirect('user/invoiceAwait');
        // }
    }

    public function verify_Invoice()
    {
        $email = $this->input->get('email');
        $file = $this->input->get('file');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // $user = $this->db->get_where('user_token', ['file' => $file])->row_array();

        if ($user) {
            $task_token = $this->db->get_where('invoice_token', ['token' => $token])->row_array();

            if ($task_token) {

                $this->db->set('status', 'accepted');
                $this->db->where('email', $email);
                $this->db->where('file_invoice', $file);
                $this->db->update('invoice');

                $this->db->delete('invoice_token', ['email' => $email]);

                $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Invoice has been accepted! Please send your invoice ASAP</div>');
                redirect('user/invoiceReady');
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid token invoice, please contact admin!</div>');
                redirect('user/invoiceReady');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Failed when sending invoice! Wrong email </div>');
            redirect('user/invoiceReady');
        }
    }
}
