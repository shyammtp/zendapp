<?php
namespace Admin\Model;

// Add these import statements 
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Login  implements InputFilterAwareInterface
{
    public $username;
    public $password; 
    protected $inputFilter;                       // <-- Add this variable 
    
    private $_dbAdapter;

    public function exchangeArray($data)
    {
        $this->userid     = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->password  = (isset($data['password'])) ? $data['password'] : null; 
    }

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    } 

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter(); 

            $inputFilter->add(array(
                'name'     => 'username',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 100,
                            'message' => '%value% Test', 
                        ),              
                    ),
                    /*array(
                        'name'    => 'Db\RecordExists',
                        'options' => array(
                            'table' => 'admin_user',
                            'field' => 'username',
                            'adapter' => $this->getDbAdapter(),
                            'message' => '%value% is not found in our record',
                        ),
                    ),*/
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                   /* array(
                        'name'    => 'Db\RecordExists',
                        'options' => array(
                            'table' => 'admin_user',
                            'field' => 'password',
                            'adapter' => $this->getDbAdapter(),
                        ),
                    ),*/
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    
    public function checkUserExists()
    {
        return $this->countRecord();
        return false;
    }
    
    public function setDbAdapter($dbAdapter) { 
        $this->_dbAdapter = $dbAdapter; 
    }

    public function getDbAdapter() {  
        return $this->_dbAdapter;
   }
}