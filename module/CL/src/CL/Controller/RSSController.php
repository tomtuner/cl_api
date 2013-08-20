<?php

namespace CL\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use AppCore\Exception\ControllerException;

class RSSController extends AbstractActionController
{
    
    /**
     * Index Action
     * 
     * Redirects to home page
     */
    public function indexAction()
    {
	try {
    	// return $this->redirect()->toUrl('http://campuslife.rit.edu/');
    	// print_r($this->getRequest()->getQuery());
		
        $sE = new \CL\Service\Entity\CLServiceEntity($this->getRequest()->getQuery());

        $s = new \CL\Service\CLService($sE);
         
        $wasSuccessful = $s->queryEventsAPI();
		// print_r("Was Successful :");
		
		// print_r($wasSuccessful);
        // $wasSuccessful = true;
        if (true) {
			// header("Content-Type: text/plain");
			
			$xml = $s->parseEventsIntoRSS($wasSuccessful);
			print_r($xml);
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
    
}

?>