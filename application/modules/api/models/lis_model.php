<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lis_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * hak akses service
     */

    function aksesService($IP, $serviceName) {
        $query = $this->db->query("
            SELECT 
            SWSCLIENT_KODE AS KODE,
            SWSCLIENT_USERNAME AS USERNAME,
            SWSCLIENT_PASSWORD AS PASSWORD
            FROM SET_WEB_SERVICE_CLIENT 
            WHERE SWSCLIENT_NAMA_WS = '$serviceName'
            AND SWSCLIENT_ALAMAT_CLIENT = '$IP'
            AND SWSCLIENT_ISAKTIF = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

    /*
     * required
     */

    function requied($field, $label, & $status, & $error) {
        if (strlen($field) < 1) {
            $error[] = 'validation: ' . $label . ' tidak boleh kosong';
            $status = FALSE;
        }
    }

    /*
     * max length
     */

    function maxLenght($field, $label, $length, & $status, & $error) {
        if (strlen($field) > intval($length)) {
            $error[] = 'validation: ' . $label . ' tidak boleh lebih dari ' . $length . ' karakter';
            $status = FALSE;
        }
    }

    /*
     * valid kode pegawai
     */

    function validKodePegawai($field, $label, & $status, & $error) {
        if (!empty($field)) {
            $query = $this->db->query("
            SELECT COUNT(MPG_KODE) AS JUMLAH FROM MST_PEGAWAI WHERE MPG_KODE = '$field'
            ");
            if ($query->row()->JUMLAH < 1) {
                $error[] = 'validation: ' . $label . ' (' . $field . ') tidak terdaftar';
                $status = FALSE;
            }
        }
    }

    function validKodeProduk($field, $label, & $status, & $error) {
        if (!empty($field)) {
            $query = $this->db->query("
            SELECT COUNT(MPRO_KODE) AS JUMLAH FROM MST_PRODUK WHERE MPRO_KODE = '$field'
            ");
            if ($query->row()->JUMLAH < 1) {
                $error[] = 'validation: ' . $label . ' (' . $field . ') tidak terdaftar';
                $status = FALSE;
            }
        }
    }

    /*
     * validation data
     */

    function validData($field, $label, $strValidation = '', & $status, & $error) {
        $arr = explode('|', $strValidation);
        $i = 0;
        while ($i < count($arr)) {
            $arr2 = explode(':', $arr[$i]);
            if (!empty($arr2[0])) {
                if ($arr2[0] == 'required') {
                    $this->requied($field, $label, $status, $error);
                } else if ($arr2[0] == 'maxLength') {
                    $this->maxLenght($field, $label, $arr2[1], $status, $error);
                } else if ($arr2[0] == 'validKodePegawai') {
                    $this->validKodePegawai($field, $label, $status, $error);
                } else if ($arr2[0] == 'validKodeProduk') {
                    $this->validKodeProduk($field, $label, $status, $error);
                }
            }
            $i++;
        }
    }

    /*
     * proses insert hasil lab
     */

    function insertHasil($dataPasien, $dataHasil) {
        $this->db->trans_begin();
        $status = TRUE;
        $report = array(); /* report bad insert */
        $error = array(); /* report error data */
        if (!empty($dataPasien)) {
            $noRm = trim(!empty($dataPasien['no_rm']) ? $dataPasien['no_rm'] : '');
            $noLab = trim(!empty($dataPasien['no_lab']) ? $dataPasien['no_lab'] : '');
            $tglOrder = trim(!empty($dataPasien['tanggal_order']) ? $dataPasien['tanggal_order'] : '');
            $tglHasil = trim(!empty($dataPasien['tanggal_kirim_hasil']) ? $dataPasien['tanggal_kirim_hasil'] : '');
            $catatan = trim(!empty($dataPasien['catatan']) ? $dataPasien['catatan'] : '');
            $idUserApi = '42';

            $this->validData($noRm, 'no_rm', 'required|maxLength:8', $status, $error);
            $this->validData($noLab, 'no_lab', 'required|maxLength:50', $status, $error);
            $this->validData($tglOrder, 'tanggal_order', 'required|maxLength:19', $status, $error);
            $this->validData($tglHasil, 'tanggal_kirim_hasil', 'required|maxLength:19', $status, $error);

            if ($status == TRUE) {
                if (!empty($dataHasil)) {
                    /*
                     * delete data lama by noLab
                     * upload 2015-09-23 11:00:00
                     */
                    if (!empty($noLab)) {
                        $this->db->query("
                            DELETE FROM DET_TRANS_HASIL_LIS WHERE TR_HASIL_LIS_THLIS_ID IN(
                                     SELECT THLIS_ID FROM TRANS_HASIL_LIS WHERE THLIS_ORDER = '$noLab'
                             )
                         ");

                        $this->db->query("
                            DELETE FROM TRANS_HASIL_LIS WHERE THLIS_ORDER = '$noLab'
                         ");
                    }

                    /*
                     * end delete
                     */

                    $i = 0;
                    while ($i < count($dataHasil) && $status == TRUE) {
                        $strKodeProduk = trim(!empty($dataHasil[$i]['kode_produk']) ? str_replace('_', '', $dataHasil[$i]['kode_produk']) : '');
                        $kodeProduk = '';
                        if (!empty($strKodeProduk)) {
                            $arrKode = explode('.', $strKodeProduk);
                            $kodeProduk = $arrKode[0];
                            if (!empty($arrKode[1])) {
                                $kodeProduk .= '.' . $arrKode[1];
                                if (!empty($arrKode[2])) {
                                    $kodeProduk .= '.' . $arrKode[2];
                                }
                            }
                        }
                        $namaProduk = trim(!empty($dataHasil[$i]['nama_produk']) ? $dataHasil[$i]['nama_produk'] : '');
                        $namaKomponen = trim(!empty($dataHasil[$i]['nama_komponen']) ? $dataHasil[$i]['nama_komponen'] : '');
                        $nilai = trim(!empty($dataHasil[$i]['nilai']) ? $dataHasil[$i]['nilai'] : '');
                        $satuan = trim(!empty($dataHasil[$i]['satuan']) ? $dataHasil[$i]['satuan'] : '');
                        $level = trim(!empty($dataHasil[$i]['level']) ? $dataHasil[$i]['level'] : '');
                        $nilaiNormal = trim(!empty($dataHasil[$i]['nilai_normal']) ? $dataHasil[$i]['nilai_normal'] : '');

                        $isVerifAnalis = trim(!empty($dataHasil[$i]['is_verif_analis']) ? 1 : 0); //new
                        $kodeAnalis = trim(!empty($dataHasil[$i]['kode_analis']) ? $dataHasil[$i]['kode_analis'] : '');
                        $namaAnalis = trim(!empty($dataHasil[$i]['nama_analis']) ? $dataHasil[$i]['nama_analis'] : ''); //new                        
                        $tglVerifAnalis = trim(!empty($dataHasil[$i]['tanggal_verif_analis']) ? $dataHasil[$i]['tanggal_verif_analis'] : '');

                        $isVerifDokter = trim(!empty($dataHasil[$i]['is_verif_dokter']) ? 1 : 0); //new
                        $kodeDokter = trim(!empty($dataHasil[$i]['kode_dokter']) ? $dataHasil[$i]['kode_dokter'] : '');
                        $namaDokter = trim(!empty($dataHasil[$i]['nama_dokter']) ? $dataHasil[$i]['nama_dokter'] : ''); //new
                        $tglVerifPemeriksa = trim(!empty($dataHasil[$i]['tanggal_verif_pemeriksa']) ? $dataHasil[$i]['tanggal_verif_pemeriksa'] : '');

                        $isVerifVerifikator = trim(!empty($dataHasil[$i]['is_verif_verifikator']) ? 1 : 0); //new
                        $kodeDokterVerifikator = trim(!empty($dataHasil[$i]['kode_dokter_verifikator']) ? $dataHasil[$i]['kode_dokter_verifikator'] : '');
                        $namaDokterVerifikator = trim(!empty($dataHasil[$i]['nama_dokter_verifikator']) ? $dataHasil[$i]['nama_dokter_verifikator'] : ''); //new
                        $tglVerifVerifikator = trim(!empty($dataHasil[$i]['tanggal_verif_verifikator']) ? $dataHasil[$i]['tanggal_verif_verifikator'] : ''); //new

                        $metode = trim(!empty($dataHasil[$i]['metode']) ? $dataHasil[$i]['metode'] : ''); //new
                        $catatan = trim(!empty($dataHasil[$i]['catatan']) ? $dataHasil[$i]['catatan'] : ''); //new
                        $informasi = trim(!empty($dataHasil[$i]['informasi']) ? $dataHasil[$i]['informasi'] : ''); //new

                        $statusManual = '0';

                        $this->validData($kodeProduk, 'kode_produk', 'maxLength:10|validKodeProduk', $status, $error);
                        $this->validData($namaProduk, 'nama_produk', 'maxLength:1000', $status, $error);
                        $this->validData($namaKomponen, 'nama_komponen', 'maxLength:100', $status, $error);
                        $this->validData($nilai, 'nilai', 'maxLength:30', $status, $error);
                        $this->validData($satuan, 'satuan', 'maxLength:10', $status, $error);
                        $this->validData($level, 'level', 'maxLength:10', $status, $error);
                        $this->validData($nilaiNormal, 'nilai_normal', 'maxLength:100', $status, $error);

                        $this->validData($tglVerifAnalis, 'tanggal_verif_analis', 'required|maxLength:19', $status, $error);
                        $this->validData($tglVerifPemeriksa, 'tanggal_verif_pemeriksa', 'required|maxLength:19', $status, $error);
                        $this->validData($tglVerifVerifikator, 'tanggal_verif_verifikator', 'maxLength:19', $status, $error);

                        $this->validData($kodeAnalis, 'kode_analis', 'required|maxLength:10|validKodePegawai', $status, $error);
                        $this->validData($kodeDokter, 'kode_dokter', 'required|maxLength:10|validKodePegawai', $status, $error);
                        $this->validData($kodeDokterVerifikator, 'kode_dokter_verifikator', 'maxLength:10|validKodePegawai', $status, $error);

                        $this->validData($namaAnalis, 'nama_analis', 'maxLength:100', $status, $error); //new
                        $this->validData($namaDokter, 'nama_dokter', 'maxLength:100', $status, $error); //new
                        $this->validData($namaDokterVerifikator, 'nama_dokter_verifikator', 'maxLength:100', $status, $error); //new

                        $this->validData($metode, 'metode', 'maxLength:100', $status, $error); //new
                        $this->validData($catatan, 'catatan', 'maxLength:1000', $status, $error); //new
                        $this->validData($informasi, 'informasi', 'maxLength:1000', $status, $error); //new

                        if ($status == TRUE) {
                            if (empty($namaAnalis)) {
                                $namaAnalis = $this->namaPegawaiByKode($kodeAnalis);
                            }
                            if (empty($namaDokter)) {
                                $namaDokter = $this->namaPegawaiByKode($kodeDokter);
                            }
                            if (empty($namaDokterVerifikator)) {
                                $namaDokterVerifikator = $this->namaPegawaiByKode($kodeDokterVerifikator);
                            }

                            $idKunj = NULL;
                            $idDetWo = NULL;
                            $idTransHasil = NULL;
                            /*
                             * mengambil identitas data hasil di transaksi wo
                             */
                            $dataWO = $this->getIdentitasWO($noLab, $noRm, $kodeProduk, TRUE);
                            if ($dataWO != NULL) {
                                $idKunj = $dataWO->ID_KUNJ;
                                $idDetWo = $dataWO->ID_DET_WO;
                                $idTransHasil = $dataWO->ID_HASIL;
                            } else {
                                $dataWO = $this->getIdentitasWO($noLab, $noRm, $kodeProduk, FALSE);
                                if ($dataWO != NULL) {
                                    $idKunj = $dataWO->ID_KUNJ;
                                    $idDetWo = NULL;
                                    $idTransHasil = NULL;
                                    /*
                                     * set status manual 1
                                     */
                                    $statusManual = '1';
                                    /*
                                     * mengambil id hasil
                                     */
                                    $queryHasil = $this->db->query("
                                        SELECT THLIS_ID 
                                        FROM TRANS_HASIL_LIS 
                                        WHERE THLIS_ORDER = '$noLab' 
                                        AND THLIS_NOMR = '$noRm'
                                        AND MST_PRODUK_MPRO_KODE = '$kodeProduk' 
                                        AND THLIS_IS_MANUAL = '1'
                                        ");
                                    if ($queryHasil->num_rows() > 0) {
                                        $idTransHasil = $queryHasil->row()->THLIS_ID;
                                    }
                                }
                            }
                            if (!empty($idKunj)) {
                                if (empty($idTransHasil)) {
                                    /*
                                     * insert trans hasil induk (per produk)
                                     */
                                    $idTransHasil = $this->ora_get_sequence('SC_TRANS_HASIL_LIS');

                                    $newHasil = array(
                                        'THLIS_ID' => $idTransHasil,
                                        'TRANS_KUNJ_PASIEN_TKPAS_ID' => $idKunj,
                                        'THLIS_NOMR' => $noRm,
                                        'THLIS_RKURAI_DESC' => $catatan,
                                        'MST_PRODUK_MPRO_KODE' => $kodeProduk,
                                        'TR_DET_WO_PNJNG_TDWPEN_ID' => $idDetWo,
                                        'THLIS_USERUPDATE' => $idUserApi,
                                        'THLIS_ORDER' => $noLab,
                                        'THLIS_PRODUK_MANUAL' => $namaProduk,
                                        'THLIS_IS_MANUAL' => $statusManual
                                    );

                                    $this->db->set('THLIS_LASTUPDATE', 'SYSDATE', FALSE);
                                    $this->db->set('THLIS_TGL_TERIMA_HASIL', "TO_DATE('$tglHasil', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
                                    $this->db->set('THLIS_TGL_ORDER', "TO_DATE('$tglOrder', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
                                    $this->db->insert('TRANS_HASIL_LIS', $newHasil);
                                    if ($this->db->affected_rows() < 1) {
                                        $report[] = 'add (no_rm:' . $noRm . ', no_lab:' . $noLab . ', kode_produk:' . $kodeProduk . ') gagal';
                                        $status = FALSE;
                                    }
                                }
                                /*
                                 * insert detail hasil
                                 */
                                $idDetTransHasil = $this->ora_get_sequence('SC_DET_TRANS_HASIL_LIS');
                                $newDetHasil = array(
                                    'DTHLIS_ID' => $idDetTransHasil,
                                    'TR_HASIL_LIS_THLIS_ID' => $idTransHasil,
                                    'MST_DET_KOMP_TIND_MDKOMT_KODE' => NULL,
                                    'DTHLIS_NILAI' => $nilai,
                                    'DTHLIS_SATUAN' => $satuan,
                                    'DTHLIS_LEVEL' => $level,
                                    'DTHLIS_NILAI_REV' => $nilaiNormal,
                                    'DTHLIS_USERUPDATE' => $idUserApi,
                                    'MST_PEGAWAI_MPG_KODE_ANALIS' => $kodeAnalis,
                                    'MST_PEGAWAI_MPG_KODE_DOKTER' => $kodeDokter,
                                    'MST_PEGAWAI_MPG_KODE_VERIF' => $kodeDokterVerifikator,
                                    'DTHLIS_NAMA_KOMPONEN' => $namaKomponen,
                                    'DTHLIS_IS_VERIF_ANALIS' => $isVerifAnalis,
                                    'DTHLIS_IS_VERIF_DOKTER' => $isVerifDokter,
                                    'NAMA_ANALIS_VERIF' => $namaAnalis,
                                    'NAMA_DOKTER_VERIF' => $namaDokter, ///
                                    'NAMA_VERIFIKATOR_VERIF' => $namaDokterVerifikator,
                                    'DTHLIS_METODE' => $metode,
                                    'DTHLIS_CATATAN' => $catatan,
                                    'DTHLIS_INFORMASI' => $informasi,
                                    'DTHLIS_IS_VERIF_FINAL' => $isVerifVerifikator
                                );

                                $this->db->set('DTHLIS_LASTUPDATE', 'SYSDATE', FALSE);
                                $this->db->set('DTHLIS_TGL_VERIF_ANALIS', "TO_DATE('$tglVerifAnalis', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
                                $this->db->set('DTHLIS_TGL_VERIF_DOKTER', "TO_DATE('$tglVerifPemeriksa', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
                                $this->db->insert('DET_TRANS_HASIL_LIS', $newDetHasil);
                                if ($this->db->affected_rows() < 1) {
                                    $report[] = 'add detail (no_lab:' . $noLab . ', kode_produk:' . $kodeProduk . ', nama_komponen:' . $namaKomponen . ', nilai:' . $nilai . ') gagal';
                                    $status = FALSE;
                                }
                            } else {
                                $error[] = 'data hasil (no_lab:' . $noLab . ', no_rm:' . $noRm . ', kode_produk:' . $kodeProduk . ') tidak ditemukan';
                                $status = FALSE;
                            }
                        }

                        $i++;
                    }
                } else {
                    /*
                     * tidak ada hasil
                     */
                    $error[] = 'Tidak ada data hasil';
                    $status = FALSE;
                }
            }
        } else {
            /*
             * tidak ada data pasien
             */
            $error[] = 'Tidak ada data pasien';
            $status = FALSE;
        }

        $result['report'] = $report;
        $result['error'] = $error;
        if ($this->db->trans_status() === FALSE || $status == FALSE) {
            $this->db->trans_rollback();
            $result['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $result['status'] = TRUE;
        }
        return $result;
    }

    /*
     * mengambil nama pegawai by kode pegawai
     */

    function namaPegawaiByKode($kode) {
        $query = $this->db->query("
                SELECT 
                TRIM(MPG.MPG_GELAR_DEPAN||' '||MPG.MPG_NAMA||' '||MPG.MPG_GELAR_BELAKANG) AS NAMA_DOKTER
                FROM MST_PEGAWAI MPG
                WHERE MPG_KODE = '" . trim($kode) . "'
         ");
        if ($query->num_rows() > 0) {
            return $query->row()->NAMA_DOKTER;
        } else {
            return NULL;
        }
    }

    /*
     * mengambil identitas data hasil di transaksi wo
     */

    function getIdentitasWO($noLab, $noRm, $kodeProduk, $cekProduk = FALSE) {
        $addWhere = '';
        if ($cekProduk == TRUE) {
            $addWhere = " AND TDWO.MST_PRODUK_MPRO_KODE = '$kodeProduk'";
        }
        $query = $this->db->query("
                                SELECT
                                TWO.TRANS_KUNJ_TKPAS_ID_PEN AS ID_KUNJ,
                                TWO.TWPEN_NOMR AS NO_RM,
                                TDWO.MST_PRODUK_MPRO_KODE AS KODE_PRODUK,
                                TDWO.TDWPEN_ID AS ID_DET_WO,
                                THL.THLIS_ID AS ID_HASIL
                                FROM TRANS_WO_PENUNJANG TWO
                                JOIN TRANS_DET_WO_PENUNJANG TDWO ON TDWO.TRANS_WO_PENUNJANG_TWPEN_ID = TWO.TWPEN_ID
                                LEFT JOIN TRANS_HASIL_LIS THL ON THL.TR_DET_WO_PNJNG_TDWPEN_ID = TDWO.TDWPEN_ID
                                WHERE TDWO.TDWPEN_SAMPLEID = '$noLab' 
                                AND TWO.TWPEN_NOMR = '$noRm' 
                                $addWhere
                            ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

    /*
     * mengembalikan data hasil by no lab
     */

    function dataHasilByNoLab($noLab) {
        $query = $this->db->query("
            SELECT 
            THL.THLIS_NOMR AS NO_RM,
            MPAS.MPAS_NAMA AS NAMA_PASIEN,
            THL.MST_PRODUK_MPRO_KODE AS KODE_PRODUK,
            MPRO.MPRO_NAMA AS NAMA_PRODUK,
            THL.THLIS_RKURAI_DESC AS CATATAN,
            TO_CHAR(THL.THLIS_TGL_TERIMA_HASIL, 'DD/MM/YYYY HH24:MI:SS') TGL_HASIL,
            TO_CHAR(THL.THLIS_TGL_ORDER, 'DD/MM/YYYY HH24:MI:SS') TGL_ORDER,
            DTHL.DTHLIS_NAMA_KOMPONEN AS NAMA_KOMPONEN,
            DTHL.DTHLIS_NILAI AS NILAI,
            DTHL.DTHLIS_SATUAN AS SATUAN,
            DTHL.DTHLIS_LEVEL AS LEVEL_HASIL,
            DTHL.DTHLIS_NILAI_REV AS NILAI_NORMAL,
            TO_CHAR(DTHL.DTHLIS_TGL_VERIF_ANALIS, 'DD/MM/YYYY HH24:MI:SS') TGL_VERIF_ANALIS,
            TO_CHAR(DTHL.DTHLIS_TGL_VERIF_DOKTER, 'DD/MM/YYYY HH24:MI:SS') TGL_VERIF_PEMERIKSA,
            DTHL.MST_PEGAWAI_MPG_KODE_ANALIS AS KODE_ANALIS,
            CASE
                    WHEN MPEGA.MPG_GELAR_DEPAN IS NOT NULL AND MPEGA.MPG_GELAR_BELAKANG IS NOT NULL THEN MPEGA.MPG_GELAR_DEPAN||' '||MPEGA.MPG_NAMA||' '||MPEGA.MPG_GELAR_BELAKANG
                    WHEN MPEGA.MPG_GELAR_DEPAN IS NOT NULL AND MPEGA.MPG_GELAR_BELAKANG IS NULL THEN MPEGA.MPG_GELAR_DEPAN||' '||MPEGA.MPG_NAMA
                    WHEN MPEGA.MPG_GELAR_DEPAN IS NULL AND MPEGA.MPG_GELAR_BELAKANG IS NOT NULL THEN MPEGA.MPG_NAMA||' '||MPEGA.MPG_GELAR_BELAKANG
                    ELSE MPEGA.MPG_NAMA
            END NAMA_ANALIS,
            DTHL.MST_PEGAWAI_MPG_KODE_DOKTER AS KODE_DOKTER,
            CASE
                    WHEN MPEGD.MPG_GELAR_DEPAN IS NOT NULL AND MPEGD.MPG_GELAR_BELAKANG IS NOT NULL THEN MPEGD.MPG_GELAR_DEPAN||' '||MPEGD.MPG_NAMA||' '||MPEGD.MPG_GELAR_BELAKANG
                    WHEN MPEGD.MPG_GELAR_DEPAN IS NOT NULL AND MPEGD.MPG_GELAR_BELAKANG IS NULL THEN MPEGD.MPG_GELAR_DEPAN||' '||MPEGD.MPG_NAMA
                    WHEN MPEGD.MPG_GELAR_DEPAN IS NULL AND MPEGD.MPG_GELAR_BELAKANG IS NOT NULL THEN MPEGD.MPG_NAMA||' '||MPEGD.MPG_GELAR_BELAKANG
                    ELSE MPEGD.MPG_NAMA
            END NAMA_DOKTER,
            DTHL.MST_PEGAWAI_MPG_KODE_VERIF AS KODE_DOKTER_VERIF,
            CASE
                    WHEN MPEGV.MPG_GELAR_DEPAN IS NOT NULL AND MPEGV.MPG_GELAR_BELAKANG IS NOT NULL THEN MPEGV.MPG_GELAR_DEPAN||' '||MPEGV.MPG_NAMA||' '||MPEGV.MPG_GELAR_BELAKANG
                    WHEN MPEGV.MPG_GELAR_DEPAN IS NOT NULL AND MPEGV.MPG_GELAR_BELAKANG IS NULL THEN MPEGV.MPG_GELAR_DEPAN||' '||MPEGV.MPG_NAMA
                    WHEN MPEGV.MPG_GELAR_DEPAN IS NULL AND MPEGV.MPG_GELAR_BELAKANG IS NOT NULL THEN MPEGV.MPG_NAMA||' '||MPEGV.MPG_GELAR_BELAKANG
                    ELSE MPEGV.MPG_NAMA
            END NAMA_DOKTER_VERIF
            FROM TRANS_HASIL_LIS THL
            JOIN DET_TRANS_HASIL_LIS DTHL ON DTHL.TR_HASIL_LIS_THLIS_ID = THL.THLIS_ID
            LEFT JOIN MST_PASIEN MPAS ON MPAS.MPAS_NORM = THL.THLIS_NOMR
            LEFT JOIN MST_PRODUK MPRO ON MPRO.MPRO_KODE = THL.MST_PRODUK_MPRO_KODE
            LEFT JOIN MST_PEGAWAI MPEGA ON MPEGA.MPG_KODE = DTHL.MST_PEGAWAI_MPG_KODE_ANALIS
            LEFT JOIN MST_PEGAWAI MPEGD ON MPEGD.MPG_KODE = DTHL.MST_PEGAWAI_MPG_KODE_DOKTER
            LEFT JOIN MST_PEGAWAI MPEGV ON MPEGV.MPG_KODE = DTHL.MST_PEGAWAI_MPG_KODE_VERIF
            WHERE THL.THLIS_ORDER = '$noLab'
            ORDER BY MPRO.MPRO_NAMA ASC
            ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }

    /*
     * insert log komunikasi data
     */

    function addLogService($log, $idTrans = NULL) {
        $isNew = FALSE;
        if (empty($idTrans)) {
            $isNew = TRUE;
            $idTrans = $this->ora_get_sequence('SC_TRANS_KOMUNIKASI_DATA_WS');
        }
        // Create connection to Oracle
        $userDb = $this->db->username;
        $passDb = $this->db->password;
        $hostname = $this->db->hostname;
        $conn = oci_connect($userDb, $passDb, $hostname);
        if ($conn) {
            if ($isNew == FALSE) {
                /*
                 * update
                 */
                $query = "UPDATE TRANS_KOMUNIKASI_DATA_WS
                        SET 
                           TKDW_PARAMETER = '" . $log['TKDW_PARAMETER'] . "',
                           TKDW_STATUS = '" . $log['TKDW_STATUS'] . "',
                           TKDW_LASTUPDATE = SYSDATE,
                           TKDW_DATA = :TKDW_DATA,
                           TKDW_RESULT = :TKDW_RESULT
                        WHERE TKDW_ID = $idTrans
                        ";

                $stmt = OCIParse($conn, $query);
                OCIBindByName($stmt, ':TKDW_DATA', $log['TKDW_DATA']);
                OCIBindByName($stmt, ':TKDW_RESULT', $log['TKDW_RESULT']);
                OCIExecute($stmt);

                ocifreestatement($stmt);
            } else {
                /*
                 * insert baru
                 */
                $query = "INSERT INTO TRANS_KOMUNIKASI_DATA_WS 
                (
                    TKDW_ID, 
                    TKDW_NAMA_WS, 
                    TKDW_ALAMAT_SERVER, 
                    TKDW_PARAMETER, 
                    TKDW_STATUS, 
                    TKDW_TANGGAL, 
                    TKDW_LASTUPDATE, 
                    TKDW_USERUPDATE, 
                    TKDW_DATA, 
                    TKDW_RESULT
                )
                VALUES (
                    $idTrans, 
                    '" . $log['TKDW_NAMA_WS'] . "', 
                    '" . $log['TKDW_ALAMAT_SERVER'] . "', 
                    '" . $log['TKDW_PARAMETER'] . "', 
                    '" . $log['TKDW_STATUS'] . "', 
                    SYSDATE, 
                    SYSDATE, 
                    '" . $log['TKDW_USERUPDATE'] . "', 
                    :TKDW_DATA, 
                    :TKDW_RESULT
                )";

                $stmt = OCIParse($conn, $query);
                OCIBindByName($stmt, ':TKDW_DATA', $log['TKDW_DATA']);
                OCIBindByName($stmt, ':TKDW_RESULT', $log['TKDW_RESULT']);
                OCIExecute($stmt);

                ocifreestatement($stmt);
            }

            oci_close($conn);

            return $idTrans;
        } else {
//            $m = oci_error();
//            echo $m['message'], "\n";
            return NULL;
        }
    }

    /*
     * format array to xml
     */

    function toXml($array) {
        return $this->arrayToXML($array, 'root');
    }

}
