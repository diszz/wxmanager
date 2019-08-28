<?php
/**
 * 红包码管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Redpack_code extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('redpack_model', 'redpack_code_model'));
    }
    
    public function index($cur_redpack = 0, $cur_type = 0, $offset = 0)
    {
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$cur_redpack && $params['redpack_id'] = $cur_redpack;
    	$cur_type && $params['status'] = ($cur_type == 1 ? 1 : 0);
    	$list = $this->redpack_code_model->getList($params, null, $offset, $limit);
    	$count = $this->redpack_code_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit, $cur_redpack.'/'.$cur_type);
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$redpackList = $this->redpack_model->getList($params, null, 0, 9999);
    	
    	//下载文件
    	$file_exist = false;
    	$file = $this->input->get('file', true);
    	if ($file)
    	{
    		$file = base64_decode_($file);
    		$file_exist = file_exists($file);
    	}
    	
    	return $this->load->view("admin/redpack_code/index", array(
    			'list' => $list, 
    			'pagination' => $pagination,
    			'redpackList' => $redpackList,
    			'cur_redpack' => $cur_redpack,
    			'cur_type' => $cur_type,
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
    		$this->form_validation->set_rules('redpack_id', 'redpack_id', valid_int_rule());
    		$this->form_validation->set_rules('content', 'content', valid_string_rule());
    		$this->form_validation->set_rules('money', 'money', valid_string_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/redpack_code/add');
    		}
    		$redpack_id = $this->form_validation->set_value('redpack_id');
    		$content = $this->form_validation->set_value('content');
    		$money = $this->form_validation->set_value('money');
    		
    		if ($money < 1 || $money > 200)
    		{
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', '金额不正确, 需要在1-200之间');
    			return redirect('admin/redpack_code/add');
    		}
    		
    		$data = array();
    		$data['site_id'] = get_siteid();
    		$data['redpack_id'] = $redpack_id;
    		$data['content'] = $content;
    		$data['money'] = $money;
    		$data['status'] = 0;
    		$data['create_time'] = time();
    		$redpack_code_id = $this->redpack_code_model->insertInfo($data);
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_code_model insertInfo '.serialize(array($data)));
    		
    		$data = array();
    		$data['make_money'] = (int)$money;
    		$data['make_code'] = (int)1;
    		$result = $this->redpack_model->increment($redpack_id, $data);
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
    		
    		return redirect('admin/redpack_code/edit?redpack_code_id='.$redpack_code_id);
    	}
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$redpackList = $this->redpack_model->getList($params, null, 0, 9999);
    	
    	//红包id, 唯一标识
    	$key_arr = make_uniqids(1, get_setting('redpack_digit'));
    	$key_str = $key_arr[0];
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	return $this->load->view("admin/redpack_code/add", array(
    			'olddata' => $olddata,
    			'redpackList' => $redpackList,
    			'key' => $key_str
    	));
    }
    
	public function edit()
	{
		$redpack_code_id = $this->input->get('redpack_code_id', true);
		if (!$redpack_code_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $redpack_code_id empty '.serialize(array($redpack_code_id)));
			return redirect('admin/redpack/index');
		}
		
		$info = $this->redpack_code_model->getInfo($redpack_code_id);
		
		//已送出不能删除/编辑
		if ($info['status'])
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_code_id)));
			$this->session->set_flashdata('error', '红包已送出, 不能删除和编辑');
			return redirect('admin/redpack_code/index');
		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('redpack_id', 'redpack_id', valid_int_rule());
    		$this->form_validation->set_rules('content', 'content', valid_string_rule());
    		$this->form_validation->set_rules('money', 'money', valid_string_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/redpack_code/edit?redpack_code_id='.$redpack_code_id);
    		}
    		$redpack_id = $this->form_validation->set_value('redpack_id');
    		$content = $this->form_validation->set_value('content');
    		$money = $this->form_validation->set_value('money');
    		
    		if ($money < 1 || $money > 200)
    		{
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', '金额不正确, 需要在1-200之间');
    			return redirect('admin/redpack_code/add');
    		}
    		
    		$data = array();
    		$data['site_id'] = get_siteid();
    		$data['redpack_id'] = $redpack_id;
    		$data['content'] = $content;
    		$data['money'] = $money;
			$result = $this->redpack_code_model->updateInfo($redpack_code_id, $data);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_code_model updateInfo '.serialize(array($redpack_code_id, $data)));
			
			$data = array();
			$data['make_money'] = (int) $money - $info['money'];
			$result = $this->redpack_model->increment($redpack_id, $data);
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
			
			return redirect('admin/redpack_code/edit?redpack_code_id='.$redpack_code_id);
		}
		
		$params = array();
    	$params['site_id'] = get_siteid();
    	$redpackList = $this->redpack_model->getList($params, null, 0, 9999);
		
		return $this->load->view("admin/redpack_code/edit", array(
				'info' => $info,
				'redpackList' => $redpackList
		));
	}
	
	public function del()
	{
		$redpack_code_id = $this->input->get('redpack_code_id', true);
		if (!$redpack_code_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_code_id empty '.serialize(array($redpack_code_id)));
			return redirect('admin/redpack_code/index');
		}
	
		$info = $this->redpack_code_model->getInfo($redpack_code_id);
		if (empty($info))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_code_id)));
			return redirect('admin/redpack_code/index');
		}
	
		//已送出不能删除/编辑
		if ($info['status'])
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_code_id)));
			$this->session->set_flashdata('error', '红包已送出, 不能删除和编辑');
			return redirect('redpack_code/index');
		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->redpack_code_model->deleteInfo($redpack_code_id);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_code_model deleteInfo '.serialize(array($info)));
			
			$data = array();
			$data['make_money'] = (int)$info['money'];
			$data['make_code'] = (int)1;
			$result = $this->redpack_model->decrement($info['redpack_id'], $data);
			
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($redpack_code_id)));
	
			return redirect('admin/redpack_code/index');
		}
	
		return $this->load->view("admin/redpack_code/del", array(
				'info' => $info,
		));
	}
	
	
}
?>