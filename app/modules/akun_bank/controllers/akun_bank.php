<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Akun_bank extends CI_Controller {

	private $privilege;

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('akun_bank_model','model');

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
            $head['title'] = "Manajemen Akun Bank";
         	//$data['tree'] = $this->model->all_tree();
         	$data['can_add'] = $this->privilege['can_add'];
            $data['banks'] = $this->alus_auth->arrayBank();
    		
		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('akun_bank/index.php',$data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
	public function ajax_list()
    {
        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $record) {
            $no++;
            $row = array();
            $row[] = $record->mab_nama_nasabah;
            $cssid = $this->alus_auth->getSingleBank($record->mab_bank);
            $row[] = '<i class="btn-bank btn-bank-180 btn-bank-app '.$cssid.'"></i><br/>Bank '.$record->mab_bank;
            $row[] = $record->mab_cabang;
            $row[] = $record->mab_nomor_rekening;
            $row[] = '<a class="btn btn-sm btn-outline-primary" href="javascript:void(0)" data-toggle="tooltip" title="Edit" onclick="edit_person('."'".$record->mab_id."'".')"><i class="fa fa-pencil-alt"></i></a>';
            $row[] = '<a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" data-toggle="tooltip" title="Hapus" onclick="delete_person('."'".$record->mab_id."'".')"><i class="fa fa-trash"></i></a>';
            
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
        $mab_nama = $data->mab_nama_nasabah;
        $arr = array('data' => $data,
                     'nama' => $mab_nama,
                     );
        echo json_encode($arr);
    }
 
    public function ajax_add()
    {
    	if($this->privilege['can_add'] == 0)
		{
			echo json_encode(array("status" => FALSE,"msg" => "You Dont Have Permission"));
		}
        else
        {

        $this->form_validation->set_rules('nama', 'Nama Nasabah', 'required');
        $this->form_validation->set_rules('bank', 'Bank', 'required');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required');
        $this->form_validation->set_rules('rekening', 'No Rekening', 'required');

        if ($this->form_validation->run() == true)
        {
            $data = array(
                'mab_nama_nasabah' => $this->input->post('nama'),
                'mab_bank' => $this->input->post('bank'),
                'mab_cabang' => $this->input->post('cabang'),
                'mab_nomor_rekening' => $this->input->post('rekening'),
            );
            $insert = $this->model->save($data);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE,"msg" => validation_errors() ));
        }
        }
        
    }
 
    public function ajax_update()
    {
    	if($this->privilege['can_edit'] == 0)
		{
			echo json_encode(array("status" => FALSE,"msg" => "You Dont Have Permission"));
		}else{

        $this->form_validation->set_rules('nama', 'Nama Nasabah', 'required');
        $this->form_validation->set_rules('bank', 'Bank', 'required');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required');
        $this->form_validation->set_rules('rekening', 'No Rekening', 'required');

        if ($this->form_validation->run() == true)
        {
            $data = array(
                'mab_nama_nasabah' => $this->input->post('nama'),
                'mab_bank' => $this->input->post('bank'),
                'mab_cabang' => $this->input->post('cabang'),
                'mab_nomor_rekening' => $this->input->post('rekening'),
            );
            $this->model->update(array('mab_id' => $this->input->post('id')), $data);
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE,"msg" => validation_errors()));
        }
        }
        
    }
 
    public function ajax_delete()
    {
    	if($this->privilege['can_delete'] == 0)
		{
			echo json_encode(array("status" => FALSE,"msg" => "You Dont Have Permission"));
		}else
        {
            $this->model->delete_by_id($this->input->post('id'));
            //$this->model->delete_detail_grupakses($this->input->post('id'));
            echo json_encode(array("status" => TRUE, "id" => $this->input->post('id')));
        }
    }
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */