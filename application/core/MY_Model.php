<?php
/**
 *
 * 模型继承类
 * 读写分离
 *
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.3.20
 *
 */
class MY_Model extends CI_Model
{
	var $class_vars = array();
	var $_db_object = null;
	var $_self_connect = false;
	var $_config = array();
	
    public function __construct()
    {
		parent::__construct();
		
		//读取配置文件
		$db = array();
		$active_group = '';
		if ( ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php')
		    && ! file_exists($file_path = APPPATH.'config/database.php'))
		{
		    show_error('The configuration file database.php does not exist.');
		}
		include($file_path);
		
		$this->_config['db'] = $db;
		$this->_config['active_group'] = $active_group;
    }
    
    /**
     * 根据主键获取单条信息
     *
     * @param string $id
     * @param number $timeout
     * @return array|null
     */
    public function getInfo($primaryVal, $timeout = 1800)
    {
    	if ($timeout < 1)
    	{
    		$query = $this->db('read')->where($this->getPrimaryKey(), $primaryVal)->get($this->getTable());
    		$info = $query->row_array();
    		log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('read')->last_query()));
    	}
    	else 
    	{
    		$cache_key = cache_key($this->getTable() . ':' . get_called_class(), $primaryVal);
    		if (!cache_has($cache_key))
    		{
    			$query = $this->db('read')->where($this->getPrimaryKey(), $primaryVal)->get($this->getTable());
    			$info = $query->row_array();
    			log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('read')->last_query()));
    			 
    			if ($info)
    			{
    				cache_set($cache_key, $info, $timeout);
    			}
    		}
    		else
    		{
    			$info = cache_get($cache_key);
    		}
    	}
    
    	//挂载联表数据
    	if ($info && method_exists(get_called_class(), 'getInfoRelation'))
    	{
    		$info = $this->getInfoRelation($info);
    	}
    
    	return $info;
    }
    
    public function getInfoByAttribute($where, $timeout = 600, $mount = true)
    {
    	if ($timeout < 1)
    	{
    		$where && $this->getWhere($where);
    		
    		if ($mount)
    		{
    			$qurey = $this->db('read')->select(array($this->getPrimaryKey()))->offset(0)->limit(1)->get($this->getTable());
    			$info = $qurey->row_array();
    		}
    		else
    		{
    			$query = $this->db('read')->offset(0)->limit(1)->get($this->getTable());
    			$info = $query->row_array();
    		}
    		log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('read')->last_query()));
    	}
    	else 
    	{
    		$cache_key = cache_key($this->getTable() .':'. get_called_class().':'.__FUNCTION__, md5(serialize($where)));
    		if (!cache_has($cache_key))
    		{
    			$where && $this->getWhere($where);
    			
    			if ($mount)
    			{
    				$qurey = $this->db('read')->select(array($this->getPrimaryKey()))->offset(0)->limit(1)->get($this->getTable());
    				$info = $qurey->row_array();
    			}
    			else
    			{
    				$query = $this->db('read')->offset(0)->limit(1)->get($this->getTable());
    				$info = $query->row_array();
    			}
    			log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('read')->last_query()));
    			 
    			if ($info)
    			{
    				cache_set($cache_key, $info, $timeout);
    			}
    		}
    		else
    		{
    			$info = cache_get($cache_key);
    		}
    	}
    	
    	if ($mount && $info)
    	{
    		$info = $this->getInfo($info[$this->getPrimaryKey()]);
    	}
    
    	//挂载联表数据
    	elseif (!$mount && $info && method_exists(get_called_class(), 'getInfoRelation'))
    	{
    		$info = $this->getInfoRelation($info);
    	}
    
    	return $info;
    }
    
    /**
     * 查询列表
     *
     * v2015.3.12
     *
     * @param array $where
     * @param array $order
     * @param array $offset
     * @param int $limit
     * @param int $groupby 
     * @param int $timeout 查询缓存时间, 默认为0, 即不缓存, 建议使用默认值. 因此缓存后无法及时获取到最新增加的记录. 且只是查询id
     * @param bool $mount : true 启用挂载模式, false 取消挂载模式
     * @return array
     */
    public function getList($where, $order = array(), $offset = 0, $limit = 20, $groupby = null, $timeout = 0, $mount = true)
    {
    	if ($timeout < 1)
    	{
    		$where && $this->getWhere($where);
    		 
    		$order && $this->getOrder($order);
    		 
    		$groupby && $this->getGroupBy($groupby);
    		
    		if ($mount)
    		{
    			$qurey = $this->db('read')->select(array($this->getPrimaryKey()))->offset($offset)->limit($limit)->get($this->getTable());
    			$list = $qurey->result_array();
    		}
    		else
    		{
    			$qurey = $this->db('read')->select()->offset($offset)->limit($limit)->get($this->getTable());
    			$list = $qurey->result_array();
    		}
    		log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('read')->last_query()));
    	}
    	else
    	{
    		$cache_key = cache_key($this->getTable() .':'. get_called_class().':'.__FUNCTION__, md5(serialize(array($where, $order, $offset, $limit, $groupby, $timeout))));
    		if (!cache_has($cache_key))
    		{
    			$where && $this->getWhere($where);
    			 
    			$order && $this->getOrder($order);
    			 
    			$groupby && $this->getGroupBy($groupby);
    		
    			if ($mount)
    			{
    				$qurey = $this->db('read')->select(array($this->getPrimaryKey()))->offset($offset)->limit($limit)->get($this->getTable());
    				$list = $qurey->result_array();
    			}
    			else
    			{
    				$qurey = $this->db('read')->select()->offset($offset)->limit($limit)->get($this->getTable());
    				$list = $qurey->result_array();
    			}
    			 
    			log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('read')->last_query()));
    			if ($list)
    			{
    				cache_set($cache_key, $list, $timeout);
    			}
    		}
    		else
    		{
    			$list = cache_get($cache_key);
    		}
    	}
    
    	//挂载联表数据
    	if ($mount && $list)
    	{
    		$list_ = array();
    		foreach ($list as $item)
    		{
    			$info = $this->getInfo($item[$this->getPrimaryKey()]);
    			if ($info)
    			{
    				$list_[] = $info;
    			}
    		}
    
    		$list = $list_;
    	}
    	elseif (!$mount && $list && method_exists(get_called_class(), 'getInfoRelation'))
    	{
    		$list_ = array();
    		foreach ($list as $item)
    		{
    			$info = $this->getInfoRelation($item);
    			$list_[] = $info;
    		}
    
    		$list = $list_;
    	}
    
    	return $list;
    
    }
    
    /**
     * 查询统计数
     *
     * v2015.3.12
     *
     * @param array $where
     * @param int $timeout 缓存结果集
     * @return array
     */
    public function getCount($where, $timeout = 0)
    {
    	if ($timeout < 1)
    	{
    		$where && $this->getWhere($where);
    		 
    		$count = $this->db('read')->count_all_results($this->getTable());
    		log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('read')->last_query()));
    	}
    	else 
    	{
    		$cache_key = cache_key($this->getTable() .':'. get_called_class().':'.__FUNCTION__, md5(serialize(array($where, $timeout))));
    		if (!cache_has($cache_key))
    		{
    			$where && $this->getWhere($where);
    			 
    			$count = $this->db('read')->count_all_results($this->getTable());
    			log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('read')->last_query()));
    			 
    			if ($count)
    			{
    				cache_set($cache_key, $count, $timeout);
    			}
    		}
    		else
    		{
    			$count = cache_get($cache_key);
    		}
    	}
    	
    	return $count;
    }
    
    public function insertInfo($data)
    {
    	$this->db('write')->insert($this->getTable(), $data);
    	log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('write')->last_query()));
    	return $this->db('write')->insert_id();
    }
    
    public function deleteInfo($primaryVal)
    {
    	$result = $this->db('write')->where($this->getPrimaryKey(), $primaryVal)->delete($this->getTable());
    	log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('write')->last_query()));
    
    	//删除该条信息的缓存
    	$cache_key = cache_key($this->getTable() . ':' . get_called_class(), $primaryVal);
    	if (cache_has($cache_key))
    	{
    		cache_del($cache_key);
    	}
    
    	return $result;
    }
    
    public function updateInfo($primaryVal, $attributes)
    {
    	$result = $this->db('write')->set($attributes)->where($this->getPrimaryKey(), $primaryVal)->update($this->getTable());
    	log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('write')->last_query()));
    	
    	//删除该条信息的缓存
    	$cache_key = cache_key($this->getTable() . ':' . get_called_class(), $primaryVal);
    	if (cache_has($cache_key))
    	{
    		$cacheInfo = cache_get($cache_key);
    		foreach ($attributes as $field => $val)
    		{
    			$cacheInfo[$field] = $val;
    		}
    		
    		cache_set($cache_key, $cacheInfo, 600);
    	}
    
    	return $result;
    }
    
    public function increment($primaryVal, $attributes)
    {
    	foreach ($attributes as $key => $val)
    	{
    		$this->db('write')->set($key, $key .'+'.$val, false);//第三个参数false意为不需要escape
    	}
    	
    	$result = $this->db('write')->where($this->getPrimaryKey(), $primaryVal)->update($this->getTable());
    	log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('write')->last_query()));
    	
    	//更新缓存
    	$cache_key = cache_key($this->getTable() . ':' . get_called_class(), $primaryVal);
    	if (cache_has($cache_key))
    	{
    		$cacheInfo = cache_get($cache_key);
    			
    		foreach ($attributes as $field => $val)
    		{
    			if (is_numeric($field) && !empty($cacheInfo[$val]))
    			{
    				$cacheInfo[$val] = (int)$cacheInfo[$val] + 1;
    			}
    			elseif (is_numeric($field))
    			{
    				$cacheInfo[$val] = 1;
    			}
    			elseif (!empty($cacheInfo[$field]))
    			{
    				$cacheInfo[$field] = (int)$cacheInfo[$field] + $val;
    			}
    			else
    			{
    				$cacheInfo[$field] = $val;
    			}
    		}
    		
    		cache_set($cache_key, $cacheInfo, 600);
    	}
    
    	return $result;
    }
    
    public function decrement($primaryVal, $attributes)
    {
    	foreach ($attributes as $key => $val)
    	{
    		$this->db('write')->set($key, $key .'-'.$val, false);//第三个参数false意为不需要escape
    	}
    	
    	$result = $this->db('write')->where($this->getPrimaryKey(), $primaryVal)->update($this->getTable());
    	log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($this->db('write')->last_query()));
    	
    	//更新缓存
    	$cache_key = cache_key($this->getTable() . ':' . get_called_class(), $primaryVal);
    	if (cache_has($cache_key))
    	{
    		$cacheInfo = cache_get($cache_key);
    
    		foreach ($attributes as $field => $val)
    		{
    			if (is_numeric($field) && isset($cacheInfo[$val]))
    			{
    				$cacheInfo[$val] = (int)$cacheInfo[$val] - 1;
    				$cacheInfo[$val] < 0 && ($cacheInfo[$val] = 0);
    			}
    			elseif (is_numeric($field))
    			{
    			    log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' last_query '.serialize($attributes));
    				return false;
    			}
    			elseif (!empty($cacheInfo[$field]))
    			{
    				$cacheInfo[$field] = (int)$cacheInfo[$field] - $val;
    				$cacheInfo[$val] < 0 && ($cacheInfo[$val] = 0);
    			}
    			else
    			{
    			    log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' false '.serialize($attributes));
    				return false;
    			}
    		}
    
    		cache_set($cache_key, $cacheInfo, 600);
    	}
    
    	return $result;
    }
    
    public function connect($hostname, $port, $username, $password, $database)
    {
        $this->_self_connect = true;
        
        $db = array();
        $db['hostname'] = $hostname;
        $db['port'] = ($port ? $port : null);
        $db['username'] = $username;
        $db['password'] = $password;
        $db['database'] = $database;
        $db['dbdriver'] = 'mysqli';
        $db['dbprefix'] = '';
        $db['pconnect'] = FALSE;
        $db['db_debug'] = false;
        $db['cache_on'] = FALSE;
        $db['cachedir'] = '';
        $db['char_set'] = 'utf8';
        $db['dbcollat'] = 'utf8_general_ci';
        $db['swap_pre'] = '';
        $db['autoinit'] = TRUE;
        $db['stricton'] = FALSE;
    
        $this->_db_object = $this->load->database($db, true);
        log_message('info', __CLASS__ . ' ' . __FUNCTION__ . ' database '.serialize(array($db, $this->db->conn_id)));
    
        return $this->_db_object->conn_id ? true : false;
    }
    
    public function connect_config($dbconfig)
    {
        $this->_self_connect = true;
        
        $this->_db_object = $this->load->database($dbconfig, true);
        log_message('info', __CLASS__ . ' ' . __FUNCTION__ . ' database '.serialize(array($dbconfig, $this->db->conn_id)));
    
        return $this->_db_object->conn_id ? true : false;
    }
    
    public function connect_group($group)
    {
        $this->_self_connect = true;
        
        $this->_db_object = $this->load->database($group, true);
        log_message('info', __CLASS__ . ' ' . __FUNCTION__ . ' database '.serialize(array($group, $this->db->conn_id)));
    
        return $this->_db_object->conn_id ? true : false;
    }
    
    protected function db($type = 'write')
    {
        //自主连接数据库, 不读配置
        if ($this->_self_connect)
        {
            return $this->_db_object;
        }
        
        //正常模式
        if (!isset($this->_config['db']['read']))
        {
            if (!$this->_db_object)
            {
                $this->_db_object = $this->load->database($this->_config['active_group'], true);
            }
            
            return $this->_db_object;
        }
        //主从分离
        else 
        {
            if ($type == 'read')
            {
                if (empty($this->_db_object['read']))
                {
                    //一主多从
                    if(!empty($this->_config['db']['read']))
                    {
                        //单一配置
                        if (isset($this->_config['db']['read']['hostname']))
                        {
                            $this->_db_object['read'] = $this->load->database($this->_config['db']['read'], true);
                        }
                        //多元配置, 单数据
                        else if (count($this->_config['db']['read']) == 1)
                        {
                            $this->_db_object['read'] = $this->load->database($this->_config['db']['read'][0], true);
                        }
                        //多元配置, 多数据
                        else
                        {
                            //随机 HASH 得到 Redis Slave 服务器句柄
                            $hash = $this->_hashId(mt_rand(), count($this->_config['db']['read']));
                        
                            $this->_db_object['read'] = $this->load->database($this->_config['db']['read'][$hash], true);
                        }
                    }
                    //一主0从
                    else 
                    {
                        $this->_db_object['read'] = $this->load->database($this->_config['db']['write'], true);
                    }
                        
                    log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' db read init');
                }
            
                return $this->_db_object['read'];
            }
            else
            {
                if (empty($this->_db_object['write']))
                {
                    $this->_db_object['write'] = $this->load->database($this->_config['db']['write'], true);
                    log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' db write init');
                }
            
                return $this->_db_object['write'];
            }
        }
    }
    
    protected function get_class_vars($force = false)
    {
    	if (!$this->class_vars || $force === true)
    	{
    		$this->class_vars = get_class_vars(get_called_class());
    	}
    	
    	return $this->class_vars;
    }
    
    protected function getPrimaryKey()
    {
    	$vars = $this->get_class_vars();
    	
    	return $vars['primaryKey'];
    }
    
    protected function getTable()
    {
    	$vars = $this->get_class_vars();
    
    	return $vars['table'];
    }
    
    /**
     * 设置水平分表
     * 根据某值取余切分表
     * 
     * 未分表
     * tablename
     * 分表
     * tablename_1
     * tablename_2
     * tablename_3
     * 
     * @param int $subtag : 分表标志, 如user_id
     */
    public function setSubtableTag($subtag)
    {
    	$vars = $this->get_class_vars(true);
    	
    	if (!empty($vars['subtableTagCount']))
    	{
    		$subtable = ($subtag % $vars['subtableTagCount']);
    		
    		//1-n
    		if ($subtable && !strpos($vars['table'], '_'. $subtable))
    		{
    			$this->class_vars['table'] = $vars['table'] .'_'. $subtable;
    			
    			log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' use subtable '.json_encode_cn(array($subtag, $this->class_vars)));
    		}
    		//0
    		else
    		{
    			//使用原表
    			log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' use table '.json_encode_cn(array($subtag, $this->class_vars)));
    		}
    	}
    	else 
    	{
    		log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' subtableTagCount empty '.json_encode_cn(array($subtag, $this->class_vars)));
    	}
    	
    	return ;
    }
    
    /**
     * 设置水平分表
     * 根据日期切分表
     * 
     * setSubtableSuffix(); 即使用原表
     *
     * @param string $subtag : 分表后缀, 如201512, 即匹配xxx_201512
     */
    public function setSubtableSuffix($subtag = null)
    {
    	//要取原始配置
    	$vars = $this->get_class_vars(true);
		
    	//有值时执行分表切换
    	if ($subtag && !strpos($vars['table'], '_'. $subtag))
    	{
    		$this->class_vars['table'] = $vars['table'] .'_'. $subtag;
    	}
    	
    	return ;
    }
    
    private function getWhere($where)
    {
        foreach ($where as $operation => $item)
        {
            if ($operation == 'like')
            {
                foreach ($item as $key => $val)
                {
                    //$this->db('read')->like($key, $val, 'none');
                    $this->db('read')->where($key. ' like ', $this->db('read')->escape($val), false);
                }
            }
            elseif ($operation == 'in')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where_in($key, $val);
                }
            }
            elseif ($operation == 'notin')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where_not_in($key, $val);
                }
            }
            elseif ($operation == 'not')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where($key. ' != ', $this->db('read')->escape($val), false);
                }
            }
            elseif ($operation == 'less')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where($key. ' < ', (int)$val, false);
                }
            }
            elseif ($operation == 'lessthan')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where($key. ' <= ', (int)$val, false);
                }
            }
            elseif ($operation == 'great')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where($key. ' > ', (int)$val, false);
                }
            }
            elseif ($operation == 'greatthan')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where($key. ' >= ', (int)$val, false);
                }
            }
             
            elseif ($operation == 'and_operation')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where($key. ' & ', (int)$val, false);
                }
            }
            elseif ($operation == 'or_operation')
            {
                foreach ($item as $key => $val)
                {
                    $this->db('read')->where($key. ' | ', (int)$val, false);
                }
            }
             
            elseif ($operation == 'exist')
            {
                foreach ($item as $key => $val)
                {
                    if (is_numeric($key))
                    {
                        $key = $val;
                    }
                    $this->db('read')->where_not_in($key, array('', null, 0));
                }
            }
            elseif ($operation == 'not_exist')
            {
                foreach ($item as $key => $val)
                {
                    if (is_numeric($key))
                    {
                        $key = $val;
                    }
                    $this->db('read')->where_in($key, array('', null, 0));
                }
            }
            else
            {
                $this->db('read')->where($operation, $item);
            }
        }
    	
    	return true;
    }
    
    private function getOrder($order)
    {
    	if (is_array($order))
    	{
    		foreach ($order as $key_ => $val_)
    		{
    			$this->db('read')->order_by($key_, $val_);
    		}
    	}
    	else
    	{
    		$this->db('read')->order_by($order);
    	}
    }
    
    private function getGroupBy($groupby)
    {
    	if (is_array($groupby))
    	{
    		foreach ($groupby as $key_)
    		{
    			$this->db('read')->group_by($key_);
    		}
    	}
    	else
    	{
    		$this->db('read')->group_by($groupby);
    	}
    }
    
    /**
     * 根据ID得到 hash 后 0～m-1 之间的值
     *
     * @param string $id
     * @param int $m
     * @return int
     */
    private function _hashId($id,$m=10)
    {
        //把字符串K转换为 0～m-1 之间的一个值作为对应记录的散列地址
        $k = md5($id);
        $l = strlen($k);
        $b = bin2hex($k);
        $h = 0;
        for($i=0;$i<$l;$i++)
        {
            //相加模式HASH
            $h += substr($b,$i*2,2);
        }
        
        $hash = ($h*1)%$m;
        return $hash;
    }
}
?>