<?php
class Test extends MY_Controller
{
	function index()
	{
		
// 		$cache = cache_init();
// 		var_dump($cache);
		
// 		$cache->file->set('afaf', 'ccc');
		
// 		var_dump($cache->file->get('afaf'));
		
		
		
// 		$this->load->driver('cache');
// 		$this->cache->file->save('foo', 'bar', 10);
		
		
		$this->load->driver('cache', array('adapter' => 'file', 'path' => APPPATH . 'cache'));
		
		if ( ! $foo = $this->cache->get('foo'))
		{
			echo 'Saving to the cache!<br />';
			$foo = 'foobarbaz!';
		
			// Save into the cache for 5 minutes
			$this->cache->save('foo', $foo, 300);
		}
		
		echo $this->cache->get('foo');
	}
	
	
	function tip()
	{
		$ip = '124.202.190.25';
		
		include APPPATH . 'libraries/sinaip/ip.php';
		
		$ret = getIpLookup($ip);
		var_dump($ret);
		
		
	}
	

}