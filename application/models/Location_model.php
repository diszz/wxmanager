<?php
/**
 * location_model
 * 
 * @copyright www.locojoy.com
 * @author xu.lihui@qq.com
 * @version v1.0 2015.2.2
 *
 */
class Location_model extends MY_Model
{
	protected $table = 'location';
	protected $primaryKey = 'location_id';
	protected $multipleSite = true;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
}