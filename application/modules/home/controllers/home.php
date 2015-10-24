<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('home/home_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'home/view_home';
        $data['menuTitle'] = 'Identitas Sekolah';
        $data['menuDescription'] = 'Indentitas Sekolah';
        $this->load->view('template', $data);
    }


}

?>