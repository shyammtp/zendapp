<?php
namespace Admin\Model;

// Add these import statements
use Zend\Db\TableGateway\TableGateway; 

class Admin
{
    public $userid;
    public $username;
    public $password; 

    public function exchangeArray($data)
    {
        $this->userid     = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->password  = (isset($data['password'])) ? $data['password'] : null;
    }
    
     
}