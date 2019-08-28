<?php
/**
 * 管理员管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2016.03.09
 */
class Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('admin_model', 'site_model', 'admin_site_model'));
    }
    
    public function index($offset = 0)
    {
    	$offset = intval($offset);
    	
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$list = $this->admin_model->getList($params, null, $offset, $limit);
    	$count = $this->admin_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/admin/index", array(
    			'list' => $list, 
    			'pagination' => $pagination
    	));
    }
    
    public function add()
    {
    	//提交表单
    	if (is_post())
    	{
    		//添加微信信息
    		$this->form_validation->set_rules('email', 'email', valid_email_rule(true));
    		$this->form_validation->set_rules('password', 'password', valid_string_rule(6, 30, true));
    		$this->form_validation->set_rules('is_superadmin', 'is_superadmin', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/admin/add');
    		}
    		$email = $this->form_validation->set_value('email');
    		$password = $this->form_validation->set_value('password');
    		$is_superadmin = $this->form_validation->set_value('is_superadmin');
    		
    		$params = array();
    		$params['email'] = $email;
    		$params['password'] = $password;
    		$params['is_superadmin'] = $is_superadmin;
    		$params['create_time'] = time();
    		$admin_id = $this->admin_model->insertInfo($params);
    		
    		//分配的站点
    		$site_ids = $this->input->post('site_ids', true);
    		if($site_ids)
    		{
    			foreach ($site_ids as $site_id)
    			{
    				$params = array();
    				$params['site_id'] = $site_id;
    				$params['admin_id'] = $admin_id;
    				$this->admin_site_model->insertInfo($params);
    			}
    		}
    		
    		refresh_adminsites();
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
    		
    		return redirect('admin/admin/edit?admin_id='.$admin_id);
    	}
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	
    	//全部站点
    	$siteList = $this->site_model->getList(null, null, 0, 99);
    	
    	return $this->load->view("admin/admin/add", array(
    			'olddata' => $olddata,
    			'siteList' => $siteList
    	));
    }
    
	public function edit()
	{
		$admin_id = $this->input->get('admin_id', true);
		if (!$admin_id)
		{
			//如果没有此参数, 则默认是编辑当前管理员
			$admin_id = get_adminid();
		}
		
		$info = $this->admin_model->getInfo($admin_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($admin_id)));
			$this->session->set_flashdata('error', lang('admin_notexist'));
			return redirect('admin/admin/index');
		}
		
		//判断权限
// 		if (!is_userweixin(get_adminid()))
// 		{
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($admin_id)));
// 			$this->session->set_flashdata('error', lang('weixin_notowner'));
// 			return redirect('admin/admin/index');
// 		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('email', 'email', valid_email_rule(true));
    		$this->form_validation->set_rules('password', 'password', valid_string_rule(6, 30));
    		$this->form_validation->set_rules('is_superadmin', 'is_superadmin', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			return redirect('admin/admin/edit?admin_id='.$admin_id);
    		}
    		$email = $this->form_validation->set_value('email');
    		$password = $this->form_validation->set_value('password');
    		$is_superadmin = $this->form_validation->set_value('is_superadmin');
		
    		$params = array();
    		$params['email'] = $email;
    		$password && $params['password'] = $password;
    		$params['is_superadmin'] = $is_superadmin;
			$result = $this->admin_model->updateInfo($admin_id, $params);
			
			//清空分配的站点
			$params = array();
			$params['admin_id'] = $admin_id;
			$adminSiteList = $this->admin_site_model->getList($params, null, 0, 99);
			if ($adminSiteList)
			{
				foreach ($adminSiteList as $item)
				{
					$this->admin_site_model->deleteInfo($item['admin_site_id']);
				}
			}
			
			//分配的站点
			$site_ids = $this->input->post('site_ids', true);
			if($site_ids)
			{
				foreach ($site_ids as $site_id)
				{
					$params = array();
					$params['site_id'] = $site_id;
					$params['admin_id'] = $admin_id;
					$this->admin_site_model->insertInfo($params);
				}
			}
			
			refresh_adminsites();
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
			
			return redirect('admin/admin/edit?admin_id='.$admin_id);
		}
		
		//全部站点
		$siteList = $this->site_model->getList(null, null, 0, 99);
		
		$attributes = array();
		$attributes['admin_id'] = $admin_id;
		$adminSiteList = $this->admin_site_model->getList($attributes, null, 0, 99);
		
		return $this->load->view("admin/admin/edit", array(
				'info' => $info,
				'siteList' => $siteList,
				'adminSiteList' => $adminSiteList
		));
	}
	
}
?>