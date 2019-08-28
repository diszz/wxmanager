<?php
/**
 * 红包活动码表数据模型
 *
 * @copyright www.locojoy.com
 * @author xu.lihui@qq.com
 * @version v1.0 2015.2.2
 *
 */
class Redpack_code_model extends MY_Model
{
	protected $table = 'redpack_code';
	protected $primaryKey = 'redpack_code_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		if (!empty($info['open_id']))
		{
			$this->load->model('weixin/user_model');
			$where = array('open_id' => $info['open_id']);
			$info['user_info'] = $this->user_model->getInfoByAttribute($where);
		}

		return $info;
	}
	
}
