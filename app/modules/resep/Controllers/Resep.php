<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Resep extends CI_Controller {

	private $privilege;

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('Resep_model','model');

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
            $head['title'] = "Daftar Resep";
         	$data['can_add'] = $this->privilege['can_add'];
    		
		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('resep/index.php',$data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}

    public function salinan_resep()
    {

        if($this->alus_auth->logged_in())
         {
            $arrayItem = array();
            $kode_inv = basename($_SERVER['REQUEST_URI']);
            if($kode_inv != "" | $kode_inv != NULL){
                $cek = $this->model->cek_nomor_inv($kode_inv);
                if($cek > 0){
                    $record = $this->model->get_by_kode($kode_inv);
                    $data['kode_inv'] = $kode_inv;
                    $data['tgl'] = $record->ti_tgl;
                    $data['user_id'] = $record->tr_user_id;

                    $data['id'] = $record->ti_id;
                    $data['resep'] = $record->ti_resep;
                    $data['resep_penerbit'] = $record->ti_resep_penerbit;
                    $data['resep_dokter'] = $record->ti_resep_dokter;
                    $data['resep_tgl'] = $record->ti_resep_tgl;

                    $this->db->select('ma_nama, ma_no_stra');
                    $this->db->from('m_apoteker');
                    $this->db->where('ma_id', $record->ti_resep_ma_id);
                    $query = $this->db->get();
                    $userdata = $query->row();
                    $data['username'] = $userdata->ma_nama;
                    $data['job'] = $userdata->ma_no_stra;

                    $head['title'] = "Salinan Resep";
                    $this->load->view('template/temaalus/header',$head);
                    $this->load->view('Resep/salinan_resep.php', $data);
                    $this->load->view('template/temaalus/footer');
                }else{
                    redirect('resep','refresh');
                }
            }else{
                redirect('resep','refresh');
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
                $row[] = $record->ti_nomor_inv;
                $t = explode(" ", $record->ti_tgl);
                $row[] = $t[0];
                $row[] = '<a class="btn btn-sm btn-outline-primary" href="javascript:void(0)" data-toggle="tooltip" title="Detail" onclick="detail('."'".$record->ti_nomor_inv."'".')"><i class="fa fa-pencil-alt"></i> Lihat Detail</a>';
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
        $this->db->select('tid_mo_id, tid_qty, tid_harga_satuan, tid_total, tid_ppn_status, tid_tb_id, mo_nama, mo_barcode, mo_deskripsi',  FALSE);
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
                        'total' => $itemdata->tid_total,
                        'ppn_status' => $itemdata->tid_ppn_status,
                        'mo_id' => $itemdata->tid_mo_id,
                        'tb_id' => $itemdata->tid_tb_id,
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