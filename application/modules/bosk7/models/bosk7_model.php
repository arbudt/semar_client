<?php

class Bosk7_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * simpan transaksi
     */

    function simpanData($data) {
        $result = array(
            'status' => FALSE,
            'idTrans' => NULL
        );
        if (!empty($data['k7_code'])) {
            $this->db->set('k7_last_update', 'now()', FALSE);
            $this->db->where('k7_code', $data['k7_code']);
            $this->db->update('trans_k7', $data);
        } else {
            $this->db->set('k7_last_update', 'now()', FALSE);
            $this->db->insert('trans_k7', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['k7_code'])) {
                $result['idTrans'] = $data['k7_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(k7_code) id FROM trans_k7    
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

    function dataTransByFilter($tahun, $triwulan) {
        $query = $this->db->query("
            SELECT 
            A.k7_code ID_TRANS,
            A.k7_tahun_code KODE_TAHUN,
            A.k7_triwulan_code KODE_TRIWULAN,
            B.triwulan_name NAMA_TRIWULAN,
            A.k7_uraian URAIAN,
            A.k7_no_kode NO_KODE,
            A.k7_sumber_dana_bos KODE_DANA_BOS,
            A.k7_jumlah_dana_bos JUMLAH_DANA_BOS,
            A.k7_sumber_dana_pendapatan_sekolah KODE_PENDAPATAN_SEKOLAH,
            A.k7_jumlah_dana_pendapatan_sekolah JUMLAH_PENDAPATAN_SEKOLAH,
            A.k7_sumber_dana_pendapatan_lain KODE_PENDAPATAN_LAIN,
            A.k7_jumlah_dana_pendapatan_lain JUMLAH_PENDAPATAN_LAIN,
            A.k7_jumlah_bantuan_lain JUMLAH_BANTUAN_LAIN,
            (A.k7_jumlah_dana_bos + A.k7_jumlah_dana_pendapatan_sekolah + A.k7_jumlah_dana_pendapatan_lain + A.k7_jumlah_bantuan_lain) TOTAL_DANA
            FROM trans_k7 A
            JOIN master_triwulan B ON B.triwulan_code = A.k7_triwulan_code
            WHERE A.k7_tahun_code = '$tahun'
            AND A.k7_triwulan_code = '$triwulan'
            AND A.k7_status = 0
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    /*
     * mengambil transaksi by id transaksi
     */

    function dataTransById($idTrans) {
        $query = $this->db->query("
            SELECT 
            A.k7_code ID_TRANS,
            A.k7_tahun_code KODE_TAHUN,
            A.k7_triwulan_code KODE_TRIWULAN,
            A.k7_sumber_dana_bos KODE_SUMBER_BOS,
            A.k7_jumlah_dana_bos JUMLAH_DANA_BOS,
            A.k7_sumber_dana_pendapatan_sekolah KODE_SUMBER_PENDAPATAN_SEKOLAH,
            A.k7_jumlah_dana_pendapatan_sekolah JUMLAH_PENDAPATAN_SEKOLAH,
            A.k7_sumber_dana_pendapatan_lain KODE_SUMBER_PENDAPATAN_LAIN,
            A.k7_jumlah_dana_pendapatan_lain JUMLAH_PENDAPATAN_LAIN,
            A.k7_jumlah_bantuan_lain JUMLAH_BANTUAN_LAIN,
            A.k7_no_kode NO_KODE,
            A.k7_uraian URAIAN,
                (A.k7_jumlah_dana_bos + A.k7_jumlah_dana_pendapatan_sekolah + A.k7_jumlah_dana_pendapatan_lain + A.k7_no_kode) TOTAL_DANA
            FROM trans_k7 A
            WHERE A.k7_code = '$idTrans'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}

?>
