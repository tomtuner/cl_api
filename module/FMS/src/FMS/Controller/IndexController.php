<?php

namespace FMS\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use AppCore\Exception\ControllerException;

class IndexController extends AbstractActionController
{

    /**
     * Create Action
     * 
     * Saves event info into the FMS project tracker system
     */
    public function createAction()
    {
    
    try
    {
        $sE = new \FMS\Service\Entity\FMSServiceEntity($this->getRequest()->getPost());

        $s = new \FMS\Service\FMSService($sE);
        
        $wasSuccessful = $s->submitEvent();
        
        if ($wasSuccessful) {
	        $result = new JsonModel(array(
    			'success'=>true,
    		));
        } else {
	        $result = new JsonModel(array(
    			'success'=>false,
    		));
        }
 
        return $result;
        
    } catch(\Exception $e)
    {
        throw new ControllerException('Error Submitting FMS Request', $e);
    }
}
    
    /**
     * Index Action
     * 
     * Redirects to home page
     */
    public function indexAction()
    {
    	return $this->redirect()->toUrl('http://campuslife.rit.edu/');
    	
    }
    
}

?>