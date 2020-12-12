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
        $Products = $this->request->getJSON();

        $Ids = ServicesDAL::product()->getAllId();

        $Products = json_decode(json_encode($Products), true);


        foreach ($Products as $product){
            if (!in_array($product['id'], $Ids))
                unset($product['id']);

            ServicesDAL::product()->save($product);

            if (isset($product['id']) && in_array($product['id'], $Ids))
                unset($Ids[array_search($product['id'], $Ids)]);
        }

        if(!empty($Ids))
            ServicesDAL::product()->delete($Ids);

        echo '{"status":"ok"}';

    }
}