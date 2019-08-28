<?php
/**
 * 站点表数据模型
 *
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com/xu.lihui@qq.com
 * @version v1.0 2015.3.25
 *
 */
class Menu_model extends MY_Model
{
	protected $table = 'menu';
	protected $primaryKey = 'menu_id';
	protected $multipleSite = true;
	protected $timestamps = false;
	
	public function getInfoRelation($info)
	{
		
		$where = array('parent_id' => $info['menu_id']);
		$info['children'] = $this->getList($where, array('sort' => 'asc'));
		
		
		return $info;
	}
}
