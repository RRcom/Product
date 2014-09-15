<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Exception;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        return $view;
    }

    public function onDispatch(MvcEvent $e)
    {
        $this->layout('product/layout/default');
        return parent::onDispatch($e);
    }
}
