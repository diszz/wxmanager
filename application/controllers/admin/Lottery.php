<?php
/**
 * 礼包管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.09.10
 */
class Lottery extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('weixin_model'));
        
        //是否选择微信
        if (!get_siteid())
        {
        	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' get_siteid false  '.serialize(array(get_userdata())));
        	redirect('admin/index');
        	exit();
        }
    }
    
    public function index($offset = 0)
    {
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$params['offset'] = $offset;
    	$params['limit'] = $limit;
    	$result = $this->weixin_model->getLotteryList($params);
    	$list = $result['data'];
    	
    	$result = $this->weixin_model->getLotteryCount($params);
    	$count = $result['data'];
    	
    	$pagination = $this->page($count, $offset, $limit);
    	
    	return $this->load->view("admin/weixin/lottery/index", array(
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
    		$this->form_validation->set_rules('odds', 'name', valid_int_rule());
    		$this->form_validation->set_rules('code_id', 'code_id', valid_string_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string(), $this->input->post())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/weixin/lottery/add');
    		}
    		$name = $this->form_validation->set_value('name');
    		$odds = $this->form_validation->set_value('odds');
    		$code_id = $this->form_validation->set_value('code_id');
    		
    		$params = array();
    		$params['site_id'] = get_siteid();
    		$params['name'] = $name;
    		$params['odds'] = $odds;
    		$params['code_id'] = $code_id;
    		$result = $this->weixin_model->addLottery($params);
    		$lottery_id = $result['data'];
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
    		
    		return redirect('admin/weixin/lottery/edit?lottery_id='.$lottery_id);
    	}
    	
    	//获取礼包列表
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$params['offset'] = 0;
    	$params['limit'] = 9999;
    	$result = $this->weixin_model->getCodeList($params);
    	$codeList = $result['data'];
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	return $this->load->view("admin/weixin/lottery/add", array(
    		'olddata' => $olddata,
    			'codeList' => $codeList
    	));
    }
    
	public function edit()
	{
		$lottery_id = $this->input->get('lottery_id', true);
		if (!$lottery_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $lottery_id empty '.serialize(array($lottery_id)));
			return redirect('admin/weixin/lottery/index');
		}
		
		$result = $this->weixin_model->getLottery(array('lottery_id' => $lottery_id));
		$info = $result['data'];
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('name', 'name', valid_string_rule(1, 60, true));
			$this->form_validation->set_rules('odds', 'odds', valid_int_rule());
			$this->form_validation->set_rules('code_id', 'code_id', valid_string_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/weixin/lottery/edit?lottery_id='.$lottery_id);
    		}
    		$name = $this->form_validation->set_value('name');
    		$odds = $this->form_validation->set_value('odds');
    		$code_id = $this->form_validation->set_value('code_id');
    		
    		$params = array();
    		$params['lottery_id'] = $lottery_id;
    		$params['site_id'] = get_siteid();
    		$params['name'] = $name;
    		$params['odds'] = $odds;
    		$params['code_id'] = (int)$code_id;
			$result = $this->weixin_model->editLottery($params);
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
			
			return redirect('admin/weixin/lottery/edit?lottery_id='.$lottery_id);
		}
		
		//获取礼包列表
		$params = array();
		$params['site_id'] = get_siteid();
		$params['offset'] = 0;
		$params['limit'] = 9999;
		$result = $this->weixin_model->getCodeList($params);
		$codeList = $result['data'];
		
		return $this->load->view("admin/weixin/lottery/edit", array(
				'info' => $info,
				'codeList' => $codeList,
		));
	}
	
	public function del()
	{
		$lottery_id = $this->input->get('lottery_id', true);
		if (!$lottery_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' lottery_id empty '.serialize(array($lottery_id)));
			return redirect('admin/weixin/lottery/index');
		}
	
		$result = $this->weixin_model->getLottery(array('lottery_id' => $lottery_id));
		$info = $result['data'];
	
		//判断权限
		if ($info['site_id'] != get_siteid())
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($lottery_id)));
			$this->session->set_flashdata('error', lang('weixin_notowner'));
			return redirect('admin/weixin/lottery/index');
		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->weixin_model->delLottery(array('lottery_id' => $lottery_id));
			
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($lottery_id)));
	
			return redirect('admin/weixin/lottery/index');
		}
	
		return $this->load->view("admin/weixin/lottery/del", array(
				'info' => $info,
		));
	}
	
}
?>