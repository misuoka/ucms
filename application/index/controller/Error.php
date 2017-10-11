<?php
namespace app\index\controller;

use think\Request;

class Error
{
    public function _empty(Request $request)
    {
        $controller = $request->controller();
        $action     = $request->action();
        return '当前请求[ ' . $controller . '/' . $action . ' ]不存在';
    }
}
