<?php namespace App\Models;


use CodeIgniter\Model;

class Product extends Model
{
    protected $DBGroup = 'default';

    protected $table      = 't_product';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'name',
        'comment'
    ];

    protected $returnType    = 'App\Entities\Product';

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}