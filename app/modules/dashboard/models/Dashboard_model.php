<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
*/
class Dashboard_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

    /*public function get_payplan($today,$minggu,$id=Null)
    {
        $qurt = $this->db->query("SELECT
                    A.* , t_sales_order.*
                FROM
                    t_payment_planning A
                LEFT JOIN t_sales_order ON A.tpp_tso_id = t_sales_order.tso_id
                INNER JOIN (
                    SELECT
                        tpp_tso_id,
                        MAX(tpp_flag) AS MaxRevision
                    FROM
                        t_payment_planning
                    GROUP BY
                        tpp_tso_id
                ) B ON A.tpp_tso_id = B.tpp_tso_id
                AND A.tpp_flag = B.MaxRevision
                AND t_sales_order.tso_invoice IS NOT NULL
                WHERE
                    A.tpp_tp_1_date BETWEEN '$today'
                AND '$minggu'
                OR A.tpp_tp_2_date BETWEEN '$today'
                AND '$minggu'
                OR A.tpp_tp_3_date BETWEEN '$today'
                AND '$minggu'
                ");
        if ($id) {
            return $qurt->result();
        }else{
            return $qurt->num_rows();
        }
    }*/

    /* Start : Modified by ANF, 17 Jan 2017 */
    public function get_payplan($today,$minggu,$id=NULL)
    {
        $qurt = $this->db->query("(SELECT
                        A.tpp_id,A.tpp_code,A.tpp_tso_id,t_sales_order.tso_invoice,DATE_FORMAT(A.tpp_tp_1_date,'%d-%b-%Y') as tanggal_payment, A.tpp_tp_1_amount as Amount_Payment, 'Termin 1' as Note, t_sales_order.tso_mcu_id,t_sales_order.tso_mcu_name
                FROM
                        t_payment_planning A
                LEFT JOIN t_sales_order ON A.tpp_tso_id = t_sales_order.tso_id
                INNER JOIN (
                        SELECT
                                tpp_tso_id,
                                MAX(tpp_flag) AS MaxRevision
                        FROM
                                t_payment_planning
                        GROUP BY
                                tpp_tso_id
                ) B ON A.tpp_tso_id = B.tpp_tso_id
                AND A.tpp_flag = B.MaxRevision
                AND t_sales_order.tso_invoice IS NOT NULL
                WHERE
                        (A.tpp_tp_1_date BETWEEN '$today'
                AND '$minggu'))
                UNION
                (SELECT
                        A.tpp_id,A.tpp_code,A.tpp_tso_id,t_sales_order.tso_invoice,DATE_FORMAT(A.tpp_tp_2_date,'%d-%b-%Y') as tanggal_payment, A.tpp_tp_2_amount as Amount_Payment, 'Termin 2' as Note, t_sales_order.tso_mcu_id,t_sales_order.tso_mcu_name
                FROM
                        t_payment_planning A
                LEFT JOIN t_sales_order ON A.tpp_tso_id = t_sales_order.tso_id
                INNER JOIN (
                        SELECT
                                tpp_tso_id,
                                MAX(tpp_flag) AS MaxRevision
                        FROM
                                t_payment_planning
                        GROUP BY
                                tpp_tso_id
                ) B ON A.tpp_tso_id = B.tpp_tso_id
                AND A.tpp_flag = B.MaxRevision
                AND t_sales_order.tso_invoice IS NOT NULL
                WHERE
                        (A.tpp_tp_2_date BETWEEN '$today'
                AND '$minggu'))
                UNION
                (SELECT
                        A.tpp_id,A.tpp_code,A.tpp_tso_id,t_sales_order.tso_invoice,DATE_FORMAT(A.tpp_tp_3_date,'%d-%b-%Y') as tanggal_payment, A.tpp_tp_3_amount as Amount_Payment, 'Termin 3' as Note, t_sales_order.tso_mcu_id,t_sales_order.tso_mcu_name
                FROM
                        t_payment_planning A
                LEFT JOIN t_sales_order ON A.tpp_tso_id = t_sales_order.tso_id
                INNER JOIN (
                        SELECT
                                tpp_tso_id,
                                MAX(tpp_flag) AS MaxRevision
                        FROM
                                t_payment_planning
                        GROUP BY
                                tpp_tso_id
                ) B ON A.tpp_tso_id = B.tpp_tso_id
                AND A.tpp_flag = B.MaxRevision
                AND t_sales_order.tso_invoice IS NOT NULL
                WHERE
                        (A.tpp_tp_3_date BETWEEN '$today'
                AND '$minggu'))
                ORDER BY tanggal_payment
                ");
        if ($id) {
            return $qurt->result();
        }else{
            return $qurt->num_rows();
        }
    }

    public function get_deliv_order($today,$minggu,$id=NULL)
    {
        $qurt = $this->db->query("SELECT *,DATE_FORMAT(tdo_date,'%d-%b-%Y') as tanggal from t_delivery_order
                        LEFT JOIN t_sales_order on t_delivery_order.tdo_tso_id = t_sales_order.tso_id
                        where (tdo_date BETWEEN '$today' AND '$minggu')
                        and tdo_status = 1
                        and tdo_history = 0
                        AND t_sales_order.tso_invoice IS NOT NULL
                        GROUP BY tdo_tso_id
                        ORDER BY tdo_date");

        if ($id) {
            return $qurt->result();
        }else{
            return $qurt->num_rows();
        }
    }

    public function get_fittingschedule($today,$minggu,$id=NULL)
    {
         $qurt = $this->db->query("SELECT a.*, b.tso_invoice, b.tso_mcu_id, b.tso_mcu_name,
                                    DATE_FORMAT(tfd_date,'%d-%b-%Y') as tanggal
                                        FROM t_fitting_date a
                                        LEFT JOIN t_sales_order b ON b.tso_id = a.tfd_tso_id
                                        WHERE b.tso_invoice IS NOT NULL
                                        AND (DATE(tfd_date) BETWEEN '$today' AND '$minggu')
                                        ORDER BY tfd_date");

        if ($id) {
            return $qurt->result();
        }else{
            return $qurt->num_rows();
        }

    }
    public function get_week_order($today,$minggu,$id=NULL)
    {
        $qurt = $this->db->query("SELECT *, DATE_FORMAT(tso_invoice_date,'%d-%b-%Y') AS tanggal
                                FROM t_sales_order
                                WHERE tso_invoice is not null
                                AND (DATE(tso_invoice_date) BETWEEN '$today' And '$minggu')");
        if ($id) {
            return $qurt->result();
        }else{
            return $qurt->num_rows();
        }
    }

    public function get_all_stok_obat(){
        $this->db->select("`m_obat`.mo_id,
                            `m_obat`.mo_mu_id,
                                    `m_obat`.mo_nama,
                                    `t_batch`.tb_id,
                                    `t_batch`.tb_tgl_kadaluarsa,
                                    `t_batch`.tb_harga_beli,
                                    `t_batch`.tb_harga_jual,
                                    `t_batch`.tb_ms_id,
                                    SUM(tj_masuk - tj_keluar) AS 'stok'", FALSE);
        $this->db->from('t_jurnal');
        $this->db->join('m_obat','m_obat.mo_id = t_jurnal.tj_mo_id','inner');
        $this->db->join('t_batch','t_batch.tb_id = t_jurnal.tj_tb_id AND t_batch.tb_mo_id = t_jurnal.tj_mo_id','inner');
        $this->db->group_by('tj_tb_id');
        $query = $this->db->get();
        return $query->result();
    }
}


/* End of file  */
/* Location: ./application/models/ */