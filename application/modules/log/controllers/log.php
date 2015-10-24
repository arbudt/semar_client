<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('log/log_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'log/log_view';
        $data['menuTitle'] = 'Log Aktifity';
        $data['menuDescription'] = 'Log Aktifitas user';
        $data['defaultTanggalAwal'] = tglSekarang();
        $data['defaultTanggalAkhir'] = tglSekarang();
        $this->load->view('template', $data);
    }

    /*
     * mengambil data transaksi berdasarkan filter
     */

    function getDataLog() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['tglAwal']) && !empty($_POST['tglAkhir'])) {
            $tglAwal = $_POST['tglAwal'];
            $tglAkhir = $_POST['tglAkhir'];
            $result = $this->log_model->dataLogByFilter($tglAwal, $tglAkhir);
            if ($result != NULL) {
                $data['data'] = $result;
            } else {
                $data['message'] = 'Tidak ada data ditemukan';
            }
        } else {
            $data['message'] = 'triwulan harus dipilih';
        }
        echo json_encode($data);
    }

}
?>