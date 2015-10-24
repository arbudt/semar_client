<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bosk7a extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bosk7a/bosk7a_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'bosk7a/view_bosk7a';
        $data['menuTitle'] = 'BOS K7a';
        $data['menuDescription'] = 'Realisasi penggunaan dana BOS';
        $this->load->view('template', $data);
    }

    /*
     * proses simpan data
     */

    function prosesSimpan() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'idTrans' => NULL
        );
        if (!empty($_POST)) {
            $trans_k7a = array(
                'k7a_code' => !empty($_POST['idTrans']) ? $_POST['idTrans'] : '',
                'k7a_no_urut' => !empty($_POST['noUrut']) ? $_POST['noUrut'] : '',
                'k7a_program' => !empty($_POST['programKegiatan']) ? $_POST['programKegiatan'] : '',
                'k7a_uraian' => !empty($_POST['uraian']) ? $_POST['uraian'] : '',
                'k7a_triwulan_code' => !empty($_POST['triwulan']) ? $_POST['triwulan'] : '',
                'k7a_price' => !empty($_POST['jumlahPengeluaran']) ? $_POST['jumlahPengeluaran'] : 0,
                'k7a_user_update' => $this->userId,
                'k7a_status' => 0
            );
            $send = $this->bosk7a_model->simpanData($trans_k7a);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['idTrans'] = $send['idTrans'];
                $data['message'] = 'Proses simpan berhasil';
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Proses simpan gagal';
            }
        } else {
            $data['message'] = 'Tidak ada proses';
        }
        echo json_encode($data);
    }

    /*
     * proses delete data
     */

    function prosesDelete() {
        $data = array(
            'status' => FALSE,
            'message' => NULL
        );
        if (!empty($_POST['idTrans'])) {
            $trans_k7a = array(
                'k7a_code' => !empty($_POST['idTrans']) ? $_POST['idTrans'] : '',
                'k7a_user_update' => $this->userId,
                'k7a_status' => 1
            );
            $send = $this->bosk7a_model->simpanData($trans_k7a);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses hapus berhasil';
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Proses hapus gagal';
            }
        } else {
            $data['message'] = 'Identitas data tidak diketahui';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data transaksi berdasarkan filter
     */

    function getDataFilterLimit() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['triwulan'])) {
            $triwulan = $_POST['triwulan'];
            $filter = array(
                'triwulan' => $triwulan
            );
            $result = $this->bosk7a_model->dataFilterLimit($filter, 0, 100);
            if ($result != NULL) {
                $data['data'] = $result['data'];
                $data['offset'] = 0;
                $data['limit'] = 100;
                $data['countAll'] = $result['countAll'];
            } else {
                $data['message'] = 'Tidak ada data ditemukan';
            }
        } else {
            $data['message'] = 'triwulan harus dipilih';
        }
        echo json_encode($data);
    }

    /*
     * mengambil satu data
     */

    function getDataByIdTrans() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idTrans'])) {
            $idTrans = $_POST['idTrans'];
            $result = $this->bosk7a_model->dataTransById($idTrans);
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

?>