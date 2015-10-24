<?php

class Master_user_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function dataGroupUser() {
        $query = $this->db->query("
        SELECT
        group_code AS KODE,
        group_name AS NAMA
        FROM master_group
        WHERE group_aktif = '1'
        ORDER BY group_name ASC 
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    /*
     * mengambil data guru yang aktif
     */

    function dataUserAll() {
        $query = $this->db->query("
            SELECT
            user_code AS ID_USER,
            user_fullname AS NAMA_LENGKAP,
            user_nickname AS NAMA_PANGGILAN,
            group_name AS GROUP_USER,
            user_username AS USERNAME,
            user_password AS PASSWORD,
            user_aktif AS STATUS_AKTIF
            FROM master_user
            LEFT JOIN master_group ON master_group .group_code = master_user.user_group
            ORDER BY user_fullname ASC
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
            'idUser' => NULL
        );

        if (!empty($data['user_code'])) {
            unset($data['user_username']); //username tidak diupdate
            unset($data['user_password']); //password tidak diupdate
            $this->db->set('user_last_update', 'now()', FALSE);
            $this->db->where('user_code', $data['user_code']);
            $this->db->update('master_user', $data);
        } else {
            $this->db->set('user_last_update', 'now()', FALSE);
            $this->db->insert('master_user', $data);
        }
        if ($this->db->affected_rows() > 0) {
            $result['status'] = TRUE;
            if (!empty($data['user_code'])) {
                $result['idUser'] = $data['user_code'];
            } else {
                $querySelect = $this->db->query("
                SELECT max(user_code) id FROM master_user
                ");
                if ($querySelect->num_rows() > 0) {
                    $result['idUser'] = $querySelect->row()->id;
                }
            }
        }
        return $result;
    }

    /*
     * mengambil transaksi by id transaksi
     */

    function dataTransById($idUser) {
        $query = $this->db->query("
            SELECT
            user_code AS ID_USER,
            user_fullname AS NAMA_LENGKAP,
            user_nickname AS NAMA_PANGGILAN,
            user_group AS GROUP_USER,
            user_username AS USERNAME,
            user_password AS PASSWORD,
            user_aktif AS STATUS_AKTIF
            FROM master_user
            WHERE user_code = '$idUser'
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

}
?>
