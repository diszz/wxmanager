<?php
/**
 *
 * 微信接口封装类
 *
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.3.25
 *
 */
class weixin
{
	/**
	 * 微信推送过来的数据或响应数据
	 * array(6) {
	 ["ToUserName"]=> string(15) "gh_824" //开发者微信号
	 ["FromUserName"]=> string(28) "oKiy8" //发送方帐号（一个OpenID）
	 ["CreateTime"]=> string(10) "1392881417" //消息创建时间 （整型）
	 ["MsgType"]=> string(4) "text" //消息类型，event
	 ["Content"]=> string(2) "rr" //文本消息内容
	 ["MsgId"]=> string(19) "5982380133421181739" //消息id，64位整型
	 }
	 * @var array
	 */
	private $data = array();
	private $token = null;
	private $appid = null;
	private $secret = null;

	/**
	 * 对数据进行签名认证，确保是微信发送的数据
	 * @param  string $token 微信开放平台设置的TOKEN
	 * @return boolean true-签名正确，false-签名错误
	 */
	public function __construct($token = '', $appid = '', $secret = '')
	{
		$this->token = $token;
		$this->appid = $appid;
		$this->secret = $secret;
	}

	public function auth()
	{
		//校验签名
		if (isset($_GET['signature']) && $_GET['signature'])
		{
			$data = array($this->token, $_GET['timestamp'], $_GET['nonce']);
			$sign = $_GET['signature'];

			/* 对数据进行字典排序 */
			sort($data, SORT_STRING);

			/* 生成签名 */
			$signature = sha1(implode($data));

			if ($signature != $sign)
			{
				return $this->rst('', 101, 'auth false');
			}
		}

		//微信接口验证
		$xml = file_get_contents("php://input");
		if(!$xml)
		{
			if(isset($_GET['echostr']))
			{
				exit($_GET['echostr']);
			}
			return $this->rst('', 102, 'auth false');
		}

		//微信正式数据
		$xml = new SimpleXMLElement($xml);
		if (!$xml)
		{
			return $this->rst('', 102, 'xml empty');
		}

		foreach ($xml as $key => $value)
		{
			$this->data[$key] = strval($value);
		}
		
		//去除空格
		if (isset($this->data['Content']))
		{
			$this->data['Content'] = trim($this->data['Content']);
		}

		return $this->rst(true);
	}

	public function getData()
	{
		return $this->rst($this->data);
	}

