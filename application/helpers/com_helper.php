<?php


function make_rand($length = 16)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

function make_rand_num($length = 6)
{
    //验证码文字生成函数
    $str = "0123456789";
    $result = "";
    for ($i = 0; $i < $length; $i++)
    {
        $num = mt_rand(1, strlen($str));
        $result.=$str[$num - 1];
    }
    return $result;
}

function get_setting($k)
{
	$ci = _get_object();
	$ci->load->model('setting_model');
	$settingInfo = $ci->setting_model->getInfoByAttribute(array('key' => $k));
	if ($settingInfo)
	{
		return $settingInfo['value'];
	}

	return null;
}

function weixin_user_avatar($headimgurl)
{
	return $headimgurl;
}

/**
 * 生成随机金额数值
 * 
 * @param int $count
 * @param int $total
 * @param float $min
 * @param float $max
 * @return array
 */
function make_randmoneys($count, $total, $min, $max)
{
	$arr = array();
	if ($count == 0 || $min > $max)
	{
		return $arr;
	}
	$avg = floor($total / $count);
	$min_tmp = $min;
	$max_tmp = $max;
	$addmax = 0;
	if ($avg >= $min && $avg <= $max)
	{
		$max_tmp = $avg;
		$addmax = $max - $avg;
	}
	$nowsum = 0;
	while ($count > 0)
	{
		$tmprand = rand($min_tmp, $max_tmp);
		$nowsum+=$tmprand;
		if ($nowsum > $total)
		{
			$count = 0;
		}
		else
		{
			$arr[] = $tmprand;
			$count--;
		}
	}
	if ($total > $nowsum)
	{
		$nowhave = $total - $nowsum;

		$newarr = array();
		while ($nowhave > 0)
		{
			if (count($arr) > 0)
			{
				$tmpadd = rand(1, $addmax);
				$addnum = $tmpadd >= $nowhave ? $nowhave : $tmpadd;
				$nowhave-=$addnum;
				$tmpaddval = array_shift($arr);
				$newarr[] = $tmpaddval + $addnum;
			}
			else
			{
				$nowhave = 0;
			}
		}
		$arr = array_merge($newarr, $arr);
	}
	shuffle($arr);
	return $arr;
}

/**
 * 生成9位的不重复的字符串数据
 *
 * @param int $count : 字符串数
 * @param int $digit : 位数
 * @return array
 */
function make_uniqids($count, $digit = 9, $arr = array())
{
	$digitMin = convert_todec(str_pad('', $digit, 'a'));
	$digitMax = convert_todec(str_pad('', $digit, 'Z'));
	//var_dump($digitMin);
	//var_dump($digitMax);

	//var_dump(ceil($digitMin/100000000000000));
	//var_dump(floor($digitMax/100000000000000));
	//exit();
	$str = mt_rand(ceil($digitMin/100000000000000), floor($digitMax/100000000000000)) .''. (microtime(true) * 10000 + mt_rand(10000, 99999) * 100000);
	//log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $str1 '.serialize(array(strlen($str), $str)));

	$str = dec_convert($str, 55);
	//log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $str2 '.serialize(array(strlen($str), $str)));

	if (strlen($str) == $digit)
	{
		$arr[] = $str;
		//$arr[] = substr(md5(uniqid()), -$length, $length);
		$arr = array_unique($arr);
	}
	else
	{
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' strlen error '.serialize(array(strlen($str), $str)));
	}

	if (count($arr) < $count)
	{
		$arr = make_uniqids($count, $digit, $arr);
	}

	return $arr;
}

/**
 * 10进制转换为其他进制
 *
 * $c = md5('ffff');
 echo $c, PHP_EOL;
 echo $r = convert($c, 64), PHP_EOL;
 echo convert($r, -64);
 *
 * @param unknown $s
 * @param number $to
 * @return string
 */
function dec_convert($int, $to_ary = 55)
{
	$int = intval($int);
	//$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@=';//62
	$chars = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';//55
	$arr = array();
	do {
		$mod = $int % $to_ary;
		$int = ($int - $mod) / $to_ary;
		array_unshift($arr, $chars[$mod]);
	} while ($int);

	return implode('', $arr);
}

/**
 * 其他进制转换为10进制
 *
 * @param string $str
 * @param int $ary
 * @return number
 */
