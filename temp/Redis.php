<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think\session\driver;

use SessionHandler;
use think\Exception;

class Redis extends SessionHandler
{
    /** @var \Redis */
    protected $handler = null;
    protected $config  = [
        'host'         => '127.0.0.1', // redis主机
        'port'         => 6379, // redis端口
        'password'     => '', // 密码
        'select'       => 0, // 操作库
        'expire'       => 3600, // 有效期(秒)
        'timeout'      => 0, // 超时时间(秒)
        'persistent'   => true, // 是否长连接
        'session_name' => '', // sessionkey前缀
    ];

    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 打开Session
     * @access public
     * @param string $savePath
     * @param mixed  $sessName
     * @return bool
     * @throws Exception
     */
    public function open($savePath, $sessName)
    {
        // 检测php环境
        if (!extension_loaded('redis')) {
            throw new Exception('not support:redis');
        }

        $this->handler = new \Redis;

        // 建立连接
        $func = $this->config['persistent'] ? 'pconnect' : 'connect';
        $this->handler->$func($this->config['host'], $this->config['port'], $this->config['timeout']);

        if ('' != $this->config['password']) {
            $this->handler->auth($this->config['password']);
        }

        if (0 != $this->config['select']) {
            $this->handler->select($this->config['select']);
        }

        return true;
    }

    /**
     * 关闭Session
     * @access public
     */
    public function close()
    {
        $this->gc(ini_get('session.gc_maxlifetime'));
        $this->handler->close();
        $this->handler = null;

        return true;
    }

    public function lock($sessID, $intTimeout = 3)
    {
        $lock_key = 'LOCK_PREFIX_' . $sessID;
        //使用setnx操作加锁，同时设置过期时间
        $intRet = $this->handler->setnx($lock_key, 1);
        if ($intRet) {
            //设置过期时间，防止死任务的出现
            $this->handler->expire($lock_key, $intTimeout);
            return true;
        }

        return false;

        // $lock_key = 'LOCK_PREFIX_' . $sessID;
        // $ttl      = $this->handler->ttl($lock_key);
        // if ($ttl == -1) {
        //     $is_lock = $this->handler->expire($lock_key, $expire);
        // } else if ($ttl < -1) {
        //     $is_lock = $this->handler->setnx($lock_key, $expire);
        // } else {
        //     $is_lock = false;
        // }
        // return $is_lock ? true : false;
        //

        // $lock_key = 'LOCK_PREFIX_' . $sessID;
        // $is_lock  = $this->handler->setnx($lock_key, $expire);

        // // 不能获取锁
        // if (!$is_lock) {

        //     // 判断锁是否过期
        //     if ($this->handler->ttl($lock_key) == -1) {
        //         $this->unlock($sessID);
        //         $is_lock = $this->handler->expire($lock_key, $expire);
        //     }

        //     // $lock_time = $this->_redis->get($key);

        //     // 锁已过期，删除锁，重新获取
        //     // if (time() > $lock_time) {
        //     //     $this->unlock($key);
        //     //     $is_lock = $this->_redis->setnx($key, time() + $expire);
        //     // }
        // }

        // return $is_lock ? true : false;
    }

    public function unlock($sessID)
    {
        $lock_key = 'LOCK_PREFIX_' . $sessID;
        $this->handler->del($lock_key);
    }

    /**
     * 读取Session
     * @access public
     * @param string $sessID
     * @return string
     */
    public function read($sessID)
    {
        // do {
        //     if ($this->lock($sessID)) {
        //         $res = (string) $this->handler->get($this->config['session_name'] . $sessID);
        //         $this->unlock($sessID);
        //         return $res;
        //     }
        // } while (true);
        return (string) $this->handler->get($this->config['session_name'] . $sessID);
    }

    /**
     * 写入Session
     * @access public
     * @param string $sessID
     * @param String $sessData
     * @return bool
     */
    public function write($sessID, $sessData)
    {
        // do {
        //     if ($this->lock($sessID)) {
        //         if ($this->config['expire'] > 0) {
        //             $res = $this->handler->setex($this->config['session_name'] . $sessID, $this->config['expire'], $sessData);
        //         } else {
        //             $res = $this->handler->set($this->config['session_name'] . $sessID, $sessData);
        //         }
        //         $this->unlock($sessID);
        //         return $res;
        //     }
        // } while (true);
        if ($this->config['expire'] > 0) {
            return $this->handler->setex($this->config['session_name'] . $sessID, $this->config['expire'], $sessData);
        } else {
            return $this->handler->set($this->config['session_name'] . $sessID, $sessData);
        }
    }

    /**
     * 删除Session
     * @access public
     * @param string $sessID
     * @return bool
     */
    public function destroy($sessID)
    {
        return $this->handler->delete($this->config['session_name'] . $sessID) > 0;
    }

    /**
     * Session 垃圾回收
     * @access public
     * @param string $sessMaxLifeTime
     * @return bool
     */
    public function gc($sessMaxLifeTime)
    {
        return true;
    }
}
