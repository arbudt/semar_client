<?php

class Pelayanan_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function getDataPoli() {
        $query = $this->db->query("
            SELECT
            `mpoli_id` AS kode,
            `mpoli_nama` AS nama
            FROM `mst_poli`
            WHERE `mpoli_isaktif` = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataDokter() {
        $query = $this->db->query("
            SELECT
            `mdok_id` AS kode,
            concat(`mdok_gelar_depan`,' ', `mdok_nama`,' ',`mdok_gelar_belang`) AS nama
            FROM `mst_dokter`
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function getDataCaraBayar() {
        $query = $this->db->query("
            SELECT
            `mcb_id` AS kode,
             `mcb_nama` AS nama
            FROM `mst_cara_bayar`
            WHERE `mcb_isaktif` = '1'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    function createNoAntrian($poli, $tgl) {
        $query = $this->db->query("
            SELECT max(`tkunj_no_antrian`) antrian
            FROM `trans_kunjungan`
            WHERE `mpoli_id` = '$poli'
            AND DATE_FORMAT(`tkunj_tanggal`, '%d-%m-%Y') = '$tgl'
            ");
        if ($query->num_rows() > 0) {
            $no = $query->row()->antrian;
            if (!empty($no)) {
                return $no++;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    /*
     * simpan transaksi
     */

    function simpanData($data) {
        $result = array(
            'status' => FALSE,
            'idTrans' => NULL
        );
        if (!empty($data['tkunj_id'])) {
//            $this->db->set('k1_last_update', 'now()', FALSE);
            $this->db->where('tkunj_id', $data['tkunj_id']);
            $this->db->update('trans_kunjungan', $data);
        } else {
//            $this->db->set('k1_last_update', 'now()', FALSE);
            $noAntrian = $this->createNoAntrian($data['mpoli_id'], $data['tkunj_tanggal']);
            $this->db->set('tkunj_no_antrian', $noAntrian);
            $this->db->set('tkunj_status_ambil', '0');
            $this->db->insert('trans_kunjungan', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['tkunj_id'])) {
                $result['idTrans'] = $data['tkunj_id'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(tkunj_id) id FROM trans_kunjungan
                ");
                if ($querySelect->num_rows() > 0) {
                    $result['idTrans'] = $querySelect->row()->id;
                }
            }
        }
        return $result;
    }

    /*
     * mengambil data limit
     */

    function dataKunjunganByFilter($poli, $noRM, $nama) {
        $addWhere = '';
        if (!empty($poli)) {
            $addWhere .= " AND trans_kunjungan.`mpoli_id` = '$poli'";
        }
        if (!empty($noRM)) {
            $addWhere .= " AND trans_kunjungan.`mpas_id` = '$noRM'";
        }
        if (!empty($nama)) {
            $addWhere .= " AND mst_pasien.`mpas_nama` like '%$nama%' ";
        }
        $query = $this->db->query("
           SELECT
            trans_kunjungan.`tkunj_id`,
            trans_kunjungan.`mpas_id`,
            trans_kunjungan.`mpoli_id`,
            trans_kunjungan.`tkunj_no_antrian`,
            DATE_FORMAT(trans_kunjungan.`tkunj_tanggal`, '%d-%m-%Y') AS tkunj_tanggal,
            trans_kunjungan.`tkunj_no_antrian`,
            trans_kunjungan.`mdok_id`,
            trans_kunjungan.`mcb_id`,
            trans_kunjungan.`tkunj_no_peserta`,
            trans_kunjungan.`tkunj_keterangan`,
            DATE_FORMAT(mst_pasien.`mpas_tanggal_lahir`, '%d-%m-%Y') AS tanggal_lahir,
            mst_pasien.*,
            mst_poli.*
            FROM trans_kunjungan
            LEFT JOIN mst_pasien ON mst_pasien.`mpas_id` = trans_kunjungan.`mpas_id`
            LEFT JOIN mst_poli ON mst_poli.mpoli_id = trans_kunjungan.mpoli_id
            WHERE 1
            $addWhere
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    /*
     * mengambil data by id
     */

    function dataKunjunganById($id) {
        $query = $this->db->query("
            SELECT
            trans_kunjungan.`tkunj_id`,
            trans_kunjungan.`mpas_id`,
            trans_kunjungan.`mpoli_id`,
            trans_kunjungan.`tkunj_no_antrian`,
            DATE_FORMAT(trans_kunjungan.`tkunj_tanggal`, '%d-%m-%Y') AS tkunj_tanggal,
            trans_kunjungan.`tkunj_no_antrian`,
            trans_kunjungan.`mdok_id`,
            trans_kunjungan.`mcb_id`,
            trans_kunjungan.`tkunj_no_peserta`,
            trans_kunjungan.`tkunj_keterangan`,
            DATE_FORMAT(mst_pasien.`mpas_tanggal_lahir`, '%d-%m-%Y') AS tanggal_lahir,
            mst_pasien.*
            FROM trans_kunjungan
            LEFT JOIN mst_pasien ON mst_pasien.`mpas_id` = trans_kunjungan.`mpas_id`
            WHERE trans_kunjungan.`tkunj_id` = '$id'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}
