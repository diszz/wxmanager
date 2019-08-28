<?php
/**
 * 微信关键词管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Keyword extends MY_Controller
{
	
	protected $objectArr = array(
			0 => '回复一句话', 
			1 => '回复一个列表', 
			2 => '挂载礼包活动', 
			3 => '挂载签到活动', 
			4 => '挂载抽奖活动',
			5 => '对应一篇文章',
			6 => '对应一批文章',
			7 => '发放红包',
	);
	
    function __construct()
    {
        parent::__construct();
        
        $this->load->model(array(
        		'keyword_model', 
        		'keyword_relation_model', 
                'keyword_alias_model',
        		'signin_model', 
        		'code_model', 
        		'lottery_model',
        		'Article_model', 
        		'Article_attribute_model', 
        		'Article_category_model',
        		'redpack_model'
        ));
    }
    
    public function index($offset = 0)
    {
    	$offset = intval($offset);
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 20;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	//$params['object'] = 1;
    	$list = $this->keyword_model->getList($params, array('keyword_id' => 'desc'), $offset, $limit);
    	$count = $this->keyword_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/keyword/index", array(
    			'list' => $list, 
    			'count' => $count,
    			'pagination' => $pagination,
    			'objectArr' => $this->objectArr
    	));
    }
    
    public function add()
    {
    	//提交表单
    	if (is_post())
    	{
    		//添加微信信息
    		$this->form_validation->set_rules('name', 'name', valid_string_rule(1, 30, true));
    		$this->form_validation->set_rules('content', 'content', valid_text_rule());
    		$this->form_validation->set_rules('type', 'type', valid_string_rule());
    		$this->form_validation->set_rules('object', 'object', valid_int_rule());
    		$this->form_validation->set_rules('object_id', 'object_id', valid_int_rule());
    		$this->form_validation->set_rules('sort', 'sort', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/keyword/add');
    		}
    		$name = $this->form_validation->set_value('name');
    		$content = $this->form_validation->set_value('content');
    		$object = $this->form_validation->set_value('object');
    		$object_id = $this->form_validation->set_value('object_id');
    		$type = $this->form_validation->set_value('type');
    		$sort = $this->form_validation->set_value('sort');
    		
    		$chilren = $this->input->post('children', true);
    		$chilrenSort = $this->input->post('children_sort', true);
    		$object_config = $this->input->post('object_config', true);
    		if ($chilren && count($chilren) > 1)
    		{
    			$object = 1;
    		}
    		
    		//检查是否已经存在
    		if (strpos($name, ','))
    		{
    		    $name_alias = explode(',', $name);
    		}
    		elseif (strpos($name, ' '))
    		{
    		    $name_alias = explode(' ', $name);
    		}
    		else
    		{
    		    $name_alias = array($name);
    		}
    		
    		//检查是否已经存在
    		$params = array();
    		$params['site_id'] = get_siteid();
    		$params['in']['name'] = $name_alias;
    		$alias_list = $this->keyword_alias_model->getList($params);
    		if($alias_list)
    		{
    		    $exist_alias = array();
    		    foreach ($alias_list as $item)
    		    {
    		        $exist_alias[] = $item['name'];
    		    }
    		    
    		    if ($exist_alias)
    		    {
    		        log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' name exist '.serialize(array($this->log_data)));
    		        $this->session->set_flashdata('olddata', $this->input->post());
    		        $this->session->set_flashdata('error', '关键词 '.implode(',', $exist_alias).' 已经存在');
    		        return redirect('admin/keyword/add');
    		    }
    		}
    		
    		$data = array();
    		$data['site_id'] = get_siteid();
    		$data['name'] = $name;
    		$data['type'] = 'text';
    		$data['content'] = $content;
    		$data['object'] = $object;
    		$data['object_id'] = (int)$object_id;
    		$data['object_config'] = $object_config && is_array($object_config) ? serialize($object_config) : '';
    		$data['sort'] = (int)$sort;
    		$data['relation_count'] = $chilren ? (int)count($chilren) : 0;
    		$data['create_time'] = time();
    		$keyword_id = $this->keyword_model->insertInfo($data);
    		
    		//分拆关键词存入别名表
    		if ($name_alias)
    		{
    		    foreach ($name_alias as $tmp)
    		    {
    		        $data = array();
    		        $data['site_id'] = get_siteid();
    		        $data['keyword_id'] = $keyword_id;
    		        $data['name'] = $tmp;
    		        $data['sort'] = (int)$sort;
    		        $this->keyword_alias_model->insertInfo($data);
    		    }
    		}
    		
    		
    		//添加新关联
    		if ($chilren)
    		{
    			foreach ($chilren as $k => $item)
    			{
    				$params = array();
    				$params['keyword_id'] = $keyword_id;
    				$params['child_keyword_id'] = $item;
    				$params['sort'] = (int)(isset($chilrenSort[$k]) ? $chilrenSort[$k] : 0);
    				$result = $this->keyword_relation_model->insertInfo($params);
    			}
    		}
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
    		
    		return redirect('admin/keyword/edit?keyword_id='.$keyword_id);
    	}
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$keywordList = $this->keyword_model->getList($params, null, 0, 999);
    	
    	//获取选项列表
    	//$params = array();
    	//$params['keyword_id'] = $keyword_id;
    	//$params['offset'] = 0;
    	//$params['limit'] = 999999;
    	//$result = $this->keyword_model->getKeywordRelationList($params);
    	$keywordRelationList = array();
    	
    	$keywordRelationArr = array();
    	if ($keywordRelationList)
    	{
    		foreach ($keywordRelationList as $item)
    		{
    			$keywordRelationArr[$item['child_keyword_id']] = $item;
    		}
    	}
    	
    	//获取签到列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$signinList = $this->signin_model->getList($params, null, 0, 999);
    	
    	//获取礼包列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$codeList = $this->code_model->getList($params, null, 0, 999);
    	
    	//获取签到列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$lotteryList = $this->lottery_model->getList($params, null, 0, 999);
    	
    	//获取红包列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$params['send_type'] = 0;
    	$redpackList = $this->redpack_model->getList($params, null, 0, 999);
    	
    	return $this->load->view("admin/keyword/add", array(
    			'olddata' => $olddata,
    			'keywordList' => $keywordList,
    			'keywordRelationArr' => $keywordRelationArr,
    			'signinList' => $signinList,
    			'codeList' => $codeList,
    			'objectArr' => $this->objectArr,
    			'lotteryList' => $lotteryList,
    			'redpackList' => $redpackList
    	));
    }
    
	public function edit()
	{
		$keyword_id = $this->input->get('keyword_id', true);
		if (!$keyword_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' keyword_id empty '.serialize(array($keyword_id)));
			return redirect('admin/keyword/index');
		}
		
		$info = $this->keyword_model->getInfo($keyword_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($keyword_id)));
			return redirect('admin/keyword/index');
		}
		
		//提交表单
		if (is_post())
		{
    		$this->form_validation->set_rules('name', 'name', valid_string_rule(1, 30, true));
    		$this->form_validation->set_rules('content', 'content', valid_text_rule());
    		$this->form_validation->set_rules('type', 'type', valid_string_rule());
    		$this->form_validation->set_rules('object', 'object', valid_int_rule());
    		$this->form_validation->set_rules('object_id', 'object_id', valid_int_rule());
    		$this->form_validation->set_rules('sort', 'sort', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/keyword/edit?keyword_id='.$keyword_id);
    		}
    		$name = $this->form_validation->set_value('name');
    		$content = $this->form_validation->set_value('content');
    		$type = $this->form_validation->set_value('type');
    		$object = $this->form_validation->set_value('object');
    		$object_id = $this->form_validation->set_value('object_id');
    		$sort = $this->form_validation->set_value('sort');
    		
    		
    		$chilren = $this->input->post('children', true);
    		$chilrenSort = $this->input->post('children_sort', true);
    		$object_config = $this->input->post('object_config', true);
			if ($chilren && count($chilren) > 1)
    		{
    			$object = 1;
    		}
    		
    		//处理关键词别名
    		if (strpos($name, ','))
    		{
    		    $name_alias = explode(',', $name);
    		}
    		elseif (strpos($name, ' '))
    		{
    		    $name_alias = explode(' ', $name);
    		}
    		else
    		{
    		    $name_alias = array($name);
    		}
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $name_alias '.serialize(array($name_alias)));
    		
    		//检查是否已经存在
    		$params = array();
    		$params['site_id'] = get_siteid();
    		$params['in']['name'] = $name_alias;
    		$alias_list = $this->keyword_alias_model->getList($params, null, 0, 99);
    		if($alias_list)
    		{
    		    $exist_alias = array();
    		    foreach ($alias_list as $item)
    		    {
    		        if ($item['keyword_id'] && $item['keyword_id'] != $keyword_id)
    		        {
    		            $exist_alias[] = $item['name'];
    		            log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $exist_alias $item '.serialize(array($item)));
    		        }
    		    }
    		    log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $exist_alias '.serialize(array($exist_alias)));
    		    
    		    if ($exist_alias)
    		    {
    		        log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' name exist '.serialize(array($this->log_data)));
    		        $this->session->set_flashdata('olddata', $this->input->post());
    		        $this->session->set_flashdata('error', '关键词 '.implode(',', $exist_alias).' 已经存在');
    		        return redirect('admin/keyword/edit?keyword_id='.$keyword_id);
    		    }
    		}
    		
    		$data = array();
    		$data['site_id'] = get_siteid();
    		$data['name'] = $name;
    		$data['type'] = 'text';
    		$data['content'] = $content;
    		$data['object'] = $object;
    		$data['object_id'] = $object_id;
    		$data['object_config'] = $object_config && is_array($object_config) ? serialize($object_config) : '';
    		$data['sort'] = (int)$sort;
    		$data['relation_count'] = $chilren ? (int)count($chilren) : 0;
			$result = $this->keyword_model->updateInfo($keyword_id, $data);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' updateInfo '.serialize(array($keyword_id, $data)));
			
			//清空当前别名表
			$attrs = array();
			$attrs['keyword_id'] = $keyword_id;
			$alias_list = $this->keyword_alias_model->getList($attrs, null, 0, 9999);
			if ($alias_list)
			{
			    foreach ($alias_list as $item)
			    {
			        $this->keyword_alias_model->deleteInfo($item['keyword_alias_id']);
			    }
			}
			//分拆关键词存入别名表
			if ($name_alias)
			{
			    foreach ($name_alias as $tmp)
			    {
			        $data = array();
			        $data['site_id'] = get_siteid();
			        $data['keyword_id'] = $keyword_id;
			        $data['name'] = $tmp;
			        $data['sort'] = $sort;
			        $this->keyword_alias_model->insertInfo($data);
			    }
			}
			
			//清空关联
			$attrs = array();
			$attrs['keyword_id'] = $keyword_id;
			$keywordRelationList = $this->keyword_relation_model->getList($attrs, null, 0, 9999);
			if ($keywordRelationList)
			{
				foreach ($keywordRelationList as $item)
				{
					$this->keyword_relation_model->deleteInfo($item['keyword_relation_id']);
				}
			}
			
			//添加新关联
			if ($chilren)
			{
				foreach ($chilren as $k => $item)
				{
					$params = array();
					$params['keyword_id'] = $keyword_id;
					$params['child_keyword_id'] = $item;
					$params['sort'] = $chilrenSort[$k];
					$result = $this->keyword_relation_model->insertInfo($params);
				}
			}
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
			
			return redirect('admin/keyword/edit?keyword_id='.$keyword_id);
		}
		
		//获取所有本站关键词
		$params = array();
		$params['site_id'] = get_siteid();
		$keywordList = $this->keyword_model->getList($params, null, 0, 9999);
		
		//获取签到列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$signinList = $this->signin_model->getList($params, null, 0, 999);
    	
    	//获取礼包列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$codeList = $this->code_model->getList($params, null, 0, 999);
    	
    	//获取签到列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$lotteryList = $this->lottery_model->getList($params, null, 0, 999);
    	
    	//获取文章列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$articleList = $this->Article_model->getList($params, null, 0, 999);
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$articleCategoryList = $this->Article_category_model->getList($params, null, 0, 999);
		
    	//获取红包列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$params['send_type'] = 0;
    	$redpackList = $this->redpack_model->getList($params, null, 0, 999);
    	
		return $this->load->view("admin/keyword/edit", array(
				'info' => $info,
				'keywordList' => $keywordList,
				'signinList' => $signinList,
				'codeList' => $codeList,
				'lotteryList' => $lotteryList,
				'articleList' => $articleList,
				'articleCategoryList' => $articleCategoryList,
				'objectArr' => $this->objectArr,
				'redpackList' => $redpackList
		));
	}
	
	public function del()
	{
		$keyword_id = $this->input->get('keyword_id', true);
		if (!$keyword_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' keyword_id empty '.serialize(array($keyword_id)));
			return redirect('admin/keyword/index');
		}
	
		$info = $this->keyword_model->getInfo($keyword_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($keyword_id)));
			return redirect('admin/keyword/index');
		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->keyword_model->deleteInfo($keyword_id);
			
		    //清空当前别名表
			$attrs = array();
			$attrs['keyword_id'] = $keyword_id;
			$alias_list = $this->keyword_alias_model->getList($attrs, null, 0, 9999);
			if ($alias_list)
			{
			    foreach ($alias_list as $item)
			    {
			        $this->keyword_alias_model->deleteInfo($item['keyword_alias_id']);
			    }
			}
			
			//清空关联
			$attrs = array();
			$attrs['keyword_id'] = $keyword_id;
			$keywordRelationList = $this->keyword_relation_model->getList($attrs, null, 0, 9999);
			if ($keywordRelationList)
			{
			    foreach ($keywordRelationList as $item)
			    {
			        $this->keyword_relation_model->deleteInfo($item['keyword_relation_id']);
			    }
			}
			
			//清空关联
			$params = array();
			$params['child_keyword_id'] = $keyword_id;
			$list1 = $this->keyword_relation_model->getList($params, null, 0, 999);
			if ($list1)
			{
			    foreach ($list1 as $item1)
			    {
			        $this->keyword_relation_model->deleteInfo($item1['keyword_relation_id']);
			    }
			}
	
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($keyword_id)));
	
			return redirect('admin/keyword/index');
		}
	
		return $this->load->view("admin/keyword/del", array(
				'info' => $info,
		));
	}
	
	public function import()
	{
		//检查进程是否存在
		$is_running = false;
		$exec_result = ps('import_keyword');
		if (count($exec_result['data'])) //加上自身, 所以是2个及2个以上
		{
			$is_running = true;
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec $is_running '.json_encode(array($is_running, $exec_result)));
		}
		
		if (is_post())
		{
			if ($is_running)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist ');
				$this->session->set_flashdata('error', lang('task_isrunning'));
				return redirect('/admin/keyword/import');
			}
				
			set_time_limit(0);
			ini_set("memory_limit", "1024M");
			header("Content-type: text/html; charset=utf-8");
		
			$data_str = $this->input->post('data', true);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' data '.json_encode(array($this->input->post())));
		
			if (empty($data_str))
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' file not select '.serialize(array()));
				$this->session->set_flashdata('error', '数据的格式不正确');
				return redirect('admin/keyword/import');
			}
				
			if (strpos($data_str, "\r") === false && strpos($data_str, "\n") === false && strpos($data_str, " ") === false)
			{
				if (strlen($data_str) > 30)
				{
					log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' file not select '.serialize(array()));
					$this->session->set_flashdata('error', '数据的格式不正确');
					return redirect('admin/keyword/import');
				}
			}
		
			//存储到临时文件
			$file_path = create_file('words.txt', $data_str);
			if ($file_path === false)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' upload_file error '.serialize(array($_FILES)));
				$this->session->set_flashdata('error', 'upload_file error');
				return redirect('admin/keyword/import');
			}
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $file_path '.serialize(array($file_path)));
		
			//执行后台任务
			$cmd = "nohup php ".FCPATH."index.php admin/command/run_import_keyword '".get_siteid()."' '".base64_encode_($file_path)."' > nohup.log 2>&1 &";
			@exec($cmd);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
		
			$this->session->set_flashdata('success', lang('cmd_running_succ'));
			return redirect('admin/keyword/index');
		}
	
		return $this->load->view('admin/keyword/import', array(
				'message' => $is_running ? lang('task_isrunning') : ''
		));
	}
	
	public function clean()
	{
		//检查进程是否存在
		$is_running = false;
		$exec_result = ps('clean_keyword');
		if (count($exec_result['data'])) //加上自身, 所以是2个及2个以上
		{
			$is_running = true;
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec $is_running '.json_encode(array($is_running, $exec_result)));
		}
		
		if (is_post())
		{
			if ($is_running)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist ');
				$this->session->set_flashdata('error', lang('task_isrunning'));
				return redirect('/admin/keyword/clean');
			}
		
			//执行后台任务
			$cmd = "nohup php ".FCPATH."index.php admin/command/run_clean_keyword '".get_siteid()."' > nohup.log 2>&1 &";
			@exec($cmd);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
		
			$this->session->set_flashdata('success', lang('cmd_running_succ'));
			return redirect('admin/keyword/index');
		}
		
		return $this->load->view('admin/keyword/clean', array(
				'message' => $is_running ? lang('task_isrunning') : ''
		));
	}
}
?>