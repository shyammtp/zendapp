<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller\Settings;
  
use Zend\View\Model\ViewModel;
use Core\Controller\AbstractController as CoreController;  

class GeneralController extends CoreController
{
    private $workingDays = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
    public function indexAction()
    { 
        $countrys = $this->getCountryTable()->fetchAll();
        $bind = array('countrys' => $countrys,
                    'workingdays' => $this->workingDays,
                    'locale' => \Site::getLocale(),
                    'timezone' => \Site::getTimezones());
        $view = new ViewModel($bind);
         
        $view->setTemplate('admin/settings/general/index');
        return $view;
    }
    
    public function webAction()
    { 
        $view = new ViewModel();
        return $view;
    }
     
     
    
}
