<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Alkes_model extends CI_Model {

	var $table = 'm_obat';
    var $column_order = array('mo_nama','mo_deskripsi','mk_nama','mo_barcode','mo_penyimpanan','mu_nama','mo_resep',null,null,null);
    var $column_search = array('mo_nama','mo_deskripsi','mk_nama','mo_barcode','mo_penyimpanan','mu_nama','mo_resep');
    var $order = array('mo_id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->alus_co = $this->alus_auth->alus_co();
        $temp = $this->alus_auth->getAlkesOrItemID('Alkes');
        $this->id_alkes = $temp->mk_id;
	}

	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
        $this->db->join('m_unit', 'm_unit.mu_id = m_obat.mo_mu_id', 'left');
        $this->db->where('mo_mk_id', $this->id_alkes);//Pilih hanya alkes
        
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
        $this->db->where('mo_id',$id);
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
        $this->db->where('mo_id', $id);
        $this->db->delete($this->table);
    }

}

/* End of file  */
/* Location: ./application/models/ */