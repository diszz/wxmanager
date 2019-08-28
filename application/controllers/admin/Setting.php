<?php
/**
 * 文章管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Setting extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('setting_model'));
    }
    
    public function index($offset = 0)
    {
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$list = $this->setting_model->getList($params, null, $offset, $limit);
    	$count = $this->setting_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/setting/index", array(
    			'list' => $list, 
    			'pagination' => $pagination,
    	));
    }
    
    public function add()
    {
    	//提交表单
    	if (is_post())
    	{
    		//添加微信信息
    		$this->form_validation->set_rules('key', 'key', valid_string_rule());
			$this->form_validation->set_rules('name', 'name', valid_string_rule());
			$this->form_validation->set_rules('value', 'value', valid_string_rule(0,255));
			if (!$this->form_validation->run())
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string())));
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $this->form_validation->error_string());
				return redirect('admin/setting/add');
			}
			$key = $this->form_validation->set_value('key');
			$name = $this->form_validation->set_value('name');
			$value = $this->form_validation->set_value('value');
    		
    		$data = array();
			$data['key'] = $key;
			$data['name'] = $name;
			$data['value'] = $value;
    		$setting_id = $this->setting_model->insertInfo($data);
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
    		
    		return redirect('admin/setting/edit?setting_id='.$setting_id);
    	}
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	return $this->load->view("admin/setting/add", array(
    		'olddata' => $olddata
    	));
    }
    
	public function edit()
	{
		$setting_id = $this->input->get('setting_id', true);
		if (!$setting_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' setting_id empty '.serialize(array($setting_id)));
			$this->session->set_flashdata('error', 'setting_id empty');
			return redirect('admin/setting/index');
		}
		
		$info = $this->setting_model->getInfo($setting_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($setting_id)));
			$this->session->set_flashdata('error', 'article notexist');
			return redirect('admin/setting/index');
		}
		
		//判断权限
// 		if (!is_userweixin(get_siteid()))
// 		{
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($setting_id)));
// 			$this->session->set_flashdata('error', lang('weixin_notowner'));
// 			return redirect('admin/setting/index');
// 		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('key', 'key', valid_string_rule());
			$this->form_validation->set_rules('name', 'name', valid_string_rule());
			$this->form_validation->set_rules('value', 'value', valid_string_rule(0,255));
			if (!$this->form_validation->run())
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string())));
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $this->form_validation->error_string());
				return redirect('admin/setting/edit?setting_id='.$setting_id);
			}
			$key = $this->form_validation->set_value('key');
			$name = $this->form_validation->set_value('name');
			$value = $this->form_validation->set_value('value');
		
			$data = array();
			$data['key'] = $key;
			$data['name'] = $name;
			$data['value'] = $value;
			$result = $this->setting_model->updateInfo($setting_id, $data);
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
			
			return redirect('admin/setting/edit?setting_id='.$setting_id);
		}
		
		return $this->load->view("admin/setting/edit", array(
				'info' => $info,
		));
	}
	
	public function del()
	{
		$setting_id = $this->input->get('setting_id', true);
		if (!$setting_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' setting_id empty '.serialize(array($setting_id)));
			return redirect('admin/setting/index');
		}
	
		$info = $this->setting_model->getInfo($setting_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($setting_id)));
			$this->session->set_flashdata('error', '设置不存在');
			return redirect('admin/setting/index');
		}
		
		if ($info['is_require'])
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($setting_id)));
			$this->session->set_flashdata('error', '系统设置, 只能编辑不能删除');
			return redirect('admin/setting/index');
		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->setting_model->deleteInfo($setting_id);
				
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($setting_id)));
				
			return redirect('admin/setting/index');
		}
	
		return $this->load->view("admin/setting/del", array(
				'info' => $info,
		));
	}
	
}
?>