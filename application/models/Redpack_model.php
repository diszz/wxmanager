<?php
/**
 * 红包表数据模型
*
* @copyright www.locojoy.com
* @author lihuixu@joyogame.com/xu.lihui@qq.com
* @version v1.0 2015.3.25
*
*/
class Redpack_model extends MY_Model
{
	protected $table = 'redpack';
	protected $primaryKey = 'redpack_id';
	protected $multipleSite = false;
	protected $timestamps = false;
	
	public function getInfoRelation($info)
	{
		return $info;
	}
	
	//领取红包码
	public function fetchCode($site_id, $redpack_id, $openid)
	{
		$this->load->model(array('user_model', 'redpack_code_model', 'redpack_record_model', 'user_attribute_model'));
		$log_data = array();
		$log_data[] = $this->input->post();
		
		//查询微信信息
		$siteInfo = $this->site_model->getInfo($site_id);
		if (empty($siteInfo['pay_mch_id']) || empty($siteInfo['pay_api_key']))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_site_seterr ' . serialize(array($siteInfo, $log_data)));
			return result('', 'redpack_exchange_site_seterr', 'redpack_exchange_site_seterr');
		}
		
		/**************************************************
		 * 红包活动的校验
		 *
		 ****************************************************/
		
		//查询红包活动是否存
		$redpackInfo = $this->redpack_model->getInfo($redpack_id);
		if (!$redpackInfo)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_redpack_noexist ' . serialize(array($redpack_id, $log_data)));
			return result('', 'redpack_exchange_not_exist', 'redpack_exchange_not_exist');
		}
		//$log_data[] = $redpackInfo;
		
		//活动不存在
		if (empty($redpackInfo['status']))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_not_open ' . serialize(array($redpackInfo, $log_data)));
			return result('', 'redpack_exchange_not_open', 'redpack_exchange_not_open');
		}
		
		//活动未开始
		if (empty($redpackInfo['start_time']) || (int)$redpackInfo['start_time'] > time())
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_not_start ' . serialize(array($redpackInfo, $log_data)));
			return result('', 'redpack_exchange_not_start', 'redpack_exchange_not_start');
		}
		
		//活动已结束
		if (empty($redpackInfo['end_time']) || (int)$redpackInfo['end_time'] < time())
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_is_end ' . serialize(array($redpackInfo, $log_data)));
			return result('', 'redpack_exchange_is_end', 'redpack_exchange_is_end');
		}
		
		//查询用户是否获得过
		$params = array();
		$params['site_id'] = $site_id;
		$params['openid'] = $openid;
		//有红包组的情况
		if ($redpackInfo['key'])
		{
			$params['key'] = $redpackInfo['key'];
		}
		//没有红包组的情况
		else
		{
			$params['redpack_id'] = $redpackInfo['redpack_id'];
		}
		$params['status'] = 0;
		$recordInfo = $this->Redpack_record_model->getInfoByAttribute($params);
		if ($recordInfo)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_user_repeat cache_sismember ' . serialize(array($params, $log_data)));
			return result('', 'redpack_exchange_user_repeat', 'redpack_exchange_user_repeat');
		}
		
		//校验用户是否存在
		$wheres = array();
		$wheres['site_id'] = $site_id;
		$wheres['openid'] = $openid;
		$userInfo = $this->user_model->getInfoByAttribute($wheres);
		if (!$userInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' user_notexist '.serialize(array($wheres)));
			return result('', 'user_notexist', lang('user_notexist'));
		}
	
		/*************************************
		 * 校验成功, 执行兑换
		 *
		 ************************************/
		
	
		//比较剩余量
		$code_last = (int)$redpackInfo['make_code'] - (int)$redpackInfo['send_people'];
		log_message('error', __CLASS__.' '.__FUNCTION__.' code_item_last '.serialize(array($code_last, $redpackInfo)));
		if ($code_last <= 0)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' code_item_noremain : total_count >= send_count '.serialize(array($redpackInfo)));
			return result('', 'code_item_noremain', lang('code_item_noremain'));
		}
	
		//随机抽取未分配的列表
		$params = array();
		$params['site_id'] = $site_id;
		$params['status'] = 0;
		$params['redpack_id'] = $redpack_id;
	
		$limit = 5;
		$offset = 0;
		if ($code_last > $limit)
		{
			$offset = mt_rand(0, $code_last - $limit);
		}
		$redpackCodeList = $this->redpack_code_model->getList($params, null, $offset, $limit, 0, false);
		if (!$redpackCodeList)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_code_model getList empty ' . json_encode(array($params, $offset, $limit)));
			return result('', 'code_item_noremain', lang('code_item_noremain'));
		}
	
		//分配, 防止并发, 有至多5次机会
		$runStat = false;
		$redpackCodeInfo = null;
		foreach ($redpackCodeList as $k => $item)
		{
			log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' foreach $redpackCodeList ' . serialize(array($k, $item)));
			//更改code item的状态
			$set = array();
			$set['status'] = 1;
			$result = $this->redpack_code_model->updateInfo($item['redpack_code_id'], $set);
			if ($result)
			{
				$runStat = true;
				$redpackCodeInfo = $item;
				log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' getItem succ ' . serialize(array($item)));
				break;
			}
			else
			{
				//没有抢到, 尝试下一个
				log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' foreach $redpackCodeList fail,next ' . serialize(array($k, $item)));
			}
		}
		if (!$runStat)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run code_item_noremain ');
			return result('', 'code_item_noremain', lang('code_item_noremain'));
		}
	
		//礼包已送出量+1
		$params = array();
		$params['send_people'] = 1;
		$params['send_money'] = $redpackCodeInfo['content'];
		$this->redpack_model->increment($redpack_id, $params);
	
		//记录用户的礼包
		$params = array();
		$params['redpack_count'] = 1;
		$this->user_attribute_model->increment($userInfo['user_id'], $params);
	
		//记录用户的礼包
		$params = array();
		$params['site_id'] = $site_id;
		$params['openid'] = $openid;
		$params['key'] = $redpackInfo['key'];
		$params['redpack_id'] = $redpack_id;
		$params['money'] = $redpackCodeInfo['money'];
		$params['code'] = $redpackCodeInfo['content'];
		$params['status'] = '0';
		$params['ip'] = getIp();
		$params['create_time'] = time();
		$this->redpack_record_model->insertInfo($params);
	
		//本渠道发放
		if (!$redpackInfo['send_type'])
		{
			//增加红包的发放金额, 发放人数, 参与人数
			$params = array();
			$params['send_money'] = $redpackCodeInfo['money'];
			$params['send_people'] = 1;
			$this->redpack_model->decrement($redpackInfo['redpack_id'], $params);
		}
		
		return result($redpackCodeInfo);
	}
	
	//兑换红包
	public function exchange_code($site_id, $openid, $key)
	{
		$log_data = array();
		$log_data[] = $this->input->post();
	
		//查询微信信息
		$siteInfo = $this->site_model->getInfo($site_id);
		if (empty($siteInfo['pay_mch_id']) || empty($siteInfo['pay_api_key']))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_site_seterr ' . serialize(array($siteInfo, $log_data)));
			return result('', 'redpack_exchange_site_seterr', 'redpack_exchange_site_seterr');
		}
	
		//查询红包码是否有效
		$params = array();
		$params['site_id'] = $site_id;
		$params['content'] = $key;
		$codeInfo = $this->redpack_code_model->getInfoByAttribute($params);
		if (!$codeInfo)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_code_notexist getList empty ' . serialize(array($params, $log_data)));
			return result('', 'redpack_exchange_code_notexist', 'redpack_exchange_code_notexist');
		}
		//$log_data[] = $codeList;
	
		/**************************************************
		 * 红包活动的校验
		 *
		 ****************************************************/
	
		//查询红包活动是否存
		$redpackInfo = $this->redpack_model->getInfo($codeInfo['redpack_id']);
		if (!$redpackInfo)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_redpack_noexist ' . serialize(array($codeInfo, $log_data)));
			return result('', 'redpack_exchange_not_exist', 'redpack_exchange_not_exist');
		}
		//$log_data[] = $redpackInfo;
	
		//活动不存在
		if (empty($redpackInfo['status']))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_not_open ' . serialize(array($redpackInfo, $log_data)));
			return result('', 'redpack_exchange_not_open', 'redpack_exchange_not_open');
		}
	
		//活动未开始
		if (empty($redpackInfo['start_time']) || (int)$redpackInfo['start_time'] > time())
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_not_start ' . serialize(array($redpackInfo, $log_data)));
			return result('', 'redpack_exchange_not_start', 'redpack_exchange_not_start');
		}
	
		//活动已结束
		if (empty($redpackInfo['end_time']) || (int)$redpackInfo['end_time'] < time())
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_is_end ' . serialize(array($redpackInfo, $log_data)));
			return result('', 'redpack_exchange_is_end', 'redpack_exchange_is_end');
		}
		
		//判断校验码是否已使用
		if ($codeInfo['status'] == 2)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_code_isused cache_sismember ' . serialize(array($codeInfo, $log_data)));
			return result('', 'redpack_exchange_code_isused', 'redpack_exchange_code_isused');
		}
		
		//判断红包金额是否合法
		if ($codeInfo['money'] < 1)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_money_less ' . serialize(array($codeInfo, $log_data)));
			return result('', 'redpack_exchange_money_less', 'redpack_exchange_money_less');
		}
		
		//查询用户是否获得过
		$params = array();
		$params['site_id'] = $site_id;
		$params['openid'] = $openid;
		//有红包组的情况
		if ($redpackInfo['key'])
		{
			$params['key'] = $redpackInfo['key'];
		}
		//没有红包组的情况
		else
		{
			$params['redpack_id'] = $redpackInfo['redpack_id'];
		}
		$params['status'] = 0;
		$recordInfo = $this->Redpack_record_model->getInfoByAttribute($params);
		
		/*************************************
		 * 校验成功, 执行兑换
		 *
		 ************************************/
	
		//设置红包码用户标志
		$params = array();
		$params['status'] = 2;
		$this->redpack_code_model->updateInfo($codeInfo['redpack_code_id'], $params);
	
		//生成支付号
		$mch_billno = $siteInfo['pay_mch_id'].date('YmdHis').mt_rand(1000, 9999);
		$log_data[] = $mch_billno;
		
		//本渠道发放, 只执行领取
		if ($redpackInfo['send_type'])
		{
			if (!$recordInfo)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_user_notfetch cache_sismember ' . serialize(array($params, $log_data)));
				return result('', 'redpack_exchange_user_notfetch', 'redpack_exchange_user_notfetch');
			}
			
			//添加红包记录
			$params = array();
			$params['redpack_id'] = $redpackInfo['redpack_id'];
			$params['site_id'] = $redpackInfo['site_id'];
			$params['openid'] = $openid;
			$params['mch_billno'] = $mch_billno;
			$params['mch_id'] = $siteInfo['pay_mch_id'];
			$params['money'] = $codeInfo['money'];
			$params['status'] = 0;
			$params['redpack_code'] = $codeInfo['content'];
			$record_id = $this->redpack_record_model->updateInfo($recordInfo['redpack_record_id'], $params);
			
			//增加红包的发放金额, 发放人数, 参与人数
			$params = array();
			$params['fetch_money'] = $codeInfo['money'];
			$params['fetch_people'] = 1;
			$this->redpack_model->increment($redpackInfo['redpack_id'], $params);
		}
		//其他渠道发放, 同时执行发和领
		else 
		{
			if ($recordInfo)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_user_repeat cache_sismember ' . serialize(array($params, $log_data)));
				return result('', 'redpack_exchange_user_repeat', 'redpack_exchange_user_repeat');
			}
			
			//添加红包记录
			$params = array();
			$params['redpack_id'] = $redpackInfo['redpack_id'];
			$params['site_id'] = $redpackInfo['site_id'];
			$params['openid'] = $openid;
			$params['mch_billno'] = $mch_billno;
			$params['mch_id'] = $siteInfo['pay_mch_id'];
			$params['money'] = $codeInfo['money'];
			$params['status'] = 0;
			$params['redpack_code'] = $codeInfo['content'];
			$params['create_time'] = time();
			$record_id = $this->redpack_record_model->insertInfo($params);
				
			//增加红包的发放金额, 发放人数, 参与人数
			$params = array();
			$params['send_money'] = $codeInfo['money'];
			$params['send_people'] = 1;
			$params['fetch_money'] = $codeInfo['money'];
			$params['fetch_people'] = 1;
			$this->redpack_model->increment($redpackInfo['redpack_id'], $params);
		}
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' succ ' . serialize($log_data));
		return result(array('redpackInfo' => $redpackInfo, 'codeInfo' => $codeInfo, 'mch_billno' => $mch_billno, 'record_id' => $record_id));
	}
	
	//回滚
	public function rollback_code($redpack_id, $redpack_code_id, $record_id, $errno = '', $error = '')
	{
		$log_data = array();
		$log_data[] = $this->input->post();
	
		//查询红包活动是否存
		$redpackInfo = $this->redpack_model->getInfo($redpack_id);
		if (!$redpackInfo)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_exchange_redpack_noexist ' . serialize($log_data));
			return result('', 'redpack_notexist', 'redpack_notexist');
		}
		$site_id = $redpackInfo['site_id'];
	
		//获取红包码
		$codeInfo = $this->redpack_code_model->getInfo($redpack_code_id);
		if (!$codeInfo)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' redpack_code_notexist ' . serialize($log_data));
			return result('', 'redpack_code_notexist', 'redpack_code_notexist');
		}
	
		//其他渠道发放
		if ($redpackInfo['send_type'])
		{
			//设置红包码用户标志
			$params = array();
			$params['status'] = 0;
			$this->redpack_code_model->updateInfo($redpack_code_id, $params);
		}
		//本渠道发放
		else 
		{
			//设置红包码用户标志
			$params = array();
			$params['status'] = 1;
			$this->redpack_code_model->updateInfo($redpack_code_id, $params);
		}
	
		$params = array();
		$params['status'] = 1;
		$params['errno'] = $errno;
		$params['error'] = $error;
		$this->redpack_record_model->updateInfo($record_id, $params);
	
		//增加红包的发放金额, 发放人数, 参与人数
		$params = array();
		$params['send_money'] = $codeInfo['money'];
		$params['send_people'] = 1;
		$this->redpack_model->decrement($redpackInfo['redpack_id'], $params);
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' succ ' . serialize($log_data));
		return result(true);
	}
}