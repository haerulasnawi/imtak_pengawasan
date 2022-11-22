<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //jika validasinya lolos
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            //user available/ active
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    }
                    if ($user['role_id'] == 4) {
                        redirect('humanresource');
                    }
                    if ($user['role_id'] == 5) {
                        redirect('projectmanager');
                    } else {
                        redirect('user');
                    }
                    redirect('user');
                } else {
                    $this->session->set_flashdata('wrong', 'Wrong Password!');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('activated', 'This Email is not activated!');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('registered', 'Email is not registered!');
            redirect('auth');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        // $this->form_validation->set_rules('name', 'Name', 'required|trim');
        // $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
        //     'is_unique' => 'This email has already registered!'
        // ]);
        // $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
        //     'matches' => 'Password dont match!',
        //     'min_length' => 'Password too short!'
        // ]);
        // $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        // if ($this->form_validation->run() == false) {
        //     $data['title'] = 'User Registration';
        //     $this->load->view('templates/auth_header', $data);
        //     $this->load->view('auth/registration');
        //     $this->load->view('templates/auth_footer');
        // } else {
        //     $email = $this->input->post('email', true);
        //     $data = [
        //         'name' =>  htmlspecialchars($this->input->post('name', true)),
        //         'email' => htmlspecialchars($email),
        //         'image' => 'default.jpeg',
        //         'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
        //         'role_id' => 2,
        //         'is_active' => 0,
        //         'date_created' => time()

        //     ];

        //     //siapkan token
        //     $token = base64_encode(random_bytes(32));
        //     $user_token = [
        //         'email' => $email,
        //         'token' => $token,
        //         'date_created' => time()
        //     ];

        //     $this->db->insert('user', $data);
        //     $this->db->insert('user_token', $user_token);

        //     $this->_sendEmail($token, 'verify');

        //     $this->session->set_flashdata('message', 'Congratulation, your account has been created, please activate your account!');
        //     redirect('auth');
        // }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'in-v3.mailjet.com',
            'smtp_user' => '59c1747dc31bc9bac6fd1237e19a20d5',
            'smtp_pass' => 'a6bb930b90659f5a1bc3fcd1ad28645f',
            'smtp_port' => 587,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'crlf' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('bkpsdm@mataramkota.go.id', 'Admin Badan Kepegawaian dan Pengembangan Sumber Daya Manusia');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href=" ' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '& token=' . urlencode($token) . '">Activate</a>');
        } elseif ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href=" ' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '& token=' . urlencode($token) . '">Reset Password</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">' . $email . ' has been activated! Please Login </div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Token Expired!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid token!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Account activation failed! Wrong email </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('logout', 'You have been logged out!');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == false) {

            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Please check your email to reset your password!</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Email is not registered or activated!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function createAccount()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->db->select('email, nip');
        $query['user'] = $this->db->get('user')->result_array();


        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('name', 'Nama lengkap', 'required|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim|is_unique[user.nip]', [
            'is_unique' => 'This NIP has already registered!'
        ]);
        $this->form_validation->set_rules('unit_kerja', 'Unit kerja', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[re_password]', [
            'matches' => 'Password not match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('re_password', 'Confirm Password', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Buat Akun';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/create-account');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'id' => htmlspecialchars($this->input->post('id')),
                'name' =>  htmlspecialchars($this->input->post('name', true)),
                'unit_kerja' =>  htmlspecialchars($this->input->post('unit_kerja', true)),
                'nip' =>  htmlspecialchars($this->input->post('nip', true)),
                'no_hp' =>  htmlspecialchars($this->input->post('no_hp', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpeg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
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

            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Congratulation, account has been created, please check your email and activate your account! </div>');
            redirect('auth');
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changepassword();
            } else {
                $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Reset password failed! Wrong token</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('menus', '<div class="alert alert-danger alert-dismissible" role="alert">Reset password failed! Wrong email</div>');
            redirect('auth');
        }
    }

    public function changepassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');
        if ($this->form_validation->run() == false) {

            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('menus', '<div class="alert alert-success alert-dismissible" role="alert">Password has been changed! Please login</div>');
            redirect('auth');
        }
    }
}
