<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Redis 操作
 * 
 * @package	CodeIgniter
 * @author xu.lihui@qq.com
 * @since  Version 3.0.0
 */
class Redis_v1
{
	/**
	 * Default config
	 *
	 * @static
	 * @var	array
	 */
	protected $_config = array(
		'socket_type' => 'tcp',
		'host' => '127.0.0.1',
		'password' => NULL,
		'port' => 6379,
		'timeout' => 0
	);
	
	/*
	protected $_config = array(
	    'master' => array(
	        'status' => true,
	        'socket_type' => 'tcp',
	        'host' => '127.0.0.1',
	        'port' => 6379,
	        'timeout' => 1200
	    ),
	    'slave' => array(
	        'status' => true,
	        'socket_type' => 'tcp',
	        'host' => '127.0.0.1',
	        'port' => 6379,
	        'timeout' => 1200
	    )
	);
	*/
	
	/**
	 * Redis connection
	 *
	 * @var	Redis
	 */
	protected $_redis_object;


	public function __construct()
	{
	    //读取 application/config/redis.php 配置
	    $CI =& get_instance();
	    if ($CI->config->load('redis', TRUE, TRUE))
	    {
	        $this->_config = $CI->config->item('redis');
	    }
	}

	/**
	 * 写缓存
	 *
	 * @param string $key 组存KEY
	 * @param string $value 缓存值
	 * @param int $expire 过期时间， 0:表示无过期时间
	 */
	public function set($key, $value, $expire=0){
		if($expire == 0){
			$ret = $this->_redis('master')->set($key, $value);
		}else{
			$ret = $this->_redis('master')->setex($key, $expire, $value);
		}
		return $ret;
	}

	/**
	 * 读缓存
	 *
	 * @param string $key 缓存KEY,支持一次取多个 $key = array('key1','key2')
	 * @return string || boolean  失败返回 false, 成功返回字符串
	 */
	public function get($key)
	{
		$func = is_array($key) ? 'mGet' : 'get';
		$value = $this->_redis()->{$func}($key);
		
		if (!$value)
		{
		    return $value;
		}
		
		if(is_numeric($value))
		{
		    return $value;
		}
		
		if (preg_match('/^\w+$/', $value))
		{
		    return $value;
		}
		
		if (strpos($value, ':'))
		{
		    return unserialize($value);
		}
		
        return $value;
	}
	
	/**
	 * key 是否存在
	 *
	 * @param string $key 缓存KEY
	 * @return boolean
	 */
	public function has($key){
		return $this->_redis()->exists($key);
	}
	
	/**
	 * 删除缓存
	 *
	 * @param string || array $key 缓存KEY，支持单个健:"key1" 或多个健:array('key1','key2')
	 * @return int 删除的健的数量
	 */
	public function del($key){
		// $key => "key1" || array('key1','key2')
		return $this->_redis()->delete($key);
	}
	
	/**
	 * 值加加操作,类似 ++$i ,如果 key 不存在时自动设置为 0 后进行加加操作
	 *
	 * @param string $key 缓存KEY
	 * @param int $default 操作时的默认值
	 * @return int　操作后的值
	 */
	public function incr($key,$default=1){
		if($default == 1){
			return $this->_redis()->incr($key);
		}else{
			return $this->_redis()->incrBy($key, $default);
		}
	}
	
	/**
	 * 值减减操作,类似 --$i ,如果 key 不存在时自动设置为 0 后进行减减操作
	 *
	 * @param string $key 缓存KEY
	 * @param int $default 操作时的默认值
	 * @return int　操作后的值
	 */
	public function decr($key,$default=1){
		if($default == 1){
			return $this->_redis()->decr($key);
		}else{
			return $this->_redis()->decrBy($key, $default);
		}
	}
	
	/**
	 * 添空当前数据库
	 *
	 * @return boolean
	 */
	public function clear(){
		return $this->_redis()->flushDB();
	}
	
	public function expire($key, $expire = 600){
		return $this->_redis()->expire($key, (int)$expire);
	}

