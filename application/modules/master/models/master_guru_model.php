<?php

class Master_guru_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * mengambil data guru yang aktif
     */

    function dataGuruAll() {
        $query = $this->db->query("
            SELECT
            guru_code AS ID_GURU,
            guru_name AS NAMA_GURU,
            CASE WHEN UPPER(guru_gender) = 'L' THEN 'Laki-Laki' ELSE 'Perempuan' END JENIS_KELAMIN,
            guru_addres AS ALAMAT,
            guru_job AS TUGAS,
            CASE WHEN guru_aktif = '1' THEN 'Aktif' ELSE 'Tidak Aktif' END STATUS_AKTIF
            FROM master_guru
            ORDER BY guru_name asc
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
        if (!empty($data['guru_code'])) {
            $this->db->set('guru_last_update', 'now()', FALSE);
            $this->db->where('guru_code', $data['guru_code']);
            $this->db->update('master_guru', $data);
        } else {
            $this->db->set('guru_last_update', 'now()', FALSE);
            $this->db->insert('master_guru', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['guru_code'])) {
                $result['idGuru'] = $data['guru_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(guru_code) id FROM master_guru
                ");
                if ($querySelect->num_rows() > 0) {
                    $result['idGuru'] = $querySelect->row()->id;
                }
            }
        }
        return $result;
    }

    /*
     * mengambil transaksi by id transaksi
     */

    function dataTransById($idGuru) {
        $query = $this->db->query("
            SELECT
            guru_code AS ID_GURU,
            guru_name AS NAMA_GURU,
            guru_gender AS JENIS_KELAMIN,
            guru_addres AS ALAMAT,
            guru_job AS TUGAS,
            guru_aktif AS STATUS_AKTIF
            FROM master_guru
            WHERE guru_code = '$idGuru'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}
?>
