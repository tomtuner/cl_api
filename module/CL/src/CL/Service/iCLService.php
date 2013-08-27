<?php

/**
 * Description of iCLService
 *
 * @author Thomas DeMeo
 */

namespace CL\Service;

interface iCLService
{

    /**
     * Submit Event to CL System
     *
     * @throws ServiceException 
     */
    public function queryEventsAPI($startdate, $enddate, $type);
}

?>