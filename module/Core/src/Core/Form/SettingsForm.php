<?php
namespace Core\Form;

use Zend\Form\Form;

class SettingsForm extends Form
{
    protected $_fields;
    
    protected $_country;
    
    public function __construct($name = null)
    {  
        parent::__construct($name);    
    }
    
    public function addFields($fields)
    {
        $this->_fields = $fields;
        return $this;
    }
    
    public function load()
    {
        if(!isset($this->_fields['groups']))
        {
            return $this;
        }
        foreach($this->_fields['groups'] as $group => $groupval)
        { 
            foreach($groupval['fields'] as $element)
            {
                $value = null;
                if(isset($element['path']))
                { 
                   $value = \Ething::getSiteConfig($element['path']);
                   if(strpos($value ,",")!== false)
                   {
                        $value = explode(",",\Ething::getSiteConfig($element['path']));
                   }
                }
                 
                 $default = array(
                        'name' => isset($element['name'])?$element['name']:"",
                        'type' => isset($element['type'])?$element['type']:'text'  
                    );
                $db = array('attributes' => array('value' => $value));
                $additionalParams = array();
                if(isset($element['attributes']))
                {
                    $finalattribute = array_merge($db['attributes'],$element['attributes']);
                     
                    $additionalParams += array('attributes' => $finalattribute);
                }
                
                if(isset($element['backendmodel']))
                {
                    if(class_exists($element['backendmodel']))
                        $additionalParams += array('type' => $element['backendmodel']);
                } 
                 
                switch($element['type'])
                {
                    case "radio":
                    case "select": 
                        $additionalParams += array('options' => array('label' => $element['options']['label'],
                                                'value_options' => isset($element['options']['sourcemodel'])?
                                                call_user_func(array(new $element['options']['sourcemodel'],(isset($element['options']['sourcemodel_method'])?$element['options']['sourcemodel_method']:"toOptionArray")))
                                                :$this->formOptionvalues(isset($element['options']['values'])?$element['options']['values']:array())));
                        break;
                }
                 
                if(isset($element['name']))
                { 
                    $finalset = array_merge($default,$additionalParams);
                    $this->add($finalset);
                }
            }
        }    
        return $this;
    }
    
    public function addCountry($country)
    {
        $this->_country = $country;
        return $this;
    }
    
    public function formOptionvalues($options)
    {
        $values = array();
        foreach($options as $key =>  $option)
        {
            $values[$option['value']]= isset($option['label'])?$option['label']:$key;
        }
        return $values;
    }
}