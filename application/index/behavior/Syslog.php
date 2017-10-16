<?php
namespace app\index\behavior;

use think\facade\Config;
use think\Request;

/**
 * 系统操作日志记录
 * 注：此行为必须用于
 */
class Syslog
{
    public function run(Request $request, $params)
    {
        $this->request     = $request;
        $arr1              = Config::get('uncheck_logined') ?: []; // 不需要登录即可访问
        $arr2              = Config::get('uncheck_auth') ?: []; // 不需要权限即可访问
        $this->loginFilter = array_map('strtolower', $arr1);
        $this->authFilter  = array_map('strtolower', $arr2);

        if (($this->request->controller() . '/' . $this->request->action()) == 'User/login') {
            // echo '登录结束';

        }

        // var_dump($params->getData());die;

        // // 行为逻辑
        // if (!$this->loginedAuth()) {
        //     $this->error('您未登录系统，请登录', 'Index/login');
        // } else {
        //     $this->request->loginer = $this->getLoginer();
        // }

        // if (!$this->checkAuth()) {
        //     $this->error('您没有该权限', 'Index/login');
        // }
    }
}
