<?php namespace App\Filters;


use CodeIgniter\Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{

    /**
     * @inheritDoc
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $type = '';
        if(isset($arguments[0]))
            $type = $arguments[0];

        $status_auth = Services::session()->isLoggedIn;

        if($status_auth && Services::session()->userData['status'] != 2 && $type == 'admin')
            return redirect()->to('/Auth/login');

        if($status_auth && Services::session()->userData['status'] != 3 && $type == 'purchaser')
            return redirect()->to('/Auth/login');

        if($status_auth && $type == 'noauth')
            return redirect('/');


        if(!$status_auth && $type != 'noauth')
            return redirect()->to('/Auth/login');


    }

    /**
     * @inheritDoc
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}