function convert_todec($str, $ary = 55)
{
	//$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@=';//62
	$chars = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';//55
	$int = 0;
	for ($i = 0; $i < strlen($str); $i++)
	{
		$s = substr($str, -$i-1, 1);
		//var_dump($s);
		$pos = strpos($chars, $s);
		//var_dump($pos);
		$int += pow($ary, $i) * $pos;
	}
	return $int;
}



function create_file($filename = '', $data = '')
{
	$upload_path = FCPATH.'resource/uploads/files/'.date('Y/md');
	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $upload_path '.serialize(array($upload_path)));

	//校验文件夹是否有效
	if (!is_dir($upload_path))
	{
		mkdir($upload_path, 0755, true);
		
		if (!is_dir($upload_path))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' mkdir error '.serialize(array($upload_path)));
			return false;
		}
	}
	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $upload_path1 '.serialize(array($upload_path)));

	$file_path = $upload_path .'/'.trim($filename, '/');

	//文件已存在, 自动更名
	if (file_exists($file_path))
	{
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' succ '.serialize(array($file_path)));

		if (strpos($filename, '.'))
		{
			$filename = str_replace('.', time() . '.', $filename);
		}
		else
		{
			$filename .= time();
		}

		$file_path = $upload_path .'/'.trim($filename, '/');
	}

	//写入文本
	write_file($file_path, $data);

	//校验结果
	if (file_exists($file_path))
	{
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' succ '.serialize(array($file_path)));
		return $file_path;
	}

	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' false '.serialize(array($file_path)));
	return false;
}

function ps($name)
{
	$cmd = "ps -o pid,start,command ax | grep '".$name."' | awk '!/awk/ && !/grep/'";
	@exec($cmd, $return, $errno);
	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd, $return, $errno)));

	return array('data' => $return, 'errno' => $errno);
}

//分页函数
function make_page($count, $offset, $limit, $otherRoute = '')
{
	$ci = _get_object();
	$ci->load->library("pagination");
	$pageConfig = array();
	$pageConfig["base_url"] = base_url($ci->router->fetch_directory().$ci->router->fetch_class().'/'.$ci->router->fetch_method().'/'.trim($otherRoute, '/'));
	$pageConfig["total_rows"] = $count;
	$pageConfig["per_page"] = $limit;
	$pageConfig["cur_page"] = $offset;
	$pageConfig["num_links"] = 6;

	$pageConfig['prev_tag_open'] = '<li class="paginate_button ">';
	$pageConfig['prev_tag_close'] = '</li>';
	$pageConfig['next_tag_open'] = '<li class="paginate_button ">';
	$pageConfig['next_tag_close'] = '</li>';

	$pageConfig['num_tag_open'] = '<li class="paginate_button ">';
	$pageConfig['num_tag_close'] = '</li>';

	$pageConfig['first_tag_open'] = '<li class="paginate_button ">';
	$pageConfig['first_tag_close'] = '<li class="paginate_button ">';
	$pageConfig['last_tag_open'] = '<li class="paginate_button ">';
	$pageConfig['last_tag_close'] = '</li>';
	$pageConfig['cur_tag_open'] = '<li class="paginate_button active"><a href="#">';
	$pageConfig['cur_tag_close'] = '</a></li>';
	$ci->pagination->initialize($pageConfig);

	return array(
			"pages" => $ci->pagination->create_links(),
			"total" => $pageConfig["total_rows"],
			"total_page" => ceil($count / $limit),
			"page" => $offset / $limit + 1,
			"offset" => $offset,
			"limit" => $limit,
			"now" => $offset .' - ' . ($offset + $limit)
	);
}

function getAchieveArr()
{
	return array(0 => '成功', 1 => '失败');
}

function getAchieveVal($k)
{
	$sArr = getAchieveArr();

	return isset($sArr[$k]) ? $sArr[$k] : false;
}

function getStatusArr()
{
	return array(0 => '关闭', 1 => '开启');
}

function getStatusVal($k)
{
	$sArr = getStatusArr();

	return isset($sArr[$k]) ? $sArr[$k] : false;
}

