<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class retur_pembelian_model extends CI_Model {

	var $table1 = 't_retur_pembelian';
    var $table2 = 't_retur_pembelian_detail';
    var $column_order = array('trp_id','trp_tgl', null);
    var $column_search = array('trp_id');
    var $order = array('trp_id' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->alus_co = $this->alus_auth->alus_co();
	}


	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
    private function _get_datatables_query()
    {
         
        $this->db->select("
            t_retur_pembelian.trp_id,
            t_retur_pembelian.trp_kode,
            t_retur_pembelian.trp_tgl,
            alus_u.first_name,
            alus_u.last_name,
            m_supplier.ms_nama
            ");
        $this->db->from($this->table1);
        $this->db->join("alus_u", "alus_u.id = t_retur_pembelian.trp_user_id", "inner");
        $this->db->join("m_supplier", "m_supplier.ms_id = t_retur_pembelian.trp_ms_id");

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

    function get_by_kode($kode){
        $this->db->select('*');
        $this->db->from($this->table1);
        $this->db->where('trp_kode', $kode);
        $query = $this->db->get();
        return $query->row();
    }

    function get_data_detail_by_id($id){
        $this->db->select('*');
        $this->db->from('t_retur_pembelian_detail');
        $this->db->join('t_batch', 't_batch.tb_id = t_retur_pembelian_detail.trpd_tb_id', 'inner');
        $this->db->join('m_supplier', 'm_supplier.ms_id = t_batch.tb_ms_id', 'inner');
        $this->db->join('m_obat', 'm_obat.mo_id = t_batch.tb_mo_id', 'left');
        $this->db->where("trpd_trp_id", $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_batch_list_by_supplier($ms_id){
        $this->db->select('*, sum(tj_masuk - tj_keluar) as stok');
        $this->db->from('t_batch');
        $this->db->join('m_supplier', 'm_supplier.ms_id = t_batch.tb_ms_id', 'inner');
        $this->db->join('m_obat', 'm_obat.mo_id = t_batch.tb_mo_id', 'inner');
        $this->db->join('m_unit', 'm_unit.mu_id = m_obat.mo_mu_id');
        $this->db->join('t_jurnal', 't_jurnal.tj_tb_id = t_batch.tb_id');
        $this->db->where('t_batch.tb_ms_id', $ms_id);
        $this->db->group_by('tj_tb_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function cek_nomor_inv($nomor_inv)
    {
        $this->db->from($this->table1);
        $this->db->where('trp_kode',$nomor_inv);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function kurangi_stok_batch($tb_id, $mo_id, $jumlah, $keterangan){
        $data = array('tj_tb_id' => $tb_id, 'tj_mo_id' => $mo_id, 'tj_keluar' => $jumlah, 'tj_keterangan' => $keterangan);
        $this->db->insert('t_jurnal', $data);
        return $this->db->insert_id();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table1);
        return $this->db->count_all_results();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table1, $data);
        return $this->db->insert_id();
    }

    public function save_detail($data)
    {
        $this->db->insert($this->table2, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table1, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('trp_id', $id);
        $this->db->delete($this->table1);
    }

}

/* End of file  */
/* Location: ./application/models/ */