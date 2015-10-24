<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bosk7 extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bosk7/bosk7_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'bosk7/view_bosk7';
        $data['menuTitle'] = 'BOS K7';
        $data['menuDescription'] = 'Realisasi dana BOS tiap jenis anggaran';
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
            $trans_k7 = array(
                'k7_code' => !empty($_POST['idTrans']) ? $_POST['idTrans'] : '',
                'k7_tahun_code' => !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : '',
                'k7_triwulan_code' => !empty($_POST['triwulan']) ? $_POST['triwulan'] : '',
                'k7_sumber_dana_bos' => !empty($_POST['sumberDanaBos']) ? $_POST['sumberDanaBos'] : '',
                'k7_jumlah_dana_bos' => !empty($_POST['jumlahSumberDanaBos']) ? $_POST['jumlahSumberDanaBos'] : '',
                'k7_sumber_dana_pendapatan_sekolah' => !empty($_POST['sumberDanaPendapatanSekolah']) ? $_POST['sumberDanaPendapatanSekolah'] : '',
                'k7_jumlah_dana_pendapatan_sekolah' => !empty($_POST['jumlahSumberDanaPendapatanSekolah']) ? $_POST['jumlahSumberDanaPendapatanSekolah'] : '',
                'k7_sumber_dana_pendapatan_lain' => !empty($_POST['sumberDanaPendapatanLain']) ? $_POST['sumberDanaPendapatanLain'] : '',
                'k7_jumlah_dana_pendapatan_lain' => !empty($_POST['jumlahSumberDanaPendapatanLain']) ? $_POST['jumlahSumberDanaPendapatanLain'] : '',
                'k7_jumlah_bantuan_lain' => !empty($_POST['jumlahBantuanLain']) ? $_POST['jumlahBantuanLain'] : '',
                'k7_no_kode' => !empty($_POST['noKode']) ? $_POST['noKode'] : '',
                'k7_uraian' => !empty($_POST['uraian']) ? $_POST['uraian'] : '',
                'k7_user_update' => $this->userId
            );
            $send = $this->bosk7_model->simpanData($trans_k7);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['idTrans'] = $send['idTrans'];
                $data['message'] = 'Proses simpan berhasil';
                if (!empty($_POST['idTrans'])) {
                    addLogAktifity('bos k7', 'update', 'edit data dengan kode k7 : ' . $send['idTrans']);
                } else {
                    addLogAktifity('bos k7', 'insert', 'tambah data dengan kode k7 : ' . $send['idTrans']);
                }
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
            $trans_k7 = array(
                'k7_code' => $_POST['idTrans'],
                'k7_user_update' => $this->userId,
                'k7_status' => 1
            );
            $send = $this->bosk7_model->simpanData($trans_k7);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses hapus berhasil';
                addLogAktifity('bos k7', 'delete', 'hapus data dengan kode k7 : ' . $_POST['idTrans']);
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

    function getDataTrans() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['tahun']) && !empty($_POST['triwulan'])) {
            $tahun = $_POST['tahun'];
            $triwulan = $_POST['triwulan'];
            $result = $this->bosk7_model->dataTransByFilter($tahun, $triwulan);
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
            $result = $this->bosk7_model->dataTransById($idTrans);
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