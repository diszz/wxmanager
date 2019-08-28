<?php
/**
 * 关键词活动码表数据模型
 *
 * @copyright www.locojoy.com
 * @author xu.lihui@qq.com
 * @version v1.0 2015.2.2
 *
 */
class Code_model extends MY_Model
{
	protected $table = 'code';
	protected $primaryKey = 'code_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
	
	public function fetchCode($site_id, $code_id, $openid, $is_repeat = false)
	{
		$this->load->model(array('user_model', 'code_model', 'code_item_model', 'code_record_model', 'user_attribute_model'));
		
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
		
		
		//查询用户是否已获得过
		$wheres = array();
		$wheres['site_id'] = $site_id;
		$wheres['openid'] = $openid;
		$wheres['code_id'] = $code_id;
		$codeRecordInfo = $this->code_record_model->getInfoByAttribute($wheres);
		
		if ($codeRecordInfo)
		{
			if (!$is_repeat)
			{
				log_message('error', __CLASS__.' '.__FUNCTION__.' code_get_repeat '.serialize(array($wheres)));
				return result('', 'code_get_repeat', lang('code_get_repeat'));
			}
		}
		
		$codeInfo = $this->code_model->getInfo($code_id);
		if (!$codeInfo)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' code_notexist '.serialize(array($code_id)));
			return result('', 'code_notexist', lang('code_notexist'));
		}
		
		//比较剩余量
		$code_last = (int)$codeInfo['total_count'] - (int)$codeInfo['send_count'];
		log_message('error', __CLASS__.' '.__FUNCTION__.' code_item_last '.serialize(array($code_last, $codeInfo)));
		if ($code_last <= 0)
		{
			log_message('error', __CLASS__.' '.__FUNCTION__.' code_item_noremain : total_count >= send_count '.serialize(array($codeInfo)));
			return result('', 'code_item_noremain', lang('code_item_noremain'));
		}
		
		//随机抽取未分配的列表
		$params = array();
		$params['site_id'] = $site_id;
		$params['status'] = 0;
		$params['code_id'] = $code_id;
		
		$limit = 5;
		$offset = 0;
		if ($code_last > $limit)
		{
			$offset = mt_rand(0, $code_last - $limit);
		}
		$codeItemList = $this->code_item_model->getList($params, null, $offset, $limit, 0, false);
		if (!$codeItemList)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' code_item_model getList empty ' . json_encode(array($params, $offset, $limit)));
			return result('', 'code_item_noremain', lang('code_item_noremain'));
		}
		
		//分配, 防止并发, 有至多5次机会
		$runStat = false;
		$codeItemInfo = null;
		foreach ($codeItemList as $k => $item)
		{
			log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' foreach $codeItemList ' . serialize(array($k, $item)));
			//更改code item的状态
			$set = array();
			$set['status'] = 1;
			$result = $this->code_item_model->updateInfo($item['code_item_id'], $set);
			if ($result)
			{
				$runStat = true;
				$codeItemInfo = $item;
				log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' getItem succ ' . serialize(array($item)));
				break;
			}
			else
			{
				//没有抢到, 尝试下一个
				log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' foreach $codeItemList fail,next ' . serialize(array($k, $item)));
			}
		}
		if (!$runStat)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run code_item_noremain ');
			return result('', 'code_item_noremain', lang('code_item_noremain'));
		}
		
		//礼包已送出量+1
		$params = array();
		$params['send_count'] = 1;
		$this->code_model->increment($code_id, $params);
		
		//记录用户的礼包
		$params = array();
		$params['code_count'] = 1;
		$this->user_attribute_model->increment($userInfo['user_id'], $params);
		
		//记录用户的礼包
		$params = array();
		$params['site_id'] = $site_id;
		$params['code_id'] = $code_id;
		$params['openid'] = $openid;
		$params['code_item_id'] = $codeItemInfo['code_item_id'];
		$params['message'] = $codeItemInfo['content'];
		$params['code_send_result'] = 1;
		$params['code_send_reason'] = $codeItemInfo['code_item_id'];
		$params['ip'] = getIp();
		$params['create_time'] = time();
		$this->code_record_model->insertInfo($params);
		
		return result($codeItemInfo);
	}
}
