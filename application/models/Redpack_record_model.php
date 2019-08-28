<?php
/**
 * 红包记录表数据模型
*
* @copyright www.locojoy.com
* @author lihuixu@joyogame.com/xu.lihui@qq.com
* @version v1.0 2015.3.25
*
*/
class Redpack_record_model extends MY_Model
{
	protected $table = 'redpack_record';
	protected $primaryKey = 'redpack_record_id';
	protected $multipleSite = false;
	protected $timestamps = false;
	
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('user_model');
	}

	public function getInfoRelation($info)
	{
		if (!empty($info['openid']))
		{
			$where = array('openid' => $info['openid']);
			$info['user_info'] = $this->user_model->getInfoByAttribute($where);
		}
		
		return $info;
	}
}