<?php

class Pelayanan_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function getAntrianBerikutnyaByPoli($poli, $tgl) {
        $query = $this->db->query("
            SELECT
            MIN(`tkunj_id`) as id_kunj
            FROM `trans_kunjungan`
            WHERE `mpoli_id` = '$poli'
            AND DATE_FORMAT(trans_kunjungan.`tkunj_tanggal`, '%d-%m-%Y') = '$tgl'
            AND `tkunj_status_ambil` <> '1'
            ");
        if ($query->num_rows() > 0) {
            $idKunj = $query->row()->id_kunj;
            $this->db->set('tkunj_status_ambil', '1');
            $this->db->where('tkunj_id', $idKunj);
            $this->db->update('trans_kunjungan');
            return $idKunj;
        } else {
            return NULL;
        }
    }

    function getDataRiwatatByRm($noRm) {
        $query = $this->db->query("
            SELECT
            trans_diagnosa.`tdiag_nama` AS diagnosa,
            DATE_FORMAT(trans_kunjungan.`tkunj_tanggal`, '%d-%m-%Y') AS tanggal,
            mst_poli.mpoli_nama AS nama_poli
            FROM trans_diagnosa
            JOIN trans_kunjungan ON trans_kunjungan.tkunj_id = trans_diagnosa.tkunj_id
            LEFT JOIN mst_poli ON mst_poli.mpoli_id = trans_kunjungan.mpoli_id
            WHERE trans_diagnosa.mpas_id = '$noRm'
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
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
        if (!empty($data['tdiag_id'])) {
            $this->db->set('tdiag_date', 'now()', FALSE);
            $this->db->where('tdiag_id', $data['tdiag_id']);
            $this->db->update('trans_diagnosa', $data);
        } else {
            $this->db->set('tdiag_date', 'now()', FALSE);
            $this->db->insert('trans_diagnosa', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['tdiag_id'])) {
                $result['idTrans'] = $data['tdiag_id'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(tdiag_id) id FROM trans_diagnosa
                ");
                if ($querySelect->num_rows() > 0) {
                    $result['idTrans'] = $querySelect->row()->id;
                }
            }
        }
        return $result;
    }

    /*
     * mengambil data by id
     */

    function dataDiagnosaByIdKunj($id) {
        $query = $this->db->query("
            SELECT * FROM `trans_diagnosa` WHERE `tkunj_id` = '$id'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

    function dataDiagnosaByIdTrans($id) {
        $query = $this->db->query("
            SELECT * FROM `trans_diagnosa` WHERE `tdiag_id` = '$id'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}