	/**
	 * 条件形式设置缓存，如果 key 不存时就设置，存在时设置失败
	 *
	 * @param string $key 缓存KEY
	 * @param string $value 缓存值
	 * @return boolean
	 */
	public function setnx($key, $value){
		return $this->_redis()->setnx($key, $value);
	}
    public function lrem($key, $count, $value){
        return $this->_redis()->lRemove($key, $value, $count);
    }
    public function llen($key){
        return $this->_redis()->llen($key);
    }
    public function lpush($key, $value){
        return $this->_redis()->lpush($key, self::import_convert($value));
    }
    public function rpush($key, $value){
        return $this->_redis()->rpush($key, self::import_convert($value));
    }
    public function lget($key){ //list get
        $list = array();
        $len = $this->llen($key);
        for($i = 0; $len >= $i; $i++){
            $data = $this->_redis()->lindex($key, $i);
            array_push($list, $data);
        }
        return $list;
    }
    public function lrange($key, $start, $limit){
        $end = $start + $limit - 1;
        $data = $this->_redis()->lrange($key, $start, $end);
        $list = array();
        foreach($data as $k => $v){
            $list[$k] = $v;
        }
        return $list;
    }
    public function rpop($key){
        return $this->_redis()->rpop($key);
    }
    public function lpop($key){
        return $this->_redis()->lpop($key);
    }
    public function sadd($key, $val){
        return $this->_redis()->sadd($key, $val);
    }
    public function hset($key, $field, $val){
        return $this->_redis()->hset($key, $field, $val);
    }
    public function hget($key, $field){
    	return $this->_redis()->hget($key, $field);
    }
    public function hexists($key, $field){
        return $this->_redis()->hexists($key, $field);
    }
    public function spop($key){
        return $this->_redis()->spop($key);
    }
    public function srem($key, $field){
    	return $this->_redis()->srem($key, $field);
    }
    public function sismember($key, $member){
    	return $this->_redis()->sismember($key, $member);
    }
    public function ssize($key){
    	return $this->_redis()->ssize($key);
    }
	
	
	/******************************************
	 * 有序集合
	 *******************************************/
	public function zadd($key, $member, $score){
		return $this->_redis()->zAdd($key, (int)$score, $member);
	}
	public function zrank($key, $member){
		return $this->_redis()->zRank($key, $member);
	}
	public function zrevrank($key, $member){
		return $this->_redis()->zRevRank($key, $member);
	}
	public function zincrby($key, $member, $score){
		return $this->_redis()->zIncrBy($key, (int)$score, $member);
	}
	public function zscore($key, $member){
		return $this->_redis()->zScore($key, $member);
	}
	public function zcount($key, $min, $max){
		return $this->_redis()->zCount($key, (int)$min, (int)$max);
	}
	public function zrange($key, $start, $stop){
		return $this->_redis()->zRange($key, (int)$start, (int)$stop);
	}
	public function zrevrange($key, $start, $stop){
		return $this->_redis()->zrevrange($key, (int)$start, (int)$stop);
	}
	
	/**
	 * 关闭连接
	 *
	 * @return boolean
	 */
	public function close()
	{
	   if(isset($this->_redis_object['slave']))
        {
            $this->_redis_object['slave']->close();
        }
        
        if(isset($this->_redis_object['master']))
        {
            $this->_redis_object['master']->close();
        }
        
        if (!isset($this->_redis_object['slave']) && !isset($this->_redis_object['master']))
        {
            $this->_redis_object->close();
        }
		return true;
	}

	/**
	 * 获得redis对象
	 * 懒加载模式
	 * 
	 * @param string $type slave,master
	 * @return Redis
	 */
	private function _redis($type = 'master')
	{
	    //正常配置
	    if (empty($this->_config['master']))
	    {
	        if(!$this->_redis_object)
	        {
	            $this->_redis_object = new Redis();
	            $this->_redis_object->pconnect($this->_config['host'],$this->_config['port']);
	        }
	        
	        return $this->_redis_object;
	    }
	    
	    //读写分离
	    else
	    {
	        if ($type == 'slave')
	        {
	            if (empty($this->_redis_object['slave']))
	            {
	                //一主多从
	                if (!empty($this->_config['slave']))
	                {
	                    //单一配置
	                    if (isset($this->_config['slave']['host']))
	                    {
	                        $this->_redis_object['slave'] = new Redis();
	                        $this->_redis_object['slave']->pconnect($this->_config['slave']['host'],$this->_config['slave']['port']);
	                    }
	                    //多元配置, 单数据
	                    else if (count($this->_config['slave']) == 1)
	                    {
	                        $this->_redis_object['slave'] = new Redis();
	                        $this->_redis_object['slave']->pconnect($this->_config['slave'][0]['host'],$this->_config['slave'][0]['port']);
	                    }
	                    else
	                    {
	                        //随机 HASH 得到 Redis Slave 服务器句柄
	                        $hash = $this->_hashId(mt_rand(), count($this->_config['slave']));
	                         
	                        $this->_redis_object['slave'] = new Redis();
	                        $this->_redis_object['slave']->pconnect($this->_config['slave'][$hash]['host'],$this->_config['slave'][$hash]['port']);
	                    }
	                }
	                //一主0从
	                else 
	                {
	                    $this->_redis_object['slave'] = new Redis();
	                    $this->_redis_object['slave']->pconnect($this->_config['master']['host'],$this->_config['master']['port']);
	                }
	                 
	                log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' slave init');
	            }
	             
	            return $this->_redis_object['slave'];
	        }
	        else 
	        {
	            if (empty($this->_redis_object['master']))
	            {
	                $this->_redis_object['master'] = new Redis();
	                $this->_redis_object['master']->pconnect($this->_config['master']['host'],$this->_config['master']['port']);
	            
	                log_message('debug', __CLASS__ . ' ' . __FUNCTION__ . ' master init');
	            }
	            
	            return $this->_redis_object['master'];
	        }
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

}// End Class