<?php
/**
 * 关键词活动码表数据模型
 *
 * @copyright www.locojoy.com
 * @author xu.lihui@qq.com
 * @version v1.0 2015.2.2
 *
 */
class Code_item_model extends MY_Model
{
	protected $table = 'code_item';
	protected $primaryKey = 'code_item_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
	
}
