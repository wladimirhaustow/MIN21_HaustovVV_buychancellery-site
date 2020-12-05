<?php


namespace App\Models;


use CodeIgniter\Model;

class ToPurchaser extends Model
{
    protected $DBGroup = 'default';

    protected $table      = 't_to_purchaser';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'user'
    ];

    protected $returnType    = 'App\Entities\ToPurchaser';

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}