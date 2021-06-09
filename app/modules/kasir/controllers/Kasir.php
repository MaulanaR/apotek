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

	public function end_sesi()
	{
		if(!empty($this->session->userdata('id_sesi')))
		{
			//save ke db updatenya 
			$saldo_sekarang = $this->alus_auth->get_sesi_saldo();
			$update = array(
				'tsu_saldo_akhir' 	=> $saldo_sekarang,
				'tsu_jam_keluar'	=> date('Y-m-d H:i:s')
			);
			$this->db->where('tsu_id', $this->session->userdata('id_sesi'));
			$this->db->update('t_sesi_user', $update);
			
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

			$this->alus_auth->get_sesi_saldo();
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

		$this->alus_auth->get_sesi_saldo();
		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Transaksi Baru";
         	$a = FALSE;
         	do{
         		$b = $this->alus_auth->generateUniqueId(8);
         		$cek = $this->model->cek_nomor_inv($b);
         		if($cek > 0) $a = TRUE;//jika ada, akan diulang kembali
         	}while($a);
         	
         	$data['uniqid'] = $b;

         	$this->db->from("m_akun_bank");
	        if($this->db->count_all_results() > 0){$s = TRUE;}else{$s = FALSE;}
	        $data['avail_rek'] = $s;
		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/transaksi.php', $data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	public function transaksi_resep()
	{
		if( empty($this->session->userdata('id_sesi')))
		{
			redirect(base_url('kasir/login_kasir'));
		}

		$this->alus_auth->get_sesi_saldo();
		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Tebus Resep";
         	$a = FALSE;
         	do{
         		$b = $this->alus_auth->generateUniqueId(8);
         		$cek = $this->model->cek_nomor_inv($b);
         		if($cek > 0) $a = TRUE;//jika ada, akan diulang kembali
         	}while($a);
         	
         	$data['uniqid'] = $b;

         	$this->db->from("m_akun_bank");
	        if($this->db->count_all_results() > 0){$s = TRUE;}else{$s = FALSE;}
	        $data['avail_rek'] = $s;

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('kasir/transaksi_resep.php', $data);
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
         	$x = $this->alus_auth->tipePembayaran('translate', $record->ti_tipe_pembayaran);
         	$data['tipe_pembayaran'] = $x;
         	$y = $record->ti_no_ref_pembayaran;
         	if($y){
         		$data['no_ref'] = $y;
         	}else{
         		$data['no_ref'] = ' - ';
         	}

         	$data['id'] = $record->ti_id;
         	$data['resep'] = $record->ti_resep;

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

	function cari_data_resep($content){
		$cari = $this->alus_auth->stok_like($content, TRUE);
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

	function cari_data_invoice($uniqid){
		$status = FALSE;
		if($uniqid != ""){
			$cari = $this->model->cek_nomor_inv($uniqid);
			if($cari >= 1 ){
				$status = TRUE;
				$msg = "Success";
			}else{
				$msg = "Invoice tidak ditemukan!";
			}
		}else{
			$msg = "Ajax error!";
		}
		$arr = array('status' => $status, 'msg' => $msg);
		echo json_encode($arr);
	}

	function ajax_transaksi_sesi(){
		$sesi_id = $this->session->userdata('id_sesi');
		$status = false;
		$c = 0;
		if(isset($sesi_id)){
			$status = true;
			$this->db->select('tsud_no_inv, ti_id, ti_total_barang, ti_grandtotal', FALSE);
			$this->db->from('t_sesi_user_detail');
			$this->db->join('t_invoice', 't_invoice.ti_nomor_inv = t_sesi_user_detail.tsud_no_inv', 'left');
			$this->db->where('tsud_tsu_id', $sesi_id);
			$query = $this->db->get();
			$data = $query->result();
			$temp = array();
			foreach ($data as $item) {
				$c++;
				$row = array();
				$row[] = $item->ti_id;
				$row[] = $item->tsud_no_inv;
				$row[] = $item->ti_total_barang;
				$row[] = $item->ti_grandtotal;
				$row[] = '<a href="'.base_url('kasir/invoice_detail/'.$item->tsud_no_inv).'" rel="noopener" class="btn btn-default"><i class="fas fa-print"></i></a>';

				$temp[] = $row;
			}
			$recordsTotal = $c;
			$recordsFiltered = $query->num_rows();

		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => $temp,
		);

		echo json_encode($output);
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
					'ti_tipe_pembayaran' => $data->tipe_pembayaran,
					'ti_no_ref_pembayaran' => $data->no_ref_pembayaran,
					'ti_mab_id' => $data->mab_id,
					'ti_resep' => $data->resep,
					'ti_resep_penerbit' => $data->penerbit,
					'ti_resep_dokter' => $data->dokter,
					'ti_resep_tgl' => $data->resep_tgl,
					'ti_resep_ma_id' => $data->ma_id,
				);

				$inv_id = $this->model->save($content);//save ke invoice

				foreach ($item as $key => $value) {

						$temp = $jumlahBarang + $value->jumlah;
						$jumlahBarang = $temp;//hitung jumlah item

						$total = $value->harga * $value->jumlah;//hitung total per item
						$con = array(
							'tid_ti_id' => $inv_id,
							'tid_mo_id' => $value->mo_id,
							'tid_tb_id' => $value->tb_id,
							'tid_qty' => $value->jumlah,
							'tid_harga_satuan' => $value->harga,
							'tid_total'=> $total,
						);
						$this->model->saveDetail($con);//save item ke detail

						$arrayItem = array(
							'tj_ti_id' => $inv_id, 
							'tj_mo_id' => $value->mo_id, 
							'tj_tb_id' => $value->tb_id,
							'tj_keluar' => $value->jumlah,
							'tj_keterangan' => 'Transaksi pembelian',
						);
						$this->db->insert('t_jurnal', $arrayItem);//Kurangi stok item
					}
				$this->model->update(array('ti_id' => $inv_id), array('ti_total_barang' => $jumlahBarang));//update jumlah barang di invoice
				
				//save ke sesi login kasir
				$data_kasir_save = array(
					'tsud_tsu_id' 	=> $this->session->userdata('id_sesi'),
					'tsud_no_inv' 	=> $data->kode_inv,
					'tsud_ti_id' 	=> $inv_id
				);
				$this->db->insert('t_sesi_user_detail', $data_kasir_save);
				
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