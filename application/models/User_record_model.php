<?php
/**
 * 用户操作记录表数据模型
 *
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com/xu.lihui@qq.com
 * @version v1.0 2015.3.25
 *
 */
class User_record_model extends MY_Model
{
	protected $table = 'user_record';
	protected $primaryKey = 'user_record_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
}