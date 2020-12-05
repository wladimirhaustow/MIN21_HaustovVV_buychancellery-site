<?php


namespace App\DAL;


use App\Models\Request as RequestModel;
use CodeIgniter\Config\BaseService;

class Request extends BaseService
{
    private RequestModel $Request_model;

    public function __construct()
    {
        $this->Request_model = new RequestModel();
    }

    public function getAll(int $userId, string $select = '') : array
    {
        return $this->Request_model->select($select)->where('user', $userId)->findAll();
    }

    public function delAll(int $userId)
    {
        return $this->Request_model->where('user', $userId)->delete();
    }

    public function insert(array $Products)
    {
        return $this->Request_model->insertBatch($Products);
    }


}