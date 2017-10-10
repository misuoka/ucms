<?php
namespace app\index\model;

use think\Model;
// use think\Request;
use think\facade\Request;
use think\Container;

class Sysuser extends Model
{
	// protected $type = [
    //     'create_time'  =>  'datetime',
	// ];
	// protected $updateTime = 'last_logintime';
	// protected $autoWriteTimestamp = 'datetime';
	protected $pk = 'suid';

	protected $auto = ['password', 'last_loginip'];
    protected $insert = ['status' => 1];  
    protected $update = [];  
    
    protected function setPasswordAttr($value)
    {
		return password_hash($value, PASSWORD_DEFAULT, ['cost' => 12]);
    }
    
    protected function setLastLoginipAttr()
    {
        // $request = Container::get('request');
        $request = Request::instance(); // 必须
		// $request = new Request(); // 出错，没有传Config对象
        return $request->ip();
    }
}
