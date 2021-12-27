<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\InventoryModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InventoryAPI extends ResourceController
{
    protected $userM;
    protected $inventoryM;
    protected $apiKey;

    public function __construct()
    {
        $userM = new UserModel();
        $inventoryM = new InventoryModel(); 

        $this->userM = $userM;
        $this->inventoryM = $inventoryM;
        $this->apiKey = $userM->apiKey();
    }
    public function authorization($data, $method = NULL, $id = NULL)
    {
        if($method == 'create')
        {
            $this->inventoryM->insert($data);
        }
        if($method == 'update')
        {
            $this->inventoryM->update($id, $data);
        }
        if($method == 'delete')
        {
            $this->inventoryM->delete($id);
        }
        $response = [
            'status'    => 200,
            'error'     => false,
            'messages'  =>'Successfull',
            'data'      => $data 
        
        ];
        return $this->respondCreated($response);                     
    }

    public function index()
    {   
        $data = $this->inventoryM->findAll();
        return $this->authorization($data);
    
    }
    public function show($id = NULL)
    {
        $data = $this->inventoryM->show($id);
        if($data):
        return $this->authorization($data);   
        else:
            $response = [
                'status'    =>404,
                'error'     =>true,
                'messages'  =>'Data Not Found',
                'data'      =>[]
            ];
        return $this->respondCreated($response);
        endif;    
    }

    public function create()
    {
        $method = 'create';
        $data ='';
        
        if ($this->validate($this->inventoryM->validationRules)):
        $insert = $this->request->getRawInput();
        $data = [
            'name'  => $insert["name"],
            'price' => $insert["price"],
            'stock' => $insert["stock"],
            'msg'   => 'Successfully created new data'
        ];  
        endif;       
        
        return $this->authorization($data,$method);
    }

    public function update($id = NULL)
    {   
        $method = 'update';
        $data ='';
        
        if ($this->validate($this->inventoryM->validationRules)):
        $edit = $this->request->getRawInput();
        $data = [
            'name'  => $edit["name"],
            'price' => $edit["price"],
            'stock' => $edit["stock"],
            'msg'   => 'Successfully updated data'
        ];  
        endif;       
        
        return $this->authorization($data,$method,$id);
    }

    public function delete($id = NULL)
    {
        $method = 'delete';
        $data = [
            'msg'   => 'Successfully deleted id '.$id
        ];

        return $this->authorization($data,$method,$id);
    }
}
