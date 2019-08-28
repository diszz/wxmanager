<?php
/**
 * 签到表数据模型
 *
 * @copyright www.locojoy.com
 * @author xu.lihui@qq.com
 * @version v1.0 2015.2.2
 *
 */
class Signin_model extends MY_Model
{
	protected $table = 'signin';
	protected $primaryKey = 'signin_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
	
	//签到业务逻辑
	public function doSign($site_id, $signin_id, $openid)
	{
		$this->load->model(array('signin_item_model', 'signin_user_model', 'signin_record_model'));
		
		//获取签到信息
		$signinInfo = $this->signin_model->getInfo($signin_id);
		if (!$signinInfo)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' getInfo $signin_id empty ');
			return result('', 'signin_notexist', lang('signin_notexist'));
		}
		
		//获取与用户关系信息
		$where = array();
		$where['site_id'] = $site_id;
		$where['signin_id'] = $signin_id;
		$where['openid'] = $openid;
		$signinUserInfo = $this->signin_user_model->getInfoByAttribute($where);
		if (!$signinUserInfo)
		{
			$data = array();
			$data['site_id'] = $site_id;
			$data['signin_id'] = $signin_id;
			$data['openid'] = $openid;
			$data['total_count'] = (int)0;
			$data['keep_count'] = (int)0;
			$data['last_time'] = (int)0;
			$data['create_time'] = time();
			$signin_user_id = $this->signin_user_model->insertInfo($data);
				
			$signinUserInfo = $this->signin_user_model->getInfo($signin_user_id);
			
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' first signin '.serialize(array($signinUserInfo)));
		}
		
		//获取签到奖励全部次数
		$where = array();
		$where['signin_id'] = $signin_id;
		$signinItemList = $this->signin_item_model->getList($where);
		$signinItemArr = array();
		if ($signinItemList)
		{
			foreach ($signinItemList as $item)
			{
				$signinItemArr[$item['times']] = $item;
			}
		}
		
		/**********************************************
		 * 计算下一次签到
		 ***********************************************/
		
		$next_time_start = $signinUserInfo['last_time'] + $signinInfo['cycle'];
		$next_time_end = $next_time_start + $signinInfo['cycle'];
		
		//没有达到下次签到时间, 提示重复签到
		if ($next_time_start > time())
		{
			$curSigninItem = $signinItemArr[$signinUserInfo['keep_count']];
			
			if (strpos($curSigninItem['repeat_word'], '{time}'))
			{
				$curSigninItem['repeat_word'] = str_replace('{time}', ($next_time_start - time()) . '秒', $curSigninItem['repeat_word']);
			}
			
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' signin_repeat '.serialize(array($where)));
			return result('', 'repeat_word', $curSigninItem['repeat_word']);
		}
		
		//确定签到次数
		$signinTime = 1;
		
		//是连续签到
		if ($signinInfo['is_continue'])
		{
			//已经过了下一次签到的最后时间
			if ($next_time_end < time())
			{
				//返回第1次签到
				if ($signinInfo['is_loop'])
				{
					$signinTime = 1;
				}
				//不是循环签到
				else 
				{
					log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' signin_over '.serialize(array($signinInfo, $signinUserInfo)));
					return result('', 'signin_over', lang('signin_over'));
				}
			}
			//否则是用户的连续签到次数
			else 
			{
				//下次签到在总次数之内
				if ($signinUserInfo['keep_count'] < $signinInfo['item_count'])
				{
					$signinTime = $signinUserInfo['keep_count'] + 1;
				}
				//下次签到超过总次数, 且是循环签到
				elseif ($signinInfo['is_loop'])
				{
					$signinTime = 1;
				}
				//不是循环签到
				else 
				{
					log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' signin_over '.serialize(array($signinInfo, $signinUserInfo)));
					return result('', 'signin_over', lang('signin_over'));
				}
			}
		}
		
		//不是连续签到
		else
		{
			//下次签到在总次数之内
			if ($signinUserInfo['keep_count'] < $signinInfo['item_count'])
			{
				$signinTime = $signinUserInfo['keep_count'] + 1;
			}
			//下次签到超过总次数, 且是循环签到
			elseif ($signinInfo['is_loop'])
			{
				$signinTime = 1;
			}
			//不是循环签到
			else 
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' signin_over '.serialize(array($signinInfo, $signinUserInfo)));
				return result('', 'signin_over', lang('signin_over'));
			}
		}
		
		
		/**********************************************
		 * 执行签到
		 ***********************************************/
		
		$params = array();
		$params['total_count'] = 1;
		$result = $this->signin_user_model->increment($signinUserInfo['signin_user_id'], $params);
		
		$params = array();
		$params['last_time'] = time();
		$params['keep_count'] = $signinTime;
		$result = $this->signin_user_model->updateInfo($signinUserInfo['signin_user_id'], $params);
		
		//将要执行的签到信息
		$signinItemInfo = $signinItemArr[$signinTime];
		
		//签到记录
		$data = array();
		$data['site_id'] = $site_id;
		$data['signin_id'] = (string)$signin_id;
		$data['openid'] = (string)$openid;
		$data['code_id'] = $signinItemInfo['code_id'];
		$data['message'] = (string)'签到第'.($signinTime).'次, 获得礼包码';
		$data['code_send_result'] = 0;
		$data['code_send_reason'] = '';
		$data['create_time'] = time();
		$signin_record_id = $this->signin_record_model->insertInfo($data);
		
		
		$data = array();
		$data['code_id'] = $signinItemInfo['code_id'];
		$data['signin_record_id'] = $signin_record_id;
		$data['word'] = $signinItemInfo['success_word'];
		
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' succ '.serialize(array($signinInfo, $signinUserInfo, $data)));
		return result($data);
	}
}
