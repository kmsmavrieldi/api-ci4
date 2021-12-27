<?php

namespace App\Controllers;

// use App\Controllers\BaseController;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
// Use Exception;
// use \Firebase\JWT\JWT;

class UserAPI extends ResourceController
{
    protected $userM;

    public function __construct()
    {
        $userM = new UserModel;
        $this->userM = $userM;
        return $this->userM;
    }

    public function register()
    {
        

        if (!$this->validate($this->userM->validationRules, $this->userM->validationMessages)) 
        {

            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {
            $data = [
                "name" => $this->request->getVar("name"),
                "email" => $this->request->getVar("email"),
                "phone_no" => $this->request->getVar("phone_no"),
                "password" => password_hash($this->request->getVar("password"), PASSWORD_DEFAULT),
            ];
            
            if ($this->userM->insert($data)) {

                $response = [
                    'status' => 200,
                    "error" => false,
                    'messages' => 'Successfully, User has been registered',
                    'data' => []
                ];
            } else {

                $response = [
                    'status' => 500,
                    "error" => true,
                    'messages' => 'Failed to create User',
                    'data' => []
                ];
            }
        }

        return $this->respondCreated($response);
    }
    private function getKey()
    {
        return 'my_application_secret';
    }


    public function login()
    {     
            $userData = $this->userM->where('email', $this->request->getVar('email'))->first();
            
            if(!empty($userData)){
                if(password_verify($this->request->getVar('password'), $userData['password'])){

                    // $token = password_hash(1234, PASSWORD_DEFAULT); 
                    $token = $userData['password']; //from kms methods
                    $response = [
                        'status' => 200,
                        'error' => false,
                        'messages' => 'User logged In successfully',
                        'data' => [
                            'token' => $token
                        ]
                    ];
                    return $this->respondCreated($response);
                } else {

                    $response = [
                        'status' => 500,
                        'error' => true,
                        'messages' => 'Incorrect details',
                        'data' => []
                    ];
                    return $this->respondCreated($response);
                }

            } else {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'messages' => 'User not found',
                    'data' => []
                ];
                return $this->respondCreated($response);
                
            }
         
    }
    public function details()
    {
        $UserAll = $this->userM->UserAll();

        // $key = $this->getKey();
        

        $response = [
            'status'    => 200,
            'error'     => false,
            'messages'  =>'User details',
            'data'      => $UserAll 
        
        ];
        return $this->respondCreated($response);

    }

    
}

