<?php

class Bosk7a_model extends MY_Model {

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
        if (!empty($data['k7a_code'])) {
            $this->db->set('k7a_last_update', 'now()', FALSE);
            $this->db->where('k7a_code', $data['k7a_code']);
            $this->db->update('trans_k7a', $data);
        } else {
            $this->db->set('k7a_last_update', 'now()', FALSE);
            $this->db->insert('trans_k7a', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['k7a_code'])) {
                $result['idTrans'] = $data['k7a_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(k7a_code) id FROM trans_k7a
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

    function dataFilterLimit($filter, $offset, $limit) {
        $strQuery = "
        SELECT 
        A.k7a_code ID_TRANS,
        A.k7a_triwulan_code KODE_TRIWULAN,
        DATE_FORMAT(A.k7a_date, '%d/%m/%Y') TGL,
        A.k7a_no_urut NO_URUT,
        A.k7a_program PROGRAM_KEGIATAN,
        A.k7a_uraian URAIAN_PENGGUNAAN,
        A.k7a_price JUMLAH,
        B.triwulan_name NAMA_TRIWULAN
        FROM trans_k7a A
        JOIN master_triwulan B ON B.triwulan_code = A.k7a_triwulan_code
        WHERE A.k7a_triwulan_code = '" . $filter['triwulan'] . "'
        AND A.k7a_status = 0
        ";
        $query = $this->db->query("
            $strQuery
            LIMIT $offset, $limit    
        ");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query2 = $this->db->query("
                $strQuery   
            ");
            $jumlahData = $query2->num_rows();
            $result = array(
                'data' => $data,
                'countAll' => $jumlahData
            );
            return $result;
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
            k7a_code ID_TRANS,
            k7a_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(k7a_date, '%d-%m-%Y') TGL,
            k7a_no_urut NO_URUT,
            k7a_program PROGRAM_KEGIATAN,
            k7a_uraian URAIAN_PENGGUNAAN,
            k7a_price JUMLAH
            FROM trans_k7a
            WHERE k7a_code = '$idTrans'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}

?>
