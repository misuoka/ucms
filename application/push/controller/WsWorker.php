<?php

namespace app\push\controller;

use think\worker\Server;
use Workerman\Worker;
use Workerman\Lib\Timer;

class WsWorker extends Server
{
    public $name         = 'WsWorker';
    protected $processes    = 1;
    protected $socket       = 'websocket://0.0.0.0:2346';
    private $clientCount    = 0;
    private $uidConnections = [];
    const HEARTBEAT_TIME    = 30;
    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        $connection->lastMessageTime = time(); // 设置最后接收数据的时间

        // $connection->send('我收到你的信息了');
        if (!isset($connection->uid) && $data) {
            $connection->uid = $data;

            $this->uidConnections[$connection->uid] = $connection;
        }
        echo "Recevie a message from client {$connection->uid}, msg: {$data}\n";

        // $worker->onMessage = function($connection, $msg)
        // {
        //     $msg = json_decode($msg, true);
        //     switch($msg['type'])
        //     {
        //     case 'login':
        //         // 验证成功，删除定时器，防止连接被关闭
        //         Timer::del($connection->auth_timer_id);
        //         break;
        //     }
        // }

    }
    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
        $this->clientCount++;
        echo "The {$this->clientCount} client connection ... \n";

        // 临时给$connection对象添加一个auth_timer_id属性存储定时器id
        // 定时30秒关闭连接，需要客户端30秒内发送验证删除定时器
        // $connection->auth_timer_id = Timer::add(30, function()use($connection){
        //     $connection->close();
        // }, null, false);
        // 可用来进行用户第一次验证，如果规定时间内，客户端未发送正确的验证用户识别数据，则关闭链接

        // $connection->onWebSocketConnect = function ($connection, $http_header) {
        //     // 可以在这里判断连接来源是否合法，不合法就关掉连接
        //     // $_SERVER['HTTP_ORIGIN']标识来自哪个站点的页面发起的websocket连接
        //     if ($_SERVER['HTTP_ORIGIN'] != 'http://chat.workerman.net') {
        //         $connection->close();
        //     }
        //     // onWebSocketConnect 里面$_GET $_SERVER是可用的
        //     // var_dump($_GET, $_SERVER);
        // };
    }
    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        if (isset($connection->uid)) {
            // 连接断开时删除映射
            unset($this->uidConnections[$connection->uid]);
            echo "The {$connection->uid} close.\n";
        }
    }
    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }
    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {
        // 开启一个内部端口，方便内部系统推送数据，Text协议格式 文本+换行符
        $inner_text_worker            = new Worker('text://0.0.0.0:5678');
        $inner_text_worker->onMessage = function ($connection, $buffer) {
            // $data数组格式，里面有uid，表示向那个uid的页面推送数据
            $data = json_decode($buffer, true);
            $uid  = $data['uid'];
            // 通过workerman，向uid的页面推送数据
            $ret = $this->sendMessageByUid($uid, $buffer);
            // 返回推送结果
            $connection->send($ret ? 'ok' : 'fail');
        };
        // ## 执行监听 ##
        $inner_text_worker->listen();

        Timer::add(1, function () use ($worker) {
            $time_now = time();
            foreach ($worker->connections as $connection) {
                // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
                if (empty($connection->lastMessageTime)) {
                    $connection->lastMessageTime = $time_now;
                    continue;
                }
                // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
                if ($time_now - $connection->lastMessageTime > self::HEARTBEAT_TIME) {
                    $key = array_search($connection, $this->uidConnections);
                    unset($this->uidConnections[$key]);
                    $connection->close();
                }
            }
        });

        echo "Server is runing ...\n";
    }

    public function sendMessageByUid($uid, $message)
    {
        if (isset($this->uidConnections[$uid])) {
            $connection = $this->uidConnections[$uid];
            $connection->send($message);
            return true;
        }
        return false;
    }
}
