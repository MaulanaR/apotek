<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Stok_model extends CI_Model {

    var $column_order = array('mo_id', 'mo_nama', 'tb_id', 'tb_tgl_kadaluarsa', 'stok', null);
    var $column_search = array('mo_nama', 'mo_id');
    var $order = array('mo_id' => 'desc');
    var $table = 't_jurnal'; 
    var $table2 = 't_batch';

	public function __construct()
	{
		parent::__construct();
		$this->alus_co = $this->alus_auth->alus_co();
	}


	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
    private function _get_datatables_query($id)
    {
        $this->db->select("`m_obat`.mo_id,
                            `m_obat`.mo_mu_id,
                                    `m_obat`.mo_nama,
                                    `t_batch`.tb_id,
                                    `t_batch`.tb_tgl_kadaluarsa,
                                    SUM(tj_masuk - tj_keluar) AS 'stok'", FALSE);
        $this->db->from('t_jurnal');
        $this->db->join('m_obat','m_obat.mo_id = t_jurnal.tj_mo_id','inner');
        $this->db->join('t_batch','t_batch.tb_id = t_jurnal.tj_tb_id AND t_batch.tb_mo_id = t_jurnal.tj_mo_id','inner');
        if(isset($id)){
        $this->db->where('mo_id', $id);
        }
        $this->db->group_by('tj_tb_id');
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if(isset($_POST['search']['value'])) // if datatable send POST for search
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
 
    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if(isset($_POST['length']) && $_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
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
 
    public function get_by_id($moid, $tbid)
    {
        $this->db->select("*,SUM(tj_masuk - tj_keluar) AS 'stok'", FALSE);
        $this->db->from('t_jurnal');
        $this->db->join('m_obat','m_obat.mo_id = t_jurnal.tj_mo_id','inner');
        $this->db->join('t_batch','t_batch.tb_id = t_jurnal.tj_tb_id AND t_batch.tb_mo_id = t_jurnal.tj_mo_id','inner');
        $this->db->where("mo_id = '".$moid."' AND tb_id = '".$tbid."'");
        $query = $this->db->get();
        return $query->row();
    }
     public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function save_batch($data)
    {
        $this->db->insert($this->table2, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function update_batch($where, $data)
    {
        $this->db->update($this->table2, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('tb_id', $id);
        $this->db->delete($this->table);
    }
    

}

/* End of file  */
/* Location: ./application/models/ */