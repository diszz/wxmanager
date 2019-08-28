<?php
/**
 * 微信管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Menu extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('menu_model', 'keyword_model'));
    }
    
    public function index($offset = 0)
    {
    	$offset = intval($offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$params['parent_id'] = '_not_exist';
    	$list = $this->menu_model->getList($params, array('sort' => 'desc'), $offset, $limit);
    	$count = $this->menu_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit);
    	
    	return $this->load->view("admin/menu/index", array(
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
    		$this->form_validation->set_rules('name', 'name', valid_string_rule());
    		$this->form_validation->set_rules('content_click', 'content_click', valid_text_rule());
    		$this->form_validation->set_rules('content_link', 'content_link', valid_text_rule());
    		$this->form_validation->set_rules('parent_id', 'parent_id', valid_string_rule());
    		$this->form_validation->set_rules('type', 'type', valid_string_rule());
    		$this->form_validation->set_rules('sort', 'sort', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			$this->session->set_flashdata('olddata', $this->input->post());
    			$this->session->set_flashdata('error', $this->form_validation->error_string());
    			return redirect('admin/menu/add');
    		}
    		$name = $this->form_validation->set_value('name');
    		$content_click = $this->form_validation->set_value('content_click');
    		$content_link = $this->form_validation->set_value('content_link');
    		$parent_id = $this->form_validation->set_value('parent_id');
    		$type = $this->form_validation->set_value('type');
    		$sort = $this->form_validation->set_value('sort');
    		
    		$params = array();
    		$params['site_id'] = get_siteid();
    		$params['name'] = $name;
    		$params['content'] = ($type == 'click' ? $content_click : $content_link);
    		$params['parent_id'] = (int)$parent_id;
    		$params['type'] = $type;
    		$params['sort'] = (int)$sort;
    		$menu_id = $this->menu_model->insertInfo($params);
    		
    		$this->session->set_flashdata('success', lang('form_add_succ'));
    		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
    		
    		return redirect('admin/menu/edit?menu_id='.$menu_id);
    	}
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$keywordList = $this->keyword_model->getList($params, null, 0, 999);
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$menuList = $this->menu_model->getList($params, null, 0, 999);
    	
    	return $this->load->view("admin/menu/add", array(
    			'keywordList' => $keywordList,
    			'menuList' => $menuList
    	));
    }
    
	public function edit()
	{
		$menu_id = $this->input->get('menu_id', true);
		if (!$menu_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' menu_id empty '.serialize(array($menu_id)));
			return redirect('admin/menu/index');
		}
		
		$info = $this->menu_model->getInfo($menu_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($menu_id)));
			return redirect('admin/menu/index');
		}
		
		//提交表单
		if (is_post())
		{
			$this->form_validation->set_rules('name', 'name', valid_string_rule());
    		$this->form_validation->set_rules('content_click', 'content_click', valid_text_rule());
    		$this->form_validation->set_rules('content_link', 'content_link', valid_text_rule());
    		$this->form_validation->set_rules('parent_id', 'parent_id', valid_string_rule());
    		$this->form_validation->set_rules('type', 'type', valid_string_rule());
    		$this->form_validation->set_rules('sort', 'sort', valid_int_rule());
    		if (!$this->form_validation->run())
    		{
    			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_validation error '.serialize(array($this->form_validation->error_string())));
    			return redirect('admin/menu/edit?menu_id='.$menu_id);
    		}
    		$name = $this->form_validation->set_value('name');
    		$content_click = $this->form_validation->set_value('content_click');
    		$content_link = $this->form_validation->set_value('content_link');
    		$parent_id = $this->form_validation->set_value('parent_id');
    		$type = $this->form_validation->set_value('type');
    		$sort = $this->form_validation->set_value('sort');
		
    		$params = array();
    		$params['site_id'] = get_siteid();
    		$params['name'] = $name;
    		$params['content'] = ($type == 'click' ? $content_click : $content_link);
    		$params['parent_id'] = (int)$parent_id;
    		$params['type'] = $type;
    		$params['sort'] = (int)$sort;
			$result = $this->menu_model->updateInfo($menu_id, $params);
			
			$this->session->set_flashdata('success', lang('form_edit_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($params)));
			
			return redirect('admin/menu/edit?menu_id='.$menu_id);
		}
		
		$params = array();
    	$params['site_id'] = get_siteid();
    	$keywordList = $this->keyword_model->getList($params, null, 0, 999);
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$menuList = $this->menu_model->getList($params, null, 0, 999);
		
		return $this->load->view("admin/menu/edit", array(
				'info' => $info,
				'keywordList' => $keywordList,
				'menuList' => $menuList
		));
	}
	
	public function del()
	{
		$menu_id = $this->input->get('menu_id', true);
		if (!$menu_id)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' menu_id empty '.serialize(array($menu_id)));
			return redirect('admin/menu/index');
		}
	
		$info = $this->menu_model->getInfo($menu_id);
		if (!$info)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' weixin not exist '.serialize(array($menu_id)));
			return redirect('admin/menu/index');
		}
	
		//提交表单
		if (is_post())
		{
			$result = $this->menu_model->deleteInfo($menu_id);
	
			$this->session->set_flashdata('success', lang('form_del_succ'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($menu_id)));
	
			return redirect('admin/menu/index');
		}
	
		return $this->load->view("admin/menu/del", array(
				'info' => $info,
		));
	}
	
	
	public function online()
	{
		include_once APPPATH.'third_party/weixin/weixin.php';
		$siteInfo = get_siteinfo();
		$weixin = new weixin($siteInfo['token'], $siteInfo['appid'], $siteInfo['appsecret']);
		$menuData = $weixin->getMenu();
		if ($menuData['errno'])
		{
			$this->session->set_flashdata('error', lang('weixin_unauthorized'));
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' form_edit_succ '.serialize(array($siteInfo)));
			
			return redirect('admin/menu/index');
		}
		
		if (!empty($menuData['data']['menu']['button']))
		{
			$menuData = $menuData['data']['menu']['button'];
		}
		else
		{
			$menuData = null;
		}
		
		$params = array();
		$params['site_id'] = get_siteid();
		$params['parent_id'] = '_not_exist';
		$list = $this->menu_model->getList($params, null, 0, 999);
		
		$menuNewData = array();
		
		if ($list)
		{
			//生成菜单
			foreach ($list as $info)
			{
				if (mb_strlen($info['name']) > 16)
				{
					$this->session->set_flashdata('error', '菜单name，不超过16个字节');
					return redirect('admin/menu/online');
				}
				
				
				$menuItem = array();
				$menuItem['name'] = $info['name'];
		
				//子菜单
				if (!empty($info['children']))
				{
					$menuItem['sub_button'] = array();
					foreach ($info['children'] as $item_)
					{
						if (mb_strlen($item_['name']) > 40)
						{
							$this->session->set_flashdata('error', '子菜单name不超过40个字节');
							return redirect('admin/menu/online');
						}
						
						$menuItem_ = array();
						$menuItem_['name'] = $item_['name'];
							
						//类型
						$menuItem_['type'] = $item_['type'];
						if ($menuItem_['type'] == 'click')
						{
							if (mb_strlen($item_['content']) > 128)
							{
								$this->session->set_flashdata('error', '子菜单key不超过128个字节');
								return redirect('admin/menu/online');
							}
							
							$menuItem_['key'] = $item_['content'];
						}
						else
						{
							if (mb_strlen($item_['content']) > 256)
							{
								$this->session->set_flashdata('error', '子菜单url不超过256个字节');
								return redirect('admin/menu/online');
							}
							
							$menuItem_['type'] = 'view';
							//$menuItem_['url'] = $weixin->oauthUrl($item_['content']);
							//只有服务号&认证才能使用
							if (!empty($siteInfo['type']))
							{
								$menuItem_['url'] = $weixin->oauthUrl(get_setting('site_domain').'/oauth/userbase/'.get_siteid().'/'.base64_encode_($item_['content']));
							}
							else
							{
								$menuItem_['url'] = $item_['content'];
							}
						}
							
						$menuItem_['sub_button'] = array();
						
						if (count($menuItem['sub_button']) > 5)
						{
							$this->session->set_flashdata('error', '子菜单不能超过5个');
							return redirect('admin/menu/online');
						}
						$menuItem['sub_button'][] = $menuItem_;
					}
				}
				else
				{
					//类型
					$menuItem['type'] = $info['type'];
					if ($menuItem['type'] == 'click')
					{
						if (mb_strlen($info['content']) > 128)
						{
							$this->session->set_flashdata('error', '菜单key不超过128个字节');
							return redirect('admin/menu/online');
						}
						
						$menuItem['key'] = $info['content'];
					}
					else
					{
						if (mb_strlen($info['content']) > 256)
						{
							$this->session->set_flashdata('error', '菜单url不超过256个字节');
							return redirect('admin/menu/online');
						}
						
						$menuItem['type'] = 'view';
						
						//只有服务号&认证才能使用
						if (!empty($siteInfo['type']))
						{
							$menuItem['url'] = $weixin->oauthUrl(get_setting('site_domain').'/oauth/userbase/'.get_siteid().'/'.base64_encode_($info['content']));
						}
						else
						{
							$menuItem['url'] = $info['content'];
						}
					}
				}
				
				
				if (count($menuNewData) >3 )
				{
					$this->session->set_flashdata('error', '菜单不能超过3个');
					return redirect('admin/menu/online');
				}
				$menuNewData[] = $menuItem;
			}
		}
		//var_dump($menuNewData);
		
		
		//确定同步
		if (is_post())
		{
			$data = array('button' => $menuNewData);
			$dataStr = json_encode_cn($data);
			$result = $weixin->createMenu($dataStr);
			if ($result['errno'])
			{
				log_message('error', __CLASS__.' '.__FUNCTION__.' create_menu fail '.serialize(array($result)));
				$this->session->set_flashdata('error', $result['error']);
				return redirect('admin/menu/online');
			}
			else
			{
				$message = lang('operation_succ');
				log_message('error', __CLASS__.' '.__FUNCTION__.' menu sync succ '.serialize($message));
				$this->session->set_flashdata('success', $message);
				return redirect('admin/menu/online');
			}
		}
		
		return $this->load->view("admin/menu/online", array(
				'menus' => $menuData,
				'menuNewData' => $menuNewData
		));
	}
	
}
?>