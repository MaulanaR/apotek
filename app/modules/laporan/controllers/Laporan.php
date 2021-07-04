<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
 */
class Laporan extends CI_Controller
{

	private $privilege;

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('laporan_model', 'model');
		$this->load->model('Unit_model', 'unit');
		$this->load->model('Suppliers_model', 'supplier');
		$this->load->library('pdf2');

		if (!$this->alus_auth->logged_in()) {
			redirect('admin/Login', 'refresh');
		}
		$this->privilege = $this->Alus_hmvc->cek_privilege($this->uri->segment(1));
		if ($this->privilege['can_view'] == '0') {
			echo "<script type='text/javascript'>alert('You dont have permission to access this menu');</script>";
			redirect('dashboard', 'refresh');
		}
		$temp = $this->alus_auth->getAlkesOrItemID('Alkes');
        $this->id_alkes = $temp->mk_id;
	}


	public function index()
	{

		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Buat Laporan";
			//$data['tree'] = $this->model->all_tree();
			$data['can_add'] = $this->privilege['can_add'];

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('laporan/index.php', $data);
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}

	function generate()
	{
		switch ($this->input->post('jenis')) {
			case 'Transaksi':
				if ($this->input->post('kelompok') == 'harian') {
					$this->db->select("*, DATE_FORMAT(ti_tgl, '%m%d') as orderx, DATE_FORMAT(ti_tgl, '%d-%m-%Y') as tgl_inv, COUNT(*) as total_order, SUM(ti_grandtotal) as total_uang");
					$this->db->where('ti_tgl >=', date('Y-m-d H:i:s', strtotime($this->input->post('tgl_awal'))));
					$this->db->where('ti_tgl <=', date('Y-m-d 23:59:59', strtotime($this->input->post('tgl_akhir'))));
					$this->db->order_by('orderx', 'asc');
					$this->db->group_by('tgl_inv');
				} else {
					$this->db->select("*, YEAR(ti_tgl) as tahun,DATE_FORMAT(ti_tgl, '%M') as tgl_inv, MONTH(ti_tgl) as bulan, COUNT(*) AS total_order, SUM(ti_grandtotal) AS total_uang");
					$this->db->where('ti_tgl >=', date('Y-m-d H:i:s', strtotime($this->input->post('tgl_awal'))));
					$this->db->where('ti_tgl <=', date('Y-m-d 23:59:59', strtotime($this->input->post('tgl_akhir'))));
					$this->db->group_by('YEAR(ti_tgl) , MONTH(ti_tgl)');
				}

				$dtinv = $this->db->get('t_invoice');

				$data['data'] = $dtinv->result();
				$data['tgl_awal'] = $this->input->post('tgl_awal');
				$data['tgl_akhir'] = $this->input->post('tgl_akhir');

				$arrdate = array();
				$count_order = array();
				$sum_order = array();
				foreach ($dtinv->result() as $key => $value) {
					array_push($arrdate, $value->tgl_inv);
					array_push($count_order, (int)$value->total_order);
					array_push($sum_order, (float)$value->total_uang);
				}

				$data['datex'] = $arrdate;
				$data['count_order'] = $count_order;
				$data['sum_order'] = $sum_order;
				$data['kelompok'] = $this->input->post('kelompok');
				$this->load->view('ajax/view_transaksi', $data);
				break;

			case 'StokObat' :
				$arr = $this->alus_auth->ajax_stok_obat_by_id();
				$data['data'] = $arr;
				$data['id_alkes'] = $this->id_alkes;

				$this->load->view('ajax/stok', $data, FALSE);
				break;
			case 'StokObatKd' :
				$data['id_alkes'] = $this->id_alkes;
				$arr = $this->alus_auth->ajax_stok_obat_by_id();
				$data['data'] = $arr;
				$this->load->view('ajax/stok_obat_kadaluarsa', $data, FALSE);

				break;
			case 'StokAlkes' :
				$arr = $this->alus_auth->ajax_stok_obat_by_id();
				$data['data'] = $arr;
				$data['id_alkes'] = $this->id_alkes;
				$this->load->view('ajax/stok_alkes', $data, FALSE);
				break;
			
			default:
				# code...
				break;
		}
	}

	function export_transaksi()
	{
		$jenis = $this->input->get('jenis') ? $this->input->get('jenis') : 'excel';

		if ($jenis == 'excel') {
			if ($this->input->get('kelompok') == 'harian') {
				$this->db->select("*, DATE_FORMAT(ti_tgl, '%m%d') as orderx, DATE_FORMAT(ti_tgl, '%d-%m-%Y') as tgl_inv, COUNT(*) as total_order, SUM(ti_grandtotal) as total_uang");
				$this->db->where('ti_tgl >=', date('Y-m-d H:i:s', strtotime($this->input->get('awal'))));
				$this->db->where('ti_tgl <=', date('Y-m-d 23:59:59', strtotime($this->input->get('akhir'))));
				$this->db->order_by('orderx', 'asc');
				$this->db->group_by('tgl_inv');
			} else {
				$this->db->select("*, YEAR(ti_tgl) as tahun,DATE_FORMAT(ti_tgl, '%M') as tgl_inv, MONTH(ti_tgl) as bulan, COUNT(*) AS total_order, SUM(ti_grandtotal) AS total_uang");
				$this->db->where('ti_tgl >=', date('Y-m-d H:i:s', strtotime($this->input->get('awal'))));
				$this->db->where('ti_tgl <=', date('Y-m-d 23:59:59', strtotime($this->input->get('akhir'))));
				$this->db->group_by('YEAR(ti_tgl) , MONTH(ti_tgl)');
			}

			$dtinv = $this->db->get('t_invoice');

			$data['data'] = $dtinv->result();
			$data['awal'] = date('d-m-Y', strtotime($this->input->get('awal')));
			$data['akhir'] = date('d-m-Y', strtotime($this->input->get('akhir')));
			$this->load->view('ajax/export_transaksi', $data, FALSE);
		} else {
			if ($this->input->get('kelompok') == 'harian') {
				$this->db->select("*, DATE_FORMAT(ti_tgl, '%m%d') as orderx, DATE_FORMAT(ti_tgl, '%d-%m-%Y') as tgl_inv, COUNT(*) as total_order, SUM(ti_grandtotal) as total_uang");
				$this->db->where('ti_tgl >=', date('Y-m-d H:i:s', strtotime($this->input->get('awal'))));
				$this->db->where('ti_tgl <=', date('Y-m-d 23:59:59', strtotime($this->input->get('akhir'))));
				$this->db->order_by('orderx', 'asc');
				$this->db->group_by('tgl_inv');
			} else {
				$this->db->select("*, YEAR(ti_tgl) as tahun,DATE_FORMAT(ti_tgl, '%M') as tgl_inv, MONTH(ti_tgl) as bulan, COUNT(*) AS total_order, SUM(ti_grandtotal) AS total_uang");
				$this->db->where('ti_tgl >=', date('Y-m-d H:i:s', strtotime($this->input->get('awal'))));
				$this->db->where('ti_tgl <=', date('Y-m-d 23:59:59', strtotime($this->input->get('akhir'))));
				$this->db->group_by('YEAR(ti_tgl) , MONTH(ti_tgl)');
			}

			$data = $this->db->get('t_invoice')->result();


			$this->load->library('pdf');
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->setPrintFooter(false);
			$pdf->setPrintHeader(false);
			$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
			$pdf->AddPage('');
			$pdf->SetFont('');


			$tabel = '
			<table class="table table-bordered table-strip" border="1px">
        <thead>
            <tr>
                <th>No.</th>
                <th>Bulan/Tanggal</th>
                <th>Jumlah Transaksi</th>
                <th>Total Pemasukan</th>
            </tr>
        </thead>
        <tbody>';

			$no = 1;
			foreach ($data as $key => $value) {
				$tabel .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>' . $value->tgl_inv . '</td>
                    <td class="text-center">' . $value->total_order . '</td>
                    <td>' . $this->alus_auth->rupiahrp($value->total_uang) . '</td>
                </tr>';
				$no++;
			}
			$table .= '</tbody></table>';

			/*echo $tabel;
	        die();*/
			$pdf->writeHTML($tabel);

			ob_end_clean();

			$pdf->Output('Laporan Transaksi (' . date('d-m-Y', strtotime($this->input->get('awal'))) . ' - ' . date('d-m-Y', strtotime($this->input->get('akhir'))) . ').pdf', 'D');
		}
	}

	function export_stok(){
		$jenis = $this->input->get('jenis') ? $this->input->get('jenis') : 'excel';
		$ret = $this->alus_auth->ajax_stok_obat_by_id();
		$data_mentah = $ret['data'];
		$thobat= "";
		$thcolspan= 6;
		switch ($this->input->get('content')){
				case 'obat':
					$ar2 = $this->alus_auth->filter_array_2d_not_match($data_mentah, 11, $this->id_alkes);//filter alkes
	    			$arr = $this->alus_auth->filter_array_2d_not_match($ar2, 4, TRUE);
	    			$judul = "Laporan Persediaan Obat";
	    			$thobat = "<th>Tanggal Kadaluarsa</th>";
	    			$thcolspan = 7;
					break;
				case 'alkes':
					$arr = $this->alus_auth->filter_array_2d_match($data_mentah, 11, $this->id_alkes);
					$judul = "Laporan Persediaan Alkes";
					break;
				case 'obatkd':
					$ar2 = $this->alus_auth->filter_array_2d_not_match($data_mentah, 11, $this->id_alkes);//filter alkes
	      			$arr = $this->alus_auth->filter_array_2d_match($ar2, 4, TRUE);//filter kadaluarsa
	      			$judul = "Laporan Persediaan Obat Kadaluarsa";
	      			$thobat = "<th>Tanggal Kadaluarsa</th>";
	      			$thcolspan = 7;
					break;
				default :
					$arr = null;
					break;
			}
		$data['x'] = $arr;
		$data['judul'] = $judul; 
		if($jenis == 'excel'){
			$this->load->view('ajax/export_stok', $data, FALSE);
		}else{
			$tabel = '
			<html>
			<head>
			<style>
			body{
				font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
					font-size: 1rem;
					font-weight: 400;
					line-height: 1.5;
					color: #212529;
					text-align: left;
			}
			table.table-bordered.dataTable th, table.table-bordered.dataTable td {
    			border-left-width: 0;
			}
			bordered thead th {
    			border-bottom-width: 2px;
			}
			.table thead th {
   				vertical-align: bottom;
    			border-bottom: 2px solid #dee2e6;
        		border-bottom-width: 2px;
			}
			table.dataTable th {
    			-webkit-box-sizing: content-box;
    			box-sizing: content-box;
			}
			th {
    			border: 1px solid #dee2e6;
        		border-bottom-color: rgb(222, 226, 230);
        		border-bottom-style: solid;
        		border-bottom-width: 1px;
        		border-left-width: 1px;
			}
			.table td, .table th {
    			padding: .75rem;
    			vertical-align: top;
    			border-top: 1px solid #dee2e6;
			}
			th {
    			text-align: center;
			}
			td.text-center{
				text-align:center;
			}
			p{
				line-height:5px;
			}
			.font-weight-light {
    			font-weight: 300 !important;
			}
			.brand-text{
			    float: left;
			    line-height: .8;
			    margin-left: .8rem;
			    margin-right: .5rem;
			    margin-top: -3px;
			    max-height: 33px;
			    width: auto;
			    font-size:3em;
			}
			.img-circle {
			    border-radius: 50%;
			}
			img {
			    vertical-align: middle;
			    border-style: none;
			}
			</style>
			</head>
			<body>
			<div>
			<span class="brand-text font-weight-light">
			<img src="'.base_url("assets/logo/askrindo-mini.png").'" alt="Askrindo Logo" class="brand-image img-circle elevation-3" width="50px" height="50px" style="opacity: .8">
      		Apotek App</span>
      		</div>
      		<br/>
      		<br/>
      		<div>
			<table class="table table-bordered table-strip">
        <thead>
        	<tr>
        		<th colspan="'.$thcolspan.'"><p><h3>'.$judul.'</h3></p><p>Per Tanggal '.date('d-m-Y').'</p></th>
        	</tr>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Batch ID</th>
                '.$thobat.'
                <th>Supplier</th>
                <th>Stok</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>';
        	$dat = $data['x'];
			for($i = 0; $i < count($dat); $i++){
                $tabel .= "
                 <tr>
                  <td class='text-center'>".($i + 1).".</td>
                  <td>".$dat[$i][0]."</td>
                  <td>".$dat[$i][3]."</td>";
                  if($this->input->get('content')!='alkes'){
                  	$tabel .= "<td>".$dat[$i][1]."</td>";
                  }
                 $tabel .="<td>".$dat[$i][10]."</td>
                  <td>".$dat[$i][2]."</td>
                  <td>".$dat[$i][7]."</td>
                 </tr>
                ";
            }
			$tabel .= '</tbody></div></table></body></html>';

			/*echo $tabel;
	        die();*/
	        $orientation = 'portrait';
	        $paper = 'A4';
	        $this->pdf2->generate($tabel, $judul, $paper, $orientation);
		}
	}
	/* Server Side Data */
	/* Modified by : Maulana.code@gmail.com */
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */