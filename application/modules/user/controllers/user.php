<?php

class User extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->load->view('user/view_user');
        
    }
}
?>
