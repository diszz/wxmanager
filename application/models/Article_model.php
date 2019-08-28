<?php
/**
 * 文章数据模型
*
* @copyright www.locojoy.com
* @author lihuixu@joyogame.com/xu.lihui@qq.com
* @version v1.0 2015.3.25
*
*/
class Article_model extends MY_Model
{
	protected $table = 'article';
	protected $primaryKey = 'article_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function __construct()
	{
	    parent::__construct();
		$this->load->model('Article_attribute_model');
	}
	
	public function getInfoRelation($info)
	{
		$info['attribute'] = $this->Article_attribute_model->getInfoByAttribute(array('article_id' => $info['article_id']));
		
		return $info;
	}
}