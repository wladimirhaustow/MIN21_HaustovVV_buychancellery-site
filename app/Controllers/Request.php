<?php


namespace App\Controllers;


use App\Entities\ToPurchaser;
use Config\Services;
use Config\ServicesDAL;

class Request extends BaseController
{


    public function get(){

        $UserRequest = [];

        $AllRequest = ServicesDAL::userRequest()->getAll();

        if(!empty($AllRequest)){
            foreach ($AllRequest as $Request){
                $User_entity = ServicesDAL::user()->getUserById($Request->user);
                $UserRequest[$Request->id] = $User_entity->login.' ['.$Request->created_at->toDateTimeString().']';

            }

        }

        return $this->response->setStatusCode(200)->setJSON($UserRequest);
    }

    public function getById($userId){
        $UserRequest = ServicesDAL::userRequest()->getById($userId);

        $UserRequests = unserialize($UserRequest->request);

        foreach ($UserRequests as &$UserRequest){
            $UserRequest->product = ServicesDAL::product()->getNameById($UserRequest->product)->name;
        }
        unset($UserRequest);

        return $this->response->setStatusCode(200)->setJSON($UserRequests);
    }


    public function send(){
        $Products = $this->request->getJSON();

        $ProductsSerial = serialize($Products);

        $Request = new \App\Entities\Request();
        $Request->request = $ProductsSerial;
        $Request->user = (int)Services::session()->userData['id'];

        ServicesDAL::userRequest()->insert($Request);

    }
}