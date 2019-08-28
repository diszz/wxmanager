<?php
/**
 * 文章管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Article extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Article_model', 'Article_attribute_model', 'Article_category_model'));
    }
    
    public function index($category_id = 0, $offset = 0)
    {
    	$category_id = intval($category_id);
    	$offset = intval($offset);
    	
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$category_id && $params['category_id'] = $category_id;
    	$list = $this->Article_model->getList($params, null, $offset, $limit);
    	$count = $this->Article_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit, $category_id);
    	
    	//文章分类
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$categoryList = $this->Article_category_model->getList($params, null, 0, 99);
    	
    	return $this->load->view("admin/article/index", array(
    			'list' => $list, 
    			'pagination' => $pagination,
    			'category_id' => $category_id,
    			'categoryList' => $categoryList
    	));
    }
    
    public function add()
    {
    	//提交表单
    	if (is_post())
    	{
    		//添加微信信息
    		$this->form_validation->set_rules('category_id', 'category_id', valid_string_rule());
			$this->form_validation->set_rules('post_id', 'post_id', valid_string_rule());
			$this->form_validation->set_rules('title', 'title', valid_string_rule());
			$this->form_validation->set_rules('url', 'url', valid_text_rule());
			$this->form_validation->set_rules('is_redirect', 'is_redirect', valid_int_rule());
			$this->form_validation->set_rules('author', 'author', valid_string_rule());
			$this->form_validation->set_rules('author_avatar', 'author_avatar', valid_text_rule());
			$this->form_validation->set_rules('icon', 'icon', valid_text_rule());
			$this->form_validation->set_rules('desc', 'desc', valid_text_rule());
			$this->form_validation->set_rules('content', 'content', 'trim|required');
			$this->form_validation->set_rules('sort', 'sort', valid_int_rule());
			if (!$this->form_validation->run())
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string())));
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $this->form_validation->error_string());
				return redirect('admin/article/add');
			}
			$category_id = $this->form_validation->set_value('category_id');
			$post_id = $this->form_validation->set_value('post_id');
			$title = $this->form_validation->set_value('title');
			$url = $this->form_validation->set_value('url');
			$is_redirect = $this->form_validation->set_value('is_redirect');
			$author = $this->form_validation->set_value('author');
			$author_avatar = $this->form_validation->set_value('author_avatar');
			$icon = $this->form_validation->set_value('icon');
			$desc = $this->form_validation->set_value('desc');
			$content = $this->form_validation->set_value('content');
			$sort = $this->form_validation->set_value('sort');
    		
    		$data = array();
			$data['site_id'] = get_siteid();
			$data['category_id'] = $category_id;
			$data['post_id'] = $post_id;
			$data['url'] = $url;
			$data['is_redirect'] = $is_redirect ? 1 : 0;
			$data['author'] = $author;
			$data['author_avatar'] = $author_avatar;
			$data['icon'] = $icon;
			$data['title'] = $title;
			$data['desc'] = $desc;
			$data['sort'] = (int)$sort;
			$data['create_time'] = time();
    		$article_id = $this->Article_model->insertInfo($data);
    		
    		$attrs = array();
    		$attrs['article_id'] = $article_id;
    		$attrs['content'] = htmlspecialchars($content, ENT_QUOTES);
    		$this->Article_attribute_model->insertInfo($attrs);
    		
    		if (!$url)
    		{
    			$url = trim(get_setting('site_domain'), '/').'/wap/article/detail/'.$article_id;
    			
    			$data = array();
    			$data['url'] = $url;
    			$result = $this->Article_model->updateInfo($article_id, $data);
    		}
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
    		
    		return redirect('admin/article/edit?article_id='.$article_id);
    	}
    	
    	$olddata = $this->session->flashdata('olddata');
    	
    	//文章分类
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$categoryList = $this->Article_category_model->getList($params, null, 0, 99);
    	
    	return $this->load->view("admin/article/add", array(
    			'olddata' => $olddata,
    			'categoryList' => $categoryList
    	));
    }
    
	public function edit()
	{
		$article_id = $this->input->get('article_id', true);
		if (!$article_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' article_id empty '.serialize(array($article_id)));
			$this->session->set_flashdata('error', 'article_id empty');
			return redirect('weixin/article/index');
		}
		
		$info = $this->Article_model->getInfo($article_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($article_id)));
			$this->session->set_flashdata('error', 'article notexist');
			return redirect('admin/article/index');
		}
		
		//判断权限
// 		if (!is_userweixin(get_siteid()))
// 		{
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($article_id)));
// 			$this->session->set_flashdata('error', lang('weixin_notowner'));
// 			return redirect('admin/article/index');
// 		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('category_id', 'category_id', valid_string_rule());
			$this->form_validation->set_rules('post_id', 'post_id', valid_string_rule());
			$this->form_validation->set_rules('title', 'title', valid_string_rule());
			$this->form_validation->set_rules('url', 'url', valid_text_rule());
			$this->form_validation->set_rules('is_redirect', 'is_redirect', valid_int_rule());
			$this->form_validation->set_rules('author', 'author', valid_string_rule());
			$this->form_validation->set_rules('author_avatar', 'author_avatar', valid_text_rule());
			$this->form_validation->set_rules('icon', 'icon', valid_text_rule());
			$this->form_validation->set_rules('desc', 'desc', valid_text_rule());
			$this->form_validation->set_rules('content', 'content', 'trim|required');
			$this->form_validation->set_rules('sort', 'sort', valid_int_rule());
			if (!$this->form_validation->run())
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation '.serialize(array($this->form_validation->error_string())));
				$this->session->set_flashdata('olddata', $this->input->post());
				$this->session->set_flashdata('error', $this->form_validation->error_string());
				return redirect('weixin/article/edit?article_id='.$article_id);
			}
			$category_id = $this->form_validation->set_value('category_id');
			$post_id = $this->form_validation->set_value('post_id');
			$title = $this->form_validation->set_value('title');
			$url = $this->form_validation->set_value('url');
			$is_redirect = $this->form_validation->set_value('is_redirect');
			$author = $this->form_validation->set_value('author');
			$author_avatar = $this->form_validation->set_value('author_avatar');
			$icon = $this->form_validation->set_value('icon');
			$desc = $this->form_validation->set_value('desc');
			$content = $this->form_validation->set_value('content');
			$sort = $this->form_validation->set_value('sort');
			
			if (!$url)
			{
				$url = trim(get_setting('site_domain'), '/').'/wap/article/detail/'.$article_id;
			}
			
			$data = array();
			$data['site_id'] = get_siteid();
			$data['category_id'] = $category_id;
			$post_id && $data['post_id'] = $post_id;
			$url && $data['url'] = $url;
			is_numeric($is_redirect) && $data['is_redirect'] = $is_redirect ? 1 : 0;
			$author && $data['author'] = $author;
			$author_avatar && $data['author_avatar'] = $author_avatar;
			$icon && $data['icon'] = $icon;
			$title && $data['title'] = $title;
			$desc && $data['desc'] = $desc;
			$content && $data['content'] = $content;
			is_numeric($sort) && $data['sort'] = (int)$sort;
			$result = $this->Article_model->updateInfo($article_id, $data);
			
			$attrs = array();
			$attrs['article_id'] = $article_id;
			$aaInfo = $this->Article_attribute_model->getInfoByAttribute($attrs);
			if ($aaInfo)
			{
				$this->Article_attribute_model->deleteInfo($aaInfo['article_attribute_id']);
			}
			
			$attrs = array();
			$attrs['article_id'] = $article_id;
			$attrs['content'] = htmlspecialchars($content, ENT_QUOTES);
			$this->Article_attribute_model->insertInfo($attrs);
			
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($data)));
			
			return redirect('admin/article/edit?article_id='.$article_id);
		}
		
		//文章分类
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$categoryList = $this->Article_category_model->getList($params, null, 0, 99);
		
		return $this->load->view("admin/article/edit", array(
				'info' => $info,
				'categoryList' => $categoryList
		));
	}
	
	public function del()
	{
		$article_id = $this->input->get('article_id', true);
		if (!$article_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' article_id empty '.serialize(array($article_id)));
			return redirect('admin/article/index');
		}
	
		$info = $this->Article_model->getInfo($article_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($article_id)));
			return redirect('admin/article/index');
		}
	
		//判断权限
// 		if (!is_userweixin(get_siteid()))
// 		{
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($article_id)));
// 			$this->session->set_flashdata('error', lang('weixin_notowner'));
// 			return redirect('admin/article/index');
// 		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->Article_model->deleteInfo($article_id);
				
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($article_id)));
				
			return redirect('admin/article/index');
		}
	
		return $this->load->view("admin/article/del", array(
				'info' => $info,
		));
	}
	
}
?>