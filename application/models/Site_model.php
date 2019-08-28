<?php
/**
 * 微信表数据模型
 *
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com/xu.lihui@qq.com
 * @version v1.0 2015.3.25
 *
 */
class Site_model extends MY_Model
{
	protected $table = 'site';
	protected $primaryKey = 'site_id';
	protected $multipleSite = true;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
}
