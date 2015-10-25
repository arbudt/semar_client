<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_pasien extends MY_Controller {

    private $REST_PASIEN_SERVER = "http://localhost/semar_server/index.php/api/pasien/getpasien";

    function __construct() {
        parent::__construct();
        $this->load->model('registrasi/reg_pasien_model');
        $this->load->library('rest');
        Requests::register_autoloader();
    }

    function index() {
//        $data['previlages'] = $this->previlages;
        $data['page'] = 'registrasi/view_reg_pasien';
        $data['menuTitle'] = 'Pendaftaran Pasien';
        $data['menuDescription'] = 'Pendaftaran data pasien';

        $this->load->view('template', $data);
    }

    public function get_pasien($no_rm_nasional='') {
        $url = $this->REST_PASIEN_SERVER . '/' . $no_rm_nasional;
        $header = array(
            'Accept' => 'application/json'
        );


        $request = Requests::get($url, $header);
        $data = NULL;
        if (!empty($request->status_code)) {
            if ($request->status_code == '200') {
                if (!empty($request->body)) {
                    $temp = json_decode($request->body);
                    if (!empty($temp->pasien)) {
                        $data = $temp->pasien;
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

        return $data;
    }

    public function kirim_pasien($mpas_id='', $mrs_id='', $tkunj_norm='') {
        $headers = array(
            'Accept' => 'application/json'
        );
        $url = 'http://localhost/semar_server/index.php/api/pasien/save_pasien';
        $data = array(
            'mpas_id' => $mpas_id,
            'mrs_id' => $mrs_id,
            'tkunj_no_rm' => $tkunj_norm
        );
        $status = Requests::post($url, $headers, $data);
//        print_r($status);
    }

    /*
     * mengambil satu data
     */

    function proses_ambil_data_on_line() {
        $data = array(
            'data' => NULL,
            'message' => NULL,
            'optionsKab' => NULL,
            'optionskec' => NULL,
            'optionsKel' => NULL,
        );
        if (!empty($_POST['noRmNasional'])) {
            $noRmNasional = $_POST['noRmNasional'];
            $result = $this->get_pasien($noRmNasional);
            if ($result != NULL) {
                $data['data'] = $result;
                $data['optionsKab'] = $this->options_kabupaten_by_prop($result->rpro_id);
                $data['optionskec'] = $this->options_kecamatan_by_kab($result->rkab_id);
                $data['optionsKel'] = $this->options_kelurahan_by_kec($result->rkec_id);
            } else {
                $data['message'] = 'Tidak ada data ditemukan';
            }
        } else {
            $data['message'] = 'identitas harus dikirim';
        }
        echo json_encode($data);
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
     * data kabupaten
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

    public function get_options_kecamatan_by_kab() {
        $respon = '';
        if (!empty($_POST['kode'])) {

            $respon = $this->options_kecamatan_by_kab($_POST['kode']);
        } else {
            $respon = '<option value="">...nul</option>';
        }
        echo $respon;
    }

    /*
     * data kecamatan
     */

    function options_kecamatan_by_kab($id) {
        $respon = '';
        if (!empty($id)) {
            $data = $this->reg_pasien_model->getDataKecamatanBykab($id);
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

    public function get_options_kelurahan_by_kec() {
        $respon = '';
        if (!empty($_POST['kode'])) {

            $respon = $this->options_kelurahan_by_kec($_POST['kode']);
        } else {
            $respon = '<option value="">...nul</option>';
        }
        echo $respon;
    }

    /*
     * data kelurahan
     */

    function options_kelurahan_by_kec($id) {
        $respon = '';
        if (!empty($id)) {
            $data = $this->reg_pasien_model->getDataKelurahanBykec($id);
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
            $data = $this->reg_pasien_model->tableDescription($tableName);
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
            $data = $this->reg_pasien_model->tableDescription($tableName);
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

    function proses_simpan() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'noRm' => NULL
        );
        if (!empty($_POST)) {
            $mst_pasien = array(
                'mpas_id' => !empty($_POST['noRm']) ? $_POST['noRm'] : '',
                'mpas_nama' => !empty($_POST['namaPasien']) ? $_POST['namaPasien'] : '',
                'mpas_jenis_kelamin' => !empty($_POST['jenisKelamin']) ? $_POST['jenisKelamin'] : '',
                'mpas_tempat_lahir' => !empty($_POST['tempatLahir']) ? $_POST['tempatLahir'] : '',
                'mpas_tanggal_lahir' => !empty($_POST['tanggalLahir']) ? $_POST['tanggalLahir'] : '',
                'rsk_id' => !empty($_POST['statusKawin']) ? $_POST['statusKawin'] : '',
                'rag_id' => !empty($_POST['agama']) ? $_POST['agama'] : '',
                'rgd_id' => !empty($_POST['golonganDarah']) ? $_POST['golonganDarah'] : '',
                'mpas_telepon' => !empty($_POST['noTelepon']) ? $_POST['noTelepon'] : '',
                'mpas_hp' => !empty($_POST['noHp']) ? $_POST['noHp'] : '',
                'mpas_no_identitas' => !empty($_POST['noIdentitas']) ? $_POST['noIdentitas'] : '',
                'mpas_alamat' => !empty($_POST['alamat']) ? $_POST['alamat'] : '',
                'rpro_id' => !empty($_POST['propinsi']) ? $_POST['propinsi'] : '',
                'rkab_id' => !empty($_POST['kabupaten']) ? $_POST['kabupaten'] : '',
                'rkec_id' => !empty($_POST['kecamatan']) ? $_POST['kecamatan'] : '',
                'rkel_id' => !empty($_POST['kelurahan']) ? $_POST['kelurahan'] : '',
                'rpend_id' => !empty($_POST['pendidikan']) ? $_POST['pendidikan'] : '',
                'rpek_id' => !empty($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '',
                'mpas_alergi' => !empty($_POST['alergi']) ? $_POST['alergi'] : ''
            );
            $send = $this->reg_pasien_model->simpanData($mst_pasien);
            if ($send['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['noRm'] = $send['mpas_id'];
                $data['message'] = 'Proses simpan berhasil';
                if (!empty($_POST['isOnLine']) && empty($_POST['noRm']) && !empty($_POST['noRmOnline'])) {
                    $this->kirim_pasien($_POST['noRmOnline'], '1', $data['noRm']);
                }
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

    function cari_list_pasien() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['listNoRm']) || !empty($_POST['listNama'])) {
            $noRM = $_POST['listNoRm'];
            $nama = $_POST['listNama'];
            $result = $this->reg_pasien_model->dataPasienByFilter($noRM, $nama);
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

    function get_data_pasien_by_id() {
        $data = array(
            'data' => NULL,
            'message' => NULL,
            'optionsKab' => NULL,
            'optionskec' => NULL,
            'optionsKel' => NULL,
        );
        if (!empty($_POST['noRm'])) {
            $idTrans = $_POST['noRm'];
            $result = $this->reg_pasien_model->dataPasienByDd($idTrans);
            if ($result != NULL) {
                $data['data'] = $result;
                $data['optionsKab'] = $this->options_kabupaten_by_prop($result->rpro_id);
                $data['optionskec'] = $this->options_kecamatan_by_kab($result->rkab_id);
                $data['optionsKel'] = $this->options_kelurahan_by_kec($result->rkec_id);
            } else {
                $data['message'] = 'Tidak ada data ditemukan';
            }
        } else {
            $data['message'] = 'identitas harus dikirim';
        }
        echo json_encode($data);
    }

    public function data_test() {
        echo 'sukses';
    }

    public function test() {
        echo dropDownTest();
    }

}