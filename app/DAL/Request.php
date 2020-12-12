<?php /** @noinspection PhpIncompatibleReturnTypeInspection */


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

    public function getAll() : array
    {
        return $this->Request_model->where('id >', 0)->findAll();
    }

    public function getById(int $id) : ?\App\Entities\Request
    {
        return $this->Request_model->where('id', $id)->first();
    }


    public function delAll(int $userId)
    {
        return $this->Request_model->where('user', $userId)->delete();
    }

    public function insert(\App\Entities\Request $Products)
    {
        return $this->Request_model->insert($Products);
    }


}