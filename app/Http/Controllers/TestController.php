<?php
/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2017/8/6
 * Time: 16:03
 */

namespace App\Http\Controllers;


use App\Service\FactoryService;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class TestController extends Controller
{
    private $factoryService;

    public function __construct(FactoryService $factoryService)
    {
        $this->factoryService = $factoryService;
    }

    public function test(Request $request)
    {
       // $openId = $this->getOpenId();
        $params = $request->all();

        $user = session('wechat.oauth_user');



        $result = $this->factoryService->searchFactory(['classify' =>array_get($params, 'params')]);

        $factory = $result->toArray();
        //dd($factory);
        $tlp = '欢迎[ ' . $user->name . ' ]同志，由于前端显示页面还没有完成，我们目前只能看到这样的数据了。' . "\n\n"


        ;

        //dd($tlp . json_encode($result));
        $factory = array_merge($factory, ['userName' => $user->name]);
        return view('test.test', $factory);


        /*
        return $user;
        dd($this->getOpenId());*/
        /*dd($openId);
        $app = new Application();
        $userService = $app->user;
        dd($userService);*/
    }

}