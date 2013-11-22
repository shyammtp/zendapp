<?php
namespace Core\Model\System\Config\Source;
 
use Core\Model\Functions as coreFunction;

class Country extends coreFunction
{
    public function toOptionArray()
    {
        $object = new \Core\Model\Country($this->getTableGatewayInstance('country_region')); 
        return $object->toOptionArray();
    }
}