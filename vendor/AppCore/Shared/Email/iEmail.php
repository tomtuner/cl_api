<?php

/**
 * Description of iEmail
 *
 * @author Nikesh Hajari
 */

namespace AppCore\Shared\Email;

use AppCore\Service\Entity\iServiceEntity;

interface iEmail
{

    /**
     * Class Default Constructor
     * 
     * @param AppCore\Service\Entity\iServiceEntity
     */
    public function __construct(iServiceEntity $serviceEntity);

    /**
     * Get E-mail Message
     * 
     * @return Zend\Mail 
     */
    public function getMessage();
}

?>
