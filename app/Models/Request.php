<?php namespace App\Models;


use CodeIgniter\Model;

class Request extends Model
{
    protected $DBGroup = 'default';

    protected $table      = 't_request';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'request',
        'user',
    ];

    protected $returnType    = 'App\Entities\Request';

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}