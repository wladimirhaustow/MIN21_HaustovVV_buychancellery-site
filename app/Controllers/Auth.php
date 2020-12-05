<?php


namespace App\Controllers;


use App\Entities\User as UserEntity;
use CodeIgniter\Config\Services;
use CodeIgniter\Session\Session;
use CodeIgniter\Validation\Validation;
use Config\ServicesDAL;

class Auth extends BaseController
{
    private Session $session;
    private Validation $validation;


    public function __construct(){
        $this->session = Services::session();
        $this->validation = Services::validation();
    }

    public function login(){
        return view('login');
    }

    public function register(){
        return view('register');
    }

    public function attemptRegister(){
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $rules = [
            'login'		=> [
                'rules' => 'required|alpha_dash|min_length[3]|max_length[20]|is_unique[t_users.login]',
                'errors' => [
                    'is_unique' => 'Пользователь с таким логином уже существует!'
                ],
            ],
            'password' 	=> 'required|min_length[8]|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return view('register', ['errors' => $this->validator->getErrors()]);
        }


        $User_entity = ServicesDAL::user()->getUserByLogin($login);

        if(is_null($User_entity))
        {
            $NewUser_entity = new UserEntity();
            $NewUser_entity->login = $login;
            $NewUser_entity->password = password_hash($password, PASSWORD_DEFAULT);

            ServicesDAL::user()->createUser($NewUser_entity);

            return redirect()->to('/Auth/login');
        }

    }

    public function attemptLogin(){
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $rules = [
            'login'		=> [
                'rules' => 'required|alpha_dash|min_length[3]|max_length[20]|is_not_unique[t_users.login]',
                'errors' => [
                    'is_not_unique' => 'Неправильный логин или пароль!'
                ],
            ],
            'password' 	=> 'required|min_length[8]|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return view('login', ['errors' => $this->validator->getErrors()]);
        }

        $User_entity = ServicesDAL::user()->getUserByLogin($login);

        if(!is_null($User_entity))
        {
            if(password_verify($password, $User_entity->password)){
                $this->session->set('isLoggedIn', true);
                $this->session->set('userData', [
                    'id' => $User_entity->id,
                    'status' => $User_entity->user_status
                ]);

                return redirect()->to('/');
            }
        }

        //todo неправильный логин или пароль

    }

    public function logout(){
        $this->session->remove(['isLoggedIn', 'userData']);

        return redirect()->to('/Auth/login');
    }
}