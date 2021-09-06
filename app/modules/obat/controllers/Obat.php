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

	public function expired()
	{

		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Obat Kadaluarsa";
			//$data['can_add'] = $this->privilege['can_add'];

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('expired.php', $data);
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}

	public function deactivated()
	{

		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Obat Nonaktif";
			//$data['can_add'] = $this->privilege['can_add'];

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('deactivated.php', $data);
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
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

	public function ajax_list_kadaluarsa()
	{
		$kd_interval = 10; //interval hari sebelum kadaluarsa
		$status = FALSE;
		$kadaluarsa = FALSE;
		$hampir = FALSE;
		$con = $this->model->get_all_stok_obat();
		$data = array();
		$data2 = array();
		foreach ($con as $record2) {
			$cekkd = $this->alus_auth->cek_kadaluarsa($record2->tb_tgl_kadaluarsa, $kd_interval);
			if ($cekkd->status == 'kd') {
				$status = TRUE;
				$kadaluarsa = TRUE;
				$row2 = array();
				$row2[] = $record2->mo_nama; //0
				$row2[] = $record2->tb_tgl_kadaluarsa; //1
				$row2[] = $record2->stok; //2
				$row2[] = $record2->tb_id; //3
				$sisahari = $cekkd->sisahari;
				$status_kd = $cekkd->status;
				$row2[] = $kadaluarsa; //4
				$row2[] = $sisahari; //5
				$row2[] = $status_kd;
				$row2[] = $record2->mo_id; //7
				$data[] = $row2;
				$msg = 'Ada obat kadaluarsa!';
			} else if ($cekkd->status == 'hr') {
				$hampir = TRUE;
				$row = array();
				$row[] = $record2->mo_nama; //0
				$row[] = $record2->tb_tgl_kadaluarsa; //1
				$row[] = $record2->stok; //2
				$row[] = $record2->tb_id; //3
				$sisahari = $cekkd->sisahari;
				$status_kd = $cekkd->status;
				$row[] = $kadaluarsa; //4
				$row[] = $sisahari; //5
				$row[] = $status_kd; //6
				$row[] = $record2->mo_id; //7
				$data2[] = $row;
			}
		}
		echo json_encode(array('status' => $status, 'statuskd' => $kadaluarsa, 'statushr' => $hampir, 'msg' => $msg, 'datakd' => $data, 'datahr' => $data2));
		//echo json_encode(["status" => true]);
	}

	public function ajax_list_nonaktif()
	{
		$this->db->select('*');
		$this->db->from('t_batch');
		$this->db->join('m_obat', 'm_obat.mo_id = t_batch.tb_mo_id', 'inner');
		$this->db->where('tb_status_kadaluarsa IS NOT TRUE');
		$q = $this->db->get();
		$r = $q->result();
		$num = $q->num_rows();
		$data = array();
		$status = FALSE;
		if ((int)$num > 0) {
			$status = TRUE;
			foreach ($r as $value) {
				$row = array();
				$row[] = $value->mo_id; //0
				$row[] = $value->tb_id; //1
				$row[] = $value->mo_nama; //2
				$row[] = $value->tb_tgl_kadaluarsa; //3
				$data[] = $row;
			}
		}
		echo json_encode(array("status" => $status, "data" => $data));
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

	public function ajax_ubah_status_batch($id)
	{
		$status = FALSE;
		$this->db->select("sum(tj_masuk - tj_keluar) as stok");
		$this->db->from("t_jurnal");
		$this->db->where("tj_tb_id", $id);
		$q = $this->db->get();
		$row = $q->row();
		if ($row->stok === '0') { //doublecheck stok
			$status = TRUE;
			$this->db->select('tb_status_kadaluarsa');
			$this->db->from('t_batch');
			$this->db->where('tb_id', $id);
			$query = $this->db->get();
			$data = $query->row();
			if ($data->tb_status_kadaluarsa == '0') {
				$a = TRUE;
			} else {
				$a = FALSE;
			}
			$this->db->update('t_batch', array('tb_status_kadaluarsa' => $a), array('tb_id' => $id));
		}
		echo json_encode(array("status" => $status));
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
			$data['mo_ppn_10'] = $record->mo_ppn_10;

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('Obat/detail.php', $data);
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}

	public function batch_detail($mo_id)
	{

		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Batch Detail";
			//$data['tree'] = $this->model->all_tree();
			$tb_id = $this->input->get('tbid');
			$data = array();
			$record = $this->stok->get_by_id($mo_id, $tb_id);
			$earliest_batch = $this->get_earliest_batch($tb_id);
			$data['tb_id'] = $tb_id;
			$data['tb_tgl_masuk'] = $record->tb_tgl_masuk;
			$data['tb_tgl_kadaluarsa'] = $record->tb_tgl_kadaluarsa;
			$data['tb_harga_beli'] = $record->tb_harga_beli;
			$data['tb_harga_jual'] = $record->tb_harga_jual;
			$data['tb_status_kadaluarsa'] = $record->tb_status_kadaluarsa;
			$data['toggle_status'] = ($record->tb_status_kadaluarsa != '0') ? true : false;
			$data['toggle_stok'] = ((int)$record->stok != 0) ? true : false;
			$data['earliest_batch'] = $earliest_batch;

			$datasup = $this->supplier->get_by_id($record->tb_ms_id);
			$data['ms_nama'] = $datasup->ms_nama;

			$dataunit = $this->unit->get_by_id($record->mo_mu_id);
			$data['mu_nama'] = $dataunit->mu_nama;

			$data['mo_deskripsi'] = $record->mo_deskripsi;
			$data['mo_nama'] = $record->mo_nama;
			$data['stok'] = $record->stok;

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('Obat/batch_detail.php', $data);
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
				$id = $this->model->save($data);

				echo json_encode(array("status" => TRUE, "id" => $id));
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

	public function get_earliest_batch($tb_id = null)
	{
		$this->db->select("DATE_FORMAT(tj_created, '%Y-%m-%d') as tgl");
		$this->db->where('tj_tb_id', $tb_id);
		$this->db->limit('1');
		$batch = $this->db->get('t_jurnal')->row();

		$tgl = date_create($batch->tgl);
		$y = date_sub($tgl, date_interval_create_from_date_string("1 DAY"));

		return date_format($y, 'Y-m-d');
	}

	public function save_stock()
	{
		$baru = $this->input->post('baru');

		$this->form_validation->set_rules('stock', 'stock obat', 'required');
		$this->form_validation->set_rules('id_obat', 'id obat', 'required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
		if ($baru == 1) {
			$this->form_validation->set_rules('tanggal', 'tanggal', 'required');
			$this->form_validation->set_rules('supplier', 'supplier', 'required');
			$this->form_validation->set_rules('harga_beli', 'harga_beli', 'required');
			$this->form_validation->set_rules('harga_jual', 'harga_jual', 'required');
		} else {
			$this->form_validation->set_rules('tgl_tersedia', 'Tanggal batch', 'required');
		}

		if ($this->form_validation->run() == true) {

			if ($baru == 0) {
				//maka lama
				$id_batch = $this->input->post('tgl_tersedia');
				//input stock ke jurnal
				$stock = array(
					'tj_mo_id' 		=> $this->input->post('id_obat'),
					'tj_tb_id' 		=> $this->input->post('tgl_tersedia'),
					'tj_user_id' 	=> $this->session->userdata('user_id'),
				);
				if ($this->input->post('jenis') == 'penambahan') {
					$stock['tj_masuk'] = $this->input->post('stock');
					$stock['tj_keluar'] = 0;
					$stock['tj_keterangan'] = $this->input->post('keterangan');;
				} else {
					$stock['tj_masuk'] = 0;
					$stock['tj_keluar'] = $this->input->post('stock');
					$stock['tj_keterangan'] = $this->input->post('keterangan');;
				}
				$this->db->insert('t_jurnal', $stock);
			} else {
				//input batch baru
				$this->db->where('tb_tgl_kadaluarsa', date('Y-m-d', strtotime($this->input->post('tanggal'))));
				$this->db->where('tb_ms_id', $this->input->post('supplier'));
				$cekada = $this->db->get('t_batch');
				if ($cekada->num_rows() > 0) {
					//maka ada, gunakan id batch yang ada.
					$id_batch = $cekada->row()->tb_id;
				} else {
					//maka input batch baru
					$data_batch = array(
						'tb_tgl_masuk' 		=> date('Y-m-d'),
						'tb_tgl_kadaluarsa' => date('Y-m-d', strtotime($this->input->post('tanggal'))),
						'tb_mo_id' 			=> $this->input->post('id_obat'),
						'tb_ms_id' 			=> $this->input->post('supplier'),
						'tb_harga_beli' 	=> str_replace(',', '', $this->input->post('harga_beli')),
						'tb_harga_jual' 	=> str_replace(',', '', $this->input->post('harga_jual')),
					);

					$this->db->insert('t_batch', $data_batch);
					$id_batch = $this->db->insert_id();
				}

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

	public function ajax_ubah_ppn_10($id)
	{
		$this->db->select('mo_ppn_10');
		$this->db->from('m_obat');
		$this->db->where('mo_id', $id);
		$query = $this->db->get();
		$data = $query->row();
		if ($data->mo_ppn_10 == '0') {
			$a = TRUE;
		} else {
			$a = FALSE;
		}
		$this->db->update('m_obat', array('mo_ppn_10' => $a), array('mo_id' => $id));

		echo json_encode(array("status" => TRUE));
	}


	public function ajax_data_penjualan()
	{
		//$startdate = json_decode( html_entity_decode( stripslashes ($_POST['stardate']) ) );
		//$enddate = json_decode( html_entity_decode( stripslashes ($_POST['enddate']) ) );
		$mo_id = json_decode(html_entity_decode(stripslashes($_POST['id'])));
		$this->db->select('tid_mo_id, SUM(tid_qty) AS qty, tid_created');
		$this->db->from('t_invoice_detail');
		$this->db->where('tid_mo_id', $mo_id);
		$this->db->group_by('tid_mo_id, date(tid_created)');
		$query = $this->db->get();
		$res = $query->result();
		$data = array();
		$tgl = array();
		foreach ($res as $val) {
			$pisah = explode(" ", $val->tid_created);
			$pisahlagi = explode("-", $pisah[0]);
			$data[intval($pisahlagi[2])] = $val->qty;
			//array_push($data, $val->tid_created);
		}
		$arr = array(
			"data" => $data
		);
		echo json_encode($data);
	}

	public function ajax_batch_history()
	{
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$this->db->select("*, DATE_FORMAT(tj_created, '%d-%m-%Y') as tgl");
		$this->db->where('tj_tb_id', $this->input->post('id'));
		$this->db->where('tj_created >=', date('Y-m-d 23:59:59', strtotime($tglAwal)));
		$this->db->where('tj_created <=', date('Y-m-d 23:59:59', strtotime($tglAkhir)));
		$query = $this->db->get('t_jurnal');
		echo json_encode($query->result());
	}

	public function cek_stok_by_tgl_batch()
	{
		$id_batch = $this->input->post('id_batch');
		$id_obat = $this->input->post('id_obat');

		$data = $this->db->query('SELECT
		m_obat.mo_nama,
		t_batch.tb_tgl_masuk AS batch_tgl_masuk,
		(
			SELECT
				(
					SUM(tj_masuk) - SUM(tj_keluar)
				)
			FROM
				t_jurnal
			WHERE
				tj_mo_id = "' . $id_obat . '"
			AND tj_tb_id = "' . $id_batch . '"
		) AS stok
	FROM
		t_batch
	LEFT JOIN m_obat ON m_obat.mo_id = t_batch.tb_mo_id')->row();

		$array = array('status' => TRUE, 'data' => $data);
		echo json_encode($array);
	}

	public function import()
	{

		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Import From Excel";

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('import.php');
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}

	public function save_obat_import()
	{
		if ($this->privilege['can_add'] == 0) {
			echo json_encode(array("status" => FALSE, "msg" => "You Dont Have Permission"));
		} else {

			$this->form_validation->set_rules('nama_obat[]','nama_obat','required');
			$this->form_validation->set_rules('deskripsi[]','deskripsi','required');
			$this->form_validation->set_rules('id_kategori[]','id_kategori','required');
			$this->form_validation->set_rules('penyimpanan[]','penyimpanan','required');
			$this->form_validation->set_rules('id_satuan[]','id_satuan','required');
			$this->form_validation->set_rules('resep[]','resep','required');

			if ($this->form_validation->run() == true) {
				$nama_obat = $this->input->post('nama_obat');
				$deskripsi = $this->input->post('deskripsi');
				$id_kategori = $this->input->post('id_kategori');
				$penyimpanan = $this->input->post('penyimpanan');
				$id_satuan = $this->input->post('id_satuan');
				$resep = $this->input->post('resep');

				$nama_obat_error = array();
				$nama_obat_berhasil = array();
				foreach ($nama_obat as $key => $value_obat) {
					$data = array(
						'mo_nama'         => $nama_obat[$key],
						'mo_deskripsi'    => $deskripsi[$key],
						'mo_mk_id'        => $id_kategori[$key],
						'mo_barcode'      => $this->alus_auth->get_code('SN-BARCODE'),
						'mo_penyimpanan'  => $penyimpanan[$key],
						'mo_mu_id'        => $id_satuan[$key],
						'mo_resep'        => $resep[$key],
					);
					
					if(!$this->db->insert('m_obat', $data)){
						array_push($nama_obat_error, $nama_obat[$key]);
					}else{
						array_push($nama_obat_berhasil, $nama_obat[$key]);
					}
				}
				
				if( count($nama_obat_error) > 0)
				{
					echo json_encode(array("status" => TRUE, 'withError' => TRUE, 'msg' => "Berhasil dengan beberapa data tidak dapat di import !", 'list' => $nama_obat_error));
				}else{
					echo json_encode(array("status" => TRUE, 'withError' => FALSE, 'msg' => "Data berhasil di import dengan jumlah : ".count($nama_obat_berhasil)));
				}
			} else {
				echo json_encode(array("status" => FALSE, "msg" => validation_errors()));
			}
		}
	}
	
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */