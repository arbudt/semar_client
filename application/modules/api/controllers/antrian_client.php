<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of antrian_client
 *
 * @author ziaha
 */
require APPPATH . 'libraries/REST_Controller.php';

class Antrian_client extends REST_Controller {

    //put your code here
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('antrian_client_model');
    }

    public function get_antrian_get($id_poli = '', $tanggal_kunjungan = '') {

        $result_total = $this->antrian_client_model->get_antrian_total($id_poli, $tanggal_kunjungan);
        $result_sekarang = $this->antrian_client_model->get_antrian_sekarang($id_poli, $tanggal_kunjungan);

        if (empty($result_total)) {
            $data['antrian']['total'] = 0;
        } else {
            $data['antrian']['total'] = $result_total;
        }

        if (empty($result_sekarang)) {
            $data['antrian']['sekarang'] = 0;
        } else {
            $data['antrian']['sekarang'] = $result_sekarang;
        }

        $data['antrian']['status'] = 1;
        $this->response($data);
    }

}
