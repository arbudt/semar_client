<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_guru extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master/master_guru_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'master/view_master_guru';
        $data['menuTitle'] = 'Data Guru';
        $data['menuDescription'] = 'Data Guru';
        $this->load->view('template', $data);
    }

    /*
     * proses simpan data
     */

    function prosesSimpan() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'idGuru' => NULL
        );
        if (!empty($_POST)) {
            $dataGuru = array(
                'guru_code' => !empty($_POST['idGuru']) ? $_POST['idGuru'] : '',
                'guru_name' => !empty($_POST['nama']) ? $_POST['nama'] : '',
                'guru_gender' => !empty($_POST['jenisKelamin']) ? $_POST['jenisKelamin'] : '',
                'guru_addres' => !empty($_POST['alamat']) ? $_POST['alamat'] : '',
                'guru_job' => !empty($_POST['tugas']) ? $_POST['tugas'] : '',
                'guru_aktif' => !empty($_POST['statusAktif']) ? $_POST['statusAktif'] : '0',
                'guru_user_update' => $this->userId
            );
            $send = $this->master_guru_model->simpanData($dataGuru);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['idGuru'] = $send['idGuru'];
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
     * mengambil data transaksi berdasarkan filter
     */

    function getDataAll() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        $result = $this->master_guru_model->dataGuruAll();
        if ($result != NULL) {
            $data['data'] = $result;
        } else {
            $data['message'] = 'Tidak ada data ditemukan';
        }
        echo json_encode($data);
    }

    /*
     * mengambil satu data
     */

    function getDataById() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idGuru'])) {
            $idGuru = $_POST['idGuru'];
            $result = $this->master_guru_model->dataTransById($idGuru);
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