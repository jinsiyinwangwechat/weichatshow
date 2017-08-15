<?php

/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2017/8/9
 * Time: 21:19
 */
namespace App\Service;

use App\Repository\FactoryRepository;
use App\Repository\UserRepository;
use EasyWeChat\Core\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    private $factoryRepository;
    private $userRepository;


    public function __construct(
        FactoryRepository $factoryRepository,
        UserRepository    $userRepository
    )
    {
        $this->factoryRepository = $factoryRepository;
        $this->userRepository    = $userRepository;
    }

    public function createUser($params)
    {
        return $this->userRepository->createUser($params);
    }
}