<?php
namespace app\index\controller;

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

    }
}
