<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rekammedis_client
 *
 * @author ziaha
 */
require APPPATH . 'libraries/REST_Controller.php';

class rekammedis_client extends REST_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('rekammedis_client_model');
    }

    function get_rekammedis_get($no_rm = '') {
        $q = $this->rekammedis_client_model->getData($no_rm);
        if (empty($q)) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
            $data['data'] = $q;
        }
        $this->response($data);
    }

}
