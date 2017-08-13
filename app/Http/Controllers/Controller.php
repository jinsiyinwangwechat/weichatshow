<?php

namespace App\Http\Controllers;

use EasyWeChat\Core\Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Log;
use App\Exceptions\BeeperException;
use Smarty;
use App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;




    /**
     * 格式化接口返回值
     * @param $result
     * @param string $message
     * @param $code
     * @return array
     */
    protected function formatJsonOutput($result, $message = 'success', $code = null)
    {
        return response()->json([
            'code' => is_null($code) ? config('custom_code.success.code') : $code,
            'msg' => $message,
            'info' => $result
        ]);
    }

    protected function getOpenId(){
        $user = session('wechat.oauth_user');
        return $user;
        $openId = array_get($user, 'id', false);
        if($openId === false){
            Log::info('openid did not get with user info' . json_encode($user));
            throw new \Exception('没有openid!');
        }
        return $openId;
    }

    protected function checkOrderByMobile($order, $mobile){
        $result = (array_get($order, 'dp_contact_mobile') == $mobile) ? $order : [];
        return $result;
    }

    protected function display($tpl, $data = []){
        $base = base_path();
        $smarty = new Smarty();

        $smarty->template_dir = $base . '/web/template';
        $smarty->compile_dir = $base . '/web/template_c';
        $smarty->config_dir = $base . '/web/config';
        $smarty->cache_dir = $base . '/web/cache';
        $smarty->left_delimiter='{%';
        $smarty->right_delimiter='%}';
        $smarty->caching = false;
        $smarty->debugging = false;
        $data['csrf_token'] = csrf_token();
        $data['is_prod_env'] = intval(App::environment('production'));
        $data['app_env'] = getenv('APP_ENV');
        $smarty->assign('info', $data);

        $smarty->display($tpl);
    }

    public function outJsonFormat($result){
        return response()->json([
            'code' => 0,
            'info' => $result
        ]);
    }

}
