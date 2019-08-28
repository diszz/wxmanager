<?php

function valid_mongoid_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|exact_length[24]|regex_match[/^[0-9a-f]+$/]';
	}
	return 'trim|exact_length[24]|regex_match[/^[0-9a-f]+$/]';
}

function valid_page_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|integer|min_length[1]|max_length[100]';
	}
	return 'trim|integer|min_length[1]|max_length[100]';
}
function valid_offset_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|integer|min_length[0]|max_length[1000]';
	}
	return 'trim|integer|min_length[0]|max_length[1000]';
}
function valid_limit_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|integer|min_length[1]|max_length[100]';
	}
	return 'trim|integer|min_length[1]|max_length[100]';
}
function valid_mobile_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|integer|exact_length[11]|xss_clean';
	}
	return 'trim|integer|exact_length[11]|xss_clean';
}
function valid_time_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|integer|exact_length[10]';
	}
	return 'trim|integer|exact_length[10]';
}
function valid_number_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|integer';
	}
	return 'trim|integer';
}
function valid_int_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|integer';
	}
	return 'trim|integer';
}

function valid_commentContent_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|min_length[3]|max_length[1000]';
	}
	return 'trim|min_length[3]|max_length[1000]';
}
function valid_articleTitle_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|min_length[3]|max_length[30]';
	}
	return 'trim|min_length[3]|max_length[30]';
}
function valid_articleContent_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|min_length[3]|max_length[1000]';
	}
	return 'trim|min_length[3]|max_length[1000]';
}
function valid_string_rule($min = 0, $max = 30,$required = false)
{
	if ($required)
	{
		return 'trim|required|min_length['.$min.']|max_length['.$max.']';
	}
	return 'trim|min_length['.$min.']|max_length['.$max.']';
}
function valid_text_rule($required = false)
{
	if ($required)
	{
		return 'trim|required';
	}
	return 'trim';
}
function valid_email_rule($required = false)
{
	if ($required)
	{
		return 'trim|required|valid_email';
	}
	return 'trim|valid_email';
}