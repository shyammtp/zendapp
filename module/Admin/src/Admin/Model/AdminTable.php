<?php
namespace Admin\Model;

// Add these import statements
use Zend\Db\TableGateway\TableGateway; 

class AdminTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function checkLogin($username, $password)
    {
        $rowset = $this->tableGateway->select(array('username' => $username,'password' => md5($password)));
        $row = $rowset->current();        
        if (!$row) {
            throw new \Exception("Could not find row record");
        }
        return row;
    }

    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('user_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
 

    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(array('user_id' => $id));
    }
}