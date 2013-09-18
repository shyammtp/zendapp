<?php
namespace Admin\Form\Settings\General;

use Zend\Form\Form as Zendform;

class Form extends Zendform
{
    protected $_options = array();
    
     
    
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('admin'); 
        
        $this->add(array(
            'name' => 'settings[general][default_country]',
            'type' => 'select',
            'options' => array(
                'value_options' => array(),
            ),
            'attributes' => array(
                'id' =>'selS0V',
                'tabindex' => '-1',
                'class' => 'chosen span6',
                'data-placeholder' => 'Your Default Country'
            )
        ));
        
        $this->add(array(
                'type' => 'Zend\Form\Element\MultiCheckbox',
                'name' => 'multi-checkbox',
                'options' => array(
                        'label' => 'What do you like ?',
                        'value_options' => array(
                                '0' => 'Apple',
                                '1' => 'Orange',
                                '2' => 'Lemon',
                        ),
                )
        ));
        
    }
}