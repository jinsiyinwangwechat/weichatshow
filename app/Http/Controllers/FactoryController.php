<?php
/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2017/8/9
 * Time: 21:13
 */

namespace App\Http\Controllers;


use App\Service\FactoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactoryController extends Controller
{
    private $factoryService;

    public function __construct(FactoryService $factoryService)
    {
        $this->factoryService = $factoryService;
    }

    /**
     * 工厂列表页面
     * @param Request $request
     * @return mixed
     */
    public function listPage(Request $request)
    {
        $village = $this->factoryService->getVillageList();
        return view("test.list")->with('village', $village);
    }

    /**
     * 工厂详情页面
     * @param Request $request
     * @return $this
     */
    public function detailPage(Request $request) {
        $factoryId  = $request->get('factory_id');
        return view("test.detail")->with('factoryId', $factoryId);
    }
    /**
     * 工厂列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFactoryList(Request $request)
    {

        $params = $request->all();

        $result =  $this->factoryService->getFactoryList($params);

        return $this->outJsonFormat($result->toArray());
    }

    /**
     * 检索接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchFactory(Request $request)
    {

        $this->validate($request, [
            'classify' => 'required'
        ],[
            'classify.required' => '小类必须传'
            ]);

        $params = $request->all();

        $result = $this->factoryService->searchFactory($params);

        return $this->outJsonFormat($result);

    }


    /**
     * @param Request $request
     */
    public function doCollection(Request $request)
    {
        $this->validate($request, [
            'factory_id' => 'required'
        ]);

        $factoryId  = $request->get('factory_id');
        //$openId = $this->getOpenId();
        $openId = 'sdfsdfsdf';

        $this->factoryService->doCollection($factoryId, $openId);
    }


    /**
     * 取消收藏
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelCollection(Request $request)
    {
        $this->validate($request, [
            'factory_id' => 'required'
        ]);
        $factoryId  = $request->get('factory_id');
        //$openId = $this->getOpenId();
        $openId = 'sdfsdfsdf';

        $result = $this->factoryService->cancelCollection($factoryId, $openId);

        return $this->outJsonFormat($result);
    }

    public function getFactoryDetail(Request $request)
    {
        $this->validate($request, [
           'factory_id' => 'required'
        ],[
            'factory_id.required' => '必须传'
        ]);

        $factoryId  = $request->get('factory_id');
        //$openId = $this->getOpenId();
        $openId = 'sdfsdfsdf';

        $result = $this->factoryService->getFactoryDetail($factoryId);

        return $this->outJsonFormat($result);
    }

    public function getCollectionList(Request $request)
    {
        $openid = $this->getOpenId();

        $result = $this->factoryService->getCollectionList($openid);

        return $this->outJsonFormat($result);
    }
}