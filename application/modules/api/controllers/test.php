<?php

class Test extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('api/lis_model'));
        $this->load->library('rest');
        Requests::register_autoloader();
    }

    function index() {
        
    }

    /*
     * oke
     */

    function testing_get_content() {
        $url = 'http://admin:1234@arif.simrs.dev/index.php/api/lis/hasil/201401020164';
        $data = file_get_contents($url);
        pr($data);
    }

    /*
     * oke
     */

    function rest_client_example() {
        $url = 'http://admin:1234@arif.simrs.dev/index.php/api/lis/hasil/201401020164';

        $data = $this->rest->get($url);
//        $data = $this->rest->get($url, array('no_lab' => '201401020164'));

        pr($data);
    }

    function rest_client() {
        $this->load->library('rest', array(
            'server' => 'http://arif.simrs.dev/index.php/api/lis',
            'api_key' => 'Setec_Astronomy',
            'api_name' => 'X-API-KEY',
            'http_user' => 'admin',
            'http_pass' => '1234',
            'http_auth' => 'basic',
            'ssl_verify_peer' => TRUE,
            'ssl_cainfo' => '/certs/cert.pem',
//            'X-Authorization': 'user:deadbeef' 
        ));
        $data = $this->rest->get('hasil', array('no_lab' => '201401020164'));
        pr($data);
    }

    function sample() {
        $stringDataHasil = '[
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PPT",
      "kode_analis": "2535",
      "nilai": "17.9",
      "level": "",
      "kode_produk": "01.12.102_",
      "satuan": "detik",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "INR",
      "kode_analis": "2535",
      "nilai": "15.0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "APTT",
      "kode_analis": "2535",
      "nilai": "34.1",
      "level": "",
      "kode_produk": "01.12.103",
      "satuan": "detik",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "APTT",
      "kode_analis": "2535",
      "nilai": "30.9",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PO2",
      "kode_analis": "2535",
      "nilai": "136,2",
      "level": "",
      "kode_produk": "",
      "satuan": "mmHg",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PCO2",
      "kode_analis": "2535",
      "nilai": "32,5",
      "level": "",
      "kode_produk": "",
      "satuan": "mmHg",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PH-AGD",
      "kode_analis": "2535",
      "nilai": "7,456",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "Thb-AGD",
      "kode_analis": "2535",
      "nilai": "14,3",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "SO2",
      "kode_analis": "2535",
      "nilai": "99,2",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "CHCO3",
      "kode_analis": "2535",
      "nilai": "22,4",
      "level": "",
      "kode_produk": "",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "CTCO2P",
      "kode_analis": "2535",
      "nilai": "23,4",
      "level": "",
      "kode_produk": "",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "BE",
      "kode_analis": "2535",
      "nilai": "-0,6",
      "level": "",
      "kode_produk": "",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "CHCO3ST",
      "kode_analis": "2535",
      "nilai": "23,8",
      "level": "",
      "kode_produk": "",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "BEECF",
      "kode_analis": "2535",
      "nilai": "-1,4",
      "level": "",
      "kode_produk": "",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "SO2C",
      "kode_analis": "2535",
      "nilai": "99,2",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "AADO2",
      "kode_analis": "2535",
      "nilai": "74,0",
      "level": "",
      "kode_produk": "",
      "satuan": "mmHg",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "ctO2",
      "kode_analis": "2535",
      "nilai": "20,1",
      "level": "",
      "kode_produk": "",
      "satuan": "Vol%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "AAO2",
      "kode_analis": "2535",
      "nilai": "64,8",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "BB",
      "kode_analis": "2535",
      "nilai": "47,1",
      "level": "",
      "kode_produk": "",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "RI",
      "kode_analis": "2535",
      "nilai": "54,0",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "FIO2",
      "kode_analis": "2535",
      "nilai": "0,350",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "BARO-AGD",
      "kode_analis": "2535",
      "nilai": "752,0",
      "level": "",
      "kode_produk": "",
      "satuan": "mmHg",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "TEMP-AGD",
      "kode_analis": "2535",
      "nilai": "38,6",
      "level": "",
      "kode_produk": "",
      "satuan": "C",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "GLU-UL",
      "kode_analis": "2535",
      "nilai": "1+",
      "level": "",
      "kode_produk": "",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PROT-UL",
      "kode_analis": "2535",
      "nilai": "+-",
      "level": "",
      "kode_produk": "01.12.019",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "BIL-UL",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "01.12.020",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "URO-UL",
      "kode_analis": "2535",
      "nilai": "NORMAL",
      "level": "",
      "kode_produk": "01.12.021",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PH-UL",
      "kode_analis": "2535",
      "nilai": "5,5",
      "level": "",
      "kode_produk": "01.12.023",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PH-UL",
      "kode_analis": "2535",
      "nilai": ">1.030",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "BLOOD-UL",
      "kode_analis": "2535",
      "nilai": "3+",
      "level": "",
      "kode_produk": "",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "KETON-UL",
      "kode_analis": "2535",
      "nilai": "0,0",
      "level": "",
      "kode_produk": "01.12.022",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "NITRIT-UL",
      "kode_analis": "2535",
      "nilai": "0,0",
      "level": "",
      "kode_produk": "",
      "satuan": "mg/L",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "LEU-UL",
      "kode_analis": "2535",
      "nilai": "250,0",
      "level": "",
      "kode_produk": "",
      "satuan": "LEU/U",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "WARNA-UL",
      "kode_analis": "2535",
      "nilai": "YELLOW",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "SEL",
      "kode_analis": "2535",
      "nilai": ".",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "LEKO",
      "kode_analis": "2535",
      "nilai": "+",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "GLITTERCEL",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "LEKO",
      "kode_analis": "2535",
      "nilai": "+",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "ERIT",
      "kode_analis": "2535",
      "nilai": "+++",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "TUBU",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "VES",
      "kode_analis": "2535",
      "nilai": "0-1",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "VAG",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "URETH",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "SILINDER",
      "kode_analis": "2535",
      "nilai": ".",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "HIALIN",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "GRANULER",
      "kode_analis": "2535",
      "nilai": "+",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "EPITEL",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "ERITROSIT",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "LEKOSIT",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "KRISTAL",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "CA-OXALAT",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "TRIFOSFAT",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "ASURAT",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "ASURAT",
      "kode_analis": "2535",
      "nilai": "0",
      "level": "",
      "kode_produk": "",
      "satuan": "",
      "kode_dokter": "2539",
      "nilai_normal": " -",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "WBC-XN",
      "kode_analis": "2535",
      "nilai": "15.38",
      "level": "",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "RBC-XN",
      "kode_analis": "2535",
      "nilai": "5.02",
      "level": "",
      "kode_produk": "",
      "satuan": "10^6/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "HGB-XN",
      "kode_analis": "2535",
      "nilai": "13.6",
      "level": "",
      "kode_produk": "",
      "satuan": "g/dL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "HCT-XN",
      "kode_analis": "2535",
      "nilai": "41.0",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "MCV-XN",
      "kode_analis": "2535",
      "nilai": "81.7",
      "level": "",
      "kode_produk": "",
      "satuan": "fl",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "MCH-XN",
      "kode_analis": "2535",
      "nilai": "27.1",
      "level": "",
      "kode_produk": "",
      "satuan": "pg",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "MCHC-XN",
      "kode_analis": "2535",
      "nilai": "33.2",
      "level": "",
      "kode_produk": "",
      "satuan": "g/dL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PLT-XN",
      "kode_analis": "2535",
      "nilai": "147",
      "level": "L",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "150 - 450",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "RDW-SD-XN",
      "kode_analis": "2535",
      "nilai": "44.8",
      "level": "",
      "kode_produk": "",
      "satuan": "fL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "RDW-CV-XN",
      "kode_analis": "2535",
      "nilai": "15.1",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PDW-XN",
      "kode_analis": "2535",
      "nilai": "14.9",
      "level": "",
      "kode_produk": "",
      "satuan": "fl",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "MPV-XN",
      "kode_analis": "2535",
      "nilai": "11.5",
      "level": "",
      "kode_produk": "",
      "satuan": "fl",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "P-LCR-XN",
      "kode_analis": "2535",
      "nilai": "36.5",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "PCT-XN",
      "kode_analis": "2535",
      "nilai": "0.17",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "NRBC#-XN",
      "kode_analis": "2535",
      "nilai": "0.00",
      "level": "",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "NEUT#-XN",
      "kode_analis": "2535",
      "nilai": "12.23",
      "level": "",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "LYMPH#-XN",
      "kode_analis": "2535",
      "nilai": "1.41",
      "level": "",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "MONO#-XN",
      "kode_analis": "2535",
      "nilai": "1.67",
      "level": "",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "EO#-XN",
      "kode_analis": "2535",
      "nilai": "0.00",
      "level": "",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "BASO#-XN",
      "kode_analis": "2535",
      "nilai": "0.07",
      "level": "",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "IG#-XN",
      "kode_analis": "2535",
      "nilai": "0.96",
      "level": "",
      "kode_produk": "",
      "satuan": "10^3/µL",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "NRBC%-XN",
      "kode_analis": "2535",
      "nilai": "0.0",
      "level": "A",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "0",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "NEUT%-XN",
      "kode_analis": "2535",
      "nilai": "79.4",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "LYMPH%-XN",
      "kode_analis": "2535",
      "nilai": "9.2",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "MONO%-XN",
      "kode_analis": "2535",
      "nilai": "10.9",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "EO%-XN",
      "kode_analis": "2535",
      "nilai": "0.0",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "BASO%-XN",
      "kode_analis": "2535",
      "nilai": "0.5",
      "level": "",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "IG%-XN",
      "kode_analis": "2535",
      "nilai": "6.2",
      "level": "A",
      "kode_produk": "",
      "satuan": "%",
      "kode_dokter": "2539",
      "nilai_normal": "0/100%",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "SGOT-COBAS",
      "kode_analis": "2535",
      "nilai": "18",
      "level": "",
      "kode_produk": "01.12.337",
      "satuan": "U/L",
      "kode_dokter": "2539",
      "nilai_normal": "<= 40",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "SGPT-COBAS",
      "kode_analis": "2535",
      "nilai": "9",
      "level": "",
      "kode_produk": "01.12.332",
      "satuan": "U/L",
      "kode_dokter": "2539",
      "nilai_normal": "<= 41",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "UREUM-COBAS",
      "kode_analis": "2535",
      "nilai": "29,90",
      "level": "H",
      "kode_produk": "01.12.282",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": "6,00 - 20,00",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "CREA-COBAS",
      "kode_analis": "2535",
      "nilai": "1,33",
      "level": "H",
      "kode_produk": "01.12.046",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": "0,70 - 1,20",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "UA-COBAS",
      "kode_analis": "2535",
      "nilai": "5,1",
      "level": "",
      "kode_produk": "01.12.234",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": "3,4 - 7,0",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "GDS-COBAS",
      "kode_analis": "2535",
      "nilai": "177",
      "level": "H",
      "kode_produk": "01.12.366",
      "satuan": "mg/dL",
      "kode_dokter": "2539",
      "nilai_normal": "80 - 140",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "NA",
      "kode_analis": "2535",
      "nilai": "132",
      "level": "L",
      "kode_produk": "01.12.057",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "136 - 145",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "K",
      "kode_analis": "2535",
      "nilai": "2,99",
      "level": "L",
      "kode_produk": "01.12.052",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "3,50 - 5,10",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   },
   {
      "kode_dokter_verifikator": "2801",
      "tanggal_verif_pemeriksa": "2014-06-17 18:54:16",
      "nama_komponen": "CL",
      "kode_analis": "2535",
      "nilai": "90",
      "level": "L",
      "kode_produk": "01.12.416",
      "satuan": "mmol/L",
      "kode_dokter": "2539",
      "nilai_normal": "98 - 107",
      "tanggal_verif_analis": "2014-06-17 18:54:16"
   }
]';

        $arrHasil = json_decode($stringDataHasil);
        echo $arrHasil[0]['kode_dokter_verifikator'];
        echo 'hasil';
        echo '<pre>';
        print_r($arrHasil);
        echo '</pre>';

        $stringDataPasien = '';

        $stringSample = '{"THLIS_ID":"159","TRANS_KUNJ_PASIEN_TKPAS_ID":"330838","THLIS_NOMR":"00358688","THLIS_RKURAI_DESC":"testing","MST_PRODUK_MPRO_KODE":"01.12.102_","TR_DET_WO_PNJNG_TDWPEN_ID":null,"THLIS_USERUPDATE":"42","THLIS_ORDER":"4061708867","THLIS_PRODUK_MANUAL":null,"THLIS_IS_MANUAL":"1"}';
        echo '<br>';
        echo '<pre>';
        print_r($stringSample);
        echo '</pre>';

        $stringLagi = '{
   "THLIS_ID": "159",
   "TRANS_KUNJ_PASIEN_TKPAS_ID": "330838",
   "THLIS_NOMR": "00358688",
   "THLIS_RKURAI_DESC": "testing",
   "MST_PRODUK_MPRO_KODE": "01.12.102_",
   "TR_DET_WO_PNJNG_TDWPEN_ID": null,
   "THLIS_USERUPDATE": "42",
   "THLIS_ORDER": "4061708867",
   "THLIS_PRODUK_MANUAL": null,
   "THLIS_IS_MANUAL": "1"
}';
        $array = array(
            "TRANS_KUNJ_PASIEN_TKPAS_ID" => "330838",
            "THLIS_NOMR" => "00358688",
            "THLIS_RKURAI_DESC" => "testing",
            "MST_PRODUK_MPRO_KODE" => "01.12.102",
            "TR_DET_WO_PNJNG_TDWPEN_ID" => null,
            "THLIS_USERUPDATE" => "42",
            "THLIS_ORDER" => "4061708867",
            "THLIS_PRODUK_MANUAL" => null,
            "THLIS_IS_MANUAL" => "1"
        );
