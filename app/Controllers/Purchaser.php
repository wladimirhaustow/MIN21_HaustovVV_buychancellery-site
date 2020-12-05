<?php


namespace App\Controllers;


use Config\ServicesDAL;

class Purchaser extends BaseController
{
    public function get()
    {
        $ToPurchaser = [];

        $AllToPurchaser = ServicesDAL::toPurchaser()->getAll();

        if(!empty($AllToPurchaser)){
            foreach ($AllToPurchaser as $purchaser){
                $User_entity = ServicesDAL::user()->getUserById($purchaser->id);
                $ToPurchaser[$User_entity->id] = $User_entity->login;

            }

        }

        return $this->response->setStatusCode(200)->setJSON($ToPurchaser);
    }
}