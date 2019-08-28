<?php
/**
 * 响应模块
 *
 * @copyright Locojoy.com
 * @author lihuixu@locojoy.com
 * @version v1.0 2014.4.18
 */
include APPPATH.'third_party/weixin/weixin.php';

class Client extends MY_Controller
{
	private $weixin = null;
	private $siteConfig = null;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('site_model', 'keyword_model', 'keyword_alias_model', 'client_record_model'));
	}
	
	public function index($site_id = 0)
	{
		$this->log_data[] = $site_id;
		//微信分号
		if (!$site_id)
		{
			log_message('error', __CLASS__.' '. __FUNCTION__.' $site_id empty '. json_encode(array($this->log_data)));
			exit();
		}
		
		//获取当前站点详情
		$siteInfo = $this->site_model->getInfo($site_id);
		if (!$siteInfo)
		{
			log_message('error', __CLASS__.' '. __FUNCTION__.' site error '. json_encode(array($site_id, $siteInfo, $this->log_data)));
			exit();
		}
		$this->siteConfig = $siteInfo;
		$this->log_data[] = $this->siteConfig;
		
		//更新站点信息
		$attrs = array();
		//设置通信状态
		if (!$siteInfo['connect_status'])
		{
			$attrs['connect_status'] = 1;
		}
		//上次通信时间
		if (!$siteInfo['connect_last_time'] || $siteInfo['connect_last_time'] < strtotime(date('Y-m-d')))
		{
			$attrs['connect_last_time'] = time();
		}
		if ($attrs)
		{
			$this->site_model->updateInfo($site_id, $attrs);
		}
		
		//设置站点
		setSite($site_id);
		log_message('error', __CLASS__.' '. __FUNCTION__.' site info '. json_encode(array($this->log_data)));
		
		//实例化微信接口对象
    	$this->weixin = new weixin($this->siteConfig['token'], $this->siteConfig['appid'], $this->siteConfig['appsecret']);
    	
		//验证
		$result = $this->weixin->auth();
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '. __FUNCTION__.' weixin auth error '. serialize($result));
			exit();
		}
		
		$result = $this->weixin->getData();
		if (!$result['data'])
		{
			log_message('error', __CLASS__.' '. __FUNCTION__.' request data empty '. serialize($result));
			exit();
		}
		$requestData = $result['data'];
		//log_message('INFO', __CLASS__.' '. __FUNCTION__.' $weixin getData '. serialize($requestData));
		
		
		//记录行为数据
		$params = array();
		$params['site_id'] = $site_id;
		$params['openid'] = $requestData['FromUserName'];
		$params['type'] = $requestData['MsgType'];
		!empty($requestData['Content']) && $params['keyword'] = $requestData['Content'];
		$params['content'] = serialize($requestData);
		$params['create_time'] = time();
		$result = $this->client_record_model->insertInfo($params);
		
		//同步用户信息
		$this->synchronizeUser($requestData);
		
		//返回数据
		$responseData = array();
		
		/* 获取回复信息 */
		// 这里的回复信息是通过判断请求内容自行定制的， 不在 SDK范围内，请自行完成
		switch (strtolower($requestData['MsgType']))
		{
			case 'text' :
				$responseData = $this->text($requestData);
				break;
			case 'image' :
				$responseData = $this->image($requestData);
				break;
			case 'voice' :
				$responseData = $this->voice($requestData);
				break;
			case 'video' :
				$responseData = $this->video($requestData);
				break;
			case 'link' :
				$responseData = $this->link($requestData);
				break;
			case 'event' :
				$responseData = $this->event($requestData);
				break;
			default:
				log_message('error', __CLASS__.' '. __FUNCTION__.' no this MsgType'. serialize($requestData));
				exit;
		}
		
		//交换对象
		$responseData['ToUserName'] = $requestData['FromUserName'];
		$responseData['FromUserName'] = $requestData['ToUserName'];
		
		//统一替换换行符
		if (isset($requestData['Content']) && strstr($requestData['Content'], '\t\n'))
		{
			$requestData['Content'] = str_replace('\t\n', "\t\n", $requestData['Content']);
		}
		
		$result = $this->weixin->response($responseData);
		log_message('info', __CLASS__.' '. __FUNCTION__.' response '. serialize($result['data']));
		
		echo($result['data']);
		return ;
	}
	
	/**
	 * 回复文字
	 *
	 * @return array
	 */
	protected function text($requestData)
	{
		$requestData = $this->getMessage($requestData);
		log_message('info', __CLASS__.' '. __FUNCTION__.' getMessage '. serialize(array($requestData)));
		
		return $requestData;
	}
	
	/**
	 * 回复图片消息
	 *
	 * ToUserName 	是 	接收方帐号（收到的OpenID）
	 FromUserName 	是 	开发者微信号
	 CreateTime 	是 	消息创建时间 （整型）
	 MsgType 	是 	image
	 MediaId 	是 	通过上传多媒体文件，得到的id。
	 */
	protected function image($requestData)
	{
		$requestData['MsgType'] = 'text';
		$requestData['Content'] = '图片';
		
		$requestData = $this->getMessage($requestData);
		log_message('INFO', __CLASS__.' '. __FUNCTION__.' getMessage '. serialize(array($requestData)));
		
		return $requestData;
	}
	
	/**
	 * 回复语音消息
	 *
	 * ToUserName 	是 	接收方帐号（收到的OpenID）
	 FromUserName 	是 	开发者微信号
	 CreateTime 	是 	消息创建时间戳 （整型）
	 MsgType 	是 	语音，voice
	 MediaId 	是 	通过上传多媒体文件，得到的id
	 * @param  string $content 要回复的音乐
	 */
	protected function voice($requestData)
	{
		$requestData['MsgType'] = 'voice';
		$requestData['MediaId'] = $requestData['MediaId'];
		$requestData['Content'] = '你好, 这是个语音.';
		
		$requestData['MsgType'] = 'text';
		$requestData['Content'] = '语音';
		
		$requestData = $this->getMessage($requestData);
		log_message('INFO', __CLASS__.' '. __FUNCTION__.' getMessage '. serialize(array($requestData)));
		
		return $requestData;
	}
	
	protected function video($requestData)
	{
		$requestData['MsgType'] = 'voice';
		$requestData['MediaId'] = $requestData['MediaId'];
		$requestData['Content'] = '你好, 这是个视频.';
		
		$requestData['MsgType'] = 'text';
		$requestData['Content'] = '视频';
		
		$requestData = $this->getMessage($requestData);
		log_message('INFO', __CLASS__.' '. __FUNCTION__.' getMessage '. serialize(array($requestData)));
		
		return $requestData;
	}
	
	protected function link($requestData)
	{
		$requestData['MsgType'] = 'voice';
		$requestData['MediaId'] = $requestData['MediaId'];
		$requestData['Content'] = '你好, 这是个链接.';
		
		$requestData['MsgType'] = 'text';
		$requestData['Content'] = '链接';
		
		$requestData = $this->getMessage($requestData);
		log_message('INFO', __CLASS__.' '. __FUNCTION__.' getMessage '. serialize(array($requestData)));
		
		return $requestData;
	}
	
	
	
	/**
	 * 回复图文消息
	 *
	 * ToUserName 	是 	接收方帐号（收到的OpenID）
	 FromUserName 	是 	开发者微信号
	 CreateTime 	是 	消息创建时间 （整型）
	 MsgType 	是 	news
	 ArticleCount 	是 	图文消息个数，限制为10条以内
	 Articles 	是 	多条图文消息信息，默认第一个item为大图,注意，如果图文数超过10，则将会无响应
	 Title 	否 	图文消息标题
	 Description 	否 	图文消息描述
	 PicUrl 	否 	图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200
	 Url 	否 	点击图文消息跳转链接
	 */
	protected function news($requestData)
	{
		$articles = array();
		foreach ($news as $key => $value) {
			list(
					$articles[$key]['Title'],
					$articles[$key]['Description'],
					$articles[$key]['PicUrl'],
					$articles[$key]['Url']
			) = $value;
			if($key >= 9) { break; } //最多只允许10调新闻
		}
		$requestData['ArticleCount'] = count($articles);
		$requestData['Articles'] = $articles;
		return $requestData;
	}
	
	/**
	 * 响应事件.关注
	 *
	 * 关注
	 * ToUserName 	开发者微信号
	 FromUserName 	发送方帐号（一个OpenID）
	 CreateTime 	消息创建时间 （整型）
	 MsgType 	消息类型，event
	 Event 	事件类型，subscribe(订阅)、unsubscribe(取消订阅)
	 *
	 *
	 * 扫描带参数二维码事件, 用户未关注时，进行关注后的事件推送
	 * ToUserName 	开发者微信号
	 FromUserName 	发送方帐号（一个OpenID）
	 CreateTime 	消息创建时间 （整型）
	 MsgType 	消息类型，event
	 Event 	事件类型，subscribe
	 EventKey 	事件KEY值，qrscene_为前缀，后面为二维码的参数值
	 Ticket 	二维码的ticket，可用来换取二维码图片
	
	 * @return array
	 */
	protected function event($requestData)
	{
		if (!isset($requestData['Event']))
		{
			$requestData['Event'] = '';
		}
		
		switch (strtolower($requestData['Event']))
		{
			case 'subscribe' :
				//扫描带参数二维码事件.还未关注时
				if (isset($requestData['EventKey']) && strstr($requestData['EventKey'], 'qrscene_'))
				{
					$requestData['Content'] = '扫描关注';
					$requestData = $this->getMessage($requestData);
						
					$key = substr($requestData['EventKey'], strlen('qrscene_'));
					$requestData['MsgType'] = 'text';
					$requestData['Content'] .= $key;
				}
				else
				{
					$requestData['Content'] = '欢迎语';
					$requestData = $this->getMessage($requestData);
				}
				
				log_message('INFO', __CLASS__.' '.__FUNCTION__.' subscribe ' . serialize($requestData));
				
				break;
			case 'unsubscribe' ://取消关注
				$requestData['MsgType'] = 'text';
				$requestData['Content'] = '您已取消关注.';
				//unset($requestData['EventKey']);
				
				log_message('info', __CLASS__.' '. __FUNCTION__.' unsubscribe '. serialize($requestData));
				
				break;
			case 'scan' ://扫描带参数二维码事件, 用户已关注时的事件推送
				$scene_id = $requestData['EventKey'];
	
				$requestData['MsgType'] = 'text';
				$requestData['Content'] = '你好, 您已关注.'.$scene_id;
				break;
			case 'location' ://上报地理位置事件
	
				log_message('INFO', __CLASS__.' '. __FUNCTION__.' location '. serialize($requestData));
	    		
				//插入/更新用户位置表
				$this->load->model(array('Location_model'));
	    		$params = array();
	    		$params['site_id'] = $this->siteConfig['site_id'];
	    		$params['openid'] = $requestData['FromUserName'];
	    		$params['latitude'] = $requestData['Latitude'];
	    		$params['longitude'] = $requestData['Longitude'];
	    		$params['precision'] = $requestData['Precision'];
	    		$params['create_time'] = time();
	    		$this->Location_model->insertInfo($params);
	    		
				$requestData['MsgType'] = 'text';
				$requestData['Content'] = '已上报地理位置';
	    		break;
			case 'click' ://自定义菜单事件
				
				log_message('error', __CLASS__.' '. __FUNCTION__.' click '. serialize($requestData));
				$key = $requestData['EventKey'];
				
				$requestData['Content'] = $key;
				$requestData = $this->getMessage($requestData);
				break;
				
			//用户领取卡券
			/**
			 * <xml> <ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<FriendUserName><![CDATA[FriendUser]]></FriendUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[user_get_card]]></Event>
<CardId><![CDATA[cardid]]></CardId>
<IsGiveByFriend>1</IsGiveByFriend>
<UserCardCode><![CDATA[12312312]]></UserCardCode>
<OuterId>0</OuterId>
</xml>
			 * **/
			case 'user_get_card':
				log_message('error', __CLASS__.' '. __FUNCTION__.' user_get_card '. serialize($requestData));
				
				//card_id
				
				
			//用户删除卡券
			/**
				<xml> <ToUserName><![CDATA[toUser]]></ToUserName>
				<FromUserName><![CDATA[FromUser]]></FromUserName>
				<CreateTime>123456789</CreateTime>
				<MsgType><![CDATA[event]]></MsgType>
				<Event><![CDATA[user_del_card]]></Event>
				<CardId><![CDATA[cardid]]></CardId>
				<UserCardCode><![CDATA[12312312]]></UserCardCode>
				</xml>
			**/
			case 'user_del_card' : 
				log_message('error', __CLASS__.' '. __FUNCTION__.' user_del_card '. serialize($requestData));
				
				//card_id
				
				
			default:
				$requestData['MsgType'] = 'text';
				$requestData['Content'] = '你好,欢迎您关注乐动卓越公众助手';
		}
		return $requestData;
	}
	
	/**
	 * 获取关键词的匹配语
	 * 1.交互式回复interactive response
	 * 2.文字检索
	 *
	 * @param unknown $key
	 * @param string $default
	 * @return boolean|Ambigous <string, boolean>
	 */
	protected function getMessage($requestData)
	{
		$cachekey = 'client:dialog:'.$this->siteConfig['site_id'].':'.$requestData['FromUserName'];
		
		//交互式回复, 回复的数字翻译为对应的字符串
		if (is_numeric($requestData['Content']) && $requestData['Content'] < 100)
		{
			$num = $requestData['Content'];
			$cacheData = cache_get($cachekey);
			if ($cacheData)
			{
				$cacheValue = unserialize($cacheData);
				log_message('error', __CLASS__.' '. __FUNCTION__.' dialog front '. serialize(array($requestData, $cachekey, $cacheData)));
				if(!$cacheValue || !isset($cacheValue[$num]))
				{
					log_message('error', __CLASS__.' '. __FUNCTION__.' dialog match error '. serialize(array($cacheValue, $num, $cachekey)));
				}
				else
				{
					$requestData['Content'] = $cacheValue[$num];
					log_message('error', __CLASS__.' '. __FUNCTION__.' dialog match success '. serialize(array($requestData, $num, $cachekey)));
				}
			}
		}
		
		/********************************************
		 * 1.特殊业务处理
		 * 1.1.红包码兑换红包
		 * 
		 ********************************************/
		
		//领取红包码
		if (strlen($requestData['Content']) == get_setting('redpack_code') && preg_match('/^\w+$/', $requestData['Content']))
		{
			log_message('error', __CLASS__.' '. __FUNCTION__.' redpack  '. serialize(array($requestData)));
			$result = $this->getRedpack($requestData);
			if ($result['errno'])
			{
				$requestData['type'] = 'text';
				$requestData['Content'] = $result['error'];
				log_message('error', __CLASS__.' '. __FUNCTION__.' redpack fail '. serialize(array($requestData)));
			}
			else
			{
				$requestData['type'] = 'text';
				$requestData['Content'] = $result['error'];
				log_message('error', __CLASS__.' '. __FUNCTION__.' redpack succ '. serialize(array($requestData)));
			}
			
			return $requestData;
		}
		
		/********************************************
		 * 2.查询关键词
		 *
		 ********************************************/
		//字母数字转小写
		$requestData['Content'] = strtolower($requestData['Content']);
		log_message('info', __CLASS__.' '. __FUNCTION__.' strtolower '. serialize(array($requestData['Content'])));
		
		//完全匹配关键词
		$params = array();
		$params['site_id'] = $this->siteConfig['site_id'];
		$params['name'] = $requestData['Content'];
		$info = $this->keyword_alias_model->getInfoByAttribute($params);
		log_message('error', __CLASS__.' '. __FUNCTION__.' keyword_info '. serialize(array($info, $requestData)));
		
		/********************************************
		 * 2.1.关键词不存在, 给予友好提示
		 *
		 ********************************************/
		if (empty($info))
		{
			log_message('error', __CLASS__.' '. __FUNCTION__.' not find: keyword '. serialize(array($requestData['Content'])));
			
			//1分钟内只出现一次
// 			$cachekeyLimit = 'client:dialog_limit:'.$this->siteConfig['site_id'].':'.$requestData['FromUserName'];
// 			if (cache_get($cachekeyLimit))
// 			{
// 				log_message('error', __CLASS__.' '. __FUNCTION__.' client:dialog non-frequently '. serialize(array($requestData, $cachekeyLimit)));
// 				exit();
// 			}
			
			//没找到对应的回复词语, 则使用默认
			$params = array();
			$params['site_id'] = $this->siteConfig['site_id'];
			$params['name'] = '默认语';
			$info = $this->keyword_alias_model->getInfoByAttribute($params);
			if (empty($info))
			{
				log_message('error', __CLASS__.' '. __FUNCTION__.' not find: default '. serialize(array($params, $requestData['Content'])));
			
				//获取推荐的条目
				$params = array();
				$params['site_id'] = $this->siteConfig['site_id'];
				$relationList = $this->keyword_alias_model->getList($params, array('sort' => 'desc'), 0, 5);
				if (!$relationList)
				{
					log_message('error', __CLASS__.' '. __FUNCTION__.' getWordList '.json_encode(array($params, $result)));
				}
				else
				{
					$relationWordKeys = array();
					$replaceStr = "\t\n";
					foreach ($relationList as $key_ => $item_)
					{
						$relationWordKeys[$key_+1] = $item_['name'];
						$replaceStr .= '['.($key_+1).'] ' . $item_['name']."\t\n";
					}
					cache_set($cachekey, serialize($relationWordKeys), 7200);
						
					//交互式记录回话
					$requestData['type'] = '';
					$requestData['Content'] = '您是否要找：'. $replaceStr.'请输入编号进行选择';
				}
			}
				
			//cache_set($cachekeyLimit, time(), 60);
			
			return $requestData;
		}
		else
		{
		    $info = $this->keyword_model->getInfo($info['keyword_id']);
		}
		
		/***********************************************************************
		 * 3.关键词存在, 根据关联的结果对象, 处理业务
		 ***************************************************************************/
		log_message('error', __CLASS__.' '. __FUNCTION__.' object '.json_encode(array($info['object'], $info)));
		switch ($info['object'])
		{
			//对应一句话
			case 0 : 
			    $requestData['Content'] = $info['content'];
				break;
			//对应一个列表
			case 1 :
				$requestData = $this->dealRelation($requestData, $info, $cachekey);
				break;
			//对应发码功能
			case 2 :
				$requestData = $this->dealCode($requestData, $info);
				break;
			//对应签到功能
			case 3 :
				$requestData = $this->dealSignin($requestData, $info);
				break;
			//对应抽奖功能
			case 4 :
				$requestData = $this->dealLottery($requestData, $info);
				break;
			//对应文章功能
			case 5 :
				$requestData = $this->dealArticle($requestData, $info);
				break;
			//对应文章功能
			case 6 :
				$requestData = $this->dealArticleCategory($requestData, $info);
				break;
			//发放红包码
			case 7 :
				$requestData = $this->dealRedpack($requestData, $info);
				break;
			default:
			    $requestData['Content'] = $info['content'];
		}
		
		log_message('info', __CLASS__.' '. __FUNCTION__.' success '. serialize(array($requestData, $info)));
		return $requestData;
	}
	
	/**
	 * 同步用户信息
	 * 获取用户基本信息, 获得条件：必须通过微信认证
	 * @param array $requestData
	 * @return bool
	 */
	private function synchronizeUser($requestData)
	{
		//未认证时
		if (empty($this->siteConfig['verify']))
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' isnot verify  ' . serialize(array($requestData, getSite())));
			
			$this->load->model(array('user_model'));
			
			//查询用户本地信息是否存在
			$params = array();
			$params['site_id'] = $this->siteConfig['site_id'];
			$params['openid'] = $requestData['FromUserName'];
			$userInfo = $this->user_model->getInfoByAttribute($params);
			if (!$userInfo)
			{
				$weixinUserInfo['site_id'] = getSite();
				$weixinUserInfo['openid'] = (string)$requestData['FromUserName'];
				$weixinUserInfo['create_time'] = time();
				$user_id = $this->user_model->insertInfo($weixinUserInfo);
				
				log_message('error', __CLASS__.' '.__FUNCTION__.' user notexist, insert  ' . serialize(array($requestData, getSite())));
			}
		}
		
		//认证后
		else 
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' is verify  ' . serialize(array($requestData, getSite())));
			
			//获取用户微信信息
			$weixinUserInfo = $this->weixin->getUserInfo($requestData['FromUserName']);
			if ($weixinUserInfo['errno'])
			{
				log_message('error', __CLASS__.' '.__FUNCTION__.' weixin getUserInfo error ' . serialize(array($requestData, $weixinUserInfo)));
				return false;
			}
			$weixinUserInfo = $weixinUserInfo['data'];
			
			$this->load->model(array('user_model'));
			
			//查询用户本地信息是否存在
			$params = array();
			$params['site_id'] = $this->siteConfig['site_id'];
			$params['openid'] = $requestData['FromUserName'];
			$userInfo = $this->user_model->getInfoByAttribute($params);
			if (!$userInfo)
			{
				$weixinUserInfo['site_id'] = getSite();
				$weixinUserInfo['openid'] = (string)$requestData['FromUserName'];
				$user_id = $this->user_model->insertInfo($weixinUserInfo);
				
				log_message('error', __CLASS__.' '.__FUNCTION__.' user notexist, insert  ' . serialize(array($requestData, getSite())));
			}
			//用户存在
			else
			{
				//判断是否同步用户信息
				$is_sync = false;
			
				//用户资料时间太长, 同步用户资料
				if (empty($userInfo['last_update_time']) || time() - $userInfo['last_update_time'] > 86400 * 7)
				{
					$is_sync = true;
					log_message('error', __CLASS__.' '.__FUNCTION__.' redirect userinfo oauthUrl timeout '. serialize(array($userInfo)));
				}
			
				//用户存在, 且昵称相同, 不需要同步
				if ((empty($userInfo['nickname']) || empty($weixinUserInfo['nickname'])) || $userInfo['nickname'] != $weixinUserInfo['nickname'])
				{
					$is_sync = true;
					log_message('error', __CLASS__.' '.__FUNCTION__.' user nickname not same ' . serialize(array($requestData, $weixinUserInfo)));
				}
			
				if (empty($userInfo['headimgurl']) || empty($weixinUserInfo['headimgurl']) || $userInfo['headimgurl'] != $weixinUserInfo['headimgurl'])
				{
					$is_update = true;
				}
			
				//用户存在, 昵称不相同, 同步信息
				if ($is_sync)
				{
					$weixinUserInfo['site_id'] = getSite();
					$this->user_model->updateInfo($userInfo['user_id'], $weixinUserInfo);
				}
			}
		}
	
		return true;
	}
	
	private function dealRelation($requestData, $info, $cachekey)
	{
		$this->load->model(array('keyword_relation_model'));
		log_message('error', __CLASS__.' '. __FUNCTION__.' start '. serialize(array($requestData, $info, $cachekey)));
		
		//查询关系列表
		$wheres = array();
		$wheres['keyword_id'] = $info['keyword_id'];
		$orders = array();
		$orders['sort'] = 'desc';
		$relationList = $this->keyword_relation_model->getList($wheres, $orders, 0, 999);
		if (!$relationList)
		{
			$requestData['Content'] = str_replace('{}', "\r\n列表未定义\t\n", $info['content']);
			log_message('error', __CLASS__.' '. __FUNCTION__.' weixin_model getWordRelationList empty '. serialize($info));
		}
		else
		{
			$relationWordKeys = array();
			$replaceStr = "\t\n";
			foreach ($relationList as $key_ => $item_)
			{
				$relationWordKeys[$key_+1] = $item_['child_info']['alias'][0]['name'];
				$replaceStr .= '['.($key_+1).'] ' . $item_['child_info']['alias'][0]['name']."\t\n";
			}
			cache_set($cachekey, serialize($relationWordKeys), 7200);
		
			//交互式记录回话
			if (strpos($info['content'], '{}') !== false)
			{
				log_message('error', __CLASS__.' '. __FUNCTION__.' category strpos {list} true '. serialize(array($info, $replaceStr)));
				$requestData['Content'] = str_replace('{}', $replaceStr, $info['content']);
			}
			else
			{
				log_message('info', __CLASS__.' '. __FUNCTION__.' category strpos {list} false '. serialize(array($info, $replaceStr)));
				$requestData['Content'] = $info['content'] . $replaceStr;
			}
		}
		
		log_message('error', __CLASS__.' '. __FUNCTION__.' end '. serialize(array($requestData, $info, $cachekey)));
		return $requestData;
	}
	
	
	/**
	 * 
	 * 资讯
	 * 
	 * 点击资讯菜单/输入"资讯"文字
	 * 
	 * @param array $requestData
	 * @return array
	 */
	private function dealArticle($requestData, $info)
	{
		$this->load->model(array('Article_model'));
		
		$articleInfo = $this->Article_model->getInfo($info['object_id']);
		if (!$articleInfo)
		{
			log_message('error', __CLASS__.' '. __FUNCTION__.' article_model fetchArticle error '. serialize(array($info, $requestData)));
			$requestData['Content'] = lang('article_notexist');
			return $requestData;
		}
		
		$requestData['MsgType'] = 'news';
		$requestData['ArticleCount'] = 1;
		$requestData['Articles'] = array();
			
		$title = $articleInfo['title'];
		if (strpos($title, '\n') !== false)
		{
			$title = str_replace('\n', '', $title);
		}
		if (preg_match('/&#\d+;/', $title))
		{
			$title = preg_replace('/&#\d+;/', '', $title);
		}
		$title = strip_tags($title);
		
		if (mb_strlen($title, 'utf-8') > 25)
		{
			$title = mb_substr($title, 0, 25, 'utf-8') .'..';
		}
		
		$desc = trim($articleInfo['desc']);
		if (strpos($desc, '\n') !== false)
		{
			$desc = str_replace('\n', '', $desc);
		}
		if (preg_match('/&#\d+;/', $desc))
		{
			$desc = preg_replace('/&#\d+;/', '', $desc);
		}
		$desc = strip_tags($desc);
		
		$itemArr = array();
		$itemArr['Title'] = $title;
		$articleInfo['desc'] && ($itemArr['Description'] = $desc);
		$articleInfo['icon'] && $itemArr['PicUrl'] = $articleInfo['icon'];
		//$itemArr['Url'] = base_url('/oauth/userbase/'.base64_encode_($item['url']));//仅跳转
		
		//只有已认证服务号才能获取用户信息
		if (!empty($this->siteConfig['type']) && !empty($this->siteConfig['verify']))
		{
			$itemArr['Url'] = $this->weixin->oauthUrl(base_url('/oauth/userbase/'.getSite().'/'.base64_encode_($articleInfo['url'])));//获取用户openid
		}
		else
		{
			$itemArr['Url'] = $articleInfo['url'];
		}
		//log_message('error', __CLASS__.' '. __FUNCTION__.' Articles item '. serialize(array($itemArr)));
		$requestData['Articles'][] = $itemArr;
		
		return $requestData;
	}
	
	/**
	 *
	 * 根据分类获得资讯列表
	 *
	 * 点击资讯菜单/输入"资讯"文字
	 *
	 * @param array $requestData
	 * @return array
	 */
	private function dealArticleCategory($requestData, $info)
	{
		$object_config = $info['object_config'] ? unserialize($info['object_config']) : '';
	
		//处理分页
		$offset = 0;
		$limit = !empty($object_config['count']) ? $object_config['count'] : 5;
		
		//记忆翻页
		$cachekey = 'client:articlecategory:'.$this->siteConfig['site_id'].':'.$info['keyword_id'].':'.$requestData['FromUserName'];
		$result = cache_get($cachekey);
		if ($result)
		{
			cache_inc($cachekey, 1, 7200);
			log_message('INFO', __CLASS__.' '. __FUNCTION__.' dealArticle inc '. serialize(array($cachekey, $result, $requestData)));
				
			$offset = (int)$result;
		}
		else
		{
			cache_set($cachekey, 1, 7200);
			log_message('INFO', __CLASS__.' '. __FUNCTION__.' dealArticle set '. serialize(array($cachekey, 1, $requestData)));
		}
		
		$this->load->model(array('Article_model'));
		
		//查询文章
		$params = array();
		$params['site_id'] = getSite();
		!empty($info['object_id']) && $params['category_id'] = $info['object_id'];
		$articleList = $this->Article_model->getList($params, null, $offset, $limit);
		if (!$articleList)
		{
			log_message('error', __CLASS__.' '. __FUNCTION__.' article_model getList empty '. serialize(array($params, $requestData)));
			//不是第一页时, 让下一次回到第一页
			if (!$offset)
			{
				cache_set($cachekey, 0, 7200);
				$requestData['Content'] = lang('article_noremain_cycle');
			}
			else
			{
				$requestData['Content'] = lang('article_noremain_over');
			}
		}
		else
		{
			$requestData['MsgType'] = 'news';
			$requestData['ArticleCount'] = count($articleList);
			$requestData['Articles'] = array();
			foreach ($articleList as $item)
			{
				$title = $item['title'];
				if (strpos($title, '\n') !== false)
				{
					$title = str_replace('\n', '', $title);
				}
				if (preg_match('/&#\d+;/', $title))
				{
					$title = preg_replace('/&#\d+;/', '', $title);
				}
				$title = strip_tags($title);
	
				if (mb_strlen($title, 'utf-8') > 25)
				{
					$title = mb_substr($title, 0, 25, 'utf-8') .'..';
				}
	
				$desc = trim($item['desc']);
				if (strpos($desc, '\n') !== false)
				{
					$desc = str_replace('\n', '', $desc);
				}
				if (preg_match('/&#\d+;/', $desc))
				{
					$desc = preg_replace('/&#\d+;/', '', $desc);
				}
				$desc = strip_tags($desc);
	
				//单条图文
				if (count($articleList) > 1)
				{
					if (mb_strlen($desc, 'utf-8') > 25)
					{
						$desc = mb_substr($desc, 0, 25, 'utf-8') .'..';
					}
				}
	
	
				$itemArr = array();
				$itemArr['Title'] = $title;
				$item['desc'] && ($itemArr['Description'] = $desc);
				$item['icon'] && $itemArr['PicUrl'] = $item['icon'];
				//$itemArr['Url'] = base_url('/oauth/userbase/'.base64_encode_($item['url']));//仅跳转
	
				//只有已认证服务号才能获取用户信息
				if (!empty($this->siteConfig['type']) && !empty($this->siteConfig['verify']))
				{
					$itemArr['Url'] = $this->weixin->oauthUrl(base_url('/oauth/oauth/userbase/'.getSite().'/'.base64_encode_($item['url'])));//获取用户openid
				}
				else
				{
					$itemArr['Url'] = $item['url'];
				}
				
				log_message('error', __CLASS__.' '. __FUNCTION__.' Articles item '. serialize(array($itemArr)));
				$requestData['Articles'][] = $itemArr;
			}
		}
		
		return $requestData;
	}
	
	//活动码
	//匹配//恭喜您, 您领取的激活码是{},感谢您的参与.
	private function dealCode($requestData, $info)
	{
		$code_id = $info['object_id'];
		$openid = $requestData['FromUserName'];
		$this->log_data = array();
		
		$this->load->model(array('code_model'));
		
		$result = $this->code_model->fetchCode(getSite(), $code_id, $openid);
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode succ ' . serialize(array($requestData, $info, $result, $this->log_data)));
			$requestData['Content'] = $result['message'];
			return $requestData;
		}
		$code = $result['data']['content'];
		
		//提示内容
		if (strpos($info['content'], '{}'))
		{
			$requestData['Content'] = str_replace('{}', $code, $info['content']);
		}
		else
		{
			$requestData['Content'] = $info['content'] .' '. $code;
		}
		
		log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode succ ' . serialize(array($requestData, $info, $result, $this->log_data)));
		return $requestData;
	}
	
	//处理签到功能
	private function dealSignin($requestData, $info)
	{
		$signin_id = $info['object_id'];
		$openid = $requestData['FromUserName'];
		$this->log_data = array();
		
		if (!$signin_id)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' signin_nosetting ' . serialize(array($requestData, $this->log_data)));
			$requestData['Content'] = lang('signin_nosetting');
			return $requestData;
		}
		
		$this->load->model(array('signin_model'));
		$result = $this->signin_model->doSign(getSite(), $signin_id, $openid);
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode succ ' . serialize(array($requestData, $info, $result, $this->log_data)));
			$requestData['Content'] = $result['message'];
			return $requestData;
		}
		$code_id = $result['data']['code_id'];
		$signin_record_id = $result['data']['signin_record_id'];
		$word = $result['data']['word'];
		
		//获取到奖励
		if ($code_id)
		{
			$this->load->model(array('code_model', 'signin_record_model'));
			$result = $this->code_model->fetchCode(getSite(), $code_id, $openid, true);
			if ($result['errno'])
			{
				//反馈结果
				if ($signin_record_id)
				{
					$params = array();
					$params['code_send_result'] = 2;
					$params['code_send_reason'] = $requestData['Content'];
					$this->signin_record_model->updateInfo($signin_record_id, $params);
				}
				
				log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode succ ' . serialize(array($requestData, $info, $result, $this->log_data)));
				$requestData['Content'] = $result['message'];
				return $requestData;
			}
			$code = $result['data']['content'];
			$code_item_id = $result['data']['code_item_id'];
			
			//提示内容
			if ($word)
			{
				if (strpos($word, '{code}') !== false)
				{
					$requestData['Content'] = str_replace('{code}', $code, $word);
				}
				else
				{
					$requestData['Content'] = $word.' '.$code;
				}
			}
			elseif (strpos($info['content'], '{}') !== false)
			{
				$requestData['Content'] = str_replace('{}', $code, $info['content']);
			}
			else
			{
				$requestData['Content'] = $info['content'] .' '. $code;
			}
			
			//反馈结果
			if ($signin_record_id)
			{
				$params = array();
				$params['code_item_id'] = $code_item_id;
				$params['code_send_result'] = 1;
				$params['code_send_reason'] = $requestData['Content'];
				$this->signin_record_model->updateInfo($signin_record_id, $params);
			}
			
			log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode, succ ' . serialize(array($requestData, $info, $this->log_data)));
			return $requestData;
		}
		//没有获取奖励
		else
		{
			if ($word)
			{
				$requestData['Content'] = $word;
			}
			else
			{
				$requestData['Content'] = $info['content'];
			}
				
			log_message('error', __CLASS__.' '.__FUNCTION__.' no code, succ ' . serialize(array($requestData, $info, $this->log_data)));
			return $requestData;
		}
	}
	
	//处理抽奖功能
	private function dealLottery($requestData, $info)
	{
	    $lottery_id = $info['object_id'];
	    $openid = $requestData['FromUserName'];
		$this->log_data = array();
	
		if (empty($info['object_id']))
		{
			$requestData['Content'] = lang('lottery_nosetting');
			log_message('error', __CLASS__.' '.__FUNCTION__.' signin_nosetting ' . serialize(array($requestData, $this->log_data)));
			return $requestData;
		}
	
		//查询是否有签到信息
		$params = array();
		$params['site_id'] = $this->siteConfig['site_id'];
		$params['lottery_id'] = $info['object_id'];
		$params['openid'] = $openid;
		$result = $this->weixin_model->doLottery($params);
		if ($result['errno'])
		{
			$requestData['Content'] = lang($result['errno']);
			log_message('error', __CLASS__.' '.__FUNCTION__.' getSignin error ' . serialize(array($requestData, $params, $result)));
			return $requestData;
		}
		$doLotteryInfo = $result['data'];
	
		//获取到奖励
		if ($doLotteryInfo['code_id'])
		{
			$params = array();
			$params['site_id'] = $this->siteConfig['site_id'];
			$params['code_id'] = $doLotteryInfo['code_id'];
			$params['openid'] = $openid;
			$params['is_repeat'] = true;
			$result = $this->weixin_model->fetchCode($params);
			log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode 111 ' . serialize(array($requestData, $result)));
			if ($result['errno'])
			{
				log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode error ' . serialize(array($requestData, $params, $result)));
				if($result['errno'] == 'code_item_noremain')
				{
					$codeInfo = $result['data'];
					$requestData['Content'] = lang('lottery_'.$result['errno']);
				}
				elseif($result['errno'] == 'code_item_done' && $result['data'])
				{
					$codeInfo = $result['data'];
					$requestData['Content'] = sprintf(lang('lottery_'.$result['errno']), $codeInfo['item']['content']);
				}
				else
				{
					$requestData['Content'] = lang($result['errno']);
				}
	
				//反馈结果
				if ($doLotteryInfo['lottery_record_id'])
				{
					$params = array();
					$params['lottery_record_id'] = $doLotteryInfo['lottery_record_id'];
					$params['code_send_result'] = 0;
					$params['code_send_reason'] = $requestData['Content'];
					$this->weixin_model->editLotteryRecord($params);
				}
	
				log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode error 1 ' . serialize(array($requestData, $result)));
				return $requestData;
			}
			else
			{
				log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode succ ' . serialize(array($requestData, $result)));
	
				$codeInfo = $result['data'];
				if (strpos($info['content'], '{lottery}'))
				{
					$requestData['Content'] = str_replace('{lottery}', $codeInfo['item']['content'], $info['content']);
				}
				else
				{
					$requestData['Content'] = $info['content'] .' '. $codeInfo['item']['content'];
				}
	
				//反馈结果
				if ($doLotteryInfo['lottery_record_id'])
				{
					$params = array();
					$params['lottery_record_id'] = $doLotteryInfo['lottery_record_id'];
					$params['code_send_result'] = 1;
					$params['code_send_reason'] = $requestData['Content'];
					$this->weixin_model->editLotteryRecord($params);
				}
	
				log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode succ 1 ' . serialize(array($requestData, $result)));
				return $requestData;
			}
		}
		//没有获取奖励
		else
		{
			$requestData['Content'] = lang('lottery_notwin');
	
			log_message('error', __CLASS__.' '.__FUNCTION__.' no code ' . serialize(array($requestData, $result)));
			return $requestData;
		}
	}
	
	//转接多客服
	private function dealCustomerService($requestData, $info)
	{
		log_message('error', __CLASS__.' '. __FUNCTION__.' dealCustomerService '. serialize(array($requestData)));
	
		$requestData['MsgType'] = 'transfer_customer_service';
	
		return $requestData;
	}
	
	//发放红包码
	private function dealRedpack($requestData, $info)
	{
		$redpack_id = $info['object_id'];
		$openid = $requestData['FromUserName'];
		$this->log_data = array();
		
		$this->load->model(array('redpack_model'));
		
		$result = $this->redpack_model->fetchCode(getSite(), $redpack_id, $openid);
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode succ ' . serialize(array($requestData, $info, $result, $this->log_data)));
			$requestData['Content'] = $result['message'];
			return $requestData;
		}
		$code = $result['data']['content'];
		
		//提示内容
		if (strpos($info['content'], '{}'))
		{
			$requestData['Content'] = str_replace('{}', $code, $info['content']);
		}
		else
		{
			$requestData['Content'] = $info['content'] .' '. $code;
		}
		
		log_message('error', __CLASS__.' '.__FUNCTION__.' fetchCode succ ' . serialize(array($requestData, $info, $result, $this->log_data)));
		return $requestData;
	}
	
	//领取/兑换红包码
	private function getRedpack($requestData)
	{
		$openid = $requestData['FromUserName'];
		$this->log_data = array();
		
		//频率限制
		$errtime = 0;
		$cacheRedpackErrkey = 'weixin:redpack:'.$this->siteConfig['site_id'].':'.$openid;
		$errtime = cache_get($cacheRedpackErrkey);
		if ($errtime)
		{
			log_message('INFO', __CLASS__.' '. __FUNCTION__.' $cacheRedpackErrkey '. serialize(array($cacheRedpackErrkey, $errtime, $requestData)));
		}
		$this->log_data[] = $errtime;
		
		//限制次数5次
		if ($errtime > 5)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' redpack_limited '.serialize(array($cacheRedpackErrkey, $errtime, $requestData)));
			return result('', 'redpack_limited', lang('redpack_limited'));
		}
		
		//勿在0点到8点间发红包
		$nowHour = date('H');
		if ($nowHour < 8)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' redpack_rest error '.json_encode(array($nowHour, $this->log_data)));
			return result('', 'redpack_rest', lang('redpack_rest'));
		}
		
		$key = trim($requestData['Content']);//BA_DchAj8uvGxYNNpv0kiqbHAU5MGgwdaCJIC2pXHc%2FdjV4MbUGao95Jf1QMFYK23GR
		$this->log_data[] = $key;
		if (!$key)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' token redpack_key_empty '.serialize($this->log_data));
			return result('', 'redpack_key_empty', lang('redpack_key_empty'));
		}
		
		
		
		$start_time = microtime(true);
		$this->load->model(array('redpack_model'));
		
		//兑换红包
		$result = $this->redpack_model->exchange_code(getSite(), $openid, $key);
		if ($result['errno'])
		{
			cache_inc($cacheRedpackErrkey, 1, 43200);
			
			log_message('error', __CLASS__.' '.__FUNCTION__.' exchangeRedpack error '.serialize(array($result, $this->log_data)));
			return result('', $result['errno'], lang($result['error']));
		}
		elseif (!$result['data'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' exchangeRedpack empty, redpack_get_none '.serialize($this->log_data));
			return result('', 'redpack_get_none', lang('redpack_get_none'));
		}
		$redpackInfo = $result['data']['redpackInfo'];
		$codeInfo = $result['data']['codeInfo'];
		$mch_billno = $result['data']['mch_billno'];
		$record_id = $result['data']['record_id'];
		
		$end_time = microtime(true);
		log_message('error', __CLASS__.' '.__FUNCTION__.' exchangeRedpack_time '.serialize(array($end_time - $start_time, $codeInfo, $this->log_data)));
		
		//支付
		$data = array();
		$data['mch_billno'] = $mch_billno; //商户订单号（每个订单号必须唯一）组成： mch_id+yyyymmdd+10位一天内不能重复的数字。接口根据商户订单号支持重入， 如出现超时可再调用。
		$data['mch_id'] = $this->siteConfig['pay_mch_id']; //微信支付分配的商户号
		$data['wxappid'] = $this->siteConfig['appid']; //商户appid
		$data['nick_name'] = $redpackInfo['send_name']; //提供方名称
		$data['send_name'] = $redpackInfo['send_name']; //红包发送者名称
		$data['re_openid'] = $openid;//接受收红包的用户,用户在wxappid下的openid
		$data['total_amount'] = (float)$codeInfo['money']; //付款金额，单位分
		$data['min_value'] = (float)$codeInfo['money']; //最小红包金额，单位分
		$data['max_value'] = (float)$codeInfo['money']; //最大红包金额，单位分（ 最小金额等于最大金额： min_value=max_value =total_amount）
		$data['total_num'] = count(array($openid)); //红包发放总人数
		$data['wishing'] = $redpackInfo['wishing']; //红包祝福语
		$data['client_ip'] = get_setting('site_ip'); //调用接口的机器Ip地址
		$data['act_name'] = $redpackInfo['name']; //活动名称
		$data['act_id'] = $redpackInfo['redpack_id'];
		$data['remark'] = $redpackInfo['remark']; //备注信息
		$data['logo_imgurl'] = $redpackInfo['logo_imgurl']; //商户logo的url
		//$data['share_content'] = $redpackInfo['send_name'] . $redpackInfo['wishing']; //分享文案
		//$data['share_url'] = $redpackInfo['logo_imgurl']; //分享链接
		//$data['share_imgurl'] = $redpackInfo['logo_imgurl']; //分享的图片url
		
		log_message('error', __CLASS__.' '.__FUNCTION__.' sendredpack params '.serialize(array($data, $this->siteConfig['pay_api_key'], $this->log_data)));
		$result = $this->weixin->sendredpack($data, $this->siteConfig['pay_api_key']);
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' sendredpack error '.serialize(array($result, $this->log_data)));
			//提示
			$message = lang('redpack_'.$result['errno']);
			if (!$message)
			{
				$message = lang('redpack_send_error');
			}
			
			//错误数+1
			cache_inc($cacheRedpackErrkey, 1, 7200);
			
			//重置用户数据
			log_message('error', __CLASS__.' '.__FUNCTION__.' rollbackRedpack start '.serialize(array($redpackInfo['redpack_id'], $codeInfo['redpack_code_id'], $record_id, $result['errno'], $result['error'], $this->log_data)));
			$result = $this->redpack_model->rollback_code($redpackInfo['redpack_id'], $codeInfo['redpack_code_id'], $record_id, $result['errno'], $result['error']);
			log_message('error', __CLASS__.' '.__FUNCTION__.' rollbackRedpack end '.serialize(array($result, $redpackInfo['redpack_id'], $codeInfo['redpack_code_id'], $record_id, $result['errno'], $result['error'], $this->log_data)));
			
			log_message('error', __CLASS__.' '.__FUNCTION__.' $weixin redpack_send_error '.json_encode_cn(array($result, $this->log_data)));
			return result('', 'redpack_send_error', $message);
		}
		$billInfo = $result['data'];
		
		$stop_time = microtime(true);
		
		//成功提示语
		log_message('error', __CLASS__.' '.__FUNCTION__.' sendredpack succ '.serialize(array($stop_time - $end_time, $end_time - $start_time, $billInfo, $this->log_data)));
		return result(true, '', lang('redpack_get_succ'));
	}
	
	private function getRedpackGroup($requestData)
	{
		$openid = $requestData['FromUserName'];
		$this->log_data = array();
	
		//频率限制
		$errtime = 0;
		$cacheRedpackErrkey = 'weixin:redpack:'.$this->siteConfig['site_id'].':'.$openid;
		$result = $this->cache_model->get($cacheRedpackErrkey);
		if ($result['data'])
		{
			$errtime = (int)$result['data'];
			log_message('INFO', __CLASS__.' '. __FUNCTION__.' $cacheRedpackErrkey '. serialize(array($cacheRedpackErrkey, $errtime, $requestData)));
		}
		$this->log_data[] = $errtime;
	
		//限制次数5次
		if ($errtime > 5)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' redpack_limited '.serialize(array($cacheRedpackErrkey, $errtime, $requestData)));
			return result('', 'redpack_limited', lang('redpack_limited'));
		}
	
		//勿在0点到8点间发红包
		$nowHour = date('H');
		if ($nowHour < 8)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' redpack_rest error '.json_encode(array($nowHour, $this->log_data)));
			return result('', 'redpack_rest', lang('redpack_rest'));
		}
	
		$key = trim($requestData['Content']);//BA_DchAj8uvGxYNNpv0kiqbHAU5MGgwdaCJIC2pXHc%2FdjV4MbUGao95Jf1QMFYK23GR
		$this->log_data[] = $key;
		if (!$key)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' token redpack_key_empty '.serialize($this->log_data));
			return result('', 'redpack_key_empty', lang('redpack_key_empty'));
		}
	
		
	
		$start_time = microtime(true);
	
		//兑换红包
		$params = array();
		$params['site_id'] = getSite();
		$params['openid'] = $openid;
		$params['key'] = $key;
		//log_message('error', __CLASS__.' '.__FUNCTION__.' exchangeRedpack start '.serialize(array($params, $this->log_data)));
		$result = $this->weixin_model->exchangeRedpack($params);
		if ($result['errno'])
		{
			$this->cache_model->inc($cacheRedpackErrkey, 1, 43200);
				
			log_message('error', __CLASS__.' '.__FUNCTION__.' exchangeRedpack error '.serialize(array($result, $this->log_data)));
			return result('', $result['errno'], lang($result['error']));
		}
		elseif (!$result['data'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' exchangeRedpack empty, redpack_get_none '.serialize($this->log_data));
			return result('', 'redpack_get_none', lang('redpack_get_none'));
		}
		$redpackInfo = $result['data']['redpackInfo'];
		$codeInfo = $result['data']['codeInfo'];
		$mch_billno = $result['data']['mch_billno'];
		$record_id = $result['data']['record_id'];
	
		$end_time = microtime(true);
		//log_message('error', __CLASS__.' '.__FUNCTION__.' exchangeRedpack_time '.serialize(array($end_time - $start_time, $codeInfo, $this->log_data)));
	
		//支付
		$data = array();
		$data['mch_billno'] = $mch_billno; //商户订单号（每个订单号必须唯一）组成： mch_id+yyyymmdd+10位一天内不能重复的数字。接口根据商户订单号支持重入， 如出现超时可再调用。
		$data['mch_id'] = $this->siteConfig['pay_mch_id']; //微信支付分配的商户号
		$data['wxappid'] = $this->siteConfig['appid']; //商户appid
		$data['nick_name'] = $redpackInfo['send_name']; //提供方名称
		$data['send_name'] = $redpackInfo['send_name']; //红包发送者名称
		$data['re_openid'] = $openid;//接受收红包的用户,用户在wxappid下的openid
		$data['total_amount'] = (float)$codeInfo['money']; //付款金额，单位分
		$data['min_value'] = (float)$codeInfo['money']; //最小红包金额，单位分
		$data['max_value'] = (float)$codeInfo['money']; //最大红包金额，单位分（ 最小金额等于最大金额： min_value=max_value =total_amount）
		$data['total_num'] = count(array($openid)); //红包发放总人数
		$data['wishing'] = $redpackInfo['wishing']; //红包祝福语
		$data['client_ip'] = '42.62.47.220'; //调用接口的机器Ip地址
		$data['act_name'] = $redpackInfo['name']; //活动名称
		$data['act_id'] = $redpackInfo['redpack_id'];
		$data['remark'] = $redpackInfo['remark']; //备注信息
		$data['logo_imgurl'] = $redpackInfo['logo_imgurl']; //商户logo的url
		//$data['share_content'] = $redpackInfo['send_name'] . $redpackInfo['wishing']; //分享文案
		//$data['share_url'] = $redpackInfo['logo_imgurl']; //分享链接
		//$data['share_imgurl'] = $redpackInfo['logo_imgurl']; //分享的图片url
		$data['total_num'] = $redpackInfo['total_num']; //红包发放总人数，即总共有多少人可以领到该组红包（包括分享者）
		$data['amt_type'] = 'ALL_RAND'; //红包金额设置方式ALL_RAND—全部随机,商户指定总金额和红包发放总人数，由微信支付随机计算出各红包金额
	
		log_message('error', __CLASS__.' '.__FUNCTION__.' sendredpack params '.serialize(array($data, $this->siteConfig['pay_api_key'], $this->log_data)));
		$result = $this->weixin->sendgroupredpack($data, $this->siteConfig['pay_api_key']);
		if ($result['errno'])
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' sendredpack error '.serialize(array($result, $this->log_data)));
			//提示
			$message = lang('redpack_'.$result['errno']);
			if (!$message)
			{
				$message = lang('redpack_send_error');
			}
				
			//错误数+1
			$this->cache_model->inc($cacheRedpackErrkey, 1, 7200);
				
			//重置用户数据
			$params = array();
			$params['redpack_code_id'] = $codeInfo['redpack_code_id'];
			$params['redpack_id'] = $redpackInfo['redpack_id'];
			$params['record_id'] = $record_id;
			$params['errno'] = $result['errno'];
			$params['error'] = $result['error'];
			log_message('error', __CLASS__.' '.__FUNCTION__.' rollbackRedpack start '.serialize(array($params, $this->log_data)));
			$result = $this->weixin_model->rollbackRedpack($params);
			log_message('error', __CLASS__.' '.__FUNCTION__.' rollbackRedpack end '.serialize(array($result, $params, $this->log_data)));
				
			log_message('error', __CLASS__.' '.__FUNCTION__.' $weixin redpack_send_error '.json_encode_cn(array($result, $this->log_data)));
			return result('', 'redpack_send_error', $message);
		}
		$billInfo = $result['data'];
	
		$stop_time = microtime(true);
	
		//成功提示语
		log_message('error', __CLASS__.' '.__FUNCTION__.' sendredpack succ '.serialize(array($stop_time - $end_time, $end_time - $start_time, $billInfo, $this->log_data)));
		return result(true, '', lang('redpack_get_succ'));
	}
	
	
}