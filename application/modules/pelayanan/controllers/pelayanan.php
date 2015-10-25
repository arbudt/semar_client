<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelayanan extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pelayanan/pelayanan_model');
        $this->load->model('registrasi/reg_poli_model');
        $this->load->library('rest');
        Requests::register_autoloader();
    }

    function index() {
        $data['page'] = 'pelayanan/view_pelayanan';
        $data['menuTitle'] = 'Pelayanan Poli';
        $data['menuDescription'] = 'Pelayanan kunjungan poli';

        $this->load->view('template', $data);
    }

    /*
     * mengambil satu data
     */

    function get_antrian_by_poli() {
        $data = array(
            'data' => NULL,
            'message' => NULL,
            'dataRiwayat' => NULL,
            'dataDiagnosa' => NULL
        );

        if (!empty($_POST['poli'])) {
            $poli = $_POST['poli'];
            $tgl = date('d-m-Y');
            $idKunjungan = $this->pelayanan_model->getAntrianBerikutnyaByPoli($poli, $tgl);
            if (!empty($idKunjungan)) {
                $dataKunj = $this->reg_poli_model->dataKunjunganById($idKunjungan);
                if ($data != NULL) {
                    $data['data'] = $dataKunj;
                    $noRm = $dataKunj->mpas_id;
                    $data['dataRiwayat'] = $this->pelayanan_model->getDataRiwatatByRm($noRm);
                    $data['dataDiagnosa'] = $this->pelayanan_model->dataDiagnosaByIdKunj($idKunjungan);
                } else {
                    $data['message'] = 'Tidak ada data ditemukan kunjungan';
                }
            } else {
                $data['message'] = 'Tidak ada data ditemukan';
            }
        } else {
            $data['message'] = 'Harus memilih Poli';
        }
        echo json_encode($data);
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
            $trans_diagnosa = array(
                'tdiag_id' => !empty($_POST['idTransDiagnosa']) ? $_POST['idTransDiagnosa'] : '',
                'tdiag_nama' => !empty($_POST['namaDiagnosa']) ? $_POST['namaDiagnosa'] : '',
                'tdiag_keterangan' => !empty($_POST['keteranganDiagnosa']) ? $_POST['keteranganDiagnosa'] : '',
                'mpas_id' => !empty($_POST['noRmDiagnosa']) ? $_POST['noRmDiagnosa'] : '',
                'tkunj_id' => !empty($_POST['idKunjDiagnosa']) ? $_POST['idKunjDiagnosa'] : ''
            );
            $send = $this->pelayanan_model->simpanData($trans_diagnosa);
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
     * mengambil satu data
     */

    function get_data_diagnosa_by_id() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idTrans'])) {
            $idTrans = $_POST['idTrans'];
            $result = $this->pelayanan_model->dataDiagnosaByIdTrans($idTrans);
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

    function get_data_rs() {
        $data = array(
            'data' => NULL,
            'count' => 0,
            'message' => NULL
        );
        if (!empty($_POST['noRm'])) {
            $noRmLocal = $_POST['noRm'];
            $url = 'http://localhost/semar_server/index.php/api/rekam_medis/getrumahsakit/' . $noRmLocal;
            $header = array(
                'Accept' => 'application/json'
            );
            $request = Requests::get($url, $header);
            if (!empty($request->status_code)) {
                if ($request->status_code == '200') {
                    if (!empty($request->body)) {
                        $temp = json_decode($request->body);
                        if (!empty($temp->data)) {
                            $data['data'] = $temp->data;
                        } else {
                            $data['message'] = 'Tidak ada respons data dari server';
                        }
                    } else {
                        $data['message'] = 'Tidak ada respons dari server';
                    }
                } else {
                    $data['message'] = 'Proses gagal';
                }
            } else {
                $data['message'] = 'Terjadi masalah dengan format data';
            }
        } else {
            $data['message'] = 'identitas harus dikirim';
        }
        $data['count'] = count($data['data']);
        echo json_encode($data);
    }

    function proses_ambil_data_riwayat() {
        $data = array(
            'data' => NULL,
            'count' => 0,
            'message' => NULL
        );
        if (!empty($_POST['ambilIdRs'])) {

            $url = 'http://localhost/semar_server/index.php/api/rekam_medis/getpostrekamedik';
            $header = array(
                'Accept' => 'application/json'
            );
            $data['mrs_id'] = $_POST['ambilIdRs'];
            $data['tkunj_no_rm'] = $_POST['ambilNoRm'];

            $request = Requests::post($url, $header, $data);
            if (!empty($request->status_code)) {
                if ($request->status_code == '200') {
                    if (!empty($request->body)) {
                        $temp = json_decode($request->body);
                        if (!empty($temp->data)) {
                            $data['data'] = $temp->data;
                        } else {
                            $data['message'] = 'Tidak ada respons data dari server';
                        }
                    } else {
                        $data['message'] = 'Tidak ada respons dari server';
                    }
                } else {
                    $data['message'] = 'Proses gagal';
                }
            } else {
                $data['message'] = 'Terjadi masalah dengan format data';
            }
        } else {
            $data['message'] = 'identitas harus dikirim';
        }
        $data['count'] = count($data['data']);
        echo json_encode($data);
    }

}