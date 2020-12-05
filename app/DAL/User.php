<?php /** @noinspection PhpIncompatibleReturnTypeInspection */

namespace App\DAL;


use CodeIgniter\Config\BaseService;
use \App\Models\User as UserModel;
use \App\Entities\User as UserEntity;

class User extends BaseService
{
    private UserModel $User_model;
    public function __construct()
    {
        $this->User_model = new UserModel();
    }

    public function getUserByLogin(string $login) : ?UserEntity
    {
        return $this->User_model->where('login', $login)->first();
    }

    public function getUserById(string $id) : ?UserEntity
    {
        return $this->User_model->where('id', $id)->first();
    }

    public function createUser(UserEntity $user) : int
    {
        return $this->User_model->insert($user);
    }

    public function editUser(UserEntity $user) : void
    {
        $this->User_model->save($user);
    }

}