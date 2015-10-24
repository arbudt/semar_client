<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trans_gaji extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pengeluaran/trans_gaji_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'pengeluaran/view_trans_gaji';
        $data['menuTitle'] = 'BUKU PENGELUARAN';
        $data['menuDescription'] = 'Pembayaran gaji guru GTT dan PTT';
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
            $trans_gaji = array(
                'gaji_code' => !empty($_POST['idTrans']) ? $_POST['idTrans'] : '',
                'guru_code' => !empty($_POST['guru']) ? $_POST['guru'] : '',
                'gaji_tugas' => !empty($_POST['tugas']) ? $_POST['tugas'] : '',
                'gaji_date' => !empty($_POST['tanggal']) ? dateReverse($_POST['tanggal']) : dateReverse(tglSekarang()),
                'gaji_tahun_code' => !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : '',
                'gaji_triwulan_code' => !empty($_POST['triwulan']) ? $_POST['triwulan'] : '',
                'gaji_price' => !empty($_POST['jumlahPengeluaran']) ? $_POST['jumlahPengeluaran'] : 0,
                'gaji_user_update' => $this->userId
            );
            $send = $this->trans_gaji_model->simpanData($trans_gaji);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['idTrans'] = $send['idTrans'];
                $data['message'] = 'Proses simpan berhasil';
                if (!empty($_POST['idTrans'])) {
                    addLogAktifity('gaji guru', 'update', 'edit data dengan kode : ' . $send['idTrans']);
                } else {
                    addLogAktifity('gaji guru', 'insert', 'tambah data dengan kode : ' . $send['idTrans']);
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
            $trans_k3 = array(
                'k3_code' => $_POST['idTrans'],
                'k3_user_update' => $this->userId,
                'k3_status' => 1
            );
            $trans_gaji = array(
                'gaji_code' => !empty($_POST['idTrans']) ? $_POST['idTrans'] : '',
                'gaji_user_update' => $this->userId,
                'gaji_status' => 1
            );
            $send = $this->trans_gaji_model->simpanData($trans_gaji);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses hapus berhasil';
                addLogAktifity('gaji guru', 'delete', 'hapus data dengan kode : ' . $_POST['idTrans']);
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
            $result = $this->trans_gaji_model->dataTransByFilter($tahun, $triwulan);
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
            $result = $this->trans_gaji_model->dataTransById($idTrans);
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