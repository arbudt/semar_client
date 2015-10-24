<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Input_diagnosa_jmn extends MY_Controller {

    private $_custId = '7189'; //id api
    private $_custKey = 'rs1s2y3'; //key api
    private $tingkatKelas1 = 4; //tingkat kelas I
    private $modulId = 1411; //,odul id 

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('application_helper', 'all_registrasi_helper'));
        $this->load->helper('pelayanan_irj_helper', 'menu_helper');
        $this->load->library('form_validation');
        $model = array(
            'menu_model',
            'emr/input_diagnosa_jmn_model',
            'emr/emr_model',
            'pelayanan/pelayanan_irna_model',
            'pelayanan/ambulan_model',
            'kasir/kasir_model',
            'kasir/simulasi_tagihan_model'
        );
        $this->load->model($model);
        $this->menu['top_menu'] = TRUE;
        $this->load->library('rest');
        Requests::register_autoloader();
    }

    public function index() {
        $this->menu['active'] = 3;
        $data = array();
        $data['pencarian']['data'] = NULL;
        $data['pencarian']['message'] = NULL;
        //data poliklinik
        $dataPelayanan = $this->input_diagnosa_jmn_model->getJenisPelayanaRekamMedis();
        $data['optionsPelayanan'][''] = 'Semua';
        if ($dataPelayanan) {
            foreach ($dataPelayanan as $row) {
                $data['optionsPelayanan'][$row->MINS_KODE] = $row->MINS_NAMA;
            }
        }
        $data['pencarian']['isCari'] = 0; //status pencarian dari view
        $data['optionsPoliklinik'][''] = 'Semua';
        $data['optionsDetailPoliklinik'][''] = 'Semua';
        $data['pencarian']['defaultCekTgl'] = TRUE;
        $data['pencarian']['defaultCekLunas'] = TRUE;
        $data['pencarian']['defaultTgl'] = tglsekarang();
        $data['pencarian']['defaultTglKeluar'] = tglsekarang();
        $data['pencarian']['defaultPelayanan'] = '';
        $data['pencarian']['defaultPoliklinik'] = '';
        $data['pencarian']['defaultSubPoliklinik'] = '';

        $this->render('emr/view_input_icd_jmn', $data, $this->menu, FALSE);
    }

    /*
     * proses simpan input diagnosa
     */

    public function prosesSimpanDiagnosa() {
        $data = array(
            'status' => FALSE,
            'dataDiagnosa' => NULL,
            'message' => NULL,
            'report' => ''
        );
        $this->form_validation->set_rules('noRegDiagnosa', 'No Registrasi', 'required');
        $this->form_validation->set_rules('noRmDiagnosa', 'No RM', 'required');
        $this->form_validation->set_rules('idKunjDiagnosa', 'Indentitas Kunjungan', 'required');
        if ($this->form_validation->run() == TRUE) {
            $noRm = '';
            if (!empty($_POST['noRmDiagnosa'])) {
                $noRm = $_POST['noRmDiagnosa'];
            }
            $idKunj = '';
            if (!empty($_POST['idKunjDiagnosa'])) {
                $idKunj = $_POST['idKunjDiagnosa'];
            }
            $noReg = '';
            if (!empty($_POST['noRegDiagnosa'])) {
                $noReg = $_POST['noRegDiagnosa'];
            }
            $userId = $this->session->userdata('userid');
            $arrIndux = array(
                'noRm' => $noRm,
                'noReg' => $noReg,
                'idKunj' => $idKunj,
                'userId' => $userId
            );
            $arrDetail = array();
            if (!empty($_POST['idRowForm'])) {
                $i = 0;
                while ($i < count($_POST['idRowForm'])) {
                    $indexRow = $_POST['idRowForm'][$i];
                    $idSimpan = NULL;
                    if (!empty($_POST['idSimpanDiagnosa'][$indexRow])) {
                        $idSimpan = $_POST['idSimpanDiagnosa'][$indexRow];
                    }
                    $isKlaim = '0';
                    if (!empty($_POST['isKlaimDiagnosa'][$indexRow])) {
                        $isKlaim = $_POST['isKlaimDiagnosa'][$indexRow];
                    }
                    $isSudahBatal = 0;
                    if (!empty($_POST['isBatal'][$indexRow])) {
                        $isSudahBatal = intval($_POST['isBatal'][$indexRow]);
                    }
                    $jenisDiagnosa = NULL;
                    if (!empty($_POST['jenisDiagnosa'][$indexRow])) {
                        $jenisDiagnosa = $_POST['jenisDiagnosa'][$indexRow];
                    }
                    $jenisKasus = '0';
                    if (!empty($_POST['jenisKasusDiagnosa'][$indexRow])) {
                        $jenisKasus = $_POST['jenisKasusDiagnosa'][$indexRow];
                    }
                    $icdDiagnosa = NULL;
                    if (!empty($_POST['icdDiagnosa'][$indexRow])) {
                        if ($_POST['icdDiagnosa'][$indexRow] != 'null') {
                            $icdDiagnosa = $_POST['icdDiagnosa'][$indexRow];
                        }
                    }
                    $ketDiagnosa = NULL;
                    if (!empty($_POST['ketDiganosa'][$indexRow])) {
                        $ketDiagnosa = $_POST['ketDiganosa'][$indexRow];
                    }
                    $ketUbah = NULL;
                    if (!empty($_POST['ketUbahDiganosa'][$indexRow])) {
                        $ketUbah = $_POST['ketUbahDiganosa'][$indexRow];
                    }
                    $isBatal = '0';
                    if (!empty($_POST['isBatalDiagnosa'][$indexRow])) {
                        $isBatal = $_POST['isBatalDiagnosa'][$indexRow];
                    }
                    $alasanBatal = NULL;
                    if (!empty($_POST['alasanBatalDiagnosa'][$indexRow])) {
                        $alasanBatal = $_POST['alasanBatalDiagnosa'][$indexRow];
                    }
                    $ketBatal = NULL;
                    if (!empty($_POST['ketBatalDiagnosa'][$indexRow])) {
                        $ketBatal = $_POST['ketBatalDiagnosa'][$indexRow];
                    }
                    /*
                     * perbedaan $isSudahBatal vs $isBatal
                     * $isBatal = kondisi pembatalan saat ini dari form
                     * $isSudahBatal = diagnosa sudah dibatalkan dari sebelumya (tidak akan diproses dalam simpan db)
                     */
                    if ($isSudahBatal == 0) {
                        $arrDetail[] = array(
                            'idSimpan' => $idSimpan,
                            'isKlaim' => $isKlaim,
                            'jenisDiagnosa' => $jenisDiagnosa,
                            'jenisKasus' => $jenisKasus,
                            'icdDiagnosa' => $icdDiagnosa,
                            'ketDiagnosa' => $ketDiagnosa,
                            'ketUbah' => $ketUbah,
                            'isBatal' => $isBatal,
                            'alasanBatal' => $alasanBatal,
                            'ketBatal' => $ketBatal
                        );
                    }
                    $i++;
                }
            }
            if ($this->input_diagnosa_jmn_model->simpanDiagnosa($arrIndux, $arrDetail) == TRUE) {
                $data['status'] = TRUE;
                $data['dataDiagnosa'] = $this->input_diagnosa_jmn_model->dataInputDiagnosaByIdKunj($idKunj);
                $data['message'] = 'Proses simpan berhasil';
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Proses gagal';
            }
        } else {
            $data['message'] = 'Data belum lengkap, mohon lengkapi terlebih dahulu';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data diagnosa by id kunjungan
     */

    public function getDataDiagnosaByIdKunj() {
        $data = array(
            'dataDiagnosa' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            $idKunj = $_POST['idKunj'];
            $data['dataDiagnosa'] = $this->input_diagnosa_jmn_model->dataInputDiagnosaByIdKunj($idKunj);
        } else {
            $data['message'] = 'Identitas kunjungan kosong, Hubungi Administrator';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data all modul diagnosa berdasarkan tkpasId
     */

    public function getAllDataInputDiagnosa() {
        $data = array(
            'dataDiagnosa' => NULL,
            'dataTindakan' => NULL,
            'listTindakan' => NULL,
            'dataVerifikasi' => NULL,
            'statusVerif' => FALSE,
            'dataPerkiraanInacbg' => NULL,
            'statusInputCMG' => FALSE,
            'statusFinalInacbg' => FALSE,
            'dataDokter' => NULL,
            'dataHistory' => NULL,
            'dataKunjungan' => NULL,
            'infoTarifFinal' => NULL,
            'dataInfoKelas' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            $idKunj = $_POST['idKunj'];
            //data diagnosa
            $data['dataDiagnosa'] = $this->input_diagnosa_jmn_model->dataInputDiagnosaByIdKunj($idKunj);
            //data tindakan
            $data['dataTindakan'] = $this->input_diagnosa_jmn_model->dataInputTindakanByIdKunj($idKunj);
            //data list tindakan yang pernah diinputkan
            $dataListTindakan = $this->input_diagnosa_jmn_model->getListTindakan($idKunj);
            if ($dataListTindakan->num_rows() > 0) {
                $data['listTindakan'] = $dataListTindakan->result();
            }
            //data verifikasi
            $dataVerifikasi = $this->input_diagnosa_jmn_model->dataVerifikasiByTkpasId($idKunj);
            if ($dataVerifikasi != NULL) {
                $data['dataVerifikasi'] = $dataVerifikasi;
                $dataVerifikasi->TARIF_RS_KLAIM = number_format($dataVerifikasi->TARIF_RS_KLAIM);
                $data['statusVerif'] = TRUE;
                $noReg = $dataVerifikasi->NOREG;
                if ($dataVerifikasi->IS_BOLEH_KIRIM_ULANG == 1) {
                    $data['statusFinalInacbg'] = FALSE;
                } else {
                    $setGeneral = $this->input_diagnosa_jmn_model->getSettingGeneralByName('status_final_kirim_inacbg');
                    if ($setGeneral == '1') {
                        $isBolehKirimUlangSesuaiHak = $this->input_diagnosa_jmn_model->getSettingGeneralByName('status_boleh_kirim_ulang_sesuai_hak'); //setting jika boleh krirm ulang jika sesuai hak
                        if ($isBolehKirimUlangSesuaiHak == '1') {
                            $dataKelasJaminan = $this->input_diagnosa_jmn_model->kelasJaminanNaikTurunKelasKirimInacbg($noReg);
                            $tingkatKelasJaminan = $dataKelasJaminan['tingkatKelasJaminan'];
                            $tingkatKelasTagihan = NULL;
                            $dataKelasTagihan = $this->input_diagnosa_jmn_model->hitungKelasTagihanInacbg($noReg);
                            if ($dataKelasTagihan['status'] == TRUE) {
                                $tingkatKelasTagihan = $dataKelasTagihan['tingkatKelasTagihan'];
                            }
                            if ($tingkatKelasJaminan == $tingkatKelasTagihan) {
                                $data['statusFinalInacbg'] = FALSE;
                            } else {
                                $data['statusFinalInacbg'] = TRUE;
                            }
                        } else {
                            $data['statusFinalInacbg'] = TRUE;
                        }
                    }
                }
                //data kunjungan pasien
                $data['dataKunjungan']['ID_KUNJ'] = $dataVerifikasi->ID_KUNJ;
                $data['dataKunjungan']['NOREG'] = $dataVerifikasi->NOREG;
                $data['dataKunjungan']['NORM'] = $dataVerifikasi->NORM;
                $data['dataKunjungan']['NAMA_PASIEN'] = $dataVerifikasi->NAMA_PASIEN;
            } else {
                $dataDefault = $this->input_diagnosa_jmn_model->dataDefaultVerifikasiByTkpasId($idKunj);
                //default data verifikasi jika belum ada data verifikasi sebelumnya
                $dataDefault->HOT = $this->input_diagnosa_jmn_model->getTarifHotByIdKunj($idKunj); //default Tarif HOT
                $dataDefault->ALKES = $this->input_diagnosa_jmn_model->getTarifAlkesByIdKunj($idKunj); //default Tarif ALKES;
                $dataDefault->IS_BOLEH_KIRIM_ULANG = 1;
                $dataDefault->TARIF_RS_KLAIM = number_format($this->tarifTagihanRs($idKunj, $dataDefault->NOREG, $dataDefault->NO_JAMINAN));
                $data['dataVerifikasi'] = $dataDefault;
                $data['statusFinalInacbg'] = FALSE;
                //data kunjungan pasien
                $data['dataKunjungan']['ID_KUNJ'] = $dataDefault->ID_KUNJ;
                $data['dataKunjungan']['NOREG'] = $dataDefault->NOREG;
                $data['dataKunjungan']['NORM'] = $dataDefault->NORM;
                $data['dataKunjungan']['NAMA_PASIEN'] = $dataDefault->NAMA_PASIEN;
            }

            $data['dataInfoKelas'] = $this->input_diagnosa_jmn_model->getInfoKelasByIdKunj($idKunj);

            //data perkiraan grouper inacbg
            $dataPerkiraan = $this->input_diagnosa_jmn_model->dataPerkiraanInacbg($idKunj);
            if ($dataPerkiraan != NULL) {
                $data['dataPerkiraanInacbg']['NO_PENJAMINAN'] = $dataPerkiraan->NO_PENJAMINAN;
                $data['dataPerkiraanInacbg']['KODE_GROUPER'] = $dataPerkiraan->KODE_GROUPER;
                $data['dataPerkiraanInacbg']['TARIF'] = number_format($dataPerkiraan->TARIF);
                $data['dataPerkiraanInacbg']['DESC_GROUPER'] = $dataPerkiraan->DESC_GROUPER;
            }
            //status input cmg (ya / tidak)
            $data['statusInputCMG'] = $this->input_diagnosa_jmn_model->cekInputCMGByIdKunj($idKunj);
            //data dokter penanggnung jawab
            $dataDokterPJ = array();
            $dataDokter = $this->pelayanan_irna_model->loadDokterPJ($idKunj);
            if ($dataDokter != FALSE) {
                $dataDokterPJ = array(
                    'idDokterPJ' => !empty($dataDokter->TMRPJPLY_ID) ? ($dataDokter->TMRPJPLY_ID) : '',
                    'kodeDokter' => !empty($dataDokter->MST_PEG_MPG_KODE) ? ($dataDokter->MST_PEG_MPG_KODE) : '',
                    'namaDokter' => !empty($dataDokter->NAMA_DOKTER) ? ($dataDokter->NAMA_DOKTER) : '',
                    'namaDokterResident' => !empty($dataDokter->TMRPJPLY_NAMA) ? ($dataDokter->TMRPJPLY_NAMA) : '',
                    'idKunjungan' => !empty($dataDokter->TRANS_KUNJ_TKPAS_ID) ? ($dataDokter->TRANS_KUNJ_TKPAS_ID) : '',
                    'noreg' => !empty($dataDokter->TMRPJPLY_NOREG) ? ($dataDokter->TMRPJPLY_NOREG) : '',
                    'norm' => !empty($dataDokter->TMRPJPLY_NOMR) ? ($dataDokter->TMRPJPLY_NOMR) : ''
                );
            }
            $data['dataDokter'] = $dataDokterPJ;
            //ambil history perubahan dokter
            $dataHistoryPJ = array();
            $dataHistory = $this->pelayanan_irna_model->loadHistoryDokterPJ($idKunj);
            if ($dataHistory != FALSE) {
                foreach ($dataHistory->result() as $row) {
                    $dataHistoryPJ[] = array(
                        'idUbahDokterPJ' => !empty($row->TUPJPLY_ID) ? ($row->TUPJPLY_ID) : '',
                        'tanggalUbah' => !empty($row->TUPJPLY_TANGGAL) ? ($row->TUPJPLY_TANGGAL) : '',
                        'idDokterPJ' => !empty($row->TR_MR_PJ_TMRPJPLY_ID_AWAL) ? ($row->TR_MR_PJ_TMRPJPLY_ID_AWAL) : '',
                        'kodeDokter' => !empty($row->MST_PEGAWAI_MPG_KODE_AWAL) ? ($row->MST_PEGAWAI_MPG_KODE_AWAL) : '',
                        'namaDokter' => $row->MPG_GELAR_DEPAN . ' ' . $row->NAMA_DOKTER . ' ' . $row->MPG_GELAR_BELAKANG,
                        'alasanUbah' => !empty($row->RALS_NAMA) ? ($row->RALS_NAMA) : '',
                        'keteranganUbah' => !empty($row->TUPJPLY_KET_UBAH) ? ($row->TUPJPLY_KET_UBAH) : '',
                    );
                }
            }
            $data['dataHistory'] = $dataHistoryPJ;
            $data['infoTarifFinal'] = $this->dataTarifAkhirInacbg($idKunj);
        } else {
            $data['message'] = 'Identitas kunjungan kosong, Hubungi Administrator';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data history perubahan diagnosa
     */

    public function getDataHistoryPerubahanDiagnosa() {
        $data = array(
            'dataHistory' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idSimpan'])) {
            $idSimpan = $_POST['idSimpan'];
            $data['dataHistory'] = $this->input_diagnosa_jmn_model->dataHistoryPerubahanDiagnosaByIdTrans($idSimpan);
        } else {
            $data['message'] = 'Identitas kosong, Hubungi Administrator';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data icd 10 berdasarkan jenis diagnosa
     * max ditampilkan 100 diagnosa
     */

    public function getIcd10ByJenisDiagnosa() {
        $data = array();
        if (!empty($_GET['q']) && $_GET['jenisDiagnosa']) {
            $key = $_GET['q'];
            $jenisDiagnosa = $_GET['jenisDiagnosa'];
            $resultIcd = $this->input_diagnosa_jmn_model->dataIcd10ByJenisDiagnosa($key, $jenisDiagnosa);
            if ($resultIcd != NULL) {
                foreach ($resultIcd as $row) {
                    $data[] = array(
                        "id" => $row->MICD10_KODE,
                        "namaDiagnosa" => $row->MICD10_PENYAKIT,
                        "text" => $row->MICD10_KODE . ' - ' . $row->MICD10_PENYAKIT);
                }
            } else {
                $data[] = array("id" => '', "text" => 'tidak ada data yang cocok');
            }
        } else {
            $data[] = array("id" => '', "text" => 'harus memilih jenis diagnosa dulu');
        }
        echo json_encode($data);
    }

    /*
     * mengambil data tindakan berasarkan kata kunci
     * max ditampilkan 100 baris tindakan
     */

    public function getIcd9ByKey() {
        if (!empty($_GET['q'])) {
            $key = $_GET['q'];

            $query = $this->input_diagnosa_jmn_model->getdataIcd9($key);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = array(
                        "id" => $row->ICD9CM_KODE,
                        "namaDiagnosa" => $row->ICD9CM_KETERANGAN,
                        "text" => $row->ICD9CM_KODE . ' - ' . $row->ICD9CM_KETERANGAN);
                }
            } else {
                $data[] = array("id" => '', "text" => 'tidak ada data yang cocok');
            }
            echo json_encode($data);
        }
    }

    /*
     * mengambil data diagnosa by id kunjungan
     */

    public function getDataTindakanByIdKunj() {
        $data = array(
            'dataTindakan' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            $idKunj = $_POST['idKunj'];
            $data['dataTindakan'] = $this->input_diagnosa_jmn_model->dataInputTindakanByIdKunj($idKunj);
        } else {
            $data['message'] = 'Identitas kunjungan kosong, Hubungi Administrator';
        }
        echo json_encode($data);
    }

    /*
     * proses simpan input diagnosa
     */

    public function prosesSimpanTindakan() {
        $data = array(
            'status' => FALSE,
            'dataTindakan' => NULL,
            'message' => NULL,
            'report' => ''
        );
        $this->form_validation->set_rules('noRegTindakan', 'No Registrasi', 'required');
        $this->form_validation->set_rules('noRmTindakan', 'No RM', 'required');
        $this->form_validation->set_rules('idKunjTindakan', 'Indentitas Kunjungan', 'required');
        if ($this->form_validation->run() == TRUE) {
            $noRm = '';
            if (!empty($_POST['noRmTindakan'])) {
                $noRm = $_POST['noRmTindakan'];
            }
            $idKunj = '';
            if (!empty($_POST['idKunjTindakan'])) {
                $idKunj = $_POST['idKunjTindakan'];
            }
            $noReg = '';
            if (!empty($_POST['noRegTindakan'])) {
                $noReg = $_POST['noRegTindakan'];
            }
            $userId = $this->session->userdata('userid');
            $arrIndux = array(
                'noRm' => $noRm,
                'noReg' => $noReg,
                'idKunj' => $idKunj,
                'userId' => $userId
            );
            $arrDetail = array();
            if (!empty($_POST['idRowForm'])) {
                $i = 0;
                while ($i < count($_POST['idRowForm'])) {
                    $indexRow = $_POST['idRowForm'][$i];
                    $idSimpan = NULL;
                    if (!empty($_POST['idSimpanTindakan'][$indexRow])) {
                        $idSimpan = $_POST['idSimpanTindakan'][$indexRow];
                    }
                    $isKlaim = '0';
                    if (!empty($_POST['isKlaimTindakan'][$indexRow])) {
                        $isKlaim = $_POST['isKlaimTindakan'][$indexRow];
                    }
                    $isSudahBatal = 0;
                    if (!empty($_POST['isSudahBatalTindakan'][$indexRow])) {
                        $isSudahBatal = intval($_POST['isSudahBatalTindakan'][$indexRow]);
                    }
                    $kodeProduk = NULL;
                    if (!empty($_POST['kodeProduk'][$indexRow])) {
                        $kodeProduk = $_POST['kodeProduk'][$indexRow];
                    }
                    $idPelayanan = NULL;
                    if (!empty($_POST['idPelayananPasien'][$indexRow])) {
                        $idPelayanan = $_POST['idPelayananPasien'][$indexRow];
                    }
                    $tanggal = tglsekarang();
                    if (!empty($_POST['tglTindakan'][$indexRow])) {
                        $tanggal = $_POST['tglTindakan'][$indexRow];
                    }
                    $jam = jamsekarang();
                    if (!empty($_POST['jamTindakan'][$indexRow])) {
                        $jam = $_POST['jamTindakan'][$indexRow];
                    }
                    $jenisTindakan = NULL;
                    if (!empty($_POST['jenisTindakan'][$indexRow])) {
                        $jenisTindakan = $_POST['jenisTindakan'][$indexRow];
                    }
                    $namaTindakan = NULL;
                    if (!empty($_POST['namaTindakan'][$indexRow])) {
                        $namaTindakan = $_POST['namaTindakan'][$indexRow];
                    }
                    $icdDiagnosa = NULL;
                    if (!empty($_POST['icd9Tindakan'][$indexRow])) {
                        $icdDiagnosa = $_POST['icd9Tindakan'][$indexRow];
                    }
                    $ketUbah = NULL;
                    if (!empty($_POST['ketUbahTindakan'][$indexRow])) {
                        $ketUbah = $_POST['ketUbahTindakan'][$indexRow];
                    }
                    $isBatal = '0';
                    if (!empty($_POST['isBatalTindakan'][$indexRow])) {
                        $isBatal = $_POST['isBatalTindakan'][$indexRow];
                    }
                    $alasanBatal = NULL;
                    if (!empty($_POST['alasanBatalTindakan'][$indexRow])) {
                        $alasanBatal = $_POST['alasanBatalTindakan'][$indexRow];
                    }
                    $ketBatal = NULL;
                    if (!empty($_POST['ketBatalTindakan'][$indexRow])) {
                        $ketBatal = $_POST['ketBatalTindakan'][$indexRow];
                    }
                    /*
                     * perbedaan $isSudahBatal vs $isBatal
                     * $isBatal = kondisi pembatalan saat ini dari form
                     * $isSudahBatal = diagnosa sudah dibatalkan dari sebelumya (tidak akan diproses dalam simpan db)
                     */
                    if ($isSudahBatal == 0) {
                        $arrDetail[] = array(
                            'idSimpan' => $idSimpan,
                            'isKlaim' => $isKlaim,
                            'tgl' => $tanggal,
                            'jam' => $jam,
                            'jenisTindakan' => $jenisTindakan,
                            'idPelayanan' => $idPelayanan,
                            'kodeProduk' => $kodeProduk,
                            'namaTindakan' => $namaTindakan,
                            'icdDiagnosa' => $icdDiagnosa,
                            'ketUbah' => $ketUbah,
                            'isBatal' => $isBatal,
                            'alasanBatal' => $alasanBatal,
                            'ketBatal' => $ketBatal
                        );
                    }
                    $i++;
                }
            }
            if ($this->input_diagnosa_jmn_model->simpanTindakan($arrIndux, $arrDetail) == TRUE) {
                $data['status'] = TRUE;
                $data['dataTindakan'] = $this->input_diagnosa_jmn_model->dataInputTindakanByIdKunj($idKunj);
                $data['message'] = 'Proses simpan berhasil';
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Proses gagal';
            }
        } else {
            $data['message'] = 'Data belum lengkap, mohon lengkapi terlebih dahulu';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data history perubahan tindakan
     */

    public function getDataHistoryPerubahanTindakan() {
        $data = array(
            'dataHistory' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idSimpan'])) {
            $idSimpan = $_POST['idSimpan'];
            $data['dataHistory'] = $this->input_diagnosa_jmn_model->getDataHistoryPerubahanTindakanByIdTrans($idSimpan);
        } else {
            $data['message'] = 'Identitas kosong, Hubungi Administrator';
        }
        echo json_encode($data);
    }

    /*
     * proses verifikasi data
     */

    public function prosesSimpanVerifikasi() {
        $result = array(
            'status' => FALSE,
            'message' => NULL,
            'dataVerifikasi' => NULL
        );
        if (!empty($_POST['hiddenKunjId'])) {
            $tkpasId = $_POST['hiddenKunjId'];
            $noReg = $_POST['noReg'];
            $noPeserta = $_POST['noPeserta'];
            $noRm = $_POST['noRm'];
            $noJaminan = $_POST['noJaminan'];
            $namaSep = !empty($_POST['namaSepVerif']) ? str_replace("'", "''", $_POST['namaSepVerif']) : '';
            $tglLahirSep = !empty($_POST['inputTglLahirSepVerif']) ? $_POST['inputTglLahirSepVerif'] : NULL;
            $strJenisKelaminSep = !empty($_POST['inputJenisKelaminSepVerif']) ? $_POST['inputJenisKelaminSepVerif'] : NULL;
            $jenisKelaminSep = '';
            if (!empty($strJenisKelaminSep)) {
                if ($strJenisKelaminSep == "Laki-laki") {
                    $jenisKelaminSep = 'L';
                } else {
                    $jenisKelaminSep = 'P';
                }
            }
            $tglSep = NULL;
            if (!empty($_POST['tglSep'])) {
                $tglSep = $_POST['tglSep'];
            }
            $tglMasuk = $_POST['tglMasuk'];
            $jamMasuk = '00:00:00';
            if (!empty($_POST['jamMasuk'])) {
                $jamMasuk = $_POST['jamMasuk'];
            }
            $waktuMasuk = $tglMasuk . ' ' . $jamMasuk;
            $tglKeluar = $_POST['tglKeluar'];
            $jamKeluar = '00:00:00';
            if (!empty($_POST['jamKeluar'])) {
                $jamKeluar = $_POST['jamKeluar'];
            }
            $waktuKeluar = $tglKeluar . ' ' . $jamKeluar;
            $los = $_POST['los'];
            $hot = '0';
            if (!empty($_POST['hotVerif'])) {
                $hot = $_POST['hotVerif'];
            }
            $alkes = '0';
            if (!empty($_POST['alkesVerif'])) {
                $alkes = $_POST['alkesVerif'];
            }
            $tarifRsKlaim = 0;
            if (!empty($_POST['inputTarifRsVerif'])) {
                $tarifRsKlaim = preg_replace("/[^0-9]+/", "", $_POST['inputTarifRsVerif']);
            }
            /*
             * proses hitung tarif rs call pack
             */
            $bbBayiLahir = NULL;
            if (!empty($_POST['beratBadanBayiVerif'])) {
                $bbBayiLahir = $_POST['beratBadanBayiVerif'];
            }
            $data = array(
                'TRANS_KUNJ_PAS_TKPAS_ID' => $tkpasId,
                'TVERIFINA_NOREG' => $noReg,
                'TVERIFINA_NOMR' => $noRm,
                'TVERIFINA_NOPST' => $noPeserta,
                'TVERIFINA_NOJMN' => $noJaminan,
                'TVERIFINA_LOS' => $los,
                'TVERIFINA_ISBATAL' => '0',
                'TVERIFINA_MU_VERIF' => $this->session->userdata('userid'),
                'TVERIFINA_USERUPDATE' => $this->session->userdata('userid'),
                'TVERIFINA_HOT' => $hot,
                'TVERIFINA_ALKES' => $alkes,
                'TVERIFINA_BB_BAYI' => $bbBayiLahir,
                'TVERIFINA_TARIF_RS_KLAIM' => $tarifRsKlaim
            );
            if ($this->input_diagnosa_jmn_model->simpanVerifikasi($data, $waktuMasuk, $waktuKeluar, $tglSep, $namaSep, $tglLahirSep, $jenisKelaminSep) == TRUE) {
                $result['status'] = TRUE;
                $result['message'] = 'Proses verifikasi berhasil';
                if (substr($noReg, 0, 2) == '01') {
                    /*
                     * hitung ulang no reg yang sep nya sama dan irj
                     */
                    $dataReg = $this->input_diagnosa_jmn_model->noRegBySep($noJaminan, $noReg);
                    if ($dataReg != NULL) {
                        foreach ($dataReg as $row) {
                            $noRegLoop = $row->NO_REG;
                            if (substr($noRegLoop, 0, 2) == '01') {
                                $this->hitungTotalTagihan($noRegLoop);
                            }
                        }
                    } else {
                        $this->hitungTotalTagihan($noReg);
                    }
                }
                $tarifRsKlaimHitungUlang = $this->tarifTagihanRs($tkpasId, $noReg, $noJaminan);
                if (!empty($tarifRsKlaimHitungUlang)) {
                    $hu = $this->input_diagnosa_jmn_model->updateVerifInacbgTarifRsKlaimByKunjungan($tkpasId, $tarifRsKlaimHitungUlang);
                    if ($hu) {
                        $result['report'] = 'hitung ulang' . $tarifRsKlaimHitungUlang . ' berhasil';
                    } else {
                        $result['report'] = 'hitung ulang' . $tarifRsKlaimHitungUlang . ' gagal';
                    }
                } else {
                    $result['report'] = 'hitung ulang tidak dilakukan karena tarif 0';
                }
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Proses verifikasi gagal';
            }
        } else {
            $result['message'] = 'Identitas atau data tidak lengkap';
        }
        echo json_encode($result);
    }

    /*
     * hitung dan ambil tarif rs
     */

    function tarifTagihanRs($idKunj, $noReg, $noSep, $isHitungUlangTagihanIRJ = FALSE) {
        $tarifRsKlaim = 0;
        if (substr($noReg, 0, 2) == '01') {/* irj ambil by no sep */
            if ($isHitungUlangTagihanIRJ == TRUE) {
                /*
                 * hitung ulang no reg yang sep nya sama dan irj
                 */
                $dataReg = $this->input_diagnosa_jmn_model->noRegBySep($noSep, $noReg);
                if ($dataReg != NULL) {
                    foreach ($dataReg as $row) {
                        $noRegLoop = $row->NO_REG;
                        if (substr($noRegLoop, 0, 2) == '01') {
                            $this->hitungTotalTagihan($noRegLoop);
                        }
                    }
                } else {
                    $this->hitungTotalTagihan($noReg);
                }
            }
            $tarifRsKlaim = $this->input_diagnosa_jmn_model->totalTarifRsByNoSep($noSep, $noReg);
        } else {
            /* default tarif diambil data total tagihan */
            $tarifRsKlaim = $this->input_diagnosa_jmn_model->getTarifRsTotalTagihanByNoreg($noReg);
        }
        if (substr($noReg, 0, 2) == '02') {/* irna perhitungkan naik turun kelas */
            /*
             * ambil data kelas
             */
            $dataKelas = $this->input_diagnosa_jmn_model->kelasJaminanNaikTurunKelasKirimInacbg($noReg);
            $kelas = $dataKelas['kelasHak'];
            /*
             * cek jika naik kelas ke VIP atau diatasnya
             */
            if (($dataKelas['tingkatKelasJaminan'] > $dataKelas['tingkatKelasHak']) && ($dataKelas['tingkatKelasJaminan'] > $this->tingkatKelas1)) {
                $data = $this->hitungTagihan($idKunj, $noReg, $kelas);
                if ($data['totTgh']) {
                    $tarifRsKlaim = $data['totTgh'];
                } else {
                    $tarifRsKlaim = 0;
                }
            }
        }
        return round($tarifRsKlaim);
    }

    /*
     * start hitung tarif tagihan
     */

    /**
     * <p>CEK SETTING PEMBAYARAN GABUNG</p>
     */
    public function getSettingBayar() {
        $data = $this->kasir_model->cekSettingBayar();
        foreach ($data->result() as $row) {
            $kode = !empty($row->MSG_VALUE) ? $row->MSG_VALUE : '1';
        }

        return($kode);
    }

    /**
     * <p>AJAX HITUNG ULANG TAGIHAN BERDASAR KELAS</p>
     */
    public function hitungTagihan($idKunj, $noreg, $kelas) {
        if (!empty($idKunj) && !empty($noreg)) {
            $noregArr = explode('|', $noreg);
            //hitung ulang penunjang IRNA & IRD pada hitung terpisah
            $len = sizeOf($noregArr);
            if ((substr($noregArr[0], 0, 2) == '02' || substr($noregArr[0], 0, 2) == '03') && $len == 1) {
                $isBakuTempel = 1;
            } else {
                $isBakuTempel = 0;
            }

            //cek setting pembayaran
            $setting = $this->getSettingBayar();
            if ($setting == '1') {
                $noregTransfer = $this->kasir_model->getDaftarNoReg($idKunj, true);
            } else {
                $noregTransfer = $this->kasir_model->getDaftarNoReg($idKunj, false);
            }
            //hitung ulang tgh yg ditransfer ke noreg ini
            foreach ($noregTransfer->result() as $dataTransfer) {
                if ($noregArr[0] != $dataTransfer->TKPAS_NOREG) {
                    $noregArr[$len] = $dataTransfer->TKPAS_NOREG;
                    $len++;
                }
            }

            asort($noregArr); // sorting array noreg
            //hitung tagihan & jasa
            $noreg = '';
            $cnt = 0;
            $arrNoReg = '';
            foreach ($noregArr as $key => $val) {
                if ($noreg !== $val) {
                    $cnt++;
                    $arrNoReg .= '|' . $val;
                }
                $noreg = $val;
            }
            $this->simulasi_tagihan_model->hitungUlangTgh(substr($arrNoReg, 1), $cnt, $kelas);

            //hitung total tagihan setelah hitung ulang
            $re_data = $this->totalTagihanTmp($idKunj, $isBakuTempel);
            return $re_data;
        }
    }

    /*
     * <p>TOTAL DATA TAGIHAN PADA TABEL TEMPORARY</p>
     */

    function totalTagihanTmp($idKunj, $isBakuTempel = 0) {

        //cek setting pembayaran
        $setting = $this->getSettingBayar();
        if ($setting == '1' || $isBakuTempel == 1) {
            $tagihanObat = $this->kasir_model->getTotalDataTagihanObat($idKunj, true);
            $noreg = $this->kasir_model->getDaftarSemuaNoReg($idKunj);
        } else {
            $tagihanObat = $this->kasir_model->getTotalDataTagihanObat($idKunj, false);
            $noreg = $this->kasir_model->getDaftarSemuaNoRegPisah($idKunj);
        }
        $tagihan = $this->simulasi_tagihan_model->getTotalDataTagihanPlyTmp($noreg);
        $tagihanAkom = $this->simulasi_tagihan_model->getTotalDataTagihanAkomTmp($noreg);

        //resume tagihan, subsidi, jaminan
        $totTghAll = 0;
        $totBayar = 0;
        $totJmnAll = 0;
        $selJmnAll = 0;
        $totSubJmnAll = 0;
        $totSubFasAll = 0;
        $totDiskAll = 0;
        $totKrgnAll = 0;
        $totPiutAll = 0;
        $totCostAll = 0;
        $noFaktur = '';
        foreach ($tagihan->result() as $row) {
            $totTgh = !empty($row->TOTAL_TGH) ? $row->TOTAL_TGH : 0;
            $totTghAll += $totTgh;
            $totBayar += $totTgh;
        }
        foreach ($tagihanAkom->result() as $row) {
            $totTgh = !empty($row->TOTAL_TGH) ? $row->TOTAL_TGH : 0;
            $totTghAll += $totTgh;
            $totBayar += $totTgh;
        }
        foreach ($tagihanObat->result() as $row) {
            $totTgh = ($row->TOTAL_TGH * $row->TTGHO_JML_OBAT) + $row->TTGHO_TGH_TUSLAG_OBAT;
            if ($noFaktur != $row->TPBRGM_NO_FAKTUR) {
                $bulatTgh = $row->TPTOBT_TGH_FAKTUR;
            } else {
                $bulatTgh = 0;
            }
            $noFaktur = $row->TPBRGM_NO_FAKTUR;
            $totTgh = round($totTgh, 2);
            $totTghAll += $totTgh + $bulatTgh;
            $totBayar += $totTgh + $bulatTgh;
        }

        $re_data = array(
            'totTgh' => ($totTghAll == 0) ? '0' : $totTghAll,
            'totBayar' => ($totBayar == 0) ? '0' : $totBayar,
            'totJmn' => ($totJmnAll == 0) ? '0' : $totJmnAll,
            'selJmn' => ($selJmnAll == 0) ? '0' : $selJmnAll,
            'totSubJmn' => ($totSubJmnAll == 0) ? '0' : $totSubJmnAll,
            'totSubFas' => ($totSubFasAll == 0) ? '0' : $totSubFasAll,
            'totDisk' => ($totDiskAll == 0) ? '0' : $totDiskAll,
            'totKrgn' => ($totKrgnAll == 0) ? '0' : $totKrgnAll,
            'totPiut' => ($totPiutAll == 0) ? '0' : $totPiutAll,
            'totCost' => ($totCostAll == 0) ? '0' : $totCostAll
        );

        return $re_data;
    }

    /*
     * end hitung tarif tagihan
     */

    /*
     * proses update data sep cara bayar
     */

    public function prosesUpdateSepCarabayar() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'report' => ''
        );
        $strReport = '';
        $strReport .= '#ada proses simpan sep';
        $noReg = !empty($_POST['noRegSEPAuto']) ? $_POST['noRegSEPAuto'] : '';
        $noJaminan = !empty($_POST['noPenjaminanSEPAuto']) ? $_POST['noPenjaminanSEPAuto'] : '';
        $namaPasienSep = !empty($_POST['namaPasienSEPAuto']) ? $_POST['namaPasienSEPAuto'] : '';
        $tanggalLahirSep = !empty($_POST['tanggalLahirSEPAuto']) ? $_POST['tanggalLahirSEPAuto'] : '';
        $kodeJenisKelaminSep = !empty($_POST['kodeJenisKelaminSEPAuto']) ? $_POST['kodeJenisKelaminSEPAuto'] : '';
        if (!empty($noReg) && !empty($noJaminan) && !empty($namaPasienSep) && !empty($tanggalLahirSep) && !empty($kodeJenisKelaminSep)) {
            //update identitas sep ke trans_cara bayar
            $dataUpdatePasienCaraBayar = array(
                'TCBYR_GENDERPST' => strtoupper($kodeJenisKelaminSep),
                'TCBYR_NAMAPST' => str_replace("'", "''", $namaPasienSep)
            );
            if ($this->input_diagnosa_jmn_model->updateIdentitasPasienCarabayar($dataUpdatePasienCaraBayar, $tanggalLahirSep, $noJaminan, $noReg) == TRUE) {
                $strReport .= '#update Sep pasien cara bayar berhasil';
            } else {
                $strReport .= '#update Sep pasien cara bayar gagal';
            }
        } else {
            $strReport .= '#tidak jadi simpan sep karena ada data yg kosong';
            $data['message'] = 'beberapa data Sep Tidak lengkap';
        }
        $data['report'] = $strReport;
        echo json_encode($data);
    }

    /*
     * proses batal verifikasi
     * dengan cek status final -DenganCekStatusFinal
     */

    public function prosesBatalVerifikasiDenganCekStatusFinal() {
        $result = array(
            'status' => FALSE,
            'message' => NULL,
            'statusFinalInacbg' => FALSE
        );
        if (!empty($_POST['hiddenKunjId'])) {
            $tkpasId = $_POST['hiddenKunjId'];
            //cek status kirim inacbg
            if ($this->input_diagnosa_jmn_model->cekSudahKirimInacbgByTkpasId($tkpasId) == TRUE) {//jika pernah kirim data ke incbg
                //cek koneksi server inacbg
                if ($this->input_diagnosa_jmn_model->cekKoneksiServerInacbg() == TRUE) {
                    //cek status final
                    if ($this->input_diagnosa_jmn_model->statusFinalInacbg($tkpasId) == TRUE) {
                        $result['message'] = 'Status inacbg sudah final. Tidak bisa membatalkan Verifikasi';
                        $result['statusFinalInacbg'] = TRUE;
                    } else {
                        if ($this->input_diagnosa_jmn_model->batalVerifikasi($tkpasId)) {
                            $result['status'] = TRUE;
                            $result['message'] = 'Proses batal verifikasi berhasil';
                        } else {
                            $result['status'] = FALSE;
                            $result['message'] = 'Proses batal verifikasi gagal';
                        }
                    }
                } else {
                    $result['status'] = FALSE;
                    $result['message'] = 'Saat ini tidak dapat membatalkan verifikasi karena tidak dapat terkoneksi dengan server inacbg';
                }
            } else {
                //proses pembatalan
                if ($this->input_diagnosa_jmn_model->batalVerifikasi($tkpasId)) {
                    $result['status'] = TRUE;
                    $result['message'] = 'Proses batal verifikasi berhasil';
                } else {
                    $result['status'] = FALSE;
                    $result['message'] = 'Proses batal verifikasi gagal';
                }
            }
        } else {
            $result['message'] = 'Identitas atau data tidak lengkap';
        }
        echo json_encode($result);
    }

    /*
     * proses batal verifikasi
     * tidak mengcek status final -TanpaCekStatusFinal
     */

    public function prosesBatalVerifikasi() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'statusFinalInacbg' => FALSE,
            'report' => NULL
        );
        if (
                !empty($_POST['idKunjBatalVerif']) &&
                !empty($_POST['alasanBatalVerif']) &&
                !empty($_POST['keteranganBatalVerif']) &&
                !empty($_POST['userNameBatalVerif']) &&
                !empty($_POST['userPasswordBatalVerif'])
        ) {
            $idKunj = $this->input->post('idKunjBatalVerif');
            $alasan = $this->input->post('alasanBatalVerif');
            $keterangan = $this->input->post('keteranganBatalVerif');
            $username = $this->security->xss_clean($this->input->post('userNameBatalVerif'));
            $password1 = $this->security->xss_clean($this->input->post('userPasswordBatalVerif'));
            $password = $this->encrypt->sha1($password1);

            $this->load->model('main/main_model');
            $string = $this->main_model->login($username, $password);
            $data['status'] = $string;
            // index 0: true/false | index 1: userid | index 2: username | index 3: usergroup 
            $login = explode(',', $string);
            if ($login[0] == 'false') {
                $data['status'] = FALSE;
                $data['message'] = 'Username atau Password salah';
            } else {
                $previleges = privilagesDb($this->modulId, $login[3]);
                if (!empty($previleges['batal_validasi'])) {
                    $dataBatal = array(
                        'ID_KUNJ' => $idKunj,
                        'USER_ID' => $login[1],
                        'USER_GROUP' => $login[3],
                        'ALASAN' => $alasan,
                        'KETERANGAN' => $keterangan
                    );
                    $prosesBatal = $this->input_diagnosa_jmn_model->batalVerifInacbg($dataBatal);
                    if ($prosesBatal['status'] == TRUE) {
                        $data['status'] = TRUE;
                        $data['message'] = 'Proses batal verifikasi berhasil';
                    } else {
                        $data['message'] = 'Proses batal verifikasi gagal';
                    }
                    $data['report'] = $prosesBatal['report'];
                } else {
                    $data['message'] = 'Maaf Anda tidak memiliki hak akses untuk batal verifikasi';
                }
            }
        } else {
            $data['message'] = 'Data tidak lengkap';
        }
        echo json_encode($data);
    }

    /*
     * proses grouper inacbg
     */

    public function getUrlGrouperIncbgServerTest() {
        $data = array(
            'stringUrl' => NULL,
            'message' => NULL,
            'report' => ''
        );
        $strReport = '';
        if (!empty($_POST['noReg'])) {
            /* Ambil WS */
            $WS = $this->input_diagnosa_jmn_model->getWS(KIRIM_INACBG_TEST);
            if ($WS != NULL) {
                $noReg = $_POST['noReg'];
                $dataKunjPasien = $this->input_diagnosa_jmn_model->dataKunjunganPasienGrouper($noReg);
                if ($dataKunjPasien != NULL) {
                    $dataDiagPasien = $this->input_diagnosa_jmn_model->dataDiagnosaPasienInacbg($noReg);
                    if ($dataDiagPasien != NULL) {
                        $diag = '';
                        /* Ambil Diagnosa Pasien */
                        for ($y = 1; $y <= 30; $y++) {
                            $diag .= '&diag' . $y . '=' . (!empty($dataDiagPasien[$y - 1]['KODE_ICD10_INACBG']) ? $dataDiagPasien[$y - 1]['KODE_ICD10_INACBG'] : '');
                        }
                        /* Ambil Tindakan Pasien */
                        $dataTindPasien = $this->input_diagnosa_jmn_model->dataTindakanPasienInacbg($noReg);
                        $proc = '';
                        for ($z = 1; $z <= 30; $z++) {
                            $proc .= '&proc' . $z . '=' . (!empty($dataTindPasien[$z - 1]['KODE_ICD9_INACBG']) ? $dataTindPasien[$z - 1]['KODE_ICD9_INACBG'] : '');
                        }

                        $procedure = '';
                        $drugs = '';
                        $investigasi = '';
                        $prosthesisi = '';
                        $dataCMG = $this->input_diagnosa_jmn_model->dataCMGByNoreg($noReg);
                        if ($dataCMG != NULL) {
                            if (!empty($dataCMG->KODE_PROCE)) {
                                $procedure = $dataCMG->KODE_PROCE;
                            }
                            if (!empty($dataCMG->KODE_DRUGS)) {
                                $drugs = $dataCMG->KODE_DRUGS;
                            }
                            if (!empty($dataCMG->KODE_INVESTIGASI)) {
                                $investigasi = $dataCMG->KODE_INVESTIGASI;
                            }
                            if (!empty($dataCMG->KODE_PROSTESIS)) {
                                $prosthesisi = $dataCMG->KODE_PROSTESIS;
                            }
                        }

                        $user = '';
                        if ($WS['SWSSERV_USERNAME'] != NULL) {
                            $user = $WS['SWSSERV_USERNAME'];
                        }
                        $pass = '';
                        if ($WS['SWSSERV_PASSWORD'] != NULL) {
                            $pass = $WS['SWSSERV_PASSWORD'];
                        }
                        $noRm = '';
                        if ($dataKunjPasien['NORM'] != NULL) {
                            $noRm = $dataKunjPasien['NORM'];
                        }
                        $namaPasien = '';
                        if ($dataKunjPasien['NAMA_PASIEN'] != NULL) {
                            $namaPasien = $dataKunjPasien['NAMA_PASIEN'];
                        }
                        $jenisKelamin = '';
                        if ($dataKunjPasien['JENIS_KELAMIN'] != NULL) {
                            $jenisKelamin = $dataKunjPasien['JENIS_KELAMIN'];
                        }
                        $tanggalLahir = '';
                        if ($dataKunjPasien['TGL_LAHIR'] != NULL) {
                            $tanggalLahir = $dataKunjPasien['TGL_LAHIR'];
                        }
                        $jenisBayar = '';
                        if ($dataKunjPasien['CARA_BAYAR_INACBG'] != NULL) {
                            $jenisBayar = $dataKunjPasien['CARA_BAYAR_INACBG'];
                        }
                        $noPeserta = '';
                        if ($dataKunjPasien['NO_PESERTA'] != NULL) {
                            $noPeserta = $dataKunjPasien['NO_PESERTA'];
                        }
                        $noSep = '';
                        if ($dataKunjPasien['NO_PENJAMINAN'] != NULL) {
                            $noSep = $dataKunjPasien['NO_PENJAMINAN'];
                        }
                        $jenisPerawatan = '';
                        if ($dataKunjPasien['JENIS_PERAWATAN'] != NULL) {
                            $jenisPerawatan = $dataKunjPasien['JENIS_PERAWATAN'];
                        }
                        $kelasPerawatan = '';
                        if ($jenisPerawatan == '2') {//jika jenis perawatan irj = 2
                            $kelasPerawatan = '3';
                            $strReport .= '#kelas perawatan 3 irj';
                        } else {
                            if ($dataKunjPasien['KELAS_INACBG'] != NULL) {
                                $kelasPerawatan = $dataKunjPasien['KELAS_INACBG'];
                            }
                            $strReport .= '#kelas perawatan ' . $kelasPerawatan;
                            //cek naik turun kelas
                            $naikTurunKelas = $this->input_diagnosa_jmn_model->getNaikTurunKelasKirimInacbg($noReg);
                            if ($naikTurunKelas != NULL) {
                                $kelasPerawatan = $naikTurunKelas;
                                $strReport .= '#naik turun kelas ' . $naikTurunKelas;
                            } else {
                                $strReport .= '#naik turun kelas null';
                            }
                        }
                        $tglMasuk = dateReverse(tglsekarang());
                        if ($dataKunjPasien['TGL_REG'] != NULL) {
                            $tglMasuk = $dataKunjPasien['TGL_REG'];
                        }
                        //cek registrasi hari sama
                        $dataCekInacbg = $this->input_diagnosa_jmn_model->cekDataInacbgByRmTgl($noRm, $tglMasuk, 0);
                        if ($dataCekInacbg['data'] != NULL) {
                            $strReport .= $dataCekInacbg['report'];
                            $isPernahKirim = FALSE;
                            $tglPernahKirim = NULL;
                            $tglMasukFull = $dataKunjPasien['TGL_JAM_REG'];
                            foreach ($dataCekInacbg['data'] as $rowCek) {
                                $cekNoReg = $rowCek->noReg;
                                $tglRegFull = $rowCek->tglRegFull;
                                if (!empty($cekNoReg)) {
                                    if ($noReg == $cekNoReg) {//jika ada no registrasi sama
                                        $isPernahKirim = TRUE;
                                        $tglPernahKirim = $tglRegFull;
                                    }
                                }
                            }
                            if ($isPernahKirim == TRUE) {//tgl mengikuti tgl sebelumnya yang sudah dikirim
                                $tglMasuk = $tglPernahKirim;
                                $strReport .= ' tgl masuk = tgl masuk sebelumnya Y-m-d h:i:s';
                            } else {
                                $tglMasuk = $tglMasukFull;
                                $strReport .= ' tgl masuk = masuk full';
                            }
                        } else {
                            $strReport .= $dataCekInacbg['report'];
                            $strReport .= ' tgl masuk = masuk Y-m-d';
                        }
                        //end cek
                        $tglKeluar = dateReverse(tglsekarang());
                        if ($dataKunjPasien['TGL_REG_KELUAR'] != NULL) {
                            $tglKeluar = $dataKunjPasien['TGL_REG_KELUAR'];
                        }
                        $caraKeluar = '5';
                        if ($dataKunjPasien['KODE_CARA_KELUAR_INACBG'] != NULL) {
                            $caraKeluar = $dataKunjPasien['KODE_CARA_KELUAR_INACBG'];
                        }
                        if ($jenisPerawatan == '2') {//jika jenis perawatan irj = 2
                            if ($this->input_diagnosa_jmn_model->isDiRujukKeIrna($noReg) == TRUE) {
                                $caraKeluar = '2';
                                $strReport .= '#irj dirujuk irna - cara keluar transfer(2)';
                            } else {
                                $caraKeluar = '1';
                                $strReport .= '#irj - cara keluar home(1)';
                            }
                        }
                        $dokterPJ = '';
                        if ($dataKunjPasien['DOKTER_PJ'] != NULL) {
                            $dokterPJ = $dataKunjPasien['DOKTER_PJ'];
                        }
                        $beratLahir = '0';
                        if ($dataKunjPasien['BERAT_LAHIR'] != NULL) {
                            $beratLahir = $dataKunjPasien['BERAT_LAHIR'];
                        }
                        $rujukan = '';
                        if ($dataKunjPasien['SURAT_RUJUKAN'] != NULL) {
                            $rujukan = $dataKunjPasien['SURAT_RUJUKAN'];
                        }
                        $tarif = $dataKunjPasien['TARIF_RS_KLAIM'];
                        if (!empty($jenisBayar)) {
                            if (!empty($dokterPJ)) {
                                $data_kirim = "user_nm=" . $user . "&user_pw=" . $pass
                                        . "&norm=" . $noRm . "&nm_pasien=" . $namaPasien . "&jns_kelamin=" . $jenisKelamin
                                        . "&tgl_lahir=" . $tanggalLahir . "&jns_pbyrn=" . $jenisBayar . "&no_peserta=" . $noSep
                                        . "&no_sep=" . $noPeserta . "&jns_perawatan=" . $jenisPerawatan . "&kls_perawatan=" . $kelasPerawatan
                                        . "&tgl_masuk=" . $tglMasuk . "&tgl_keluar=" . $tglKeluar . "&cara_keluar=" . $caraKeluar
                                        . "&dpjp=" . $dokterPJ . "&berat_lahir=" . $beratLahir . "&tarif_rs=" . $tarif
                                        . "&srt_rujukan=" . $rujukan . "&bhp=" . "" . "&severity=" . "0" . "&adl=" . "0" . "&spec_proc=" . $procedure . "&spec_dr=" . $drugs
                                        . "&spec_inv=" . $investigasi . "&spec_prosth=" . $prosthesisi . $diag . $proc;

                                $stringUrl = $WS['SWSSERV_ALAMAT_SERVER'] . $data_kirim;
                                $data['stringUrl'] = $stringUrl;
                            } else {
                                $data['message'] = 'Dokter Penanggung jawab belum di inputkan';
                            }
                        } else {
                            $data['message'] = 'Pasien tidak menggunakan cara bayar inacbg';
                        }
                    } else {
                        $data['message'] = 'Harus menginputkan data diagnosa terlebih dahulu';
                    }
                } else {
                    $data['message'] = 'Data Pasien dengan No Registrasi ' . $noReg . ' tidak ditemukan';
                }
            } else {
                $data['message'] = 'Setting servis tidak ditemukan';
            }
        } else {
            $data['message'] = 'No Registrasi kosong';
        }
        $data['report'] = $strReport;
        echo json_encode($data);
    }

    /*
     * proses grouper inacbg Asli
     */

    public function getUrlGrouperIncbgSeverAsli() {
        $data = array(
            'stringUrl' => NULL,
            'message' => NULL,
            'report' => ''
        );
        $strReport = '';
        if (!empty($_POST['noReg'])) {
            $noReg = $_POST['noReg'];
            $isAdaPiutang = $this->input_diagnosa_jmn_model->cekAdaPiutangPerorangan($noReg);
            if ($isAdaPiutang == TRUE) {
                /*
                 * cek apakah sesuai hak atau turun kelas, naik turun kelas jaminan
                 */
                $dataKelas = $this->input_diagnosa_jmn_model->kelasJaminanNaikTurunKelasKirimInacbg($noReg);
                if ($dataKelas['tingkatKelasHak'] >= $dataKelas['tingkatKelasJaminan']) {
                    /*
                     * jika kelas jaminan sesuai dengan kelas hak atau turun kelas
                     * maka tetap boleh kirim grouping walau ada piutang
                     */
                    $isAdaPiutang = FALSE;
                }
            }
            if ($isAdaPiutang == FALSE) {
                /* Ambil WS */
                try {
                    $WS = $this->input_diagnosa_jmn_model->getWS(KIRIM_INACBG);
                    if ($WS != NULL) {
                        $dataKunjPasien = $this->input_diagnosa_jmn_model->dataKunjunganPasienKirimGrouper($noReg);
                        if ($dataKunjPasien != NULL) {
                            $dataDiagPasien = $this->input_diagnosa_jmn_model->dataDiagnosaPasienInacbg($noReg);
                            if ($dataDiagPasien != NULL) {
                                $isAdaPrimary = FALSE; //harus ada diagnosa primary
                                $isNotNullDiagnosa = TRUE;
                                $messageNotNullDiagnosa = '';
                                //validasi diagnosa tidak boleh ada yang null/kosong
                                for ($i = 0; $i < count($dataDiagPasien); $i++) {
                                    if (empty($dataDiagPasien[$i]['KODE_ICD10_INACBG'])) {
                                        $isNotNullDiagnosa = FALSE;
                                        $messageNotNullDiagnosa .= 'Diagnosa ' . $dataDiagPasien[$i]['KODE_ICD10'] . ' tidak terdapat dalam inacbg ';
                                    }
                                    //cek diagnosa primary
                                    if ($dataDiagPasien[$i]['JENIS_DIAGNOSA'] == '02') {
                                        $isAdaPrimary = TRUE;
                                    }
                                }
                                //cek diagnosa primary
                                if ($isAdaPrimary == TRUE) {
                                    if ($isNotNullDiagnosa == TRUE) {
                                        $diag = '';
                                        /* Ambil Diagnosa Pasien */
                                        for ($y = 1; $y <= 30; $y++) {
                                            $diag .= '&diag' . $y . '=' . (!empty($dataDiagPasien[$y - 1]['KODE_ICD10_INACBG']) ? $dataDiagPasien[$y - 1]['KODE_ICD10_INACBG'] : '');
                                        }
                                        /* Ambil Tindakan Pasien */
                                        $dataTindPasien = $this->input_diagnosa_jmn_model->dataTindakanPasienInacbg($noReg);
                                        $proc = '';
                                        for ($z = 1; $z <= 30; $z++) {
                                            $proc .= '&proc' . $z . '=' . (!empty($dataTindPasien[$z - 1]['KODE_ICD9_INACBG']) ? $dataTindPasien[$z - 1]['KODE_ICD9_INACBG'] : '');
                                        }
                                        $procedure = '';
                                        $drugs = '';
                                        $investigasi = '';
                                        $prosthesisi = '';
                                        $dataCMG = $this->input_diagnosa_jmn_model->dataCMGByNoreg($noReg);
                                        if ($dataCMG != NULL) {
                                            if (!empty($dataCMG->KODE_PROCE)) {
                                                $procedure = $dataCMG->KODE_PROCE;
                                            }
                                            if (!empty($dataCMG->KODE_DRUGS)) {
                                                $drugs = $dataCMG->KODE_DRUGS;
                                            }
                                            if (!empty($dataCMG->KODE_INVESTIGASI)) {
                                                $investigasi = $dataCMG->KODE_INVESTIGASI;
                                            }
                                            if (!empty($dataCMG->KODE_PROSTESIS)) {
                                                $prosthesisi = $dataCMG->KODE_PROSTESIS;
                                            }
                                        }

                                        $user = '';
                                        if ($WS['SWSSERV_USERNAME'] != NULL) {
                                            $user = $WS['SWSSERV_USERNAME'];
                                        }
                                        $pass = '';
                                        if ($WS['SWSSERV_PASSWORD'] != NULL) {
                                            $pass = $WS['SWSSERV_PASSWORD'];
                                        }
                                        $noRm = '';
                                        if ($dataKunjPasien['NORM'] != NULL) {
                                            $noRm = $dataKunjPasien['NORM'];
                                        }
                                        $noPeserta = '';
                                        if ($dataKunjPasien['NO_PESERTA'] != NULL) {
                                            $noPeserta = $dataKunjPasien['NO_PESERTA'];
                                        }
                                        $noSep = '';
                                        if ($dataKunjPasien['NO_PENJAMINAN'] != NULL) {
                                            $noSep = $dataKunjPasien['NO_PENJAMINAN'];
                                        }
                                        /*
                                         * jika cara bayar bridging sep
                                         * maka indentitas disesuaikan dengan data BPJS
                                         */
                                        $namaPasien = '';
                                        $jenisKelamin = '';
                                        $tanggalLahir = '';
                                        if ($dataKunjPasien['IS_BRIDGING_SEP'] == '1') {
                                            $strReport .= '#pasien sep';
                                            //identitas dari cara bayar
                                            $NotNullIdentitas = TRUE;
                                            if ($dataKunjPasien['NAMA_PASIEN_SEP'] != NULL) {
                                                $namaPasien = $dataKunjPasien['NAMA_PASIEN_SEP'];
                                                $strReport .= '#ada nama sep';
                                            } else {
                                                $NotNullIdentitas = FALSE;
                                                $strReport .= '#tidak ada nama sep';
                                            }
                                            if ($dataKunjPasien['JENIS_KELAMIN_SEP'] != NULL) {
                                                $jenisKelamin = $dataKunjPasien['JENIS_KELAMIN_SEP'];
                                                $strReport .= '#ada jk sep';
                                            } else {
                                                $NotNullIdentitas = FALSE;
                                                $strReport .= '#tidak ada jk sep';
                                            }
                                            if ($dataKunjPasien['TGL_LAHIR_SEP'] != NULL) {
                                                $tanggalLahir = $dataKunjPasien['TGL_LAHIR_SEP'];
                                                $strReport .= '#ada tgl sep';
                                            } else {
                                                $NotNullIdentitas = FALSE;
                                                $strReport .= '#tidak ada tgl sep';
                                            }
                                            //ambil identitas from server BPJS karena identitas pasien
                                            $isDapatSEP = TRUE;
                                            if ($NotNullIdentitas == FALSE) {
                                                $strReport .= '#ambil data sep';
                                                $dataSEP = $this->getDataSEPOnLine($noSep);
                                                if (!empty($dataSEP['message'])) {
                                                    $strReport .= '#' . $dataSEP['message'];
                                                }
                                                if (!empty($dataSEP['report'])) {
                                                    $strReport .= '#' . $dataSEP['report'];
                                                }
                                                if (!empty($dataSEP['data']['namaPasien'])) {
                                                    $strReport .= '#dapat data sep';
                                                    $namaPasien = $dataSEP['data']['namaPasien'];
                                                    $tanggalLahir = $dataSEP['data']['tanggalLahir'];
                                                    $kodeJenisKelamin = strtoupper($dataSEP['data']['kodeJenisKelamin']);
                                                    if ($kodeJenisKelamin == 'L') {
                                                        $jenisKelamin = '1';
                                                    } else {
                                                        $jenisKelamin = '2';
                                                    }
                                                    //update identitas sep ke trans_cara bayar
                                                    $dataUpdatePasienCaraBayar = array(
                                                        'TCBYR_GENDERPST' => $kodeJenisKelamin,
                                                        'TCBYR_NAMAPST' => str_replace("'", "''", $namaPasien)
                                                    );
                                                    if ($this->input_diagnosa_jmn_model->updateIdentitasPasienCarabayar($dataUpdatePasienCaraBayar, $tanggalLahir, $noSep, $noReg) == TRUE) {
                                                        $strReport .= '#update pasien cara bayar berhasil';
                                                    } else {
                                                        $strReport .= '#update pasien cara bayar gagal';
                                                    }
                                                } else {
                                                    $isDapatSEP = FALSE;
                                                    $strReport .= '#tidak dapat data sep';
                                                }
                                            }
                                            //ambil identitas pasien dari mst pasien jika tidak dapat identitas SEP
                                            if ($isDapatSEP == FALSE) {
                                                if ($dataKunjPasien['NAMA_PASIEN'] != NULL) {
                                                    $namaPasien = $dataKunjPasien['NAMA_PASIEN'];
                                                    $strReport .= '#nama dari master';
                                                }
                                                if ($dataKunjPasien['JENIS_KELAMIN'] != NULL) {
                                                    $jenisKelamin = $dataKunjPasien['JENIS_KELAMIN'];
                                                    $strReport .= '#jk dari master';
                                                }
                                                if ($dataKunjPasien['TGL_LAHIR'] != NULL) {
                                                    $tanggalLahir = $dataKunjPasien['TGL_LAHIR'];
                                                    $strReport .= '#tgl dari master';
                                                }
                                            }
                                            //end validasi identitas pasien
                                        } else {//ambil dari data master pasien
                                            $strReport .= '#bukan sep';
                                            if ($dataKunjPasien['NAMA_PASIEN'] != NULL) {
                                                $namaPasien = $dataKunjPasien['NAMA_PASIEN'];
                                                $strReport .= '#nama dari master';
                                            }
                                            if ($dataKunjPasien['JENIS_KELAMIN'] != NULL) {
                                                $jenisKelamin = $dataKunjPasien['JENIS_KELAMIN'];
                                                $strReport .= '#jk dari master';
                                            }
                                            if ($dataKunjPasien['TGL_LAHIR'] != NULL) {
                                                $tanggalLahir = $dataKunjPasien['TGL_LAHIR'];
                                                $strReport .= '#tgl dari master';
                                            }
                                        }
                                        $jenisBayar = '';
                                        if ($dataKunjPasien['CARA_BAYAR_INACBG'] != NULL) {
                                            $jenisBayar = $dataKunjPasien['CARA_BAYAR_INACBG'];
                                        }
                                        $jenisPerawatan = '';
                                        if ($dataKunjPasien['JENIS_PERAWATAN'] != NULL) {
                                            $jenisPerawatan = $dataKunjPasien['JENIS_PERAWATAN'];
                                        }
                                        $kelasPerawatan = '';
                                        if ($jenisPerawatan == '2') {//jika jenis perawatan irj = 2
                                            $kelasPerawatan = '3';
                                            $strReport .= '#kelas perawatan 3 irj';
                                        } else {
                                            if ($dataKunjPasien['KELAS_INACBG'] != NULL) {
                                                $kelasPerawatan = $dataKunjPasien['KELAS_INACBG'];
                                            }
                                            $strReport .= '#kelas perawatan ' . $kelasPerawatan;
                                            //cek naik turun kelas
                                            $naikTurunKelas = $this->input_diagnosa_jmn_model->getNaikTurunKelasKirimInacbg($noReg);
                                            if ($naikTurunKelas != NULL) {
                                                $kelasPerawatan = $naikTurunKelas;
                                                $strReport .= '#naik turun kelas ' . $naikTurunKelas;
                                            } else {
                                                $strReport .= '#naik turun kelas null';
                                            }
                                        }
                                        $tglMasuk = dateReverse(tglsekarang());
                                        if ($dataKunjPasien['TGL_REG'] != NULL) {
                                            $tglMasuk = $dataKunjPasien['TGL_REG'];
                                        }
                                        //cek registrasi hari sama
                                        $dataCekInacbg = $this->input_diagnosa_jmn_model->cekDataInacbgByRmTgl($noRm, $tglMasuk, 1);
                                        if ($dataCekInacbg['data'] != NULL) {
                                            $strReport .= $dataCekInacbg['report'];
                                            $isPernahKirim = FALSE;
                                            $tglPernahKirim = NULL;
                                            $tglMasukFull = $dataKunjPasien['TGL_JAM_REG'];
                                            foreach ($dataCekInacbg['data'] as $rowCek) {
                                                $cekNoReg = $rowCek->noReg;
                                                $tglRegFull = $rowCek->tglRegFull;
                                                if (!empty($cekNoReg)) {
                                                    if ($noReg == $cekNoReg) {//jika ada no registrasi sama
                                                        $isPernahKirim = TRUE;
                                                        $tglPernahKirim = $tglRegFull;
                                                    }
                                                }
                                            }
                                            if ($isPernahKirim == TRUE) {//tgl mengikuti tgl sebelumnya yang sudah dikirim
                                                $tglMasuk = $tglPernahKirim;
                                                $strReport .= ' tgl masuk = tgl masuk sebelumnya Y-m-d h:i:s';
                                            } else {
                                                $tglMasuk = $tglMasukFull;
                                                $strReport .= ' tgl masuk = masuk full';
                                            }
                                        } else {
                                            $strReport .= $dataCekInacbg['report'];
                                            $strReport .= ' tgl masuk = masuk Y-m-d';
                                        }
                                        //end cek
                                        $tglKeluar = dateReverse(tglsekarang());
                                        if ($dataKunjPasien['TGL_REG_KELUAR'] != NULL) {
                                            $tglKeluar = $dataKunjPasien['TGL_REG_KELUAR'];
                                        }
                                        $caraKeluar = '5';
                                        if ($dataKunjPasien['KODE_CARA_KELUAR_INACBG'] != NULL) {
                                            $caraKeluar = $dataKunjPasien['KODE_CARA_KELUAR_INACBG'];
                                        }
                                        if ($jenisPerawatan == '2') {//jika jenis perawatan irj = 2
                                            if ($this->input_diagnosa_jmn_model->isDiRujukKeIrna($noReg) == TRUE) {
                                                $caraKeluar = '2';
                                                $strReport .= '#irj dirujuk irna - cara keluar transfer(2)';
                                            } else {
                                                $caraKeluar = '1';
                                                $strReport .= '#irj - cara keluar home(1)';
                                            }
                                        }
                                        $dokterPJ = '';
                                        if ($dataKunjPasien['DOKTER_PJ'] != NULL) {
                                            $dokterPJ = $dataKunjPasien['DOKTER_PJ'];
                                        }
                                        $beratLahir = '0';
                                        if ($dataKunjPasien['BERAT_LAHIR'] != NULL) {
                                            $beratLahir = $dataKunjPasien['BERAT_LAHIR'];
                                        }
                                        $rujukan = '';
                                        if ($dataKunjPasien['SURAT_RUJUKAN'] != NULL) {
                                            $rujukan = $dataKunjPasien['SURAT_RUJUKAN'];
                                        }
                                        $tarif = $dataKunjPasien['TARIF_RS_KLAIM'];
                                        if (!empty($jenisBayar)) {
                                            if (!empty($dokterPJ)) {
                                                $data_kirim = "user_nm=" . $user . "&user_pw=" . $pass
                                                        . "&norm=" . $noRm . "&nm_pasien=" . $namaPasien . "&jns_kelamin=" . $jenisKelamin
                                                        . "&tgl_lahir=" . $tanggalLahir . "&jns_pbyrn=" . $jenisBayar . "&no_peserta=" . $noSep
                                                        . "&no_sep=" . $noPeserta . "&jns_perawatan=" . $jenisPerawatan . "&kls_perawatan=" . $kelasPerawatan
                                                        . "&tgl_masuk=" . $tglMasuk . "&tgl_keluar=" . $tglKeluar . "&cara_keluar=" . $caraKeluar
                                                        . "&dpjp=" . $dokterPJ . "&berat_lahir=" . $beratLahir . "&tarif_rs=" . $tarif
                                                        . "&srt_rujukan=" . $rujukan . "&bhp=" . "" . "&severity=" . "0" . "&adl=" . "0" . "&spec_proc=" . $procedure . "&spec_dr=" . $drugs
                                                        . "&spec_inv=" . $investigasi . "&spec_prosth=" . $prosthesisi . $diag . $proc;

                                                $stringUrl = $WS['SWSSERV_ALAMAT_SERVER'] . $data_kirim;
                                                $data['stringUrl'] = $stringUrl;
                                            } else {
                                                $data['message'] = 'Dokter Penanggung jawab belum di inputkan';
                                            }
                                        } else {
                                            $data['message'] = 'Pasien tidak menggunakan cara bayar inacbg';
                                        }
                                    } else {
                                        $data['message'] = $messageNotNullDiagnosa;
                                    }
                                } else {
                                    $data['message'] = 'Belum ada Diagnosa Primary';
                                }
                            } else {
                                $data['message'] = 'Harus menginputkan data diagnosa terlebih dahulu';
                            }
                        } else {
                            $data['message'] = 'Data Pasien dengan No Registrasi ' . $noReg . ' tidak ditemukan atau belum diverifikasi';
                        }
                    } else {
                        $data['message'] = 'Setting servis tidak ditemukan';
                    }
                } catch (Exception $exc) {
                    $data['report'] .= $exc->getMessage();
                    $data['report'] .= $exc->getTraceAsString();
                }
            } else {
                $data['message'] = 'Pasien memiliki piutang, Batalkan piutang terlebih dahulu untuk melakukan grouping';
            }
        } else {
            $data['message'] = 'No Registrasi kosong';
        }
        $data['report'] = $strReport;
        echo json_encode($data);
    }

    /*
     * mengambil data informasi SEP
     */

    public function getDataSEPOnLine($noSep) {
        $data = array(
            'data' => NULL,
            'message' => NULL,
            'report' => ''
        );
        if (!empty($noSep)) {
            $header = array(
                'Accept' => 'application/json'
            );
            $WS = $this->input_diagnosa_jmn_model->getWS('cekSEP');
            if ($WS != NULL) {
                $alamatService = $WS['SWSSERV_ALAMAT_SERVER'];
                if (!empty($alamatService)) {
                    //cek koneksi server
                    $url = $alamatService . $noSep;
                    try {
                        $request = Requests::get($url, $header);
                        if (!empty($request->status_code)) {
                            if ($request->status_code == '200') {
                                if (!empty($request->body)) {
                                    $response = json_decode($request->body);
                                    if ($response->metaData->code == '200') {
                                        if (!empty($response->response)) {
                                            $jenisKelamin = strval($response->response->pesertasep->kelamin);
                                            $namaPasien = strval($response->response->pesertasep->nama);
                                            $noKartu = strval($response->response->pesertasep->noKartuBpjs);
                                            $noRm = strval($response->response->pesertasep->noMr);
                                            $noRujukan = strval($response->response->pesertasep->noRujukan);
                                            $tglLahir = strval($response->response->pesertasep->tglLahir);
                                            $tglPelayanan = strval($response->response->pesertasep->tglPelayanan);
                                            $pelayanan = strval($response->response->pesertasep->tktPelayanan);
                                            $data['data']['namaPasien'] = $namaPasien;
                                            $data['data']['noRm'] = $noRm;
                                            $data['data']['noKartu'] = $noKartu;
                                            $data['data']['tanggalLahir'] = $tglLahir;
                                            $data['data']['tanggalPelayanan'] = $tglPelayanan;
                                            $data['data']['noRujukan'] = $noRujukan;
                                            $data['data']['kodeJenisKelamin'] = $jenisKelamin;
                                            if (strtoupper($jenisKelamin) == 'L') {
                                                $data['data']['jenisKelamin'] = 'Laki-laki';
                                            } else {
                                                $data['data']['jenisKelamin'] = 'Perempuan';
                                            }
                                            $data['data']['kodePelayanan'] = $pelayanan;
                                            if (intval($pelayanan) == 2) {
                                                $data['data']['jenisPelayanan'] = 'Rawat Jalan';
                                            } else {
                                                $data['data']['jenisPelayanan'] = 'Rawat Inap';
                                            }
                                        } else {
                                            if (!empty($response->metaData)) {
                                                $data['message'] = 'No SEP tidak ditemukan';
                                            } else {
                                                $data['message'] = 'Alamat service tidak ditemukan. Hubungi Administrator';
                                            }
                                        }
                                    } else {
                                        $data['message'] = 'No SEP tidak ditemukan';
                                    }
                                } else {
                                    $data['message'] = 'Tidak ada respons dari service BPJS. Hubungi Administrator';
                                }
                            } else {
                                $data['message'] = 'No SEP salah';
                            }
                        } else {
                            $data['message'] = 'Respons dari service BPJS tidak sesuai format. Hubungi Administrator';
                        }
                    } catch (Exception $exc) {
                        $data['report'] .= $exc->getMessage();
                        $data['report'] .= $exc->getTraceAsString();
                        $data['message'] = 'Tidak terhubung dengan service BPSJ. Hubungi Administrator';
                    }
                } else {
                    $data['message'] = 'Setting service salah. Hubungi Administrator';
                }
            } else {
                $data['message'] = 'Belum ada setting service. Hubungi Administrator';
            }
        } else {
            $data['message'] = 'No SEP kosong';
        }
        return $data;
    }

    /*
     * cek koneksi alamat url
     */

    function pingAddres($url) {
        $response = @get_headers($url);
        if (!empty($response)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * proses simpan data perkiraan inacbg
     */

    public function prosesSimpanPerkiraanInacbg() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'dataPerkiraanInacbg' => NULL
        );
        if (!empty($_POST['noReg'])) {
            $idKunj = $_POST['idKunj'];
            $noReg = $_POST['noReg'];
            $noRm = $_POST['noRm'];
            $noPenjaminan = $_POST['noPenjaminan'];
            $kodeGrouper = $_POST['kodeGrouper'];
            $tarif = $_POST['tarif'];
            $arrPerkiraan = array(
                'TRANS_KUNJ_PAS_TKPAS_ID' => $idKunj,
                'TKPINACBG_NOREG' => $noReg,
                'TKPINACBG_NOMR' => $noRm,
                'TKPINACBG_NO_PENJAMINAN' => $noPenjaminan,
                'TKPINACBG_KODE_GROUPER' => $kodeGrouper,
                'TKPINACBG_TARIF_INACBG' => $tarif,
                'TKPINACBG_USERUPDATE' => $this->session->userdata('userid')
            );
            if ($this->input_diagnosa_jmn_model->simpanPerkiraanInacbg($arrPerkiraan) == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses simpan perkiraan inacbg berhasil';
                $dataPerkiraan = $this->input_diagnosa_jmn_model->dataPerkiraanInacbg($idKunj);
                if ($dataPerkiraan != NULL) {
                    $data['dataPerkiraanInacbg']['NO_PENJAMINAN'] = $dataPerkiraan->NO_PENJAMINAN;
                    $data['dataPerkiraanInacbg']['KODE_GROUPER'] = $dataPerkiraan->KODE_GROUPER;
                    $data['dataPerkiraanInacbg']['TARIF'] = number_format($dataPerkiraan->TARIF);
                    $data['dataPerkiraanInacbg']['DESC_GROUPER'] = $dataPerkiraan->DESC_GROUPER;
                }
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Proses simpan perkiraan inacbg gagal';
            }
        } else {
            $data['message'] = 'Identitas data tidak lengkap';
        }
        echo json_encode($data);
    }

    /*
     * proses kirim data inacbg
     */

    public function prosesKirimInacbg() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'message_report' => NULL,
            'report' => NULL,
            'valid' => TRUE,
            'message_valid' => NULL
        );
        if (!empty($_POST['noReg'])) {
            $noReg = $_POST['noReg'];
            $result = $this->input_diagnosa_jmn_model->kirimInacbg($noReg);
            if ($result['valid'] == TRUE) {
                $data['valid'] = TRUE;
                if ($result['status'] == TRUE) {
                    $data['status'] = TRUE;
                    $data['message'] = 'Proses kirim inacbg berhasil';
                    $data['report'] = $result['report'];
                    $data['message_report'] = $result['message'];
                } else {
                    $data['status'] = FALSE;
                    $data['message'] = 'Proses kirim inacbg gagal. ' . $result['message'];
                    $data['report'] = $result['report'];
                    $data['message_report'] = $result['message'];
                }
            } else {
                $data['status'] = FALSE;
                $data['valid'] = FALSE;
                $data['message_valid'] = $result['valid_message'];
            }
        } else {
            $data['message'] = 'No Registrasi kosong';
        }
        echo json_encode($data);
    }

    /*
     * mangambil status final kirim data inacbg
     */

    public function cekStatusFinalInacbg() {
        $result = array(
            'statusFinalInacbg' => FALSE,
            'message' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            $idKunj = $_POST['idKunj'];
            if ($this->input_diagnosa_jmn_model->cekKoneksiServerInacbg() == TRUE) {
                $result['statusFinalInacbg'] = $this->input_diagnosa_jmn_model->statusFinalInacbg($idKunj);
            } else {
                $result['message'] = 'Tidak dapat terhubung ke server inacbg';
            }
        } else {
            $result['message'] = 'Identitas kunjungan kosong';
        }
        echo json_encode($result);
    }

    /*
     * proses pencarian pasien
     */

    public function prosesCariPasien() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        $isValid = TRUE;
        $pilihTgl = '';
        if (!empty($_POST['cek_tgl_reg'])) {
            $pilihTgl = $_POST['cek_tgl_reg'];
        }
        $pilihPelayanan = '';
        if (!empty($_POST['cek_jenis_pelayanan'])) {
            $pilihPelayanan = $_POST['cek_jenis_pelayanan'];
        }

        $pilihRm = '';
        if (!empty($_POST['cek_no_rm'])) {
            $pilihRm = $_POST['cek_no_rm'];
        }
        $noRm = $_POST['cari_no_rm'];
        $pilihNama = '';
        if (!empty($_POST['cek_nama'])) {
            $pilihNama = $_POST['cek_nama'];
        }
        $nama = $_POST['cari_nama'];
        $pilihNoReg = '';
        if (!empty($_POST['cek_no_reg'])) {
            $pilihNoReg = $_POST['cek_no_reg'];
        }
        $noReg = $_POST['cari_no_reg'];
        if (!empty($pilihRm) || !empty($pilihNama) || !empty($pilihNoReg)) {
            if (!empty($pilihRm)) {
                if (empty($noRm)) {
                    $isValid = FALSE;
                    $data['message'] = 'No Rm tidak boleh kosong jika dipilih';
                }
            } else if (!empty($pilihNoReg)) {
                if (empty($noReg)) {
                    $isValid = FALSE;
                    $data['message'] = 'No Registrasi tidak boleh kosong jika dipilih';
                }
            } else {
                if (!empty($pilihNama)) {
                    if (empty($nama)) {
                        $isValid = FALSE;
                        $data['message'] = 'Nama tidak boleh kosong jika dipilih';
                    } else {
                        if (strlen($nama) < 3) {
                            $isValid = FALSE;
                            $data['message'] = 'Nama harus lebih dari 3 karakter';
                        }
                    }
                }
            }
        } else {
            if (empty($pilihTgl) || empty($pilihPelayanan)) {
                $isValid = FALSE;
                $data['message'] = 'Harus pilih tanggal dan jenis pelayanan';
            }
        }
        if ($isValid == TRUE) {
            $result = $this->input_diagnosa_jmn_model->cariPasien($_POST);
            if ($result != NULL) {
                $data['data'] = $result;
            } else {
                $data['message'] = 'Tidak ada data pasien ditemukan';
            }
        }
        echo json_encode($data);
    }

    /*
     * pross pencarian pasien dengan manual post
     */

    public function prosesCariPasienVersiPost() {
        $data = array();
        $data['pencarian']['isCari'] = 0; //status pencarian dari view
        $data['pencarian']['data'] = NULL;
        $data['pencarian']['message'] = NULL;
        $cekTgl = FALSE;
        if (!empty($_POST['cek_tgl_reg'])) {
            $cekTgl = TRUE;
        }
        $cekTglKeluar = FALSE;
        if (!empty($_POST['cek_tgl_keluar'])) {
            $cekTglKeluar = TRUE;
        }
        $cekNoReg = FALSE;
        if (!empty($_POST['cek_no_reg'])) {
            $cekNoReg = TRUE;
        }
        $cekNoRM = FALSE;
        if (!empty($_POST['cek_no_rm'])) {
            $cekNoRM = TRUE;
        }
        $cekNama = FALSE;
        if (!empty($_POST['cek_nama'])) {
            $cekNama = TRUE;
        }
        $cekCaraBayar = FALSE;
        if (!empty($_POST['cek_cara_bayar'])) {
            $cekCaraBayar = TRUE;
        }
        $cekDirawat = FALSE;
        if (!empty($_POST['cek_dirawat'])) {
            $cekDirawat = TRUE;
        }
        $cekStopTglAkhir = FALSE;
        if (!empty($_POST['cek_stop_tanggal_akhir'])) {
            $cekStopTglAkhir = TRUE;
        }
        $cekKeluar = FALSE;
        if (!empty($_POST['cek_keluar'])) {
            $cekKeluar = TRUE;
        }
        $cekLunas = FALSE;
        if (!empty($_POST['cek_lunas'])) {
            $cekLunas = TRUE;
        }
        $cekJenisPelayanan = FALSE;
        if (!empty($_POST['cek_jenis_pelayanan'])) {
            $cekJenisPelayanan = TRUE;
        }
        $cekPoliklinik = FALSE;
        if (!empty($_POST['cek_poliklinik'])) {
            $cekPoliklinik = TRUE;
        }
        $cekSubPoliklinik = FALSE;
        if (!empty($_POST['cek_sub_poliklinik'])) {
            $cekSubPoliklinik = TRUE;
        }
        //cek validasi minimal inputan
        $isValid = TRUE;
        $noRm = !empty($_POST['cari_no_rm']) ? $_POST['cari_no_rm'] : '';
        $nama = !empty($_POST['cari_nama']) ? $_POST['cari_nama'] : '';
        $noReg = !empty($_POST['cari_no_reg']) ? $_POST['cari_no_reg'] : '';

        if (!empty($cekNoRM) || !empty($cekNama) || !empty($cekNoReg)) {
            if (!empty($cekNoRM)) {
                if (empty($noRm)) {
                    $isValid = FALSE;
                    $data['pencarian']['message'] = 'No Rm tidak boleh kosong jika dipilih';
                    $data['pencarian']['isCari'] = 1;
                }
            } else if (!empty($cekNoReg)) {
                if (empty($noReg)) {
                    $isValid = FALSE;
                    $data['pencarian']['message'] = 'No Registrasi tidak boleh kosong jika dipilih';
                    $data['pencarian']['isCari'] = 1;
                }
            } else {
                if (!empty($cekNama)) {
                    if (empty($nama)) {
                        $isValid = FALSE;
                        $data['pencarian']['message'] = 'Nama tidak boleh kosong jika dipilih';
                        $data['pencarian']['isCari'] = 1;
                    } else {
                        if (strlen($nama) < 3) {
                            $isValid = FALSE;
                            $data['pencarian']['message'] = 'Nama harus lebih dari 3 karakter';
                            $data['pencarian']['isCari'] = 1;
                        }
                    }
                }
            }
        } else {
            if (empty($cekTgl) || empty($cekJenisPelayanan)) {
                $isValid = FALSE;
                $data['pencarian']['message'] = 'Harus pilih tanggal dan jenis pelayanan';
                $data['pencarian']['isCari'] = 1;
            }
        }
        if ($isValid == TRUE) {
            $result = $this->input_diagnosa_jmn_model->cariPasien($_POST);
            if ($result != NULL) {
                $data['pencarian']['data'] = $result;
            } else {
                $data['pencarian']['isCari'] = 1;
                $data['pencarian']['message'] = 'Tidak ada data pasien ditemukan';
            }
        }
        $data['pencarian']['defaultCekTgl'] = $cekTgl;
        $data['pencarian']['defaultCekTglKeluar'] = $cekTglKeluar;
        $data['pencarian']['defaultCekNoReg'] = $cekNoReg;
        $data['pencarian']['defaultCekNoRm'] = $cekNoRM;
        $data['pencarian']['defaultCekNama'] = $cekNama;
        $data['pencarian']['defaultCekCaraBayar'] = $cekCaraBayar;
        $data['pencarian']['defaultCekDirawat'] = $cekDirawat;
        $data['pencarian']['defaultCekStopTglAkhir'] = $cekStopTglAkhir;
        $data['pencarian']['defaultCekKeluar'] = $cekKeluar;
        $data['pencarian']['defaultCekLunas'] = $cekLunas;
        $data['pencarian']['defaultCekPelayanan'] = $cekJenisPelayanan;
        $data['pencarian']['defaultCekPoliklinik'] = $cekPoliklinik;
        $data['pencarian']['defaultCekSubPoliklinik'] = $cekSubPoliklinik;

        $kodePelayanan = !empty($_POST['cari_kode_jenis_pelayanan']) ? $_POST['cari_kode_jenis_pelayanan'] : '';
        $kodePoliklinik = !empty($_POST['kode_poliklinik']) ? $_POST['kode_poliklinik'] : '';
        $kodeSubPoliklinik = !empty($_POST['kode_sub_poliklinik']) ? $_POST['kode_sub_poliklinik'] : '';

        $data['pencarian']['defaultTgl'] = !empty($_POST['cari_tgl_reg_awal']) ? $_POST['cari_tgl_reg_awal'] : tglsekarang();
        $data['pencarian']['defaultTglKeluar'] = !empty($_POST['cari_tgl_keluar_awal']) ? $_POST['cari_tgl_keluar_awal'] : tglsekarang();
        $data['pencarian']['defaultNoReg'] = !empty($_POST['cari_no_reg']) ? $_POST['cari_no_reg'] : '';
        $data['pencarian']['defaultNoRm'] = !empty($_POST['cari_no_rm']) ? $_POST['cari_no_rm'] : '';
        $data['pencarian']['defaultNama'] = !empty($_POST['cari_nama']) ? $_POST['cari_nama'] : '';
        $data['pencarian']['defaultCaraBayar'] = !empty($_POST['kode_cara_bayar']) ? $_POST['kode_cara_bayar'] : '';
        $data['pencarian']['defaultPelayanan'] = $kodePelayanan;
        $data['pencarian']['defaultPoliklinik'] = $kodePoliklinik;
        $data['pencarian']['defaultSubPoliklinik'] = $kodeSubPoliklinik;

        //data poliklinik
        $dataPelayanan = $this->input_diagnosa_jmn_model->getJenisPelayanaRekamMedis();
        $data['optionsPelayanan'][''] = 'Semua';
        if ($dataPelayanan) {
            foreach ($dataPelayanan as $row) {
                $data['optionsPelayanan'][$row->MINS_KODE] = $row->MINS_NAMA;
            }
        }

        //data poliklinik
        $data['optionsPoliklinik'][''] = 'Semua';
        if (!empty($kodePelayanan)) {
            $dataPoliklinik = $this->ambulan_model->getPoliklinikByJenisPelayanan($kodePelayanan, '');
            if ($dataPoliklinik) {
                foreach ($dataPoliklinik as $row) {
                    $data['optionsPoliklinik'][$row->MINS_KODE] = $row->MINS_NAMA;
                }
            }
        }
        //data detail poliklinik
        $data['optionsDetailPoliklinik'][''] = 'Semua';
        if (!empty($kodePoliklinik)) {
            $dataDetailPoliklinik = $this->ambulan_model->getSubPoliklinikByPoliklinik($kodePoliklinik, '');
            if ($dataDetailPoliklinik) {
                foreach ($dataDetailPoliklinik as $row) {
                    $data['optionsDetailPoliklinik'][$row->MINS_KODE] = $row->MINS_NAMA;
                }
            }
        }
        $this->menu['active'] = 3;
        $this->render('emr/view_input_icd_jmn', $data, $this->menu, FALSE);
    }

    /*
     * cek status koneksi server  
     */

    public function cekStatusKoneksi() {
        $data = array(
            'status' => FALSE,
            'message' => NULL
        );
        if ($this->input_diagnosa_jmn_model->cekKoneksiServerInacbg() == TRUE) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        echo json_encode($data);
    }

    /*
     * cek status koneksi server  test
     */

    public function cekStatusKoneksiServerTest() {
        $data = array(
            'status' => FALSE,
            'message' => NULL
        );
        if ($this->input_diagnosa_jmn_model->cekKoneksiServerInacbgTest() == TRUE) {
            $data['status'] = TRUE;
        } else {
            $data['status'] = FALSE;
        }
        echo json_encode($data);
    }

    /*
     * cek kode icd10 dalam setting mst icd10 
     */

    public function cekIcd10ByMapJenisDiag() {
        $data = array(
            'status' => FALSE,
            'message' => NULL
        );
        if (!empty($_POST['icd10']) && !empty($_POST['jenisDiagnosa'])) {
            if ($this->input_diagnosa_jmn_model->cekIcd10ByMapJenisDiagnosa($_POST['icd10'], $_POST['jenisDiagnosa']) == TRUE) {
                $data['status'] = TRUE;
            } else {
                $data['status'] = FALSE;
            }
        } else {
            $data['message'] = 'code icd10 dan jenis diagnosa harus dikirim';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data informasi SEP
     */

    public function cekSEPOnline() {
        $data = array(
            'data' => NULL,
            'dataLocal' => NULL,
            'dataTarifRS' => NULL,
            'message' => NULL,
            'report' => '',
            'status' => FALSE
        );
        if (!empty($_POST['noSEP']) && !empty($_POST['noReg'])) {
            $noSep = $_POST['noSEP'];
            $noReg = !empty($_POST['noReg']) ? $_POST['noReg'] : '';
            $strValidSep = preg_replace('/[^\da-z]/i', '', $noSep); /* harus ada angka atau karakter a-z */
            if (!empty($strValidSep)) {
                $dataNoregVerif = $this->input_diagnosa_jmn_model->dataVerifNoregBySepNoreg($noSep, $noReg);
                if ($dataNoregVerif == NULL) {
                    $data['status'] = TRUE;
                    if ($this->input_diagnosa_jmn_model->isBridgingSepByNoReg($noReg) == 1) {
                        $response = $this->getDataSEPOnLine($noSep);
                        $data['data'] = $response['data'];
                        $data['message'] = $response['message'];
                        $data['report'] = $response['report'];
                    }
                    if (!empty($noReg)) {
                        $dataLocal = $this->input_diagnosa_jmn_model->infoSepKunjunganByNoreg($noReg);
                        if ($dataLocal != NULL) {
                            $data['dataLocal'] = $dataLocal;
                        }
                    }
                    if (substr($noReg, 0, 2) == '01') {
                        /*
                         * hitung ulang no reg yang sep nya sama dan irj
                         */
                        $dataReg = $this->input_diagnosa_jmn_model->noRegBySep($noSep, $noReg);
                        if ($dataReg != NULL) {
                            foreach ($dataReg as $row) {
                                $noRegLoop = $row->NO_REG;
                                if (substr($noRegLoop, 0, 2) == '01') {
                                    $this->hitungTotalTagihan($noRegLoop);
                                }
                            }
                        } else {
                            $this->hitungTotalTagihan($noReg);
                        }
                        $data['dataTarifRS'] = $this->input_diagnosa_jmn_model->dataTarifRsByNoSep($noSep, $noReg);
                    }
                } else {
                    $stringNoregVerif = '';
                    foreach ($dataNoregVerif as $row) {
                        if (empty($stringNoregVerif)) {
                            $stringNoregVerif .= $row->NO_REG;
                        } else {
                            $stringNoregVerif .= ', ' . $row->NO_REG;
                        }
                    }
                    $data['message'] = 'No SEP (' . $noSep . ') sudah  dilakukan verifikasi dengan no registrasi ' . $stringNoregVerif;
                }
            } else {
                $data['message'] = 'No SEP tidak sesuai format';
            }
        } else {
            $data['message'] = 'No SEP kosong';
        }
        echo json_encode($data);
    }

    /*
     * proses cetak tarif rs by no sep
     */

    public function pdf_tarif_rs_by_no_sep($noSep = '', $noReg = '') {
        $this->load->library('Pdf');
        if (!empty($noSep)) {
            $noSep = str_replace('%20', ' ', $noSep); /* antisipasi karena ada beberapa sep yang ada spacinya diawal no sep */
            if (substr($noReg, 0, 2) == '01') {
                $response = $this->getDataSEPOnLine($noSep);
                $dataSimrs = NULL;
                $dataLocal = $this->input_diagnosa_jmn_model->infoSepKunjunganByNoreg($noReg);
                if ($dataLocal != NULL) {
                    $dataSimrs['namaPasien'] = $dataLocal->NAMA_PASIEN_LOCAL;
                    $dataSimrs['noRm'] = $dataLocal->NO_RM_LOCAL;
                    $dataSimrs['tanggalLahir'] = $dataLocal->TGL_LAHIR_LOCAL;
                    $dataSimrs['jenisKelamin'] = $dataLocal->JENIS_KELAMIN_LOCAL;
                    $dataSimrs['noSep'] = $noSep;
                }
                $dataTarif = $this->input_diagnosa_jmn_model->dataTarifRsByNoSep($noSep, $noReg);

                $data = array();
                $header = '';
                $kota = "Yogyakarta, ";
                $infoRS = $this->input_diagnosa_jmn_model->dataInfoRS();
                if ($infoRS != NULL) {
                    $header .= $infoRS->MRS_NAMA . "\n";
                    $header .= $infoRS->MRS_ALAMAT . "\n";
                    $header .= "Telp. " . $infoRS->MRS_TELP1 . "\n";
                    $header .= "Faks. " . $infoRS->MRS_FAX1;
                    $kota = $infoRS->MRS_KOTA;
                } else {
                    $header .= "RUMAH SAKIT DR. SARDJITO\n";
                    $header .= "Jl. Kesehatan No. 1, Sekip - Yogyakarta<\n";
                    $header .= "Telp. (0274) 587333\n";
                    $header .= "Faks. (0274) 589309";
                    $kota = "Yogyakarta, ";
                }

                $data['header'] = $header;
                $data['title'] = 'INFORMASI TARIF RUMAH SAKIT';
                $data['tanggalTtd'] = $kota . ', ' . dateIndonesiaLable(date("d-m-Y"));
                $data['namaTtd'] = $this->session->userdata('fullname');
                $data['dataSep'] = $response['data'];
                $data['dataSimrs'] = $dataSimrs;
                $data['dataTarifRS'] = $dataTarif;

                $this->load->view('emr/view_cetak_tarif_rs_sep_pdf', $data);
            } else {
                echo 'Bukan registrasi IRJ';
            }
        } else {
            echo 'No SEP kosong';
        }
    }

    /*
     * menghitung total tagihan
     */

    function hitungTotalTagihan($noReg) {
        $params = array(
            ':pNoReg' => $noReg
        );
        $procedureName = "PACK_PERHITUNGAN_TOTAL.P_GET_TARIF_RS";
        $this->input_diagnosa_jmn_model->pReportProcedure($procedureName, $params);
    }

    /*
     * mengambil data informasi SEP Auto call
     */

    public function cekSEPOnlineAuto() {
        $data = array(
            'data' => NULL,
            'dataLocal' => NULL,
            'message' => NULL,
            'report' => '',
            'isDataSepBpjs' => 0
        );
        if (!empty($_POST['noSEP']) && !empty($_POST['noReg'])) {
            $noSep = $_POST['noSEP'];
            $noReg = !empty($_POST['noReg']) ? $_POST['noReg'] : '';
            $strValidSep = preg_replace('/[^\da-z]/i', '', $noSep); /* harus ada angka atau karakter a-z */
            if (!empty($strValidSep)) {
                $dataNoregVerif = $this->input_diagnosa_jmn_model->dataVerifNoregBySepNoreg($noSep, $noReg);
                if ($dataNoregVerif == NULL) {
                    $data['status'] = TRUE;
                    $dataLocal = $this->input_diagnosa_jmn_model->infoSepKunjunganByNoreg($noReg);
                    if ($dataLocal != NULL) {
                        $data['dataLocal'] = $dataLocal;
                    }
                    //ambil data Sep di cara bayar
                    $isBridging = '0';
                    $dataSep = $this->input_diagnosa_jmn_model->infoSEPCaraBayarByNoreg($noReg);
                    if ($dataSep != NULL) {
                        $data['data']['namaPasien'] = $dataSep->NAMA_PASIEN;
                        $data['data']['noRm'] = $dataSep->NO_RM;
                        $data['data']['tanggalLahir'] = $dataSep->TGL_LAHIR;
                        $data['data']['jenisKelamin'] = $dataSep->JENIS_KELAMIN;
                        $data['data']['kodeJenisKelamin'] = $dataSep->KODE_JENIS_KELAMIN;
                        $isBridging = $dataSep->IS_BRIDGING;
                    }
                    if (empty($data['data']['namaPasien']) || $isBridging == '0') {
                        if (!empty($noSep)) {
                            $response = $this->getDataSEPOnLine($noSep);
                            $data['data'] = $response['data'];
                            $data['message'] = $response['message'];
                            $data['report'] = $response['report'];
                            $data['isDataSepBpjs'] = 1;
                        } else {
                            $data['message'] = 'No SEP kosong';
                        }
                    }
                } else {
                    $stringNoregVerif = '';
                    foreach ($dataNoregVerif as $row) {
                        if (empty($stringNoregVerif)) {
                            $stringNoregVerif .= $row->NO_REG;
                        } else {
                            $stringNoregVerif .= ', ' . $row->NO_REG;
                        }
                    }
                    $data['message'] = 'No SEP (' . $noSep . ') sudah  dilakukan verifikasi dengan no registrasi ' . $stringNoregVerif;
                }
            } else {
                $data['message'] = 'No SEP tidak sesuai format';
            }
        } else {
            $data['message'] = 'No SEP tidak boleh kosong';
        }
        echo json_encode($data);
    }

    /*
     * informasi icd9
     */

    function getIcd9Info() {
        if (!empty($_POST['icd9'])) {
            $icd9 = $_POST['icd9'];
            $data = $this->input_diagnosa_jmn_model->loadIcd9Info($icd9);
            if ($data != NULL) {
                echo $data->ICD9CM_KETERANGAN;
            } else {
                echo NULL;
            }
        } else {
            echo NULL;
        }
    }

    /*
     * mengambalikan arra option yang sesuai dengan diagnosa
     * pengembalian berupa array
     */

    function generateArrOptionsRefCMG($dataRef, $dataDiagnosa, $dataTindakan) {
        $arrOptionRef = array();
        if ($dataRef != NULL) {
            foreach ($dataRef as $row) {//perulangan sebanyak ref yang ditemukan
                //data diagnosa
                $arrStringDiagnosa = array();
                if ($row->KODE_DIAGNOSA != NULL) {
                    $arrStringDiagnosa = explode(';', $row->KODE_DIAGNOSA); //proses pemisahan ldelimiter
                }
                $arrKetemuDiagnosa = array();
                $i = 0;
                while ($i < count($arrStringDiagnosa)) {//perulangan sebanyak
                    if ($dataDiagnosa != NULL) {
                        $r = 0;
                        while ($r < count($dataDiagnosa)) {//perulangan sebanyak data diagnosa
                            if (strtoupper(trim($arrStringDiagnosa[$i])) == strtoupper(trim($dataDiagnosa[$r]['KODE_ICD10_INACBG']))) {
                                $arrKetemuDiagnosa[] = $dataDiagnosa[$r]['KODE_ICD10']; //catat icd10
                            }
                            $r++;
                        }
                    }
                    $i++;
                }
                //data tindakan
                $arrStringTindakan = array();
                if ($row->KODE_TINDAKAN != NULL) {
                    $arrStringTindakan = explode(';', $row->KODE_TINDAKAN); //proses pemisahan delimiter
                }
                $arrKetemuTindakan = array();
                $j = 0;
                while ($j < count($arrStringTindakan)) {//perulangan sebanyak array string
                    if ($dataDiagnosa != NULL) {
                        $n = 0;
                        while ($n < count($dataTindakan)) {//perulangan sebanyak tindakan
                            if (strtoupper(trim($arrStringTindakan[$j])) == strtoupper(trim($dataTindakan[$n]['KODE_ICD9_INACBG']))) {
                                $arrKetemuTindakan[] = $dataTindakan[$n]['KODE_ICD9']; //catat icd9
                            }
                            $n++;
                        }
                    }
                    $j++;
                }
                //cek ketemu diagnosa atau tindakan
                if ((count($arrKetemuDiagnosa) > 0) || (count($arrStringTindakan) > 0)) {
                    $stringIcd9 = implode(';', $arrKetemuTindakan);
                    $stringIcd10 = implode(';', $arrKetemuDiagnosa);
                    $arrOptionRef[] = array(
                        'KODE' => $row->KODE,
                        'NAMA' => $row->NAMA,
                        'KODE_INACBG' => $row->KODE_INACDG,
                        'KODE_ICD9' => $stringIcd9,
                        'KODE_ICD10' => $stringIcd10
                    );
                }
            }
        }
        if (!empty($arrOptionRef)) {
            $arrOptionRef[] = array(
                'KODE' => '',
                'NAMA' => '-',
                'KODE_INACBG' => '',
                'KODE_ICD9' => '',
                'KODE_ICD10' => ''
            );
        }
        return $arrOptionRef;
    }

    /*
     * mengambil data input cmg 
     */

    function dataInputCMGbyIdkunj() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            $idKunj = $_POST['idKunj'];
            //data diagnosa
            $dataDiagnosa = $this->input_diagnosa_jmn_model->dataDiagnosaPasienInacbgByIdkunj($idKunj);
            //data tindakan
            $dataTindakan = $this->input_diagnosa_jmn_model->dataTindakanPasienInacbgByIdkunj($idKunj);
            //option ref drugs
            $dataRefDrugs = $this->input_diagnosa_jmn_model->dataRefDrugsCMGByIdKunj($idKunj);
            $arrOptionRefDrugs = $this->generateArrOptionsRefCMG($dataRefDrugs, $dataDiagnosa, $dataTindakan);
            //option ref Investigasi
            $dataRefInvestigasi = $this->input_diagnosa_jmn_model->dataRefInvestigasiCMGByIdKunj($idKunj);
            $arrOptionRefInvestigasi = $this->generateArrOptionsRefCMG($dataRefInvestigasi, $dataDiagnosa, $dataTindakan);
            //option ref Investigasi
            $dataRefProc = $this->input_diagnosa_jmn_model->dataRefProcCMGByIdKunj($idKunj);
            $arrOptionRefProc = $this->generateArrOptionsRefCMG($dataRefProc, $dataDiagnosa, $dataTindakan);
            //option ref Investigasi
            $dataRefProstesis = $this->input_diagnosa_jmn_model->dataRefProstesisCMGByIdKunj($idKunj);
            $arrOptionRefProstesis = $this->generateArrOptionsRefCMG($dataRefProstesis, $dataDiagnosa, $dataTindakan);

            $data['data']['optionsRefDrugs'] = $arrOptionRefDrugs;
            $data['data']['optionsRefInvestigasi'] = $arrOptionRefInvestigasi;
            $data['data']['optionsRefProc'] = $arrOptionRefProc;
            $data['data']['optionsRefProstesis'] = $arrOptionRefProstesis;
            //data input cmg
            $data['data']['CMG'] = $this->input_diagnosa_jmn_model->dataInputCMGByIdKunj($idKunj);
        } else {
            $data['message'] = 'Identitas Kunjungan kosong';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data input cmg  berdasarkan id kunjungan dan kode grouper
     */

    function dataInputCMGbyIdkunjAndGrouper() {
        $data = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            if (!empty($_POST['kodeGrouper'])) {
                $idKunj = $_POST['idKunj'];
                $kodeGrouper = $_POST['kodeGrouper'];
                //data diagnosa
                $dataDiagnosa = $this->input_diagnosa_jmn_model->dataDiagnosaPasienInacbgByIdkunj($idKunj);
                //data tindakan
                $dataTindakan = $this->input_diagnosa_jmn_model->dataTindakanPasienInacbgByIdkunj($idKunj);
                //option ref drugs
                $dataRefDrugs = $this->input_diagnosa_jmn_model->dataRefDrugsCMGByKodeGrouper($kodeGrouper);
                $arrOptionRefDrugs = $this->generateArrOptionsRefCMG($dataRefDrugs, $dataDiagnosa, $dataTindakan);
                //option ref Investigasi
                $dataRefInvestigasi = $this->input_diagnosa_jmn_model->dataRefInvestigasiCMGByKodeGrouper($kodeGrouper);
                $arrOptionRefInvestigasi = $this->generateArrOptionsRefCMG($dataRefInvestigasi, $dataDiagnosa, $dataTindakan);
                //option ref Investigasi
                $dataRefProc = $this->input_diagnosa_jmn_model->dataRefProcCMGByKodeGrouper($kodeGrouper);
                $arrOptionRefProc = $this->generateArrOptionsRefCMG($dataRefProc, $dataDiagnosa, $dataTindakan);
                //option ref Investigasi
                $dataRefProstesis = $this->input_diagnosa_jmn_model->dataRefProstesisCMGByKodeGrouper($kodeGrouper);
                $arrOptionRefProstesis = $this->generateArrOptionsRefCMG($dataRefProstesis, $dataDiagnosa, $dataTindakan);

                $data['data']['optionsRefDrugs'] = $arrOptionRefDrugs;
                $data['data']['optionsRefInvestigasi'] = $arrOptionRefInvestigasi;
                $data['data']['optionsRefProc'] = $arrOptionRefProc;
                $data['data']['optionsRefProstesis'] = $arrOptionRefProstesis;
                //data input cmg
                $data['data']['CMG'] = $this->input_diagnosa_jmn_model->dataInputCMGByIdKunj($idKunj);
            } else {
                $data['message'] = 'Kode Grouper kosong';
            }
        } else {
            $data['message'] = 'Identitas Kunjungan kosong';
        }
        echo json_encode($data);
    }

    /*
     * proses input data CMG
     */

    function prosesSimpanInputCMG() {
        $result = array(
            'status' => FALSE,
            'message' => NULL
        );
        if (!empty($_POST)) {
            $idTrans = $_POST['idTransInputCMG'];
            $idKunj = $_POST['idKunjInputCMG'];
            $noReg = $_POST['noRegInputCMG'];
            $noRm = $_POST['noRmInputCMG'];
            //procedure
            $refProce = NULL;
            if (!empty($_POST['refProcInputCMG'])) {
                $refProce = $_POST['refProcInputCMG'];
            }
            $icd9Proce = NULL;
            if (!empty($_POST['icd9ProcInputCMG'])) {
                $icd9Proce = $_POST['icd9ProcInputCMG'];
            }
            $icd10Proce = NULL;
            if (!empty($_POST['icd10ProcInputCMG'])) {
                $icd10Proce = $_POST['icd10ProcInputCMG'];
            }
            //drugs
            $refDrugs = NULL;
            if (!empty($_POST['refDrugsInputCMG'])) {
                $refDrugs = $_POST['refDrugsInputCMG'];
            }
            $icd9Drugs = NULL;
            if (!empty($_POST['icd9DrugsInputCMG'])) {
                $icd9Drugs = $_POST['icd9DrugsInputCMG'];
            }
            $icd10Drugs = NULL;
            if (!empty($_POST['icd10DrugsInputCMG'])) {
                $icd10Drugs = $_POST['icd10DrugsInputCMG'];
            }
            //investigasi
            $refInvestigasi = NULL;
            if (!empty($_POST['refInvestigasiInputCMG'])) {
                $refInvestigasi = $_POST['refInvestigasiInputCMG'];
            }
            $icd9Investigasi = NULL;
            if (!empty($_POST['1cd9InvestigasiInputCMG'])) {
                $icd9Investigasi = $_POST['1cd9InvestigasiInputCMG'];
            }
            $icd10Investigasi = NULL;
            if (!empty($_POST['1cd10InvestigasiInputCMG'])) {
                $icd10Investigasi = $_POST['1cd10InvestigasiInputCMG'];
            }
            //prosthesisi
            $refProst = NULL;
            if (!empty($_POST['refProstesisInputCMG'])) {
                $refProst = $_POST['refProstesisInputCMG'];
            }
            $icd9Prost = NULL;
            if (!empty($_POST['icd9ProstesisInputCMG'])) {
                $icd9Prost = $_POST['icd9ProstesisInputCMG'];
            }
            $icd10Prost = NULL;
            if (!empty($_POST['icd10ProstesisInputCMG'])) {
                $icd10Prost = $_POST['icd10ProstesisInputCMG'];
            }

            $newData = array(
                'TRANS_KUNJ_TKPAS_ID' => $idKunj,
                'TCMGPAS_NOREG' => $noReg,
                'TCMGPAS_NOMR' => $noRm,
                'REF_CMG_SPP_RCMGSPP_KODE' => $refProce,
                'MST_ICD9CM_MICD9CM_KODE_SPP' => $icd9Proce,
                'REF_CMG_SPD_RCMGSPD_KODE' => $refDrugs,
                'MST_BRG_MDS_MBMDS_KODE' => $icd9Drugs,
                'REF_CMG_SPI_RCMGSPI_KODE' => $refInvestigasi,
                'MST_ICD9CM_MICD9CM_KODE_SPI' => $icd9Investigasi,
                'REF_CMG_SPPR_RCMGSPPR_KODE' => $refProst,
                'MST_ICD9CM_MICD9CM_KODE_SPPR' => $icd9Prost,
                'TCMGPAS_ISBATAL' => '0',
                'MST_ICD10_MICD10_KODE_SPP' => $icd10Proce,
                'MST_ICD10_MICD10_KODE_SPD' => $icd10Drugs,
                'MST_ICD10_MICD10_KODE_SPI' => $icd10Investigasi,
                'MST_ICD10_MICD10_KODE_SPPR' => $icd10Prost
            );
            if ($this->input_diagnosa_jmn_model->simpanInputCMG($newData, $idTrans) == TRUE) {
                $result['status'] = TRUE;
                $result['message'] = 'Proses simpan berhasil';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Proses simpan gagal';
            }
        } else {
            $result['message'] = 'Identitas Kunjungan tidak lengkap';
        }
        echo json_encode($result);
    }

    /*
     * proses input data Auto CMG
     */

    function prosesSimpanAutoInputCMG() {
        $result = array(
            'status' => FALSE,
            'message' => NULL,
            'report' => NULL
        );
        if (!empty($_POST)) {
            $idTrans = $_POST['idTransAutoInputCMG'];
            $idKunj = $_POST['idKunjAutoInputCMG'];
            $noReg = $_POST['noRegAutoInputCMG'];
            $noRm = $_POST['noRmAutoInputCMG'];
            //procedure
            $refProce = NULL;
            if (!empty($_POST['refProcAutoInputCMG'])) {
                $refProce = $_POST['refProcAutoInputCMG'];
            }
            $icd9Proce = NULL;
            if (!empty($_POST['icd9ProcAutoInputCMG'])) {
                $icd9Proce = $_POST['icd9ProcAutoInputCMG'];
            }
            $icd10Proce = NULL;
            if (!empty($_POST['icd10ProcAutoInputCMG'])) {
                $icd10Proce = $_POST['icd10ProcAutoInputCMG'];
            }
            //drugs
            $refDrugs = NULL;
            if (!empty($_POST['refDrugsAutoInputCMG'])) {
                $refDrugs = $_POST['refDrugsAutoInputCMG'];
            }
            $icd9Drugs = NULL;
            if (!empty($_POST['icd9DrugsAutoInputCMG'])) {
                $icd9Drugs = $_POST['icd9DrugsAutoInputCMG'];
            }
            $icd10Drugs = NULL;
            if (!empty($_POST['icd10DrugsInputCMG'])) {
                $icd10Drugs = $_POST['icd10DrugsAutoInputCMG'];
            }
            //investigasi
            $refInvestigasi = NULL;
            if (!empty($_POST['refInvestigasiAutoInputCMG'])) {
                $refInvestigasi = $_POST['refInvestigasiAutoInputCMG'];
            }
            $icd9Investigasi = NULL;
            if (!empty($_POST['1cd9InvestigasiAutoInputCMG'])) {
                $icd9Investigasi = $_POST['1cd9InvestigasiAutoInputCMG'];
            }
            $icd10Investigasi = NULL;
            if (!empty($_POST['1cd10InvestigasiAutoInputCMG'])) {
                $icd10Investigasi = $_POST['1cd10InvestigasiAutoInputCMG'];
            }
            //prosthesisi
            $refProst = NULL;
            if (!empty($_POST['refProstesisAutoInputCMG'])) {
                $refProst = $_POST['refProstesisAutoInputCMG'];
            }
            $icd9Prost = NULL;
            if (!empty($_POST['icd9ProstesisAutoInputCMG'])) {
                $icd9Prost = $_POST['icd9ProstesisAutoInputCMG'];
            }
            $icd10Prost = NULL;
            if (!empty($_POST['icd10ProstesisAutoInputCMG'])) {
                $icd10Prost = $_POST['icd10ProstesisAutoInputCMG'];
            }

            $isServerAsli = 0;
            if (!empty($_POST['isServerAsliAutoInputCMG'])) {
                $isServerAsli = intval($_POST['isServerAsliAutoInputCMG']);
            }

            $newData = array(
                'TRANS_KUNJ_TKPAS_ID' => $idKunj,
                'TCMGPAS_NOREG' => $noReg,
                'TCMGPAS_NOMR' => $noRm,
                'REF_CMG_SPP_RCMGSPP_KODE' => $refProce,
                'MST_ICD9CM_MICD9CM_KODE_SPP' => $icd9Proce,
                'REF_CMG_SPD_RCMGSPD_KODE' => $refDrugs,
                'MST_BRG_MDS_MBMDS_KODE' => $icd9Drugs,
                'REF_CMG_SPI_RCMGSPI_KODE' => $refInvestigasi,
                'MST_ICD9CM_MICD9CM_KODE_SPI' => $icd9Investigasi,
                'REF_CMG_SPPR_RCMGSPPR_KODE' => $refProst,
                'MST_ICD9CM_MICD9CM_KODE_SPPR' => $icd9Prost,
                'TCMGPAS_ISBATAL' => '0',
                'MST_ICD10_MICD10_KODE_SPP' => $icd10Proce,
                'MST_ICD10_MICD10_KODE_SPD' => $icd10Drugs,
                'MST_ICD10_MICD10_KODE_SPI' => $icd10Investigasi,
                'MST_ICD10_MICD10_KODE_SPPR' => $icd10Prost
            );
            if ($isServerAsli == 1) {//simpan server simrs 
                if ($this->input_diagnosa_jmn_model->simpanInputCMG($newData, $idTrans) == TRUE) {
                    //set data special groups dan update no Reg
                    $kirim = $this->input_diagnosa_jmn_model->addSpecialGrouperAndUpdateNoReg($idKunj, $noReg, $noRm, $isServerAsli);
                    if ($kirim['status'] == TRUE) {
                        $result['status'] = TRUE;
                        $result['message'] = 'Proses simpan berhasil';
                        $result['report_message'] = $kirim['message'];
                        $result['report'] = $kirim['report'];
                    } else {
                        $result['status'] = FALSE;
                        $result['message'] = 'Proses simpan gagal saat update data inacbg';
                        $result['report_message'] = $kirim['message'];
                        $result['report'] = $kirim['report'];
                    }
                } else {
                    $result['status'] = FALSE;
                    $result['message'] = 'Proses simpan gagal';
                }
            } else {//tidak simpan server simrs
                //set data special groups dan update no Reg
                $kirim = $this->input_diagnosa_jmn_model->addSpecialGrouperAndUpdateNoReg($idKunj, $noReg, $noRm, $isServerAsli);
                if ($kirim['status'] == TRUE) {
                    $result['status'] = TRUE;
                    $result['message'] = 'Proses simpan berhasil';
                    $result['report_message'] = $kirim['message'];
                    $result['report'] = $kirim['report'];
                } else {
                    $result['status'] = FALSE;
                    $result['message'] = 'Proses simpan gagal saat update data inacbg';
                    $result['report_message'] = $kirim['message'];
                    $result['report'] = $kirim['report'];
                }
            }
        } else {
            $result['message'] = 'Identitas Kunjungan tidak lengkap';
        }
        echo json_encode($result);
    }

    /*
     * proses batal input cmg
     */

    function prosesBatalInputCMG() {
        $result = array(
            'status' => FALSE,
            'message' => NULL
        );
        if (!empty($_POST['idTransBatalCMG']) && !empty($_POST['idKunjBatalCMG']) && !empty($_POST['alasanBatalCMG'])) {
            $idTrans = $_POST['idTransBatalCMG'];
            $idKunj = $_POST['idKunjBatalCMG'];
            $alasan = $_POST['alasanBatalCMG'];
            $keterangan = $_POST['keteranganBatalCMG'];
            $dataBatal = array(
                'TCMGPAS_ID' => $idTrans,
                'TRANS_KUNJ_TKPAS_ID' => $idKunj,
                'TCMGPAS_ISBATAL' => '1',
                'REF_ALASAN_RALS_KODE' => $alasan,
                'TCMGPAS_KET_BATAL' => $keterangan,
                'TCMGPAS_USERBATAL' => $this->session->userdata('userid')
            );
            if ($this->input_diagnosa_jmn_model->batalInputCMG($dataBatal) == TRUE) {
                $result['status'] = TRUE;
                $result['message'] = 'Proses batal berhasil';
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Proses batal gagal';
            }
        } else {
            $result['message'] = 'Identitas Kunjungan tidak lengkap';
        }
        echo json_encode($result);
    }

    /*
     * proses insert trans kirim inacbg
     */

    public function prosesCreateTransKirimInacbg() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'report' => NULL,
        );
        if (!empty($_POST['noReg'])) {
            $noReg = $_POST['noReg'];
            $result = $this->input_diagnosa_jmn_model->simpanProsesKirimInacbg($noReg);
            if ($result['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses kirim inacbg berhasil';
                $data['report'] = $result['report'];
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Proses kirim inacbg gagal';
                $data['report'] = $result['report'];
            }
        } else {
            $data['message'] = 'No Registrasi kosong';
        }
        echo json_encode($data);
    }

    /*
     * proses download data hasil inacbg
     */

    function prosesDownLoadHasilInacbg() {
        $data = array(
            'status' => FALSE,
            'message' => NULL,
            'report' => NULL,
        );
        if (!empty($_POST['noReg'])) {
            $noReg = $_POST['noReg'];
            $idKunj = $_POST['idKunj'];
            $noRm = $_POST['noRm'];
            $result = $this->input_diagnosa_jmn_model->downloadHasilInacbgByNoReg($noRm, $noReg, $idKunj);
            if ($result['status'] == TRUE) {
                $data['status'] = TRUE;
                $data['message'] = 'Proses download hasil inacbg berhasil';
                $data['report'] = $result['report'];
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'Proses download hasil inacbg gagal. Silahkan download manual';
                $data['report'] = $result['report'];
            }
        } else {
            $data['message'] = 'No Registrasi kosong';
        }
        echo json_encode($data);
    }

    /*
     * ambil url cetak inacbg by no reg
     */

    function getUrlCetakInacbg() {
        $data = array(
            'urlCetak' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['noReg'])) {
            $noReg = $_POST['noReg'];
            $WS = $this->input_diagnosa_jmn_model->getWS(CETAK_INACBG);
            if ($WS != NULL) {
                $url = $WS['SWSSERV_ALAMAT_SERVER'];
                if (!empty($url)) {
                    $result = $this->input_diagnosa_jmn_model->identitasDataInacbg($noReg);
                    if ($result != NULL) {
                        $patient = $result->PATIENT_ID;
                        $admission = $result->ADMISSION_ID;
                        if (!empty($patient) && !empty($admission)) {
                            $stringUrl = $url . 'pid=' . $patient . '&adm=' . $admission;
                            $data['urlCetak'] = $stringUrl;
                            $data['message'] = 'url tersedia';
                        } else {
                            $data['message'] = 'identitas hasil tidak ditemukan';
                        }
                    } else {
                        $data['message'] = 'hasil inacbg belum tersedia';
                    }
                } else {
                    $data['message'] = 'alamat cetak salah. Hubungi Administrator';
                }
            } else {
                $data['message'] = 'Setting alamat cetak belum ada';
            }
        } else {
            $data['message'] = 'No Registrasi kosong';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data info tarif akhir inacbg
     */

    function getTarifAkhirInacbg() {
        $data = array(
            'infoTarifFinal' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            $idKunj = $_POST['idKunj'];
            $data['infoTarifFinal'] = $this->dataTarifAkhirInacbg($idKunj);
        } else {
            $data['message'] = 'identitas kunjungan kosong';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data tarif akhir inacbg
     */

    function dataTarifAkhirInacbg($idKunj) {
        $dataTarifFinal = NULL;
        $infoTarif = $this->input_diagnosa_jmn_model->infoTarifFinalInacbg($idKunj);
        if ($infoTarif != NULL) {
//            if ($infoTarif->PELAYANAN == '01') {
//                $tarifRsBySEP = number_format($this->input_diagnosa_jmn_model->totalTarifRsByNoSep($infoTarif->NO_SEP, $infoTarif->NO_REG));
//                $dataTarifFinal['TARIF_RS'] = $tarifRsBySEP;
//            } else {
//                $dataTarifFinal['TARIF_RS'] = number_format($infoTarif->TARIF_RS);
//            }
            $dataTarifFinal['TARIF_RS'] = number_format($infoTarif->TARIF_RS_RIIL);
            $dataTarifFinal['TARIF_INACBG'] = number_format($infoTarif->TARIF_INACBG);
            $dataTarifFinal['TARIF_PROCE'] = number_format($infoTarif->TARIF_PROCE);
            $dataTarifFinal['TARIF_DRUGS'] = number_format($infoTarif->TARIF_DRUGS);
            $dataTarifFinal['TARIF_INVESTIGATION'] = number_format($infoTarif->TARIF_INVESTIGATION);
            $dataTarifFinal['TARIF_PROST'] = number_format($infoTarif->TARIF_PROST);
            $dataTarifFinal['TARIF_HOT'] = number_format($infoTarif->TARIF_HOT);
            $dataTarifFinal['KODE_GROUPER'] = $infoTarif->KODE_GROUPER;
            $dataTarifFinal['DESC_GROUPER'] = $infoTarif->DESC_GROUPER;
            $dataTarifFinal['TARIF_PROPORSI'] = !empty($infoTarif->TARIF_PROPORSI) ? number_format($infoTarif->TARIF_PROPORSI) : NULL;
            $total = $infoTarif->TARIF_INACBG + $infoTarif->TARIF_PROCE + $infoTarif->TARIF_DRUGS + $infoTarif->TARIF_INVESTIGATION + $infoTarif->TARIF_PROST + $infoTarif->TARIF_HOT;
            $dataTarifFinal['TARIF_TOTAL'] = number_format($total);
            if ($total > $infoTarif->TARIF_RS) {
                $dataTarifFinal['STATUS_SURPLUS'] = '+';
                $dataTarifFinal['NAMA_STATUS_SURPLUS'] = 'Plus';
            } else {
                $dataTarifFinal['STATUS_SURPLUS'] = '-';
                $dataTarifFinal['NAMA_STATUS_SURPLUS'] = 'Minus';
            }
        }
        return $dataTarifFinal;
    }

    /*
     * generate header request api
     */

    public function generateHeader($content_type = 'application/json', $method = '') {
        $time = time();
        $data = $this->_custId . '&' . $time;

        $signature = hash_hmac('sha256', $data, $this->_custKey, true);
        $encodedSignature = base64_encode($signature);
        $header = '';
        if (!empty($signature)) {
            if (!empty($method) && $method == 'delete') {
                $header = array(
                    'Accept: application/json',
                    'X-cons-id: ' . $this->_custId,
                    'X-Timestamp: ' . $time,
                    'X-Signature: ' . $encodedSignature,
                    'Content-Type: ' . $content_type . '',
                );
            } else {
                $header = array(
                    'Accept' => 'application/json',
                    'X-cons-id' => $this->_custId,
                    'X-Timestamp' => $time,
                    'X-Signature' => $encodedSignature,
                    'Content-Type' => $content_type,
                );
            }
        }
        return $header;
    }

    /*
     * mengambil data history SEP by no Peserta
     */

    public function getHistorySEP() {
        $data = array(
            'data' => NULL,
            'message' => NULL,
            'report' => NULL
        );
        if (!empty($_POST['noPeserta'])) {
            $noPeserta = $_POST['noPeserta'];
            $result = $this->dataHistorySEPOnLine($noPeserta);
            if (!empty($result['data'])) {
                $namaRS = 'RSUP Dr Sardjito';
                $infoRs = $this->input_diagnosa_jmn_model->dataInfoRS();
                if ($infoRs != NULL) {
                    $namaRS = $infoRs->MRS_NAMA;
                }
                $data['data'] = $result['data'];
                for ($i = 0; $i < count($result['data']); $i++) {
                    $SEP = $data['data'][$i]['noSep'];
                    if ($this->input_diagnosa_jmn_model->cekAdaRegBySEP($SEP) == FALSE) {
                        $data['data'][$i]['keterangan'] = 'Tidak ada di list kunjungan ' . $namaRS;
                        $data['data'][$i]['adaKunjungan'] = 0;
                    } else {
                        $data['data'][$i]['keterangan'] = '';
                        $data['data'][$i]['adaKunjungan'] = 1;
                    }
                }
            }
            $data['message'] = $result['message'];
            $data['report'] = $result['report'];
        } else {
            $data['message'] = 'No Peserta Kosong';
        }
        echo json_encode($data);
    }

    /*
     * mengambil data history SEP by no Registrasi
     * digunakan di registrasi penunjang
     */

    public function getHistorySEPByIdKunj() {
        $data = array(
            'data' => NULL,
            'noRegBayar' => NULL,
            'message' => NULL,
            'report' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            $idKunj = $_POST['idKunj'];
            $dataPeserta = $this->input_diagnosa_jmn_model->dataNoPesertaDanPenjaminanByIdKunj($idKunj);
            if ($dataPeserta != NULL) {
                $noPeserta = $dataPeserta->NO_PESERTA;
                $data['noRegBayar'] = $dataPeserta->NO_REG;
                $result = $this->dataHistorySEPOnLine($noPeserta);
                if (!empty($result['data'])) {
                    $data['data'] = $result['data'];
                }
                $data['message'] = $result['message'];
                $data['report'] = $result['report'];
            } else {
                $data['message'] = 'Bukan kunjungan dengan cara bayar Bridging SEP';
            }
        } else {
            $data['message'] = 'No Peserta Kosong';
        }
        echo json_encode($data);
    }

    /*
     * YYYY-MM-DD
     * to
     * DD-MM-YYYY
     */

    function reverseToDateIndo($strTgl) {
        if (!empty($strTgl)) {
            $arrTgl = explode('-', substr($strTgl, 0, 10));
            $tahun = !empty($arrTgl[2]) ? $arrTgl[2] : '';
            $bulan = !empty($arrTgl[1]) ? $arrTgl[1] : '';
            $hari = !empty($arrTgl[0]) ? $arrTgl[0] : '';
            return $tahun . '-' . $bulan . '-' . $hari;
        } else {
            return '';
        }
    }

    /*
     * data history sep
     */

    public function dataHistorySEPOnLine($noPeserta) {
        $data = array(
            'data' => NULL,
            'message' => NULL,
            'report' => ''
        );
        if (!empty($noPeserta)) {
            $WS = $this->input_diagnosa_jmn_model->getWS('riwayatSEP');
            if ($WS != NULL) {
                $alamatService = $WS['SWSSERV_ALAMAT_SERVER'];
                if (!empty($alamatService)) {
                    //cek koneksi server
                    $url = $alamatService . $noPeserta;
                    try {
                        $request = Requests::get($url, $this->generateHeader());
                        if (!empty($request->body)) {
                            $response = json_decode($request->body);
                            if (!empty($response->response)) {
                                $history = $response->response->list;
                                if (!empty($history)) {
                                    $i = 0;
                                    while ($i < count($history)) {
                                        $noSep = !empty($history[$i]->noSep) ? $history[$i]->noSep : '';
                                        $strTglSep = !empty($history[$i]->tglSep) ? $history[$i]->tglSep : '';
                                        $tglSep = '';
                                        if (!empty($strTglSep)) {
                                            $tglSep = $this->reverseToDateIndo($strTglSep);
                                        }
                                        $strTglPulang = !empty($history[$i]->tglPulang) ? $history[$i]->tglPulang : '';
                                        $tglPulang = '';
                                        if (!empty($strTglPulang)) {
                                            $tglPulang = $this->reverseToDateIndo($strTglPulang);
                                        }
                                        $poliTujuan = '';
                                        if (!empty($history[$i]->poliTujuan)) {
                                            $poliTujuan = !empty($history[$i]->poliTujuan->nmPoli) ? $history[$i]->poliTujuan->nmPoli : '';
                                        }
                                        //set data
                                        $data['data'][] = array(
                                            'noSep' => $noSep,
                                            'tglSep' => $tglSep,
                                            'tglPulang' => $tglPulang,
                                            'nmPoli' => $poliTujuan
                                        );
                                        $i++;
                                    }
                                } else {
                                    $data['message'] = 'Tidak ada history';
                                }
                            } else {
                                if (!empty($response->metaData)) {
                                    $data['message'] = 'No Peserta tidak ditemukan';
                                } else {
                                    $data['message'] = 'Alamat service tidak ditemukan. Hubungi Administrator';
                                }
                            }
                        } else {
                            $data['message'] = 'Tidak ada respon dari service BPJS. Hubungi Administrator';
                        }
                    } catch (Exception $exc) {
                        $data['report'] .= $exc->getMessage();
                        $data['report'] .= $exc->getTraceAsString();
                        $data['message'] = 'Tidak terhubung dengan service BPSJ. Hubungi Administrator';
                    }
                } else {
                    $data['message'] = 'Setting service salah. Hubungi Administrator';
                }
            } else {
                $data['message'] = 'Belum ada setting service. Hubungi Administrator';
            }
        } else {
            $data['message'] = 'No Peserta kosong';
        }
        return $data;
    }

    /*
     * mengambil history kirim
     */

    public function getDataHistoryKirimInacbg() {
        $result = array(
            'data' => NULL,
            'message' => NULL
        );
        if (!empty($_POST['idKunj'])) {
            $idKunj = $_POST['idKunj'];
            $history = $this->input_diagnosa_jmn_model->dataHistoryKirimInacbg($idKunj);
            if ($history != NULL) {
                $arrData = array();
                foreach ($history as $row) {
                    settype($row->THGINA_TARIF_INACBG, 'float');
                    settype($row->THGINA_TARIF_SP_PROC, 'float');
                    settype($row->THGINA_TARIF_SP_DRUGS, 'float');
                    settype($row->THGINA_TARIF_SP_INVESTIGATION, 'float');
                    settype($row->THGINA_TARIF_SP_PROSTHESIS, 'float');
                    settype($row->THGINA_TARIF_HOT, 'float');
                    $arrData[] = array(
                        'TKPASID' => $row->TRANS_KUNJ_TKPAS_ID,
                        'NOREG' => $row->TKDINA_NOREG,
                        'NOMR' => $row->TKDINA_NOMR,
                        'NAMA' => $row->NAMA,
                        'NOPENJAMINAN' => $row->TKDINA_NO_PENJAMINAN,
                        'NOPESERTA' => $row->NOPESERTA,
                        'JENISPLYTEXT' => $row->JENISPLYTEXT,
                        'TGLJAMINAN' => $row->TGLJAMINAN,
                        'TGLMASUK' => $row->TGL_MASUK,
                        'TGLKELUAR' => $row->TGL_KELUAR,
                        'LOS' => $row->LOS,
                        'KELASJAMINAN' => $row->KELAS_JAMINAN,
                        'KELASRAWAT' => !empty($row->KELAS_RAWAT) ? $row->KELAS_RAWAT : $this->input_diagnosa_jmn_model->namaNaikTurunKelasKirimInacbg($row->TKDINA_NOREG),
                        'TARIFRS' => $row->THGINA_TARIF_RS,
                        'KODEGROUPER' => $row->THGINA_KODE_GROUPER,
                        'TARIFINACBG' => $row->THGINA_TARIF_INACBG,
                        'TARIFINACBGJAMINAN' => $row->TARIFINACBGJAMINAN,
                        'TARIFTOTALJAMINAN' => $row->TARIFTOTALJAMINAN,
                        'TARIFTAGIHANINACBG' => $row->TAGIHAN_INACBG,
                        'TARIFTAGIHANINACBGJAMINAN' => $row->TARIFTAGIHANINACBGJAMINAN,
                        'TARIFHOT' => $row->THGINA_TARIF_HOT,
                        'TARIFALKES' => $row->TARIF_ALKES,
                        'TARIFSPPROC' => $row->THGINA_TARIF_SP_PROC,
                        'TARIFSPDRUGS' => $row->THGINA_TARIF_SP_DRUGS,
                        'TARIFSPINVESTIGATION' => $row->THGINA_TARIF_SP_INVESTIGATION,
                        'TARIFSPPROSTHESIS' => $row->THGINA_TARIF_SP_PROSTHESIS,
                        'IS_BRIDGING' => $row->IS_BRIDGING,
                        'IS_HASIL_ASLI' => $row->IS_HASIL_ASLI
                    );
                }
                $result['data'] = $arrData;
            } else {
                $result['message'] = 'Tidak ada data ditemukan';
            }
        } else {
            $result['message'] = 'Identitas kunjungan kosong';
        }
        echo json_encode($result);
    }

    /*
     * mengambil data registrasi by registrasi utama
     */

    public function getDataRegistrasiByRegUtama() {
        $data = array(
            'data' => NULL,
            'message' => ''
        );
        if (!empty($_POST['noRegUtama'])) {
            $noRegUtama = $_POST['noRegUtama'];
            $dataReg = $this->input_diagnosa_jmn_model->dataInfoRegistrasiByNoRegUtama($noRegUtama);
            if ($dataReg != NULL) {
                $data['data'] = $dataReg;
            } else {
                $data['message'] = 'Data tidak ditemukan';
            }
        } else {
            $data['message'] = 'No Registrasi Utama kosong';
        }
        echo json_encode($data);
    }

    /*
     * TESTING
     */

    function testSep($noSep = '') {
        $header = array(
            'Accept' => 'application/json'
        );
        $WS = $this->input_diagnosa_jmn_model->getWS('cekSEP');
        if ($WS != NULL) {
            $alamatService = $WS['SWSSERV_ALAMAT_SERVER'];
            if (!empty($alamatService)) {
                //cek koneksi server
                $url = $alamatService . $noSep;
                try {
                    $request = Requests::get($url, $header);
                    echo '<pre>';
                    print_r($request);
                    echo '</pre>';
                    if ($request->status_code == '200') {
                        if (!empty($request->body)) {
                            $response = json_decode($request->body);
                            if ($response->metaData->code == '200') {
                                echo 'Sukses';
                            } else {
                                echo 'Gagal';
                            }
                            echo 'isi';
                        } else {
                            echo 'kosong';
                        }
                    } else {
                        echo 'No SEP salah';
                    }
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
    }

    public function cekStatusKoneksi2() {
        echo 'My Sql conecting<br/>';
        $hostName = '192.168.100.112:3306';
        $username = 'inacbg';
        $password = 'CBGMASTER';
        $tB = microtime(true);
        $connection = @mysql_connect($hostName, $username, $password);
        $tA = microtime(true);
        echo '<pre>';
        print_r($connection);
        echo '</pre>';
        echo 'time : ' . round((($tA - $tB) * 1000), 0) . " ms";
    }

    public function cekStatusKoneksi3() {
        echo 'Fsockopen conecting<br/>';
        $hostName = '192.168.100.112';
        $errno = '';
        $errstr = '';
        $tB = microtime(true);
        $socket = @fsockopen($hostName, '3306', $errno, $errstr, 0.5);
        $tA = microtime(true);
        if (!$socket) {
            socket_close($socket);
            echo 'tidak melakukan';
        } else {
            socket_close($socket);
            $con = $this->input_diagnosa_jmn_model->koneksiInacbg();
            if ($con == TRUE) {
                echo 'Conek';
            } else {
                echo 'tidak konek';
            }
        }
        echo '<pre>';
        print_r($socket);
        echo '</pre>';
        echo '$errno : ' . $errno . '<br/>';
        echo '$errstr : ' . $errstr . '<br/>';
        echo 'time : ' . round((($tA - $tB) * 1000), 0) . " ms";
    }

    /*
     * test koneksi inacbg
     */

    function testConnect() {
        $hostName = '10.100.254.22';
        $username = 'inacbg41';
        $password = 'CBGMASTER';
        echo 'koneksi ' . $hostName . ' u ' . $username . '</br>';
        $this->benchmark->mark('code_start');
        $connection = @mysql_connect($hostName, $username, $password);
        if (!$connection) {
            echo 'gagal, ';
        } else {
            mysql_close($connection);
            echo 'sukses, ';
        }
        $this->benchmark->mark('code_end');
        echo 'waktu ' . $this->benchmark->elapsed_time('code_start', 'code_end');
        echo '</br>';
        echo '</br>';

        $hostName1 = '10.100.254.24';
        $username1 = 'root';
        $password1 = 'CBGMASTER';
        echo 'koneksi ' . $hostName1 . ' u ' . $username1 . '</br>';
        $this->benchmark->mark('code_start1');
        $connection1 = @mysql_connect($hostName1, $username1, $password1);
        if (!$connection1) {
            echo 'gagal, ';
        } else {
            mysql_close($connection1);
            echo 'sukses, ';
        }
        $this->benchmark->mark('code_end1');
        echo 'waktu ' . $this->benchmark->elapsed_time('code_start1', 'code_end1');
        echo '</br>';
        echo '</br>';

        $hostName2 = '10.100.254.23';
        $username2 = 'inacbg';
        $password2 = 'CBGMASTER';
        echo 'koneksi ' . $hostName2 . ' u ' . $username2 . '</br>';
        $this->benchmark->mark('code_start2');
        $connection2 = @mysql_connect($hostName2, $username2, $password2);
        if (!$connection2) {
            echo 'gagal, ';
        } else {
            mysql_close($connection2);
            echo 'sukses, ';
        }
        $this->benchmark->mark('code_end2');
        echo 'waktu ' . $this->benchmark->elapsed_time('code_start2', 'code_end2');
        echo '</br>';
        echo '</br>';

        $hostName3 = '10.1.1.53';
        $username3 = 'inacbg';
        $password3 = 'CBGMASTER';
        echo 'koneksi ' . $hostName3 . ' u ' . $username3 . '</br>';
        $this->benchmark->mark('code_start3');
        $connection3 = @mysql_connect($hostName3, $username3, $password3);
        if (!$connection3) {
            echo 'gagal, ';
        } else {
            echo 'sukses, ';
            mysql_close($connection3);
        }
        $this->benchmark->mark('code_end3');
        echo 'waktu ' . $this->benchmark->elapsed_time('code_start3', 'code_end3');
        echo '</br>';
        echo '</br>';

        $hostName4 = '10.100.254.22';
        $username4 = 'root';
        $password4 = 'CBGMASTER';
        echo 'koneksi ' . $hostName4 . ' u ' . $username4 . '</br>';
        $this->benchmark->mark('code_start4');
        $connection4 = @mysql_connect($hostName4, $username4, $password4);
        if (!$connection4) {
            echo 'gagal, ';
        } else {
            echo 'sukses, ';
            mysql_close($connection4);
        }
        $this->benchmark->mark('code_end4');
        echo 'waktu ' . $this->benchmark->elapsed_time('code_start4', 'code_end4');
        echo '</br>';
        echo '</br>';
    }

    function doCon3() {
        $hostName = '10.1.1.15';
        $port = '3306';
        $errno = '';
        $errstr = '';
        $this->benchmark->mark('code_startP');
        $connection = @fsockopen($hostName, $port, $errno, $errstr, 5); //set timeout 500ms
        echo 'con ' . $connection . '<br>';
        if (!$connection) {
            echo 'FALSE';
            echo '$errno ' . $errno . '<br>';
            echo '$errstr ' . $errstr . '<br>';
        } else {
            echo 'TRUE';
            echo '<br>close';
            fclose($connection);
        }

        echo '<br>';
        echo 'con ' . $connection . '<br>';
        echo 'end';
        $this->benchmark->mark('code_endP');
        echo 'waktu ' . $this->benchmark->elapsed_time('code_startP', 'code_endP');
    }

    function testing() {
        $fileName = 'new20155031710549.txt';
        $ip = '10.100.254.11';
        $user = 'coki';
        $pass = 'cokicoki';
        $port = '21';
        $local_file = 'document_test/rr' . $fileName;
        $remote_file = 'document_lis/file_order/' . $fileName;

        $result = array();
        $connection = @ftp_connect($ip, $port);
        if (!$connection) {
            $result['status'] = FALSE;
            $result['message'] = "Connection attempt failed!";
        } else {
            $login = @ftp_login($connection, $user, $pass);
            if (!$login) {
                $result['status'] = FALSE;
                $result['message'] = "Login attempt failed!";
            } else {
                // try to download $remote_file and save it to $handle
//                if (@ftp_get($connection, $local_file, $remote_file, FTP_ASCII)) {
//                    $result['message'] = "successfully written to $local_file\n";
//                } else {
//                    $result['message'] = "There was a problem while downloading $remote_file to $local_file\n";
//                }
                // try to download $remote_file and save it to $handle
//                $handle = fopen($local_file, 'w');
//                $downloadAndOpen = @ftp_fget($connection, $handle, $remote_file, FTP_ASCII, 0);
//                if (!$downloadAndOpen) {
//                    echo "There was a problem while downloading $remote_file to $local_file\n";
//                } else {
//                    echo "successfully written to $local_file\n";
//                    echo $downloadAndOpen;
//                }
//                fclose($handle);
            }
            ftp_close($connection);
        }
        pr($result);
    }

    /*
     * END TESTING
     */
}