function upload_file($FILES_file)
{
	//上传模板文件
	if (empty($FILES_file))
	{
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' file not select '.serialize(array($_FILES)));
		return -1;
	}
	
	include APPPATH . 'libraries/uploads.php';
	
	$upload_path = FCPATH.'resource/uploads/files/'.date('Y/md');
	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $upload_path '.serialize(array($upload_path)));
	
	$uploads = new uploads($FILES_file, $upload_path);
	//array(5) { ["name"]=> string(36) "9a1df89713b27687d0a628db6cb8c8bb.xls" ["size"]=> int(41472) ["type"]=> string(24) "application/vnd.ms-excel" ["width"]=> NULL ["height"]=> NULL }
	$file_infos = $uploads->get_file_infos();
	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' get_file_infos '.serialize(array($file_infos)));
	
	if ($file_infos['size'] <= 0)
	{
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $file_infos size err '.serialize(array($file_infos)));
		return -2;
	}
	
	//string(97) "/opt/www/cms_process/manage/resource/uploads/files/2015/0303/9a1df89713b27687d0a628db6cb8c8bb.xls"
	$file_path = $upload_path . '/'.$file_infos['name'];
	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $file_path '.serialize(array($file_path)));
	
	return $file_path;
}

function read_excel($file_path, $sheet = 0)
{
	include APPPATH . 'libraries/PHPExcel/PHPExcel.php';
	//默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
	$PHPReader = new PHPExcel_Reader_Excel2007();
	if(!$PHPReader->canRead($file_path))
	{
		$PHPReader = new PHPExcel_Reader_Excel5();
		if(!$PHPReader->canRead($file_path))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' canRead failse '.serialize(array($file_path)));
			return false;
		}
	}
	$objPHPExcel = $PHPReader->load($file_path);
		
	//读取工作表
	$currentSheet = $objPHPExcel->getSheet($sheet);
		
	//取得最大的列号
	$allColumn = $currentSheet->getHighestColumn();
	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' getHighestColumn '.serialize(array($allColumn)));
		
	//取得一共有多少行
	$allRow = $currentSheet->getHighestRow();
	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' getHighestRow '.serialize(array($allRow)));
	
	$data = array();
	
	//循环每一行
	for($currentRow = 1;$currentRow <= $allRow;$currentRow++)
	{
		$dataRow = array();
		
		//$currentSheet->getStyles()
		
		//循环每一列
		for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++)
		{
			$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
			log_message('info', __CLASS__ . ' ' . __FUNCTION__ . ' $currentColumn '.json_encode(array($currentRow, $currentColumn, $val)));
// 			$val1 = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getFormattedValue();/**ord()将字符转为十进制数*/
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $currentColumn1 '.json_encode(array($currentRow, $currentColumn, $val1)));
// 			$val1 = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getCalculatedValue();/**ord()将字符转为十进制数*/
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $currentColumn1 '.json_encode(array($currentRow, $currentColumn, $val1)));
			
// 			$val1 = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getOldCalculatedValue();/**ord()将字符转为十进制数*/
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $currentColumn1 '.json_encode(array($currentRow, $currentColumn, $val1)));
			
// 			$val1 = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getDataType();/**ord()将字符转为十进制数*/
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $currentColumn1 '.json_encode(array($currentRow, $currentColumn, $val1)));
			
// 			$val1 = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getCoordinate();/**ord()将字符转为十进制数*/
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $currentColumn1 '.json_encode(array($currentRow, $currentColumn, $val1)));
			
// 			$val1 = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValueBinder();/**ord()将字符转为十进制数*/
// 			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $currentColumn1 '.json_encode(array($currentRow, $currentColumn, $val1)));
			
			
			if (is_numeric($val))
			{
				$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getFormattedValue();/**ord()将字符转为十进制数*/
				
				//9.140000000000001
				$val_str = (string)$val;
				if (strpos($val_str, '.'))
				{
					$val_str_back = strstr($val_str, '.');
					$val_str_front = str_replace($val_str_back, '', $val_str);
					
					if (substr($val_str_back, -9, 9) == '000000001')
					{
						$val_str_back = str_replace('000000001', '', $val_str_back);
						$val_str_back = trim($val_str_back, '0');
						$val = $val_str_front . $val_str_back;
					}
				}
			}
			else
			{
				//$val = iconv('gbk','utf-8', (string)$val);
			}
			$dataRow[] = (string)$val;
		}
		
		$data[] = $dataRow;
	}
	
	return $data;
}

function base64_encode_($data)
{
	return str_replace(array('/','+','='), array('_a','_b','_c'), base64_encode($data));
}

function base64_decode_($data)
{
	return base64_decode(str_replace(array('_a','_b','_c'), array('/','+','='), $data));
}

