<?php
namespace app\index\controller;

use think\Request;
// use think\facade\Request;
use think\facade\Session;
use think\View;
use think\Controller;
use app\index\model\Sysuser;

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

    public function hello($name = 'ThinkPHP5')
    {
        // $request->loginer['']
        return 'hello,' . $name;
    }

    public function push()
    {
        // $request = new Request();
        // $request->param('uid');

        // 建立socket连接到内部推送端口
        $client = stream_socket_client('tcp://127.0.0.1:5678', $errno, $errmsg, 1);
        // 推送的数据，包含uid字段，表示是给这个uid推送
        $data = array('uid'=>'hong', 'time'=> date('Y-m-d H:i:s'));
        // 发送数据，注意5678端口是Text协议的端口，Text协议需要在数据末尾加上换行符
        fwrite($client, json_encode($data)."\n");
        // 读取推送结果
        return fread($client, 8192);
    }

    public function redis()
    {
        $redis = new \Redis;
        $redis->connect('127.0.0.1', 6379);

        list($index, $match, $count) = [null, 'ss.tp51_*', 500];

        $keysArr = $redis->scan($index, $match, $count);

        // var_dump($keysArr);
        echo $redis->ttl($keysArr[0]);
    }

    public function user()
    {
        // Session::clear();
        $loginer = ['username'=>'hong', 'user_id'=>'1'];
        Session::set('loginer', $loginer);
        $view = new View();
        $view->init();
        $view->assign('name', $loginer['username']);

        return $view->fetch('user');
    }
}
