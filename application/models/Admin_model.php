<?php
/**
 * 用户表数据模型
 *
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com/xu.lihui@qq.com
 * @version v1.0 2015.3.25
 *
 */
class Admin_model extends MY_Model
{
	protected $table = 'admin';
	protected $primaryKey = 'admin_id';
	protected $multipleSite = true;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
}