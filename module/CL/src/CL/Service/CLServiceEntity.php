<?php

/**
 * Description of CLServiceEntity
 *
 * @author Thomas DeMeo
 */

namespace CL\Service\Entity;

class CLServiceEntity extends \AppCore\Service\Entity\AbstractServiceEntity
{   
    /**
     * Get Responsible Representative Name
     * 
     * @return string 
     */
    public function getStartDate()
    {
        return $this->getProperty('startdate');
    }
	
    /**
     * Get Responsible Representative Name
     * 
     * @return string 
     */
    public function getEndDate()
    {
        return $this->getProperty('enddate');
    }
}

?>