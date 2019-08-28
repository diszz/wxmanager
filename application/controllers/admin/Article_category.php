<?php
/**
 * 文章管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Article_category extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Article_category_model','Article_model', 'Article_attribute_model'));
    }
    
    public function index($offset = 0)
    {
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$list = $this->Article_category_model->getList($params, null, $offset, $limit);
    	$count = $this->Article_category_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/article_category/index", array(
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
			$this->form_validation->set_rules('name', 'name', valid_string_rule(1, 60, true));
			$this->form_validation->set_rules('sort', 'sort', valid_int_rule());
			if (!$this->form_validation->run())
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string())));
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $this->form_validation->error_string());
				return redirect('admin/article_category/add');
			}
			$name = $this->form_validation->set_value('name');
			$sort = $this->form_validation->set_value('sort');
    		
    		$data = array();
			$data['site_id'] = get_siteid();
			$data['name'] = $name;
			$data['sort'] = (int)$sort;
			$data['create_time'] = time();
    		$category_id = $this->Article_category_model->insertInfo($data);
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
    		
    		return redirect('admin/article_category/edit?category_id='.$category_id);
    	}
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	return $this->load->view("admin/article_category/add", array(
    		'olddata' => $olddata
    	));
    }
    
	public function edit()
	{
		$category_id = $this->input->get('category_id', true);
		if (!$category_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' category_id empty '.serialize(array($category_id)));
			$this->session->set_flashdata('error', 'category_id empty');
			return redirect('admin/article_category/index');
		}
		
		$info = $this->Article_category_model->getInfo($category_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($category_id)));
			$this->session->set_flashdata('error', 'article notexist');
			return redirect('admin/article_category/index');
		}
		
		//判断权限
// 		if (!is_userweixin(get_siteid()))
// 		{
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($category_id)));
// 			$this->session->set_flashdata('error', lang('weixin_notowner'));
// 			return redirect('admin/article_category/index');
// 		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('name', 'name', valid_string_rule(1, 60, true));
			$this->form_validation->set_rules('sort', 'sort', valid_int_rule());
			$this->form_validation->set_rules('bbs_source_url', 'bbs_source_url', valid_text_rule());
			if (!$this->form_validation->run())
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string())));
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $this->form_validation->error_string());
				return redirect('admin/article_category/edit?category_id='.$category_id);
			}
			$name = $this->form_validation->set_value('name');
			$sort = $this->form_validation->set_value('sort');
			$bbs_source_url = $this->form_validation->set_value('bbs_source_url');
		
			$data = array();
			$data['site_id'] = get_siteid();
			$data['name'] = $name;
			is_numeric($sort) && $data['sort'] = (int)$sort;
			isset($bbs_source_url) && $data['bbs_source_url'] = $bbs_source_url;
			$result = $this->Article_category_model->updateInfo($category_id, $data);
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
			
			return redirect('admin/article_category/edit?category_id='.$category_id);
		}
		
		return $this->load->view("admin/article_category/edit", array(
				'info' => $info,
		));
	}
	
	public function del()
	{
		$category_id = $this->input->get('category_id', true);
		if (!$category_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' category_id empty '.serialize(array($category_id)));
			return redirect('admin/article_category/index');
		}
	
		$info = $this->Article_category_model->getInfo($category_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($category_id)));
			return redirect('admin/article_category/index');
		}
	
		//判断权限
// 		if (!is_userweixin(get_siteid()))
// 		{
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($category_id)));
// 			$this->session->set_flashdata('error', lang('weixin_notowner'));
// 			return redirect('admin/article_category/index');
// 		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->Article_category_model->deleteInfo($category_id);
				
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($category_id)));
				
			return redirect('admin/article_category/index');
		}
	
		return $this->load->view("admin/article_category/del", array(
				'info' => $info,
		));
	}
	
	public function source($category_id, $offset = 0)
	{
		$category_id = intval($category_id);
		$offset = ($offset < 0 ? 0 : $offset);
		$limit = 10;
	
		$categoryInfo = $this->Article_category_model->getInfo($category_id);
		if (empty($categoryInfo['bbs_source_url']))
		{
			$this->session->set_flashdata('error', '没有设置论坛资源地址');
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' 没有设置论坛资源地址 '.serialize(array($category_id, $categoryInfo)));
			return redirect('admin/article_category/index');
		}
		
		include_once APPPATH.'third_party/bbs/bbs.php';
		$bbs = new bbs();
		$bbs->setSourceUrl($categoryInfo['bbs_source_url']);
	
		$data = $bbs->getCurrentList();
		$list = array_slice($data, $offset, $limit);
		if (!$list)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' array_slice no data '.serialize(array($offset, $limit)));
			$this->session->set_flashdata('error', 'no data');
			return redirect('admin/article/index');
		}
	
		$post_ids = array();
		$list_ = array();
		foreach ($list as $item)
		{
			$attrs = array();
			$attrs['site_id'] = get_siteid();
			$attrs['post_id'] = $item['post_id'];
			$result = $this->Article_model->getInfoByAttribute($attrs);
			$item['is_import'] = !empty($result) ? true : false;
			$list_[] = $item;
		}
		$list = $list_;
	
		$pagination = make_page(count($data), $offset, $limit, $category_id);
	
		return $this->load->view("admin/article_category/source", array(
				'list' => $list,
				'pagination' => $pagination,
				'category_id' => $category_id
		));
	}
	
	public function addpost()
	{
		$post_id = $this->input->get('post_id', true);
		$category_id = $this->input->get('category_id', true);
		$offset = $this->input->get('offset', true);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $post_id '.serialize(array($post_id)));
	
		//检查是否已添加
		$attrs = array();
		$attrs['site_id'] = get_siteid();
		$attrs['post_id'] = $post_id;
		$result = $this->Article_model->getInfoByAttribute($attrs);
		if ($result)
		{
			$this->session->set_flashdata('error', '已经添加');
			return redirect('admin/article_category/source/'.$category_id.'/'.$offset);
		}
		
		//获取分类详情
		$categoryInfo = $this->Article_category_model->getInfo($category_id);
		if (empty($categoryInfo['bbs_source_url']))
		{
			$this->session->set_flashdata('error', '没有设置论坛资源地址');
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' 没有设置论坛资源地址 '.serialize(array($category_id, $categoryInfo)));
			return redirect('admin/article_category/index');
		}
	
		include_once APPPATH.'third_party/bbs/bbs.php';
		$bbs = new bbs();
		$bbs->setSourceUrl($categoryInfo['bbs_source_url']);
	
		$list = $bbs->getCurrentList();
	
		if (!empty($list[$post_id]))
		{
			$params = array();
			$params['site_id'] = get_siteid();
			$params['category_id'] = $category_id;
			$params['post_id'] = $post_id;
			$params['title'] = $list[$post_id]['title'];
			$params['url'] = $list[$post_id]['url'];
			$params['is_redirect'] = 1;
			$params['author'] = $list[$post_id]['author'];
			//$params['author_url'] = $list[$post_id]['author_url'];
			$params['icon'] = $list[$post_id]['icon'];
			$params['desc'] = $list[$post_id]['desc'];
			$params['sort'] = 0;
			$article_id = $this->Article_model->insertInfo($params);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' addArticle '.serialize(array($params)));
			
			$attrs = array();
			$attrs['article_id'] = $article_id;
			$attrs['content'] = $list[$post_id]['desc'];
			$this->Article_attribute_model->insertInfo($attrs);
			
				
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' succ '.serialize(array($params)));
		}
		else
		{
			$this->session->set_flashdata('error', '$post_id not find');
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' fail '.serialize(array($params)));
		}
	
		return redirect('admin/article_category/source/'.$category_id.'/'.$offset);
	}
}
?>