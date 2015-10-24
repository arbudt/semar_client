<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bosk6 extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bosk6/bosk6_model');
        $this->load->model('bosk3/bosk3_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'bosk6/view_bosk6';
        $data['menuTitle'] = 'BOS K6';
        $data['menuDescription'] = 'Buku Pembantu Pajak';
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
            $trans_k6 = array(
                'k6_code' => !empty($_POST['idTrans']) ? $_POST['idTrans'] : '',
                'k6_tahun_code' => !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : '',
                'k6_triwulan_code' => !empty($_POST['triwulan']) ? $_POST['triwulan'] : '',
                'k6_date' => !empty($_POST['tanggal']) ? dateReverse($_POST['tanggal']) : dateReverse(tglSekarang()),
                'k6_no_bukti' => !empty($_POST['noBukti']) ? $_POST['noBukti'] : '',
                'k6_no_kode' => !empty($_POST['noKode']) ? $_POST['noKode'] : '',
                'k6_uraian' => !empty($_POST['uraian']) ? $_POST['uraian'] : '',
                'k6_ppn' => !empty($_POST['jumlahPengeluaranPPN']) ? $_POST['jumlahPengeluaranPPN'] : 0,
                'k6_ppn21' => !empty($_POST['jumlahPengeluaranPPN21']) ? $_POST['jumlahPengeluaranPPN21'] : 0,
                'k6_ppn22' => !empty($_POST['jumlahPengeluaranPPN22']) ? $_POST['jumlahPengeluaranPPN22'] : 0,
                'k6_ppn23' => !empty($_POST['jumlahPengeluaranPPN23']) ? $_POST['jumlahPengeluaranPPN23'] : 0,
                'k6_total_price' => !empty($_POST['jumlahTotalPengeluaran']) ? $_POST['jumlahTotalPengeluaran'] : 0,
                'k6_user_update' => $this->userId
            );
            $send = $this->bosk6_model->simpanData($trans_k6);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['idTrans'] = $send['idTrans'];
                $data['message'] = 'Proses simpan berhasil';
                if (!empty($_POST['idTrans'])) {
                    addLogAktifity('bos k6', 'update', 'edit data dengan kode k6 : ' . $send['idTrans']);
                } else {
                    addLogAktifity('bos k6', 'insert', 'tambah data dengan kode k6 : ' . $send['idTrans']);
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
            $trans_k6 = array(
                'k6_code' => $_POST['idTrans'],
                'k6_user_update' => $this->userId,
                'k6_status' => 1
            );
            $send = $this->bosk6_model->simpanData($trans_k6);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses hapus berhasil';
                addLogAktifity('bos k6', 'delete', 'hapus data dengan kode k6 : ' . $_POST['idTrans']);
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
            $dataK6 = array();
            $resultPPhK3 = $this->bosk6_model->dataTransPPhK3ByFilter($tahun, $triwulan);
            if ($resultPPhK3 != NULL) {
                foreach ($resultPPhK3 as $row) {
                    if ($row->INPUT_PPH == '1') {//hitung nilai pph (penerimaan)
                        $keluar = $row->JUMLAH_PENGELUARAN;
                        $nilaiPPh21 = intval($keluar) * 15 / 100;
                        $dataK6[] = array(
                            'ID_TRANS' => NULL,
                            'TGL' => $row->TGL,
                            'NO_BUKTI' => $row->NO_BUKTI,
                            'NO_KODE' => $row->NO_KODE,
                            'URAIAN' => $row->URAIAN,
                            'JUMLAH_PPN' => '0',
                            'JUMLAH_PPN21' => $nilaiPPh21,
                            'JUMLAH_PPN22' => '0',
                            'JUMLAH_PPN23' => '0',
                            'JUMLAH_TOTAL' => $nilaiPPh21,
                            'NAMA_TRIWULAN' => $row->NAMA_TRIWULAN
                        );
                    }
                }
            }

            $result = $this->bosk6_model->dataTransByFilter($tahun, $triwulan);
            if ($result != NULL) {
                foreach ($result as $row) {
                    $dataK6[] = array(
                        'ID_TRANS' => $row->ID_TRANS,
                        'TGL' => $row->TGL,
                        'NO_BUKTI' => $row->NO_BUKTI,
                        'NO_KODE' => $row->NO_KODE,
                        'URAIAN' => $row->URAIAN,
                        'JUMLAH_PPN' => $row->JUMLAH_PPN,
                        'JUMLAH_PPN21' => $row->JUMLAH_PPN21,
                        'JUMLAH_PPN22' => $row->JUMLAH_PPN22,
                        'JUMLAH_PPN23' => $row->JUMLAH_PPN23,
                        'JUMLAH_TOTAL' => $row->JUMLAH_TOTAL,
                        'NAMA_TRIWULAN' => $row->NAMA_TRIWULAN
                    );
                }
            }
            if (!empty($dataK6)) {
                $data['data'] = $dataK6;
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
            $result = $this->bosk6_model->dataTransById($idTrans);
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