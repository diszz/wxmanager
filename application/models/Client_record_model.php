<?php
/**
 * location_model
 * 
 * @copyright www.locojoy.com
 * @author xu.lihui@qq.com
 * @version v1.0 2015.2.2
 *
 */
class Client_record_model extends MY_Model
{
	protected $table = 'client_record';
	protected $primaryKey = 'client_record_id';
	protected $multipleSite = true;
	protected $timestamps = false;

	public function getInfoRelation($info)
	{
		return $info;
	}
	
	public function getStatistical($site_id, $count = 6)
	{
		$attrs = array();
		$attrs['site_id'] = $site_id;
		$attrs['less']['create_time'] = time();
		$attrs['great']['create_time'] = strtotime(date('Y-m-d', time()));
		$count_today = $this->Client_record_model->getCount($attrs);
		
		$attrs = array();
		$attrs['site_id'] = $site_id;
		$attrs['less']['create_time'] = strtotime(date('Y-m-d', time()));
		$attrs['great']['create_time'] = strtotime(date('Y-m-d', time() - 86400));
		$count_yestoday = $this->Client_record_model->getCount($attrs);
		
		$attrs = array();
		$attrs['site_id'] = $site_id;
		$attrs['less']['create_time'] = strtotime(date('Y-m-d', time() - 86400));
		$attrs['great']['create_time'] = strtotime(date('Y-m-d', time() - 86400 * 2));
		$count_2 = $this->Client_record_model->getCount($attrs);
		
		return array(
				date('Y-m-d', time()) => $count_today, 
				date('Y-m-d', time() - 86400) => $count_yestoday,
				date('Y-m-d', time() - 86400 * 2) => $count_2
		);
	}
	
	public function getKeywordStat($site_id, $count = 20)
	{
		$sql = "select keyword,count(keyword) as count from ".$this->table." where site_id=".$site_id;
		$sql .= " and create_time > ".strtotime(date('Y-m-d', time() - 86400 * 7));
		$sql .= " group by keyword order by count desc limit 0, 50";
		
		$query = $this->db()->query($sql);	
		$list = $query->result_array();
		log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query, no cache '.serialize(array($list, $this->db()->last_query())));
		
		$arr = array();
		if ($list)
		{
			foreach ($list as $item)
			{
				$arr[$item['keyword']] = $item['count'];
			}
		}
	
		return $arr;
	}
	
	public function getRecordTypeStat($site_id, $count = 20)
	{
		$sql = "select `type`,count(`type`) as count from ".$this->table." where site_id=".$site_id;
		$sql .= " and create_time > ".strtotime(date('Y-m-d', time() - 86400 * 7));
		$sql .= " group by `type` order by count desc limit 0, 5";
		
		$query = $this->db()->query($sql);	
		$list = $query->result_array();
		log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query, no cache '.serialize(array($list, $this->db()->last_query())));
		
		$arr = array();
		if ($list)
		{
			foreach ($list as $item)
			{
				$arr[$item['type']] = $item['count'];
			}
		}
	
		return $arr;
	}
}