<?php

/**
 * Description of BaseServiceEntity
 *
 * @author Nikesh Hajari
 */

namespace AppCore\Shared\Service\Entity;

use AppCore\Exception\ServiceEntityException;

class ShibbolethServiceEntity
{

    /**
     * Get University Id
     * 
     * @return string 
     */
    public function getUid()
    {
        return $this->getEnvironmentVariable('REDIRECT_uid');
    }
    
    /**
     * Get Display Name
     * 
     * @return string 
     */
    public function getDisplayName()
    {
        return $this->getEnvironmentVariable('REDIRECT_displayName');
    }

    /**
     * Get First Name
     * 
     * @return string 
     */
    public function getFirstName()
    {
        return $this->getEnvironmentVariable('REDIRECT_givenName');
    }

    /**
     * Get Last Name
     * 
     * @return string 
     */
    public function getLastName()
    {
        return $this->getEnvironmentVariable('REDIRECT_sn');
    }

    /**
     * Get E-mail Address
     * 
     * @return string 
     */
    public function getEmailAddress()
    {
        return $this->getEnvironmentVariable('REDIRECT_mail');
    }
    
    /**
     * Get Environment Variable
     * 
     * Returns environment variable if set else
     * exception
     * 
     * @param string $envVar
     * @return string
     * @throws ServiceEntityException 
     */
    private function getEnvironmentVariable($envVar)
    {
        if(getEnv($envVar) === false)
        {
            throw new ServiceEntityException('Missing Environment Variable - Check Shibboleth Configuration / PHP Environmental Variables');
        }
        
        return getenv($envVar);
    }
    
}

?>
