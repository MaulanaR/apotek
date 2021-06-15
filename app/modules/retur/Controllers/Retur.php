<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Retur extends CI_Controller {

	private $privilege;

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('retur_model','model');

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
		 	$this->load->view('retur/index.php',$data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

    public function retur_detail()
    {

        if($this->alus_auth->logged_in())
         {
            $arrayItem = array();
            $kode_inv = basename($_SERVER['REQUEST_URI']);
            if($kode_inv != "" | $kode_inv != NULL){
                $cek = $this->model->cek_nomor_inv($kode_inv);
                if($cek > 0){
                    $this->db->select('ti_tgl');
                    $this->db->from('t_invoice');
                    $this->db->where('ti_nomor_inv',$kode_inv);
                    $query = $this->db->get();
                    $invoice = $query->row();
                    $record = $this->model->get_by_kode($kode_inv);
                    $data['kode_inv'] = $kode_inv;
                    $data['tgl'] = $record->tr_tgl;
                    $data['tgl_invoice'] = $invoice->ti_tgl;
                    $data['ppn_kembali'] = $record->tr_ppn_kembali;
                    $data['ppn_nilai'] = $this->alus_auth->rupiahrp($record->tr_total_ppn);
                    $data['user_id'] = $record->tr_user_id;
                    $data['nilai_pengembalian'] = $this->alus_auth->rupiahrp($record->tr_nilai_pengembalian);
                    $data['keterangan'] = $record->tr_keterangan;
                    $data['id'] = $record->tr_id;

                    $this->db->select('username, job_title');
                    $this->db->from('alus_u');
                    $this->db->where('id', $record->tr_user_id);
                    $query = $this->db->get();
                    $userdata = $query->row();
                    $data['username'] = $userdata->username;
                    $data['job'] = $userdata->job_title;

                    $head['title'] = "Retur dari Invoice : ".$kode_inv;
                    $this->load->view('template/temaalus/header',$head);
                    $this->load->view('retur/retur_detail.php', $data);
                    $this->load->view('template/temaalus/footer');
                }else{
                    redirect('retur','refresh');
                }
            }else{
                redirect('retur','refresh');
            }
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
                $row = array();
                $row[] = $no + 1;
                $row[] = $record->tr_ti_nomor_inv;
                $t = explode(" ", $record->tr_tgl);
                $row[] = $t[0];
                $row[] = $this->alus_auth->rupiahrp($record->tr_nilai_pengembalian);
                $row[] = '<a class="btn btn-sm btn-outline-primary" href="javascript:void(0)" data-toggle="tooltip" title="Detail" onclick="detail('."'".$record->tr_ti_nomor_inv."'".')"><i class="fa fa-pencil-alt"></i> Lihat Detail</a>';
                //add html for action
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
 
    function ajax_detail_items(){
        $id = $_POST['id'];
        $status = false;
        if(isset($id)){
        $status = true;
        $this->db->select('trd_qty, trd_harga_satuan, trd_ppn_status, trd_mo_id, trd_tb_id, mo_nama, mo_barcode, mo_deskripsi',  FALSE);
        $this->db->from('t_retur_detail');
        $this->db->join('m_obat', 'm_obat.mo_id = t_retur_detail.trd_mo_id', 'inner');
        $this->db->where('trd_tr_id', $id);
        $query2 = $this->db->get();
        $data = $query2->result();
        $temp = array();
            foreach ($data as $itemdata) {
                $totalharga = $itemdata->trd_qty * $itemdata->trd_harga_satuan;
                    $temp[] = array(
                        'qty' => $itemdata->trd_qty,
                        'nama' => $itemdata->mo_nama, 
                        'barcode' => $itemdata->mo_barcode, 
                        'deskripsi' => $itemdata->mo_deskripsi, 
                        'harga' => $itemdata->trd_harga_satuan, 
                        'total' => $totalharga,
                        'ppn_status' => $itemdata->trd_ppn_status,
                        'mo_id' => $itemdata->trd_mo_id,
                        'tb_id' => $itemdata->trd_tb_id,
                    );
                
            }
        $arr = $temp;
        }
        echo json_encode(array('status' => $status, 'data' => $arr));
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