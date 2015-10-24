<?php

class Log_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * insert table log
     */

    function addLogAktivity($modul, $aktifitas, $desc) {
        $this->db->set('log_user_code', $this->userId);
        $this->db->set('log_user_nama', $this->userfullName);
        $this->db->set('log_modul', $modul);
        $this->db->set('log_aktitifas', $aktifitas);
        $this->db->set('log_desc', $desc);
        $this->db->insert('log_aktivity');
    }

    /*
     * mengambil data log
     */

    function dataLogByFilter($tglAwal, $tglAkhir) {
        $tanggalAwal = dateReverse($tglAwal) . ' 00:00:00';
        $tanggalAkhir = dateReverse($tglAkhir) . ' 23:59:59';
        $query = $this->db->query("
            SELECT
            log_kode AS KODE_LOG,
            log_user_code AS KODE_USER,
            log_user_nama AS NAMA_USER,
            DATE_FORMAT(log_date, '%d/%m/%Y %h:%i') WAKTU,
            log_modul AS MODUL,
            log_aktitifas AS AKTIFITAS,
            log_desc AS KETERANGAN
            FROM log_aktivity
            WHERE log_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir'
            ORDER BY log_date DESC
            ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

}
?>