	/**
	 * 创建菜单
	 *
	 * @param string $data : json串, 但是不得对中文转码
	 * @return array('errcode' => '0', 'errmsg' => '')
	 */
	public function createMenu($data)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/menu/create';

		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			if ($result['errmsg'] && strpos($result['errmsg'], 'invalid button name size') !== false)
			{
				return $this->rst('', $result['errcode'], '无效菜单名长度');
			}
			elseif ($result['errmsg'] && strpos($result['errmsg'], 'api unauthorized') !== false)
			{
				return $this->rst('', $result['errcode'], 'API 未认证');
			}
		
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $result)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		return $this->rst($result);
	}
	
	/**
	 * 获取菜单
	 *
	 * @param array $data
	 * @return array('errcode' => '0', 'errmsg' => '')
	 */
	public function getMenu()
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/menu/get';

		$result = $this->request_with_accesstoken($url);
		if (isset($result['errcode']) && $result['errcode'])
		{
			if ($result['errmsg'] && strpos($result['errmsg'], 'invalid button name size') !== false)
			{
				return $this->rst('', $result['errcode'], '无效菜单名长度');
			}
			elseif ($result['errmsg'] && strpos($result['errmsg'], 'api unauthorized') !== false)
			{
				return $this->rst('', $result['errcode'], 'API 未认证');
			}
			
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $result)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}

		return $this->rst($result);
	}

	/**
	 * 删除菜单
	 *
	 * @param array $data
	 * @return array('errcode' => '0', 'errmsg' => '')
	 */
	public function deleteMenu()
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/menu/delete';

		$result = $this->request_with_accesstoken($url);
		if (isset($result['errcode']) && $result['errcode'])
		{
			if ($result['errmsg'] && strpos($result['errmsg'], 'invalid button name size') !== false)
			{
				return $this->rst('', $result['errcode'], '无效菜单名长度');
			}
			elseif ($result['errmsg'] && strpos($result['errmsg'], 'api unauthorized') !== false)
			{
				return $this->rst('', $result['errcode'], 'API 未认证');
			}
				
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $result)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		return $this->rst($result);
	}
	
	/**
	 * 客服回复文本消息
	 * @param string $OPENID
	 * @param string $text
	 * @return array
	 */
	public function sendCustomMessage($OPENID, $text)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send';
		
		$data = array();
		$data['touser'] = $OPENID;
		$data['msgtype'] = 'text';
		$data['text'] = array('content' => $text);
		
		$result = $this->request_with_accesstoken($url, $data, 'post');
		
		return $this->rst($result);
	}
	
	public function getCustomMessageList()
	{
		
	}

	/**
	 * 获取用户信息
	 * https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
	 *
	 * return
	 * {
	    "subscribe": 1,
	    "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
	    "nickname": "Band",
	    "sex": 1,
	    "language": "zh_CN",
	    "city": "广州",
	    "province": "广东",
	    "country": "中国",
	    "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
	   "subscribe_time": 1382694957
	}
	 *
	 * @param string $OPENID
	 * @return multitype:unknown number string
	 */
	public function getUserInfo($OPENID)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?openid='.$OPENID.'&lang=zh_CN';

		$result = $this->request_with_accesstoken($url);
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' getUserInfo error ' . serialize(array($result, $url, $OPENID)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		return $this->rst($result);
	}
	/**
	 * 
	 * jsapi
	 * https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi
	 * 
	 * //卡券
	 * https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=wx_card
	 * 
	 * 
	 * @param string $refresh
	 * @return multitype:unknown number string
	 */
	public function getTicket($type = 'jsapi')
	{
		$cache_key = 'weixin:ticket:'.$this->appid;
		if (function_exists('cache_get'))
		{
			$data = cache_get($cache_key);
			if ($data)
			{
				log_message('debug', __CLASS__.' '.__FUNCTION__.' cache get '.serialize(array($cache_key, $data)));
				return $this->rst($data);
			}
		}
		else
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' function_cache_get_not_exists error ');
		}
	
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=".$type;
		$result = $this->request_with_accesstoken($url);
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' error ' . serialize(array($url, $result)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		if (function_exists('cache_set'))
		{
			cache_set($cache_key, $result['ticket'], 7200);//谨慎改动
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' cacheSet '.serialize(array($cache_key, $result['ticket'])));
		}
		else
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' function_cache_set_not_exists error ');
		}
	
		log_message('ERROR', __CLASS__.' '.__FUNCTION__.' return '.serialize(array($result['ticket'])));
		return $this->rst($result['ticket']);
	}

	/**
	 * 微信网页认证第一步
	 * 网页为获取微信用户信息的操作
	 *
	 * Scope为snsapi_base 只能获取用户openid
		Scope为snsapi_userinfo 弹出授权页面，可通过openid拿到昵称、性别、所在地
	 * https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
	 */
	public function oauthUrl($REDIRECT_URI, $STATE = '123456', $SCOPE = 'snsapi_base')
	{
		$APPID = $this->appid;
		$REDIRECT_URI = urlencode($REDIRECT_URI);
		($SCOPE == 'snsapi_base') ? '' : ($SCOPE = 'snsapi_userinfo');

		return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$APPID."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=".$SCOPE."&state=".$STATE."#wechat_redirect";
	}

	/**
	 * 微信网页认证第二步
	 * return
	 * {
	   "access_token":"ACCESS_TOKEN",
	   "expires_in":7200,
	   "refresh_token":"REFRESH_TOKEN",
	   "openid":"OPENID",
	   "scope":"SCOPE"
	}
	 *
	 * @param unknown $CODE
	 * @return multitype:unknown number string
	 */
	public function oauthAccessToken($CODE)
	{
		$APPID = $this->appid;
		$SECRET = $this->secret;
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$APPID.'&secret='.$SECRET.'&code='.$CODE.'&grant_type=authorization_code';

		$result = $this->request($url);
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' oauthAccessToken error ' . json_encode(array($url, $CODE, $result)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		return $this->rst($result);
	}

	/**
	 * 获取更长久的access_token
	 * 返回
	 * {
	   "access_token":"ACCESS_TOKEN",
	   "expires_in":7200,
	   "refresh_token":"REFRESH_TOKEN",
	   "openid":"OPENID",
	   "scope":"SCOPE"
	}
	 *
	 * @param unknown $REFRESH_TOKEN
	 * @return multitype:unknown number string
	 */
	public function oauthRefreshToken($REFRESH_TOKEN)
	{
		$APPID = $this->appid;
		$url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$APPID.'&grant_type=refresh_token&refresh_token='.$REFRESH_TOKEN;

		$result = $this->request_ssl_with_accesstoken($url);
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' oauthRefreshToken error ' . json_encode(array($url, $REFRESH_TOKEN, $result)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		return $this->rst($result);
	}

	/**
	 * 获取授权人信息
	 * 如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token和openid拉取用户信息了。
	 *
	 * @param unknown $ACCESS_TOKEN
	 * @param unknown $OPENID
	 * @return multitype:unknown number string
	 */
	public function oauthGetUserInfo($ACCESS_TOKEN, $OPENID)
	{
		$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$ACCESS_TOKEN.'&openid='.$OPENID.'&lang=zh_CN';

		$result = $this->request_with_accesstoken($url);
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' oauthGetUserInfo error ' . json_encode(array($url, $ACCESS_TOKEN, $OPENID, $result)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		return $this->rst($result);
	}

	/**
	 * 上传图片, 音频, 视频
	 *
	 * ["data"]=> array(3) {
	 * ["type"]=> string(5) "image"
	 * ["media_id"]=> string(64) "5vXW4FVVyEi3ydVH0kTHTRtbnrcBKyvYFW8hn9KTqontz-dgdevX_In0DD4AYiub"
	 * ["created_at"]=> int(1395309213)
	 * }
	 * @param unknown $TYPE
	 * @param unknown $source
	 * @return {"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
	 */
	public function upload($TYPE, $source)
	{
		//https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=TYPE
		$url = 'https://api.weixin.qq.com/cgi-bin/media/upload?type='.$TYPE;

		$data = array();
		$data['media'] = '@'.$source;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' upload error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		//{"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
		return $this->rst($result);
	}
	
	/**
	 * 上传卡券图片
	 * 
	 * 1.上传的图片限制文件大小限制 1MB，像素为 300*300，支持 JPG 格式。
	 * 2.调用接口获取的 logo_url 进支持在微信相关业务下使用，否则会做相应处理。
	 * 
	 * @param unknown $source
	 * @return string
	 */
	public function uploadCardLogo($source)
	{
		//https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg';
		
		$data = array();
		$data['buffer'] = '@'.$source;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' upload error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		//{"url":"http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZJkmG8xXhiaHqkKSVMMWeN3hLut7X7hicFNjakmxibMLGWpXrEXB33367o7zHN0CwngnQY7zb7g/0"}
		return $this->rst($result['url']);
	}
	
	
	/**
	 * 批量导入门店信息
	 * 
	 * 
	 * {
"business_name":"麦当劳",
"branch_name":"赤岗店",
"province":"广东省",
"city":"广州市",
"district":"海珠区",
"address":"中国广东省广州市海珠区艺苑路 11 号",
"telephone":"020-89772059",
"category":"房产小区",
"longitude":"115.32375",
"latitude":"25.097486"
},
{
"business_name":"麦当劳",
"branch_name":"赤岗店",
"province":"广东省",
"city":"广州市",
"district":"海珠区",
"address":"中国广东省广州市海珠区艺苑路 11 号",
"telephone":"020-89772059",
"category":"房产小区",
"longitude":"115.32375",
"latitude":"25.097486"
},
	 *
	 * @param list $location_list 二维数组
	 * @return array
	 */
	public function batchaddCardLocation($location_list)
	{
		//https://api.weixin.qq.com/card/location/batchadd?access_token=TOKEN
		$url = 'https://api.weixin.qq.com/card/location/batchadd';
	
		$data = array();
		$data['location_list'] = $location_list;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		//{"errcode":0,"errmsg":"ok","location_id_list":[271262077,271262079]}
		return $this->rst($result['location_id_list']);
	}
	
	/**
	 * 拉取门店列表
	 * 
	 * 
	 * location_id 门店 ID
business_name 门店名称
branch_name 分店名
phone 联系电话
address 详细地址
longitude 经度
latitude 纬度

	 * @param int $offset 偏移量， 0 开始
	 * @param int $count 拉取数量
	 * @return list
	 */
	public function batchgetCardLocation($offset, $count)
	{
		//https://api.weixin.qq.com/card/location/batchget?access_token=TOKEN
		$url = 'https://api.weixin.qq.com/card/location/batchget';
		
		$data = array();
		$data['offset'] = $offset;
		$data['count'] = $count;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		return $this->rst($result['location_list']);
	}
	
	/**
	 * 获取颜色列表接口
	 * 
	 * name 创建卡券时可以填入的 color 名称
value 对应的颜色数值
	 * @return list
	 */
	public function getCardColors()
	{
		//https://api.weixin.qq.com/card/getcolors?access_token=TOKEN
		$url = 'https://api.weixin.qq.com/card/getcolors';
		
		$data = array();
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		return $this->rst($result['colors']);
	}
	
	/**
	 * 批量查询卡列表
	 *
	 *
	 * card_id_list 卡 id 列表
	 * total_num 该商户名下 card_id 总数
	 * 
	 * 
	 * @param int $offset 偏移量， 0 开始
	 * @param int $count 拉取数量
	 * @return list
	 */
	public function batchgetCard($offset, $count)
	{
		//https://api.weixin.qq.com/card/location/batchget?access_token=TOKEN
		$url = 'https://api.weixin.qq.com/card/batchget';
	
		$data = array();
		$data['offset'] = $offset;
		$data['count'] = $count;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id_list']);
	}
	
	
	/**
	 * 查询卡券详情
	 *
	 *
	 * card_id_list 卡 id 列表
	 * total_num 该商户名下 card_id 总数
	 *
	 *
	 * @param int $offset 偏移量， 0 开始
	 * @param int $count 拉取数量
	 * @return list
	 */
	public function getCard($card_id)
	{
		//https://api.weixin.qq.com/card/location/batchget?access_token=TOKEN
		$url = 'https://api.weixin.qq.com/card/get';
	
		$data = array();
		$data['card_id'] = $card_id;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card']);
	}
	
	/**
	 * 查询卡券详情
	 *
	 *
	 * card_id_list 卡 id 列表
	 * total_num 该商户名下 card_id 总数
	 *
	 *
	 * @param int $offset 偏移量， 0 开始
	 * @param int $count 拉取数量
	 * @return list
	 */
	public function unavaiCard($card_id)
	{
		//https://api.weixin.qq.com/card/location/batchget?access_token=TOKEN
		$url = 'https://api.weixin.qq.com/card/get';
	
		$data = array();
		$data['card_id'] = $card_id;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card']);
	}
	
	/**
	 * 创建卡券接口
	 * 创建卡券仅代表成功创建一种卡券，创建成功不代表下发成功。商户需通过二维码或JS API 的方式将卡券下发给用户。
	 * 
	 * 
	 * "card_type": "GROUPON",
"groupon": {
"base_info": {
"logo_url":
"http:\/\/www.supadmin.cn\/uploads\/allimg\/120216\/1_120216214725_1.jpg",
"brand_name":"海底捞",
"code_type":"CODE_TYPE_TEXT",
"title": "132 元双人火锅套餐",
"sub_title": "",
"color": "Color010",
"notice": "使用时向服务员出示此券",
"service_phone": "020-88888888",
"description": "不可与其他优惠同享\n 如需团购券发票， 请在消费时向商户提出\n 店内均可
使用， 仅限堂食\n 餐前不可打包， 餐后未吃完， 可打包\n 本团购券不限人数， 建议 2 人使用， 超过建议人
数须另收酱料费 5 元/位\n 本单谢绝自带酒水饮料",
"date_info": {
"type": 1,
"begin_timestamp": 1397577600 ,
"end_timestamp": 1422724261
},
"sku": {
"quantity": 50000000
},
"get_limit": 3,
"use_custom_code": false,
"bind_openid": false,
"can_share": true,
"can_give_friend": true,
"location_id_list" : [123, 12321, 345345],
"custom_url_name": "立即使用",
"custom_url": "http://www.qq.com",
"custom_url_sub_title": "6 个汉字 tips",
"promotion_url_name": "更多优惠",
"promotion_url": "http://www.qq.com",
"source": "大众点评"
},
"deal_detail": "以下锅底 2 选 1（有菌王锅、麻辣锅、大骨锅、番茄锅、清补凉锅、酸菜鱼锅可
选） ： \n 大锅 1 份 12 元\n 小锅 2 份 16 元\n 以下菜品 2 选 1\n 特级肥牛 1 份 30 元\n 洞庭鮰鱼卷 1 份
20 元\n 其他\n 鲜菇猪肉滑 1 份 18 元\n 金针菇 1 份 16 元\n 黑木耳 1 份 9 元\n 娃娃菜 1 份 8 元\n 冬
瓜 1 份 6 元\n 火锅面 2 个 6 元\n 欢乐畅饮 2 位 12 元\n 自助酱料 2 位 10 元"}

	 * 
	 * 
	 * @return string
	 */
	public function createCard($cardInfo)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card'] = $cardInfo;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		//{"errcode":0,"errmsg":"ok","card_id":"p1Pj9jr90_SQRaVqYI239Ka1erkI"}
		return $this->rst($result['card_id']);
	}
	
	//团购券： GROUPON;
	public function createCardGroupon($baseInfo, $default_detail)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'GROUPON';
		$data['card']['groupon']['base_info'] = $baseInfo;
		$data['card']['groupon']['default_detail'] = $default_detail;//团购券专用，团购详情
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//通用券： GENERAL_COUPON
	public function createCardGeneralGroupon($baseInfo, $default_detail)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'GENERAL_COUPON';
		$data['card']['general_coupon']['base_info'] = $baseInfo;
		$data['card']['general_coupon']['default_detail'] = $default_detail;//团购券专用，团购详情
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//礼品券： GIFT
	public function createCardGift($baseInfo, $gift)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'GIFT';
		$data['card']['gift']['base_info'] = $baseInfo;
		$data['card']['gift']['gift'] = $gift;//礼品券专用，表示礼品名字
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//代金券： CASH;
	public function createCardCash($baseInfo, $least_cost, $reduce_cost)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
		
		$data = array();
		$data['card']['card_type'] = 'CASH';
		$data['card']['cash']['base_info'] = $baseInfo;
		$data['card']['cash']['least_cost'] = $least_cost;//代金券专用， 表示起用金额（ 单位为分）
		$data['card']['cash']['reduce_cost'] = $reduce_cost;//代金券专用， 表示减免金额（ 单位为分）
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//折扣券： DISCOUNT;
	public function createCardDiscount($baseInfo, $discount)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'DISCOUNT';
		$data['card']['discount']['base_info'] = $baseInfo;
		$data['card']['discount']['discount'] = $discount;//折扣券专用， 表示打折额度（ 百分比）。填 30 就是七折。
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//会员卡： MEMBER_CARD
	public function createCardMemberCard($baseInfo, $supply_bonus, $supply_balance, $bonus_cleared = null, $bonus_rules = null, $balance_rules = null, $prerogative = null, $bind_old_card_url = null, $activate_url = null, $need_push_on_view = true)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'MEMBER_CARD';
		$data['card']['member_card']['base_info'] = $baseInfo;
		$data['card']['member_card']['supply_bonus'] = $supply_bonus;//是否支持积分，填写 true 或false，如填写 true，积分相关字段均为必填。填写 false，积分字段无需填写。 储值字段处理方式相同。
		$data['card']['member_card']['supply_balance'] = $supply_balance;//是否支持储值，填写 true 或false。 （该权限申请及说明详见 Q&A)
		$data['card']['member_card']['bonus_cleared'] = $bonus_cleared;//积分清零规则
		$data['card']['member_card']['bonus_rules'] = $bonus_rules;//积分规则
		$data['card']['member_card']['balance_rules'] = $balance_rules;//储值说明
		$data['card']['member_card']['prerogative'] = $prerogative;//特权说明 
		$data['card']['member_card']['bind_old_card_url'] = $bind_old_card_url;//绑定旧卡的 url，与“activate_url” 字段二选一必填
		$data['card']['member_card']['activate_url'] = $activate_url;//激活会员卡的 url，与“bind_old_card_url” 字段二选一必填。
		$data['card']['member_card']['need_push_on_view'] = $need_push_on_view;//true 为用户点击进入会员卡时是否推送事件。
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//景点门票： SCENIC_TICKET
	public function createCardScenicTicket($baseInfo, $ticket_class, $guide_url)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'SCENIC_TICKET';
		$data['card']['scenic_ticket']['base_info'] = $baseInfo;
		$data['card']['scenic_ticket']['ticket_class'] = $ticket_class;//票类型，例如平日全票，套票等。
		$data['card']['scenic_ticket']['guide_url'] = $guide_url;//导览图 url 
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//电影票： MOVIE_TICKET；
	public function createCardMovieTicket($baseInfo, $detail)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'MOVIE_TICKET';
		$data['card']['movie_ticket']['base_info'] = $baseInfo;
		$data['card']['movie_ticket']['detail'] = $detail;//电影票详情
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//飞机票： BOARDING_PASS
	public function createCardBoardingPass($baseInfo, $from, $to, $flight, $departure_time, $landing_time, $check_in_url, $gate, $boarding_time, $air_model)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'BOARDING_PASS';
		$data['card']['boarding_pass']['base_info'] = $baseInfo;
		$data['card']['boarding_pass']['from'] = $from;//起点，上限为 18 个汉字
		$data['card']['boarding_pass']['to'] = $to;//终点，上限为 18 个汉字。
		$data['card']['boarding_pass']['flight'] = $flight;//航班
		$data['card']['boarding_pass']['departure_time'] = $departure_time;//起飞时间。 Unix 时间戳格式
		$data['card']['boarding_pass']['landing_time'] = $landing_time;//降落时间。 Unix 时间戳格式
		$data['card']['boarding_pass']['check_in_url'] = $check_in_url;//在线值机的链接 
		$data['card']['boarding_pass']['gate'] = $gate;//登机口。 如发生登机口变更， 建议商家实时调用该接口变更。
		$data['card']['boarding_pass']['boarding_time'] = $boarding_time;//登机时间， 只显示“时分” 不显示日期， 按时间戳格式填写。 发生登机时间变更，建议商家实时调用该接口变更。
		$data['card']['boarding_pass']['air_model'] = $air_model;//机型，上限为 8 个汉字
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//红包 : LUCKY_MONEY
	public function createCardLuckyMoney($baseInfo)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'LUCKY_MONEY';
		$data['card']['lucky_money']['base_info'] = $baseInfo;
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	//会议门票： MEETING_TICKET
	public function createCardMeetingTicket($baseInfo, $meeting_detail, $map_url)
	{
		//https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/card/create';
	
		$data = array();
		$data['card']['card_type'] = 'SCENIC_TICKET';
		$data['card']['meeting_ticket']['base_info'] = $baseInfo;
		$data['card']['meeting_ticket']['meeting_detail'] = $meeting_detail;//会议详情 
		$data['card']['meeting_ticket']['map_url'] = $map_url;//会场导览图
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['card_id']);
	}
	
	/**
	 * 接口调用请求说明
	 * 
	 * @return multitype:unknown number string
	 */
	public function createCardQrcode($card_id, $code, $openid, $expire_seconds, $is_unique_code, $balance, $outer_id)
	{
		//https://api.weixin.qq.com/card/qrcode/create?access_token=TOKEN
		$url = 'https://api.weixin.qq.com/card/qrcode/create';
		
		$data = array();
		$data['action_name'] = 'QR_CARD';
		$data['action_info']['card']['card_id'] = $card_id;//卡券 ID 
		$data['action_info']['card']['code'] = $code;//指定卡券 code 码， 只能被领一次。 use_custom_code 字段为 true 的卡券必须填写， 非自定义 code 不必填写。
		$data['action_info']['card']['openid'] = $openid;//指定领取者的 openid， 只有该用户能领取。 bind_openid字段为 true 的卡券必须填写，非自定义 openid 不必填写。
		$data['action_info']['card']['expire_seconds'] = $expire_seconds;//指定二维码的有效时间，范围是 60 ~ 1800 秒。不填默认为永久有效。
		$data['action_info']['card']['is_unique_code'] = $is_unique_code;//指定下发二维码， 生成的二维码随机分配一个 code， 领取后不可再次扫描。填写 true 或 false。默认 false。
		$data['action_info']['card']['balance'] = $balance;//红包余额，以分为单位。 红包类型必填（ LUCKY_MONEY），其他卡券类型不填。
		$data['action_info']['card']['outer_id'] = $outer_id;//领取场景值，用于领取渠道的数据统计，默认值为 0，字段类型为整型。用户领取卡券后触发的事件推送中会带上此自定义场景值。
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		//{"errcode":0,"errmsg":"ok","ticket":"gQG28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0FuWC1DNmZuVEhvMVp4NDNMRnNRAAIEesLvUQMECAcAAA=="
		return $this->rst($result['ticket']);
	}
	
	/**
	 * 发送红包
	 *
	 * link
	 *
	 */
	public function sendredpack($data, $pay_api_key)
	{
		//https://api.weixin.qq.com/card/qrcode/create?access_token=TOKEN
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
	
		// 		$data = array();
		// 		$data['mch_billno'] = $mch_billno; //商户订单号（每个订单号必须唯一）组成： mch_id+yyyymmdd+10位一天内不能重复的数字。接口根据商户订单号支持重入， 如出现超时可再调用。
		// 		$data['mch_id'] = $mch_id; //微信支付分配的商户号
		// 		$data['wxappid'] = $wxappid; //商户appid
		// 		$data['nick_name'] = $nick_name; //提供方名称
		// 		$data['send_name'] = $send_name; //红包发送者名称
		// 		$data['re_openid'] = $re_openid;//接受收红包的用户,用户在wxappid下的openid
		// 		$data['total_amount'] = $total_amount; //付款金额，单位分
		// 		$data['min_value'] = $min_value; //最小红包金额，单位分
		// 		$data['max_value'] = $max_value; //最大红包金额，单位分（ 最小金额等于最大金额： min_value=max_value =total_amount）
		// 		$data['total_num'] = $total_num; //红包发放总人数
		// 		$data['wishing'] = $wishing; //红包祝福语
		// 		$data['client_ip'] = $client_ip; //调用接口的机器Ip地址
		// 		$data['act_name'] = $act_name; //活动名称
		// 		$data['act_id'] = $act_id;
		// 		$data['remark'] = $remark; //备注信息
		// 		$data['logo_imgurl'] = $logo_imgurl; //商户logo的url
		// 		$data['share_content'] = $share_content; //分享文案
		// 		$data['share_url'] = $share_url; //分享链接
		// 		$data['share_imgurl'] = $share_imgurl; //分享的图片url
	
		$data['nonce_str'] = time();
	
		$signStr = '';
		$data_ = $data;
		ksort($data_);
		foreach ($data_ as $k => $v)
		{
			if ($k && $v)
			{
				$signStr .= ($k.'='.$v.'&');
			}
		}
		$signStr = $signStr . 'key='.$pay_api_key;
		$data['sign'] = strtoupper(md5($signStr));
	
		//组织xml
		$xml = new SimpleXMLElement('<xml></xml>');
		$this->data2xml($xml, $data);
		$dataXml = $xml->asXML();
	
		$result = $this->request_ssl_with_accesstoken($url, $dataXml, 'post');
		//log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request ' . json_encode_cn(array($url, $data, $result)));
		if (!empty($result['return_code']) && strtoupper($result['return_code']) == 'SUCCESS')
		{
			//sendEmail('lihuixu@joyogame.com', 'sendredpack succ', serialize(array(__CLASS__, __FUNCTION__, $result)));
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request succ ' . json_encode_cn(array($url, $data)));
			return $this->rst($result);
		}
		else
		{
			//sendEmail('lihuixu@joyogame.com', 'sendredpack fail', serialize(array(__CLASS__, __FUNCTION__, $result)));
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode_cn(array($url, $data, $result)));
			return $this->rst('', $result['err_code'], $result['err_code_des']);
		}
	}
	
	
	public function sendgroupredpack($data, $pay_api_key)
	{
		//https://api.weixin.qq.com/card/qrcode/create?access_token=TOKEN
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
	
		// 		$data = array();
		// 		$data['mch_billno'] = $mch_billno; //商户订单号（每个订单号必须唯一）组成： mch_id+yyyymmdd+10位一天内不能重复的数字。接口根据商户订单号支持重入， 如出现超时可再调用。
		// 		$data['mch_id'] = $mch_id; //微信支付分配的商户号
		// 		$data['wxappid'] = $wxappid; //商户appid
		// 		$data['nick_name'] = $nick_name; //提供方名称
		// 		$data['send_name'] = $send_name; //红包发送者名称
		// 		$data['re_openid'] = $re_openid;//接受收红包的用户,用户在wxappid下的openid
		// 		$data['total_amount'] = $total_amount; //付款金额，单位分
		// 		$data['min_value'] = $min_value; //最小红包金额，单位分
		// 		$data['max_value'] = $max_value; //最大红包金额，单位分（ 最小金额等于最大金额： min_value=max_value =total_amount）
		// 		$data['total_num'] = $total_num; //红包发放总人数
		// 		$data['wishing'] = $wishing; //红包祝福语
		// 		$data['client_ip'] = $client_ip; //调用接口的机器Ip地址
		// 		$data['act_name'] = $act_name; //活动名称
		// 		$data['act_id'] = $act_id;
		// 		$data['remark'] = $remark; //备注信息
		// 		$data['logo_imgurl'] = $logo_imgurl; //商户logo的url
		// 		$data['share_content'] = $share_content; //分享文案
		// 		$data['share_url'] = $share_url; //分享链接
		// 		$data['share_imgurl'] = $share_imgurl; //分享的图片url
	
		//$data['total_num'] = $total_amount; //红包发放总人数，即总共有多少人可以领到该组红包（包括分享者）
		//$daat['amt_type'] = 'ALL_RAND';红包金额设置方式ALL_RAND—全部随机,商户指定总金额和红包发放总人数，由微信支付随机计算出各红包金额
	
		$data['nonce_str'] = time();
	
		$signStr = '';
		$data_ = $data;
		ksort($data_);
		foreach ($data_ as $k => $v)
		{
			if ($k && $v)
			{
				$signStr .= ($k.'='.$v.'&');
			}
		}
		$signStr = $signStr . 'key='.$pay_api_key;
		$data['sign'] = strtoupper(md5($signStr));
	
		//组织xml
		$xml = new SimpleXMLElement('<xml></xml>');
		$this->data2xml($xml, $data);
		$dataXml = $xml->asXML();

		$result = $this->request_ssl_with_accesstoken($url, $dataXml, 'post');
		//log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request ' . json_encode_cn(array($url, $data, $result)));
		if (!empty($result['return_code']) && strtoupper($result['return_code']) == 'SUCCESS')
		{
			//sendEmail('lihuixu@joyogame.com', 'sendredpack succ', serialize(array(__CLASS__, __FUNCTION__, $result)));
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request succ ' . json_encode_cn(array($url, $data)));
			return $this->rst($result);
		}
		else
		{
			//sendEmail('lihuixu@joyogame.com', 'sendredpack fail', serialize(array(__CLASS__, __FUNCTION__, $result)));
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode_cn(array($url, $data, $result)));
			return $this->rst('', $result['err_code'], $result['err_code_des']);
		}
	}
	
	/**
	 * 获取access token
	 *
	 * access_token是公众号的全局唯一票据，公众号调用各接口时都需使用access_token。
	 * 正常情况下access_token有效期为7200秒，重复获取将导致上次获取的access_token失效。
	 *
	 * http请求方式: GET https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
	 */
	protected function getAccessToken($refresh = false)
	{
		if (!$this->appid || !$this->secret)
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' params error ' . json_encode(array($this->appid, $this->secret)));
			return false;
		}

		$cache_key = 'weixin:access_token:'.$this->appid;
		
		if (!$refresh)
		{
			if (function_exists('cache_get'))
			{
				$data = cache_get($cache_key);
				if ($data)
				{
					log_message('debug', __CLASS__.' '.__FUNCTION__.' cache get '.serialize(array($cache_key, $data)));
					return $data;
				}
			}
			else
			{
				log_message('ERROR', __CLASS__.' '.__FUNCTION__.' function_cache_get_not_exists error ');
			}
		}
		

		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential';

		$data = array();
		$data['appid'] = $this->appid;
		$data['secret'] = $this->secret;
		$result = $this->request($url, $data, 'get');
		if (!$result || (isset($result['errcode']) && $result['errcode']))
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' getAccessToken error ' . json_encode(array($refresh, $url, $data, $result)));
			return false;
		}
		
		
		if (function_exists('cache_set'))
		{
			cache_set($cache_key, $result['access_token'], 7200);//谨慎改动
		}
		else
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' function_cache_set_not_exists error ');
		}

		return $result['access_token'];
	}
	
	protected function request_with_accesstoken($url, $data = null, $method = 'get')
	{
		$accessToken = $this->getAccessToken();
		if ($accessToken === false)
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' getAccessToken error ');
			return $this->rst('', '1', 'getAccessToken error');
		}
		
		$url_ = $url . (strpos($url, '?') ? '&' : '?') . 'access_token='.$accessToken;
		
		$result = $this->request($url_, $data, $method);
		
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url_, $result)));
				
			//若是认证错误, 则更新AccessToken, 再次执行
			if ($result['errmsg'] == 'invalid credential' || strpos($result['errmsg'], 'access_token'))
			{
				log_message('ERROR', __CLASS__.' '.__FUNCTION__.' getAccessToken error ' . serialize(array($result, $url_, $data, $method)));
				$accessToken = $this->getAccessToken(true);
				$url_ = $url . (strpos($url, '?') ? '&' : '?') . 'access_token='.$accessToken;
				
				$result = $this->request($url_, $data, $method);
				log_message('ERROR', __CLASS__.' '.__FUNCTION__.' getAccessToken : $refresh  ' . serialize(array($result, $url_, $data, $method)));
			}
		}
		
		return $result;
	}
	
	/**
	 *
	 * curl
	 *
	 * @param string $url
	 * @param array $data
	 * @param string $method
	 * @return mixed
	 */
	protected function request($url, $data = null, $method = 'get')
	{
		// 初始化一个 cURL 对象
		$ch = curl_init();
		
		// 设置你需要抓取的URL
		if (strtolower($method) == 'post')
		{
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		}
		else
		{
			if ($data)
			{
				$url .= (strpos($url,'?') ? '&' : '?') .http_build_query($data);
			}
			curl_setopt($ch, CURLOPT_URL, $url);
		}

		if (strstr($url, 'https:'))
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//信任任何证书
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//检查证书中是否设置域名,0不验证
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
// 			curl_setopt($ch, CURLOPT_SSLCERT, "./keys/client.crt"); //client.crt文件路径
// 			curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "112358"); //client证书密码
// 			curl_setopt($ch, CURLOPT_SSLKEY, "./keys/client.key");
		}

		curl_setopt($ch,CURLOPT_HEADER,0);//显示返回的Header区域内容
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//获取的信息以文件流的形式返回
		curl_setopt($ch,CURLOPT_TIMEOUT,10);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);

		// 运行cURL，请求网页
		$result = curl_exec($ch);
		log_message('ERROR', __CLASS__.' '.__FUNCTION__.' exec ' . json_encode(array($url, $data, $method, $result)));

		// 关闭URL请求
		curl_close($ch);
		
		if (!$result || !json_decode($result))
		{
			return false;
		}
		$result = json_decode($result, true);
		
		return $result;
	}
	
	protected function request_ssl_with_accesstoken($url, $data = null, $method = 'get')
	{
		$accessToken = $this->getAccessToken();
		if ($accessToken === false)
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' getAccessToken error ');
			return $this->rst('', '1', 'getAccessToken error');
		}
	
		$url_ = $url . (strpos($url, '?') ? '&' : '?') . 'access_token='.$accessToken;
	
		$result = $this->request_ssl($url_, $data, $method);
	
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url_, $result)));
	
			//若是认证错误, 则更新AccessToken, 再次执行
			if ($result['errmsg'] == 'invalid credential' || strpos($result['errmsg'], 'access_token'))
			{
				log_message('ERROR', __CLASS__.' '.__FUNCTION__.' $refresh getAccessToken ' . serialize(array($result)));
				$accessToken = $this->getAccessToken(true);
				$url_ = $url . (strpos($url, '?') ? '&' : '?') . 'access_token='.$accessToken;
	
				$result = $this->request_ssl($url_, $data, $method);
			}
		}
	
		return $result;
	}
	
	protected function request_ssl($url, $data = null, $method = 'get')
	{
		// 初始化一个 cURL 对象
		$ch = curl_init();
	
		// 设置你需要抓取的URL
		if (strtolower($method) == 'post')
		{
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		}
		else
		{
			if ($data)
			{
				$url .= (strpos($url,'?') ? '&' : '?') .http_build_query($data);
			}
			curl_setopt($ch, CURLOPT_URL, $url);
		}
	
		//超时时间
		curl_setopt($ch,CURLOPT_TIMEOUT,15);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
	
		//证书
		curl_setopt($ch,CURLOPT_SSLCERT,APPPATH.'/third_party/weixin/paycert/apiclient_cert.pem');
		curl_setopt($ch,CURLOPT_SSLKEY,APPPATH.'/third_party/weixin/paycert/apiclient_key.pem');
		curl_setopt($ch,CURLOPT_CAINFO,APPPATH.'/third_party/weixin/paycert/rootca.pem');
	
		// 运行cURL，请求网页
		$result = curl_exec($ch);
		//log_message('ERROR', __CLASS__.' '.__FUNCTION__.' curl_exec result ' . json_encode(array($url, $data, $result)));
	
		// 关闭URL请求
		curl_close($ch);
	
		if ($result && strpos($result, 'xml') && strpos($result, '/xml'))
		{
			$result = $this->xml2data($result);
			//log_message('ERROR', __CLASS__.' '.__FUNCTION__.' curl_exec xml result ' . json_encode(array($url, $data, $result)));
			return $result;
		}
	
		if ($result && json_decode($result))
		{
			$result = json_decode($result, true);
			//log_message('ERROR', __CLASS__.' '.__FUNCTION__.' curl_exec json result ' . json_encode(array($url, $data, $result)));
			return $result;
		}
	
		log_message('ERROR', __CLASS__.' '.__FUNCTION__.' curl_exec 1 result ' . json_encode(array($url, $data, $result)));
		return $result;
	}

	/**
	 * * 响应微信发送的信息（自动回复）
	 * @param  string $to      接收用户名
	 * @param  string $from    发送者用户名
	 * @param  array  $content 回复信息，文本信息为string类型
	 * @param  string $type    消息类型
	 * @param  string $flag    是否新标刚接受到的信息
	 * @return string          XML字符串
	 */
	public function response($data)
	{
		$data['FuncFlag'] = 0;
		$data['CreateTime'] = time();

		/* 转换数据为XML */
		$xml = new SimpleXMLElement('<xml></xml>');
		$this->data2xml($xml, $data);

		return $this->rst($xml->asXML());
	}

	/**
	 * 数据XML编码
	 * @param  object $xml XML对象
	 * @param  mixed  $data 数据
	 * @param  string $item 数字索引时的节点名称
	 * @return string
	 */
	protected function data2xml($xml, $data, $item = 'item')
	{
		foreach ($data as $key => $value) {
			/* 指定默认的数字key */
			is_numeric($key) && $key = $item;
			/* 添加子元素 */
			if(is_array($value) || is_object($value)){
				$child = $xml->addChild($key);
				$this->data2xml($child, $value, $item);
			} else {
				if(is_numeric($value)){
					$child = $xml->addChild($key, $value);
				} else {
					$child = $xml->addChild($key);
					$node  = dom_import_simplexml($child);
					$node->appendChild($node->ownerDocument->createCDATASection($value));
				}
			}
		}
	}

	protected function rst($data = array(), $errno = 0, $error = '')
	{
		return array('data' => $data, 'errno' => $errno, 'error' => $error);
	}
	
	//获取多客服聊天记录
	public function customservice_getmsgrecord($starttime, $endtime, $page = 1, $size = 10)
	{
		//https://api.weixin.qq.com/card/getcolors?access_token=TOKEN
		$url = 'https://api.weixin.qq.com/customservice/msgrecord/getrecord';
	
		$data = array();
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$data['pagesize'] = $size;
		$data['pageindex'] = $page;
	
		$data = json_encode($data);
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['recordlist']);
	}
	
	public function group_create($name)
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/groups/create';
	
		$data = array();
		$data['group']['name'] = $name;
	
		$data = json_encode($data);
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['group']);
	}
	
	public function group_update($id, $name)
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/groups/update';
	
		$data = array();
		$data['group']['id'] = $id;
		$data['group']['name'] = $name;
	
		$data = json_encode($data);
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst(true);
	}
	
	public function group_delete($id)
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/groups/delete';
	
		$data = array();
		$data['group']['id'] = $id;
	
		$data = json_encode($data);
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst(true);
	}
	
	public function group_get()
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/groups/get';
	
		$result = $this->request_with_accesstoken($url, '', 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $result)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst($result['groups']);
	}
	
	public function group_member_update($openid, $to_groupid)
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/groups/members/update';
	
		$data = array();
		$data['openid'] = $openid;
		$data['to_groupid'] = $to_groupid;
	
		$data = json_encode($data);
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst(true);
	}
	
	public function group_member_batchupdate($openid_list, $to_groupid)
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate';
	
		//{"openid_list":["oDF3iYx0ro3_7jD4HFRDfrjdCM58","oDF3iY9FGSSRHom3B-0w5j4jlEyY"],"to_groupid":108}
		$data = array();
		$data['openid_list'] = $openid_list;
		$data['to_groupid'] = $to_groupid;
	
		$data = json_encode($data);
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
	
		return $this->rst(true);
	}
	
	//二维码类型，QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
	public function qrcode_create($action_name = 'QR_SCENE', $expire_seconds = 2592000)
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create';
		$scene = time();
	
	
		//{"openid_list":["oDF3iYx0ro3_7jD4HFRDfrjdCM58","oDF3iY9FGSSRHom3B-0w5j4jlEyY"],"to_groupid":108}
		$data = array();
		if (strtoupper($action_name) == 'QR_LIMIT_STR_SCENE')
		{
			$data['action_name'] = 'QR_LIMIT_STR_SCENE';
			$data['action_info']['scene']['scene_str'] = (string)$scene;
		}
		elseif (strtoupper($action_name) == 'QR_LIMIT_SCENE')
		{
			$data['action_name'] = 'QR_LIMIT_SCENE';
			$data['action_info']['scene']['scene_id'] = $scene;
		}
		else
		{
			$data['expire_seconds'] = $expire_seconds;
			$data['action_name'] = 'QR_SCENE';
			$data['action_info']['scene']['scene_id'] = $scene;
		}
	
		$data = json_encode($data);
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		$result['scene'] = $scene;
		$result['showqrcode'] = $this->qrcode_url($result['ticket']);
	
		log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request succ ' . json_encode(array($result, $url, $data)));
		return $this->rst($result);
	}
	
	public function qrcode_url($ticket)
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket);
	
		return $url;
	}
	
	public function message_sendall()
	{
		//https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN
		$url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall';
		
		$data = array();
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$data['pagesize'] = $size;
		$data['pageindex'] = $page;
		
		$data = json_encode($data);
		$result = $this->request_with_accesstoken($url, $data, 'post');
		if (isset($result['errcode']) && $result['errcode'])
		{
			log_message('ERROR', __CLASS__.' '.__FUNCTION__.' request error ' . json_encode(array($url, $data)));
			return $this->rst('', $result['errcode'], $result['errmsg']);
		}
		
		return $this->rst($result['recordlist']);
	}
	
}
