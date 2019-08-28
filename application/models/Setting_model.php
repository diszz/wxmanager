<?php
/**
 * 设置模型
*
* @copyright www.locojoy.com
* @author lihuixu@joyogame.com/xu.lihui@qq.com
* @version v1.0 2015.3.25
*
*/
class Setting_model extends MY_Model
{
	protected $table = 'setting';
	protected $primaryKey = 'setting_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
}