<?php
/**
 * 命令控制器
 *
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 *
 */
class Command extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index($p)
	{
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' total '.serialize(array($p)));
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' total '.serialize(array(time())));
		
		sleep(300);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' total '.serialize(array(time())));
	}
	
	public function run_make_redpack_code($site_id, $redpack_id, $total_people, $total_money, $min_value, $max_value)
	{
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
			
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' t1 '.serialize(array(microtime(true))));
			
		$money_arr = make_randmoneys($total_people, $total_money, $min_value, $max_value);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' t2 '.serialize(array(microtime(true), count($money_arr))));
		
		$key_arr = array();
		$total = count($money_arr);
		$itemCount = 1000;
		$n = ceil( $total / $itemCount);
		for ($i=1;$i<=$n;$i++)
		{
			if ($total - count($key_arr) >= $itemCount)
			{
				$arr = make_uniqids($itemCount, get_setting('redpack_digit'));//礼包码是9位,红包码是10位
			}
			else 
			{
				$arr = make_uniqids($total - count($key_arr), get_setting('redpack_digit'));//礼包码是9位,红包码是10位
			}
			
			$key_arr = array_merge($arr, $key_arr);
		}
		//$key_arr = redpack_uniqid();
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' t3 '.serialize(array(microtime(true), count($key_arr))));
			
		$data_arr = array_combine($key_arr, $money_arr);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' t4 '.serialize(array(microtime(true), count($data_arr))));
		
		$this->load->model(array('redpack_model', 'redpack_code_model'));
		
		$total_money_ = 0;
		$total_code_ = 0;
		foreach ($data_arr as $k => $v)
		{
			$data_item = array();
			$data_item['site_id'] = $site_id;
			$data_item['redpack_id'] = $redpack_id;
			$data_item['content'] = $k;
			$data_item['money'] = $v;
			$data_item['status'] = 0;
			$data_item['create_time'] = time();
			$result = $this->redpack_code_model->insertInfo($data_item);
			
			$total_money_ += $v;
			$total_code_ ++;
		
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' t5 '.serialize(array(microtime(true), count($data_arr))));
		}
		
		$data = array();
		$data['make_money'] = (int)$total_money_;
		$data['make_code'] = (int)$total_code_;
		$result = $this->redpack_model->increment($redpack_id, $data);
		
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array(microtime(true), count($data))));
	}
	
	public function run_clean_redpack_code($site_id, $redpack_id)
	{
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
			
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' t1 '.serialize(array(microtime(true))));
			
		$this->load->model(array('redpack_model', 'redpack_code_model'));
		
		
		$params = array();
		$params['site_id'] = $site_id;
		$params['redpack_id'] = $redpack_id;
		$count = $this->redpack_code_model->getCount($params);
		
		$once = 999;
		$total = ceil($count/$once);
		
		for ($i=1;$i<=$total;$i++)
		{
			$list = $this->redpack_code_model->getList($params, null, 0, $once, null, 0, false);
			
			if ($list)
			{
				foreach ($list as $item)
				{
					$result = $this->redpack_code_model->deleteInfo($item['redpack_code_id']);
				}
			}
			
		}
		
		$data = array();
		$data['make_money'] = (int)0;
		$data['make_code'] = (int)0;
		$result = $this->redpack_model->updateInfo($redpack_id, $data);
			
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array(microtime(true))));
	}
	
	
	public function run_export_redpack_code($exportFile = null, $site_id = null, $redpack_id = null, $type = null)
	{
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
	
		if (!$exportFile)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $exportFile null '.serialize(array($exportFile)));
			exit();
		}
	
		$exportFile = base64_decode_($exportFile);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $exportFile '.serialize(array($exportFile)));
	
		$this->load->library("PHPExcel/PHPExcel");
		$this->load->library("PHPExcel/PHPExcel/IOFactory");
		$objPhpExcel = new PHPExcel();
		$objPhpExcel->getProperties()->setTitle("export")->setDescription("none");
		$objPhpExcel->setActiveSheetIndex(0);
	
		//视觉样式开始
		$objPhpExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(9);//字体
		$objPhpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPhpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPhpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPhpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPhpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPhpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPhpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$objPhpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$objPhpExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('FF808080');
	
		//栏目
		$columns  = array("红包活动码", "金额", "创建日期", "用户ID", "用户昵称", "用户获取时间");
		foreach ($columns as $i => $item)
		{
			$objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $item);
		}
		
		$this->load->model(array('weixin_model'));
	
		//获取数据总数
		$params = array();
		$params['site_id'] = $site_id;
		$redpack_id && $params['redpack_id'] = $redpack_id;
		$type && $params['open_id'] = ($type == 1 ?'_is_exist' : '_not_exist');
		$result = $this->weixin_model->getRedpackCodeCount($params);
		$count = $result['data'];
		if ($count < 1)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' getRedpackCodeCount $count < 1 '.serialize(array($count)));
			exit();
		}
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' total '.serialize(array($count)));
	
		//每次10000条,循环提取
		$onceLimit = 100;
		$cur_row = 2;
		for ($i = 0; $i < ceil($count/$onceLimit);$i++)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' loop '.json_encode(array($i, ceil($count/$onceLimit))));
		
			$params = array();
			$params['site_id'] = $site_id;
			$redpack_id && $params['redpack_id'] = $redpack_id;
			$type && $params['open_id'] = ($type == 1 ?'_is_exist' : '_not_exist');
			$params['offset'] = $i * $onceLimit;
			$params['limit'] = $onceLimit;
			$result = $this->weixin_model->getRedpackCodeList($params);
			$list = $result['data'];
	
			foreach ($list as $k => $item)
			{
				$objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $cur_row, (string)$item["content"]);
				$objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $cur_row, (string)$item["money"]);
				$objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $cur_row, (string)date('Y-m-d H:i:s', $item['create_time']));
				$objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $cur_row, (string)$item['open_id']);
				$objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $cur_row, (string)(!empty($item['open_id']) ? $item['user_info']['nickname'] : ''));
				$objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $cur_row, (string)(!empty($item['get_time']) ? date('Y-m-d H:i:s', $item['get_time']) : ''));
				// $objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $cur_row, (string)$item["mail_count"]);
				// $objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $cur_row, (string)$item["valid_count"]);
				// $objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $cur_row, (string)$item["reward_count"]);
				// $objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $cur_row, (string)date('Y-m-d H:i:s', (int)$item["create_time"]));
			
				$cur_row++;
			}
			
			//防止数据接口堵塞
			sleep(1);
		}
	
		$exportFileName = trim(strrchr($exportFile, '/'), '/');
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $exportFileName '.json_encode(array($exportFileName)));
	
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $exportFileName . '"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPhpExcel, 'Excel5');
		//$objWriter->save('php://output');
		$objWriter->save($exportFile);
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array($exportFile)));
	}
	
	
	
	public function run_export_redpack_record($exportFile = null, $site_id = null, $redpack_id = null, $status = null)
	{
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
	
		if (!$exportFile)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $exportFile null '.serialize(array($exportFile)));
			exit();
		}
	
		$exportFile = base64_decode_($exportFile);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $exportFile '.serialize(array($exportFile)));
	
		$this->load->model("weixin_model");
		include_once APPPATH .'/libraries/php_excel.php';
		$php_excel = new php_excel();
	
		$columns  = array("用户", "昵称", "金额", "支付号", "错误号","错误内容","兑换时间");
		$php_excel->write_headers($columns);
	
	
		//获取数据总数
		$params = array();
		$params['site_id'] = $site_id;
		$redpack_id && $params['redpack_id'] = $redpack_id;
		$status && $params['status'] = $status;
		$result = $this->weixin_model->getRedpackRecordCount($params);
		$count = $result['data'];
		if ($count < 1)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $count < 1 '.serialize(array($count)));
			exit();
		}
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' total '.serialize(array($count)));
	
		//每次10000条,循环提取
		$onceLimit = 50;
		$row = 2;
		for ($i = 0; $i < ceil($count/$onceLimit);$i++)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' loop '.json_encode(array($i, ceil($count/$onceLimit))));
		
			$params = array();
			$params['site_id'] = $site_id;
			$redpack_id && $params['redpack_id'] = $redpack_id;
			$status && $params['status'] = $status;
			$params['offset'] = $i * $onceLimit;
			$params['limit'] = $onceLimit;
			$result = $this->weixin_model->getRedpackRecordList($params);
			$list = $result['data'];
		
			foreach ($list as $k => $item)
			{
				$data = array(
					(string)$item['open_id'],
					(string)(''),//!empty($item["user_info"]['nickname']) ? $item["user_info"]['nickname'] : 
					(string)$item['money'],
					(string)(!empty($item["redpack_code"]) ? $item["redpack_code"] : ''),
					(string)(!empty($item["errno"]) ? $item["errno"] : ''),
					(string)(!empty($item["error"]) ? $item["error"] : ''),
					(string)date('Y-m-d H:i:s', $item['create_time'])
				);
				$php_excel->write_data($data);
			}
		}
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array($exportFile)));
		$php_excel->write_file($exportFile);
	}
	
	public function run_import_redpack_limitedlist($redpack_id = null, $file_path = null, $limit_userkey_column = null)
	{
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
		
		$file_path = base64_decode_($file_path);
		
		//读取excel文件数据
		$excel_data = read_excel($file_path, 0);
		if (!$excel_data)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' read_excel empty '.serialize(array($file_path, 0)));
			exit();
		}
		
		$this->load->model(array('weixin_model'));
		
		$excel_data_ = array();
		$is_clean = true;
		foreach ($excel_data as $key => $columns)
		{
			$user_key = $columns[$limit_userkey_column];
		
			//去除栏目行
			if (!preg_match('/[\w\-]+/', $user_key))
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' column header continue '.serialize(array($key, $columns)));
				continue;
			}
		
			$excel_data_[] = $user_key;
				
			//分批插入
			if (count($excel_data_) > 100)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $item data '.serialize(array($key, count($excel_data), $columns)));
				
				$params = array();
				$params['redpack_id'] = $redpack_id;
				$params['user_keys'] = $excel_data_;
				$is_clean && $params['is_clean'] = 1;
				$result = $this->weixin_model->importRedpackUserLimitedList($params);
				if ($result['errno'])
				{
		
				}
		
				$excel_data_ = array();
				$is_clean = false;
				
				sleep(1);
			}
		}
		
		if (count($excel_data_) > 0)
		{
			$params = array();
			$params['redpack_id'] = $redpack_id;
			$params['user_keys'] = $excel_data_;
			$is_clean && $params['is_clean'] = 1;
			$result = $this->weixin_model->importRedpackUserLimitedList($params);
			if ($result['errno'])
			{
					
			}
			$is_clean = false;
		}
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array($file_path)));
	}
	
	public function run_import_keyword_code($site_id = null, $keyword_id = null, $file_path = null, $code_column = null)
	{
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
	
		$file_path = base64_decode_($file_path);
	
		//读取excel文件数据
		$excel_data = read_excel($file_path, 0);
		if (!$excel_data)
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' read_excel empty '.serialize(array($file_path, 0)));
			exit();
		}
	
		$this->load->model(array('weixin_model'));
	
		$excel_data_ = array();
		foreach ($excel_data as $key => $columns)
		{
			//log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $item data '.serialize(array($columns)));

			if (empty($columns[$code_column]))
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' column empty continue '.serialize(array($key, $columns)));
				continue;
			}

			$code = $columns[$code_column];

			//去除栏目行
			if (!preg_match('/\w+/', $code))
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' column header continue '.serialize(array($key, $columns)));
				continue;
			}

			//主关键词
			$params = array();
			$params['site_id'] = $site_id;
			$params['keyword_id'] = $keyword_id;
			$params['content'] = $code;
			$excel_data_[] = $params;
			
			if (count($excel_data_) > 50)
			{
				$params = array();
				$params['data'] = $excel_data_;
				$result = $this->weixin_model->importKeywordCode($params);
				if ($result['errno'])
				{
						
				}
			
				$excel_data_ = array();
			}
		}
	
		if (count($excel_data_) > 0)
		{
			$params = array();
			$params['data'] = $excel_data_;
			$result = $this->weixin_model->importKeywordCode($params);
			if ($result['errno'])
			{
					
			}
		}
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array($file_path)));
	}
	
	public function run_make_code($site_id = null, $code_id = null, $count = 100)
	{
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
	
		$data_arr = make_uniqids($count, get_setting('code_digit'));//礼包码是9位,红包码是10位
	
		$this->load->model(array('code_model', 'code_item_model'));
		$count = 0;
		foreach ($data_arr as $k => $line_str)
		{
			$line_str = trim($line_str);
			if (!$line_str)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $line_str empty '.serialize(array($k, $line_str)));
				continue;
			}
				
			//插入数据
			$params = array();
			$params['site_id'] = $site_id;
			$params['code_id'] = $code_id;
			$params['content'] = $line_str;
			$params['status'] = 0;
			$params['create_time'] = time();
			$result = $this->code_item_model->insertInfo($params);
				
			$count++;
		}
	
		//更新code统计数
		$params = array();
		$params['total_count'] = $count;
		$this->code_model->increment($code_id, $params);
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array($count)));
	}
	
	public function run_import_code($site_id = null, $code_id = null, $file_path = null)
	{
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
		
		$file = base64_decode_($file_path);
		if (!file_exists($file))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' file_notexists '.serialize(array($file, $file_path)));
		}
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' params data '.serialize(array($file)));
		
		//读取临时文件
		$data_str = read_file($file);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $file data '.serialize(array(strlen($data_str), $file)));
		
		//数据字符串转化为数组
		$data_arr = array();
		if (strpos($data_str, "\r\n"))
		{
			$data_arr = explode("\r\n", $data_str);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' explode \r\n '.serialize(array(count($data_arr), $file)));
		}
		elseif (strpos($data_str, "\r"))
		{
			$data_arr = explode("\r", $data_str);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' explode \r '.serialize(array(count($data_arr), $file)));
		}
		elseif (strpos($data_str, "\n"))
		{
			$data_arr = explode("\n", $data_str);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' explode \n '.serialize(array(count($data_arr), $file)));
		}
		else
		{
			$data_arr = array($data_str);
		}
		
		$this->load->model(array('code_model', 'code_item_model'));
		$count = 0;
		foreach ($data_arr as $k => $line_str)
		{
			$line_str = trim($line_str);
			if (!$line_str)
			{
				log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $line_str empty '.serialize(array($k, $line_str)));
				continue;
			}
			
			//插入数据
			$params = array();
			$params['site_id'] = $site_id;
			$params['code_id'] = $code_id;
			$params['content'] = $line_str;
			$params['status'] = 0;
			$params['create_time'] = time();
			$result = $this->code_item_model->insertInfo($params);
			
			$count++;
		}
		
		//更新code统计数
		$params = array();
		$params['total_count'] = $count;
		$this->code_model->increment($code_id, $params);
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array($file_path)));
	}
	
	public function run_clean_code($site_id = null, $code_id = null)
	{
		//不限执行时间
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
			
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' t1 '.serialize(array(microtime(true))));
			
		$this->load->model(array('code_model', 'code_item_model'));
		
		//--清空关键词-------------------------------------
		
		$params = array();
		$params['site_id'] = $site_id;
		$params['code_id'] = $code_id;
		$count = $this->code_item_model->getCount($params);
		
		$once = 999;
		$times = ceil($count/$once);
		
		for ($i=1;$i<=$times;$i++)
		{
			$params = array();
			$params['site_id'] = $site_id;
			$list = $this->code_item_model->getList($params, null, 0, $once);
			
			if ($list)
			{
				foreach ($list as $item)
				{
					$this->code_item_model->deleteInfo($item['code_item_id']);
				}
			}
		}
		
		//更新code统计数
		$params = array();
		$params['total_count'] = 0;
		$this->code_model->updateInfo($code_id, $params);
		
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array(microtime(true))));
	}
	
	//导入关键词
	public function run_import_keyword($site_id = null, $file_path = null)
	{
		$file = base64_decode_($file_path);
		if (!file_exists($file))
		{
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' file_notexists '.serialize(array($file, $file_path)));
		}
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' params data '.serialize(array($file)));
	
		//读取临时文件
		$data_str = read_file($file);
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' $file data '.serialize(array(strlen($data_str), $file)));
	
		//数据字符串转化为数组
		$data_arr = array();
		if (strpos($data_str, "\r\n"))
		{
			$data_arr = explode("\r\n", $data_str);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' explode \r\n '.serialize(array(count($data_arr), $file)));
		}
		elseif (strpos($data_str, "\r"))
		{
			$data_arr = explode("\r", $data_str);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' explode \r '.serialize(array(count($data_arr), $file)));
		}
		elseif (strpos($data_str, "\n"))
		{
			$data_arr = explode("\n", $data_str);
			log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' explode \n '.serialize(array(count($data_arr), $file)));
		}
		else
		{
			$data_arr = array($data_str);
		}
	
		$this->load->model(array('keyword_model', 'keyword_alias_model'));
		$data_ = array();
		foreach ($data_arr as $k => $line_str)
		{
			$line_str = trim($line_str);
			
			//每一行的格式:关键词 说明
			if (strpos($line_str, ' '))
			{
				list($name, $content) = explode(' ', $line_str);
			}
			else
			{
				$name = $content = $line_str;
			}
			
			//插入数据
			$params = array();
			$params['site_id'] = $site_id;
			$params['name'] = $name;
			$params['content'] = $content;
			$params['object'] = 0;
			$params['type'] = (string)'text';
			$params['sort'] = (int)0;
			$keyword_id = $this->keyword_model->insertInfo($params);
			
			$data = array();
			$data['site_id'] = $site_id;
			$data['keyword_id'] = $keyword_id;
			$data['name'] = $name;
			$this->keyword_alias_model->insertInfo($data);
			
		}
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array($file_path)));
	}
	
	public function run_clean_keyword($site_id = null)
	{
		//不限执行时间
		set_time_limit(0);
		//设定内存上限！
		ini_set('memory_limit','2560M');
			
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' t1 '.serialize(array(microtime(true))));
			
		$this->load->model(array('keyword_model', 'keyword_relation_model', 'keyword_alias_model'));
		
		//--清空关键词-------------------------------------
		
		$params = array();
		$params['site_id'] = $site_id;
		$count = $this->keyword_model->getCount($params);
		
		$once = 999;
		$times = ceil($count/$once);
		
		for ($i=1;$i<=$times;$i++)
		{
			$params = array();
			$params['site_id'] = $site_id;
			$list = $this->keyword_model->getList($params, null, 0, $once);
			
			if ($list)
			{
				foreach ($list as $item)
				{
					$this->keyword_model->deleteInfo($item['keyword_id']);
					
					//清空当前别名表
					$attrs = array();
					$attrs['keyword_id'] = $item['keyword_id'];
					$alias_list = $this->keyword_alias_model->getList($attrs, null, 0, 9999);
					if ($alias_list)
					{
					    foreach ($alias_list as $item)
					    {
					        $this->keyword_alias_model->deleteInfo($item['keyword_alias_id']);
					    }
					}
					
					//--清空关联关系-------------------------------------
					$params = array();
					$params['keyword_id'] = $item['keyword_id'];
					$list1 = $this->keyword_relation_model->getList($params, null, 0, 999);
					if ($list1)
					{
						foreach ($list1 as $item1)
						{
							$this->keyword_relation_model->deleteInfo($item1['keyword_relation_id']);
						}
					}
					
					$params = array();
					$params['child_keyword_id'] = $item['keyword_id'];
					$list1 = $this->keyword_relation_model->getList($params, null, 0, 999);
					if ($list1)
					{
						foreach ($list1 as $item1)
						{
							$this->keyword_relation_model->deleteInfo($item1['keyword_relation_id']);
						}
					}
					
				}
			}
		}
	
		log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' run succ '.json_encode(array(microtime(true))));
	}
}