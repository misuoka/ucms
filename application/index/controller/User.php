<?php
namespace app\index\controller;

use app\index\model\Sysuser;
use think\Controller;
use think\Request;

class User extends Controller
{
    public function login(Request $request)
    {
        if (!$request->isPost()) {
            $this->error('非法访问');
        }
        $data   = $request->post();
        $result = $this->validate($data, 'app\index\validate\Sysuser.login');

        if (true !== $result) {
            $this->error($result);
        }
        if (!Sysuser::login($data)) {
            $this->error('登录失败，账号或密码错误');
        }

        $this->success('登录成功', 'Index/index');
    }
}