//        $this->lis_model->sample($array);

        $dataPasien = array(
            'no_rm' => '00358688', /* No MR */
            'nama_pasien' => 'Nama Pasien', /* Nama Pasien */
            'no_lab' => '4061708867', /* No Lab 201401020164 */
            'tanggal_order' => '2014-06-17 18:53:08', /* Tanggal Order (format: DD/MM/YYYY HH24:MI:SS) */
            'tanggal_kirim_hasil' => '2014-06-17 18:53:08', /* Tanggal pengiriman hasil (format: DD/MM/YYYY HH24:MI:SS) */
            'catatan' => 'testing' /* Catatan komentar deskripsi */
        );


        $dataHasil = array(
            array(
                'kode_produk' => '01.12.102_', /* Kode produk */
                'nama_komponen' => 'PPT', /* Detail komponen produk */
                'nilai' => '17.9', /* Nilai hasil */
                'satuan' => 'detik', /* Satuan hasil */
                'level' => '', /* Level hasil (normal / abnormal) */
                'nilai_normal' => '', /* Nilai Normal */
                'tanggal_verif_analis' => '2014-06-17 18:54:16', /* Tanggal verif analis (format: DD/MM/YYYY HH24:MI:SS) */
                'tanggal_verif_pemeriksa' => '2014-06-17 18:54:16', /* Tanggal verif dokter pemeriksa (format: DD/MM/YYYY HH24:MI:SS) */
                'kode_analis' => '2535', /* kode analis (kode pegawai) */
                'kode_dokter' => '2539', /* kode dokter (kode pegawai) */
                'kode_dokter_verifikator' => '2801' /* kode dokter verifikator (kode pegawai) */
            ),
            array(
                'kode_produk' => '',
                'nama_komponen' => 'INR',
                'nilai' => '15.0',
                'satuan' => '',
                'level' => '',
                'nilai_normal' => '',
                'tanggal_verif_analis' => '2014-06-17 18:54:16',
                'tanggal_verif_pemeriksa' => '2014-06-17 18:54:16',
                'kode_analis' => '2535',
                'kode_dokter' => '2539',
                'kode_dokter_verifikator' => '2801'
            ), array(
                'kode_produk' => '01.12.103',
                'nama_komponen' => 'APTT',
                'nilai' => '34.1',
                'satuan' => 'detik',
                'level' => '',
                'nilai_normal' => '',
                'tanggal_verif_analis' => '2014-06-17 18:54:16',
                'tanggal_verif_pemeriksa' => '2014-06-17 18:54:16',
                'kode_analis' => '2535',
                'kode_dokter' => '2539',
                'kode_dokter_verifikator' => '2801'
            )
        );

        echo '<pre>';
        print_r($dataHasil);
        echo '</pre>';
    }

    /*
     * oke
     */

    function native_curl_post() {
        $username = 'admin';
        $password = '1234';

        $url = 'http://arif.simrs.dev/index.php/api/lis/hasil';

        /*
         * data pasien
         */
        $dataPasien = array(
            'no_rm' => '01658344', /* No MR */
            'nama_pasien' => 'Hasan Rahmad', /* Nama Pasien */
            'no_lab' => '201401020164', /* No Lab 201401020164 */
            'tanggal_order' => '19/12/2014 23:58:59', /* Tanggal Order (format: DD/MM/YYYY HH24:MI:SS) */
            'tanggal_kirim_hasil' => '25/12/2014 08:58:59', /* Tanggal pengiriman hasil (format: DD/MM/YYYY HH24:MI:SS) */
            'catatan' => 'catatan hasil' /* Catatan komentar deskripsi */
        );

        /*
         * detail hasil
         */
        $dataHasil = array(
            array(
                'kode_produk' => '01.12.046', /* Kode produk */
                'nama_komponen' => 'komponen1', /* Detail komponen produk */
                'nilai' => '8', /* Nilai hasil */
                'satuan' => 'mil', /* Satuan hasil */
                'level' => 'normal', /* Level hasil (normal / abnormal) */
                'nilai_normal' => '5', /* Nilai Normal */
                'tanggal_verif_analis' => '25/12/2014 08:58:59', /* Tanggal verif analis (format: DD/MM/YYYY HH24:MI:SS) */
                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59', /* Tanggal verif dokter pemeriksa (format: DD/MM/YYYY HH24:MI:SS) */
                'kode_analis' => '2535', /* kode analis (kode pegawai) */
                'kode_dokter' => '2539', /* kode dokter (kode pegawai) */
                'kode_dokter_verifikator' => '2801' /* kode dokter verifikator (kode pegawai) */
            ),
            array(
                'kode_produk' => '01.12.046',
                'nama_komponen' => 'komponen2',
                'nilai' => '7',
                'satuan' => 'mil',
                'level' => 'abnormal',
                'nilai_normal' => '5',
                'tanggal_verif_analis' => '25/12/2014 08:58:59',
                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59',
                'kode_analis' => '2535',
                'kode_dokter' => '2541',
                'kode_dokter_verifikator' => '2546'
            ), array(
                'kode_produk' => '01.12.057',
                'nama_komponen' => 'komponen2',
                'nilai' => '10',
                'satuan' => 'kg',
                'level' => 'normal',
                'nilai_normal' => '6',
                'tanggal_verif_analis' => '25/12/2014 08:58:59',
                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59',
                'kode_analis' => '2808',
                'kode_dokter' => '2539',
                'kode_dokter_verifikator' => '2800'
            )
        );

        $data['pasien'] = $dataPasien;
        $data['hasil'] = $dataHasil;
        /*
         * json post
         */
        $dataJson = json_encode($data);
        echo $dataJson;
        die();
        /*
         * xml post
         * jika xml tanpa string xml version (<?xml version="1.0"?>)
         */
        $noXml = '<?xml version="1.0"?>';
        $stringXml = $this->lis_model->toXml($data);
        $dataXml = str_replace($noXml, '', $stringXml);
        // Set up and execute the curl process
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        /*
         * array
         */
//        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($data));
        /*
         * xml
         */
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $dataXml);
        /*
         * json
         */
