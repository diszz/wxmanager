<?php
/**
 * 礼包管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.09.10
 */
class Signin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('signin_model','signin_item_model','code_model'));
    }
    
    public function index($offset = 0)
    {
    	$offset = intval($offset);
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$list = $this->signin_model->getList($params, null, $offset, $limit);
    	$count = $this->signin_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/signin/index", array(
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
    		$this->form_validation->set_rules('name', 'name', valid_string_rule(true));
    		$this->form_validation->set_rules('cycle', 'cycle', valid_int_rule());
    		$this->form_validation->set_rules('is_continue', 'is_continue', valid_int_rule());
    		$this->form_validation->set_rules('is_loop', 'is_loop', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string(), $this->input->post())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/signin/add');
    		}
    		$name = $this->form_validation->set_value('name');
    		$cycle = $this->form_validation->set_value('cycle');
    		$is_continue = $this->form_validation->set_value('is_continue');
    		$is_loop = $this->form_validation->set_value('is_loop');
    		
    		$params = array();
    		$params['site_id'] = get_siteid();
    		$params['name'] = $name;
    		$params['cycle'] = (int)$cycle;
    		$params['is_continue'] = (int)$is_continue;
    		$params['is_loop'] = (int)$is_loop;
    		$params['has_code'] = 0;
    		$params['item_count'] = 0;
    		$params['create_time'] = time();
    		$signin_id = $this->signin_model->insertInfo($params);
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
    		
    		return redirect('admin/signin/edit?signin_id='.$signin_id);
    	}
    	
    	//获取礼包列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$codeList = $this->code_model->getList($params, null, 0, 999);
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	return $this->load->view("admin/signin/add", array(
    			'olddata' => $olddata,
    			'codeList' => $codeList
    	));
    }
    
	public function edit()
	{
		$signin_id = $this->input->get('signin_id', true);
		if (!$signin_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $signin_id empty '.serialize(array($signin_id)));
			return redirect('admin/signin/index');
		}
		
		$info = $this->signin_model->getInfo($signin_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $info empty '.serialize(array($signin_id)));
			return redirect('admin/signin/index');
		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('name', 'name', valid_string_rule(1, 60, true));
			$this->form_validation->set_rules('cycle', 'cycle', valid_int_rule());
    		$this->form_validation->set_rules('is_continue', 'is_continue', valid_int_rule());
    		$this->form_validation->set_rules('is_loop', 'is_loop', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/signin/edit?signin_id='.$signin_id);
    		}
    		$name = $this->form_validation->set_value('name');
    		$cycle = $this->form_validation->set_value('cycle');
    		$is_continue = $this->form_validation->set_value('is_continue');
    		$is_loop = $this->form_validation->set_value('is_loop');
    		
    		$params = array();
    		$params['site_id'] = get_siteid();
    		$params['name'] = $name;
    		$params['cycle'] = (int)$cycle;
    		$params['is_continue'] = (int)$is_continue;
    		$params['is_loop'] = (int)$is_loop;
    		$params['has_code'] = 0;
    		$params['item_count'] = 0;
			$result = $this->signin_model->updateInfo($signin_id, $params);
			
			$params = array();
			$params['signin_id'] = $signin_id;
			$signinItemList = $this->signin_item_model->getList($params, null, 0, 999);
			if ($signinItemList)
			{
				foreach ($signinItemList as $item)
				{
					$this->signin_item_model->deleteInfo($item['signin_item_id']);
				}
			}
			
			$has_code = 0;
			$item_count = 0;
			$code_ids = $this->input->post('code', true);
			$success_words = $this->input->post('success_word', true);
			$repeat_words = $this->input->post('repeat_word', true);
			foreach ($code_ids as $times => $code_id)
			{
				$params = array();
				$params['signin_id'] = $signin_id;
				$params['code_id'] = '';
				$params['success_word'] = !empty($success_words[$times]) ? $success_words[$times] : '';
				$params['repeat_word'] = !empty($repeat_words[$times]) ? $repeat_words[$times] : '';
				$params['times'] = $times + 1;
				
				if ($code_id)
				{
					$params['code_id'] = $code_id;
					$has_code = 1;
				}
				
				$item_count++;
				
				$this->signin_item_model->insertInfo($params);
			}
			
			$params = array();
			$params['has_code'] = $has_code;
			$params['item_count'] = $item_count;
			$result = $this->signin_model->updateInfo($info['signin_id'], $params);
			
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
			
			return redirect('admin/signin/edit?signin_id='.$signin_id);
		}
		
		//获取礼包列表
		$params = array();
		$params['site_id'] = get_siteid();
		$codeList = $this->code_model->getList($params, null, 0, 999);
		
		$params = array();
		$params['signin_id'] = $signin_id;
		$signinCodeList = $this->signin_item_model->getList($params, null, 0, 999);
		
		return $this->load->view("admin/signin/edit", array(
				'info' => $info,
				'codeList' => $codeList,
				'signinCodeList' => $signinCodeList
		));
	}
	
	public function del()
	{
		$signin_id = $this->input->get('signin_id', true);
		if (!$signin_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' signin_id empty '.serialize(array($signin_id)));
			return redirect('admin/signin/index');
		}
	
		$info = $this->signin_model->getInfo($signin_id);
	
		//判断权限
// 		if ($info['site_id'] != get_siteid())
// 		{
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($signin_id)));
// 			$this->session->set_flashdata('error', lang('weixin_notowner'));
// 			return redirect('admin/signin/index');
// 		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->signin_model->deleteInfo($signin_id);
			
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($signin_id)));
	
			return redirect('admin/signin/index');
		}
	
		return $this->load->view("admin/signin/del", array(
				'info' => $info,
		));
	}
	
}
?>