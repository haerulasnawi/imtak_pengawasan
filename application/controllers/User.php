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
        $id = $this->input->get('id');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        $user = $this->db->get_where('request_task', ['id' => $id])->row_array();

        if ($user) {
            $task_token = $this->db->get_where('task_token', ['token' => $token])->row_array();

            if ($task_token) {
                if (time() - $task_token['date_created'] < (60 * 60 * 24 * 2)) {
                    $this->db->set('status', 'accepted');
                    $this->db->where('email', $email);
                    $this->db->where('id', $id);
                    $this->db->update('request_task');

                    $this->db->delete('task_token', ['email' => $email]);

                    $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task has been accepted! Happy working </div>');
                    redirect('user/requestedTask');
                } else {
                    $this->db->set('status', 'denied');
                    $this->db->where('email', $email);
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
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $task_token = $this->db->get_where('task_token', ['token' => $token])->row_array();

            if ($task_token) {
                if (time() - $task_token['date_created'] < (60 * 60 * 24 * 2)) {
                    $this->db->set('status', 'denied');
                    $this->db->where('email', $email);
                    $this->db->update('request_task');

                    $this->db->delete('task_token', ['email' => $email]);

                    $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Task has been accepted! Happy working </div>');
                    redirect('user/requestedTask');
                } else {
                    $this->db->set('status', 'denied');
                    $this->db->where('email', $email);
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

        redirect('user/requestedTask');
    }
}
