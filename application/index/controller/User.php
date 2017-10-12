<?php
namespace app\index\controller;

use app\index\model\Sysuser;
use think\Controller;
use think\Request;

class User extends Controller
{
    // public function login(Request $request)
    // {
    //     if (!$request->isPost()) {
    //         $this->error('非法访问');
    //     }
    //     $data   = $request->post();
    //     $result = $this->validate($data, 'app\index\validate\Sysuser.login');

    //     if (true !== $result) {
    //         $this->error($result);
    //     }
    //     if (!Sysuser::login($data)) {
    //         $this->error('登录失败，账号或密码错误');
    //     }
    //     // $result = Hook::exec('app\\index\\behavior\\LoginLog', ['success' => true]);
    //     $this->success('登录成功', 'Index/index');
    // }

    public function login(Request $request)
    {
        $success = false;
        $msg     = '非法访问';

        if ($request->isPost()) {
            $data   = $request->post();
            $result = $this->validate($data, 'app\index\validate\Sysuser.login');

            if (true !== $result) {
                $msg = $result;
            } else if (Sysuser::login($data)) {
                $msg     = '登录成功';
                $success = true;
            } else {
                $msg = '登录失败，账号或密码错误';
            }
        }

        Hook::listen('loginlog_write', ['success' => $success, 'msg' => $msg]);

        $success ? $this->success($msg, 'Index/index') : $this->error($msg);
    }
}
