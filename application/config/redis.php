<?php
//---正常redis配置-------------------------------------------------

$config = array(
    'socket_type' => 'tcp',
    'host' => '127.0.0.1',
    'port' => 6379,
    'timeout' => 1200
);

//---主从redis配置-------------------------------------------------

// $config['master'] = array(
//     'socket_type' => 'tcp',
//     'host' => '127.0.0.1',
//     'port' => 6379,
//     'timeout' => 1200
// );

// $config['slave'] = array(
//     array(
//         'socket_type' => 'tcp',
//         'host' => '127.0.0.1',
//         'port' => 6379,
//         'timeout' => 1200
//     )
// );

//-------------------------------------------------------