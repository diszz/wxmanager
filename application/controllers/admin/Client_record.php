<?php
/**
 * 问题管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 *
 */
class Client_record extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array("client_record_model"));
	}
	
	public function index($offset = 0)
	{
		$offset = intval($offset);
		$offset = ($offset < 0 ? 0 : $offset);
		$limit = 10;
		
		$params = array();
		$params['site_id'] = get_siteid();
		$list = $this->client_record_model->getList($params, null, $offset, $limit);
		$count = $this->client_record_model->getCount($params);
		
		$pagination = make_page($count, $offset, $limit);
		
		//下载文件
		$file_exist = false;
		$file = $this->input->get('file', true);
		if ($file)
		{
			$file = base64_decode_($file);
			$file_exist = file_exists($file);
		}
		 
		return $this->load->view('admin/client_record/index', array(
				'list' => $list,
				'count' => $count,
				'pagination' => $pagination,
				'file' => $file,
				'file_exist' => $file_exist
		));
	}
	
}