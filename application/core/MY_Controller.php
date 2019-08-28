<?php
class MY_Controller extends CI_Controller
{
	protected $log_data = array();
	
	function MY_Controller()
	{
		parent::__construct();
		
		$this->log_data['ip'] = $this->input->ip_address();
        $this->log_data['uri'] = $this->uri->uri_string();
        $this->log_data['referrer'] = $this->agent->referrer();
        $this->log_data['agent_string'] = $this->agent->agent_string();
        
        if ($_REQUEST)
        {
            foreach ($_REQUEST as $k => $v)
            {
                $this->log_data['request'][$k] = strlen(serialize($v)) > 500 ? substr(serialize($v), 0, 500) .'>>500' : serialize($v);
            }
        }

		//请求的路由, 例 admin/index/login
        $path = trim($this->router->fetch_directory() . $this->router->fetch_class().'/'.$this->router->fetch_method(), '/');
        $this->log_data['path'] = $path;
        log_message('error', ' -- request -- Controller start '.json_encode_cn(array($this->agent->agent_string(), $this->log_data)));

        /*****************************************************************
         * 分站逻辑
         *
         ******************************************************************/
        if ($this->router->fetch_directory() == 'admin/')
        {
        	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' root : admin '.json_encode_cn($this->log_data));
        	
        	$this->load->helper('admin_helper');
        	
			//判断角色控制权限
			$admin_id = get_adminid();
			if (!$admin_id)
			{
				if (!in_array($path, array('admin/index/login', '/admin/index/login')))
				{
					log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' check_auth notlogin '.serialize(array($path, $this->log_data)));
					if ($this->input->is_ajax_request())
					{
						response(null, 'user_notlogin', lang('user_notlogin'));
					}
					else
					{
						$this->session->set_flashdata('error', lang('user_notlogin'));
						redirect('admin/index/login');
					}
					exit();
				}
				else
				{
					log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' check_auth isloginpage '.serialize(array($path, $this->log_data)));
				}
			}
			
			//判断是否选择站点
			$site_info = get_siteinfo();
			if (!$site_info)
			{
				if (!in_array($path, array(
						'admin/index/index','admin/index/login','admin/index/logout', 'admin/index/select_site',
						'admin/setting/index','admin/setting/add','admin/setting/edit','admin/setting/del',
						'admin/site/index','admin/site/add','admin/site/edit','admin/site/del',
						'admin/admin/index','admin/admin/add','admin/admin/edit','admin/admin/del',
				)))
				{
					log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' check_auth notlogin '.serialize(array($path, $this->log_data)));
					if ($this->input->is_ajax_request())
					{
						response(null, 'user_notlogin', lang('user_notlogin'));
					}
					else
					{
						$this->session->set_flashdata('error', lang('user_notlogin'));
						redirect('admin/site/index');
					}
					exit();
				}
				else
				{
					log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' check_auth isloginpage '.serialize(array($path, $this->log_data)));
				}
			}
			
        }
        elseif ($this->router->fetch_directory() == 'shop/')
        {
        	
        }
        
        /*********************************************************************/
        
       
        
        /*********************************************************************/
        
	}
}
