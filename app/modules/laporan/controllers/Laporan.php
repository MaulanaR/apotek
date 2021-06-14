<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Laporan extends CI_Controller {

	private $privilege;

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('laporan_model','model');

		if(!$this->alus_auth->logged_in())
		{
			redirect('admin/Login','refresh');
		}
		$this->privilege = $this->Alus_hmvc->cek_privilege($this->uri->segment(1));
        if($this->privilege['can_view'] == '0')
        {
            echo "<script type='text/javascript'>alert('You dont have permission to access this menu');</script>";
            redirect('dashboard','refresh');
        }
	}
		

	public function index()
	{
	
		if($this->alus_auth->logged_in())
         {
            $head['title'] = "Buat Laporan";
         	//$data['tree'] = $this->model->all_tree();
         	$data['can_add'] = $this->privilege['can_add'];
    		
		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('laporan/index.php',$data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	function generate()
	{
		switch ($this->input->post('jenis')) {
			case 'Transaksi':
				$this->db->select("DATE_FORMAT(ti_tgl, '%d-%m-%Y') as tgl_inv, COUNT(*) as total_order, SUM(ti_grandtotal) as total_uang");
				$this->db->where('ti_tgl >=', date('Y-m-d H:i:s', strtotime($this->input->post('tgl_awal'))));
				$this->db->where('ti_tgl <=', date('Y-m-d 23:59:59', strtotime($this->input->post('tgl_akhir'))));
				$this->db->group_by('tgl_inv');
				
				$dtinv = $this->db->get('t_invoice');
				
				$data['data'] = $dtinv->result();
				$data['tgl_awal'] = $this->input->post('tgl_awal');
				$data['tgl_akhir'] = $this->input->post('tgl_akhir');

				$arrdate = array();
				$count_order = array();
				$sum_order = array();
				foreach ($dtinv->result() as $key => $value) {
					array_push($arrdate, $value->tgl_inv);
					array_push($count_order, (int)$value->total_order);
					array_push($sum_order, (float)$value->total_uang);
				}

				$data['datex'] = $arrdate;
				$data['count_order'] = $count_order;
				$data['sum_order'] = $sum_order;
				$this->load->view('ajax/view_transaksi', $data);
				
				break;
			
			default:
				# code...
				break;
		}

	}
	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */