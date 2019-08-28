<?php
/**
 * 综合首页
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Index extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array(
        		"admin_model", 
        		"site_model",
        ));
    }
    
    public function index()
    {
    	//站点列表
    	$site_arr = get_adminsites();
    	
    	return $this->load->view("admin/index/index", array(
    			'site_arr' => $site_arr,
    	));
    }
    
    
    public function select_site()
    {
    	$site_id = $this->input->get('site_id', true);
    	$site_info = $this->site_model->getInfo($site_id);
    	if (!$site_info)
    	{
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' site_id empty '.serialize(array($site_id)));
    		$this->session->set_flashdata('error', lang('site_notexist'));
    		return redirect('admin/index/index');
    	}
    	
    	
    	$this->session->set_userdata(array('site_info' => $site_info));
    	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $site_info '.serialize($this->log_data));
    	
    	if (!get_siteinfo())
    	{
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' site_id empty '.serialize(array($site_id)));
    		$this->session->set_flashdata('error', lang('site_notexist'));
    		return redirect('admin/index/index');
    	}
    	
    	return redirect('admin/index/site');
    }
    
    public function site()
    {
    	$this->load->model(array("Client_record_model"));
    	
    	//交互记录统计
    	$recordStatisticals = $this->Client_record_model->getStatistical(get_siteid(), 6);
    	 
    	$recordKeywordStat = $this->Client_record_model->getKeywordStat(get_siteid(), 6);
    	 
    	$recordTypeStat = $this->Client_record_model->getRecordTypeStat(get_siteid(), 6);
    	
    	return $this->load->view("admin/index/site", array(
    			'recordStatisticals' => $recordStatisticals,
    			'recordKeywordStat' => $recordKeywordStat,
    			'recordTypeStat' => $recordTypeStat
    	));
    }
	
    public function login()
    {
    	if (get_admininfo())
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' logined '.serialize(array(get_admininfo(), $this->log_data)));
			return redirect('admin/index');
		}
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' login '.serialize(array(get_admininfo(), $this->log_data)));
        
        //提交表单
        if (is_post())
        {
        	$this->form_validation->set_rules('email', 'email', valid_email_rule(true));
        	$this->form_validation->set_rules('password', 'password', valid_string_rule(true));
        	$this->form_validation->set_rules('remember', 'remember', valid_int_rule());
        	if (!$this->form_validation->run())
        	{
        		$message = $this->form_validation->error_string();
        		$this->session->set_flashdata('error', $message);
        		$this->session->set_flashdata('olddata', $this->input->post());
        		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string(), $this->log_data)));
        		return redirect('admin/index/login');
        	}
        	$email = $this->form_validation->set_value('email');
        	$password = $this->form_validation->set_value('password');
        	$remember = $this->form_validation->set_value('remember');
        	
        	$where = array();
        	$where['email'] = $email;
        	$admin_info = $this->admin_model->getInfoByAttribute($where, 0);
        	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' getInfoByAttribute '.serialize(array($admin_info, $this->log_data)));
        	if (!$admin_info)
        	{
        		$this->session->set_flashdata('error', lang('admin_notexist'));
        		$this->session->set_flashdata('olddata', $this->input->post());
        		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' email notfound '.serialize(array($where, $this->log_data)));
        		return redirect('admin/index/login');
        	}
        	if ($admin_info['password'] != $password)
        	{
        		$this->session->set_flashdata('error', lang('admin_nameorpasserr'));
        		$this->session->set_flashdata('olddata', $this->input->post());
        		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' password wrong '.serialize(array($admin_info, $this->log_data)));
        		return redirect('admin/index/login');
        	}
        	
        	$attributes = array();
        	$attributes['last_login_time'] = time();
        	$attributes['last_login_ip'] = $this->input->ip_address();
        	$attributes['last_login_device'] = '';
			$this->admin_model->updateInfo($admin_info['admin_id'], $attributes);
			
			$this->session->set_userdata(array('admin_info' => $admin_info));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' admindata1 '.serialize($this->log_data));
			
			//权限
			refresh_adminsites();
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' admindata1 '.serialize($this->log_data));
			
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' succ1 '.serialize(array($admin_info, $this->log_data)));
			return redirect('admin/index/index');
        }
        
        $olddata = $this->session->flashdata('olddata');
        
		return $this->load->view("admin/index/login", array(
				'olddata' => $olddata
		));
    }
    
    //退出
    public function logout()
    {
    	$sessionData = array(
    			'admin_info' => "",
    			'admin_sites' => "",
    	);
    	$this->session->set_userdata($sessionData);
    
    	return redirect('admin/index/login');
    }
    
    public function uploadfile_to_cdn()
    {
    	if (is_post())
    	{
    		set_time_limit(0);
    		ini_set("memory_limit", "1024M");
    		header("Content-type: text/html; charset=utf-8");
    
    		$file_path = upload_file($_FILES['imgFile']);
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' upload_file $file_path '.serialize(array($file_path)));
    
    		$result = upload_to_cdn($file_path);
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' upload_to_cdn $file_path '.serialize(array($result)));
    
    		echo json_encode($result);
    		return ;
    	}
    }
}
?>