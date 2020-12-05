<?php /** @noinspection PhpIncompatibleReturnTypeInspection */


namespace App\DAL;


use App\Models\Product as ProductModel;
use CodeIgniter\Config\BaseService;

class Product extends BaseService
{
    private ProductModel $Product_model;
    public function __construct()
    {
        $this->Product_model = new ProductModel();
    }

    public function getAll(string $select = '') : array
    {
        return $this->Product_model->select($select)->findAll();
    }


    public function getNameByid(int $id) : ?\App\Entities\Product
    {
        return $this->Product_model->select('name')->where('id', $id)->first();
    }

    public function delAll()
    {
        return $this->Product_model->where('id >', 0)->delete();
    }

    public function insert(array $Products)
    {
        return $this->Product_model->insertBatch($Products);
    }
}