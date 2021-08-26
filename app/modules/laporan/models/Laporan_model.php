<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Laporan_model extends CI_Model {

	var $t_invoice = 't_invoice';
    var $t_batch = 't_batch';
    var $t_obat = 'm_obat';
    var $column_order = array('mk_nama',null);
    var $column_order_stok = array('tb_tgl_masuk', null);
    var $column_search = array('mk_nama');
    var $column_search_stok = array('tj_tb_id', 'tb_tgl_masuk', 'tb_tgl_kadaluarsa');
    var $order = array('mk_id' => 'desc');
    var $order_stok = array('tj_tb_id' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->alus_co = $this->alus_auth->alus_co();
	}


	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function get_data_invoice($tgl_awal, $tgl_akhir){
        $this->db->where("ti_tgl BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' ORDER BY ti_tgl");
        $query = $this->db->get();
        $data[0] = $query->num_rows();
        $data[1] = $query->result();
        return $data;
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('mk_id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('mk_id', $id);
        $this->db->delete($this->table);
    }

    public function _get_stok_batch_query($mo_id){
        $this->db->select("*, sum(tj_masuk - tj_keluar) AS stok");
        $this->db->from('t_jurnal');
        $this->db->join('t_batch', 't_batch.tb_id = t_jurnal.tj_tb_id', 'inner');
        $this->db->where('tj_mo_id', $mo_id);
        $this->db->group_by('tj_tb_id');
 
        $i = 0;
     
        foreach ($this->column_search_stok as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_stok) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_stok[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order_stok))
        {
            $order = $this->order_stok;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_stok_batch($mo_id)
    {
        $this->_get_stok_batch_query($mo_id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

}

/* End of file  */
/* Location: ./application/models/ */