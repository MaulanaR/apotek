<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Retur_pembelian extends CI_Controller {

	private $privilege;

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('retur_pembelian_model','model');

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
            $head['title'] = "Daftar Retur";
         	$data['can_add'] = $this->privilege['can_add'];
    		
		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('retur_pembelian/index.php',$data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

    public function input_retur_pembelian()
    {
    
        if($this->alus_auth->logged_in())
         {
            $head['title'] = "Daftar Retur";
            $data['can_add'] = $this->privilege['can_add'];
            $data['list_supplier'] = $this->db->get('m_supplier');
            $length = 4;
            do{
                $b = $this->alus_auth->generateUniqueId($length);
                $cek = $this->model->cek_nomor_inv($b);
                if($cek > 0){
                    $a = TRUE;
                    $length += 1;
                 }else{
                    $a = FALSE;
                 }
            }while($a);
            $data['kode'] = 'RTP'.$b;
            
            $this->load->view('template/temaalus/header',$head);
            $this->load->view('retur_pembelian/input_retur_pembelian.php',$data);
            $this->load->view('template/temaalus/footer');
        }
        else
        {
            redirect('admin/Login','refresh');
        }
    }

    public function retur_pembelian_detail()
    {
        if($this->alus_auth->logged_in())
        {
            $head['title'] = "Daftar Retur";
            $kode = basename($_SERVER['REQUEST_URI']);
            if($kode != "" | $kode != NULL){
                $cek = $this->model->cek_nomor_inv($kode);
                if($cek > 0){
                    $data['kode'] = $kode;
                    $trp = $this->model->get_by_kode($kode);
                    $data['tgl'] = $trp->trp_tgl;
                    $data['total_item'] = $trp->trp_qty;

                    $this->db->select('*');
                    $this->db->from('m_supplier');
                    $this->db->where('ms_id', $trp->trp_ms_id);
                    $query = $this->db->get();
                    $supplier = $query->row();
                    $data['ms_nama'] = $supplier->ms_nama;
                    $data['ms_alamat'] = $supplier->ms_alamat;
                    $data['ms_telp'] = $supplier->ms_telp;
                    $data['ms_kodepos'] = $supplier->ms_kodepos;


                    $this->db->select('first_name, last_name, job_title');
                    $this->db->from('alus_u');
                    $this->db->where('id', $trp->trp_user_id);
                    $query = $this->db->get();
                    $userdata = $query->row();
                    $last_name = strtoupper((substr($userdata->last_name,0,1)));
                    $data['username'] = $userdata->first_name." ".$last_name;
                    $data['job'] = $userdata->job_title;

                    $trpd = $this->model->get_data_detail_by_id($trp->trp_id);
                    $data['trp_id'] = $trp_id;
                    $data['data'] = $trpd;

                    $data['title'] = "Detail Retur ".$kode;
                    $this->load->view('template/temaalus/header',$head);
                    $this->load->view('retur_pembelian/retur_pembelian_detail.php',$data);
                    $this->load->view('template/temaalus/footer');
                }
                else
                {
                    redirect('dashboard','refresh');
                }
            }
            else
            {
                redirect('dashboard','refresh');
            }
        }
        else
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
                $row = array();
                $row[] = $no + 1;
                $row[] = $record->trp_kode;
                $row[] = $record->first_name." ".$record->last_name;
                $row[] = $record->ms_nama;
                $t = explode(" ", $record->trp_tgl);
                $row[] = $t[0];
                $row[] = '<a class="btn btn-sm btn-outline-primary" href="javascript:void(0)" data-toggle="tooltip" title="Detail" onclick="detail('."'".$record->trp_kode."'".')"><i class="fa fa-pencil-alt"></i> Lihat Detail</a>';
                $data[] = $row;
                $no++;
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
    
    function get_batch_by_supplier_id(){
        $id = $this->input->post('ms_id');
        $data = $this->model->get_batch_list_by_supplier($id);
        echo json_encode(array('data' => $data));
    }

    function save_retur_pembelian(){
        if ($this->privilege['can_add'] == 0) {
            echo json_encode(array("status" => FALSE, "msg" => "You Dont Have Permission"));
        } else {
        $data = json_decode(html_entity_decode(stripslashes($this->input->post('data'))));
        $uniqid = $this->input->post('kode');
        $ms_id = $this->input->post('ms_id');
        $status = false;
        if(isset($data)){
            $status = true;
            $data_utama = array(
                    'trp_kode' => $uniqid,
                    'trp_user_id' => $this->session->userdata('user_id'),
                    'trp_ms_id' => $ms_id,
                    'trp_qty' => '0',
                    'trp_tgl' => date('Y-m-d'),
                );
            $trp_id = $this->model->save($data_utama);
            $total_qty = 0;
            foreach ($data as $value) {
                $detail = array(
                    'trpd_trp_id' => $trp_id,
                    'trpd_tb_id' => $value->batchId,
                    'trpd_qty' => $value->quantity,
                    'trpd_tgl_input' => $value->tgl
                );

                $this->model->save_detail($detail);

                $this->model->kurangi_stok_batch($value->batchId, $value->itemId, $value->quantity, 'Retur Pembelian '.$uniqid);

                $total_qty += (int)$value->quantity;
            }
            $this->model->update(array('trp_id' => $trp_id), array('trp_qty' => $total_qty));
            echo json_encode(array("status" => $status, "data" => $data, "msg" => "Sukses!"));
        }else{
            echo json_encode(array("status" => $status, "msg" => "Ajax error!"));
        }
        }
    }

    function ajax_cek_stok(){
        $success = FALSE;
        $data = json_decode(html_entity_decode(stripslashes($this->input->post('data'))));
        $arr = array();
        if(isset($_POST['data'])){
            $success = TRUE;
            $i = 0;
            foreach ($data as $value) {
                if($success){
                    $cek = $this->alus_auth->cek_stok($value->itemId, $value->batchId, $value->quantity);
                    $success = $cek['status'];
                }else{
                    $arr[] = array('nama' => $value->nama, 'stok' => $cek->stok);
                }
            }   
        }
        $response = array("status" => $success, "data" => $arr);
        echo json_encode($response);
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
            echo json_encode(array("status" => TRUE));
        }
    }
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */