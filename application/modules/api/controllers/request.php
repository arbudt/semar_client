<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request extends CI_Controller
{
	public function __construct(){
		parent::__construct();
	}

	public function pushPelayananPenunjangHasilKritis()
	{
		$tanggal = $this->input->post('tanggal');
		$keterangan = $this->input->post('keterangan');
		$jam_hasil = $this->input->post('jam_hasil');
	}
}