<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'email',
        'phone_no',
        'password'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules   = [
        'name'  => 'required',
        'email' => 'required|valid_email|is_unique[employees.email]|min_length[6]',
        'phone_no' => 'required',
        'password'  => 'required' 
    ];
    protected $validationMessages      = [
        "name" => [
            "required" => "Name is required"
        ],
        "email" => [
            "required" => "Email required",
            "valid_email" => "Email address is not in format"
        ],
        "phone_no" => [
            "required" => "Phone Number is required"
        ],
        "password" => [
            "required" => "password is required"
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function apiKey()
    {
        $apiKey = 1234;
        return $apiKey;
    }
    public function userAll()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select('name, email, phone_no');
        $query = $builder->get()->getResult();
        return $query;
    }

    public function matchToken($token)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $query = $builder->where('password', $token)->get()->getResult();
        return $query;
    }
}
