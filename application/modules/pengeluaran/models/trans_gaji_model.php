<?php

class Trans_gaji_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * mengambil data guru yang aktif
     */

    function dataGuru() {
        $query = $this->db->query("
            SELECT 
            guru_code KODE_GURU,
            guru_name NAMA_GURU,
            CASE WHEN UPPER(guru_gender) = 'L' THEN 'Laki-Laki' ELSE 'Perempuan' END JENIS_KELAMIN,
            guru_addres ALAMAT,
            guru_job TUGAS
            FROM master_guru
            WHERE guru_aktif = 1
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
        if (!empty($data['gaji_code'])) {
            $this->db->set('gaji_last_update', 'now()', FALSE);
            $this->db->where('gaji_code', $data['gaji_code']);
            $this->db->update('trans_gaji', $data);
        } else {
            $this->db->set('gaji_last_update', 'now()', FALSE);
            $this->db->insert('trans_gaji', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['gaji_code'])) {
                $result['idTrans'] = $data['gaji_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(gaji_code) id FROM trans_gaji
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
            A.gaji_code ID_TRANS,
            A.gaji_tahun_code KODE_TAHUN,
            A.gaji_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(A.gaji_date, '%d/%m/%Y') TGL,
            A.guru_code KODE_GURU,
            C.guru_name NAMA_GURU,
            A.gaji_tugas TUGAS,
            A.gaji_price JUMLAH,
            B.triwulan_name NAMA_TRIWULAN
            FROM trans_gaji A
            JOIN master_triwulan B ON B.triwulan_code = A.gaji_triwulan_code
            JOIN master_guru C ON C.guru_code = A.guru_code
            WHERE A.gaji_tahun_code = '$tahun'
            AND A.gaji_triwulan_code = '$triwulan'
            AND A.gaji_status = 0
            ORDER BY A.gaji_date ASC
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
            gaji_code ID_TRANS,
            gaji_tahun_code KODE_TAHUN,
            gaji_triwulan_code KODE_TRIWULAN,
            DATE_FORMAT(gaji_date, '%d-%m-%Y') TGL,
            guru_code KODE_GURU,
            gaji_tugas TUGAS,
            gaji_price JUMLAH
            FROM trans_gaji
            WHERE gaji_code = '$idTrans'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}

?>
