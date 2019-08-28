<?php


function get_sessionid()
{
	$userData = get_sessiondata();

	if (empty($userData['session_id']))
	{
		return null;
	}

	return $userData['session_id'];
}


function get_userid()
{
	$userInfo = get_userinfo();
	if (empty($userInfo['user_id']))
	{
		return 0;
	}

	return $userInfo['user_id'];
}

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

function get_userinfo()
{
	$userData = get_sessiondata();

	if (empty($userData['user']))
	{
		return null;
	}
	$userInfo = $userData['user'];

	return $userInfo;
}

function get_userapp()
{
	$userData = get_sessiondata();

	if (empty($userData['app']))
	{
		return null;
	}
	$userApp = $userData['app'];

	return $userApp;
}


/**
 * 面向所有用户
 *
 * @param str $path
 */
function check_login($path)
{
	$exceptionPaths = array('login');
	 
	if (in_array(trim($path, '/'), $exceptionPaths))
	{
		return true;
	}
	 
	if (!get_userinfo())
	{
		return false;
	}
	
	return true;
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