<?php

/**
 * Description of FMSService
 *
 * @author Sam Falconer
 */

namespace FMS\Service;

use AppCore\Service\Entity\iServiceEntity;
use AppCore\Exception\ServiceException;
use AppCore\Service\EventHookType;

class FMSService extends \AppCore\Service\AbstractService implements \FMS\Service\iFMSService
{

    /**
     * FMS Service Entitiy
     * @var FMS\Service\FMSServiceEntity
     */
    private $serviceEntity;

    /**
     * FMS Service Default Constructor
     * @param iServiceEntity $serviceEntity
     */
    public function __construct(iServiceEntity $serviceEntity)
    {
        $this->serviceEntity = $serviceEntity;
    }

    /**
     * Submit Event to FMS System
     * 
     * @throws ServiceException 
     *
     * @return bool
     */
    public function submitEvent()
    {
        try
        {
            //pre-add event
            $this->getEventManager()->trigger(__FUNCTION__ . EventHookType::PRE,
                    $this, array('serviceEntity' => $this->serviceEntity));
                    
            $currentTimestamp = time();
            $apiTimestamp = $this->serviceEntity->getApiTimestamp();
            
            if (abs($currentTimestamp - $apiTimestamp) > 5) {
	            throw new ServiceException('Invalid Timestamp');
            }
            
            $requestArray = array(
			    'responsibleRepresentativeName' => $this->serviceEntity->getResponsibleRepresentativeName(),
			    'responsibleRepresentativeEmail' => $this->serviceEntity->getResponsibleRepresentativeEmail(),
			    'responsibleRepresentativePhone' => $this->serviceEntity->getResponsibleRepresentativePhone(),
			    'eventName' => $this->serviceEntity->getEventName(),
			    'eventDescription' => $this->serviceEntity->getEventDescription(),
			    'eventBuildingNumber' => $this->serviceEntity->getEventBuildingNumber(),
			    'eventRoomNumber' => $this->serviceEntity->getEventRoomNumber(),
			    'eventOtherLocation' => $this->serviceEntity->getEventOtherLocation(),
			    'reservationStartTime' => $this->serviceEntity->getReservationStartTime(),
			    'eventStartTime' => $this->serviceEntity->getEventStartTime(),
			    'eventEndTime' => $this->serviceEntity->getEventEndTime(),
			    'reservationEndTime' => $this->serviceEntity->getReservationEndTime(),
			    'apiTimestamp' => (string)$this->serviceEntity->getApiTimestamp(),
			    );
			    
			$requestArrayString = implode("+", $requestArray);
			$serverApiSignature = hash_hmac('sha256', $requestArrayString, 'ad22ef55-e1d7-44ed-bfd3-db9482308e15');
			
			$clientApiSignature = $this->serviceEntity->getApiSignature();
			
			if ($serverApiSignature != $clientApiSignature) {
				throw new ServiceException('Invalid Signature');
			}
			
			$fmsModel = new \FMS\Model\FMSModel;
			
			$wasSuccessful = $fmsModel->create($this->serviceEntity);

            //post-add event
            $this->getEventManager()->trigger(__FUNCTION__ . EventHookType::POST,
                    $this,
                    array('serviceEntity' => $this->serviceEntity));
                    
            return $wasSuccessful;

        } 
        catch(\Exception $e)
        {
           throw new ServiceException('Error Processing Submission', $e);
        }
    }

}

?>