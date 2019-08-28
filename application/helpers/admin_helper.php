<?php
function get_sessiondata()
{
	$ci = _get_object();
	$sessionData = $ci->session->all_userdata();

	if (!$sessionData)
	{
		return null;
	}

	return $sessionData;
}

function get_admininfo($key = '')
{
	$adminData = get_sessiondata();

	if (empty($adminData['admin_info']))
	{
		return null;
	}
	$adminInfo = $adminData['admin_info'];

	return $key && isset($adminInfo[$key]) ? $adminInfo[$key] : $adminInfo;
}

function get_adminid()
{
    $adminInfo = get_admininfo();
    if (empty($adminInfo['admin_id']))
    {
        return null;
    }

    return $adminInfo['admin_id'];
}

/**
 * 面向所有用户
 *
 * @param str $path
 */
function check_adminlogin()
{
	if (!get_admininfo())
	{
		return false;
	}
	
	return true;
}

function check_auth($access)
{
    $userInfo = get_admininfo();
    
    if(!isset($userInfo['accesses']))
    {
        return true;
    }

    if (in_array($access, $userInfo['accesses']))
    {
        return true;
    }

    return false;
}

function refresh_adminsites()
{
    $admin_info = get_admininfo();
    if (!$admin_info)
    {
        return false;
    }
    
    $ci = _get_object();
    $admin_sites = array();
    if ($admin_info['is_superadmin'])
    {
        $site_list = $ci->site_model->getList(null, array('site_id' => 'desc'), 0, 999);
        if ($site_list)
        {
            foreach ($site_list as $item)
            {
                $admin_sites[$item['site_id']] = $item['name'];
            }
        }
    }
    else
    {
        $ci->load->model('admin_site_model');
        $where = array('admin_id' => $admin_info['admin_id']);
        $order = array('site_id' => 'asc');
        $admin_site_list = $ci->admin_site_model->getList($where, $order, 0, 99);
        if ($admin_site_list)
        {
            foreach ($admin_site_list as $item)
            {
                $site_info = $ci->site_model->getInfo($item['site_id']);
                $admin_sites[$item['site_id']] = $item['name'];
            }
        }
    }
    $ci->session->set_userdata(array('admin_sites' => $admin_sites));
    
}

function get_adminsites()
{
    $adminData = get_sessiondata();

    if (empty($adminData['admin_sites']))
    {
        return null;
    }
    $admin_sites = $adminData['admin_sites'];

    return $admin_sites;
}

function get_siteinfo()
{
    $ci = _get_object();
    $adminData = $ci->session->all_userdata();

    if (!$adminData)
    {
        return null;
    }

    if (empty($adminData['site_info']))
    {
        return null;
    }

    return $adminData['site_info'];
}

function get_siteid()
{
    $ci = _get_object();
    $adminData = $ci->session->all_userdata();

    if (!$adminData)
    {
        return null;
    }

    if (empty($adminData['site_info']))
    {
        return null;
    }
    $siteInfo = $adminData['site_info'];

    if (empty($siteInfo['site_id']))
    {
        return null;
    }

    return $siteInfo['site_id'];
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