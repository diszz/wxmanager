<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 3.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Redis Caching Class
 *
 * @package	   CodeIgniter
 * @subpackage Libraries
 * @category   Core
 * @author	   Anton Lindqvist <anton@qvister.se>
 * @link
 */
class CI_Cache_redis extends CI_Driver
{
	/**
	 * An internal cache for storing keys of serialized values.
	 *
	 * @var	array
	 */
	protected $_serialized = array();
	
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
		if ( ! $this->is_supported())
		{
			log_message('error', 'Cache: Failed to create Redis object; extension not loaded?');
			return;
		}
		
		//读取 application/config/redis.php 配置
		$CI =& get_instance();
		if ($CI->config->load('redis', TRUE, TRUE))
		{
			$this->_config = $CI->config->item('redis');
		}
	}
	
	/**
	 * Get cache
	 ** @param string $key 缓存KEY,支持一次取多个 $key = array('key1','key2')
	 * @return string || boolean  失败返回 false, 成功返回字符串
	 * @param	string	$key	Cache ID
	 * @return	mixed
	 */
	public function get($key)
	{
		// 是否一次取多个值
		$func = is_array($key) ? 'mGet' : 'get';
		$value = $this->_redis()->{$func}($key);
		
		//if ($value !== FALSE && isset($this->_serialized[$key]))
		//{
		//	return unserialize($value);
		//}
		
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

	// ------------------------------------------------------------------------

	/**
	 * Save cache
	 *
	 * @param	string	$id	Cache ID
	 * @param	mixed	$data	Data to save
	 * @param	int	$ttl	Time to live in seconds
	 * @param	bool	$raw	Whether to store the raw value (unused)
	 * @return	bool	TRUE on success, FALSE on failure
	 */
	public function save($id, $data, $ttl = 60, $raw = FALSE)
	{
		if (is_array($data) OR is_object($data))
		{
			//if ( ! $this->_redis->sIsMember('_ci_redis_serialized', $id) && ! $this->_redis->sAdd('_ci_redis_serialized', $id))
			//{
			//	return FALSE;
			//}

			//isset($this->_serialized[$id]) OR $this->_serialized[$id] = TRUE;
			$data = serialize($data);
		}
		//elseif (isset($this->_serialized[$id]))
		//{
			//$this->_serialized[$id] = NULL;
			//$this->_redis->sRemove('_ci_redis_serialized', $id);
		//}
		
		return $this->_redis('master')->set($id, $data, $ttl);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete from cache
	 *
	 * @param	string	$key	Cache key
	 * @return	bool
	 */
	public function delete($key)
	{
		if ($this->_redis('master')->delete($key) !== 1)
		{
			return FALSE;
		}

		//if (isset($this->_serialized[$key]))
		//{
		//	$this->_serialized[$key] = NULL;
		//	$this->_redis->sRemove('_ci_redis_serialized', $key);
		//}

		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Increment a raw value
	 *
	 * @param	string	$id	Cache ID
	 * @param	int	$offset	Step/value to add
	 * @return	mixed	New value on success or FALSE on failure
	 */
	public function increment($id, $offset = 1)
	{
		return $this->_redis('master')->incr($id, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Decrement a raw value
	 *
	 * @param	string	$id	Cache ID
	 * @param	int	$offset	Step/value to reduce by
	 * @return	mixed	New value on success or FALSE on failure
	 */
	public function decrement($id, $offset = 1)
	{
		return $this->_redis('master')->decr($id, $offset);
	}

	public function expire($id, $time)
	{
	    return $this->_redis('master')->expire($id, $time);
	}
	// ------------------------------------------------------------------------

	/**
	 * Clean cache
	 *
	 * @return	bool
	 * @see		Redis::flushDB()
	 */
	public function clean()
	{
		return $this->_redis('master')->flushDB();
	}

	// ------------------------------------------------------------------------

	/**
	 * Get cache driver info
	 *
	 * @param	string	$type	Not supported in Redis.
	 *				Only included in order to offer a
	 *				consistent cache API.
	 * @return	array
	 * @see		Redis::info()
	 */
	public function cache_info($type = NULL)
	{
		return $this->_redis()->info();
	}

	// ------------------------------------------------------------------------

	/**
	 * Get cache metadata
	 *
	 * @param	string	$key	Cache key
	 * @return	array
	 */
	public function get_metadata($key)
	{
		$value = $this->get($key);

		if ($value !== FALSE)
		{
			return array(
				'expire' => time() + $this->_redis()->ttl($key),
				'data' => $value
			);
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Check if Redis driver is supported
	 *
	 * @return	bool
	 */
	public function is_supported()
	{
		return extension_loaded('redis');
	}

	// ------------------------------------------------------------------------

	/**
	 * Class destructor
	 *
	 * Closes the connection to Redis if present.
	 *
	 * @return	void
	 */
	public function __destruct()
	{
//		if ($this->_redis)
//		{
//			$this->_redis->close();
//		}

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
	
}
