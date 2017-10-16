<?php
namespace app\index\validate;

use think\Validate;

class Sysuser extends Validate
{
    protected $rule = [
        'captcha'  => 'require|captchaCheck',
        'account'  => 'require|max:20|token',
        'password' => 'require',
    ];

    protected $message = [
        'account.require'      => '请输入账号',
        'account.max'          => '账号最多不能超过20个字符',
        'password.require'     => '请输入密码',
        'captcha.require'      => '请输入验证码',
        'captcha.captchaCheck' => '验证码错误',
        'age.between'          => '年龄只能在1-120之间',
        'email'                => '邮箱格式错误',
    ];

    protected $scene = [
        'login' => [/*'captcha', */'account', 'password'],
    ];

    public function captchaCheck($value, $rule)
    {
        $captcha = new \think\captcha\Captcha([]);
        return $captcha->check($value, '');
    }
}
