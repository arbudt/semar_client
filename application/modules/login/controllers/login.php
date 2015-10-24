<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('login/login_model');
    }

    function index() {
        $userId = $this->session->userdata('userId');
        if (!empty($userId)) {
            redirect('dasboard');
        } else {
            $data['page'] = 'login/view_login';
            $this->load->view('template', $data);
        }
    }

    /* proses login / validasi login */

    function prosesLogin() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $dataLogin = $this->login_model->cekLogin($username, $password);
            if ($dataLogin != NULL) {
                $userId = $dataLogin->user_code;
                $groupId = $dataLogin->user_group;
                $fullName = $dataLogin->user_fullname;
                $nickName = $dataLogin->user_nickname;
                $previlages = $this->login_model->getPrevilages($groupId);
                $data = array(
                    'userId' => $userId,
                    'fullName' => $fullName,
                    'nickName' => $nickName,
                    'previlages' => $previlages
                );
                $this->session->set_userdata($data);
                redirect('home/home');
            } else {
                $this->session->set_flashdata('message', 'Maaf identitas Anda salah');
                redirect('login/login');
            }
        } else {
            $data['page'] = 'login/view_login';
            $this->load->view('template', $data);
        }
    }

    function prosesLogout() {
        $this->session->sess_destroy();
        redirect('login/login', 'refresh');
    }

}
?>