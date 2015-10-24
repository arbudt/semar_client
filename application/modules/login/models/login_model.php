<?php

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function cekLogin($username, $password) {
        $query = $this->db->get_where('master_user', array('user_username' => $username, 'user_password' => $password));
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return NULL;
        }
    }

    /*
     * ambil previlages
     */

    function getPrevilages($userId) {
        $query = $this->db->query("
            SELECT 
            AA.menu_code kode_parent,
            AA.menu_name name_parent,
            BB.menu_code kode_menu,
            BB.menu_name,
            BB.menu_url,
            BB.menu_parent    
            FROM master_menu AA
            LEFT JOIN (
                        SELECT
                        A.menu_code,
                        A.menu_name,
                        A.menu_url,
                        A.menu_parent
                        FROM master_menu A
                        JOIN master_previlage B ON B.menu_code = A.menu_code
                        WHERE B.group_code = '$userId'
                        AND A.menu_aktif = '1'
                        AND A.menu_parent != 0

            ) BB ON BB.menu_parent = AA.menu_code
            WHERE AA.menu_parent = 0
            ORDER BY AA.menu_code, BB.menu_code ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }

}
?>
