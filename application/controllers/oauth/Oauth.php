<?php
/**
 * 微信任务模块
 * 本类切记勿加业务认证
 * 本类的方法名切勿调整, 因其他站点需调用
 *
 * @copyright Locojoy.com
 * @author lihuixu@locojoy.com
 * @version v1.0 2015.3.9
 */
include APPPATH.'third_party/weixin/weixin.php';
include APPPATH.'libraries/Token_v2.php';
class Oauth extends MY_Controller
{
	private $_token_cookie_name = 'weixin_oauth_token';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('site_model', 'user_model'));
	}
	
	/**
	 * 微信授权第一步, 
	 * 从需求方页面跳转到这里, 
	 * 跳转到微信进行统一授权工作
	 * 
	 * 先进行userbase 授权, 获得openid, 
	 * 若用户不在数据库, 则进行userinfo授权.
	 * 
	 * 注意:网页授权获取用户基本信息
	 * 订阅号无法开通此接口
	 * 服务号必须通过微信认证
	 * 
	 */
	public function index()
	{
		$this->load->library('user_agent');
		log_message('info', __CLASS__.' '.__FUNCTION__.' user_agent '.serialize($this->agent->agent_string()));
		
		$referrer = $this->agent->referrer();
		$this->log_data[] = $referrer;
		log_message('info', __CLASS__.' '.__FUNCTION__.' $referrer '.serialize($referrer));
		if (!$referrer || !strpos($referrer, '.locojoy.com') || strpos($referrer, 'wx.locojoy.com'))
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' oauth_domain_error '.serialize(array($referrer, $this->log_data)));
			return show_error(lang('oauth_domain_error'));
		}
		
		//清除token参数
		if (strpos($referrer, 'token='))
		{
			$referrer1 = preg_replace('/token=\w+/', '', $referrer);
			log_message('error', __CLASS__.' '.__FUNCTION__.' clean token '.serialize(array($referrer, $referrer1)));
			$referrer = $referrer1;
		}
		
		$oToken = new Token_v2();
		
		//判断是已有token
		$token = $this->input->get('token', true);
		if (!$token)
		{
			//$token = get_cookie($this->_token_cookie_name, true);
			//log_message('error', __CLASS__.' '.__FUNCTION__.' get token from cookie '.serialize(array($token, $this->log_data)));
		}
		if ($token)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' get_cookie, already has openid in token of cookie '.serialize(array($token, $this->log_data)));
			
			if ($oToken->check($token))
			{
				$tokenParams = $oToken->getParams();
				$this->log_data[] = $tokenParams;
				log_message('info', __CLASS__.' '.__FUNCTION__.' get_cookie, $tokenParamsArr '.serialize(array($tokenParams, $this->log_data)));
				
				if (!empty($tokenParams['openid']))
				{
					$referrer .= (strpos($referrer, '?') ? '&' : '?').'token='.$oToken->getToken();
					
					log_message('error', __CLASS__.' '.__FUNCTION__.' get_cookie, already has openid in token of cookie '.serialize(array($referrer, $this->log_data)));
					return redirect($referrer);
				}
			}
		}
		
		//subtype 当进行简单认证, 0只需获得微信用户openid, 不需要微信用户资料; 1,获取微信用户资料; 
		$site_id = (int)$this->input->get('siteid', true);
		$subtype = (int)$this->input->get('subtype', true);
		
		if ($subtype)
		{
			$subtype = 1;
		}
		
		//获取站点信息
		$siteInfo = $this->site_model->getInfo($site_id);
		if(!$siteInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notexist '.serialize(array($site_id, $this->log_data)));
			return show_error(lang('site_notexist'));
		}
		
		//检查设置
		if (empty($siteInfo['token']) || empty($siteInfo['appid']) || empty($siteInfo['appsecret']))
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' weixin_setting_error '.serialize(array($this->log_data)));
			return show_error(lang('weixin_setting_error'));
		}
		//必须是服务号
		if (!$siteInfo['type'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notserver '.serialize(array($siteInfo, $this->log_data)));
			return show_error(lang('site_notserver'));
		}
		//必须认证
		if (!$siteInfo['verify'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notverify '.serialize(array($siteInfo, $this->log_data)));
			return show_error(lang('site_notverify'));
		}
		
		//微信接口对象
		$weixin = new weixin($siteInfo['token'], $siteInfo['appid'], $siteInfo['appsecret']);
		
		//简单授权地址
		$redirect_url = get_setting('site_domain') . '/oauth/oauth/userbase/'.$site_id.'/'.base64_encode_($referrer).'/'.$subtype;
		$this->log_data[] = $redirect_url;
		$url = $weixin->oauthUrl($redirect_url, md5($referrer), 'snsapi_base');
		
		$this->log_data[] = $url;
		log_message('info', __CLASS__.' '.__FUNCTION__.' oauthUrl '.serialize($this->log_data));
		return redirect($url);
	}
	
	/**
	 * 微信授权第二步, 
	 * 从微信授权后跳转到这里
	 * 跳转到需求方页面
	 * 
	 *
	 */
	public function userbase()
	{
		$this->load->library('user_agent');
		
		$code = $this->input->get('code', true);
		$state = $this->input->get('state', true);
		$site_id = $this->uri->segment(3);
		$referrer = $this->uri->segment(4);
		$subtype = $this->uri->segment(5);
		$this->log_data[] = $code;
		$this->log_data[] = $state;
		$this->log_data[] = $site_id;
		$this->log_data[] = $referrer;
		$this->log_data[] = $subtype;
		 
		if (!$code)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' params error '. serialize(array($this->log_data)));
			return show_error(lang('oauth_error'));
		}
		
		if ($referrer)
		{
			$referrer = base64_decode_($referrer);
			//放开限制, 允许任何链接
			//$urlInfo = parse_url($referrer);
 			//if (!in_array($urlInfo['hosts'], array('bbs.locojoy.com', 'm.wsq.qq.com')))
 			//{
 				//log_message('error', __CLASS__.' '.__FUNCTION__.' $referrer not locojoy '.serialize(array($urlInfo, $this->log_data)));
 				//return show_error(lang('oauth_domain_error'));//注释慎重打开
 			//}
		}
		
		//获取微信信息
		$siteInfo = $this->site_model->getInfo($site_id);
		if(!$siteInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notexist '.serialize(array($site_id, $this->log_data)));
			return show_error(lang('site_notexist'));
		}
		
		//检查设置
		if (empty($siteInfo['token']) || empty($siteInfo['appid']) || empty($siteInfo['appsecret']))
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' weixin_setting_error '.serialize(array($this->log_data)));
			return show_error(lang('weixin_setting_error'));
		}
		//必须是服务号
		if (!$siteInfo['type'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notserver '.serialize(array($siteInfo, $this->log_data)));
			return show_error(lang('site_notserver'));
		}
		//必须认证
		if (!$siteInfo['verify'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notverify '.serialize(array($siteInfo, $this->log_data)));
			return show_error(lang('site_notverify'));
		}
		
		//实例化微信接口对象
		$weixin = new weixin($siteInfo['token'], $siteInfo['appid'], $siteInfo['appsecret']);
	
		//授权第二步, 拿到返回的code去交换access_token
		$result = $weixin->oauthAccessToken($code);
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' oauthAccessToken error '. serialize(array($result, $this->log_data)));
			return show_error(lang('oauth_error'));
		}
		$accessToken = $result['data'];
		//$this->log_data[] = $accessToken;
		log_message('error', __CLASS__.' '.__FUNCTION__.' $weixin oauthAccessToken ' . serialize($this->log_data));
	
		//拿到openid
		$openid = $accessToken['openid'];
		$this->log_data[] = $openid;
		log_message('info', __CLASS__.' '.__FUNCTION__.' $weixin $openid ' . serialize($this->log_data));
	
		//查询用户信息
		$attributes = array();
		$attributes['site_id'] = $site_id;
		$attributes['openid'] = $openid;
		$userInfo = $this->user_model->getInfoByAttribute($attributes);
		
		//判断是否同步用户信息
		$is_sync = false;
		
		if (!$userInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' user_notexist '.serialize(array($attributes, $this->log_data)));
			
			$weixinUserInfo = array();
			$weixinUserInfo['site_id'] = $site_id;
			$weixinUserInfo['openid'] = $openid;
			$weixinUserInfo['create_time'] = time();
			$result = $this->user_model->insertInfo($weixinUserInfo);
			
			$is_sync = true;
		}
		else
		{
			//用户资料时间太长, 同步用户资料
			if (empty($userInfo['last_update_time']) || time() - $userInfo['last_update_time'] > 86400 * 7)
			{
				$is_sync = true;
				log_message('info', __CLASS__.' '.__FUNCTION__.' userinfo timeout '. serialize(array($userInfo)));
			}
			
			//若没有关注咱们的微信号, 则进行授权方式获取用户资料
			if ($subtype)
			{
				$is_sync = true;
				log_message('info', __CLASS__.' '.__FUNCTION__.' userinfo nouser '. serialize(array($userInfo)));
			}
		}
		
		if ($is_sync)
		{
			$redirect_url = get_setting('site_domain') . '/oauth/oauth/userinfo/'.$site_id.'/'.base64_encode_($referrer);
			$this->log_data[] = $redirect_url;
			$url = $weixin->oauthUrl($redirect_url, md5($referrer), 'snsapi_userinfo');
			
			$this->log_data[] = $url;
			log_message('info', __CLASS__.' '.__FUNCTION__.' redirect userinfo oauthUrl '.serialize($this->log_data));
			return redirect($url);
		}
	
		log_message('error', __CLASS__.' '.__FUNCTION__.' weixin_model getByOpenId ' . serialize($userInfo));
	
		//$userInfoStr = serialize($userInfo);
	
		//用户日志
		// 		$params = array();
		// 		$params['user_id'] = $userInfo['user_id'];
		// 		$params['ip'] = (string)$this->input->ip_address();
		// 		$params['type'] = 'oauth';
		// 		$params['data'] = $userInfoStr;
		// 		$result = $this->weixin_model->addRecord($params);
	
		//回调到相应程序
		$redirect_url = site_url();
		if ($referrer)
		{
			$redirect_url = $referrer;
		}
	
		//去除token参数
		if (strpos($redirect_url, 'token='))
		{
			$url1 = preg_replace('/token=\w+/', '', $redirect_url);
			log_message('error', __CLASS__.' '.__FUNCTION__.' url '.serialize(array($redirect_url, $url1)));
			$redirect_url = $url1;
		}
	
		$oToken = new Token_v2();
		
		$oToken->addParam('site_id', $site_id);
		$oToken->addParam('openid', $openid);
		$oToken->addParam('time', time());
		
		//生成token
		$oToken->make();
		
		$redirect_url .= (strpos($redirect_url, '?') ? '&' : '?').'token='.$oToken->getToken();
		
		//设置用户标志
		set_cookie($this->_token_cookie_name, $oToken->getToken(), 86400);
	
		log_message('info', __CLASS__.' '.__FUNCTION__.' succ ' . json_encode($redirect_url));
		return redirect($redirect_url);
	}
    
    /**
     * 网页授权获取用户基本信息
     * 1.在微信界面打开第一步链接, 获取授权
     * 2.通过code换取access_token
     * 3.使用access_token获取用户信息, 添加/更新本地用户数据
     * 4.保存openid 到cookie
     * 5.回跳到首页/其他页面
     */
    public function userinfo()
    {
    	$code = $this->input->get('code', true);
    	$state = $this->input->get('state', true);
    	$site_id = $this->uri->segment(3);
    	$referrer = $this->uri->segment(4);
    	$this->log_data[] = $code;
    	$this->log_data[] = $state;
    	$this->log_data[] = $site_id;
    	$this->log_data[] = $referrer;
    	log_message('info', __CLASS__.' '.__FUNCTION__.' params '.serialize($this->log_data));
    	
    	if (!$code)
    	{
    		log_message('error', __CLASS__.' '.__FUNCTION__.' params error : $code empty '. serialize(array($this->log_data)));
    		return show_error(lang('oauth_error'));
    	}
    	
    	if ($referrer)
    	{
    		$referrer = base64_decode_($referrer);
    		//切勿注释, 必须是我们的链接
    		//if (!strpos($referrer, '.locojoy.com'))
    		//{
    			//log_message('error', __CLASS__.' '.__FUNCTION__.' oauth_domain_error '.serialize(array($referrer, $this->log_data)));
    			//return show_error(lang('oauth_domain_error'));
    		//}
    	}
    	
    	//获取微信信息
		$siteInfo = $this->site_model->getInfo($site_id);
		if(!$siteInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notexist '.serialize(array($site_id, $this->log_data)));
			return show_error(lang('site_notexist'));
		}
		
		//检查设置
		if (empty($siteInfo['token']) || empty($siteInfo['appid']) || empty($siteInfo['appsecret']))
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' weixin_setting_error '.serialize(array($this->log_data)));
			return show_error(lang('weixin_setting_error'));
		}
		//必须是服务号
		if (!$siteInfo['type'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notserver '.serialize(array($siteInfo, $this->log_data)));
			return show_error(lang('site_notserver'));
		}
		//必须认证
		if (!$siteInfo['verify'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notverify '.serialize(array($siteInfo, $this->log_data)));
			return show_error(lang('site_notverify'));
		}
    	
		//实例化微信接口对象
    	$weixin = new weixin($siteInfo['token'], $siteInfo['appid'], $siteInfo['appsecret']);
		
		//授权第二步, 拿到返回的code去交换access_token
		$result = $weixin->oauthAccessToken($code);
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' oauth_error '. serialize(array($result, $this->log_data)));
			return show_error(lang('oauth_error'));
		}
		$accessToken = $result['data'];
		$access_token = $accessToken['access_token'];
		$openid = $accessToken['openid'];
		
		$this->log_data[] = $accessToken;
		log_message('info', __CLASS__.' '.__FUNCTION__.' $weixin oauthAccessToken ' . serialize(array($accessToken, $this->log_data)));
		
		//获取微信用户数据
		$result = $weixin->oauthGetUserInfo($access_token, $openid);
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' weixin getUserInfo error ' . serialize(array($openid, $result)));
			return show_error($result['error']);
		}
		$weixinUserInfo = $result['data'];
		log_message('info', __CLASS__.' '.__FUNCTION__.' $weixin getUserInfo ' . serialize(array($openid, $weixinUserInfo)));
		
		//查询用户信息
		$attributes = array();
		$attributes['site_id'] = $site_id;
		$attributes['openid'] = $openid;
		$userInfo = $this->user_model->getInfoByAttribute($attributes);
		if (!$userInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' user_notexist '.serialize(array($attributes, $this->log_data)));
			
			$weixinUserInfo['site_id'] = $site_id;
			$weixinUserInfo['openid'] = $openid;
			$weixinUserInfo['create_time'] = time();
			$result = $this->user_model->insertInfo($weixinUserInfo);
			
			log_message('error', __CLASS__.' '.__FUNCTION__.' user_insert new '.serialize(array($attributes, $this->log_data)));
		}
		else
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' user exist ' . serialize(array($userInfo, $weixinUserInfo)));
			
			$is_update = false;
			
			//用户资料时间太长, 同步用户资料
			if (empty($userInfo['last_update_time']) || time() - $userInfo['last_update_time'] > 86400 * 7)
			{
				$is_sync = true;
				//log_message('error', __CLASS__.' '.__FUNCTION__.' userinfo timeout '. serialize(array($userInfo)));
			}
			
			//用户存在, 且昵称相同, 不需要同步
			if (empty($userInfo['nickname']) || empty($weixinUserInfo['nickname']) || $userInfo['nickname'] != $weixinUserInfo['nickname'])
			{
				$is_update = true;
			}
			
			if (empty($userInfo['headimgurl']) || empty($weixinUserInfo['headimgurl']) || $userInfo['headimgurl'] != $weixinUserInfo['headimgurl'])
			{
				$is_update = true;
			}
			
			if ($is_update)
			{
				$result = $this->user_model->updateInfo($userInfo['user_id'], $weixinUserInfo);
				log_message('error', __CLASS__.' '.__FUNCTION__.' weixin_model updateUser ' . serialize(array($result, $weixinUserInfo)));
			}
		}
		
		//用户日志
