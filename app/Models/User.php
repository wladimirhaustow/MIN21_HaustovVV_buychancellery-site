<?php namespace App\Models;


use CodeIgniter\Model;

class User extends Model
{
    protected $DBGroup = 'default';

    protected $table      = 't_users';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'login',
        'password',
        'user_status'
    ];

    protected $returnType    = 'App\Entities\User';

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}