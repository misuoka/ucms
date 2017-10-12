<?php
namespace app\index\controller;

// use think\facade\Request;
use think\Controller;
use think\Request;

class Index extends Controller
{
    // Request : think\Request  ;think\facade\Request 用于获得实例
    public function index(Request $request)
    {
        // echo $request->ip();
        // $user = Sysuser::get(3);
        // dump($user->toArray());

        // if(password_verify('123456', $user->password)){
        //     echo "yes";
        // } else {
        //     echo "fail";
        // }
        // var_dump($user);
        // $user = new Sysuser();
        // $user->account = 'conna45';
        // $user->username = 'hong';
        // $user->password = "123456";

        // $user->is_super_admin = 1;
        // $user->save();
        // dump($user->toArray());

        // $view = new View();
        // $view->init();
        // return $view->fetch();
        // return view();
        return $this->fetch();
    }

    public function login()
    {
        // return '欢迎登录';
        // $view = new View();
        // $view->init();
        // return $view->fetch();
        return $this->fetch();
    }
}
