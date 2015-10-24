<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monitoring_dana extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('log/monitoring_dana_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'log/monitoring_dana_view';
        $data['menuTitle'] = 'Monitoring Dana ';
        $data['menuDescription'] = 'Monitoring penggunaan dana BOS';
        $data['defaultTahunAjaran'] = !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : '';
        $data['defaultTriwulan'] = !empty($_POST['triwulan']) ? $_POST['triwulan'] : '';
        $this->load->view('template', $data);
    }

    /*
     * mengambil data transaksi berdasarkan filter
     */

    function chart() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'log/monitoring_dana_view';
        $data['menuTitle'] = 'Monitoring Dana BOS';
        $data['menuDescription'] = 'Monitoring penggunaan dana BOS';

        $tahun = !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : '';
        $triwulan = !empty($_POST['triwulan']) ? $_POST['triwulan'] : '';
        $persenPenerimaan = 100;
        $persenPengeluaran = 0;
        $danaPenerimaan = 0;
        $danaPengeluaran = 0;
        if (!empty($tahun) && !empty($triwulan)) {
            $danaPenerimaan = $this->monitoring_dana_model->danaPenerimaanBosByTahunTriwulan($tahun, $triwulan);
            $danaPengeluaran = $this->monitoring_dana_model->danaPengeluaranBosByTahunTriwulan($tahun, $triwulan);
            if (!empty($danaPenerimaan)) {
                $persenPengeluaran = $danaPengeluaran / $danaPenerimaan * 100;
                $persenPenerimaan = 100 - $persenPengeluaran;
            }
        }
        $data['danaPenerimaan'] = number_format($danaPenerimaan);
        $data['danaPengeluaran'] = number_format($danaPengeluaran);
        $data['persenPenerimaan'] = $persenPenerimaan;
        $data['persenPengeluaran'] = $persenPengeluaran;
        $data['defaultTahunAjaran'] = $tahun;
        $data['defaultTriwulan'] = $triwulan;
//        echo '<pre>';
//        print_r($data);
//        die();
        $this->load->view('template', $data);
    }

}
?>