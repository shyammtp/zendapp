<?php
namespace Admin\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as OriginalFormElementErrors;

class FormElementErrors extends OriginalFormElementErrors  
{
    protected $messageCloseString     = '</label>';
    protected $messageOpenFormat      = '<label class="help-inline help-small no-left-padding">';
    protected $messageSeparatorString = '';
}