// 		$params = array();
// 		$params['user_id'] = $userInfo['user_id'];
// 		$params['ip'] = (string)$this->input->ip_address();
// 		$params['type'] = 'oauth';
// 		$params['data'] = $userInfoStr;
// 		$result = $this->weixin_model->addRecord($params);
		
		//user_info 存储到cookie
		//$this->input->set_cookie("user_info", $userInfoStr, 360000);
		
		//回调到相应程序
		$redirect_url = site_url();
		if ($referrer)
		{
			$redirect_url = $referrer;
		}
		
		//加上token参数, 供调取iuserinfo
		if (strpos($redirect_url, 'token='))
		{
			$url1 = preg_replace('/token=\w+/', '', $redirect_url);
			log_message('error', __CLASS__.' '.__FUNCTION__.' url '.serialize(array($redirect_url, $url1)));
			$redirect_url = $url1;
		}
		
		$oToken = new Token_v2();
		
		$oToken->addParam('site_id', $site_id);
		$oToken->addParam('openid', $openid);
		$oToken->addParam('time', time());
		
		//生成token
		$oToken->make();
		
		$redirect_url .= (strpos($redirect_url, '?') ? '&' : '?').'token='.$oToken->getToken();
		
		//设置用户标志
		set_cookie($this->_token_cookie_name, $oToken->getToken(), 86400);
		
		log_message('info', __CLASS__.' '.__FUNCTION__.' succ ' . json_encode($redirect_url));
		return redirect($redirect_url);
    }
    
    public function iuserinfo()
    {
    	$oToken = new Token_v2();
    	
    	//解析token
    	$token = $this->input->get('token', true);
    	if (!$token)
    	{
    		//$token = get_cookie($this->_token_cookie_name, true);
    		//log_message('error', __CLASS__.' '.__FUNCTION__.' get token from cookie '.serialize(array($token, $this->log_data)));
    	}
    	if (!$token)
    	{
    		log_message('error', __CLASS__.' '.__FUNCTION__.' params token error get '.serialize(array($this->input->post(), $this->input->get())));
    		return response(null, 'token_error', lang('weixin_auth_err'));
    	}
    	if (!$oToken->check($token))
    	{    		
    		log_message('error', __CLASS__.' '.__FUNCTION__.' token check fail '.serialize(array($token, $this->log_data)));
    		return response('', 'valid_fail', lang('params_error'));
    	}
    
    	$tokenParams = $oToken->getParams();
    	$this->log_data[] = $tokenParams;
    	log_message('info', __CLASS__.' '.__FUNCTION__.' $tokenParamsArr '.serialize(array($tokenParams)));
    	
    	if (empty($tokenParams['site_id']))
    	{
    		log_message('error', __CLASS__.' '.__FUNCTION__.' weixin_siteid_error '.serialize($this->log_data));
    		return response('', 'weixin_siteid_error', lang('weixin_siteid_error'));
    	}
    	if (empty($tokenParams['openid']))
    	{
    		log_message('error', __CLASS__.' '.__FUNCTION__.' weixin_openid_error '.serialize($this->log_data));
    		return response('', 'weixin_openid_error', lang('weixin_openid_error'));
    	}
    	$openid = $tokenParams['openid'];
    	$site_id = $tokenParams['site_id'];
    	
    	$params = array();
    	$params['site_id'] = $site_id;
    	$params['openid'] = $openid;
    	$userInfo = $this->user_model->getInfoByAttribute($params);
		if (!$userInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' user_notexist '.serialize($this->log_data));
			return response('', 'user_notexist', lang('user_notexist'));
		}
		
		//处理头像图片
		$retdata = array();
		$retdata['openid'] = $userInfo['openid'];
		$retdata['nickname'] = $userInfo['nickname'];
		$retdata['headimgurl'] = trim($userInfo['headimgurl'], '/0') . '/64';
    	
		log_message('info', __CLASS__.' '.__FUNCTION__.' succ '.serialize(array($retdata, $this->log_data)));
    	return response($retdata);
    }
    
    /**
     * 获取微信分享签名
     * 
     * 来源必须是.locojoy.com
     * 
     */
    public function iSignature()
    {
    	//判断来源网页权限
    	$referrer = $this->agent->referrer();
    	$this->log_data[] = $referrer;
//     	if (!$referrer || !strpos($referrer, '.locojoy.com'))
//     	{
//     		log_message('error', __CLASS__.' '.__FUNCTION__.' oauth_domain_error '.serialize(array($this->log_data)));
//     		return response('', 'oauth_domain_error', lang('oauth_domain_error'));
//     	}
    	
    	//url
    	$url = trim($this->input->get('url', true));
    	$site_id = (int)$this->input->get('site_id', true);
//     	if (!$url || !strpos($url, '.locojoy.com'))
//     	{
//     		log_message('error', __CLASS__.' '.__FUNCTION__.' oauth_domain_error '.serialize(array($this->log_data)));
//     		return response('', 'oauth_domain_error', lang('oauth_domain_error'));
//     	}
    	
		//获取站点信息
		$siteInfo = $this->site_model->getInfo($site_id);
		if(!$siteInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notexist '.serialize(array($site_id, $this->log_data)));
			return show_error(lang('site_notexist'));
		}
		
		//检查设置
		if (empty($siteInfo['token']) || empty($siteInfo['appid']) || empty($siteInfo['appsecret']))
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' weixin_setting_error '.serialize(array($this->log_data)));
			return show_error(lang('weixin_setting_error'));
		}
		//必须是服务号
		if (!$siteInfo['type'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notserver '.serialize(array($siteInfo, $this->log_data)));
			return show_error(lang('site_notserver'));
		}
		//必须认证
		if (!$siteInfo['verify'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' site_notverify '.serialize(array($siteInfo, $this->log_data)));
			return show_error(lang('site_notverify'));
		}
		
		//微信接口对象
		$weixin = new weixin($siteInfo['token'], $siteInfo['appid'], $siteInfo['appsecret']);
		
		//获得ticket
    	$result = $weixin->getTicket();
    	if ($result['error'] || !$result['data'])
    	{
    		log_message('error', __CLASS__.' '.__FUNCTION__.' $weixin getTicket error '.serialize(array($result, $this->log_data)));
    		return response('', $result['errno'], lang('weixin_getTicket_error'));
    	}
    	$jsapiTicket = $result['data'];
    	$nonceStr = make_rand(16);
    	$timestamp = time();
    
    	$dataStr = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
    	//log_message('error', __CLASS__.' '.__FUNCTION__.' sha1 str '.serialize(array($dataStr, $this->log_data)));
    
    	$signature = sha1($dataStr);
    
    	//清除question_id=参数
    	if (strpos($url, 'question_id='))
    	{
    		$url1 = preg_replace('/question_id=\w*/', '', $url);
    		log_message('info', __CLASS__.' '.__FUNCTION__.' clean question_id '.serialize(array($url, $url1)));
    		$url = $url1;
    	}
    	
    	//清除token参数
    	if (strpos($url, 'token='))
    	{
    		$url1 = preg_replace('/token=\w*/', '', $url);
    		log_message('info', __CLASS__.' '.__FUNCTION__.' clean token '.serialize(array($url, $url1)));
    		$url = $url1;
    	}
    
    	//$data['jsapi_ticket'] = '';
    	//unset($data['jsapi_ticket']);
    	$data = array();
    	$data['appid'] = $siteInfo['appid'];
    	$data['noncestr'] = $nonceStr;
    	$data['timestamp'] = $timestamp;
    	$data['url'] = $url;
    	$data['signature'] = $signature;
    	log_message('info', __CLASS__.' '.__FUNCTION__.' rt $data '.serialize(array($data, $this->log_data)));
    
    	return response($data);
    }
    
}
