<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rekammedis_client_model
 *
 * @author ziaha
 */
class Rekammedis_client_model extends MY_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function get($no_rm) {
        $q = $this->db->from('trans_diagnosa')
                        ->join('trans_kunjungan', 'trans_diagnosa.tkunj_id = trans_kunjungan.tkunj_id', 'left')
                        ->join('mst_pasien', 'trans_diagnosa.mpas_id = mst_pasien.mpas_id', 'left')
                        ->join('mst_poli', 'trans_kunjungan.mpoli_id = mst_poli.mpoli_id')
                        ->where('trans_diagnosa.mpas_id', $no_rm)
                        ->select("trans_diagnosa.tdiag_nama, mst_poli.mpoli_nama, DATE_FORMAT(trans_kunjungan.tkunj_tanggal,'%d-%m-%Y') tkunj_tanggal, mst_pasien.mpas_nama")
                        ->get();
        return $q->num_rows() > 0 ? $q->result() : null;
    }

    public function getData($noRm) {
        $query = $this->db->query("
            SELECT
            trans_diagnosa.tdiag_nama AS diagnosa,
            mst_poli.mpoli_nama AS nama_poli,
            DATE_FORMAT(trans_kunjungan.tkunj_tanggal,'%d-%m-%Y') tanggal,
            'RSUD Jogja' AS nama_rs
            FROM trans_diagnosa
            LEFT JOIN trans_kunjungan ON trans_kunjungan.tkunj_id = trans_diagnosa .tkunj_id
            LEFT JOIN mst_pasien ON mst_pasien.mpas_id = trans_diagnosa .mpas_id
            LEFT JOIN mst_poli ON mst_poli.mpoli_id = trans_kunjungan .mpoli_id
            WHERE trans_diagnosa.mpas_id = '$noRm'
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

}
