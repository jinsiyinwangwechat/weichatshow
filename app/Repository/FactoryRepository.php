<?php
namespace App\Repository;

use App\Model\AliasModel;
use App\Model\ClassifyModel;
use App\Model\CollectionModel;
use App\Model\FactoryModel;
use App\Model\FriendFactoryModel;
use App\Model\PictureModel;
use Illuminate\Support\Facades\DB;
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
        $orderBy     = array_get($params, 'order_by', 'desc');

        $skip = $page > 1 ? ($page - 1) * $perPage : 0;
        $conditions  = array_only($params, ['town','village']);

        $query = $this->factoryModel->query();

        foreach ($conditions as $key => $item){
           $query = $query->where($key , $item);
        }
           $factoryList = $query->orderBy('collection','desc')
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

        $aliasInfo = $this->aliasModel->query()
            ->where('alias', 'like', '%'.$searchStr.'%')
            ->get()->toArray();

        $classify = array_pluck($aliasInfo, 'classify_name');

        if (empty($classify)){
            return[];
        }

        $factoryRelation = $this->classifyModel->query()
            ->whereIn('small_classify',$classify)
            ->get();

        $factoryIds = array_pluck($factoryRelation, 'factory_id');


        $searchResult = $this->factoryModel->query()
            ->whereIn('id',$factoryIds)
            ->orderBy('collection', 'desc')
            ->get();

        //$searchResult->classify = $classify;

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
            ->where('openid', $openId)
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
        $factoryFriend = DB::table('think_origin_friend_factory')
            ->select(
                "think_origin_friend_factory.id",
                'think_origin_friend_factory.origin_factory_id',
                'think_origin_friend_factory.friend_factory_id',
                'think_map.name'
            )
            ->join('think_map' ,'think_map.id' ,'=', 'think_origin_friend_factory.friend_factory_id')
            ->where('think_origin_friend_factory.origin_factory_id', $factoryId)
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

    public function getCollectionList($openid){

        $collectionList =DB::table('think_collection')
            ->select(
                "think_map.id",
                'think_map.name',
                'think_map.collection'
            )
            ->join('think_map' ,'think_map.id' ,'=', 'think_collection.factory_id')
            ->where('think_collection.openid', $openid)
            ->get();

 //
        return $collectionList;
    }
}