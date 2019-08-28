<?php
/**
 * 问题管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 *
 */
class Signin_record extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array("signin_record_model", 'signin_model'));
	}
	
	public function index($cur_signin = 0, $offset = 0)
	{
		$cur_signin = intval($cur_signin);
		$offset = intval($offset);
		$offset = ($offset < 0 ? 0 : $offset);
		$limit = 10;
		
		$params = array();
		$params['site_id'] = get_siteid();
		$cur_signin && $params['signin_id'] = $cur_signin;
		$list = $this->signin_record_model->getList($params, null, $offset, $limit);
		$count = $this->signin_record_model->getCount($params);
		
		$pagination = make_page($count, $offset, $limit, $cur_signin);
		
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
		$signinList = $this->signin_model->getList($params, null, 0, 999);
		
		return $this->load->view('admin/signin_record/index', array(
				'list' => $list,
				'count' => $count,
				'pagination' => $pagination,
				'signinList' => $signinList,
				'cur_signin' => $cur_signin,
				'file' => $file,
				'file_exist' => $file_exist
		));
	}
	
}