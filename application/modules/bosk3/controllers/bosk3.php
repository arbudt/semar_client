<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bosk3 extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bosk3/bosk3_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'bosk3/view_bosk3';
        $data['menuTitle'] = 'BOS K3';
        $data['menuDescription'] = 'Buku Kas Umum';
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
            $trans_k3 = array(
                'k3_code' => !empty($_POST['idTrans']) ? $_POST['idTrans'] : '',
                'k3_tahun_code' => !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : '',
                'k3_triwulan_code' => !empty($_POST['triwulan']) ? $_POST['triwulan'] : '',
                'k3_date' => !empty($_POST['tanggal']) ? dateReverse($_POST['tanggal']) : dateReverse(tglSekarang()),
                'k3_no_bukti' => !empty($_POST['noBukti']) ? $_POST['noBukti'] : '',
                'k3_no_kode' => !empty($_POST['noKode']) ? $_POST['noKode'] : '',
                'k3_uraian' => !empty($_POST['uraian']) ? $_POST['uraian'] : '',
                'k3_price' => !empty($_POST['jumlahPengeluaran']) ? $_POST['jumlahPengeluaran'] : 0,
                'k3_input_pph' => !empty($_POST['isInputPPh']) ? $_POST['isInputPPh'] : 0,
                'k3_user_update' => $this->userId
            );
            $send = $this->bosk3_model->simpanData($trans_k3);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['idTrans'] = $send['idTrans'];
                $data['message'] = 'Proses simpan berhasil';
                if (!empty($_POST['idTrans'])) {
                    addLogAktifity('bos k3', 'update', 'edit data dengan kode k3 : ' . $send['idTrans']);
                } else {
                    addLogAktifity('bos k3', 'insert', 'tambah data dengan kode k3 : ' . $send['idTrans']);
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
            $send = $this->bosk3_model->simpanData($trans_k3);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses hapus berhasil';
                addLogAktifity('bos k3', 'delete', 'hapus data dengan kode k3 : ' . $_POST['idTrans']);
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
            'saldo' => 0,
            'saldoKemarin' => 0,
            'totalPengeluaran' => 0,
            'totalPenerimaan' => 0,
            'totalSaldo' => 0,
            'message' => NULL
        );
        if (!empty($_POST['tahun']) && !empty($_POST['triwulan'])) {
            $tahun = $_POST['tahun'];
            $triwulan = $_POST['triwulan'];
            $saldo = $this->bosk3_model->saldoBosByTahunTriwulan($tahun, $triwulan);
            $saldoKemarin = $this->bosk3_model->saldoBosTriwulanKemarinByTahunTriwulan($tahun, $triwulan);
            $result = $this->bosk3_model->dataTransByFilter($tahun, $triwulan);
            $arrData[] = array(
                'ID_TRANS' => NULL,
                'TGL' => '',
                'NO_BUKTI' => '',
                'NO_KODE' => '',
                'URAIAN' => 'Sisa triwulan Kemarin',
                'JUMLAH_PENERIMAAN' => number_format($saldoKemarin, 2),
                'JUMLAH_PENGELUARAN' => number_format(0, 2),
                'JUMLAH_SALDO' => number_format($saldoKemarin, 2),
                'IS_DETAIL' => 0
            );

            $totalSaldo = $saldoKemarin + $saldo;
            $totalPenerimaan = $totalSaldo;
            $totalPengeluaran = 0;
            $arrData[] = array(
                'ID_TRANS' => NULL,
                'TGL' => '',
                'NO_BUKTI' => '',
                'NO_KODE' => '',
                'URAIAN' => 'Terima BOS',
                'JUMLAH_PENERIMAAN' => number_format($saldo, 2),
                'JUMLAH_PENGELUARAN' => number_format(0, 2),
                'JUMLAH_SALDO' => number_format($totalSaldo, 2),
                'IS_DETAIL' => 0
            );
            if ($result != NULL) {
                foreach ($result as $row) {
                    $keluar = $row->JUMLAH_PENGELUARAN;
                    $totalPengeluaran = $totalPengeluaran + $keluar;
                    $totalSaldo = $totalSaldo - $keluar;
                    $arrData[] = array(
                        'ID_TRANS' => $row->ID_TRANS,
                        'TGL' => $row->TGL,
                        'NO_BUKTI' => $row->NO_BUKTI,
                        'NO_KODE' => $row->NO_KODE,
                        'URAIAN' => $row->URAIAN,
                        'JUMLAH_PENERIMAAN' => number_format(0, 2),
                        'JUMLAH_PENGELUARAN' => number_format($keluar, 2),
                        'JUMLAH_SALDO' => number_format($totalSaldo, 2),
                    );
                    if ($row->INPUT_PPH == '1') {//hitung nilai pph (penerimaan)
                        $nilaiPPh = intval($keluar) * 15 / 100;
                        $totalSaldo = $totalSaldo + $nilaiPPh;
                        $arrData[] = array(
                            'ID_TRANS' => NULL,
                            'TGL' => $row->TGL,
                            'NO_BUKTI' => '',
                            'NO_KODE' => '',
                            'URAIAN' => 'PPh',
                            'JUMLAH_PENERIMAAN' => number_format($nilaiPPh, 2),
                            'JUMLAH_PENGELUARAN' => number_format(0, 2),
                            'JUMLAH_SALDO' => number_format($totalSaldo, 2)
                        );
                    }
                }
            } else {
                $data['message'] = 'Tidak ada data ditemukan';
            }
            $data['saldo'] = $saldo;
            $data['saldoKemarin'] = $saldoKemarin;
            $data['data'] = $arrData;
            $data['totalPenerimaan'] = number_format($totalPenerimaan, 2);
            $data['totalPengeluaran'] = number_format($totalPengeluaran, 2);
            $data['totalSaldo'] = number_format($totalSaldo, 2);
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
            $result = $this->bosk3_model->dataTransById($idTrans);
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

    /*
     * mengambil saldo saat ini dana bos
     */

    public function getSaldoBos() {
        $data = array(
            'saldo' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['triwulan'])) {
            $triwulan = $_POST['triwulan'];
            $saldo = $this->bosk3_model->saldoBosByTriwulan($triwulan);
            $data['saldo'] = $saldo;
        } else {
            $data['message'] = 'identitas harus dikirim';
        }
        echo json_encode($data);
    }

}
?>