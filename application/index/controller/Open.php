<?php 
namespace app\index\controller;

use think\Request;
use think\facade\Session;
use think\View;

class Open
{
	public function captcha($_dc = '')
	{
		$config = [
			'fontSize' => 40,
			 'length' => 4,
		];
		$captcha = new \think\captcha\Captcha($config);
    	return $captcha->entry($_dc);
	}
}