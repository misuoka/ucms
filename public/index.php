<?php

// [ 应用入口文件 ]

// 定义应用目录
// define('APP_PATH', __DIR__ . '/../application/');
// define('BIND_MODULE', 'index');
// // 加载框架引导文件
// require __DIR__ . '/../thinkphp/start.php';

// [ 应用入口文件 ]
// 定义应用目录
// define('APP_PATH', __DIR__ . '/../application/');
// // // define('BIND_MODULE', 'index');
// // // 加载框架引导文件
// require __DIR__ . '/../vendor/topthink/framework/start.php';

// [ 应用入口文件 ]
namespace think;

// ThinkPHP 引导文件
// 加载基础文件
require __DIR__ . '/../vendor/topthink/framework/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();
