<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth
*
* Version: 2.5.2
*
* Author: Ben Edmunds
*		  ben.edmunds@gmail.com
*         @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Alus_auth
{
	/**
	 * account status ('not_activated', etc ...)
	 *
	 * @var string
	 **/
	protected $status;

	/**
	 * extra where
	 *
	 * @var array
	 **/
	public $_extra_where = array();

	/**
	 * extra set
	 *
	 * @var array
	 **/
	public $_extra_set = array();

	/**
	 * caching of users and their groups
	 *
	 * @var array
	 **/
	public $_cache_user_in_group;

	/**
	 * __construct
	 *
	 * @return void
	 * @author Ben
	 **/
	public function __construct()
	{
		$this->load->config('alus_auth', TRUE);
		$this->load->library(array('email'));
		$this->lang->load('alus_auth');
		$this->load->helper(array('cookie', 'language','url'));

		$this->load->library('session');

		$this->load->model('alus_auth_model');
		$this->load->model('stok_depan_model');

		$this->_cache_user_in_group =& $this->alus_auth_model->_cache_user_in_group;

		//auto-login the user if they are remembered
		if (!$this->logged_in() && get_cookie($this->config->item('identity_cookie_name', 'alus_auth')) && get_cookie($this->config->item('remember_cookie_name', 'alus_auth')))
		{
			$this->alus_auth_model->login_remembered_user();
		}

		$email_config = $this->config->item('email_config', 'alus_auth');

		if ($this->config->item('use_ci_email', 'alus_auth') && isset($email_config) && is_array($email_config))
		{
			$this->email->initialize($email_config);
		}

		$this->alus_auth_model->trigger_events('library_constructor');
	}

	/**
	 * __call
	 *
	 * Acts as a simple way to call model methods without loads of stupid alias'
	 *
	 **/
	public function __call($method, $arguments)
	{
		if (!method_exists( $this->alus_auth_model, $method) )
		{
			throw new Exception('Undefined method alus_auth::' . $method . '() called');
		}
		if($method == 'create_user')
		{
			return call_user_func_array(array($this, 'register'), $arguments);
		}
		if($method=='update_user')
		{
			return call_user_func_array(array($this, 'update'), $arguments);
		}
		return call_user_func_array( array($this->alus_auth_model, $method), $arguments);
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}


	/**
	 * forgotten password feature
	 *
	 * @return mixed  boolian / array
	 * @author Mathew
	 **/
	public function forgotten_password($identity)    //changed $email to $identity
	{
		if ( $this->alus_auth_model->forgotten_password($identity) )   //changed
		{
			// Get user information
      $identifier = $this->alus_auth_model->identity_column; // use model identity column, so it can be overridden in a controller
      $user = $this->where($identifier, $identity)->where('active', 1)->users()->row();  // changed to get_user_by_identity from email

			if ($user)
			{
				$data = array(
					'identity'		=> $user->{$this->config->item('identity', 'alus_auth')},
					'forgotten_password_code' => $user->jkl
				);

				if(!$this->config->item('use_ci_email', 'alus_auth'))
				{
					$this->set_message('forgot_password_successful');
					return $data;
				}
				else
				{
					$message = $this->load->view($this->config->item('email_templates', 'alus_auth').$this->config->item('email_forgot_password', 'alus_auth'), $data, true);
					$this->email->clear();
					$this->email->from($this->config->item('admin_email', 'alus_auth'), $this->config->item('site_title', 'alus_auth'));
					$this->email->to($user->email);
					$this->email->subject($this->config->item('site_title', 'alus_auth') . ' - ' . $this->lang->line('email_forgotten_password_subject'));
					$this->email->message($message);

					if ($this->email->send())
					{
						$this->set_message('forgot_password_successful');
						return TRUE;
					}
					else
					{
						$this->set_error('forgot_password_unsuccessful');
						return FALSE;
					}
				}
			}
			else
			{
				$this->set_error('forgot_password_unsuccessful');
				return FALSE;
			}
		}
		else
		{
			$this->set_error('forgot_password_unsuccessful');
			return FALSE;
		}
	}

	/**
	 * forgotten_password_complete
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code)
	{
		$this->alus_auth_model->trigger_events('pre_password_change');

		$identity = $this->config->item('identity', 'alus_auth');
		$profile  = $this->where('jkl', $code)->users()->row(); //pass the code to profile

		if (!$profile)
		{
			$this->alus_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$new_password = $this->alus_auth_model->forgotten_password_complete($code, $profile->def);

		if ($new_password)
		{
			$data = array(
				'identity'     => $profile->{$identity},
				'new_password' => $new_password
			);
			if(!$this->config->item('use_ci_email', 'alus_auth'))
			{
				$this->set_message('password_change_successful');
				$this->alus_auth_model->trigger_events(array('post_password_change', 'password_change_successful'));
					return $data;
			}
			else
			{
				$message = $this->load->view($this->config->item('email_templates', 'alus_auth').$this->config->item('email_forgot_password_complete', 'alus_auth'), $data, true);

				$this->email->clear();
				$this->email->from($this->config->item('admin_email', 'alus_auth'), $this->config->item('site_title', 'alus_auth'));
				$this->email->to($profile->email);
				$this->email->subject($this->config->item('site_title', 'alus_auth') . ' - ' . $this->lang->line('email_new_password_subject'));
				$this->email->message($message);

				if ($this->email->send())
				{
					$this->set_message('password_change_successful');
					$this->alus_auth_model->trigger_events(array('post_password_change', 'password_change_successful'));
					return TRUE;
				}
				else
				{
					$this->set_error('password_change_unsuccessful');
					$this->alus_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
					return FALSE;
				}

			}
		}

		$this->alus_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
		return FALSE;
	}

	/**
	 * forgotten_password_check
	 *
	 * @return void
	 * @author Michael
	 **/
	public function forgotten_password_check($code)
	{
		$profile = $this->where('jkl', $code)->users()->row(); //pass the code to profile

		if (!is_object($profile))
		{
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}
		else
		{
			if ($this->config->item('forgot_password_expiration', 'alus_auth') > 0) {
				//Make sure it isn't expired
				$expiration = $this->config->item('forgot_password_expiration', 'alus_auth');
				if (time() - $profile->stu > $expiration) {
					//it has expired
					$this->clear_forgotten_password_code($code);
					$this->set_error('password_change_unsuccessful');
					return FALSE;
				}
			}
			return $profile;
		}
	}

	/**
	 * register
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function register($identity, $password, $email, $additional_data = array(), $group_ids = array()) //need to test email activation
	{
		$this->alus_auth_model->trigger_events('pre_account_creation');

		$email_activation = $this->config->item('email_activation', 'alus_auth');

		$id = $this->alus_auth_model->register($identity, $password, $email, $additional_data, $group_ids);

		if (!$email_activation)
		{
			if ($id !== FALSE)
			{
				$this->set_message('account_creation_successful');
				$this->alus_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful'));
				return $id;
			}
			else
			{
				$this->set_error('account_creation_unsuccessful');
				$this->alus_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
				return FALSE;
			}
		}
		else
		{
			if (!$id)
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}

			// deactivate so the user much follow the activation flow
			$deactivate = $this->alus_auth_model->deactivate($id);

			// the deactivate method call adds a message, here we need to clear that
			$this->alus_auth_model->clear_messages();


			if (!$deactivate)
			{
				$this->set_error('deactivate_unsuccessful');
				$this->alus_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
				return FALSE;
			}

			$activation_code = $this->alus_auth_model->activation_code;
			$identity        = $this->config->item('identity', 'alus_auth');
			$user            = $this->alus_auth_model->user($id)->row();

			$data = array(
				'identity'   => $user->{$identity},
				'id'         => $user->id,
				'abc'      => $email,
				'activation' => $activation_code,
			);
			if(!$this->config->item('use_ci_email', 'alus_auth'))
			{
				$this->alus_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
				$this->set_message('activation_email_successful');
				return $data;
			}
			else
			{
				$message = $this->load->view($this->config->item('email_templates', 'alus_auth').$this->config->item('email_activate', 'alus_auth'), $data, true);

				$this->email->clear();
				$this->email->from($this->config->item('admin_email', 'alus_auth'), $this->config->item('site_title', 'alus_auth'));
				$this->email->to($email);
				$this->email->subject($this->config->item('site_title', 'alus_auth') . ' - ' . $this->lang->line('email_activation_subject'));
				$this->email->message($message);

				if ($this->email->send() == TRUE)
				{
					$this->alus_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
					$this->set_message('activation_email_successful');
					return $id;
				}

			}

			$this->alus_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
			$this->set_error('activation_email_unsuccessful');
			return FALSE;
		}
	}

	/**
	 * logout
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function logout()
	{
		$this->alus_auth_model->trigger_events('logout');

		$identity = $this->config->item('identity', 'alus_auth');

                if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->unset_userdata( array($identity => '', 'id' => '', 'user_id' => '') );
                }
                else
                {
                	$this->session->unset_userdata( array($identity, 'id', 'user_id') );
                }

		// delete the remember me cookies if they exist
		if (get_cookie($this->config->item('identity_cookie_name', 'alus_auth')))
		{
			delete_cookie($this->config->item('identity_cookie_name', 'alus_auth'));
		}
		if (get_cookie($this->config->item('remember_cookie_name', 'alus_auth')))
		{
			delete_cookie($this->config->item('remember_cookie_name', 'alus_auth'));
		}

		// Destroy the session
		$this->session->sess_destroy();

		//Recreate the session
		if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->sess_create();
		}
		else
		{
			//$this->session->sess_destroy();
		}

		$this->set_message('logout_successful');
		return TRUE;
	}

	/**
	 * logged_in
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function logged_in()
	{
		$this->alus_auth_model->trigger_events('logged_in');

		return (bool) $this->session->userdata('identity');
	}

	/**
	 * logged_in
	 *
	 * @return integer
	 * @author jrmadsen67
	 **/
	public function get_user_id()
	{
		$user_id = $this->session->userdata('user_id');
		if (!empty($user_id))
		{
			return $user_id;
		}
		return null;
	}

	public function get_sesi_saldo()
	{
		if (!empty($this->session->userdata('id_sesi')))
		{
			$sesi_saldo = $this->alus_auth_model->get_update_saldo($this->session->userdata('id_sesi'));
			return $sesi_saldo;
		}
		return null;
	}

	/**
	 * is_admin
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function is_admin($id=false)
	{
		$this->alus_auth_model->trigger_events('is_admin');

		$admin_group = $this->config->item('admin_group', 'alus_auth');

		return $this->in_group($admin_group, $id);
	}

	/**
	 * in_group
	 *
	 * @param mixed group(s) to check
	 * @param bool user id
	 * @param bool check if all groups is present, or any of the groups
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function in_group($check_group, $id=false, $check_all = false)
	{
		$this->alus_auth_model->trigger_events('in_group');

		$id || $id = $this->session->userdata('user_id');

		if (!is_array($check_group))
		{
			$check_group = array($check_group);
		}

		if (isset($this->_cache_user_in_group[$id]))
		{
			$groups_array = $this->_cache_user_in_group[$id];
		}
		else
		{
			$users_groups = $this->alus_auth_model->get_users_groups($id)->result();
			$groups_array = array();
			foreach ($users_groups as $group)
			{
				$groups_array[$group->id] = $group->name;
			}
			$this->_cache_user_in_group[$id] = $groups_array;
		}
		foreach ($check_group as $key => $value)
		{
			$groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

			/**
			 * if !all (default), in_array
			 * if all, !in_array
			 */
			if (in_array($value, $groups) xor $check_all)
			{
				/**
				 * if !all (default), true
				 * if all, false
				 */
				return !$check_all;
			}
		}

		/**
		 * if !all (default), false
		 * if all, true
		 */
		return $check_all;
	}

 	/* list table */
 	public function alus_co()
 	{
 		return $this->config->item('alus', 'alus_auth');
 		
 	}

 	/*public function get_theme_header()
 	{
 		return $this->alus_auth_model->get_theme_header();
 	}
 	public function get_theme_menu()
 	{
 		return $this->alus_auth_model->get_theme_menu();
 	}
 	public function get_theme_modal($pilih=null)
 	{
 		return $this->alus_auth_model->get_theme_modal($pilih);
 	}*/
 	public function template($title_head=null,$index_tampil=null,$data=array())
    {
        if($this->alus_auth->logged_in())
         {
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;

            /*DATA*/

            /*END DATA*/
            $this->load->view('template/temaalus/header',$head);
            if($index_tampil)
            {
                $this->load->view($index_tampil,$data);
            }
            $this->load->view('template/temaalus/footer');
        }else
        {
            redirect('panel_login/login','refresh');
        }
    }

    public function rupiahrp($angka){
    	if(!is_numeric($angka))
    	{
			$hasil_rupiah = $angka;
    	}else{
			$hasil_rupiah = "Rp. ".number_format($angka,2,',','.');
    	}
		return $hasil_rupiah;
	}

	public function rupiah($angka){	
		if(!is_numeric($angka))
    	{
			$hasil_rupiah = $angka;
    	}else{
			$hasil_rupiah = number_format($angka,2,'.',',');
    	}
		return $hasil_rupiah;
	}

	public function ajax_stok_obat_by_id($id)
    {
       	$list2 = $this->stok_depan_model->get_datatables($id);
        $data2 = array();
        $status= FALSE;
        $kadaluarsa = FALSE;
        if($list2 != NULL | $list2 != ""){
            $status = TRUE;
        }
        $datenow = new DateTime();
        //$kadaluarsa = FALSE;
        foreach ($list2 as $record2) {
            $row2 = array();
            $row2[] = $record2->mo_nama;//0
            $row2[] = $record2->tb_tgl_kadaluarsa;//1
            $row2[] = $record2->stok;//2
            $row2[] = $record2->tb_id;//3
            $cekkd = new DateTime($record2->tb_tgl_kadaluarsa);
            $beda = $datenow->diff($cekkd);
            $hari = $beda->format('%a');
            if($datenow > $cekkd){
                $kadaluarsa = TRUE;
                $sisahari = $hari;
                $status_kd = "Kadaluarsa";
            }else{
	            if($hari <= 10){
	                $kadaluarsa = FALSE;
	                $sisahari = $hari;
	                $status_kd = "Hampir kadaluarsa";
	            }else{
	                $kadaluarsa = FALSE;
	                $sisahari = $hari;
	                $status_kd = "Ok";
	            }
        	}
            $row2[] = $kadaluarsa;//4
            $row2[] = $sisahari;//5
            $row2[] = $status_kd;//6
            $dataunit = $this->unit->get_by_id($record2->mo_mu_id);
            $row2[] = $dataunit->mu_nama;//7
            $row2[] = $record2->tb_harga_beli;//8
            $row2[] = $record2->tb_harga_jual;//9
            $datasupplier = $this->supplier->get_by_id($record2->tb_ms_id);
            $row2[] = $datasupplier->ms_nama;//10
            $row2[] = $record2->mo_mk_id;//11
            //add html for action
            $data2[] = $row2;
        }
         $output2 = array("status" => $status, "data" => $data2);

        return $output2;
    }

    public function stok_like($content, $resep){
    	return $this->stok_depan_model->get_stok_like($content, $resep);
    }

    public function cek_stok($moid, $tbid, $jumlahRequested){
    	return $this->stok_depan_model->is_in_stock($moid, $tbid, $jumlahRequested);
    }

    public function cek_kadaluarsa($tanggal, $interval){
    	$now = new DateTime();
    	$cek = new DateTime($tanggal);
    	$diff = $now->diff($cek);
    	$days = $diff->format('%a');
    	if($now > $cek){
            $status_kd = "kd";//kadaluarsa
        }else{
	        if($days <= $interval){
	            $status_kd = "hr";//hampir
	        }else{
	            $status_kd = "ok";//ok
	        }
        }
        $data = new stdClass();
        $data->status = $status_kd;
        $data->sisahari = $days;
        return $data;
    }

    public function generateUniqueId($limit){
    	$char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    	$rand = "";
    	for($i = 0; $i < $limit; $i++){
    		$rand .= $char[rand(0, strlen($char)-1)];
    	}

    	return $rand;
    }

    public function arrayBank(){
    	//arraylist untuk bank tersedia
    	//array ini berhubugan langsung dengan CSS bank_indonesia.css
    	//by: Gemintang A.W.
    	//ga12wijaya@gmail.com
    	$arr[] = array("nama" => "Mandiri", "cssid" => "bank-mandiri");
    	$arr[] = array("nama" => "Permata", "cssid" => "bank-permata");
    	$arr[] = array("nama" => "Central Asia", "cssid" => "bank-bca");
    	$arr[] = array("nama" => "Bukopin", "cssid" => "bank-bukopin");
    	$arr[] = array("nama" => "Negara Indonesia", "cssid" => "bank-bni");
    	$arr[] = array("nama" => "Jabar Banten", "cssid" => "bank-bjb");
    	$arr[] = array("nama" => "Rakyat Indonesia", "cssid" => "bank-bri");
    	$arr[] = array("nama" => "Tabungan Pensional Nasional", "cssid" => "bank-btpn");
    	$arr[] = array("nama" => "Indonesia", "cssid" => "bank-bi");
    	$arr[] = array("nama" => "United Overseas (UOB)", "cssid" => "bank-uob");
    	$arr[] = array("nama" => "Tabungan Negara", "cssid" => "bank-btn");
    	$arr[] = array("nama" => "CIMB", "cssid" => "bank-cimb");
    	$arr[] = array("nama" => "Standard Chartered", "cssid" => "bank-chartered");
    	$arr[] = array("nama" => "Other", "cssid" => "bank-other");

    	return $arr;
    }

    public function getSingleBank($bank){
    	$arr = $this->arrayBank();
    	$find = FALSE;
    	$data = "NULL";
    	foreach ($arr as $value) {
    		if($find == FALSE){
	    		if($value['nama'] == $bank){
	    			$data = $value['cssid'];
	    			$find = TRUE;
    			}
    		}
    	}
    	return $data;
    }


    public function tipePembayaran($action, $content){
    	//Array jenis pembayaran
    	$arr[0] = 'Cash';
    	$arr[1] = 'Debit / Kredit';

    	if($action == 'translate'){// maka int -> string
    		return $arr[$content];
    	}else if($action == 'interpret'){// maka cari key dan return -> int
    		$key = array_search($content, $arr);
    		return $key;
    	}else if($action == 'get'){// ambil semua isi array
    		return $arr;
    	}else{
    		return false;
    	}
    }

    public function getAlkesOrItemID($x){
    	if($x != null || $x != ''){
	    	if($x == 'Alkes'){
	    		$field = 'mk_id';
	    		$table = 'm_kategori';
	    		$param = 'mk_nama';
	    	}else if($x == 'Item'){
	    		$field = 'mu_id';
	    		$table = 'm_unit';
	    		$param = 'mu_nama';
	    	}
	    	$this->db->select($field, FALSE);
	    	$this->db->from($table);
	    	$this->db->where($param, $x);
	    	$query = $this->db->get();
	        return $query->row();
	    }else{
	    	return null;
	    }
    }

    public function filter_array_2d_not_match($array, $index, $val){
		        if(is_array($array) && count($array)>0) 
		        {
		            foreach(array_keys($array) as $key){
		                $temp[$key] = $array[$key][$index];
		                
		                if ($temp[$key] != $val){
		                    $newarray[] = $array[$key];
		                }
		            }
		          }
		      return $newarray;
	}

	public function filter_array_2d_match($array, $index, $val){
		        if(is_array($array) && count($array)>0) 
		        {
		            foreach(array_keys($array) as $key){
		                $temp[$key] = $array[$key][$index];
		                
		                if ($temp[$key] == $val){
		                    $newarray[] = $array[$key];
		                }
		            }
		          }
		      return $newarray;
	}
}

