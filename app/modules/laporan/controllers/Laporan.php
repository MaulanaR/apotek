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

	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */