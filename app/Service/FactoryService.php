<?php

/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2017/8/9
 * Time: 21:19
 */
namespace App\Service;

use App\Repository\FactoryRepository;
use EasyWeChat\Core\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FactoryService
{
    private $factoryRepository;
    public function __construct(FactoryRepository $factoryRepository)
    {
        $this->factoryRepository = $factoryRepository;
    }

    public function getVillageList() {
        $villages = array('安平镇','黄城镇','两洼乡','大子文镇','马店镇','南五庄镇','大河庄乡','油子乡','开发区','旧工业园区','饶阳工业区','深州工业区');
        return $villages;
    }

    /**
     * @param $params
     * @return \Illuminate\Support\Collection
     */
    public function getFactoryList($params)
    {
        return $this->factoryRepository->getFactoryList($params);
    }

    public function searchFactory($params)
    {
        return $this->factoryRepository->searchFactory($params);
    }

    /**
     * 收藏
     * @param $factoryId
     * @param $openId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function doCollection($factoryId, $openId)
    {
        $data = [
            'factory_id' => $factoryId,
            'openid'     => $openId,
        ];

        DB::beginTransaction();
        try {

            $this->factoryRepository->doCollection($data);

            $factoryInfo = $this->factoryRepository->addCollectionCount($factoryId);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollback();//事务回滚
            Log::error('收藏失败，factory_id:' . $factoryId . 'openid:' . $openId. 'ERROR:' . json_encode($exception->getMessage()));
            throw new \Exception('收藏失败');
        }

        return $factoryInfo;
    }

    /**
     * 取消收藏
     * @param $factoryId
     * @param $openId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function cancelCollection($factoryId, $openId)
    {
        DB::beginTransaction();
        try {
            $this->factoryRepository->cancelCollection($factoryId,$openId);

            $factoryInfo = $this->factoryRepository->addCollectionCount($factoryId, -1);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollback();//事务回滚
            Log::error('取消收藏失败，factory_id:' . $factoryId . 'openid:' . $openId. 'ERROR:' . json_encode($exception->ge));
            throw new \Exception('取消收藏失败');
        }

        return $factoryInfo;
    }

    public function getFactoryDetail($factoryId, $openid)
    {

        $factoryInfo = $this->factoryRepository->getFactoryById($factoryId);

        if (empty($factoryInfo)){
            throw new Exception('查询工厂不存在');
        }

        //获取图片
        $factoryPic        = $this->factoryRepository->getFactoryPic($factoryId);
        // 获取友情链接
        $factoryFriendLink = $this->factoryRepository->getFactoryFriendLink($factoryId);
        //获取大类小类
        $classifyInfo      = $this->factoryRepository->getClassify($factoryId);

        $collection        = $this->factoryRepository->getCollectionList($openid);
        $collection = json_encode($collection);
        $collection = json_decode($collection, true);

        $factoryInfo->pictures     = $factoryPic;
        $factoryInfo->friendLink   = $factoryFriendLink;
        $factoryInfo->classify     = $classifyInfo;
        $factoryInfo->isCollection = in_array($factoryId, array_pluck($collection, 'id'));

        return $factoryInfo->toArray();
    }

    public function getCollectionList($params)
    {
        return $this->factoryRepository->getCollectionList($params);
    }
}