<?php

namespace app\push\controller;

use Workerman\Worker;
use Workerman\Lib\Timer;

class WmMonitor
{
    private $worker;
    private $havePush = [];
    const NOTICE_LIMIT_TIME = 60;
    
    /**
     * 架构函数
     * @access public
     */
    public function __construct()
    {
        // 实例化 Websocket 服务
        $this->worker = new Worker();
        // 设置进程数
        $this->worker->count = 1;
        // 设置回调
        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];
        // Run worker
        Worker::runAll();
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {
        echo "用户状态服务启动...\n";

        Timer::add(1, [$this, 'run']);
        Timer::add(5, [$this, 'clearCache']);
    }

    public function run()
    {
        $redis = new \Redis;
        $redis->connect('127.0.0.1', 6379);

        list($index, $match, $count) = [null, 'ss.tp51_*', 500];

        do {
            $keysArr = $redis->scan($index, $match, $count);

            foreach ($keysArr as $key) {
                $timeout = $redis->ttl($key);
                if (!array_key_exists($key, $this->havePush) && $timeout > 0
                    && $timeout < self::NOTICE_LIMIT_TIME) {
                    $data = [
                        'uid'     => str_replace('ss.tp51_', '', $key),
                        'fn'      => 'offlineNotice',
                        'message' => '您的登录即将掉线，请在60秒内激活登录！',
                    ];
                    if ($this->offlinePush($data)) {
                        $this->havePush[$key] = time();
                    }
                }
            }
            usleep(50000); // 50毫秒
        } while ($index > 0);

        $redis->close();
    }

    private function offlinePush($data)
    {
        $client = stream_socket_client('tcp://127.0.0.1:5678', $errno, $errmsg, 1);
        // 发送数据，
        fwrite($client, json_encode($data) . "\n");
        // 读取推送结果
        return fread($client, 8192);
    }

    public function clearCache()
    {
        foreach ($this->havePush as $key => $value) {
            if ((time() - $value) > self::NOTICE_LIMIT_TIME) {
                unset($this->havePush[$key]);
            }
        }
    }
}
