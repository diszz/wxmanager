<?php
/**
 * 微信用户管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
    }
    
    public function index($offset = 0)
    {
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$list = $this->user_model->getList($params, null, $offset, $limit);
    	$count = $this->user_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/user/index", array(
    			'list' => $list, 
    			'pagination' => $pagination
    	));
    }
    
    public function view()
    {
    	$user_id = $this->input->get('user_id', true);
    	$info = $this->user_model->getInfo($user_id);
    	if (!$info)
    	{
    			
    		return redirect('admin/user/index');
    	}
    	
    	return $this->load->view("admin/user/view", array(
    			'info' => $info,
    	));
    }
}
?>