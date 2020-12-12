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

    public function getAllId() : array
    {
        $array_select = $this->Product_model->select('id')->get()->getResultArray();
        $ids = [];
        foreach ($array_select as $select)
            $ids[] = $select['id'];

        return $ids;
    }


    public function getNameById(int $id) : ?\App\Entities\Product
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

    public function delete(array $Products)
    {
        return $this->Product_model->delete($Products);
    }

    public function save(array $Products)
    {
        return $this->Product_model->save($Products);
    }
}