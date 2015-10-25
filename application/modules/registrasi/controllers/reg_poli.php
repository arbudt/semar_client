<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_poli extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(
                'registrasi/reg_poli_model'
        );
    }

    function index() {
//        $data['previlages'] = $this->previlages;
        $data['page'] = 'registrasi/view_reg_poli';
        $data['menuTitle'] = 'Pendaftaran Poli';
        $data['menuDescription'] = 'Pendaftaran kunjungan poli';

        $this->load->view('template', $data);
    }

    /*
     * proses simpan data
     */

    function proses_simpan() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'idTrans' => NULL
        );
        if (!empty($_POST)) {
            $trans_kunjungan = array(
                'tkunj_id' => !empty($_POST['idKunjungan']) ? $_POST['idKunjungan'] : '',
                'mpas_id' => !empty($_POST['noRm']) ? $_POST['noRm'] : '',
                'mpoli_id' => !empty($_POST['poli']) ? $_POST['poli'] : '',
                'tkunj_tanggal' => !empty($_POST['tanggalPeriksa']) ? dateReverse($_POST['tanggalPeriksa']) : '',
                'mdok_id' => !empty($_POST['dokter']) ? $_POST['dokter'] : '',
                'mcb_id' => !empty($_POST['caraBayar']) ? $_POST['caraBayar'] : '',
                'tkunj_no_peserta' => !empty($_POST['noPeserta']) ? $_POST['noPeserta'] : '',
                'tkunj_keterangan' => !empty($_POST['keterangan']) ? $_POST['keterangan'] : ''
            );
            $send = $this->reg_poli_model->simpanData($trans_kunjungan);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['idTrans'] = $send['idTrans'];
                $data['message'] = 'Proses simpan berhasil';
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Proses simpan gagal';
            }
        }
        echo json_encode($data);
    }

    /*
     * mengambil data transaksi berdasarkan filter
     */

    function cari_list_kunjungan() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['listPoliKunjungan']) || !empty($_POST['listNoRmKunjungan']) || !empty($_POST['listNamaKunjungan'])) {
            $poli = $_POST['listPoliKunjungan'];
            $noRM = $_POST['listNoRmKunjungan'];
            $nama = $_POST['listNamaKunjungan'];
            $result = $this->reg_poli_model->dataKunjunganByFilter($poli, $noRM, $nama);
            if ($result != NULL) {
                $data['data'] = $result;
            } else {
                $data['message'] = 'Tidak ada data ditemukan';
            }
        } else {
            $data['message'] = 'Harus memasukkan filter';
        }
        echo json_encode($data);
    }

    /*
     * mengambil satu data
     */

    function get_data_kunjungan_by_id() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idTrans'])) {
            $idTrans = $_POST['idTrans'];
            $result = $this->reg_poli_model->dataKunjunganById($idTrans);
            if ($result != NULL) {
                $data['data'] = $result;
            } else {
                $data['message'] = 'Tidak ada data ditemukan';
            }
        } else {
            $data['message'] = 'identitas harus dikirim';
        }
        echo json_encode($data);
    }

}