<?php
class bbs 
{
	public $sourceUrl = null;
	public $sourceCharType = 'js';
	
	public function index()
	{
		
	}
	
	public function setSourceUrl($url)
	{
		return $this->sourceUrl = $url;
	}
	
	//获取当前的资源列表
	public function getCurrentList()
	{
		if (empty($this->sourceUrl))
		{
			return null;
		}
		
		$dataStr = $this->request($this->sourceUrl);
		if (!$dataStr)
		{
			return null;
		}
		$dataArr = $this->dataformat($dataStr);
		
		return $dataArr;
	}
	
	public function dataformat($dataStr)
	{
		$regex = '/';
		
		//区域开始
		$regex .= '<dl.*';
		
		//图片部分
		$regex .= '<img src="(.*)".*';
		
		//作者链接
		$regex .= '<a href="(.*)".*';
		
		//作者名称
		$regex .= '>(.*)<\/a>.*';
		
		//链接
		$regex .= '<a href="(.*)".*';
		//标题
		$regex .= 'title="(.*)".*';
		
		//描述
		$regex .= '<dd>(.*)<\/dd>.*';
		
		//区域结束
		$regex .= 'dl\>';
		
		//贪婪模式
		$regex .= '/U';
		
		$dataStr = iconv('gbk', 'utf-8', $dataStr);
		if (preg_match_all($regex, $dataStr, $matches))
		{
			$list = array();
			foreach ($matches[0] as $key => $val)
			{
				preg_match('/&tid=(\d+)&/', $matches[4][$key], $matches_);//ID
				
				$item = array();
				$item['post_id'] = $matches_[1];
				$item['icon'] = $matches[1][$key];//图片
				$item['author_url'] = $matches[2][$key];//作者链接
				$item['author'] = $matches[3][$key];//作者
				$item['url'] = $matches[4][$key];//链接
				$item['title'] = str_replace('\n', '', trim($matches[5][$key]));//标题
				$item['desc'] = str_replace('\n', '', trim($matches[6][$key]));//描述
				$list[$item['post_id']] = $item;
			}
			
			return $list;
		}
		else
		{
			return null;
		}
	}
	
	
	//请求处理类
	protected function request($url, $params = null, $method = 'post')
	{
		//log_message('error', __CLASS__.' '. __FUNCTION__.' start ------------------ ');
		//log_message('error', __CLASS__.' '. __FUNCTION__.'_params '. json_encode_cn(array($url, $params, $method)));
	
		$start_time = microtime(true);
		$result = $this->_request($url, $params, $method);
		//log_message('error', __CLASS__.' '. __FUNCTION__.'_result '. json_encode_cn(array('used_time' => (microtime(true) - $start_time), $result['httpcode'], mb_substr($result['data'], 0, 200))));
		//log_message('error', __CLASS__.' '. __FUNCTION__.' end ------------------ ');
	
		if ($result['httpcode'] != 200)
		{
			//容错措施, 防止丢包
			if ($result['httpcode'] == 0)
			{
				log_message('error', __CLASS__.' '. __FUNCTION__.'_repeat httpcode error =0, request repeat '. json_encode_cn(array($url, $params, $method, $result)));
				$result = $this->_request($url, $params, $method);
				log_message('error', __CLASS__.' '. __FUNCTION__.'_repeat $result '. json_encode_cn(array('used_time' => (microtime(true) - $start_time), $result['httpcode'], mb_substr($result['data'], 0, 200))));
			}
	
			if ($result['httpcode'] != 200)
			{
				log_message('error', __CLASS__.' '. __FUNCTION__.' httpcode error =1 '. json_encode_cn(array($url, $params, $method, $result)));
			}
		}
	
		return $result['data'];
	}
	
	protected function _request($url,$params=array(),$requestMethod='GET',$headers=array())
	{
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ci, CURLOPT_USERAGENT, '1001 Magazine v1');
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ci, CURLOPT_TIMEOUT, 10);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_ENCODING, "");
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ci, CURLOPT_HEADER, FALSE);
	
		$requestMethod = strtoupper($requestMethod);
		switch ($requestMethod) {
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if ($params) {
					$params = http_build_query($params);
					curl_setopt($ci, CURLOPT_POSTFIELDS, $params);
				}
				else {
					curl_setopt($ci, CURLOPT_POSTFIELDS, ''); // Don't know why: if not set,  413 Request Entity Too Large
				}
				break;
			case 'DELETE':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if ($params) {
					$url = "{$url}?{$params}";
				}
				break;
			case 'GET':
				if($params) {
					$sep = false === strpos($url,'?') ? '?' : '&';
					$url .= $sep . http_build_query($params);
				}
				break;
			case 'PUT':
				if($params) {
					curl_setopt($ci, CURLOPT_CUSTOMREQUEST, "PUT");
					curl_setopt($ci, CURLOPT_POSTFIELDS, $params);
				}
				break;
		}
		log_message('error', __CLASS__.' '. __FUNCTION__.' curl '. json_encode(array($url, $params)));
	
		//$headers[] = "APIWWW: " . $_SERVER['REMOTE_ADDR'];
		curl_setopt($ci, CURLOPT_URL, $url );
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );
	
		$response = curl_exec($ci);
		$httpCode = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		$return = array(
				'httpcode' => $httpCode,
				'data' => $response,
		);
		//$httpInfo = curl_getinfo($ci);
		curl_close ($ci);
		return $return;
	}
}