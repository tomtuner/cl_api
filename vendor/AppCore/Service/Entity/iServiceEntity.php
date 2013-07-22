<?php

/**
 * Description of iServiceEntity
 *
 * @author Nikesh Hajari
 */

namespace AppCore\Service\Entity;

interface iServiceEntity
{
    
    /**
     * Class Default Constructor
     * 
     * In the controller the following can be passed in: 
     * 
     * $request->getRequest()->getPost()
     * $request->getRequest()->getQuery()
     * 
     * @param \Zend\Stdlib\Parameters $requestParams ($fieldName => $fieldValue)
     */
    public function __construct(\Zend\Stdlib\Parameters $requestParams);
    
}

?>
