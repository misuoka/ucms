<?php
namespace app\index\behavior;

use think\facade\Config;
use think\facade\Session;
use think\Request;

/**
 * 权限验证行为
 * 注：此行为必须用于 module_init (模块初始化) 处，否则 Config 读取不到 此模块中的 过滤权限
 */
class Authorize
{
    use \traits\controller\Jump;

    private $request;
    private $loginFilter = [];
    private $authFilter  = [];

    public function run(Request $request, $params)
    {
        $this->request     = $request;
        $arr1              = Config::get('uncheck_logined') ?: []; // 不需要登录即可访问
        $arr2              = Config::get('uncheck_auth') ?: []; // 不需要权限即可访问
        $this->loginFilter = array_map('strtolower', $arr1);
        $this->authFilter  = array_map('strtolower', $arr2);

        // 行为逻辑
        if (!$this->loginedAuth()) {
            $this->error('您未登录系统，请登录', 'Index/login');
        } else {
            $this->request->loginer = $this->getLoginer();
        }

        if (!$this->checkAuth()) {
            $this->error('您没有该权限', 'Index/login');
        }
    }

    private function getLoginer()
    {
        // $userId = Session::get('userId');
        // $loginer = Systemuser::get($userId);
        // 如果 session 是用redis存储的，可以把整个 loginer 存储到session中
        return Session::get('loginer');
    }

    /** 需登录权限验证 */
    private function loginedAuth()
    {
        $arr = $this->loginFilter;
        $com = $this->request->controller() . '/*';
        $url = $this->request->controller() . '/' . $this->request->action();
        $arr = array_map('strtolower', $arr);

        return in_array(strtolower($com), $arr)
        || in_array(strtolower($url), $arr)
        || Session::has('loginer');
    }

    /** 检查已登录用户的权限 */
    private function checkAuth()
    {
        $arr = array_merge($this->loginFilter, $this->authFilter);
        $com = $this->request->controller() . '/*';
        $url = $this->request->controller() . '/' . $this->request->action();
        // TODO: 获得当前用户的权限
        // $auth = (new Menu())->getAuth($this->request->loginer['suid']);

        return in_array(strtolower($com), $arr)
        || in_array(strtolower($url), $arr)
        || in_array(strtolower($url), array_map('strtolower', $auth));
    }
}
