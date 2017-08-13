<?php
namespace App\Repository;

use App\Model\AliasModel;
use App\Model\ClassifyModel;
use App\Model\CollectionModel;
use App\Model\FactoryModel;
use App\Model\FriendFactoryModel;
use App\Model\PictureModel;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2017/8/9
 * Time: 21:22
 */
class FactoryRepository
{
    private $factoryModel;
    private $aliasModel;
    private $collectionModel;
    private $pictureModel;
    private $friendFactoryModel;
    private $classifyModel;

    public function __construct(
        FactoryModel       $factoryModel,
        AliasModel         $aliasModel,
        CollectionModel    $collectionModel,
        PictureModel       $pictureModel,
        FriendFactoryModel $friendFactoryModel,
        ClassifyModel      $classifyModel
    )
    {
        $this->factoryModel       = $factoryModel;
        $this->aliasModel         = $aliasModel;
        $this->collectionModel    = $collectionModel;
        $this->pictureModel       = $pictureModel;
        $this->friendFactoryModel = $friendFactoryModel;
        $this->classifyModel      = $classifyModel;
    }

    public function getFactoryList($params)
    {
        $page        = array_get($params, 'page', 1);
        $perPage     = array_get($params, 'per_page', 10);

        $skip = $page > 1 ? ($page - 1) * $perPage : 0;
        $conditions  = array_only($params, ['town','valliage']);

        $query = $this->factoryModel->query();

        foreach ($conditions as $key => $item){
           $query = $query->where($key , $item);
        }
           $factoryList = $query->where('id', '<' ,10)
               ->orderBy('collection','desc')
               ->skip($skip)
               ->take($perPage)
               ->get();

        Log::info('查询工厂列表结束,参数:' . json_encode($params));

        return $factoryList;
    }

    public function searchFactory($params)
    {
        $searchStr = array_get($params, 'classify', '');
        if (empty($searchStr)){
            return [];
        }
/*
        $aliasInfo = $this->aliasModel->query()
            ->where('alias', $searchStr)
            ->get()->toArray();

        $classify = array_pluck($aliasInfo, 'classify_name');


        if (empty($classify)){
            return[];
        }

        $searchResult = $this->factoryModel->query()
            ->whereIn('classify_name',$classify)
            ->orderBy('collection', 'desc')
            ->get();*/

        $factoryRelation = $this->classifyModel->query()
            ->where('small_classify','like','%'.$searchStr.'%')
            ->first();

        $factoryId = array_get($factoryRelation, 'factory_id', '');

        $classifyInfo = $this->classifyModel->query()
            ->where('factory_id', $factoryId)
            ->get();

        $classify = array_pluck($classifyInfo->toArray(), 'small_classify');

        $searchResult = $this->factoryModel->query()
            ->where('id',$factoryId)
            ->first();

        $searchResult->classify = $classify;

        return $searchResult;

    }

    /**
     *  设置收藏
     * @param $params
     * @return bool
     * @throws \Exception
     */
    public function doCollection($params)
    {
        $data = array_only($params, ['factory_id', 'openid']);

        $result = $this->collectionModel->create($data);

        if ($result == false){
            throw new \Exception('收藏失败');
        }
        return $result;
    }

    /**
     * 取消收藏
     * @param $factoryId
     * @param $openId
     * @return bool
     */
    public function cancelCollection($factoryId, $openId)
    {
        $result = $this->collectionModel->query()
            ->where('factory_id', $factoryId)
            ->where('open_id', $openId)
            ->delete();
        return true;
    }

    /**
     * 设置收藏数量
     * @param $factoryId
     * @param int $num
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function addCollectionCount($factoryId, $num = 1)
    {
        $factoryInfo = $this->factoryModel->findOrFail($factoryId);

        $collectionCount = $factoryInfo->getAttribute('collection') + $num;

        $factoryInfo->setAttribute('collection', $collectionCount);

        $factoryInfo->save();

        return $factoryInfo;

    }

    /**
     * @param $factoryId
     * @return mixed|static
     */
    public function getFactoryById($factoryId)
    {
        $factoryInfo = $this->factoryModel->find($factoryId);

        return $factoryInfo;
    }

    public function getFactoryPic($factoryId)
    {
        $picArray = $this->pictureModel->query()
            ->where('uid', $factoryId)
            ->get();

        return $picArray;
    }

    public function getFactoryFriendLink($factoryId)
    {
        $factoryFriend = $this->friendFactoryModel->query()
            ->where('orgin_factory_id', $factoryId)
            ->get();

        return $factoryFriend;
    }

    public function getClassify($factoryId)
    {
        $classifyInfo = $this->classifyModel->query()
            ->where('factory_id', $factoryId)
            ->get();

        return $classifyInfo;
    }
}