<?php
namespace app\index\controller;

use Jstewmc\GetBrowser\GetBrowser;
use think\facade\Request;

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
        return Request::token();
    }

    public function test()
    {
        dump($_SESSION);
    }
}
