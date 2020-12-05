<?php /** @noinspection PhpIncompatibleReturnTypeInspection */


namespace App\DAL;


use App\Models\ToPurchaser as ToPurchaserModel;
use CodeIgniter\Config\BaseService;

class ToPurchaser extends BaseService
{
    private ToPurchaserModel $ToPurchaser_model;

    public function __construct()
    {
        $this->ToPurchaser_model = new ToPurchaserModel();
    }

    public function getAll() : ?array
    {
        return $this->ToPurchaser_model->where('id > ', 0)->findAll();
    }

    public function getByUserId(int $userId) : ?\App\Entities\ToPurchaser
    {
        return $this->ToPurchaser_model->where('user', $userId)->first();
    }

    public function delAll(int $userId)
    {
        return $this->ToPurchaser_model->where('user', $userId)->delete();
    }

    public function insert(array $purchaser)
    {
        return $this->ToPurchaser_model->save($purchaser);
    }
}