<?php
/**
 * 管理员站点表数据模型
*
* @copyright www.locojoy.com
* @author lihuixu@joyogame.com/xu.lihui@qq.com
* @version v1.0 2015.3.25
*
*/
class Keyword_alias_model extends MY_Model
{
	protected $table = 'keyword_alias';
	protected $primaryKey = 'keyword_alias_id';
	protected $multipleSite = false;
	protected $timestamps = false;
	
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('keyword_model');
	}

	public function getInfoRelation($info)
	{
		return $info;
	}
}