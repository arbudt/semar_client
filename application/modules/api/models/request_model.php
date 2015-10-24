<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	private function getDataPenunjang($noreg,$nomr)
	{
		$query = "SELECT
						TWP.TWPEN_ID,
						TWP.TRANS_KUNJ_PASIEN_TKPAS_ID,
						TDWP.TDWPEN_ID,
						THKL.THKLAB_ID
					FROM TRANS_WO_PENUNJANG TWP
					LEFT JOIN TRANS_DET_WO_PENUNJANG TDWP ON TDWP.TRANS_WO_PENUNJANG_TWPEN_ID = TWP.TWPEN_ID
					LEFT JOIN TRANS_HASIL_KRITIS_LAB THKL ON THKL.TR_DET_WO_PNJNG_TDWPEN_ID = TDWP.TDWPEN_ID
					WHERE TWP.TWPEN_NOMR = '$nomr' AND TWP.TWPEN_NOREG_TUJUAN = '$noreg'";
		$result = $this->db->query( $query ) -> row();
		return $result;
	}

	public function updateHasilKritis( $post )
	{
		$var = $this->getTHKLId( $post['noreg'], $post['nomr'] );
		if( $var )
		{
			$this->db->trans_begin();
			$this->db->set("TO_DATE(THKLAB_INSERTDATE,'DD-MM-YYYY HH24:MI:SS')", $post['tanggal'].':00', FALSE);
			$this->db->set('THKLAB_KETERANGAN', $post['keterangan']);
			$this->db->where('THKLAB_ID', $var['THKLAB_ID']);
			$update = $this->db->update('TRANS_HASIL_KRITIS_LAB');
		}
	}
}