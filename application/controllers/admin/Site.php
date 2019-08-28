<?php
/**
 * 微信管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Site extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('site_model'));
    }
    
    public function index($offset = 0)
    {
    	$offset = intval($offset);
    	
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$list = $this->site_model->getList($params, null, $offset, $limit);
    	$count = $this->site_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/site/index", array(
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
    		$this->form_validation->set_rules('name', 'name', valid_string_rule(1, 60, true));
    		$this->form_validation->set_rules('token', 'token', valid_text_rule(true));
    		$this->form_validation->set_rules('appid', 'appid', valid_text_rule(true));
    		$this->form_validation->set_rules('appsecret', 'appsecret', valid_text_rule(true));
    		$this->form_validation->set_rules('type', 'type', valid_int_rule(true));
    		$this->form_validation->set_rules('verify', 'verify', valid_int_rule(true));
    		
    		$this->form_validation->set_rules('pay_api_key', 'pay_api_key', valid_text_rule());
    		$this->form_validation->set_rules('pay_mch_id', 'pay_mch_id', valid_string_rule());
    		$this->form_validation->set_rules('pay_status', 'pay_status', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/site/add');
    		}
    		$name = $this->form_validation->set_value('name');
    		$token = $this->form_validation->set_value('token');
    		$appid = $this->form_validation->set_value('appid');
    		$appsecret = $this->form_validation->set_value('appsecret');
    		$type = $this->form_validation->set_value('type');
    		$verify = $this->form_validation->set_value('verify');
    		
    		$params = array();
    		$params['name'] = $name;
    		$params['token'] = $token;
    		$params['appid'] = $appid;
    		$params['appsecret'] = $appsecret;
    		$params['type'] = $type;
    		$params['verify'] = $verify;
    		$params['admin_id'] = get_adminid();
    		$params['create_time'] = time();
    		$site_id = $this->site_model->insertInfo($params);
    		
    		$params = array();
    		$params['site_id'] = $site_id;
    		$params['admin_id'] = get_adminid();
    		$this->admin_site_model->insertInfo($params);
    		
    		refresh_adminsites();
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
    		
    		return redirect('admin/site/edit?site_id='.$site_id);
    	}
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	return $this->load->view("admin/site/add", array(
    		'olddata' => $olddata
    	));
    }
    
	public function edit()
	{
		$site_id = $this->input->get('site_id', true);
		if (!$site_id)
		{
			//如果没有此参数, 则默认是编辑当前站点
			$site_id = get_siteid();
		}
		
		$info = $this->site_model->getInfo($site_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($site_id)));
			$this->session->set_flashdata('error', lang('site_notexist'));
			return redirect('admin/site/index');
		}
		
		//判断权限
// 		if (!is_userweixin(get_siteid()))
// 		{
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($site_id)));
// 			$this->session->set_flashdata('error', lang('weixin_notowner'));
// 			return redirect('admin/site/index');
// 		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('name', 'name', valid_string_rule(1, 60, true));
    		$this->form_validation->set_rules('token', 'token', valid_text_rule(true));
    		$this->form_validation->set_rules('appid', 'appid', valid_text_rule(true));
    		$this->form_validation->set_rules('appsecret', 'appsecret', valid_text_rule(true));
    		$this->form_validation->set_rules('type', 'type', valid_int_rule(true));
    		$this->form_validation->set_rules('verify', 'verify', valid_int_rule(true));
    		
    		$this->form_validation->set_rules('pay_api_key', 'pay_api_key', valid_text_rule());
    		$this->form_validation->set_rules('pay_mch_id', 'pay_mch_id', valid_string_rule());
    		$this->form_validation->set_rules('pay_status', 'pay_status', valid_int_rule());
    		
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			return redirect('admin/site/edit?site_id='.$site_id);
    		}
    		$name = $this->form_validation->set_value('name');
    		$token = $this->form_validation->set_value('token');
    		$appid = $this->form_validation->set_value('appid');
    		$appsecret = $this->form_validation->set_value('appsecret');
    		$type = $this->form_validation->set_value('type');
    		$verify = $this->form_validation->set_value('verify');
    		
    		$pay_api_key = $this->form_validation->set_value('pay_api_key');
    		$pay_mch_id = $this->form_validation->set_value('pay_mch_id');
    		$pay_status = $this->form_validation->set_value('pay_status');
		
    		$params = array();
    		$params['name'] = $name;
    		$params['token'] = $token;
    		$params['appid'] = $appid;
    		$params['appsecret'] = $appsecret;
    		$params['type'] = $type;
    		$params['verify'] = $verify;
    		$params['admin_id'] = get_adminid();
    		
    		$params['pay_api_key'] = $pay_api_key;
    		$params['pay_mch_id'] = $pay_mch_id;
    		$params['pay_status'] = $pay_status;
			$result = $this->site_model->updateInfo($site_id, $params);
			
			refresh_adminsites();
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
			
			return redirect('admin/site/edit?site_id='.$site_id);
		}
		
		return $this->load->view("admin/site/edit", array(
				'info' => $info,
		));
	}
	
	
	
	
}
?>