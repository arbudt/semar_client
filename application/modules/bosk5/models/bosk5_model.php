<?php

class Bosk5_model extends MY_Model {

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
        if (!empty($data['k5_code'])) {
            $this->db->set('k5_last_update', 'now()', FALSE);
            $this->db->where('k5_code', $data['k5_code']);
            $this->db->update('trans_k5', $data);
        } else {
            $this->db->set('k5_last_update', 'now()', FALSE);
            $this->db->insert('trans_k5', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['k5_code'])) {
                $result['idTrans'] = $data['k5_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(k5_code) id FROM trans_k5
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
            A.k5_code ID_TRANS,
            A.k5_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(A.k5_date, '%d/%m/%Y') TGL,
            A.k5_no_bukti NO_BUKTI,
            A.k5_no_kode NO_KODE,
            A.k5_uraian URAIAN,
            A.k5_price JUMLAH_PENGELUARAN,
            B.triwulan_name NAMA_TRIWULAN
            FROM trans_k5 A
            JOIN master_triwulan B ON B.triwulan_code = A.k5_triwulan_code
            WHERE A.k5_tahun_code = '$tahun'
            AND A.k5_triwulan_code = '$triwulan'
            AND A.k5_status = 0
            ORDER BY A.k5_date ASC
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
            k5_code ID_TRANS,
            k5_tahun_code KODE_TAHUN,
            k5_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(k5_date, '%d-%m-%Y') TGL,
            k5_no_bukti NO_BUKTI,
            k5_no_kode NO_KODE,
            k5_uraian URAIAN,
            k5_price JUMLAH_PENGELUARAN
            FROM trans_k5
            WHERE k5_code = '$idTrans'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}

?>
