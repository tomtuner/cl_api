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
		$startdate = strtotime("-2 day") * 1000;
		$enddate = strtotime("+30 day") * 1000;
		// print_r($startdate);
		// print_r("\n");
		// print_r($enddate);
        $wasSuccessful = $s->queryEventsAPI($startdate, $enddate);
		// print_r("Was Successful :");
		
		 // print_r($wasSuccessful);
        // $wasSuccessful = true;
        if ($wasSuccessful) {
			// header("Content-Type: text/plain");
			
			$xml = $s->parseEventsIntoRSS($wasSuccessful);
			
			$response = $this->getResponse();
			$response->setStatusCode(200);
			$response->setContent($xml);
			
			$response->getHeaders()->addHeaders(array('Content-type' => 'text/xml'));
			return $response;
	        // $result = new JsonModel(array(
    			// 'success'=>true,
    		// ));
        }else {
			$result = new JsonModel(array(
    			'success'=>true,
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