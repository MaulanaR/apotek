<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->alus_auth->logged_in())
		{
			redirect('admin/Login','refresh');
		}
        $this->load->library('upload');

		$this->load->model('Dashboard_model','model');
		$this->load->model('Unit_model', 'unit');
		$this->load->model('Kategori_obat_model', 'kategori');
		$this->load->model('Suppliers_model', 'supplier');
	}


	public function index()
	{

		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Beranda";

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('dashboard/index');
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	public function maps()
	{
        $head['title'] = "Beranda";

		$this->load->view('template/temaalus/header',$head);
		$this->load->view('dashboard/maps');
		$this->load->view('template/temaalus/footer');
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

	function setting()
	{
		if($this->alus_auth->logged_in())
         {
         	$head['title'] = "Setting Apps";

			$x = $this->db->get('setting_app');
			if($x->num_rows() > 0)
			{
				//ada
				$data['data'] = $x->row();
			}else{
				$this->db->insert('setting_app', ['app_nama' => 'Apotek Apps', 'app_logo' => 'askrindo-mini.png']);
				
				$x = $this->db->get('setting_app');
				$data['data'] = $x->row();
			}
			
		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('setting.php',$data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	public function save_setting()
	{
		$config['upload_path'] = './assets/logo/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']  = '1000';
        $config['max_width']  = '1000';
        $config['max_height']  = '1000';
        $config['overwrite'] = TRUE;
        $config['file_name'] = time();


        $this->load->library('upload', $config);
        $this->upload->initialize($config);

		$data_update = array(
			'app_nama' => $this->input->post('nama_app')
		);

        if($_FILES['logo']['name'] != "")
        {
			//upload logo baru
			if ( ! $this->upload->do_upload('logo')){
				echo json_encode(['status' => FALSE, 'msg' => $this->upload->display_errors()]);
				die();
			}
			else{
				if($this->input->post('old_logo') != 'askrindo-mini.png')
				{
					//maka logo lama hapus
					if(file_exists('./assets/logo/'.$this->input->post('old_logo')))
					{
						unlink('./assets/logo/'.$this->input->post('old_logo'));
					}
				}
				///[ RESIZE IMAGE ]
				$config2['image_library'] = 'gd2';
				$config2['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				$config2['new_image'] = './assets/logo';
				$config2['maintain_ratio'] = FALSE;
				$config2['create_thumb'] = TRUE;
				$config2['thumb_marker'] = '';
				$config2['width'] = 300;
				$config2['height'] = 300;
				$this->load->library('image_lib',$config2);
				if ( !$this->image_lib->resize()){
					echo json_encode(['status' => FALSE, 'msg' => $this->image_lib->display_errors('', '')]);
					die();
				}
				$data_upload = array('upload_data' => $this->upload->data());
				$data_update['app_logo'] = $data_upload['upload_data']['file_name'];
			}
		}

		$this->db->where('setting_id', $this->input->post('id'));
		$this->db->update('setting_app', $data_update);
		
		echo json_encode(['status' => TRUE, 'msg' => 'Berhasil']);
		die();
	}

	public function sync()
	{
		//t_wbs
		

		$datatwbs = $this->db->get('t_wbs');
		foreach ($datatwbs->result() as $value) {
			//cari nilai gabungan kur non kura
			$gabungan = ($value->twbs_balance_kur + $value->twbs_balance_nonkur);
			$balance_konsol = ($gabungan + $value->twbs_balance_nasre + $value->twbs_balance_jpas + $value->twbs_balance_amu);
			//cari nilai balance final (balance konsole  + eliminasi debet - eliminasi kredit)
			$nilai_balance_final = $balance_konsol + $value->twbs_debit_eliminasi - $value->twbs_credit_eliminasi;
			$data_insert_batchtwbs[] = array(
				'twbs_id' => $value->twbs_id,
				'twbs_balance_gabungan' => $gabungan,
				'twbs_balance_konsol' => $balance_konsol,
				'twbs_balance_final' => $nilai_balance_final,
			);
		}

		$datatwpl = $this->db->get('t_wpl');
		foreach ($datatwpl->result() as $value) {
			//cari nilai gabungan kur non kura
			$gabunganpl = ($value->twpl_balance_kur + $value->twpl_balance_nonkur);
			$balance_konsolpl = ($gabunganpl + $value->twpl_balance_nasre + $value->twpl_balance_jpas + $value->twpl_balance_amu);
			//cari nilai balance final (balance konsole  - eliminasi debet + eliminasi kredit)
			$nilai_balance_finalpl = $balance_konsolpl - $value->twpl_debit_eliminasi + $value->twpl_credit_eliminasi;
			$data_insert_batchtwpl[] = array(
				'twpl_id' => $value->twpl_id,
				'twpl_balance_gabungan' => $gabunganpl,
				'twpl_balance_konsol' => $balance_konsolpl,
				'twpl_balance_final' => $nilai_balance_finalpl,
			);
		}

		$this->db->update_batch('t_wbs', $data_insert_batchtwbs , 'twbs_id');
		$this->db->update_batch('t_wpl', $data_insert_batchtwpl , 'twpl_id');

		$ins = [
			'ts_user_id' => $this->session->userdata('user_id'),
			'ts_datetime'=> date('Y-m-d H:i:s')
		];
		$this->db->insert('t_sync', $ins);

		echo json_encode(['status' => TRUE]);
	}

	public function ajax_cek_kadaluarsa_all(){
		$kd_interval = 10; //interval hari sebelum kadaluarsa
		$status = FALSE;
		$kadaluarsa = FALSE;
        $hampir = FALSE;
		$con = $this->model->get_all_stok_obat();
		$data = array();
		$data2 = array();
		foreach ($con as $record2) {
            $cekkd = $this->alus_auth->cek_kadaluarsa($record2->tb_tgl_kadaluarsa, $kd_interval);
            if($cekkd->status == 'kd'){
            	if(count($data) <= 5){//limit 5 data
            	$status = TRUE;
            	$kadaluarsa = TRUE;
            	$row2 = array();
	            $row2[] = $record2->mo_nama;//0
	            $row2[] = $record2->tb_tgl_kadaluarsa;//1
	            $row2[] = $record2->stok;//2
	            $row2[] = $record2->tb_id;//3
	            $sisahari = $cekkd->sisahari;
	            $status_kd = $cekkd->status;
	            $row2[] = $kadaluarsa;//4
	            $row2[] = $sisahari;//5
	            $row2[] = $status_kd;
	            $row2[] = $record2->mo_id;//7
	            
	            $data[] = $row2;
	            $msg = 'Ada obat kadaluarsa!';
	        	}
            }else if($cekkd->status == 'hr'){
            	if(count($data2) <= 5){//limit 5 data
            	$hampir = TRUE;
            	$row = array();
	            $row[] = $record2->mo_nama;//0
	            $row[] = $record2->tb_tgl_kadaluarsa;//1
	            $row[] = $record2->stok;//2
	            $row[] = $record2->tb_id;//3
	            $sisahari = $cekkd->sisahari;
	            $status_kd = $cekkd->status;
	            $row[] = $kadaluarsa;//4
	            $row[] = $sisahari;//5
	            $row[] = $status_kd;//6
	            $row[] = $record2->mo_id;//7
	            $data2[] = $row;
	        	}
            }
		}
		echo json_encode(array('status' => $status, 'statuskd' => $kadaluarsa, 'statushr' => $hampir, 'msg' => $msg, 'datakd' => $data, 'datahr' => $data2));
		//echo json_encode(["status" => true]);
	}

}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */