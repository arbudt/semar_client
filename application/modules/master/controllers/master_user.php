<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_user extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master/master_user_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'master/view_master_user';
        $data['menuTitle'] = 'Data User';
        $data['menuDescription'] = 'Data User';
        $this->load->view('template', $data);
    }

    /*
     * proses simpan data
     */

    function prosesSimpan() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'idUser' => NULL
        );
        if (!empty($_POST)) {
            $master_user = array(
                'user_code' => !empty($_POST['idUser']) ? $_POST['idUser'] : '',
                'user_group' => !empty($_POST['groupUser']) ? $_POST['groupUser'] : '',
                'user_fullname' => !empty($_POST['namaLengkap']) ? $_POST['namaLengkap'] : '',
                'user_nickname' => !empty($_POST['namaPanggilan']) ? $_POST['namaPanggilan'] : '',
                'user_username' => !empty($_POST['username']) ? $_POST['username'] : '',
                'user_password' => !empty($_POST['password']) ? $_POST['password'] : '',
                'user_aktif' => !empty($_POST['statusAktif']) ? $_POST['statusAktif'] : '0',
                'user_user_update' => $this->userId
            );
            $send = $this->master_user_model->simpanData($master_user);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['idUser'] = $send['idUser'];
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
        $result = $this->master_user_model->dataUserAll();
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
        if (!empty($_POST['idUser'])) {
            $idUser = $_POST['idUser'];
            $result = $this->master_user_model->dataTransById($idUser);
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