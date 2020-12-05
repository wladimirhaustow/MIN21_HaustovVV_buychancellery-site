<?php


namespace App\Controllers;


use Config\ServicesDAL;

class Product extends BaseController
{
    public function get(){
        $Products = ServicesDAL::product()->getAll('id, name');

        return $this->response->setStatusCode(200)->setJSON($Products);
    }

    public function set(){
        ServicesDAL::product()->delAll();

        $Products = $this->request->getJSON();

        ServicesDAL::product()->insert($Products);

        echo '{"status":"ok"}';

    }
}