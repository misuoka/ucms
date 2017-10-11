<?php
namespace app\index\controller;

use think\Controller;

class Resource extends Controller
{
    public function topMenu()
    {
        $data = [
            ['id' => '1', 'title' => '系统管理'],
            ['id' => '2', 'title' => '内容管理'],
        ];

        return $data;
    }
}
