<?php

namespace App\Http\Controllers;

use App\Service\FactoryService;
use EasyWeChat\Foundation\Application;
use GuzzleHttp\Psr7\Request;
use Log;

class WechatController extends Controller
{
    private $wechat;
    private $factoryService;

    public function __construct(
        Application    $wechat,
        FactoryService $factoryService
    )
    {
        $this->wechat         = $wechat;
        $this->factoryService = $factoryService;
    }
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {

        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');

        $wechat->server->setMessageHandler(function($message){
//            return 'http://liucheng.nat300.top/test';

            /*Log::info('location位置:' . $message->Latitude . $message->Longitude);
            if ($message->MsgType == 'EVENT'){
                if($message->EVENT == 'location'){
                    Log::info('location位置:' . $message->Latitude . $message->Longitude);
                }
            }*/
            switch ($message->MsgType) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    $params = [
                        'classify' => $message->Content
                    ];

                    $factoryInfo = $this->factoryService->searchFactory($params);

                    $factoryId       = array_get($factoryInfo, 'id', 0);
                    $factoryName     = array_get($factoryInfo, 'name', '');
                    $factoryclassify = array_get($factoryInfo, 'classify', '');

                    if ($factoryId == 0 ){
                        return '没有找到相关企业,我们正在努力中，敬请期待';
                    }


                    //$text = new Text(['content' => '您好！overtrue。']);
                    $templateId = 'K0gJlkgXoCoKB72hXHryP_gU5CoTYSHLCUY3Us7V3wQ';
                    $url = 'http://liucheng.nat300.top/test?params=' . $message->Content;
                    $classify = "\n\n";
                    foreach ($factoryclassify as $item){
                        $classify = $classify . $item ."\n\n";
                    }
                    $data = [
                        'factory_name' => $factoryName . "\n\n",
                        'classify'     => $classify
                    ];

                    $userId = $message->FromUserName;
                    //return $userId;
                    $notice = $this->wechat->notice;
                    $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

                    return '^_^';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }

            return "欢迎关注 金丝银网，请尝试输入文字来获得丝网企业信息！";
        });

        Log::info('return response.');

        return $wechat->server->serve();
    }
}