/**
 * 获取文件夹下所有文件及文件夹
 * 
 * @param string $dir 文件夹路径 
 * @param number $level 文件夹深度
 * @return multitype:string
 */
function getAllByDir($dir, $childDir = '',$level = 99)
{
	$files = array();
	foreach(scandir($dir . $childDir) as $afile)
	{
		if(in_array($afile, array('.', '..', '.svn'))) continue;
		if(is_dir($dir . $childDir.'/'.$afile))
		{
			if ($level > 1)
			{
				$files_ = getAllByDir($dir, $childDir.'/'.$afile, $level - 1);
				if ($files_)
				{
					$files = array_merge($files, $files_);
				}
			}
			else 
			{
				$files[] = $childDir.'/' .$afile;
			}
		} else {
			
			$files[] = $childDir.'/'.$afile;
		}
	}
	
	return $files;
}


/**
 * 获取文件夹下所有文件及文件夹
 *
 * @param string $dir 文件夹路径
 * @param number $level 文件夹深度
 * @return multitype:string
 */
function getFilesByDir($dir, $childDir = '', $level = 99)
{
	$files = array();
	foreach(scandir($dir .$childDir) as $afile)
	{
		if(in_array($afile, array('.', '..', '.svn'))) continue;
		if(is_dir($dir .$childDir.'/'.$afile))
		{
			if ($level > 1)
			{
				$files_ = getFilesByDir($dir, $childDir.'/'.$afile, $level - 1);
				if ($files_)
				{
					$files = array_merge($files, $files_);
				}
			}
		} else {
			$files[] = $childDir.'/' .$afile;
		}
	}

	return $files;
}

/**
 * 获取文件夹下所有文件夹
 *
 * @param string $dir 文件夹路径
 * @param number $level 文件夹深度
 * @return multitype:string
 */
function getDirsByDir($dir, $childDir = '', $level = 99)
{
	$files = array();
	foreach(scandir($dir .$childDir) as $afile)
	{
		if(in_array($afile, array('.', '..', '.svn'))) continue;
		
		if(is_dir($dir .$childDir.'/'.$afile))
		{
			if ($level > 1)
			{
				$files_ = getDirsByDir($dir, $childDir.'/'.$afile, $level - 1);
				if ($files_)
				{
					$files = array_merge($files, $files_);
				}
			}
			else 
			{
				$files[] = $childDir.'/'.$afile;
			}
		}
	}

	return $files;
}

function scan_dirs($dir)
{
	$dirs = glob(rtrim($dir, '/') . '/*', GLOB_ONLYDIR);
	if (!$dirs)
	{
		return null;
	}
	
	$dirs_ = array();
	foreach ($dirs as $dir_)
	{
		$dir_item = array();
		$dir_item['path'] = $dir_;
		$dir_item['label'] = trim(strrchr($dir_, '/'), '/');
		$dir_item['children'] = scan_dirs($dir_);
		
		$dirs_[] = $dir_item;
	}
	
	return $dirs_;
}

function scan_files($dir)
{
	$files = glob(rtrim($dir, '/') . '/*.{*}', GLOB_BRACE);
	
	$files_ = array();
	foreach ($files as $file_)
	{
		$file_item = array();
		$file_item['path'] = $file_;
		$file_item['label'] = trim(strrchr($file_, '/'), '/');
	
		$files_[] = $file_item;
	}
	
	return $files_;
}


$siteKey = '';
function setSite($siteKey_ = '')
{
	global $siteKey;
	$siteKey = $siteKey_;
	return $siteKey;
}

function getSite()
{
	global $siteKey;
	return $siteKey;
}

function toutf8($var)
{
	if (is_array($var))
	{
		$var_ = array();
		foreach ($var as $key => $item)
		{
			$var_[$key] = toutf8($item);
		}
		return  $var_;
	}
	else
	{
		return iconv('gbk', 'utf-8', $var);
	}
}

function togbk($var)
{
	if (is_array($var))
	{
		$var_ = array();
		foreach ($var as $key => $item)
		{
			$var_[$key] = togbk($item);
		}
		return $var_;
	}
	else
	{
		return iconv('utf-8', 'gbk', $var);
	}
}



//对一个给定的二维数组按照指定的键值进行排序
function array_sort($arr,$keys,$type='asc')
{
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array;
}

/**
 * response
 *
 * @param var $data
 * @param var $errno
 * @param var $error
 */
