<?php
/**
 * 礼包码管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.09.10
 */
class Code_item extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('code_item_model', 'code_model'));
        
    }
    
    public function index($cur_code = 0, $cur_status = -1, $offset = 0)
    {
    	$cur_code = intval($cur_code);
    	$cur_status = intval($cur_status);
    	$offset = intval($offset);
    	
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$cur_code && $params['code_id'] = $cur_code;
    	$cur_status >= 0 && $params['status'] = $cur_status;
    	$list = $this->code_item_model->getList($params, null, $offset, $limit);
    	$count = $this->code_item_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit, $cur_code.'/'.$cur_status);
    	
    	//下载文件
    	$file_exist = false;
    	$file = $this->input->get('file', true);
    	if ($file)
    	{
    		$file = base64_decode_($file);
    		$file_exist = file_exists($file);
    	}
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$codeList = $this->code_model->getList($params, null, 0, 999);
    	
    	return $this->load->view("admin/code_item/index", array(
    			'list' => $list, 
    			'pagination' => $pagination,
    			'codeList' => $codeList,
    			'cur_code' => $cur_code,
    			'cur_status' => $cur_status,
    			'file' => $file,
    			'file_exist' => $file_exist
    	));
    }
    
    public function add()
    {
    	//提交表单
    	if (is_post())
    	{
    		//添加微信信息
    		$this->form_validation->set_rules('code_id', 'code_id', valid_int_rule());
    		$this->form_validation->set_rules('content', 'content', valid_string_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string(), $this->input->post())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/code_item/add');
    		}
    		$code_id = $this->form_validation->set_value('code_id');
    		$content = $this->form_validation->set_value('content');
    		
    		$data = array();
    		$data['site_id'] = get_siteid();
    		$data['code_id'] = $code_id;
    		$data['content'] = $content;
    		$data['create_time'] = time();
    		$code_item_id = $this->code_item_model->insertInfo($data);
    		
    		$data = array();
    		$data['total_count'] = 1;
    		$result = $this->code_model->increment($code_id, $data);
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
    		
    		return redirect('admin/code_item/edit?code_item_id='.$code_item_id);
    	}
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$codeList = $this->code_model->getList($params, null, 0, 999);
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	//红包id, 唯一标识
    	$key_arr = make_uniqids(1, get_setting('code_digit'));
    	$key_str = $key_arr[0];
    	
    	return $this->load->view("admin/code_item/add", array(
    			'olddata' => $olddata,
    			'codeList' => $codeList,
    			'key' => $key_str
    			
    	));
    }
    
	public function edit()
	{
		$code_item_id = $this->input->get('code_item_id', true);
		if (!$code_item_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $code_item_id empty '.serialize(array($code_item_id)));
			return redirect('admin/code/index');
		}
		
		$info = $this->code_item_model->getInfo($code_item_id);
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('code_id', 'code_id', valid_int_rule());
    		$this->form_validation->set_rules('content', 'content', valid_string_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/code_item/add');
    		}
    		$code_id = $this->form_validation->set_value('code_id');
    		$content = $this->form_validation->set_value('content');
    		
    		$data = array();
    		$data['code_id'] = $code_id;
    		$data['site_id'] = get_siteid();
    		$data['content'] = $content;
			$result = $this->code_item_model->updateInfo($code_item_id, $data);
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
			
			return redirect('admin/code_item/edit?code_item_id='.$code_item_id);
		}
		
		$codeInfo = $this->code_model->getInfo($info['code_id']);
		
		$params = array();
		$params['site_id'] = get_siteid();
		$codeList = $this->code_model->getList($params, null, 0, 999);
		
		return $this->load->view("admin/code_item/edit", array(
				'info' => $info,
				'codeInfo' => $codeInfo,
				'codeList' => $codeList
		));
	}
	
	public function del()
	{
		$code_item_id = $this->input->get('code_item_id', true);
		if (!$code_item_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' code_item_id empty '.serialize(array($code_item_id)));
			return redirect('admin/code_item/index');
		}
	
		$info = $this->code_item_model->getInfo($code_item_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($code_item_id)));
			return redirect('admin/code_item/index');
		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->code_item_model->deleteInfo($code_item_id);
			
			$data = array();
			$data['total_count'] = 1;
			$result = $this->code_model->decrement($info['code_id'], $data);
	
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($code_item_id)));
	
			return redirect('admin/code_item/index');
		}
	
		return $this->load->view("admin/code_item/del", array(
				'info' => $info,
		));
	}
}
?>