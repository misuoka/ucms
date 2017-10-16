<?php
namespace app\index\controller;

use think\Container;

class Open
{
    public function captcha()
    {
        $config = [
            'fontSize' => 40,
            'length'   => 4,
        ];
        $captcha = new \think\captcha\Captcha($config);
        return $captcha->entry('');
    }

    public function token()
    {
        return \think\facade\Request::token();
    }

    public function test()
    {
        \think\facade\Session::set('test', '设置值');
        $res = \think\facade\Session::get('test');
        // \think\facade\Session::set('test', '设置值');
        // $res = $_COOKIE['PHPSESSID'];
        // $res = '123';
        return $res;
    }

    /**
     * 并发参考请求
     */
    public function reference($i, $c = '')
    {
        $time = time();
        \think\facade\Session::set('reference', $time);
        $get = \think\facade\Session::get('reference');

        if ($get == '') {
            $result = 0;
        } else if ($time != $get) {
            $result = 1;
        } else {
            $result = 2;
        }

        return json([
            'i'      => $i,
            'c'      => $c,
            'set'    => $time,
            'get'    => $get,
            'result' => $result,
        ]);
    }

    /**
     * 刷新token方法
     */
    public function mytoken($i)
    {
        $token = md5(create_guid());
        \think\facade\Session::set('__mytoken__', $token);
        $get = \think\facade\Session::get('__mytoken__');

        if ($get == '') {
            $result = 0;
        } else if ($token != $get) {
            $result = 1;
        } else {
            $result = 2;
        }

        return json([
            'i'      => $i,
            'result' => $result,
            'set'    => $token,
            'get'    => $get,
        ]);
    }

    /**
     * 验证token的方法
     */
    public function checkToken($i)
    {
        list($name, $result, $sessionToken) = ['__mytoken__', 0, ''];

        $request = Container::get('request');
        $session = Container::get('session');
        $data    = $request->post();

        if ($session->has($name)) {

            $sessionToken = $session->get($name);
            // 令牌验证
            if ($sessionToken === $data[$name]) {
                $result = 2;
            } else {
                $result = 1;
            }

            // 删除TOKEN
            $session->delete($name);
        }

        return json([
            'i'            => $i,
            'result'       => $result, // 0,没有;1,不等;2,相等
            'postToken'    => $data[$name],
            'sessionToken' => $sessionToken,
        ]);
    }
}
