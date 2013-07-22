<?php

/**
 * Description of MailTransportFactory
 *
 * @author Nikesh Hajari
 */

namespace AppCore\Shared\EMail\Transport;

class SendMailTransportFactory implements \Zend\ServiceManager\FactoryInterface
{
   
    /**
     * Create Service: Mail Transport Factory
     * 
     * @param \Zend\ServiceManager\ServiceLocaterInterface $serviceLocator
     * @return \Zend\Mail\Transport\Sendmail 
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $sm   = $serviceLocator->getServiceLocator();
        $mail = $sm->get('default.mail.transport');
        return $mail;;
    }
    
}

?>