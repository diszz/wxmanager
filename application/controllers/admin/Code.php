<?php
/**
 * 礼包管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.09.10
 */
class Code extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('code_model'));
    }
    
    public function index($offset = 0)
    {
    	$offset = intval($offset);
    	
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$list = $this->code_model->getList($params, array('create_time' => 'desc'), $offset, $limit);
    	$count = $this->code_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/code/index", array(
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
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string(), $this->input->post())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/code/add');
    		}
    		$name = $this->form_validation->set_value('name');
    		
    		$data = array();
    		$data['site_id'] = get_siteid();
    		$data['name'] = $name;
    		$data['create_time'] = time();
    		$code_id = $this->code_model->insertInfo($data);
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
    		
    		return redirect('admin/code/edit?code_id='.$code_id);
    	}
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	return $this->load->view("admin/code/add", array(
    		'olddata' => $olddata,
    	));
    }
    
	public function edit()
	{
		$code_id = $this->input->get('code_id', true);
		if (!$code_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $code_id empty '.serialize(array($code_id)));
			return redirect('admin/code/index');
		}
		
		$info = $this->code_model->getInfo($code_id);
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('name', 'name', valid_string_rule(true));
			$this->form_validation->set_rules('total_count', 'total_count', valid_int_rule());
			$this->form_validation->set_rules('send_count', 'send_count', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/code/add');
    		}
    		$name = $this->form_validation->set_value('name');
    		$total_count = $this->form_validation->set_value('total_count');
    		$send_count = $this->form_validation->set_value('send_count');
    		
    		$data = array();
    		$data['site_id'] = get_siteid();
    		$data['name'] = $name;
    		$data['total_count'] = $total_count;
    		$data['send_count'] = $send_count;
			$result = $this->code_model->updateInfo($code_id, $data);
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
			
			return redirect('admin/code/edit?code_id='.$code_id);
		}
		
		return $this->load->view("admin/code/edit", array(
				'info' => $info,
		));
	}
	
	public function del()
	{
		$code_id = $this->input->get('code_id', true);
		if (!$code_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' code_id empty '.serialize(array($code_id)));
			return redirect('admin/code/index');
		}
	
		$info = $this->code_model->getInfo($code_id);
	
		//提交表单
		if (is_post())
		{
			$result = $this->code_model->deleteInfo($code_id);
			
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($code_id)));
	
			return redirect('admin/code/index');
		}
	
		return $this->load->view("admin/code/del", array(
				'info' => $info,
		));
	}
	
	public function make()
	{
		//检查进程是否存在
		$is_running = false;
		$exec_result = ps('make_code');
		if (count($exec_result['data'])) //加上自身, 所以是2个及2个以上
		{
			$is_running = true;
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec $is_running '.json_encode(array($is_running, $exec_result)));
		}
	
		if (is_post())
		{
			if ($is_running)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $is_running ');
				$this->session->set_flashdata('error', lang('task_isrunning'));
				return redirect('/admin/code/make');
			}
	
			set_time_limit(0);
			ini_set("memory_limit", "1024M");
			header("Content-type: text/html; charset=utf-8");
	
			$code_id = $this->input->post('code_id', true);
			$count = $this->input->post('count', true);
			$case_sensitivity = $this->input->post('case_sensitivity', true);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' data '.json_encode(array($this->input->post())));
	
			//执行后台任务
			$cmd = "nohup php ".FCPATH."index.php admin/command/run_make_code '".get_siteid()."' '".$code_id."' '".$count."' '".$case_sensitivity."' > nohup.log 2>&1 &";
			@exec($cmd);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
	
			$this->session->set_flashdata('success', lang('cmd_running_succ'));
			return redirect('admin/code/index');
		}
	
		
		$code_id = $this->input->get('code_id', true);
		
		$params = array();
		$params['site_id'] = get_siteid();
		$codeList = $this->code_model->getList($params, null, 0, 9999);
	
		return $this->load->view('admin/code/make', array(
		      'code_id' => $code_id,
				'codeList' => $codeList,
				'message' => $is_running ? lang('task_isrunning') : ''
		));
	}
	
	public function import()
	{
		//检查进程是否存在
		$is_running = false;
		$exec_result = ps('import_code');
		if (count($exec_result['data'])) //加上自身, 所以是2个及2个以上
		{
			$is_running = true;
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec $is_running '.json_encode(array($is_running, $exec_result)));
		}
		
		if (is_post())
		{
			if ($is_running)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $is_running ');
				$this->session->set_flashdata('error', lang('task_isrunning'));
				return redirect('/admin/code/import');
			}
		
			set_time_limit(0);
			ini_set("memory_limit", "1024M");
			header("Content-type: text/html; charset=utf-8");
		
			$code_id = $this->input->post('code_id', true);
			$data_str = $this->input->post('data', true);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' data '.json_encode(array($this->input->post())));
		
			if (empty($data_str))
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' file not select '.serialize(array()));
				$this->session->set_flashdata('error', '数据的格式不正确');
				return redirect('admin/code/import');
			}
		
			if (strpos($data_str, "\r") === false && strpos($data_str, "\n") === false && strpos($data_str, " ") === false)
			{
				if (strlen($data_str) > 30)
				{
					log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' file not select '.serialize(array()));
					$this->session->set_flashdata('error', '数据的格式不正确');
					return redirect('admin/code/import');
				}
			}
		
			//存储到临时文件
			$file_path = create_file('words.txt', $data_str);
			if ($file_path === false)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' upload_file error '.serialize(array($_FILES)));
				$this->session->set_flashdata('error', 'upload_file error');
				return redirect('admin/code/import');
			}
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $file_path '.serialize(array($file_path)));
		
			//执行后台任务
			$cmd = "nohup php ".FCPATH."index.php admin/command/run_import_code '".get_siteid()."' '".$code_id."' '".base64_encode_($file_path)."' > nohup.log 2>&1 &";
			@exec($cmd);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
		
			$this->session->set_flashdata('success', lang('cmd_running_succ'));
			return redirect('admin/code/index');
		}
		
		$code_id = $this->input->get('code_id', true);
		
		$params = array();
		$params['site_id'] = get_siteid();
		$codeList = $this->code_model->getList($params, null, 0, 9999);
	
		return $this->load->view('admin/code/import', array(
		    'code_id' => $code_id,
				'codeList' => $codeList,
				'message' => $is_running ? lang('task_isrunning') : ''
		));
	}
	
	public function clean()
	{
		if (is_post())
		{
			$code_id = $this->input->post('code_id', true);
			
			$cmd = "nohup php ".FCPATH."index.php admin/command/run_clean_code_item '".get_siteid()."' '".$code_id."'  > nohup.log 2>&1 &";
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $cmd '.json_encode(array($cmd)));
			
			@exec($cmd);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
			
			$this->session->set_flashdata('success', lang('cmd_running_succ'));
			return redirect('admin/code/index');
		}
	
		$params = array();
		$params['site_id'] = get_siteid();
		$codeList = $this->code_model->getList($params, null, 0, 9999);
	
		return $this->load->view('admin/code/clean', array(
				'codeList' => $codeList
		));
	}
}
?>