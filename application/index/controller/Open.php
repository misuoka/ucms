<?php
namespace app\index\controller;

use Jstewmc\GetBrowser\GetBrowser;
use think\facade\Request;

class Open
{
    public function captcha($_dc = '')
    {
        $config = [
            'fontSize' => 40,
            'length'   => 4,
        ];
        $captcha = new \think\captcha\Captcha($config);
        return $captcha->entry($_dc);
    }

    public function test()
    {

        // define the user-agent
        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) '
            . 'AppleWebKit/601.6.17 (KHTML, like Gecko) Version/9.1.1 '
            . 'Safari/601.6.17';

        // instantiate the service
        $service   = new GetBrowser();
        $userAgent = Request::header('user-agent');
        // get the browser
        $browser = $service($userAgent);

        // return the request's browser information
        $browser->getName(); // returns "Safari"
        $browser->getVersion(); // returns "9.1.1"
        $browser->getPlatform(); // returns "Macintosh"

        dump($browser);
    }
}
