<?php
namespace app\index\behavior;

use app\index\model\Loginlog as Log;
use think\facade\Config;
use think\Request;

/**
 * 系统登录日志
 * 注：此行为必须用于
 */
class Loginlog
{
    public function run(Request $request, $params)
    {
        $post = $request->post();
        $get  = $request->get();
        $req  = strtolower(($request->controller() . '/' . $request->action()));

        // 属于登录请求则记录日志
        if ($req == strtolower(Config::get('login_req'))) {
            $log          = new Log();
            $log->message = $params['msg'];
            $log->save();
        }
    }
}
