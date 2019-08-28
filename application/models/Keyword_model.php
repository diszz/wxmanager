<?php
/**
 * 关键词表数据模型
*
* @copyright www.locojoy.com
* @author lihuixu@joyogame.com/xu.lihui@qq.com
* @version v1.0 2015.3.25
*
*/
class Keyword_model extends MY_Model
{
	protected $table = 'keyword';
	protected $primaryKey = 'keyword_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function __construct()
	{
	    parent::__construct();
		$this->load->model(array('keyword_relation_model', 'Keyword_alias_model'));
	}
	
	public function getInfoRelation($info)
	{
		$info['children'] = array();
		if ($info['relation_count'])
		{
			$where = array('keyword_id' => $info['keyword_id']);
			$info['children'] = $this->keyword_relation_model->getList($where, array('sort' => 'asc'), 0, 999);
		}
		
		$where = array('keyword_id' => $info['keyword_id']);
		$info['alias'] = $this->Keyword_alias_model->getList($where, array('sort' => 'asc'), 0, 999);

		return $info;
	}
}