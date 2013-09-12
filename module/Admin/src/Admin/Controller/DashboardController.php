<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;
  
use Zend\View\Model\ViewModel;
use Core\Controller\AbstractController as CoreController;  

class DashboardController extends CoreController
{
    public function __construct()
    { 
        $this->layout('layout/dashboard/dashboard');
    }
    
    public function indexAction()
    {
        $mainview = new ViewModel();   
        return $mainview;
    } 
}
