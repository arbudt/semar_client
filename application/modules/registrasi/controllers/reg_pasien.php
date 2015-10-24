<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_pasien extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('registrasi/reg_pasien_model');
    }

    function index() {
        $data['previlages'] = $this->previlages;
        $data['page'] = 'registrasi/view_reg_pasien';
        $data['menuTitle'] = 'Pendaftaran Pasien';
        $data['menuDescription'] = 'Pendaftaran data pasien';

        $optionsStatusKawin = '';
        $this->load->view('template', $data);
    }

    public function get_options_kabupaten_by_prop() {
        
        $respon = '';
        if (!empty($_POST['kode'])) {
            
            $respon = $this->options_kabupaten_by_prop($_POST['kode']);
        } else {
            $respon = '<option value="">...nul</option>';
        }
        echo $respon;
    }

    /*
     * options dokter by ksm
     */

    function options_kabupaten_by_prop($idPropinsi) {
        $respon = '';
        if (!empty($idPropinsi)) {
            $data = $this->reg_pasien_model->getDataKabupatenByProp($idPropinsi);
            if ($data != NULL) {
                $i = 0;
                foreach ($data as $row) {
                    $i++;
                    $respon .= '<option value="' . $row->kode . '">' . $row->nama . '</option>';
                }
                if ($i > 1) {
                    $respon = '<option value="">...</option>' . $respon;
                }
            } else {
                $respon = '<option value="">...</option>';
            }
        } else {
            $respon = '<option value="">...</option>';
        }
        return $respon;
    }

    /*
     * menampilkan desc table
     */

    function getTableDescriptin($tableName = '') {
        if (!empty($tableName)) {
            $data = $this->bosk1_model->tableDescription($tableName);
            if ($data != NULL) {
                echo "$" . $tableName . " = array(<br>";
                $i = 0;
                while ($i < (count($data) - 1)) {
                    echo "'" . $data[$i]['Field'] . "' => " . $data[$i]['Type'] . ",<br>";
                    $i++;
                }
                echo "'" . $data[$i]['Field'] . "' => " . $data[$i]['Type'] . "<br>";
                echo ');';
            } else {
                echo 'Table not found';
            }
        } else {
            echo 'Table not found';
        }
    }

    /*
     * menampilkan desc table
     */

    function getTableDescriptinWithValidValue($tableName = '') {
        if (!empty($tableName)) {
            $data = $this->bosk1_model->tableDescription($tableName);
            if ($data != NULL) {
                echo "$" . $tableName . " = array(<br>";
                $i = 0;
                while ($i < (count($data) - 1)) {
                    echo "'" . $data[$i]['Field'] . "' => " . '! empty ($_POST[\'Type\'])? $_POST[\'Type\']:\'\',<br>';
                    $i++;
                }
                echo "'" . $data[$i]['Field'] . "' => " . '! empty ($_POST[\'Type\'])? $_POST[\'Type\']:\'\'<br>';
                echo ');';
            } else {
                echo 'Table not found';
            }
        } else {
            echo 'Table not found';
        }
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
            $trans_k1 = array(
                'k1_code' => !empty($_POST['idTrans']) ? $_POST['idTrans'] : '',
                'k1_tahun_code' => !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : '',
                'k1_triwulan_code' => !empty($_POST['triwulan']) ? $_POST['triwulan'] : '',
                'k1_donatur_code' => !empty($_POST['sumberDanaBos']) ? $_POST['sumberDanaBos'] : '',
                'k1_nns' => nns(),
                'k1_jumlah_siswa' => !empty($_POST['jumlahSiswa']) ? $_POST['jumlahSiswa'] : '',
                'k1_uang_per_siswa' => !empty($_POST['jumlahUangPerSiswa']) ? $_POST['jumlahUangPerSiswa'] : '',
                'k1_date' => !empty($_POST['tanggal']) ? dateReverse($_POST['tanggal']) : dateReverse(tglSekarang()),
                'k1_no_urut' => !empty($_POST['noUrutTerima']) ? $_POST['noUrutTerima'] : '',
                'k1_no_kode' => !empty($_POST['noKodeTerima']) ? $_POST['noKodeTerima'] : '',
                'k1_uraian' => !empty($_POST['uraianTerima']) ? $_POST['uraianTerima'] : '',
                'k1_uang_terima' => !empty($_POST['jumlahTerima']) ? $_POST['jumlahTerima'] : 0,
                'k1_user_update' => $this->userId
            );

            if (!empty($_POST['idTrans'])) {//proses edit
                $send = $this->bosk1_model->simpanData($trans_k1);
                if ($send['status'] == TRUE) {
                    $data['status'] = TRUE;
                    $data['idTrans'] = $send['idTrans'];
                    $data['message'] = 'Proses simpan berhasil';
                    addLogAktifity('bos k1', 'update', 'edit data dengan kode k1 : ' . $_POST['idTrans']);
                } else {
                    $data['status'] = FALSE;
                    $data['message'] = 'Proses simpan gagal';
                }
            } else {
                $tahun = !empty($_POST['tahunAjaran']) ? $_POST['tahunAjaran'] : '';
                $triwulan = !empty($_POST['triwulan']) ? $_POST['triwulan'] : '';
                $sumberDana = !empty($_POST['sumberDanaBos']) ? $_POST['sumberDanaBos'] : '';

                if ($this->bosk1_model->cekSudahAdaDataBos($tahun, $triwulan, $sumberDana) == FALSE) {
                    $send = $this->bosk1_model->simpanData($trans_k1);
                    if ($send['status'] == TRUE) {
                        $data['status'] = TRUE;
                        $data['idTrans'] = $send['idTrans'];
                        $data['message'] = 'Proses simpan berhasil';
                        addLogAktifity('bos k1', 'insert', 'tambah data dengan kode k1 : ' . $send['idTrans']);
                    } else {
                        $data['status'] = FALSE;
                        $data['message'] = 'Proses simpan gagal';
                    }
                } else {
                    $data['message'] = 'Penerimaan Dana Bos dengan sumber dana, triwulan dan tahun terpilih sudah ada';
                }
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
            $trans_k1 = array(
                'k1_code' => $_POST['idTrans'],
                'k1_user_update' => $this->userId,
                'k1_status' => 1
            );
            $send = $this->bosk1_model->simpanData($trans_k1);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses hapus berhasil';
                addLogAktifity('bos k1', 'delete', 'hapus data dengan kode k1 : ' . $_POST['idTrans']);
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
            $result = $this->bosk1_model->dataTransByFilter($tahun, $triwulan);
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
            $result = $this->bosk1_model->dataTransById($idTrans);
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