<?php namespace App\Controllers;

use CodeIgniter\Config\Services;

class Home extends BaseController
{
	public function index()
	{

	    switch (Services::session()->userData['status']){
            case 1 : return view('user');
                break;

            case 2 : return view('admin');
            break;

            case 3 : return view('purchaser');
            break;

            default: return redirect()->to('/Auth/login');

            break;
        }
	}

}
