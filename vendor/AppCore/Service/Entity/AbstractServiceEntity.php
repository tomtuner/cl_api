<?php

/**
 * Description of AbstractServiceEntity
 *
 * @author Nikesh Hajari
 */

namespace AppCore\Service\Entity;

abstract class AbstractServiceEntity implements \AppCore\Service\Entity\iServiceEntity
{

    /**
     * HTTP Request Params
     * 
     * @var \Zend\Http\Request 
     */
    protected $requestParams;

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
    public function __construct(\Zend\Stdlib\Parameters $requestParams)
    {
        $this->requestParams = $requestParams;
    }

    /**
     * Does Property Exist
     * 
     * @param string $offset
     * @return null 
     */
    public function doesPropertyExist($offset)
    {
        return isset($this->requestParams[$offset]);
    }

    /**
     * Get Property
     * 
     * @param string $offset
     * @return string|null 
     */
    public function getProperty($offset)
    {
        if($this->doesPropertyExist($offset))
    	{
    		if(is_string($this->requestParams[$offset]))
    		{
	    		return stripslashes($this->requestParams[$offset]);
    		}
    		
    		return $this->requestParams[$offset];
    	}
    	
    	return null;
    }
    
    /**
     * Get Shibboleth Service Entity
     * 
     * @return \AppCore\Shared\Service\Entity\ShibbolethServiceEntity Shibboleth Service Entity
     */
    public function getShibbolethServiceEntity()
    {
        return new \AppCore\Shared\Service\Entity\ShibbolethServiceEntity();
    }

}

?>
