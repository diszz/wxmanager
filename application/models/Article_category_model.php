<?php
/**
 * 文章数据模型
*
* @copyright www.locojoy.com
* @author lihuixu@joyogame.com/xu.lihui@qq.com
* @version v1.0 2015.3.25
*
*/
class Article_category_model extends MY_Model
{
	protected $table = 'article_category';
	protected $primaryKey = 'category_id';
	protected $multipleSite = false;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
}