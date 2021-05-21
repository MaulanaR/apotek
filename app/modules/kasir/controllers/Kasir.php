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
		$this->load->model('Kasir_model','model');
	}

	public function start_sesi()
	{
		if($this->session->userdata('sesi_saldo')){
			// do something when exist
			return true;
	   }else{
		   // do something when doesn't exist
		   $this->session->set_userdata('sesi_saldo', '1000000');
	   }
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
         	$head['title'] = "Cari Produk";

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/login_kasir.php');
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	public function invoice_detail()
	{

		if($this->alus_auth->logged_in())
         {
         	$arrayItem = array();
         	$kode_inv = basename($_SERVER['REQUEST_URI']);
         	$record = $this->model->get_by_kode($kode_inv);
         	$data['kode_inv'] = $kode_inv;
         	$data['tgl'] = $record->ti_tgl;
         	$data['subtotal'] = $this->alus_auth->rupiahrp($record->ti_subtotal);
         	$data['ppn_nilai'] = $this->alus_auth->rupiahrp($record->ti_ppn_nilai);
         	$data['nominal_bayar'] = $this->alus_auth->rupiahrp($record->ti_nominal_bayar);
         	$data['nominal_kembalian'] = $this->alus_auth->rupiahrp($record->ti_nominal_kembalian);
         	$data['user_id'] = $record->ti_user_id;
         	$data['grandtotal'] = $this->alus_auth->rupiahrp($record->ti_grandtotal);
         	$data['id'] = $record->ti_id;

         	$this->db->select('username, job_title');
			$this->db->from('alus_u');
			$this->db->where('id', $this->alus_auth->get_user_id());
			$query = $this->db->get();
			$userdata = $query->row();
			$data['username'] = $userdata->username;
			$data['job'] = $userdata->job_title;

         	$head['title'] = "Invoice ".$kode_inv;
		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/invoice_detail.php', $data);
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

	function ajax_detail_items(){
		$id = $_POST['id'];
		$status = false;
		if(isset($id)){
		$status = true;
		$this->db->select('tid_mo_id, tid_qty, tid_harga_satuan, tid_total, mo_nama, mo_barcode, mo_deskripsi', FALSE);
		$this->db->from('t_invoice_detail');
		$this->db->join('m_obat', 'm_obat.mo_id = t_invoice_detail.tid_mo_id', 'inner');
		$this->db->where('tid_ti_id', $id);
		$query2 = $this->db->get();
		$data = $query2->result();
		$temp = array();
			foreach ($data as $itemdata) {
					$temp[] = array(
						'qty' => $itemdata->tid_qty,
						'nama' => $itemdata->mo_nama, 
						'barcode' => $itemdata->mo_barcode, 
						'deskripsi' => $itemdata->mo_deskripsi, 
						'harga' => $itemdata->tid_harga_satuan, 
						'total' => $itemdata->tid_total
					);
				
			}
		$arr = $temp;
		}
		echo json_encode(array('status' => $status, 'data' => $arr));
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

	function save_transaksi(){
		$success = FALSE;
		$sesi_saldo = $this->alus_auth->get_sesi_saldo();
		$jumlahBarang = 0;
		$arr = array();
		if(isset($_POST['data'])){
			$data = json_decode( html_entity_decode( stripslashes ($_POST['data']) ) );
			$item = json_decode( html_entity_decode( stripslashes ($_POST['item']) ) );
			if($data->nominal_kembalian <= $sesi_saldo){//jika saldo mencukupi untuk kembalian

				$success = TRUE;

				$content = array(
					'ti_nomor_inv' => $data->kode_inv,
					'ti_user_id' => $this->alus_auth->get_user_id(),
					'ti_tgl' => date("Y-m-d H:i:s"),
					'ti_subtotal' => $data->subtotal,
					'ti_ppn_nilai' => $data->ppn_nilai,
					'ti_grandtotal' => $data->grandtotal,
					'ti_nominal_bayar' => $data->nominal_bayar,
					'ti_nominal_kembalian' => $data->nominal_kembalian,
				);

				$inv_id = $this->model->save($content);//save ke invoice

				$i = 0;
				foreach ($item as $key => $value) {

						$temp = $jumlahBarang + $value->jumlah;
						$jumlahBarang = $temp;

						$total = $value->harga * $value->jumlah;
						$con = array(
							'tid_ti_id' => $inv_id,
							'tid_mo_id' => $value->mo_id,
							'tid_tb_id' => $value->tb_id,
							'tid_qty' => $value->jumlah,
							'tid_harga_satuan' => $value->harga,
							'tid_total'=> $total,
						);

						$this->model->saveDetail($con);//save item ke detail
					}
				$this->model->update(array('ti_id' => $inv_id), array('ti_total_barang' => $jumlahBarang));//update jumlah barang di invoice

				$msg = "Transaksi Sukses!";
			}else{
				$msg = "Saldo kasir tidak mencukupi!";
			}
		}else{
			$msg = "Ajax error!";
		}
		echo json_encode(array("status" => $success, "msg" => $msg));
	}		
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */