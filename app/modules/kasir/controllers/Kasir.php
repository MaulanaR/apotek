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
		
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */