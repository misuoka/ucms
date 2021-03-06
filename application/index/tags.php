<?php

// 应用行为扩展定义文件
return [
    // 应用初始化
    'app_init'       => [],
    // 应用开始
    'app_begin'      => [],
    // 模块初始化
    'module_init'    => ['app\\index\\behavior\\Authorize'],
    // 操作开始执行
    'action_begin'   => [],
    // 视图内容过滤
    'view_filter'    => [],
    // 日志写入
    'log_write'      => ['app\\index\\behavior\\Syslog'],
    // 应用结束
    // 'app_end'      => ['app\\index\\behavior\\Loginlog'],

    // 登录日志
    'loginlog_write' => ['app\\index\\behavior\\Loginlog'],
    'response_send'  => ['app\\index\\behavior\\Syslog'],
    // 'response_end' => ['app\\index\\behavior\\Syslog'],
];
