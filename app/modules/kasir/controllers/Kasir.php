<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Kasir extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->alus_auth->logged_in())
		{
			redirect('admin/Login','refresh');
		}
		//$this->load->model('Dashboard_model','model');
	}


	public function index()
	{

		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Beranda";

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/index.php');
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	public function transaksi()
	{

		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Transaksi Baru";

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/transaksi.php');
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	public function cari_produk()
	{

		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Cari Produk";

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/cari_produk.php');
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	public function login_kasir()
	{

		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Cari Produk";

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/login_kasir.php');
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	function error404()
	{
		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Ups Page Not Found";

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('template/temaalus/404');
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}


	function cari_data($content){
		$cari = $this->alus_auth->stok_like($content);
		$temp = array();
		$status = FALSE;
		if($cari[0] >= 1){
			$status = TRUE;
			foreach ($cari[1] as $key => $value) {
			$cek = $this->alus_auth->cek_kadaluarsa($value->tb_tgl_kadaluarsa);
				if($cek != 'kd'){
					$temp[] = array(
						"nama" => $value->mo_nama,
						"tgl_kadaluarsa" => $value->tb_tgl_kadaluarsa,
						"stok" => $value->stok,
						"harga" => $value->tb_harga_jual,
						"tb_id" => $value->tb_id,
						"mo_id" => $value->mo_id
					);
				}
			}
		}
		$arr = array('status' => $status, 'data' => $temp);
		echo json_encode($arr);
	}
		
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */