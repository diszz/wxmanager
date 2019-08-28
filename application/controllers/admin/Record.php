<?php
/**
 * 问题管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 *
 */
class Record extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model("weixin_model");
	}
	
	public function index()
	{
		return redirect('admin/weixin/record/getlist');
	}
	
	public function getList($offset = 0)
	{
		$activity_id = $this->input->get('activity_id', true);
		$question_id = $this->input->get('question_id', true);
		
		$offset = ($offset < 0 ? 0 : $offset);
		$limit = 10;
		
		$params = array();
		$activity_id && $params['activity_id'] = $activity_id;
		$question_id && $params['question_id'] = $question_id;
		$params['offset'] = $offset;
		$params['limit'] = $limit;
		$result = $this->weixin_model->getRecordList($params);
		if ($result['errno'])
		{
		
		}
		$list = $result['data'];
		
		$params = array();
		$activity_id && $params['activity_id'] = $activity_id;
		$question_id && $params['question_id'] = $question_id;
		$result = $this->weixin_model->getRecordCount($params);
		if ($result['errno'])
		{
		
		}
		$count = $result['data'];
		
		
		$pagination = $this->page($count, $offset, $limit);
		
		return $this->load->view('admin/weixin/record/list', array(
				'list' => $list,
				'count' => $count,
				'pagination' => $pagination,
		));
	}
	
}