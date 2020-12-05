<?php


namespace App\Controllers;


use App\Entities\ToPurchaser;
use Config\Services;
use Config\ServicesDAL;

class Request extends BaseController
{


    public function get(){
        $Products = ServicesDAL::userRequest()->getAll((int)Services::session()->userData['id'], 'id, product, count, FIO, telephone, comment');


        return $this->response->setStatusCode(200)->setJSON($Products);
    }

    public function getByUserId($userId){
        $Products = ServicesDAL::userRequest()->getAll($userId, 'id, product, count, FIO, telephone, comment');

        foreach ($Products as &$Product){
            $Product->product = ServicesDAL::product()->getNameByid($Product->product)->name;
        }
        unset($Product);

        return $this->response->setStatusCode(200)->setJSON($Products);
    }


    public function set(){
        ServicesDAL::userRequest()->delAll((int)Services::session()->userData['id']);

        $Products = $this->request->getJSON();

        foreach ($Products as &$Product) {
            $Product->user = (int)Services::session()->userData['id'];
        }
        unset($Product);


        ServicesDAL::userRequest()->insert($Products);

    }

    public function send(){
        $this->set();


        $ToPurchaser_entity = ServicesDAL::toPurchaser()->getByUserId((int)Services::session()->userData['id']);

        if(is_null($ToPurchaser_entity))
        {
            $ToPurchaser = ['user' => (int)Services::session()->userData['id']];
            ServicesDAL::toPurchaser()->insert($ToPurchaser);
        }

    }
}