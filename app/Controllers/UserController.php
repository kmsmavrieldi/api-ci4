<?php

namespace App\Controllers;

// use App\Controllers\BaseController;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $userM;

    public function __construct()
    {
        $userM = new UserModel;
        $this->userM = $userM;
        return $this->userM;
    }

    public function registerForm()
    {  
      return view('user/register');  
    }

    public function register()
    {
       $data = [
           'name'       => $this->request->getVar('name'), 
           'email'      => $this->request->getVar('email'), 
           'phone_no'   => $this->request->getVar('phone_no'), 
           'password'   => password_hash($this->request->getVar('password'),PASSWORD_DEFAULT),
           'limit'      => 100 
       ];
       
    }

    public function loginForm()
    {
        
    }

    public function login()
    {
        
    }

}
     