function response($data, $errno = '', $message = '')
{
	$dataArr = array('errno' => empty($errno) ? '' : $errno, 'message' => $message, 'data' => $data);

	//?callback=jQuery213007410891919373785_1419918006860&
	//header("Content-type:text/html;charset=utf-8");
	$callback = !empty($_GET['callback']) ? $_GET['callback'] : '';
	$dataStr = json_encode($dataArr);
	if ($callback)
	{
		$dataStr = "$callback($dataStr);";
	}

	$CI = _get_object();
	$CI->output->set_content_type('application/json');
	$CI->output->set_output($dataStr);
	$CI->output->_display();

	$memory	= round(memory_get_usage() / 1024 / 1024, 2).'MB';
	log_message('error', ' -- response -- running info '.serialize(array('memory' => $memory, 'return' => $dataStr)));
	exit();
}

/**
 * 返回结果格式化
 * @param unknown $data
 * @param string $errno
 * @param string $error
 * @return multitype:string Ambigous <string, unknown>
 */
function result($data, $errno = null, $error = null)
{
	return array('errno' => $errno, 'message' => $error, 'data' => $data ? $data : '');
}


function bdtongji()
{
	$_hmt = new hm("d446c1e3c02db16a5be5a184e5e9117f");
	$_hmtPixel = $_hmt->trackPageView();
	return '<img src="'. $_hmtPixel .'" width="0" height="0" />';
}

function getIp()
{
	if(getenv('HTTP_CLIENT_IP')){
		$onlineip = getenv('HTTP_CLIENT_IP');
	}
	elseif(getenv('HTTP_X_FORWARDED_FOR')){
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif(getenv('REMOTE_ADDR')){
		$onlineip = getenv('REMOTE_ADDR');
	}
	else{
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}

	return $onlineip;
}

function is_post()
{
	return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
}

/**
 * json转码中文版
 *
 * @param int/string/array $var
 * @param bool $each : 内部使用变量, 外部无需传值
 * @return string
 */
function json_encode_cn($var, $each = false)
{
	$var_ = array();
	if (is_array($var))
	{
		$var_ = array();
		foreach ($var as $key => $val)
		{
			$var_[$key] = json_encode_cn($val, true);
		}
	}
	elseif ($var)
	{
		$var_ = urlencode($var);
	}

	//内循环
	if ($each)
	{
		return $var_;
	}

	//统一转码
	return urldecode(json_encode($var_));
}

/**
 * 将日期格式根据以下规律修改为不同显示样式
 * 小于1分钟 则显示多少秒前
 * 小于1小时，显示多少分钟前
 * 一天内，显示多少小时前
 * 3天内，显示前天22:23或昨天:12:23。
 * 超过3天，则显示完整日期。
 * @static
 * @param  $sorce_date 数据源日期 unix时间戳
 * @return void
 */
function getDateStyle($sorce_date)
{
	if (!is_int($sorce_date))
	{
		return false;
	}


	$nowTime = time();  //获取今天时间戳
	$timeHtml = ''; //返回文字格式
	$dur_time = $nowTime - $sorce_date;
	switch(true)
	{
		//一分钟
		case $dur_time < 60 :
			$timeHtml = $dur_time .'秒前';
			break;

			//小时
		case $dur_time < 3600 :
			$timeHtml = floor($dur_time/60) . '分钟前';
			break;

			//天
		case $dur_time < 86400:
			$timeHtml = floor($dur_time/3600) . '小时前';
			break;

			//昨天
		case $dur_time < 86400 * 2:
			$temp_time = date('H:i',$sorce_date);
			$timeHtml = '昨天'.$temp_time ;
			break;

			//前天
		case $dur_time < 86400 * 3:
			$temp_time  = date('H:i',$sorce_date);
			$timeHtml = '前天'.$temp_time ;
			break;

			//3天前
		case $dur_time < 86400 * 4:
			$timeHtml = '3天前';
			break;

		default:
			$timeHtml = date('Y-m-d',$sorce_date);
			break;

	}
	return $timeHtml;
}

/**
 * Validation Object
 *
 * Determines what the form validation class was instantiated as, fetches
 * the object and returns it.
 *
 * @access	private
 * @return	mixed
 */
if ( ! function_exists('_get_object'))
{
	function &_get_object()
	{
		$CI =& get_instance();

		return $CI;
	}
}