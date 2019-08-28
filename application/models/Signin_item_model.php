<?php
/**
 * 管理员站点表数据模型
*
* @copyright www.locojoy.com
* @author lihuixu@joyogame.com/xu.lihui@qq.com
* @version v1.0 2015.3.25
*
*/
class Signin_item_model extends MY_Model
{
	protected $table = 'signin_item';
	protected $primaryKey = 'signin_item_id';
	protected $multipleSite = false;
	protected $timestamps = false;
	
	public function getInfoRelation($info)
	{
		return $info;
	}
}