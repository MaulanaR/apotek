<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
 */
class Obat extends CI_Controller
{

	private $privilege;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Obat_model', 'model');
		$this->load->model('Unit_model', 'unit');
		$this->load->model('Kategori_obat_model', 'kategori');
		$this->load->model('Stok_model', 'stok');
		$this->load->model('Suppliers_model', 'supplier');

		if (!$this->alus_auth->logged_in()) {
			redirect('admin/Login', 'refresh');
		}
		$this->privilege = $this->Alus_hmvc->cek_privilege($this->uri->segment(1));
		if ($this->privilege['can_view'] == '0') {
			echo "<script type='text/javascript'>alert('You dont have permission to access this menu');</script>";
			redirect('dashboard', 'refresh');
		}
	}

	public function index()
	{

		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Master Obat-obatan";
			$data['can_add'] = $this->privilege['can_add'];

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('index.php', $data);
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}



	public function save_hak_akses()
	{
		if ($this->privilege['can_edit'] == 0) {
			echo json_encode(array("status" => FALSE, "msg" => "You Dont Have Permission"));
		} else {
			$this->form_validation->set_rules('bot[]', 'Menu', 'required');
			if ($this->form_validation->run() == true) {
				$id_group = $this->input->post('id_group');
				$mlist = $this->input->post('bot');
				$result = array();
				$i = 0;
				$sum = 0;
				foreach ($mlist as $key => $val) {
					if ($val) {
						//delete hak sebelumnya clear all 
						$this->model->del_ga($id_group);
						//buat baru
						$result[] = array(
							"id_group" 	 => $id_group,
							"id_menu" 	 => $_POST['menu'][$val],
							"can_view" 	 => $_POST['canview'][$val],
							"can_edit" 	 => $_POST['canedit'][$val],
							"can_add" 	 => $_POST['canadd'][$val],
							"can_delete" => $_POST['candelete'][$val],
							"psv" 		 => date('Y-m-d H:i:s', strtotime($_POST['psv'][$val])),
							"pev" 		 => date('Y-m-d H:i:s', strtotime($_POST['pev'][$val])),
							"psed" 		 => date('Y-m-d H:i:s', strtotime($_POST['psed'][$val])),
							"peed" 		 => date('Y-m-d H:i:s', strtotime($_POST['peed'][$val]))
						);
					}
				}

				$a = $this->model->upres($result);
				if ($a) {
					echo json_encode(array("status" => TRUE));
				} else {
					echo json_encode(array("status" => FALSE, "msg" => "Gagal update hak akses !"));
				}
			} else {
				echo json_encode(array("status" => FALSE, "msg" => "ERROR[ID NOT FOUND]"));
			}
		}
	}
	/* SERVER SIDE */
	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
	public function ajax_list()
	{
		$list = $this->model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = '<a href="' . base_url('obat/detail') . '/' . $person->mo_id . '">' . $person->mo_nama . '</a>';
			$row[] = $person->mo_deskripsi;
			$row[] = $person->mk_nama;
			$row[] = $person->mo_barcode;
			$row[] = $person->mo_penyimpanan;
			$row[] = $person->mu_nama;
			if ($person->mo_resep == 0) {
				$row[] = "Tanpa Resep";
			} else {
				$row[] =  "Perlu Resep";
			}

			if ($this->privilege['can_edit'] == 1) {
				$row[] = '<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit Obat" onclick="edit_person(' . "'" . $person->mo_id . "'" . ')"><i class="fa fa-pencil-alt"></i></a>';
			} else {
				$row[] = '';
			}

			//input stock
			$row[] = '<a class="btn btn-sm btn-outline-warning" href="' . base_url() . 'obat/input_stock/' . $person->mo_id . '" data-toggle="tooltip" title="Masukan Stok Baru"><i class="fa fa-server"></i></a>';

			if ($this->privilege['can_delete'] == 1) {
				$row[] = '<button type="button" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Hapus Obat" onclick="delete_person(' . "'" . $person->mo_id . "'" . ')"><i class="fa fa-trash"></i></a>';
			} else {
				$row[] = '';
			}

			//add html for action
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->model->count_all(),
			"recordsFiltered" => $this->model->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->model->get_by_id($id);
		echo json_encode($data);
	}


	public function ajax_update()
	{
		if ($this->privilege['can_edit'] == 0) {
			echo json_encode(array("status" => FALSE, "msg" => "You Dont Have Permission"));
		} else {

			$this->form_validation->set_rules('id', 'id', 'required');
			$this->form_validation->set_rules('nama_obat', 'nama obat', 'required');
			$this->form_validation->set_rules('kategori_obat', 'kategori obat', 'required');
			$this->form_validation->set_rules('unit', 'unit', 'required');
			if ($this->input->post('old_barcode') != $this->input->post('barcode')) {
				$this->form_validation->set_rules('barcode', 'barcode', 'required|callback__barcodeunique[barcode]');
			} else {
				$this->form_validation->set_rules('barcode', 'barcode', 'required');
			}

			if ($this->form_validation->run() == true) {
				$data = array(
					'mo_nama' => $this->input->post('nama_obat', true),
					'mo_deskripsi' => $this->input->post('des_obat', true),
					'mo_mk_id' => $this->input->post('kategori_obat', true),
					'mo_barcode' => $this->input->post('barcode', true),
					'mo_penyimpanan' => $this->input->post('penyimpanan', true),
					'mo_mu_id' => $this->input->post('unit', true),
					'mo_resep' => $this->input->post('resep', true),
				);

				$this->model->update(array('mo_id' => $this->input->post('id')), $data);

				echo json_encode(array("status" => TRUE));
			} else {
				echo json_encode(array("status" => FALSE, "msg" => validation_errors()));
			}
		}
	}

	public function ajax_delete($id)
	{
		if ($this->privilege['can_delete'] == 0) {
			echo json_encode(array("status" => FALSE, "msg" => "You Dont Have Permission"));
		} else {
			$this->model->delete_by_id($id);
			echo json_encode(array("status" => TRUE));
		}
	}

	public function ajax_stok_obat_by_id($id)
	{
		$output2 = $this->alus_auth->ajax_stok_obat_by_id($id);
		echo json_encode($output2);
	}

	public function input($idobat = null)
	{
		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Input Obat";
			$data['obat'] = $idobat;

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('index_input.php', $data);
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}

	public function detail($mo_id)
	{

		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Master Obat";
			//$data['tree'] = $this->model->all_tree();
			$data = array();
			$record = $this->model->get_by_id($mo_id);
			$data['can_add'] = $this->privilege['can_add'];
			$data['mo_id'] = $mo_id;
			$data['mo_nama'] = $record->mo_nama;
			$data['mo_barcode'] = $record->mo_barcode;
			$data['mo_penyimpanan'] = $record->mo_penyimpanan;

			$dataunit = $this->unit->get_by_id($record->mo_mu_id);
			$data['mu_nama'] = $dataunit->mu_nama;
			$datakategori = $this->kategori->get_by_id($record->mo_mk_id);
			$data['mk_nama'] = $datakategori->mk_nama;
			$data['mo_deskripsi'] = $record->mo_deskripsi;
			$data['mo_picture'] = $record->mo_picture;
			$data['mo_resep'] = $record->mo_resep;

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('Obat/detail.php', $data);
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}

	public function save_obat_new()
	{
		if ($this->privilege['can_add'] == 0) {
			echo json_encode(array("status" => FALSE, "msg" => "You Dont Have Permission"));
		} else {

			$this->form_validation->set_rules('nama_obat', 'nama obat', 'required');
			$this->form_validation->set_rules('kategori_obat', 'kategori obat', 'required');
			$this->form_validation->set_rules('barcode', 'barcode', 'required|callback__barcodeunique[barcode]');
			$this->form_validation->set_rules('unit', 'unit', 'required');

			if ($this->form_validation->run() == true) {
				$data = array(
					'mo_nama' => $this->input->post('nama_obat', true),
					'mo_deskripsi' => $this->input->post('des_obat', true),
					'mo_mk_id' => $this->input->post('kategori_obat', true),
					'mo_barcode' => $this->input->post('barcode', true),
					'mo_penyimpanan' => $this->input->post('penyimpanan', true),
					'mo_mu_id' => $this->input->post('unit', true),
					'mo_resep' => $this->input->post('resep', true),
				);

				//cek barcode ada sama?
				$this->model->save($data);

				echo json_encode(array("status" => TRUE));
			} else {
				echo json_encode(array("status" => FALSE, "msg" => validation_errors()));
			}
		}
	}

	public function get_barcode()
	{
		echo json_encode($this->alus_auth->get_code('SN-BARCODE'));
	}

	function _barcodeunique($barcode)
	{
		$arr = array();
		$this->db->where('mo_barcode', $barcode);
		$cek = $this->db->get('m_obat');
		if ($cek->num_rows() > 0) {
			$this->form_validation->set_message('_barcodeunique', 'Nomor Barcode sudah digunakan, gunakan nomor lain !');
			return false;
		} else {
			return true;
		}
	}

	public function input_stock($id = null)
	{
		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Input Stock Obat";
			$data['can_add'] = $this->privilege['can_add'];
			$data['id'] = $id;

			//list obat
			$this->db->where('mo_mk_id !=', 3);
			$this->db->join('m_kategori', 'm_kategori.mk_id = m_obat.mo_mk_id', 'left');
			$this->db->join('m_unit', 'm_unit.mu_id = m_obat.mo_mu_id', 'left');

			$data['list_obat'] = $this->db->get('m_obat');
			//end list

			//list suplliers
			$data['list_suppliers'] = $this->db->get('m_supplier');
			//end list

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('index_input_stock.php', $data);
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}

	public function get_batch($id = null)
	{
		$this->db->where('tb_mo_id', $id);
		$batch = $this->db->get('t_batch')->result();

		echo json_encode(array('data' => $batch));
	}

	public function save_stock()
	{
		$baru = $this->input->post('baru');

		$this->form_validation->set_rules('stock', 'stock obat', 'required');
		$this->form_validation->set_rules('id_obat', 'id obat', 'required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
		if($baru == 1)
		{
			$this->form_validation->set_rules('tanggal', 'tanggal' , 'required');
			$this->form_validation->set_rules('supplier', 'supplier' , 'required');
			$this->form_validation->set_rules('harga_beli', 'harga_beli' , 'required');
			$this->form_validation->set_rules('harga_jual', 'harga_jual' , 'required');
		}else{
			$this->form_validation->set_rules('tgl_tersedia', 'Tanggal batch' , 'required');
		}

		if ($this->form_validation->run() == true) {

			if($baru == 0)
			{
				//maka lama
				$id_batch = $this->input->post('tgl_tersedia');
				//input stock ke jurnal
				$stock = array(
					'tj_mo_id' 		=> $this->input->post('id_obat'),
					'tj_tb_id' 		=> $this->input->post('tgl_tersedia'),
					'tj_user_id' 	=> $this->session->userdata('user_id'),
				);
				if($this->input->post('jenis') == 'penambahan'){
					$stock['tj_masuk'] = $this->input->post('stock');
					$stock['tj_keluar'] = 0;
					$stock['tj_keterangan'] = $this->input->post('keterangan');
					;
				}else{
					$stock['tj_masuk'] = 0;
					$stock['tj_keluar'] = $this->input->post('stock');
					$stock['tj_keterangan'] = $this->input->post('keterangan');
					;
				}
					$this->db->insert('t_jurnal', $stock);
			}else{
				//input batch baru
				$data_batch = array(
					'tb_tgl_masuk' 		=> date('Y-m-d'),
					'tb_tgl_kadaluarsa' => date('Y-m-d', strtotime($this->input->post('tanggal'))),
					'tb_mo_id' 			=> $this->input->post('id_obat'),
					'tb_ms_id' 			=> $this->input->post('supplier'),
					'tb_harga_beli' 	=> str_replace(',','',$this->input->post('harga_beli')),
					'tb_harga_jual' 	=> str_replace(',','',$this->input->post('harga_jual')),
				);

				$this->db->insert('t_batch', $data_batch);
				$id_batch = $this->db->insert_id();
				
				$stock = array(
					'tj_mo_id' 		=> $this->input->post('id_obat'),
					'tj_tb_id' 		=> $id_batch,
					'tj_user_id' 	=> $this->session->userdata('user_id'),
				);
					$stock['tj_masuk'] = $this->input->post('stock');
					$stock['tj_keluar'] = 0;
					$stock['tj_keterangan'] = $this->input->post('keterangan');
				
					$this->db->insert('t_jurnal', $stock);
			}
			echo json_encode(array("status" => TRUE));
		} else {
			echo json_encode(array("status" => FALSE, "msg" => validation_errors()));
		}
	}
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */