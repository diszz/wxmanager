<?php
/**
 * 红包管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Redpack extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('redpack_model', 'redpack_code_model'));
    }
    
    public function index($offset = 0)
    {
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$list = $this->redpack_model->getList($params, null, $offset, $limit);
    	$count = $this->redpack_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/redpack/index", array(
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
    		$this->form_validation->set_rules('name', '红包活动名称', valid_string_rule(1, 30, true));
    		$this->form_validation->set_rules('key', '小组KEY', valid_string_rule());
			$this->form_validation->set_rules('status', 'status', valid_int_rule());
			
			$this->form_validation->set_rules('send_name', '红包发送者', valid_string_rule(1, 30, true));
			$this->form_validation->set_rules('wishing', '红包祝福语', valid_string_rule(3, 128, true));
			$this->form_validation->set_rules('remark', '备注信息', valid_string_rule(3, 128, true));
			$this->form_validation->set_rules('logo_imgurl', '商户logo', valid_string_rule(6, 128, true));
			
			$this->form_validation->set_rules('min_value', '最小金额', valid_int_rule(true, 100, 20000));
			$this->form_validation->set_rules('max_value', '最大金额', valid_int_rule(true, 100, 20000));
			
			$this->form_validation->set_rules('total_money', '总金额', valid_int_rule(true, 100));
			$this->form_validation->set_rules('total_people', '总人数', valid_int_rule(true, 1));
			$this->form_validation->set_rules('send_money', 'send_money', valid_int_rule());
			$this->form_validation->set_rules('send_people', 'send_people', valid_int_rule());
			$this->form_validation->set_rules('fetch_people', 'fetch_people', valid_int_rule());
			$this->form_validation->set_rules('fetch_money', 'fetch_money', valid_int_rule());
			
			$this->form_validation->set_rules('send_type', 'send_type', valid_int_rule());
			$this->form_validation->set_rules('start_time', 'start_time', valid_string_rule(1, 30, true));
			$this->form_validation->set_rules('end_time', 'end_time', valid_string_rule(1, 30, true));
			if (!$this->form_validation->run())
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string())));
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $this->form_validation->error_string());
				return redirect('admin/redpack/add');
			}
			$name = $this->form_validation->set_value('name');
			$key = $this->form_validation->set_value('key');
			$status = $this->form_validation->set_value('status');
			
			$send_name = $this->form_validation->set_value('send_name');
			$wishing = $this->form_validation->set_value('wishing');
			$remark = $this->form_validation->set_value('remark');
			$logo_imgurl = $this->form_validation->set_value('logo_imgurl');
			
			$min_value = $this->form_validation->set_value('min_value');
			$max_value = $this->form_validation->set_value('max_value');
			
			$total_money = $this->form_validation->set_value('total_money');
			$total_people = $this->form_validation->set_value('total_people');
			
			$send_money = $this->form_validation->set_value('send_money');
			$send_people = $this->form_validation->set_value('send_people');
			$fetch_people = $this->form_validation->set_value('fetch_people');
			$fetch_money = $this->form_validation->set_value('fetch_money');
			
			$send_type = $this->form_validation->set_value('send_type');
			$start_time = $this->form_validation->set_value('start_time');
			$end_time = $this->form_validation->set_value('end_time');
			
			$error = array();
			
			if (strlen($name) > 32)
			{
				$error[] = '活动名称必须少于32个字符';
			}
			if (strlen($send_name) > 32)
			{
				$error[] = '红包发送者必须少于32个字符';
			}
			if (strlen($wishing) > 128)
			{
				$error[] = '红包祝福语必须少于128个字符';
			}
			if (strlen($remark) > 256)
			{
				$error[] = '备注信息必须少于256个字符';
			}
			if (strlen($logo_imgurl) > 128)
			{
				$error[] = '商户logo地址必须少于128个字符';
			}
			
			if ($total_people < 1)
			{
				$error[] = '总人数不能小于1';
			}
			if ($total_money < 100)
			{
				$error[] = '总金额不能小于1';
			}
			if ($min_value < 100 || $min_value > 20000)
			{
				$error[] = '最小金额必须在1 - 200 之间';
			}
			if ($max_value < 100 || $max_value > 20000)
			{
				$error[] = '最大金额必须在1 - 200 之间';
			}
			if ($total_people < ceil($total_money / $max_value))
			{
				$error[] = '设置的数值需要满足条件：总金额/最大金额<=红包数<=总金额/最小金额';
			}
			if ($total_people > floor($total_money / $min_value))
			{
				$error[] = '设置的数值需要满足条件：总金额/最大金额<=红包数<=总金额/最小金额';
			}
			if ($start_time >= $end_time)
			{
				$error[] = '活动开始时间应小于活动结束时间';
			}
			if ($error)
			{
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $error);
				return redirect('admin/redpack/add');
			}
			
    		$data = array();
			$data['site_id'] = get_siteid();
			$data['name'] = $name;
			$data['key'] = $key;
			$data['status'] = (int)$status;
			
			$data['send_name'] = $send_name;
			$data['wishing'] = $wishing;
			$data['remark'] = $remark;
			$data['logo_imgurl'] = $logo_imgurl;
			
			$data['min_value'] = (int)$min_value;
			$data['max_value'] = (int)$max_value;
			
			$data['total_money'] = (int)$total_money;
			$data['total_people'] = (int)$total_people;
			$data['send_money'] = (int)$send_money;
			$data['send_people'] = (int)$send_people;
			$data['fetch_people'] = (int)$fetch_people;
			$data['fetch_money'] = (int)$fetch_money;
			
			$data['send_type'] = (int)$send_type;
			$data['start_time'] = strtotime($start_time);
			$data['end_time'] = strtotime($end_time);
			
    		$redpack_id = $this->redpack_model->insertInfo($data);
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
    		
    		return redirect('admin/redpack/edit?redpack_id='.$redpack_id);
    	}
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	return $this->load->view("admin/redpack/add", array(
    		'olddata' => $olddata
    	));
    }
    
    public function view()
    {
    	$redpack_id = $this->input->get('redpack_id', true);
    	if (!$redpack_id)
    	{
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_id empty '.serialize(array($redpack_id)));
    		return redirect('admin/redpack/index');
    	}
    
    	$info = $this->redpack_model->getInfo($redpack_id);
    	if (empty($info))
    	{
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_id)));
    		return redirect('admin/redpack/index');
    	}
    
    	return $this->load->view("admin/redpack/view", array(
    			'info' => $info,
    	));
    }
    
	public function edit()
	{
		$redpack_id = $this->input->get('redpack_id', true);
		if (!$redpack_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_id empty '.serialize(array($redpack_id)));
			return redirect('admin/redpack/index');
		}
		
		$info = $this->redpack_model->getInfo($redpack_id);
		if (empty($info))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_id)));
			return redirect('admin/redpack/index');
		}
		
		if (!empty($info['make_money']))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_id)));
			$this->session->set_flashdata('error', '红包码已生成, 请先清空码后, 方可重新生成, 编辑和删除. ');
			return redirect('admin/redpack/index');
		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('name', '红包活动名称', valid_string_rule(1, 30, true));
    		$this->form_validation->set_rules('key', '小组KEY', valid_string_rule());
			$this->form_validation->set_rules('status', 'status', valid_int_rule());
			
			$this->form_validation->set_rules('send_name', '红包发送者', valid_string_rule(1, 30, true));
			$this->form_validation->set_rules('wishing', '红包祝福语', valid_string_rule(3, 128, true));
			$this->form_validation->set_rules('remark', '备注信息', valid_string_rule(3, 128, true));
			$this->form_validation->set_rules('logo_imgurl', '商户logo', valid_string_rule(6, 128, true));
			
			$this->form_validation->set_rules('min_value', '最小金额', valid_int_rule(true, 100, 20000));
			$this->form_validation->set_rules('max_value', '最大金额', valid_int_rule(true, 100, 20000));
			
			$this->form_validation->set_rules('total_money', '总金额', valid_int_rule(true, 100));
			$this->form_validation->set_rules('total_people', '总人数', valid_int_rule(true, 1));
			$this->form_validation->set_rules('send_money', 'send_money', valid_int_rule());
			$this->form_validation->set_rules('send_people', 'send_people', valid_int_rule());
			$this->form_validation->set_rules('fetch_people', 'fetch_people', valid_int_rule());
			$this->form_validation->set_rules('fetch_money', 'fetch_money', valid_int_rule());
			
			$this->form_validation->set_rules('send_type', 'send_type', valid_int_rule());
			$this->form_validation->set_rules('start_time', 'start_time', valid_string_rule(1, 30, true));
			$this->form_validation->set_rules('end_time', 'end_time', valid_string_rule(1, 30, true));
			
			if (!$this->form_validation->run())
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string())));
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $this->form_validation->error_string());
				return redirect('admin/redpack/edit?redpack_id='.$redpack_id);
			}
			$key = $this->form_validation->set_value('key');
			$name = $this->form_validation->set_value('name');
			$status = $this->form_validation->set_value('status');
			
			$send_name = $this->form_validation->set_value('send_name');
			$wishing = $this->form_validation->set_value('wishing');
			$remark = $this->form_validation->set_value('remark');
			$logo_imgurl = $this->form_validation->set_value('logo_imgurl');
			
			$min_value = $this->form_validation->set_value('min_value');
			$max_value = $this->form_validation->set_value('max_value');
			
			$total_money = $this->form_validation->set_value('total_money');
			$total_people = $this->form_validation->set_value('total_people');
			$send_money = $this->form_validation->set_value('send_money');
			$send_people = $this->form_validation->set_value('send_people');
			$fetch_people = $this->form_validation->set_value('fetch_people');
			$fetch_money = $this->form_validation->set_value('fetch_money');
			
			$send_type = $this->form_validation->set_value('send_type');
			$start_time = $this->form_validation->set_value('start_time');
			$end_time = $this->form_validation->set_value('end_time');
			
			$error = array();
			
			if (strlen($name) > 32)
			{
				$error[] = '活动名称必须少于32个字符';
			}
			if (strlen($send_name) > 32)
			{
				$error[] = '红包发送者必须少于32个字符';
			}
			if (strlen($wishing) > 128)
			{
				$error[] = '红包祝福语必须少于128个字符';
			}
			if (strlen($remark) > 256)
			{
				$error[] = '备注信息必须少于256个字符';
			}
			if (strlen($logo_imgurl) > 128)
			{
				$error[] = '商户logo地址必须少于128个字符';
			}
			
			if ($total_people < 1)
			{
				$error[] = '总人数不能小于1';
			}
			if ($total_money < 100)
			{
				$error[] = '总金额不能小于1';
			}
			if ($min_value < 100 || $min_value > 20000)
			{
				$error[] = '最小金额必须在1 - 200 之间';
			}
			if ($max_value < 100 || $max_value > 20000)
			{
				$error[] = '最大金额必须在1 - 200 之间';
			}
			if ($total_people < ceil($total_money / $max_value))
			{
				$error[] = '设置的数值需要满足条件：总金额/最大金额<=红包数<=总金额/最小金额';
			}
			if ($total_people > floor($total_money / $min_value))
			{
				$error[] = '设置的数值需要满足条件：总金额/最大金额<=红包数<=总金额/最小金额';
			}
			if ($start_time >= $end_time)
			{
				$error[] = '活动开始时间应小于活动结束时间';
			}
			if ($error)
			{
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $error);
				return redirect('admin/redpack/edit?redpack_id='.$redpack_id);
			}
			
			$data = array();
			$key && $data['key'] = $key;
			$name && $data['name'] = $name;
			$data['site_id'] = get_siteid();
			is_numeric($status) && $data['status'] = (int)$status;
			
			$send_name && $data['send_name'] = $send_name;
			$wishing && $data['wishing'] = $wishing;
			$remark && $data['remark'] = $remark;
			$logo_imgurl && $data['logo_imgurl'] = $logo_imgurl;
			
			is_numeric($min_value) && $data['min_value'] = (int)$min_value;
			is_numeric($max_value) && $data['max_value'] = (int)$max_value;
			
			is_numeric($send_money) && $data['send_money'] = (int)$send_money;
			is_numeric($send_people) && $data['send_people'] = (int)$send_people;
			is_numeric($fetch_people) && $data['fetch_people'] = (int)$fetch_people;
			is_numeric($fetch_money) && $data['fetch_money'] = (int)$fetch_money;
			is_numeric($total_money) && $data['total_money'] = (int)$total_money;
			is_numeric($total_people) && $data['total_people'] = (int)$total_people;
			
			$data['send_type'] = (int)$send_type;
			$start_time && $data['start_time'] = (int)strtotime($start_time);
			$end_time && $data['end_time'] = (int)strtotime($end_time);
			
			$result = $this->redpack_model->updateInfo($redpack_id, $data);
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
			
			return redirect('admin/redpack/edit?redpack_id='.$redpack_id);
		}
		
		
		return $this->load->view("admin/redpack/edit", array(
				'info' => $info,
		));
	}
	
	public function del()
	{
		$redpack_id = $this->input->get('redpack_id', true);
		if (!$redpack_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_id empty '.serialize(array($redpack_id)));
			return redirect('admin/redpack/index');
		}
	
		$info = $this->redpack_model->getInfo($redpack_id);
		if (empty($info))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_id)));
			return redirect('admin/redpack/index');
		}
	
		if (!empty($info['make_money']))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_id)));
			$this->session->set_flashdata('error', '红包码已生成, 请先清空码后, 方可重新生成, 编辑和删除. ');
			return redirect('admin/redpack/index');
		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->redpack_model->deleteInfo($redpack_id);
				
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($redpack_id)));
				
			return redirect('admin/redpack/index');
		}
	
		return $this->load->view("admin/redpack/del", array(
				'info' => $info,
		));
	}
	
	public function make_code()
	{
		$redpack_id = $this->input->get('redpack_id', true);
		if (!$redpack_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_id empty '.serialize(array($redpack_id)));
			return redirect('admin/redpack/index');
		}
		
		$info = $this->redpack_model->getInfo($redpack_id);
		if (empty($info))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_id)));
			return redirect('admin/redpack/index');
		}
		
		if (!empty($info['make_money']))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_id)));
			$this->session->set_flashdata('error', '红包码已生成, 请先清空码后, 方可重新生成, 编辑和删除. ');
			return redirect('admin/redpack/index');
		}
		
		//检查进程是否存在
		$is_running = false;
		$exec_result = ps('make_redpack_code');
		if (count($exec_result['data'])) //加上自身, 所以是2个及2个以上
		{
			$is_running = true;
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec $is_running '.json_encode(array($is_running, $exec_result)));
		}
		
		//提交表单
		if (is_post())
		{
			if ($is_running)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $is_running ');
				$this->session->set_flashdata('error', lang('task_isrunning'));
				return redirect('/admin/redpack/make_code');
			}
			
			$cmd = "nohup php ".FCPATH."index.php admin/command/run_make_redpack_code '".get_siteid()."' '".$redpack_id."' '".$info['total_people']."' '".$info['total_money']."' '".$info['min_value']."' '".$info['max_value']."' > nohup.log 2>&1 &";
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $cmd '.json_encode(array($cmd)));
			
			@exec($cmd);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
			
			$this->session->set_flashdata('success', lang('cmd_running_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($redpack_id)));
		
			return redirect('admin/redpack_code/index/'.$redpack_id);
		}
		
		return $this->load->view("admin/redpack/make_code", array(
				'info' => $info,
				'message' => $is_running ? lang('task_isrunning') : ''
		));
	}
	
	public function clean_code()
	{
		$redpack_id = $this->input->get('redpack_id', true);
		if (!$redpack_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_id empty '.serialize(array($redpack_id)));
			return redirect('admin/redpack/index');
		}
			
		$info = $this->redpack_model->getInfo($redpack_id);
		if (empty($info))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($redpack_id)));
			return redirect('admin/redpack/index');
		}
		
		//检查进程是否存在
		$is_running = false;
		$exec_result = ps('clean_redpack_code');
		if (count($exec_result['data'])) //加上自身, 所以是2个及2个以上
		{
			$is_running = true;
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec $is_running '.json_encode(array($is_running, $exec_result)));
		}
		
		//提交表单
		if (is_post())
		{
			if ($is_running)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $is_running ');
				$this->session->set_flashdata('error', lang('task_isrunning'));
				return redirect('/admin/redpack/clean_code');
			}
			
			$cmd = "nohup php ".FCPATH."index.php admin/command/run_clean_redpack_code '".get_siteid()."' '".$redpack_id."' > nohup.log 2>&1 &";
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $cmd '.json_encode(array($cmd)));
			
			@exec($cmd);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
			
			$this->session->set_flashdata('success', lang('cmd_running_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($redpack_id)));
			
			$this->session->set_flashdata('success', lang('operation_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($redpack_id)));
				
			return redirect('admin/redpack/index');
		}
		
		return $this->load->view("admin/redpack/clean_code", array(
				'info' => $info,
				'message' => $is_running ? lang('task_isrunning') : ''
		));
	}
	
	public function export_code()
	{
		$redpack_id = $this->input->get('redpack_id', true);
		$type = $this->input->get('type', true);
		
		$exportFile = FCPATH . 'resource/redpack-code-'.date("Y-m-d H-i-s").".xls";
	
		$cmd = "nohup php ".FCPATH."index.php admin/command/run_export_redpack_code '".base64_encode_($exportFile)."' '".get_siteid()."' '".$redpack_id."' '".$type."' > nohup.log 2>&1 &";
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $cmd '.json_encode(array($cmd)));
		
		@exec($cmd);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
	
		$this->session->set_flashdata('success', lang('cmd_running_succ'));
	
		$exportFileName = trim(strrchr($exportFile, '/'), '/');
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $exportFileName '.json_encode(array($exportFileName)));
	
		return redirect('admin/redpack_code/index/'.$redpack_id.'/'.$type.'?file='.base64_encode_($exportFile));
	}
}
?>