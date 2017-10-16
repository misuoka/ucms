<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 会话设置
// +----------------------------------------------------------------------

return [
    'id'             => '',
    // SESSION_ID的提交变量,解决flash上传跨域
    'var_session_id' => '',
    // SESSION 前缀
    'prefix'         => 'think',
    // 驱动方式 支持redis memcache memcached
    'type'           => 'redis',

    'use_lock'       => true,

    'lock_timeout'   => 10,
    // 是否自动开启 SESSION
    'auto_start'     => true,
    // 客户端session_id的coockie键
    // 'name'           => '____hy____',
    // redis sessionkey的前缀
    'session_name'   => 'ss.tp51_',
    // 过期时间
    'expire'         => '3600',
];
