<?php
namespace Core\Model;

// Add these import statements
use Zend\Db\TableGateway\TableGateway; 

class Country
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
 
}