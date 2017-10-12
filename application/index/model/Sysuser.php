<?php
namespace app\index\model;

use think\Container;
// use think\Request;
// use think\facade\Request;
use think\Model;

class Sysuser extends Model
{
    // protected $type = [
    //     'create_time'  =>  'datetime',
    // ];
    protected $updateTime = 'last_logintime';
    // protected $autoWriteTimestamp = 'datetime';
    protected $pk = 'suid';

    protected $auto     = [];
    protected $insert   = ['status' => 1];
    protected $update   = ['last_loginip'];
    protected $readonly = ['account', 'create_time'];

    protected function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    protected function setLastLoginipAttr()
    {
        $request = Container::get('request');
        return $request->ip();
    }

    public static function login(array $data): bool
    {
        $session = Container::get('session');
        $session->delete('loginer');
        // $sysuser = Sysuser::where('account', $data['account'])->find();
        $sysuser = Sysuser::getByAccount($data['account']);
        
        if ($sysuser && password_verify($data['password'], $sysuser->password)) {
            $sysuser->login_count += 1;
            $sysuser->save();
            $session->set('loginer', $sysuser->getData());

            return true;
        }
        return false;
    }
}
