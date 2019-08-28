<?php
/**
 * 签到表数据模型
 *
 * @copyright www.locojoy.com
 * @author xu.lihui@qq.com
 * @version v1.0 2015.2.2
 *
 */
class Lottery_user_model extends MY_Model
{
	protected $table = 'lottery_user';
	protected $primaryKey = 'lottery_user_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
	
}
