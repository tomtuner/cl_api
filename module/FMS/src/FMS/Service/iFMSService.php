<?php

/**
 * Description of iFMSService
 *
 * @author Sam Falconer
 */

namespace FMS\Service;

interface iFMSService
{

    /**
     * Submit Event to FMS System
     *
     * @throws ServiceException 
     */
    public function submitEvent();
}

?>