<?php
/**
 * 红包管理
 * 
 * @copyright www.locojoy.com
 * @author lihuixu@joyogame.com
 * @version v1.0 2015.02.05
 */
class Redpack_record extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('redpack_model', 'redpack_record_model'));
    }
    
    public function index($cur_redpack = 0, $cur_status = 0, $offset = 0)
    {
    	$offset = ($offset < 0 ? 0 : $offset);
    	$limit = 15;
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$cur_redpack && $params['redpack_id'] = $cur_redpack;
    	$cur_status && $params['status'] = $cur_status;
    	$list = $this->redpack_record_model->getList($params, null, $offset, $limit);
    	$count = $this->redpack_record_model->getCount($params);
    	
    	$pagination = make_page($count, $offset, $limit, $cur_redpack.'/'.$cur_status);
    	
    	$params = array();
    	$params['site_id'] = get_siteid();
    	$redpackList = $this->redpack_model->getList($params, null, 0, 9999);
    	
    	//下载文件
    	$file_exist = false;
    	$file = $this->input->get('file', true);
    	if ($file)
    	{
    		$file_ = base64_decode_($file);
    		$file_exist = file_exists($file_);
    	}
    	
    	return $this->load->view("admin/redpack_record/index", array(
    			'list' => $list, 
    			'pagination' => $pagination,
    			'redpackList' => $redpackList,
    			'cur_redpack' => $cur_redpack,
    			'cur_status' => $cur_status,
    			'file' => $file,
    			'file_exist' => $file_exist
    	));
    }
    
    public function export_record()
    {
    	$redpack_id = $this->input->get('redpack_id', true);
    	$status = $this->input->get('status', true);
    
    	$exportFile = FCPATH . 'resource/redpack-record-'.date("Y-m-d-H-i-s").".xls";
    
    	$cmd = "nohup php ".FCPATH."index.php admin/command/run_export_redpack_record '".base64_encode_($exportFile)."' '".get_siteid()."' '".$redpack_id."' '".$status."' > nohup.log 2>&1 &";
    	@exec($cmd);
    	log_message('error', __CLASS__ . ' ' . __FUNCTION__ . ' exec '.json_encode(array($cmd)));
    
    	$this->session->set_flashdata('success', lang('cmd_running_succ'));
    	return redirect('admin/redpack_record/index/'.$redpack_id.'/'.$status.'?file='.base64_encode_($exportFile));
    }
}
?>