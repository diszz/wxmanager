<?php
/**
 * 签到表数据模型
 *
 * @copyright www.locojoy.com
 * @author xu.lihui@qq.com
 * @version v1.0 2015.2.2
 *
 */
class Lottery_record_model extends MY_Model
{
	protected $table = 'lottery_record';
	protected $primaryKey = 'lottery_record_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
	
}
