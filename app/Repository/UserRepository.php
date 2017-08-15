<?php
namespace App\Repository;

use App\Model\AliasModel;
use App\Model\ClassifyModel;
use App\Model\CollectionModel;
use App\Model\FactoryModel;
use App\Model\FriendFactoryModel;
use App\Model\PictureModel;
use App\Model\UserModel;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2017/8/9
 * Time: 21:22
 */
class UserRepository
{
    private $factoryModel;
    private $aliasModel;
    private $collectionModel;
    private $pictureModel;
    private $friendFactoryModel;
    private $classifyModel;
    private $userModel;

    public function __construct(
        FactoryModel       $factoryModel,
        AliasModel         $aliasModel,
        CollectionModel    $collectionModel,
        PictureModel       $pictureModel,
        FriendFactoryModel $friendFactoryModel,
        ClassifyModel      $classifyModel,
        UserModel          $userModel
    )
    {
        $this->factoryModel       = $factoryModel;
        $this->aliasModel         = $aliasModel;
        $this->collectionModel    = $collectionModel;
        $this->pictureModel       = $pictureModel;
        $this->friendFactoryModel = $friendFactoryModel;
        $this->classifyModel      = $classifyModel;
        $this->userModel          = $userModel;
    }



    public function createUser($params)
    {
        $userData = array_only($params,
            [
                'openid',
                'username',
                'nick',
                'sex'
            ]);
        $this->userModel->create($userData);
    }


}