//        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $dataJson);
        /*
         * Optional, delete this line if your API is open
         */
//        curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);

        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);

        echo htmlentities($buffer);
        pr($buffer);
    }

    /*
     * oke
     */

    function native_curl() {
        $username = 'admin';
        $password = '1234';

        $url = 'http://arif.simrs.dev/index.php/api/lis/hasil/201401020164';
//        $url = 'http://arif.simrs.dev/index.php/api/lis/hasil?no_lab=201401020164';
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($curl_handle, CURLOPT_GSSAPI_DELEGATION, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
            'no_lab' => '201401020164'
        ));
        // Optional, delete this line if your API is open
        curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);

        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        echo htmlentities($buffer);

//        $result = json_decode($buffer);
//        pr($buffer);
    }

    /*
     * oke
     */

    public function kirim_hasil() {
        $header = array(
            'Accept' => 'application/json'
        );

//        $url = site_url('api/lis/hasil');
        $url = 'http://admin:1234@arif.simrs.dev/index.php/api/lis/hasil';
//        $url = 'http://10.100.254.41/index.php/api/lis/hasil';


        /*
         * data pasien
         */
//        $dataPasien = array(
//            'no_rm' => '01658344', /* No MR */
//            'nama_pasien' => 'Hasan Rahmad', /* Nama Pasien */
//            'no_lab' => '201401020164', /* No Lab 201401020164 */
//            'tanggal_order' => '19/12/2014 23:58:59', /* Tanggal Order (format: DD/MM/YYYY HH24:MI:SS) */
//            'tanggal_kirim_hasil' => '25/12/2014 08:58:59', /* Tanggal pengiriman hasil (format: DD/MM/YYYY HH24:MI:SS) */
//            'catatan' => 'catatan hasil' /* Catatan komentar deskripsi */
//        );

        /*
         * detail hasil
         */
//        $dataHasil = array(
//            array(
//                'kode_produk' => '01.12.046', /* Kode produk */
//                'nama_komponen' => 'komponen1', /* Detail komponen produk */
//                'nilai' => '8', /* Nilai hasil */
//                'satuan' => 'mil', /* Satuan hasil */
//                'level' => 'normal', /* Level hasil (normal / abnormal) */
//                'nilai_normal' => '5', /* Nilai Normal */
//                'tanggal_verif_analis' => '25/12/2014 08:58:59', /* Tanggal verif analis (format: DD/MM/YYYY HH24:MI:SS) */
//                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59', /* Tanggal verif dokter pemeriksa (format: DD/MM/YYYY HH24:MI:SS) */
//                'kode_analis' => '2535', /* kode analis (kode pegawai) */
//                'kode_dokter' => '2539', /* kode dokter (kode pegawai) */
//                'kode_dokter_verifikator' => '2801' /* kode dokter verifikator (kode pegawai) */
//            ),
//            array(
//                'kode_produk' => '01.12.046',
//                'nama_komponen' => 'komponen2',
//                'nilai' => '7',
//                'satuan' => 'mil',
//                'level' => 'abnormal',
//                'nilai_normal' => '5',
//                'tanggal_verif_analis' => '25/12/2014 08:58:59',
//                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59',
//                'kode_analis' => '2535',
//                'kode_dokter' => '2541',
//                'kode_dokter_verifikator' => '2546'
//            ), array(
//                'kode_produk' => '01.12.057',
//                'nama_komponen' => 'komponen2',
//                'nilai' => '10',
//                'satuan' => 'kg',
//                'level' => 'normal',
//                'nilai_normal' => '6',
//                'tanggal_verif_analis' => '25/12/2014 08:58:59',
//                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59',
//                'kode_analis' => '2808',
//                'kode_dokter' => '2539',
//                'kode_dokter_verifikator' => '2800'
//            )
//        );
//        $this->lis_model->sample($array);


        $dataPasien = array(
            'no_rm' => '00358688', /* No MR */
            'nama_pasien' => 'Nama Pasien', /* Nama Pasien */
            'no_lab' => '4061708867', /* No Lab 201401020164 */
            'tanggal_order' => '2014-06-17 18:53:08', /* Tanggal Order (format: YYYY-MM-DD HH24:MI:SS) */
            'tanggal_kirim_hasil' => '2014-06-17 18:53:08', /* Tanggal pengiriman hasil (format: YYYY-MM-DD HH24:MI:SS) */
            'catatan' => 'testing' /* Catatan komentar deskripsi */
        );


        $dataHasil = array(
            array(
                'kode_produk' => '01.12.101', /* Kode produk */
                'nama_komponen' => 'PPT', /* Detail komponen produk */
                'nilai' => '17.9', /* Nilai hasil */
                'satuan' => 'detik', /* Satuan hasil */
                'level' => '', /* Level hasil (normal / abnormal) */
                'nilai_normal' => '', /* Nilai Normal */
                'is_verif_analis' => '1', /* bolean ( 1 0 ) */
                'kode_analis' => '2535', /* kode analis (kode pegawai) */
                'nama_analis' => 'nama analis', /* nama analis (pegawai) */
                'tanggal_verif_analis' => '2013-06-17 18:54:16', /* Tanggal verif analis (format: YYYY-MM-DD HH24:MI:SS) */
                'is_verif_dokter' => '1', /* bolean ( 1 0 ) */
                'kode_dokter' => '2539', /* kode dokter (kode pegawai) */
                'nama_dokter' => 'nama dokter', /* nama dokter (pegawai) */
                'tanggal_verif_pemeriksa' => '2013-06-17 18:54:16', /* Tanggal verif dokter pemeriksa (format: YYYY-MM-DD HH24:MI:SS) */
                'is_verif_verifikator' => '1', /* bolean ( 1 0 ) */
                'kode_dokter_verifikator' => '2801', /* kode dokter verifikator (kode pegawai) */
                'nama_dokter_verifikator' => 'nama verifikator', /* nama dokter (pegawai) */
                'tanggal_verif_verifikator' => '2013-06-17 18:54:16', /* Tanggal verif dokter pemeriksa (format: YYYY-MM-DD HH24:MI:SS) */
                'metode' => 'metode', /* metode */
                'informasi' => 'informasi', /* informasi */
                'catatan' => 'catatan' /* catatan */
            ),
            array(
                'kode_produk' => '01.12.102', /* Kode produk */
                'nama_komponen' => 'PPT', /* Detail komponen produk */
                'nilai' => '17.9', /* Nilai hasil */
                'satuan' => 'detik', /* Satuan hasil */
                'level' => '', /* Level hasil (normal / abnormal) */
                'nilai_normal' => '', /* Nilai Normal */
                'is_verif_analis' => '1', /* bolean ( 1 0 ) */
                'kode_analis' => '2535', /* kode analis (kode pegawai) */
                'nama_analis' => 'nama analis', /* nama analis (pegawai) */
                'tanggal_verif_analis' => '2013-06-17 18:54:16', /* Tanggal verif analis (format: YYYY-MM-DD HH24:MI:SS) */
                'is_verif_dokter' => '1', /* bolean ( 1 0 ) */
                'kode_dokter' => '2539', /* kode dokter (kode pegawai) */
                'nama_dokter' => 'nama dokter', /* nama dokter (pegawai) */
                'tanggal_verif_pemeriksa' => '2013-06-17 18:54:16', /* Tanggal verif dokter pemeriksa (format: YYYY-MM-DD HH24:MI:SS) */
                'is_verif_verifikator' => '1', /* bolean ( 1 0 ) */
                'kode_dokter_verifikator' => '2801', /* kode dokter verifikator (kode pegawai) */
                'nama_dokter_verifikator' => 'nama verifikator', /* nama dokter (pegawai) */
                'tanggal_verif_verifikator' => '2013-06-17 18:54:16', /* Tanggal verif dokter pemeriksa (format: YYYY-MM-DD HH24:MI:SS) */
                'metode' => 'metode', /* metode */
                'informasi' => 'informasi', /* informasi */
                'catatan' => 'catatan' /* catatan */
            )
        );
        $data['pasien'] = $dataPasien;
        $data['hasil'] = $dataHasil;

        $request = Requests::post($url, $header, $data);

        pr($request);
//        echo htmlentities($request->body);
//        $data = json_decode($request->body);
//        echo $data->error[0];
//        pr($request->headers);
//        pr($request->status_code);
//        pr($request->success);
    }

    public function kirim_hasil_json() {
        $header = array(
            'Accept' => 'application/json'
        );

//        $url = site_url('api/lis/hasil');
        $url = 'http://admin:1234@arif.simrs.dev/index.php/api/lis/hasil';
//        $url = 'http://10.100.254.41/index.php/api/lis/hasil';

        /*
         * data pasien
         */
        $dataPasien = array(
            'no_rm' => 'x1000708', /* No MR */
            'nama_pasien' => 'Hasan Rahmad', /* Nama Pasien */
            'no_lab' => '201312310004', /* No Lab 201401020164 */
            'tanggal_order' => '19/12/2014 23:58:59', /* Tanggal Order (format: DD/MM/YYYY HH24:MI:SS) */
            'tanggal_kirim_hasil' => '25/12/2014 08:58:59', /* Tanggal pengiriman hasil (format: DD/MM/YYYY HH24:MI:SS) */
            'catatan' => 'tesing lagi' /* Catatan komentar deskripsi */
        );

        /*
         * detail hasil
         */
        $dataHasil = array(
            array(
                'kode_produk' => '01.13.036', /* Kode produk */
                'nama_produk' => 'nama produk 1', /* Kode produk */
                'nama_komponen' => 'komponen1', /* Detail komponen produk */
                'nilai' => '8', /* Nilai hasil */
                'satuan' => 'mil', /* Satuan hasil */
                'level' => 'normal', /* Level hasil (normal / abnormal) */
                'nilai_normal' => '5', /* Nilai Normal */
                'tanggal_verif_analis' => '25/12/2014 08:58:59', /* Tanggal verif analis (format: DD/MM/YYYY HH24:MI:SS) */
                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59', /* Tanggal verif dokter pemeriksa (format: DD/MM/YYYY HH24:MI:SS) */
                'kode_analis' => '2535', /* kode analis (kode pegawai) */
                'kode_dokter' => '2539', /* kode dokter (kode pegawai) */
                'kode_dokter_verifikator' => '2801' /* kode dokter verifikator (kode pegawai) */
            ),
            array(
                'kode_produk' => '01.13.036',
                'nama_produk' => 'nama produk 1',
                'nama_komponen' => 'komponen2',
                'nilai' => '7',
                'satuan' => 'mil',
                'level' => 'abnormal',
                'nilai_normal' => '5',
                'tanggal_verif_analis' => '25/12/2014 08:58:59',
                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59',
                'kode_analis' => '2535',
                'kode_dokter' => '2541',
                'kode_dokter_verifikator' => '2546'
            ), array(
                'kode_produk' => '01.13.039',
                'nama_produk' => 'nama produk 2',
                'nama_komponen' => 'komponen2',
                'nilai' => '10',
                'satuan' => 'kg',
                'level' => 'normal',
                'nilai_normal' => '6',
                'tanggal_verif_analis' => '25/12/2014 08:58:59',
                'tanggal_verif_pemeriksa' => '25/12/2014 08:58:59',
                'kode_analis' => '2808',
                'kode_dokter' => '2539',
                'kode_dokter_verifikator' => '2800'
            )
        );
        /*
         * array POST
         */
        $data['pasien'] = $dataPasien;
        $data['hasil'] = $dataHasil;
        /*
         * json post
         */
        $dataJson = json_encode($data);
//        echo $dataJson;
//        echo '<br>';
//        echo htmlentities($dataJson);
//        die();
        /*
         * xml post
         * jika xml tanpa string xml version (<?xml version="1.0"?>)
         */
        $noXml = '<?xml version="1.0"?>';
        $stringXml = $this->lis_model->toXml($data);
        $dataXml = str_replace($noXml, '', $stringXml);

        $this->benchmark->mark('code_start');
//        $request = Requests::post($url, $header, $data);
        $this->benchmark->mark('code_end');
        //echo 'waktu array : ' . $this->benchmark->elapsed_time('code_start', 'code_end');
        echo '</br>';
//        pr($request);
        $this->benchmark->mark('code_start2');
        $request = Requests::post($url, $header, $dataJson);
        $this->benchmark->mark('code_end2');
        //echo 'waktu json : ' . $this->benchmark->elapsed_time('code_start2', 'code_end2');
        echo '</br>';
//        pr($request);
//        $this->benchmark->mark('code_start3');
//        $request = Requests::post($url, $header, $dataXml);
//        $this->benchmark->mark('code_end3');
//        echo 'waktu xml : ' . $this->benchmark->elapsed_time('code_start3', 'code_end3');
//        echo '</br>';
//        pr($request);
//        echo htmlentities($request);
//        die();
//        echo htmlentities($request->body);
        $response = json_decode($request->body);
        pr($request);
//        pr($request->status_code);
//        pr($request->success);
    }

    /*
     * oke
     */

    public function get_hasil() {
        $header = array(
            'Accept' => 'application/json',
            'http_user' => 'admin',
            'http_pass' => '1234',
            'http_auth' => 'basic',
            'X-Authorization' => 'admin:1234'
        );

        /*
         * $url = 'http://arif.simrs.dev/index.php/api/lis/hasil?no_lab=201401020164';
         */
        $url = 'http://admin:1234@arif.simrs.dev/index.php/api/lis/hasil/201401020164';
        $request = Requests::get($url, $header);
        pr($request);
    }

    /*
     * http://10.100.254.21:8080/HasilRESTful/webresources/entities.vsimetrishasil
     * This XML file does not appear to have any style information associated with it. The document tree is shown below.
      <vSimetrisHasils>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T12:52:16+07:00</analysezeit> keluar hasil
      <analyt>Natrium</analyt> nama komponene
      <analytnr>2240</analytnr> kode komponen internal cobas
      <graph>___(_*_)___</graph> tengah : normal,  level
      <graph>_*_(___)___</graph> tengah : rendah,
      <graph>___(___)_*_</graph> tengah : normal,
      <hostanalytnr>01.12.057</hostanalytnr> kode komponen uti
      <id>1</id> id conter cobas
      <kontrmoddate>2014-02-02T12:52:30+07:00</kontrmoddate> tgl hasil
      <kontruid>IKA</kontruid> nama analis
      <medvalStatus>0000000000000001</medvalStatus>  status medis abaikan
      <nolab>2020310078</nolab>
      <onormal>145</onormal> nilai normal yg lain
      <orderstatus>0</orderstatus>
      <patid>01670463</patid> no rm
      <prozstat>3</prozstat>
      <refbereich>136 - 145</refbereich> nilai normal
      <resultatn>139</resultatn> hasil (nilai)
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:49:39+07:00</tglorder> tgl order
      <unit>mmol/L</unit> satuan
      <unormal>136</unormal> hiraukan
      </vSimetrisHasil>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T12:52:19+07:00</analysezeit>
      <analyt>Kalium</analyt>
      <analytnr>2245</analytnr>
      <graph>_*_(___)___</graph>
      <hostanalytnr>01.12.052</hostanalytnr>
      <id>2</id>
      <indikator>L</indikator>
      <kontrmoddate>2014-02-02T12:52:31+07:00</kontrmoddate>
      <kontruid>IKA</kontruid>
      <medvalStatus>0000000000000001</medvalStatus>
      <nolab>2020310078</nolab>
      <onormal>5.1</onormal>
      <orderstatus>0</orderstatus>
      <patid>01670463</patid>
      <prozstat>3</prozstat>
      <refbereich>3.5 - 5.1</refbereich>
      <resultatn>3.2</resultatn>
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:49:39+07:00</tglorder>
      <unit>mmol/L</unit>
      <unormal>3.5</unormal>
      </vSimetrisHasil>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T12:52:23+07:00</analysezeit>
      <analyt>Klorida</analyt>
      <analytnr>2250</analytnr>
      <graph>___(_*_)___</graph>
      <hostanalytnr>01.12.416</hostanalytnr>
      <id>3</id>
      <kontrmoddate>2014-02-02T12:52:31+07:00</kontrmoddate>
      <kontruid>IKA</kontruid>
      <medvalStatus>0000000000000001</medvalStatus>
      <nolab>2020310078</nolab>
      <onormal>107</onormal>
      <orderstatus>0</orderstatus>
      <patid>01670463</patid>
      <prozstat>3</prozstat>
      <refbereich>98 - 107</refbereich>
      <resultatn>104</resultatn>
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:49:39+07:00</tglorder>
      <unit>mmol/L</unit>
      <unormal>98</unormal>
      </vSimetrisHasil>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T12:43:52+07:00</analysezeit>
      <analyt>Bilirubin Total</analyt>
      <analytnr>2005</analytnr>
      <graph>___(___)_*_</graph>
      <hostanalytnr>01.12.047</hostanalytnr>
      <id>4</id>
      <indikator>H</indikator>
      <kontrmoddate>2014-02-02T12:52:31+07:00</kontrmoddate>
      <kontruid>IKA</kontruid>
      <medvalStatus>0000000000000001</medvalStatus>
      <nolab>2020310078</nolab>
      <orderstatus>0</orderstatus>
      <patid>01670463</patid>
      <prozstat>3</prozstat>
      <refbereich><= 1.2</refbereich>
      <resultatn>11.79</resultatn>
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:49:39+07:00</tglorder>
      <unit>mg/dL</unit>
      </vSimetrisHasil>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T12:43:52+07:00</analysezeit>
      <analyt>Bilirubin direct</analyt>
      <analytnr>2015</analytnr>
      <graph>___(___)_*_</graph>
      <hostanalytnr>01.12.048</hostanalytnr>
      <id>5</id>
      <indikator>H</indikator>
      <kontrmoddate>2014-02-02T12:52:31+07:00</kontrmoddate>
      <kontruid>IKA</kontruid>
      <medvalStatus>0000000000000001</medvalStatus>
      <nolab>2020310078</nolab>
      <onormal>0.2</onormal>
      <orderstatus>0</orderstatus>
      <patid>01670463</patid>
      <prozstat>3</prozstat>
      <refbereich>0.0 - 0.2</refbereich>
      <resultatn>10.64</resultatn>
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:49:39+07:00</tglorder>
      <unit>mg/dL</unit>
      <unormal>0</unormal>
      </vSimetrisHasil>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T12:43:58+07:00</analysezeit>
      <analyt>Albumin</analyt>
      <analytnr>2035</analytnr>
      <graph>_*_(___)___</graph>
      <hostanalytnr>01.12.045</hostanalytnr>
      <id>6</id>
      <indikator>L</indikator>
      <kontrmoddate>2014-02-02T12:52:49+07:00</kontrmoddate>
      <kontruid>IKA</kontruid>
      <medvalStatus>0000000000000001</medvalStatus>
      <nolab>2020310081</nolab>
      <onormal>4.94</onormal>
      <orderstatus>0</orderstatus>
      <patid>01669144</patid>
      <prozstat>3</prozstat>
      <refbereich>3.97 - 4.94</refbereich>
      <resultatn>2.57</resultatn>
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:53:21+07:00</tglorder>
      <unit>g/dL</unit>
      <unormal>3.97</unormal>
      </vSimetrisHasil>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T13:20:22+07:00</analysezeit>
      <analyt>Natrium</analyt>
      <analytnr>2240</analytnr>
      <graph>_*_(___)___</graph>
      <hostanalytnr>01.12.057</hostanalytnr>
      <id>7</id>
      <indikator>L</indikator>
      <kontrmoddate>2014-02-02T13:22:19+07:00</kontrmoddate>
      <kontruid>IKA</kontruid>
      <medvalStatus>0000000000000001</medvalStatus>
      <nolab>2020310080</nolab>
      <onormal>145</onormal>
      <orderstatus>0</orderstatus>
      <patid>01671018</patid>
      <prozstat>3</prozstat>
      <refbereich>136 - 145</refbereich>
      <resultatn>117</resultatn>
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:51:58+07:00</tglorder>
      <unit>mmol/L</unit>
      <unormal>136</unormal>
      </vSimetrisHasil>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T13:20:26+07:00</analysezeit>
      <analyt>Kalium</analyt>
      <analytnr>2245</analytnr>
      <graph>_*_(___)___</graph>
      <hostanalytnr>01.12.052</hostanalytnr>
      <id>8</id>
      <indikator>L</indikator>
      <kontrmoddate>2014-02-02T13:22:19+07:00</kontrmoddate>
      <kontruid>IKA</kontruid>
      <medvalStatus>0000000000000001</medvalStatus>
      <nolab>2020310080</nolab>
      <onormal>5.1</onormal>
      <orderstatus>0</orderstatus>
      <patid>01671018</patid>
      <prozstat>3</prozstat>
      <refbereich>3.5 - 5.1</refbereich>
      <resultatn>2.9</resultatn>
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:51:58+07:00</tglorder>
      <unit>mmol/L</unit>
      <unormal>3.5</unormal>
      </vSimetrisHasil>
      <vSimetrisHasil>
      <analysezeit>2014-02-02T13:20:29+07:00</analysezeit>
      <analyt>Klorida</analyt>
      <analytnr>2250</analytnr>
      <graph>_*_(___)___</graph>
      <hostanalytnr>01.12.416</hostanalytnr>
      <id>9</id>
      <indikator>L</indikator>
      <kontrmoddate>2014-02-02T13:22:19+07:00</kontrmoddate>
      <kontruid>IKA</kontruid>
      <medvalStatus>0000000000000001</medvalStatus>
      <nolab>2020310080</nolab>
      <onormal>107</onormal>
      <orderstatus>0</orderstatus>
      <patid>01671018</patid>
      <prozstat>3</prozstat>
      <refbereich>98 - 107</refbereich>
      <resultatn>88</resultatn>
      <resultstatus>0000000010</resultstatus>
      <tglorder>2014-02-02T11:51:58+07:00</tglorder>
      <unit>mmol/L</unit>
      <unormal>98</unormal>
      </vSimetrisHasil>
      </vSimetrisHasils>
     */
}
