<?php
/**
 * 问题管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 *
 */
class Lottery_user extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model("weixin_model");
	}
	
	public function index($cur_lottery = 0, $offset = 0)
	{
		$offset = ($offset < 0 ? 0 : $offset);
		$limit = 10;
		
		$params = array();
		$cur_lottery && $params['lottery_id'] = $cur_lottery;
		$params['offset'] = $offset;
		$params['limit'] = $limit;
		$result = $this->weixin_model->getLotteryUserList($params);
		$list = $result['data'];
		
		$result = $this->weixin_model->getLotteryUserCount($params);
		$count = $result['data'];
		
		$pagination = $this->page($count, $offset, $limit, base_url($this->router->fetch_directory(). $this->router->fetch_class() . '/'.$this->router->fetch_method() .'/'. $cur_lottery));
		
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
		$params['offset'] = 0;
		$params['limit'] = 9999999;
		$result = $this->weixin_model->getLotteryList($params);
		$lotteryList = $result['data'];
		
		return $this->load->view('admin/weixin/lottery_user/index', array(
				'list' => $list,
				'count' => $count,
				'pagination' => $pagination,
				'lotteryList' => $lotteryList,
				'cur_lottery' => $cur_lottery,
				'file' => $file,
				'file_exist' => $file_exist
		));
	}
	
}