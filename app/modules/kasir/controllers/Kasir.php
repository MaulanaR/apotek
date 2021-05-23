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

	public function end_sesi()
	{
		if(!empty($this->session->userdata('id_sesi')))
		{
			$this->session->unset_userdata('id_sesi');
			$this->session->unset_userdata('sesi_saldo');
			return true;
		}else{
			
			return true;
		}
	}

	public function index()
	{

		if($this->alus_auth->logged_in())
         {
			if( empty($this->session->userdata('id_sesi')))
			{
				redirect(base_url('kasir/login_kasir'));
			}

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
		if( empty($this->session->userdata('id_sesi')))
		{
			redirect(base_url('kasir/login_kasir'));
		}

		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Transaksi Baru";
         	$data['uniqid'] = $this->alus_auth->generateUniqueId(8);

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/transaksi.php', $data);
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
			if( !empty($this->session->userdata('id_sesi')))
			{
				redirect(base_url('kasir'));
			}

         	$head['title'] = "Login Kasir POS";

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/login_kasir.php');
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	public function cek_login()
	{
		if($this->input->post('pass') == '')
		{
			echo json_encode(['status' => false, 'msg' => "Password harus diisi"]);
			die();
		}
		if($this->input->post('saldo') == '')
		{
			echo json_encode(['status' => false, 'msg' => "Saldo tidak boleh kurang dari Rp.1,000"]);
			die();
		}

		//cek password
		if($this->alus_auth->hash_password_db($this->session->userdata('user_id'), $this->input->post('pass')) === TRUE)
		{
			if(str_replace(',','',$this->input->post('saldo')) < 1000)
			{
				echo json_encode(['status' => false, 'msg' => "Saldo tidak boleh kurang dari Rp.1,000"]);
				die();
			}

			//save sesi
			$data = array(
				'tsu_user_id' 		=> $this->session->userdata('user_id'),
				'tsu_saldo_awal' 	=> str_replace(',','',$this->input->post('saldo')),
				'tsu_jam_masuk' 	=> date('Y-m-d H:i:S'),
			);
			$this->db->insert('t_sesi_user', $data);
			$id_sesi = $this->db->insert_id();
			
			$data_session = array(
				'id_sesi' 			=> $id_sesi,
				'sesi_saldo'	 	=> str_replace(',','',$this->input->post('saldo'))
			);

			$this->session->set_userdata($data_session);
			
			echo json_encode(['status' => true, 'msg' => "Selamat Bekerja"]);
			die();
		}else{
			echo json_encode(['status' => false, 'msg' => "Password salah"]);
			die();
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
		$cari = $this->alus_auth->stok_like($content, FALSE);
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

	function ajax_checkout(){
		$success = FALSE;
		$arr = array();
		if(isset($_POST['data'])){
			$success = TRUE;
			$i = 0;
			foreach ($_POST['data'] as $key => $value) {
					$cek = $this->alus_auth->cek_stok($value['mo_id'], $value['tb_id'], $value['jumlah']);
					$arr[] = array("nama"=>$value['nama'], "statusitem"=>$cek['status'], "stok" => $cek['stok']);
				}	
		}
		$response = array("status" => $success, "data" => $arr);
		echo json_encode($response);
	}		
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */