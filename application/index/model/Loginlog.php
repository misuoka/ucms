<?php
namespace app\index\model;

use Jstewmc\GetBrowser\GetBrowser;
use think\Container;
use think\Model;

class Loginlog extends Model
{
    protected $createTime = 'logtime';
    protected $pk         = 'logid';
    protected $insert     = ['ip', 'account', 'get_param', 'post_param', 'browser', 'platform', 'status'];
    private $browserObj   = null;
    private $loginer      = null;

    protected function setIpAttr()
    {
        $request = Container::get('request');
        return $request->ip();
    }

    protected function setGetParamAttr()
    {
        $request = Container::get('request');
        return json_encode($request->get(), JSON_UNESCAPED_UNICODE);
    }

    protected function setPostParamAttr()
    {
        $post = Container::get('request')->post();

        if ($this->getLoginer()) {
            $post['password'] = ''; // 登录成功，不存储密码
        }

        return json_encode($post, JSON_UNESCAPED_UNICODE);
    }

    protected function setBrowserAttr()
    {
        $info = $this->getBrowserInfo();

        return $info['name'] . ' - ' . $info['version'];
    }

    protected function setPlatformAttr()
    {
        $info = $this->getBrowserInfo();

        return $info['platform'];
    }

    protected function setAccountAttr()
    {
        return Container::get('request')->post('account');
    }

    protected function setStatusAttr()
    {
        $loginer = $this->getLoginer();

        return $loginer && $loginer['suid'] ? 1 : 0;
    }

    private function getBrowserInfo()
    {
        if ($this->browserObj === null) {
            $request   = Container::get('request');
            $service   = new GetBrowser();
            $userAgent = $request->header('user-agent');

            // get the browser
            $this->browserObj = $service($userAgent);
        }

        // return the request's browser information
        return [
            'name'     => $this->browserObj->getName(),
            'version'  => $this->browserObj->getVersion(),
            'platform' => $this->browserObj->getPlatform(),
        ];
    }

    private function getLoginer()
    {
        if ($this->loginer === null) {
            $this->loginer = Container::get('session')->get('loginer');
        }

        return $this->loginer;
    }
}
