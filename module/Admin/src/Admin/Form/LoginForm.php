<?php
namespace Admin\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('admin'); 
        
        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'attributes' => array(
                'id' =>'inputEmail1',
                'class' => 'm-wrap placeholder-no-fix',
                'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'attributes' => array(
                'id' =>'inputPassword1',
                'class' => 'm-wrap placeholder-no-fix',
                'placeholder' => 'Password'
            )
        ));
        
        
    }
}