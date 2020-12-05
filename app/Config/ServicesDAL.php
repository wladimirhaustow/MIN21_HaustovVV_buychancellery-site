<?php
namespace Config;


use App\DAL\Product;
use App\DAL\Request;
use App\DAL\ToPurchaser;
use App\DAL\User;
use CodeIgniter\Config\BaseService;

class ServicesDAL extends BaseService
{
    public static function user($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('user');
        }

        return new User();
    }

    public static function product($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('product');
        }

        return new Product();
    }

    public static function userRequest($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('userRequest');
        }

        return new Request();
    }

    public static function toPurchaser($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('toPurchaser');
        }

        return new ToPurchaser();
    }
}