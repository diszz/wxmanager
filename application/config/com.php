<?php
//token v3
$config['token'] = array(
		//'app_key' => '888999001',
		//'app_secret' => '888999002',
		//'app_version' => '1.0',
		'key' => '806235b87fe148c3706ee3416eb2f01f',
		'tag' => '&^hl$hfody9', // 解密标识
);

//cache_helper配置, 通用缓存模块:数据模型等
$config['cache'] = array(
		'status' => 1,//0关闭,1开启,谨慎关闭,关闭后,很多功能受影响
		'adapter' => 'file',
);

//redis_helper配置
$config['redis'] = array(
		'status' => 0,//0关闭,1开启
		'host'=>'192.168.0.1',
		'port'=>6379,
);

//图片上传配置
$config['img_upload'] = array(
		'upload_path' => FCPATH . 'resource/uploads/images/'.date('Y/m/d/'),//
		'allowed_types' => 'gif|jpg|jpeg|png',
		'file_ext_tolower' => true,//如果设置为 TRUE ，文件后缀名将转换为小写
		'max_size' => '2048',//允许上传文件大小的最大值（单位 KB），设置为 0 表示无限制
		'max_width' => '2048',//图片的最大宽度（单位为像素），设置为 0 表示无限制
		'max_height' => '2048',//图片的最大高度（单位为像素），设置为 0 表示无限制
		'encrypt_name' => true //文件名将会转换为一个随机的字符串 如果你不希望上传文件的人知道保存后的文件名，这个参数会很有用
);
$config['zip_upload'] = array(
		'upload_path' => FCPATH . 'resource/uploads/zip/'.date('Y/m/d/'),//
		'allowed_types' => 'zip',
		'file_ext_tolower' => true,//如果设置为 TRUE ，文件后缀名将转换为小写
		'max_size' => '2048',//允许上传文件大小的最大值（单位 KB），设置为 0 表示无限制
		'max_width' => '2048',//图片的最大宽度（单位为像素），设置为 0 表示无限制
		'max_height' => '2048',//图片的最大高度（单位为像素），设置为 0 表示无限制
		'encrypt_name' => true //文件名将会转换为一个随机的字符串 如果你不希望上传文件的人知道保存后的文件名，这个参数会很有用
);
$config['file_upload'] = array(
		'upload_path' => FCPATH . 'resource/uploads/xls/'.date('Y/m/d/'),//
		'allowed_types' => 'xls',
		'file_ext_tolower' => true,//如果设置为 TRUE ，文件后缀名将转换为小写
		'max_size' => '2048',//允许上传文件大小的最大值（单位 KB），设置为 0 表示无限制
		'max_width' => '2048',//图片的最大宽度（单位为像素），设置为 0 表示无限制
		'max_height' => '2048',//图片的最大高度（单位为像素），设置为 0 表示无限制
		'encrypt_name' => true //文件名将会转换为一个随机的字符串 如果你不希望上传文件的人知道保存后的文件名，这个参数会很有用
);
$config['music_upload'] = array(
		'upload_path' => FCPATH . 'resource/uploads/music/'.date('Y/m/d/'),//
		'allowed_types' => 'mp3',
		'file_ext_tolower' => true,//如果设置为 TRUE ，文件后缀名将转换为小写
		'max_size' => '5048',//允许上传文件大小的最大值（单位 KB），设置为 0 表示无限制
		'max_width' => '2048',//图片的最大宽度（单位为像素），设置为 0 表示无限制
		'max_height' => '2048',//图片的最大高度（单位为像素），设置为 0 表示无限制
		'encrypt_name' => true //文件名将会转换为一个随机的字符串 如果你不希望上传文件的人知道保存后的文件名，这个参数会很有用
);
//客户端
$config['client_upload'] = array(
		'upload_path' => FCPATH . 'resource/uploads/client/'.date('Y/m/d/'),//
		'allowed_types' => 'apk',
		'file_ext_tolower' => true,//如果设置为 TRUE ，文件后缀名将转换为小写
		'max_size' => '500000',//允许上传文件大小的最大值（单位 KB），设置为 0 表示无限制
		'encrypt_name' => true //文件名将会转换为一个随机的字符串 如果你不希望上传文件的人知道保存后的文件名，这个参数会很有用
);
